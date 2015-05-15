<?php
/**
 * PHP file wsp\class\display\advanced_object\language\LanguageBox.class.php
 * @package display
 * @subpackage advanced_object.language
 */
/**
 * Class LanguageBox
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object.language
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.17
 */

class LanguageBox extends WebSitePhpObject {
	/**#@+
		* LanguageBox style
		* @access public
		* @var string
		*/
	const STYLE_MAIN = "1";
	const STYLE_SECOND = "2";
	/**#@-*/
	
	/**#@+
		* @access private
		*/
	private $languages = array();
	private $style_header = "1";
	private $style_content = "1";
	private $shadow = false;
	private $width = 200;
	
	private $icon_16_pixels = "";
	private $icon_16_pixels_text = "";
	private $icon_48_pixels = "";
	private $icon_48_pixels_text = "";
	/**#@-*/
	
	/**
	 * Constructor LanguageBox
	 * @param boolean $shadow if box has shadow [default value: false]
	 * @param string $style_header style of the header (Box::STYLE_MAIN or Box::STYLE_SECOND) [default value: 1]
	 * @param string $style_content style of the content (Box::STYLE_MAIN or Box::STYLE_SECOND) [default value: 1]
	 */
	function __construct($shadow=false, $style_header='1', $style_content='1') {
		parent::__construct();
		
		$this->shadow = $shadow;
		$this->style_header = $style_header;
		$this->style_content = $style_content;
		if (!$this->getPage()->isAjaxPage() && !$this->getPage()->isAjaxLoadPage()) {
			$this->addCss(BASE_URL."wsp/css/angle.css.php", "", true);
		}
	}
	
	/**
	 * Method setSmallIcon
	 * @access public
	 * @param mixed $icon_16_pixels 
	 * @param string $text 
	 * @return LanguageBox
	 * @since 1.0.33
	 */
	public function setSmallIcon($icon_16_pixels, $text='') {
		$this->icon_16_pixels = $icon_16_pixels;
		$this->icon_16_pixels_text = $text;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setBigIcon
	 * @access public
	 * @param mixed $icon_48_pixels 
	 * @param string $text 
	 * @return LanguageBox
	 * @since 1.0.33
	 */
	public function setBigIcon($icon_48_pixels, $text='') {
		$this->icon_48_pixels = $icon_48_pixels;
		$this->icon_48_pixels_text = $text;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method addLanguage
	 * @access public
	 * @param string $language_code language code (ex: en, fr, de, ...)
	 * @return LanguageBox
	 * @since 1.0.33
	 */
	public function addLanguage($language_code) {
		$this->languages[sizeof($this->languages)] = $language_code;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setWidth
	 * @access public
	 * @param integer $width 
	 * @return LanguageBox
	 * @since 1.0.33
	 */
	public function setWidth($width) {
		$this->width = $width;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return object generate html box with country flag
	 * @since 1.0.33
	 */
	public function render($ajax_render=false) {
		$lang_box = new Box(translate(BOX_LANGUAGE_TITLE), $this->shadow, $this->style_header, $this->style_content, "", "select_language_box");
		if ($this->icon_48_pixels != "") {
			$lang_box->setBigIcon($this->icon_48_pixels, $this->icon_48_pixels_text);
		} else if ($this->icon_16_pixels != "") {
			$lang_box->setSmallIcon($this->icon_16_pixels, $this->icon_16_pixels_text);
		}
		if ($this->width != "") {
			$lang_box->setWidth($this->width);
		}
		$lang_obj = new Object();
		if ($this->icon_48_pixels != "") {
			$lang_obj->add("<br/>");
		}
		for ($i=0; $i < sizeof($this->languages); $i++) {
			$lang_obj->add(new Language($this->languages[$i]));
		}
		$lang_obj->add("<br/>");
		if ($this->icon_48_pixels != "") {
			$lang_obj->add("<br/>");
		}
		$lang_box->setContent($lang_obj);
		$this->object_change = false;
		return $lang_box->render();
	}
}
?>
