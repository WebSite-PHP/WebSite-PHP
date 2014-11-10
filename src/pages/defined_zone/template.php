<?php
/**
 * PHP file pages\defined_zone\template.php
 */
/**
 * Defined zone template: define the render of the zone template
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2014 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 10/11/2014
 * @version     1.2.10
 * @access      public
 * @since       1.0.51
 */

class Template extends DefinedZone {
	function __construct($content) {
		// To get the Page object you can use:
		// $page_object = $this->getPage();
		
		$this->render = new Table();
		$this->render->setWidth("100%");
		$row_main_table = new RowTable(RowTable::ALIGN_CENTER);
		
		// Header
		$this->render->addRow(new Header());
		
		// Main
		$this->render->addRow($content);
		
		$this->render->addRow();
		
		$lang_box = new LanguageBox(true, Box::STYLE_MAIN, Box::STYLE_MAIN);
		$lang_box->setWidth(600);
		$lang_box->addLanguage("en");
		$lang_box->addLanguage("fr");
		$lang_box->addLanguage("de");
		$this->render->addRow($lang_box);
		
		// Footer
		$this->render->addRow(new Footer());
	}
}
?>
