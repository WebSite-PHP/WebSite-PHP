<?php
/**
 * PHP file pages\error\error-debug.php
 */
/**
 * Page error-debug
 * URL: http://127.0.0.1/website-php/error/error-debug.html
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
 * @since       1.0.18
 */

require_once(dirname(__FILE__)."/error-template.php");

class ErrorDebug extends Page {
	private $is_trace = false;
	
	function __construct($is_trace=true) {
		$this->is_trace = $is_trace;
	}
	
	public function Load() {
		if (defined('SEND_ERROR_BY_MAIL') && SEND_ERROR_BY_MAIL == true && !isLocalDebug()) {
				if ($this->is_trace) {// standard msg "administrator is notified"
					parent::$PAGE_TITLE = __(ERROR)." - ".__(SITE_NAME);
					$box_title = __(ERROR);
					$debug_msg = __(ERROR_DEBUG_MAIL_SENT);
				} else {  // no trace in the debug information
					parent::$PAGE_TITLE = "Debug error - ".__(SITE_NAME);
					$box_title = "Debug error";
					$debug_msg = $_POST['debug'];
				}
		} else {
			parent::$PAGE_TITLE = "Debug error - ".__(SITE_NAME);
			$box_title = "Debug error";
			$debug_msg = $_POST['debug'];
		}
		
		$error_title_table = new Table();
		$error_title_table->addRowColumns(new Picture("wsp/img/warning.png", 48, 48, 0, "absmidlle"), "&nbsp;", new Label(__(ERROR), true));
		$obj_error_msg = new Object($error_title_table, "<br/>");
		$debug_obj = new Object(utf8encode($debug_msg));
		$debug_obj->setAlign(Object::ALIGN_LEFT);
		$debug_obj->setWidth("80%");
		$obj_error_msg->add($debug_obj, "<br/><br/>");
		
		if ($GLOBALS['__AJAX_LOAD_PAGE__'] == false) {
			$obj_error_msg->add("<a href=\"".$_GET['from_url']."\">Refresh this page</a>", "<br/><br/>");
		}
		
		$obj_error_msg->add("<b>Consult <a href=\"http://www.php.net\" target=\"_blank\">PHP</a> or <a href=\"http://www.website-php.com\" target=\"_blank\">WebSite-PHP</a> documentations.</b>", "<br/>");
		
		$obj_error_msg->add("<br/><br/>", "Go back to the main page", new Link(BASE_URL, Link::TARGET_NONE, __(SITE_NAME)));
		
		$this->render = new ErrorTemplate($obj_error_msg, $box_title);
		
		if (trim($_POST['debug']) != "") {
			$cache_filename = "";
			if (isset($_POST['cache_filename']) && trim($_POST['cache_filename']) != "") {
				$cache_filename = $this->getRealCacheFileName($_POST['cache_filename']);
				if (!file_exists($cache_filename)) {
					$cache_filename = "";
				}
			}
			NewException::sendErrorByMail($_POST['debug'], $cache_filename);
		}
	}
}
?>
