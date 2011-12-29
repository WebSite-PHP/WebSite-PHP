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
 * @version     1.0.101
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
			if ($_SESSION['calling_page'] == "error-page") {
				if (isset($_GET['error-redirect-url']) && $_GET['error-redirect-url'] != "") {
					$error_msg = __(ERROR_PAGE_MSG, $_GET['error-redirect-url']);
				} else if ($this->getRefererURL() != "") {
					$error_msg = __(ERROR_PAGE_MSG, $this->getRefererURL());
				} else {
					$error_msg = __(ERROR_PAGE_MSG, "");
				}
			} else {
				$error_msg = __(ERROR_PAGE_MSG, $_SESSION['calling_page']);
			}
			$error_msg_title = __(ERROR_PAGE);
		}
		
		$error_msg = new Label($error_msg, true);
		$obj_error_msg = new Object(new Picture("wsp/img/warning.png", 48, 48, 0, "absmidlle"), "<br/>", $error_msg->setColor("red"));
		$obj_error_msg->add("<br/><br/>", __(MAIN_PAGE_GO_BACK), new Link(BASE_URL, Link::TARGET_NONE, SITE_NAME));
		
		$this->render = new ErrorTemplate($obj_error_msg, $error_msg_title);
		
		if (defined('SEND_ERROR_BY_MAIL') && SEND_ERROR_BY_MAIL == true &&
			find(BASE_URL, "127.0.0.1/", 0, 0) == 0 && find(BASE_URL, "localhost/", 0, 0) == 0) {
				$send_error_mail = true;
				
				// Check if we have enougth information to send a mail
				if (in_array($_GET['error-redirect'], $array_code_error)) {
					if ($this->getRefererURL() == "") {
						if (!isset($_GET['error-redirect-referer']) || $_GET['error-redirect-referer'] == "") {
							if (!isset($_GET['error-redirect-url']) || $_GET['error-redirect-url'] == "") {
								$send_error_mail = false; // not enougth information to treat the error
							}
						}
					}
				}
				
				// Check if file need to send a mail
				$array_files_ex = array();
				$array_file_no_mail = array("", "crossdomain.xml", "sitemap.xml", "error-page.html");
				if (defined('SEND_BY_MAIL_FILE_EX') && SEND_BY_MAIL_FILE_EX != "") {
					$array_files_ex = explode(',', SEND_BY_MAIL_FILE_EX);
				}
				$array_file_no_mail = array_merge($array_file_no_mail, $array_files_ex);
				if (isset($_GET['error-redirect-url']) && $_GET['error-redirect-url'] != "") {
					$tmp_current_url = explode('?', $_GET['error-redirect-url']);
				} else {
					$tmp_current_url = explode('?', $this->getCurrentUrl());
				}
				$current_url = $tmp_current_url[0];
				$array_current_url = explode('/', $current_url);
				$filename = $array_current_url[sizeof($array_current_url)-1];
				if (in_array($filename, $array_file_no_mail)) {
					$send_error_mail = false;
				} else if ($this->getBrowserName() == "Firefox" && $this->getBrowserVersion() == "3.6" && 
									substr($filename, strlen($filename)-6, 6) == "%5C%27") { // Error with firefox 3.6
					$send_error_mail = false;
				}
				
				// send mail
				if ($send_error_mail) {
					$debug_mail = $error_msg->render();
					$debug_mail .= "<br/><br/><b>General information:</b><br/>";
					if (isset($_GET['error-redirect-url']) && $_GET['error-redirect-url'] != "") {
						$debug_mail .= "URL : ".$_GET['error-redirect-url']."<br/>";
					} else {
						$debug_mail .= "URL : ".$this->getCurrentUrl()."<br/>";
					}
					if (isset($_GET['error-redirect-referer']) && $_GET['error-redirect-referer'] != "") {
						$debug_mail .= "Referer : ".$_GET['error-redirect-referer']."<br/>";
					} else {
						$debug_mail .= "Referer : ".$this->getRefererURL()."<br/>";
					}
					$debug_mail .= "IP : <a href='http://www.infosniper.net/index.php?ip_address=".$this->getRemoteIP()."' target='_blank'>".$this->getRemoteIP()."</a><br/>";
					$debug_mail .= "Browser : ".$this->getBrowserName()." (version: ".$this->getBrowserVersion().")<br/>";
					$debug_mail .= "Crawler : ".($this->isCrawlerBot()?"true":"false")."<br/>";
					
					try {
						$mail = new SmtpMail(SEND_ERROR_BY_MAIL_TO, SEND_ERROR_BY_MAIL_TO, "ERROR on ".SITE_NAME." !!!", $debug_mail, SMTP_MAIL, SMTP_NAME);
						$mail->setPriority(SmtpMail::PRIORITY_HIGH);
						$mail->send();
					} catch (Exception $e) {}
				}
		}
	}
}
?>
