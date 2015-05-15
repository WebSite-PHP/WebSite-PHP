<?php
/**
 * PHP file wsp\class\display\Font.class.php
 * @package display
 */
/**
 * Class Font
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.17
 */

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

	/**
	 * Constructor Font
	 * @param object $content_object 
	 * @param string $font_size 
	 * @param string $font_family 
	 * @param string $font_weight 
	 */
	function __construct($content_object, $font_size='', $font_family='', $font_weight='') {
		parent::__construct();
		
		if (!isset($content_object)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, getDebugBacktrace(1));
		}
		
		$this->content_object = $content_object;
		$this->font_size = $font_size;
		$this->font_family = $font_family;
		$this->font_weight = $font_weight;
	}
	
	/**
	 * Method setFontSize
	 * @access public
	 * @param mixed $font_size 
	 * @return Font
	 * @since 1.0.35
	 */
	public function setFontSize($font_size) {
		$this->font_size = $font_size;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setFontFamily
	 * @access public
	 * @param mixed $font_family 
	 * @return Font
	 * @since 1.0.35
	 */
	public function setFontFamily($font_family) {
		$this->font_family = $font_family;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setFontWeight
	 * @access public
	 * @param mixed $font_weight 
	 * @return Font
	 * @since 1.0.35
	 */
	public function setFontWeight($font_weight) {
		$this->font_weight = $font_weight;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setFontColor
	 * @access public
	 * @param mixed $font_color 
	 * @return Font
	 * @since 1.0.35
	 */
	public function setFontColor($font_color) {
		$this->font_color = $font_color;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
		
	/**
	 * Method setId
	 * @access public
	 * @param mixed $id 
	 * @since 1.0.59
	 */
	public function setId($id) {
		$this->id = $id;
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
	 * @return string html code of object Font
	 * @since 1.0.35
	 */
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
		if (gettype($this->content_object) == "object" && method_exists($this->content_object, "render")) {
			$html .= $this->content_object->render();
		} else {
			$html .= $this->content_object;
		}
		$html .= "</span>";
		$this->object_change = false;
		return $html;
	}
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html of object Font (call with AJAX)
	 * @since 1.0.35
	 */
	public function getAjaxRender() {
		$html = "";
		if ($this->object_change && !$this->is_new_object_after_init && $this->id != "") {
			if (gettype($this->content_object) == "object" && method_exists($this->content_object, "render")) {
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
