<?php
require_once(dirname(__FILE__)."/includes/utils.inc.php");
require_once(dirname(__FILE__)."/includes/admin-template-button.inc.php");

class Admin extends Page {
	protected $USER_RIGHTS = "administrator";
	
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		parent::$PAGE_TITLE = __(ADMIN);
		
		// Admin
		$this->render = new AdminTemplateButton($this, ($_GET[menu]=="")?"admin.html":"admin.html?menu=".$_GET[menu]);
	}
}
?>