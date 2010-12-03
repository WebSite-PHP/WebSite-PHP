<?php
require_once(dirname(__FILE__)."/error-template.php");

class ErrorDebug extends Page {
	function __construct() {}
	
	public function Load() {
		parent::$PAGE_TITLE = "Debug error - ".SITE_NAME;
		
		$obj_error_msg = new Object(new Picture("wsp/img/warning.png", 48, 48, 0, "absmidlle"), "<br/>");
		$debug_obj = new Object($_GET['debug']);
		$debug_obj->setAlign(Object::ALIGN_LEFT);
		$debug_obj->setWidth("80%");
		$obj_error_msg->add($debug_obj, "<br/><br/>");
		
		$obj_error_msg->add("<a href=\"".$_GET['from_url']."\">Refresh this page</a>", "<br/><br/>");
		
		$obj_error_msg->add("<b>Consult <a href=\"http://www.php.net\" target=\"_blank\">PHP</a> or <a href=\"http://www.website-php.com\" target=\"_blank\">WebSite-PHP</a> documentations.</b>", "<br/>");
		
		$obj_error_msg->add("<br/><br/>", "Go back to the main page", new Link(BASE_URL, Link::TARGET_NONE, SITE_NAME));
		
		$this->render = new ErrorTemplate($this, $obj_error_msg, "Debug error");
	}
}
?>