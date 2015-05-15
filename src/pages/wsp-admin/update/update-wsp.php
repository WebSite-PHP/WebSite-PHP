<?php
/**
 * PHP file pages\wsp-admin\update\update-wsp.php
 */
/**
 * Content of the Page update-wsp
 * This page is used to update the FrameWork WebSite-PHP
 * URL: http://127.0.0.1/website-php-install/wsp-admin/update/update-wsp.html
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
require_once(dirname(__FILE__)."/../includes/utils-version.inc.php");

class UpdateWsp extends Page {
	protected $USER_RIGHTS = Page::RIGHTS_ADMINISTRATOR;
	protected $USER_NO_RIGHTS_REDIRECT = "wsp-admin/connect.html";
	
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		$this->setTimeout(0);
		
		if ($this->getExtractLastWspVersion()) {
			$congratulation_pic = new Picture("img/wsp-admin/button_ok_64.png", 64, 64);
			$this->render = new Object($congratulation_pic, "<br/>", __(UPDATE_FRAMEWORK_COMPLETE_OK, "WebSite-PHP"));
		} else {
			$error_pic = new Picture("img/wsp-admin/button_not_ok_64.png", 64, 64);
			$this->render = new Object($error_pic, "<br/>", __(UPDATE_FRAMEWORK_COMPLETE_NOT_OK, "WebSite-PHP"));
		}
		$button_ok = new Button($this);
		$button_ok->setValue("OK");
		$button_ok->onClickJs(DialogBox::closeAll()."location.href=location.href;");
		
		$this->render->add("<br/><br/>", $button_ok);
		$this->render->setAlign(Object::ALIGN_CENTER);
	}
	
	private function getExtractLastWspVersion() {
		$log_file = new File(dirname(__FILE__)."/tmp/wsp-update.log", false, true);
		$log_file->write("Update WSP log:\n");
		
		$old_wsp_vserion = getCurrentWspVersion();
		$log_file->write("[".date("Y-m-d H:i:s")."] Old version number: ".$old_wsp_vserion."\n");
		
		
		$log_file->write("[".date("Y-m-d H:i:s")."] Start download website-php-update.zip ...\n");
		$wsp_file = new File("http://www.website-php.com/download/website-php-update.zip", true);
		$wsp_zip = $wsp_file->read();
		$wsp_file->close();
		$log_file->write("[".date("Y-m-d H:i:s")."] End download website-php-update.zip\n");
		
		$log_file->write("[".date("Y-m-d H:i:s")."] Start write locally website-php-update.zip ...\n");
		$file = new File(dirname(__FILE__)."/tmp/website-php-update.zip", true, true);
		$file->write($wsp_zip);
		$file->close();
		$log_file->write("[".date("Y-m-d H:i:s")."] End write locally website-php-update.zip\n");
		
		if (file_exists(dirname(__FILE__)."/tmp/website-php-update.zip") && extension_loaded('zip')) {
			// save current languages used
			$array_lang_used = scandir(dirname(__FILE__)."/../../../lang");
			
			// unzip
			$zip = new ZipArchive;
			$log_file->write("[".date("Y-m-d H:i:s")."] Open Zip archive website-php-update.zip ...\n");
			$res = $zip->open(dirname(__FILE__)."/tmp/website-php-update.zip");
			if ($res === TRUE) {
				$log_file->write("[".date("Y-m-d H:i:s")."] Start Zip archive extraction ...\n");
				$bool = $zip->extractTo(dirname(__FILE__)."/../../../");
				$zip->close();
				$log_file->write("[".date("Y-m-d H:i:s")."] End Zip archive extraction (status: ".($bool?"true":"false").")\n");
				
				if ($bool) {
					// launch update script
					$is_call_from_wsp_admin_update = true;
					$log_file->write("[".date("Y-m-d H:i:s")."] Start call WSP update script ...\n");
					include("wsp-update-script.inc.php");
					$log_file->write("[".date("Y-m-d H:i:s")."] End call WSP update script (status: ".($bool?"true":"false").")\n");
				}
				$log_file->write("[".date("Y-m-d H:i:s")."] End Update WSP (status: ".($bool?"true":"false").")\n");
		
				return $bool;
			}
		}
		$log_file->write("[".date("Y-m-d H:i:s")."] End Update WSP (status: ".($bool?"true":"false").")\n");
		$log_file->close();
		
		return false;
	}
}
?>
