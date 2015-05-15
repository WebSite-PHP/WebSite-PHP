<?php
/**
 * PHP file pages\wsp-admin\update\update-framework.php
 */
/**
 * Content of the Page update-framework
 * This page is used to update the FrameWork WebSite-PHP
 * URL: http://127.0.0.1/website-php-install/wsp-admin/update/update-framework.html
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.1.5
 */

require_once(dirname(__FILE__)."/../../../lang/".$_SESSION['lang']."/wsp-admin/all.inc.php");

class UpdateFramework extends Page {
	protected $USER_RIGHTS = Page::RIGHTS_ADMINISTRATOR;
	protected $USER_NO_RIGHTS_REDIRECT = "wsp-admin/connect.html";
	
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		if (isset($_GET['parent_dialog_level'])) {
			$this->addObject(DialogBox::closeLevel($_GET['parent_dialog_level']));
		}
		
		$this->render = new Object(new Picture("img/wsp-admin/update_64.png", 64, 64), "<br/>", __(UPDATE_FRAMEWORK_WAITING));
		$this->render->setAlign(Object::ALIGN_CENTER);
		
		$dialog_box = new DialogBox(__(UPDATE_FRAMEWORK_COMPLETE), new Url($this->getBaseLanguageURL()."wsp-admin/update/".$_GET['update'].".call"));
		$this->addObject($dialog_box->modal());
	}
}
?>
