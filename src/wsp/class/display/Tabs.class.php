<?php
/**
 * PHP file wsp\class\display\Tabs.class.php
 * @package display
 */
/**
 * Class Tabs
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2017 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 11/10/2017
 * @version     1.2.15
 * @access      public
 * @since       1.0.17
 */

class Tabs extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $id = "";
	private $array_tabs_name = array();
	private $array_tabs_content = array();
	private $array_tabs_select_js = array();
	private $array_tabs_disabled = array();
	private $array_tabs_loading_content = array();
	
	private $height = "";
	private $min_height = "";
	private $cache = false;
	private $ajax_loading = true;
	private $selected_index = -1;
	private $onshow = "";
	private $tagH = "";
	private $add_hash_url = false;
	/**#@-*/
	
	/**
	 * Constructor Tabs
	 * @param string $id 
	 */
	function __construct($id='') {
		parent::__construct();
		
		if (!isset($id) || $id == "") {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, getDebugBacktrace(1));
		}
		$this->id = $id;
	}
	
	/**
	 * Method addTab
	 * @access public
	 * @param mixed $tab_name 
	 * @param object $content_or_url_object 
	 * @param string $on_select_js 
	 * @param boolean $disabled [default value: false]
	 * @param string $loading_content 
	 * @return Tabs
	 * @since 1.0.35
	 */
	public function addTab($tab_name, $content_or_url_object, $on_select_js="", $disabled=false, $loading_content = "") {
		if (gettype($content_or_url_object) == "object" && get_class($content_or_url_object) == "DateTime") {
			throw new NewException(get_class($this)."->addTab() error: Please format your DateTime object (\$my_date->format(\"Y-m-d H:i:s\"))", 0, getDebugBacktrace(1));
		}
		$this->array_tabs_name[] = $tab_name;
		$this->array_tabs_content[] = $content_or_url_object;
		$this->array_tabs_select_js[] = $on_select_js;
		$this->array_tabs_disabled[] = $disabled;
		$this->array_tabs_loading_content[] = $loading_content;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method onShowJs
	 * @access public
	 * @param mixed $js_function 
	 * @return Tabs
	 * @since 1.0.98
	 */
	public function onShowJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onShowJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		$this->onshow = trim($js_function);
		return $this;
	}
	
	/**
	 * Method setTitleTagH1
	 * @access public
	 * @return Tabs
	 * @since 1.0.98
	 */
	public function setTitleTagH1() {
		$this->tagH = "h1";
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	
	/**
	 * Method setTitleTagH2
	 * @access public
	 * @return Tabs
	 * @since 1.0.98
	 */
	public function setTitleTagH2() {
		$this->tagH = "h2";
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setTitleTagH
	 * @access public
	 * @param mixed $value 
	 * @return Tabs
	 * @since 1.0.98
	 */
	public function setTitleTagH($value) {
		$this->tagH = "h".$value;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setHeight
	 * @access public
	 * @param integer $height 
	 * @return Tabs
	 * @since 1.0.35
	 */
	public function setHeight($height) {
		$this->height = $height;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setMinHeight
	 * @access public
	 * @param mixed $min_height 
	 * @return Tabs
	 * @since 1.0.35
	 */
	public function setMinHeight($min_height) {
		$this->min_height = $min_height;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setWidth
	 * @access public
	 * @param integer $width 
	 * @return Tabs
	 * @since 1.1.2
	 */
	public function setWidth($width) {
		$this->width = $width;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method activateCache
	 * @access public
	 * @return Tabs
	 * @since 1.0.35
	 */
	public function activateCache() {
		$this->cache = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method disableAjaxLoad
	 * @access public
	 * @return Tabs
	 * @since 1.0.97
	 */
	public function disableAjaxLoad() {
		$this->ajax_loading = false;
		return $this;
	}
	
	/**
	 * Method selectedIndex
	 * @access public
	 * @param mixed $index 
	 * @return Tabs
	 * @since 1.0.97
	 */
	public function selectedIndex($index) {
		$this->selected_index = $index;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method activateAddHashToUrl
	 * @access public
	 * @return Tabs
	 * @since 1.2.15
	 */
	public function activateAddHashToUrl() {
		$this->add_hash_url = true;
		return $this;
	}

	/**
	 * Method getId
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getId() {
		return $this->id;
	}
		
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Tabs
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$is_ajax_content = false;
		
		$html = "";
		$html .= "<div id=\"".$this->getId()."\"";
		if ($this->min_height != "" || $this->height != "" || $this->width != "") {
			$html .= " style=\"";
			if ($this->min_height != "") {
				$html .= "min-height:".$this->min_height."px;height: expression(this.scrollHeight < ".$this->min_height." ? '".$this->min_height."px' : 'auto');";
			}
			if ($this->height != "") {
				$html .= "height:".$this->height."px;";
			}
			if ($this->width != "") {
				$html .= "width:".$this->width."px;";
			}
			$html .= "\"";
		}
		$html .= ">\n";
		$html .= "	<ul>\n";
		for ($i=0; $i < sizeof($this->array_tabs_name); $i++) {
			if (gettype($this->array_tabs_name[$i]) == "object" && method_exists($this->array_tabs_name[$i], "render")) {
				$tab_name_var = strip_tags($this->array_tabs_name[$i]->render());
			} else {
				$tab_name_var = $this->array_tabs_name[$i];
			}
			$html .= "		<li>";
			if ($this->tagH != "") {
				$html .= "<".$this->tagH." style=\"font-weight:inherit;\">";
			}
			$html .= "<a href=\"";
			if (get_class($this->array_tabs_content[$i]) != "Url") {
				$html .= "#".$this->getId()."_".formalize_to_variable($tab_name_var);
			} else {
				$tmp_url = $this->array_tabs_content[$i]->render($ajax_render);
				if (!$this->ajax_loading) {
					$html .= $tmp_url;
				} else {
					$is_ajax_content = true;
					$tmp_url = str_replace(".php", ".call", $tmp_url);
					$html .= $tmp_url;
					if (find($tmp_url, "?", 0, 0) > 0) {
						$html .= "&tabs_object_id=".$this->getId();
					} else {
						$html .= "?tabs_object_id=".$this->getId();
					}
				}
			}
			$html .= "\"";
			if ($this->add_hash_url == true) {
				$html .= " id=\"".$this->getId()."_".strtolower(url_rewrite_format($tab_name_var))."\"";
			}
			$html .= "><span>";
			if (gettype($this->array_tabs_name[$i]) == "object" && method_exists($this->array_tabs_name[$i], "render")) {
				$html .= $this->array_tabs_name[$i]->render();
			} else {
				$html .= $this->array_tabs_name[$i];
			}
			$html .= "</span></a>";
			if ($this->tagH != "") {
				$html .= "</".$this->tagH.">";
			}
			$html .= "</li>\n";
		}
		$html .= "	</ul>\n";
		for ($i=0; $i < sizeof($this->array_tabs_name); $i++) {
			if (get_class($this->array_tabs_content[$i]) != "Url") {
				if (gettype($this->array_tabs_content[$i]) == "object" && method_exists($this->array_tabs_content[$i], "render")) {
					$html_content = $this->array_tabs_content[$i]->render($ajax_render);
				} else {
					$html_content = $this->array_tabs_content[$i];
				}
				if (gettype($this->array_tabs_name[$i]) == "object" && method_exists($this->array_tabs_name[$i], "render")) {
					$tab_name_var = strip_tags($this->array_tabs_name[$i]->render());
				} else {
					$tab_name_var = $this->array_tabs_name[$i];
				}
				$html .= "	<div id=\"".$this->getId()."_".formalize_to_variable($tab_name_var)."\" style=\"padding:5px;";
				if ($this->width != "") {
					$html .= "width:".($this->width-10)."px;";
				}
				$html .= "\">\n";
				$html .= $html_content;
				$html .= "	</div>\n";
			}
		}
		$html .= "</div>\n";
		
		$html .= $this->getJavascriptTagOpen();
		$html .= "$(document).ready(function() {\n";
		$html .= "	$('#".$this->getId()."').tabs({";
		if ($this->onshow != "") {
			$html .= "		show: function(event, ui) { ".$this->onshow." }, \n";
		}
		if ($this->add_hash_url == true) {
			$html .= "		create: function(event, ui) {
					if (!location.hash) {
						$('#".$this->getId()."').tabs('option', 'active', 0); // activate first tab by default
						return;
					}
					$('#".$this->getId()." > ul > li > a').each(function (index, a) {
						if ('#'+$(a).attr('id') == window.location.hash) {
							$('#".$this->getId()."').tabs('option', 'selected', index);
						}
					});
			}, \n";
		}
		$html .= "		select: function(event, ui) {\n";
		if ($this->add_hash_url == true) {
			$html .= "			window.location.hash = ui.tab.id;\n";
		}
		for ($i=0; $i < sizeof($this->array_tabs_select_js); $i++) {
			$html .= "			if (ui.index == ".$i.") {\n";
			$html .= "				if ($(ui.panel).html() == '') { $(ui.panel).append(\"";
			if ($this->array_tabs_loading_content[$i] != "") {
				if (gettype($this->array_tabs_loading_content[$i]) == "object" && method_exists($this->array_tabs_loading_content[$i], "render")) {
					$html .= str_replace("\"", "'", str_replace("\n", "", str_replace("\r", "", $this->array_tabs_loading_content[$i]->render())));
				} else {
					$html .= str_replace("\"", "'", str_replace("\n", "", str_replace("\r", "", $this->array_tabs_loading_content[$i])));
				}
			} else {
				$html .= "<div align='center' style='#position:absolute;#top:50%;display:table-cell;vertical-align:middle;'><img src='".$this->getPage()->getCDNServerURL()."wsp/img/loading.gif' width='32' height='32' /></div>";
			}
			$html .= "\"); }\n";
			if ($this->array_tabs_select_js[$i] != "") {
				$html .= "				".$this->array_tabs_select_js[$i]."\n";
			}
			if ($this->height != "") {
				$html .= "				$('#' + ui.panel.id).attr('style', 'overflow:auto;height:' + (parseInt($('#".$this->getId()."').css('height').replace('px', ''))-($('#".$this->getId()."').find('.ui-tabs-nav').height()+40)) + 'px;');\n";
			}
			if (!$this->ajax_loading) {
				$html .= "				var url = $.data(ui.tab, 'load.tabs');\n";
				$html .= "				if (url) {\n";
				$html .= "					location.href = url;\n";
				$html .= "					return false;\n";
				$html .= "				}\n";
			}
			$html .= "				return true;\n";
			$html .= "			}\n";
		} 
		$html .= "			return false;\n";
		$html .= "		}\n";
		if ($this->cache) {
			$html .= "		, cache: true\n";
		}
		if ($this->selected_index > -1) {
			$html .= "		, selected: ".$this->selected_index."\n";
		}
		$disabled_html = "";
		$is_disabled = false;
		for ($i=0; $i < sizeof($this->array_tabs_disabled); $i++) {
			if ($this->array_tabs_disabled[$i]) {
				if ($is_disabled) { $disabled_html .= ","; }
				$disabled_html .= $i;
				$is_disabled = true;
			}
		}
		if ($is_disabled) {
			$html .= "		, disabled: [".$disabled_html."]\n";
		}
		if ($is_ajax_content) {
			$html .= "		, ajaxOptions: {\n";
			if ($this->cache) {
				$html .= "			cache: true,\n";
			} 
			$html .= "			success: function() {},\n";
			$html .= "			error: function (xhr, status, index, anchor) { if (status == 'error' && xhr.responseText != '') { \$(anchor.hash).html('<table><tr><td><img src=\'".$this->getPage()->getCDNServerURL()."wsp/img/warning.png\' height=\'24\' width=\'24\' border=\'0\' align=\'absmidlle\'/></td><td><b>Error</b></td></tr></table>' + (xhr.statusText != 'undefined' ? xhr.statusText : xhr.responseText)); } }\n";
			$html .= "		}\n";
		}
		$html .= "});\n";
		if ($this->selected_index > -1 && $this->height != "") {
			if (gettype($this->array_tabs_name[$this->selected_index]) == "object" && method_exists($this->array_tabs_name[$this->selected_index], "render")) {
				$tab_name_var = strip_tags($this->array_tabs_name[$this->selected_index]->render());
			} else {
				$tab_name_var = $this->array_tabs_name[$this->selected_index];
			}
			$html .= "$('#".$this->getId()."_".formalize_to_variable($tab_name_var)."').attr('style', 'overflow:auto;height:' + (parseInt($('#".$this->getId()."').css('height').replace('px', ''))-($('#".$this->getId()."').find('.ui-tabs-nav').height()+40)) + 'px;');\n";
		}
		$html .= "});\n";
		$html .= $this->getJavascriptTagClose();
		
		$this->object_change = false;
		return $html;
	}
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html of object Tabs (call with AJAX)
	 * @since 1.0.98
	 */
	public function getAjaxRender() {
		$html = "";
		if ($this->object_change && !$this->is_new_object_after_init) {
			if ($this->selected_index > -1) {
				$html .= "$('#".$this->getId()."').tabs('option', 'selected', ".$this->selected_index.");";
			}
			
			$this->object_change = false;
		}
		return $html;
	}
}
?>
