<?php
/**
 * PHP file wsp\class\display\Label.class.php
 * @package display
 */
/**
 * Class Label
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 26/05/2011
 * @version     1.0.84
 * @access      public
 * @since       1.0.17
 */

class Label extends WebSitePhpObject {
	/**#@+
	* Font family
	* @access public
	* @var string
	*/
	const FONT_ARIAL = "Arial";
	const FONT_TIMES = "Times New Roman";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $label = "";
	private $bold = false;
	private $italic = false;
	private $underline = false;
	
	private $font_size = "";
	private $font_family = "";
	private $color = "";
	
	private $id = "";
	/**#@-*/

	/**
	 * Constructor Label
	 * @param string $label 
	 * @param boolean $bold [default value: false]
	 * @param boolean $italic [default value: false]
	 * @param boolean $underline [default value: false]
	 */
	function __construct($label='', $bold=false, $italic=false, $underline=false) {
		parent::__construct();
		
		$this->label = $label;
		$this->bold = $bold;
		$this->italic = $italic;
		$this->underline = $underline;
	}
	
	/**
	 * Method setBold
	 * @access public
	 * @return Label
	 * @since 1.0.36
	 */
	public function setBold() {
		$this->bold = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setItalic
	 * @access public
	 * @return Label
	 * @since 1.0.36
	 */
	public function setItalic() {
		$this->italic = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setUnderline
	 * @access public
	 * @return Label
	 * @since 1.0.36
	 */
	public function setUnderline() {
		$this->underline = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setId
	 * @access public
	 * @param mixed $id 
	 * @return Label
	 * @since 1.0.36
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	/**
	 * Method setLabel
	 * @access public
	 * @param mixed $label 
	 * @return Label
	 * @since 1.0.36
	 */
	public function setLabel($label) {
		$this->label = $label;
		return $this;
	}
	
	/**
	 * Method setFont
	 * @access public
	 * @param mixed $font_size 
	 * @param mixed $font_family 
	 * @return Label
	 * @since 1.0.36
	 */
	public function setFont($font_size, $font_family) {
		$this->font_size = $font_size;
		$this->font_family = $font_family;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setColor
	 * @access public
	 * @param mixed $color 
	 * @return Label
	 * @since 1.0.84
	 */
	public function setColor($color) {
		$this->color = $color;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method getId
	 * @access public
	 * @return mixed
	 * @since 1.0.36
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Label
	 * @since 1.0.36
	 */
	public function render($ajax_render=false) {
		$html = "";
		
		if ($this->id != "" || $this->font_size != "" || $this->font_family != "" || $this->color != "") {
			$html .= "<label id=\"".$this->id."\"";
			if ($this->font_size != "" || $this->font_family != "" || $this->color != "") {
				$html .= " style=\"";
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
				if ($this->color != "") {
					$html .= "color:".$this->color.";";
				}
				$html .= "\"";
			}
			$html .= ">";
		}
		
		if ($this->bold) {
			$html .= "<b>";
		}
		if ($this->italic) {
			$html .= "<i>";
		}
		if ($this->underline) {
			$html .= "<u>";
		}
		
		$html .= $this->label;
		
		if ($this->italic) {
			$html .= "</i>";
		}
		if ($this->underline) {
			$html .= "</u>";
		}
		if ($this->bold) {
			$html .= "</b>";
		}
		
		if ($this->id != "" || $this->font_size != "" || $this->font_family != "") {
			$html .= "</label>";
		}
		
		$this->object_change = false;
		return $html;
	}
	
}
?>
