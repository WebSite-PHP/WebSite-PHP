<?php
/**
 * PHP file wsp\class\display\Label.class.php
 * @package display
 */
/**
 * Class Label
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
 * @copyright   WebSite-PHP.com 05/02/2017
 * @version     1.2.15
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
	private $style = "";
	
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
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
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
	 * Method setStyle
	 * @access public
	 * @param mixed $style 
	 * @return Label
	 * @since 1.0.89
	 */
	public function setStyle($style) {
		$this->style = $style;
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
	 * Method getLabel
	 * @access public
	 * @return mixed
	 * @since 1.2.15
	 */
	public function getLabel() {
		if (gettype($this->label) == "object" && method_exists($this->label, "render")) {
			$label = $this->label->render();
		} else {
			$label = $this->label;
		}
		return $label;
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
		
		if (!$this->is_ajax_event) {
			if ($this->id != "" || $this->font_size != "" || $this->font_family != "" || $this->color != "") {
				$html .= "<label";
				if ($this->id != "") {
					$html .= " id=\"".$this->id."\"";
				}
				if ($this->font_size != "" || $this->font_family != "" || $this->color != "" || $this->style != "") {
					$html .= " style=\"";
					if ($this->font_size != "") {
						if (is_numeric($this->font_size)) {
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
					if ($this->style != "") {
						$html .= $this->style;
					}
					$html .= "\"";
				}
				$html .= ">";
			}
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
		
		$html .= $this->getLabel();
		
		if ($this->italic) {
			$html .= "</i>";
		}
		if ($this->underline) {
			$html .= "</u>";
		}
		if ($this->bold) {
			$html .= "</b>";
		}
		
		if (!$this->is_ajax_event) {
			if ($this->id != "" || $this->font_size != "" || $this->font_family != "" || $this->color != "") {
				$html .= "</label>";
			}
		}
		
		$this->object_change = false;
		return $html;
	}
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html of object Label (call with AJAX)
	 * @since 1.2.3
	 */
	public function getAjaxRender() {
		$html = "";
		if ($this->object_change && !$this->is_new_object_after_init) {
			if ($this->id == "") {
				throw new NewException("To use Ajax render with ".get_class($this)." you must define an id (".get_class($this)."->setId())", 0, getDebugBacktrace(1));
			}
			
			$html .= "$('#".$this->id."').html('".str_replace("\n", "", str_replace("\r", "", addslashes($this->render(true))))."');\n";
			if ($this->style != "") {
				$html .= "$('#".$this->id."').attr('style', '".addslashes($this->style)."');\n";
			}
			if ($this->font_size != "") {
				$html .= "$('#".$this->id."').css('font-size', ";
				if (is_numeric($this->font_size)) {
					$html .= "'".$this->font_size."pt'";
				} else {
					$html .= "'".addslashes($this->font_size)."'";
				}
				$html .= ");\n";
			}
			if ($this->font_family != "") {
				$html .= "$('#".$this->id."').css('font-family', '".addslashes($this->font_family)."');\n";
			}
			if ($this->color != "") {
				$html .= "$('#".$this->id."').css('color', '".addslashes($this->color)."');\n";
			}
		}
		
		return $html;
	}
	
}
?>
