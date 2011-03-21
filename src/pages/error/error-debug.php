<?php
/**
 * PHP file pages\error\error-debug.php
 */
/**
 * Page error-debug
 * URL: http://127.0.0.1/website-php/error/error-debug.html
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
 * @copyright   WebSite-PHP.com 03/10/2010
 * @version     1.0.62
 * @access      public
 * @since       1.0.18
 */

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
		
		if ($GLOBALS['__AJAX_LOAD_PAGE__'] == false) {
			$obj_error_msg->add("<a href=\"".$_GET['from_url']."\">Refresh this page</a>", "<br/><br/>");
		}
		
		$obj_error_msg->add("<b>Consult <a href=\"http://www.php.net\" target=\"_blank\">PHP</a> or <a href=\"http://www.website-php.com\" target=\"_blank\">WebSite-PHP</a> documentations.</b>", "<br/>");
		
		$obj_error_msg->add("<br/><br/>", "Go back to the main page", new Link(BASE_URL, Link::TARGET_NONE, SITE_NAME));
		
		$this->render = new ErrorTemplate($this, $obj_error_msg, "Debug error");
	}
}
?>
