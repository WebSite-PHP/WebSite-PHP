<?php
/**
 * PHP file pages\defined_zone\template.php
 */
/**
 * Defined zone template: define the render of the zone template
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
 * @copyright   WebSite-PHP.com 19/07/2010
 * @version     1.0.66
 * @access      public
 * @since       1.0.51
 */

/**
 * Defined zone template: define the render of the zone template
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
 * @copyright   WebSite-PHP.com 19/07/2010
 * @version     1.0.50
 * @access      public
 * @since       1.0.27
 */


class Template extends DefinedZone {
	function __construct($page_object, $content) {
		parent::__construct();
		
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
		$this->render->addRow($lang_box);
		
		// Footer
		$this->render->addRow(new Footer());
	}
}
?>
