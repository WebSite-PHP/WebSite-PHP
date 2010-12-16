<?php
class Tabs extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $id = "";
	private $array_tabs_name = array();
	private $array_tabs_content = array();
	private $array_tabs_select_js = array();
	
	private $height = "";
	private $min_height = "";
	private $cache = false;
	/**#@-*/
	
	function __construct($id='') {
		parent::__construct();
		
		if (!isset($id) || $id == "") {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, 8, __FILE__, __LINE__);
		}
		$this->id = $id;
	}
	
	public function addTab($tab_name, $content_or_url_object, $on_select_js="") {
		if (gettype($content_or_url_object) == "object" && get_class($content_or_url_object) == "DateTime") {
			throw new NewException(get_class($this)."->addTab() error: Please format your DateTime object (\$my_date->format(\"Y-m-d H:i:s\"))", 0, 8, __FILE__, __LINE__);
		}
		$this->array_tabs_name[] = $tab_name;
		$this->array_tabs_content[] = $content_or_url_object;
		$this->array_tabs_select_js[] = $on_select_js;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setHeight($height) {
		$this->height = $height;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setMinHeight($min_height) {
		$this->min_height = $min_height;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function activateCache() {
		$this->cache = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}

	public function getId() {
		return $this->id;
	}
		
	public function render($ajax_render=false) {
		$is_ajax_content = false;
		
		$html = "";
		$html .= "<div id=\"".$this->getId()."\"";
		if ($this->min_height != "" || $this->height != "") {
			$html .= " style=\"";
			if ($this->min_height != "") {
				$html .= "min-height:".$this->min_height."px;height: expression(this.scrollHeight < ".$this->min_height." ? '".$this->min_height."px' : 'auto');";
			}
			if ($this->height != "") {
				$html .= "height:".$this->height."px;";
			}
			$html .= "\"";
		}
		$html .= ">\n";
		$html .= "	<ul>\n";
		for ($i=0; $i < sizeof($this->array_tabs_name); $i++) {
			$html .= "		<li><a href=\"";
			if (get_class($this->array_tabs_content[$i]) != "Url") {
				$html .= "#".$this->getId()."_".formalize_to_variable($this->array_tabs_name[$i]);
			} else {
				$is_ajax_content = true;
				$tmp_url = $this->array_tabs_content[$i]->render($ajax_render);
				$tmp_url = str_replace(".php", ".call", $tmp_url);
				$html .= $tmp_url;
				if (find($tmp_url, "?", 0, 0) > 0) {
					$html .= "&tabs_object_id=".$this->getId();
				} else {
					$html .= "?tabs_object_id=".$this->getId();
				}
			}
			$html .= "\"><span>".$this->array_tabs_name[$i]."</span></a></li>\n";
		}
		$html .= "	</ul>\n";
		for ($i=0; $i < sizeof($this->array_tabs_name); $i++) {
			if (get_class($this->array_tabs_content[$i]) != "Url") {
				if (gettype($this->array_tabs_content[$i]) == "object" && method_exists($this->array_tabs_content[$i], "render")) {
					$html_content = $this->array_tabs_content[$i]->render($ajax_render);
				} else {
					$html_content = $this->array_tabs_content[$i];
				}
				$html .= "	<div id=\"".$this->getId()."_".formalize_to_variable($this->array_tabs_name[$i])."\" style=\"padding:5px;\">\n";
				$html .= $html_content;
				$html .= "	</div>\n";
			}
		}
		$html .= "</div>\n";
		
		$html .= $this->getJavascriptTagOpen();
		$html .= "	$('#".$this->getId()."').tabs({";
		if ($this->cache) {
			$html .= "		cache: true,\n";
		}
		$html .= "		select: function(event, ui) {\n";
		for ($i=0; $i < sizeof($this->array_tabs_select_js); $i++) {
			if ($this->array_tabs_select_js[$i] != "" || $this->height != "") {
				$html .= "			if (ui.index == ".$i.") {\n";
				if ($this->array_tabs_select_js[$i] != "") {
					$html .= "				".$this->array_tabs_select_js[$i]."\n";
				}
				if ($this->height != "") {
					$html .= "				$('#' + ui.panel.id).attr('style', 'overflow:auto;height:' + (parseInt($('#".$this->getId()."').css('height').replace('px', ''))-($('#".$this->getId()."').find('.ui-tabs-nav').height()+40)) + 'px;');\n";
				}
				$html .= "				return true;\n";
				$html .= "			}\n";
			}
		} 
		$html .= "		},\n";
		if ($is_ajax_content) {
			$html .= "		ajaxOptions: {\n";
			if ($this->cache) {
				$html .= "			cache: true,\n";
			} 
			$html .= "			success: function() {}\n";
			$html .= "		}\n";
		}
		$html .= "});\n";
		$html .= $this->getJavascriptTagClose();
		
		$this->object_change = false;
		return $html;
	}
}
?>
