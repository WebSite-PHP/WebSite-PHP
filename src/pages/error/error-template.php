<?php
/**
 * PHP file pages\error\error-template.php
 */
/**
 * Template for all error pages
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
 * @copyright   WebSite-PHP.com 03/10/2010
 * @version     1.0.77
 * @access      public
 * @since       1.0.30
 */

require_once(dirname(__FILE__)."/../../wsp/class/WebSitePhpObject.class.php");
require_once(dirname(__FILE__)."/../../wsp/class/display/advanced_object/Box.class.php");
require_once(dirname(__FILE__)."/../../wsp/class/display/Link.class.php");
require_once(dirname(__FILE__)."/../../wsp/class/display/Object.class.php");
require_once(dirname(__FILE__)."/../../wsp/class/display/Page.class.php");
require_once(dirname(__FILE__)."/../../wsp/class/display/Picture.class.php");
require_once(dirname(__FILE__)."/../../wsp/class/display/RowTable.class.php");
require_once(dirname(__FILE__)."/../../wsp/class/display/Table.class.php");

class ErrorTemplate extends Page {
	function __construct($page_object, $content, $title) {
		parent::__construct();
		
		$this->render = new Table();
		$this->render->setWidth("100%");
		
		// Header
		$logo = new Picture("img/logo_128x400_".$_SESSION['lang'].".png", 128, 400);
		$logo->setTitle(SITE_NAME);
		$logo_link = new Link($page_object->getBaseLanguageURL(), Link::TARGET_NONE, $logo);
		$img_obj = new Object($logo_link);
		$img_obj->add("<br/><br/>");
		$this->render->addRow($img_obj);
		$this->render->addRow();
		
		// Error message
		$small_img = new Picture("img/logo_16x16.png", 16, 16, 0, "absmiddle");
		$title_header = new Object($small_img, $title);
		
		$error_box = new Box($title_header, true, Box::STYLE_MAIN, Box::STYLE_MAIN, '', 'error_box', 700);
		$error_box->setContent($content);
		
		$this->render->addRow($error_box);
	}
}
?>
