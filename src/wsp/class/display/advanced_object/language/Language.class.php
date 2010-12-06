<?php
/**
 * Class LangugeBox
 * 
 * Instance of a new Language object.
 * @access public
 * @author Emilien MOREL <admin@website-php.com>
 * @link http://www.website-php.com
 * @copyright website-php.com 01/12/2009
 * @version 1.0
 */
 
class Language extends WebSitePhpObject {
	/**#@+
		* @access private
		*/
	private $language = "en";
	/**#@-*/
	
	/**
	 * Constructor Language
	 * @param string $language language code (en, fr, de, ...)
	 */
	function __construct($language) {
		parent::__construct();
		
		if (!isset($language)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->language = $language;
	}
	
	/**
	 * function render
	 * @return object generate html box with country flag
	 */
	public function render($ajax_render=false) {
		$lang_link = BASE_URL.$this->language."/".PARAMS_URL;
		$lang_link_obj = new Link($lang_link, Link::TARGET_NONE, new Picture("wsp/img/lang/".$this->language.".png", 24, 24));
		$this->object_change = false;
		return $lang_link_obj->render();
	}
}
?>