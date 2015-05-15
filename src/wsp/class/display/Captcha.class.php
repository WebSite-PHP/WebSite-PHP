<?php
/**
 * PHP file wsp\class\display\Captcha.class.php
 * @package display
 */
/**
 * Class Captcha
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

class Captcha extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	protected $class_name = "";
	protected $page_object = null;
	protected $form_object = null;
	private $name = "";
	private $value = "";
	private $refresh = true;
	private $sound = true;
	private $default_value = "";
	private $width = 230;
	private $height = 80;
	private $has_focus = false;
	/**#@-*/
	
	/**
	 * Constructor Captcha
	 * @param mixed $page_or_form_object 
	 * @param string $name 
	 * @param boolean $refresh [default value: true]
	 * @param boolean $sound [default value: true]
	 */
	function __construct($page_or_form_object, $name='', $refresh=true, $sound=true) {
		parent::__construct();
		
		if (!isset($page_or_form_object) || gettype($page_or_form_object) != "object" || (!is_subclass_of($page_or_form_object, "Page") && get_class($page_or_form_object) != "Form")) {
			throw new NewException("Argument page_or_form_object for ".get_class($this)."::__construct() error", 0, getDebugBacktrace(1));
		}
		
		if (is_subclass_of($page_or_form_object, "Page")) {
			$this->class_name = get_class($page_or_form_object);
			$this->page_object = $page_or_form_object;
			$this->form_object = null;
		} else {
			$this->page_object = $page_or_form_object->getPageObject();
			$this->class_name = get_class($this->page_object)."_".$page_or_form_object->getName();
			$this->form_object = $page_or_form_object;
		}
		
		if ($name == "") {
			$name = $this->page_object->createObjectName($this);
			$this->name = $name;
		} else {
			$exist_object = $this->page_object->existsObjectName($name);
			$this->name = $name;
			if ($exist_object != false) {
				throw new NewException("Tag name \"".$name."\" for object ".get_class($this)." already use for other object ".get_class($exist_object), 0, getDebugBacktrace(1));
			}
			$this->page_object->addEventObject($this, $this->form_object);
		}
		
		$this->refresh = $refresh;
		$this->sound = $sound;
	}
	
	/**
	 * Method setValue
	 * @access public
	 * @param mixed $value 
	 * @return Captcha
	 * @since 1.0.35
	 */
	public function setValue($value) {
		$this->value = $value;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}

	/**
	 * Method setDefaultValue
	 * @access public
	 * @param mixed $value 
	 * @return Captcha
	 * @since 1.0.35
	 */
	public function setDefaultValue($value) {
		$this->default_value = $value;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setWidth
	 * @access public
	 * @param integer $width 
	 * @return Captcha
	 * @since 1.0.35
	 */
	public function setWidth($width) {
		if (!is_integer($width)) {
			throw new NewException("width attribut must be an integer in the method setWidth (Captcha object)", 0, getDebugBacktrace(1));
		}
		$this->width = $width;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setHeight
	 * @access public
	 * @param integer $height 
	 * @return Captcha
	 * @since 1.0.35
	 */
	public function setHeight($height) {
		$this->height = $height;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setFocus
	 * @access public
	 * @return Captcha
	 * @since 1.0.103
	 */
	public function setFocus() {
		$this->has_focus = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method forceObjectChange
	 * @access public
	 * @return Captcha
	 * @since 1.0.35
	 */
	public function forceObjectChange() {
		$this->object_change =true;
		return $this;
	}
	
	/**
	 * Method getName
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * Method getEventObjectName
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getEventObjectName() {
		return $this->class_name."_".$this->name;
	}

	/**
	 * Method getValue
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * Method getDefaultValue
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getDefaultValue() {
		return $this->default_value;
	}

	/**
	 * Method getFormObject
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getFormObject() {
		return $this->form_object;
	}
	
	/**
	 * Method check
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function check() {
		$securimage = new Securimage();
		$is_captcha_correct = $securimage->check($this->value);
		if (!$is_captcha_correct) {
			$this->object_change =true;
		}
		return $is_captcha_correct;
	}
	
	/**
	 * Method getId
	 * @access public
	 * @return mixed
	 * @since 1.0.103
	 */
	public function getId() {
		return "wsp_captcha_".$this->name;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Captcha
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$html = "";
		if ($this->class_name != "") {
			if (!$ajax_render) {
				$html .= "<div id=\"wsp_captcha_".$this->name."\">\n";
			}
			$html .= "<div style=\"width:";
			if ($this->sound || $this->refresh) {
				$html .= ($this->width + 30);
			} else {
				$html .= $this->width;
			}
			$html .= "px;\">\n";
			$html .= "<img id=\"captcha_img_".$this->name."\" src=\"".BASE_URL."wsp/includes/securimage/securimage_show.php?width=".$this->width."&height=".$this->height."\" alt=\"CAPTCHA Image\" align=\"left\" width=\"".$this->width."\" height=\"".$this->height."\" />\n";
			$html .= "<br />\n";
			if ($this->sound) {
				$html .= "<object type=\"application/x-shockwave-flash\" data=\"".BASE_URL."wsp/includes/securimage/securimage_play.swf?audio=wsp/includes/securimage/securimage_play.php&amp;bgColor1=#fff&amp;bgColor2=#fff&amp;iconColor=#777&amp;borderWidth=1&amp;borderColor=#000\" height=\"19\" width=\"19\">\n";
	    		$html .= "	<param name=\"movie\" value=\"".BASE_URL."wsp/includes/securimage/securimage_play.swf?audio=wsp/includes/securimage/securimage_play.php&amp;bgColor1=#fff&amp;bgColor2=#fff&amp;iconColor=#777&amp;borderWidth=1&amp;borderColor=#000\" />\n";
	  			$html .= "</object>\n";
			}
  			$html .= "<br /><br />\n";
  			if ($this->refresh) {
				$html .= "<a tabindex=\"-1\" style=\"border-style: none\" href=\"#\" title=\"Refresh Captcha Image\" onclick=\"$('#captcha_img_".$this->name."').attr('src', '".BASE_URL."wsp/includes/securimage/securimage_show.php?width=".$this->width."&height=".$this->height."&sid=' + Math.random()); return false\"><img src=\"".$this->getPage()->getCDNServerURL()."wsp/includes/securimage/images/refresh.gif\" alt=\"Reload Captcha Image\" border=\"0\" onclick=\"this.blur()\" align=\"bottom\" /></a>\n";
  			}
  			$html .= "<br />\n";
			$html .= "<strong>".__(CAPTCHA_CODE)."</strong> ";
			$html .= "<input type=\"text\" name=\"".$this->getEventObjectName()."\" id=\"".$this->getEventObjectName()."\" size=\"8\" value=\"".$this->value."\" style=\"width: ".($this->width - 100)."px\"";
			$html .= " onFocus=\"this.select()\""; // select text on focus
			$html .= " onBlur=\"\$(this).val(\$(this).val());\""; // unselect text when lost focus
			$html .= " />\n";
			$html .= "</div>\n";
			if (!$ajax_render) {
				$html .= "</div>\n";
			}
			if ($this->has_focus) {
				$html .= $this->getJavascriptTagOpen();
				$html .= "\$('#".$this->getEventObjectName()."').focus().select();\n"; // select text on focus
				$html .= $this->getJavascriptTagClose();
			}
		}
		$this->object_change = false;
		return $html;
	}
	

	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html of object Captcha (call with AJAX)
	 * @since 1.0.35
	 */
	public function getAjaxRender() {
		$html = "";
		$html .= "$('#wsp_captcha_".$this->name."').html(\"".str_replace('"', '\"', str_replace("\n", "", str_replace("\r", "", $this->render(true))))."\");\n";
		$html .= "$('#wsp_captcha_".$this->name."').css('width', \"".$this->width."px\");\n";
		$html .= "$('#captcha_img_".$this->name."').attr('src', '".BASE_URL."wsp/includes/securimage/securimage_show.php?width=".$this->width."&height=".$this->height."&sid=' + Math.random());\n";
		if ($this->has_focus) {
			$html .= "\$('#".$this->getEventObjectName()."').focus().select();\n"; // select text on focus
		}
		return $html;
	}
}
?>
