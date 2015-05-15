<?php
/**
 * PHP file pages\wsp-admin\update\update-browscap.php
 */
/**
 * Content of the Page update-browscap
 * This page is used to update the FrameWork WebSite-PHP
 * URL: http://127.0.0.1/website-php-install/wsp-admin/update/update-browscap.html
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
 * @copyright   WebSite-PHP.com 14/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.1.4
 */

require_once(dirname(__FILE__)."/../../../lang/".$_SESSION['lang']."/wsp-admin/all.inc.php");

class UpdateBrowscap extends Page {
	protected $USER_RIGHTS = Page::RIGHTS_ADMINISTRATOR;
	protected $USER_NO_RIGHTS_REDIRECT = "wsp-admin/connect.html";
	
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		unset($_SESSION['user_browscap_version']);
		
		if ($this->updateBrowscapFile()) {
			$congratulation_pic = new Picture("img/wsp-admin/button_ok_64.png", 64, 64);
			$this->render = new Object($congratulation_pic, "<br/>", __(UPDATE_FRAMEWORK_COMPLETE_OK, "Browscap.ini"));
		} else {
			$error_pic = new Picture("img/wsp-admin/button_not_ok_64.png", 64, 64);
			$this->render = new Object($error_pic, "<br/>", __(UPDATE_FRAMEWORK_COMPLETE_NOT_OK, "Browscap.ini"));
		}
		
		$button_ok = new Button($this);
		$button_ok->setValue("OK");
		$button_ok->onClickJs(DialogBox::closeAll()."location.href=location.href;");
		
		$this->render->add("<br/><br/>", $button_ok);
		$this->render->setAlign(Object::ALIGN_CENTER);
		
		// refresh the page
		$this->addObject(new JavaScript("setTimeout('location.href=location.href;', 1000);"));
	}
	
	private function updateBrowscapFile() {
        ini_set("memory_limit", "2G");

        require_once(dirname(__FILE__).'/../../../wsp/class/utils/Browscap.class.php');
        $cacheDir = SITE_DIRECTORY.'/wsp/includes/browscap/';
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir);
        }
		unlink($cacheDir."cache.php");
		unlink($cacheDir."browscap.ini");
        $browscap = new Browscap($cacheDir);
        $browscap->doAutoUpdate = true;
        $browser = $browscap->getBrowser();

		unset($_SESSION['user_browscap_version']);
		unset($_SESSION['browser_info']);
		global $browscapIni;
		unset($browscapIni);
		
		if (is_dir($cacheDir."cache.php")) {
			return true;
		}
		return false;
	}
}
?>
