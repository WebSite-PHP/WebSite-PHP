<?php
/**
 * PHP file wsp\class\display\advanced_object\language\Language.class.php
 * @package display
 * @subpackage advanced_object.language
 */
/**
 * Class Language
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
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, getDebugBacktrace(1));
		}
		
		$this->language = $language;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return object generate html box with country flag
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$lang_link = BASE_URL.$this->language."/".str_replace($this->getPage()->getBaseLanguageURL(), "", $this->getPage()->getCurrentURL());
		$lang_link_obj = new Link($lang_link, Link::TARGET_NONE, new Picture("wsp/img/lang/".$this->language.".png", 24, 24, 0, Picture::ALIGN_ABSMIDDLE));
		$this->object_change = false;
		return $lang_link_obj->render();
	}
}
?>
