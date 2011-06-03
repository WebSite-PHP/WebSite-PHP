<?php
require_once(dirname(__FILE__)."/../../../lang/".$_SESSION['lang']."/wsp-admin/all.inc.php");

class UpdateFramework extends Page {
	protected $USER_RIGHTS = "administrator";
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
