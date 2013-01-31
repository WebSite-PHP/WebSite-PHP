<?php
require_once(dirname(__FILE__)."/../includes/admin-template-form.inc.php");

class ManageTranslations extends Page {
	protected $USER_RIGHTS = Page::RIGHTS_ADMINISTRATOR;
	protected $USER_NO_RIGHTS_REDIRECT = "wsp-admin/connect.html";
	
	public function Load() {
		parent::$PAGE_TITLE = __(MANAGE_TRANSLATIONS);
		
		$construction_page = new Object(__(PAGE_IN_CONSTRUCTION));
		$construction_page->setClass("warning");
		
		// Search in all translation files the labels
		// Features :
		// - get the list of the labels for a page / language
		// - display for each label if there is a translation in all the language of the website
		// - enter a new label
		// - update a label
		// - delete a label
		
		// Create a link to the page
		
		$this->render = new AdminTemplateForm($this, $construction_page);
	}
}
?>
