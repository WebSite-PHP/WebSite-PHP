<?php
require_once(dirname(__FILE__)."/error-template.php");

class Error404 extends Page {
	function __construct() {}
	
	public function Load() {
		parent::$PAGE_TITLE = __(ERROR_404)." - ".SITE_NAME;
		
		$obj_error_msg = new Object(new Picture("wsp/img/warning.png", 48, 48, 0, "absmidlle"), "<br/>", __(ERROR_404_MSG));
		$obj_error_msg->add("<br/><br/>", __(MAIN_PAGE_GO_BACK), new Link(BASE_URL, Link::TARGET_NONE, SITE_NAME));
		
		$this->render = new ErrorTemplate($this, $obj_error_msg, __(ERROR_404));
	}
}
?>