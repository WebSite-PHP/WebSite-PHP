<?php
class Font extends WebSitePhpObject {
	/**#@+
		* Font family
		* @access public
		* @var string
		*/
	const FONT_ARIAL = "Arial";
	const FONT_TIMES = "Times New Roman";
	/**#@-*/
	
	/**#@+
		* Font weight
		* @access public
		* @var string
		*/
	const FONT_WEIGHT_BOLD = "bold";
	const FONT_WEIGHT_NONE = "none";
	/**#@-*/
	
	/**#@+
		* @access private
		*/
	private $content_object = null;
	private $font_size = "";
	private $font_family = "";
	private $font_weight = "";
	private $font_color = "";
	private $id = "";
	/**#@-*/

	function __construct($content_object, $font_size='', $font_family='', $font_weight='') {
		parent::__construct();
		
		if (!isset($content_object)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->content_object = $content_object;
		$this->font_size = $font_size;
		$this->font_family = $font_family;
		$this->font_weight = $font_weight;
	}
	
	public function setFontSize($font_size) {
		$this->font_size = $font_size;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setFontFamily($font_family) {
		$this->font_family = $font_family;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setFontWeight($font_weight) {
		$this->font_weight = $font_weight;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setFontColor($font_color) {
		$this->font_color = $font_color;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
		
	public function setId($id) {
		$this->id = $id;
	}
		
	public function getId() {
		return $this->id;
	}
	
	public function render($ajax_render=false) {
		$html = "<span ";
		if ($this->id != "") {
			$html .= "id=\"".$this->id."\" ";
		}
		$html .= "style=\"";
		if ($this->font_size != "") {
			if (is_integer($this->font_size)) {
				$html .= "font-size:".$this->font_size."pt;";
			} else {
				$html .= "font-size:".$this->font_size.";";
			}
		}
		if ($this->font_family != "") {
			$html .= "font-family:".$this->font_family.";";
		}
		if ($this->font_weight != "") {
			$html .= "font-weight:".$this->font_weight.";";
		}
		if ($this->font_color != "") {
			$html .= "color:".$this->font_color.";";
		}
		$html .= "\">";
		if (gettype($this->content_object) == "object") {
			$html .= $this->content_object->render();
		} else {
			$html .= $this->content_object;
		}
		$html .= "</span>";
		$this->object_change = false;
		return $html;
	}
	
	/**
	 * function getAjaxRender
	 * @return string javascript code to update initial html with ajax call
	 */
	public function getAjaxRender() {
		$html = "";
		if ($this->object_change && !$this->is_new_object_after_init && $this->id != "") {
			if (gettype($this->content_object) == "object") {
				$content = $this->content_object->render();
			} else {
				$content = $this->content_object;
			}
			$html .= "$('#".$this->id."').html(\"".str_replace('"', '\"', str_replace("\n", "", str_replace("\r", "", $content)))."\");\n";
			$html .= "$('#".$this->id."').attr('style', '";
			if ($this->font_size != "") {
				if (is_integer($this->font_size)) {
					$html .= "font-size:".$this->font_size."pt;";
				} else {
					$html .= "font-size:".$this->font_size.";";
				}
			}
			if ($this->font_family != "") {
				$html .= "font-family:".$this->font_family.";";
			}
			if ($this->font_weight != "") {
				$html .= "font-weight:".$this->font_weight.";";
			}
			if ($this->font_color != "") {
				$html .= "color:".$this->font_color.";";
			}
			$html .= "');\n";
		}
		return $html;
	}
}
?>
