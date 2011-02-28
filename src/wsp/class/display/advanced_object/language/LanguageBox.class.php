<?php
/**
 * Class LangugeBox
 * 
 * Instance of a new LanguageBox with rounded header.
 * @access public
 * @author Emilien MOREL <admin@website-php.com>
 * @link http://www.website-php.com
 * @copyright website-php.com 29/11/2009
 * @version 1.0
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
	private $width = "";
	
	private $icon_16_pixels = "";
	private $icon_16_pixels_text = "";
	private $icon_48_pixels = "";
	private $icon_48_pixels_text = "";
	/**#@-*/
	
	/**
	 * Constructor LanguageBox
	 * @param object|string $title title in the header the box
	 * @param boolean $shadow if box has shadow
	 * @param string $style_header style of the header (Box::STYLE_MAIN or Box::STYLE_SECOND)
	 * @param string $style_content style of the content (Box::STYLE_MAIN or Box::STYLE_SECOND)
	 */
	function __construct($shadow=false, $style_header='1', $style_content='1') {
		parent::__construct();
		
		$this->shadow = $shadow;
		$this->style_header = $style_header;
		$this->style_content = $style_content;
	}
	
	public function setSmallIcon($icon_16_pixels, $text='') {
		$this->icon_16_pixels = $icon_16_pixels;
		$this->icon_16_pixels_text = $text;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setBigIcon($icon_48_pixels, $text='') {
		$this->icon_48_pixels = $icon_48_pixels;
		$this->icon_48_pixels_text = $text;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * function addLanguage
	 * @param string language code (ex: en, fr, de, ...)
	 */
	public function addLanguage($language_code) {
		$this->languages[sizeof($this->languages)] = $language_code;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setWidth($width) {
		$this->width = $width;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * function render
	 * @return object generate html box with country flag
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
		$lang_box->setContent($lang_obj);
		$this->object_change = false;
		return $lang_box->render();
	}
}
?>
