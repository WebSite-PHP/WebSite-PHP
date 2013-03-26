<?php
require_once(dirname(__FILE__)."/../includes/admin-template-form.inc.php");

class ManageTemplates extends Page {
	protected $USER_RIGHTS = Page::RIGHTS_ADMINISTRATOR;
	protected $USER_NO_RIGHTS_REDIRECT = "wsp-admin/admin.html";
	
	public function Load() {
		parent::$PAGE_TITLE = __(MANAGE_TEMPLATES);
		
		$construction_page = new Object(__(PAGE_IN_CONSTRUCTION));
		$construction_page->setClass("warning");
		
		// Use webservices to synchronise the list of available template
		// Features
		// - get the list of templates
		// - download
		// - update (version check)
		// - uninstall
		
		$this->render = new AdminTemplateForm($this, $construction_page);
	}
}
?>
