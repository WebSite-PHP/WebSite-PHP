<?php
/**
 * PHP file pages\error\error-page.php
 */
/**
 * Page error-page
 * URL: http://127.0.0.1/website-php/error/error-page.html
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 26/05/2011
 * @version     1.0.98
 * @access      public
 * @since       1.0.18
 */

require_once(dirname(__FILE__)."/error-template.php");

class ErrorPage extends Page {
	function __construct() {}
	
	public function Load() {
		parent::$PAGE_TITLE = __(ERROR_PAGE)." - ".SITE_NAME;
		parent::$PAGE_META_ROBOTS = "noindex, nofollow";
		
		$error_msg_title = "";
		$array_code_error = array(401, 403, 404, 500);
		if (in_array($_GET['error-redirect'], $array_code_error)) {
			$_SESSION['calling_page'] = "";
			$error_msg = constant("ERROR_".$_GET['error-redirect']."_MSG");
			parent::$PAGE_TITLE = constant("ERROR_".$_GET['error-redirect']."_MSG")." - ".SITE_NAME;
			$error_msg_title = constant("ERROR_".$_GET['error-redirect']."_MSG");
		} else {
			$error_msg = __(ERROR_PAGE_MSG, $_SESSION['calling_page']);
			$error_msg_title = __(ERROR_PAGE);
		}
		
		$error_msg = new Label($error_msg, true);
		$obj_error_msg = new Object(new Picture("wsp/img/warning.png", 48, 48, 0, "absmidlle"), "<br/>", $error_msg->setColor("red"));
		$obj_error_msg->add("<br/><br/>", __(MAIN_PAGE_GO_BACK), new Link(BASE_URL, Link::TARGET_NONE, SITE_NAME));
		
		$this->render = new ErrorTemplate($obj_error_msg, $error_msg_title);
	}
}
?>
