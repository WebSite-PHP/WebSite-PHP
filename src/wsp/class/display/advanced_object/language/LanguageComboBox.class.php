<?php
/**
 * PHP file wsp\class\display\advanced_object\language\LanguageComboBox.class.php
 * @package display
 * @subpackage advanced_object.language
 */
/**
 * Class LanguageComboBox
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2013 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object.language
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 18/02/2013
 * @version     1.2.2
 * @access      public
 * @since       1.0.93
 */

class LanguageComboBox extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $cmb_language = null;
	/**#@-*/
	
	/**
	 * Constructor LanguageComboBox
	 * @param mixed $page_or_form_object 
	 * @param string $name 
	 * @param string $width 
	 */
	function __construct($page_or_form_object, $name='', $width='') {
		parent::__construct();
		
		$this->cmb_language = new ComboBox($page_or_form_object, $name, $width);
	}
	
	/**
	 * Method addLanguage
	 * @access public
	 * @param mixed $language_code 
	 * @param mixed $language_text 
	 * @return LanguageComboBox
	 * @since 1.0.93
	 */
	public function addLanguage($language_code, $language_text) {
		$lang_link = BASE_URL.$language_code."/".str_replace($this->getPage()->getBaseLanguageURL(), "", $this->getPage()->getCurrentURL());
		$this->cmb_language->addItem($lang_link, $language_text, ($this->getPage()->getLanguage()==$language_code)?true:false, BASE_URL."wsp/img/lang/".$language_code.".png");
		$this->cmb_language->onChangeJs("location.href=$('#".$this->cmb_language->getEventObjectName()."').val();");
		return $this;
	}
	
	/**
	 * Method setWidth
	 * @access public
	 * @param integer $width 
	 * @return LanguageComboBox
	 * @since 1.0.93
	 */
	public function setWidth($width) {
		$this->cmb_language->setWidth($width);
		return $this;
	}
	
	/**
	 * Method setSmallIcons
	 * @access public
	 * @since 1.1.7
	 */
	public function setSmallIcons() {
		$this->cmb_language->setSmallIcons();
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return mixed
	 * @since 1.0.93
	 */
	public function render($ajax_render=false) {
		$this->object_change = false;
		return $this->cmb_language->render();
	}
}
?>
