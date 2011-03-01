<?php
/**
 * Description of PHP file wsp\class\display\advanced_object\language\Language.class.php
 * Class Language
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 22/10/2010
 *
 * @version     1.0.30
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
