<?php
require_once(dirname(__FILE__)."/../../../lang/".$_SESSION['lang']."/wsp-admin/all.inc.php");

class UpdateWsp extends Page {
	protected $USER_RIGHTS = "administrator";
	protected $USER_NO_RIGHTS_REDIRECT = "wsp-admin/connect.html";
	
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		$this->setTimeout(0);
		
		if ($this->getExatactLastWspVersion()) {
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
	
	private function getExatactLastWspVersion() {
		$wsp_file = new File("http://www.website-php.com/download/website-php-update.zip", true);
		$wsp_zip = $wsp_file->read();
		$wsp_file->close();
		
		$file = new File(dirname(__FILE__)."/tmp/website-php-update.zip", true, true);
		$file->write($wsp_zip);
		$file->close();
		
		if (file_exists(dirname(__FILE__)."/tmp/website-php-update.zip") && extension_loaded('zip')) {
			$zip = new ZipArchive;
			$res = $zip->open(dirname(__FILE__)."/tmp/website-php-update.zip");
			if ($res === TRUE) {
				$bool = $zip->extractTo(dirname(__FILE__)."/../../../");
				$zip->close();
				
				if ($bool) {
					$is_call_from_wsp_admin_update = true;
					include("wsp-update-script.inc.php");
				}
				
				return $bool;
			}
		}
		return false;
	}
}
?>
