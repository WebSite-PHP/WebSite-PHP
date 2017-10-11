<?php
/**
 * PHP file pages\error\error-page.php
 */
/**
 * Page error-page
 * URL: http://127.0.0.1/website-php/error/error-page.html
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2017 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 05/02/2017
 * @version     1.2.15
 * @access      public
 * @since       1.0.18
 */

require_once(dirname(__FILE__)."/error-template.php");
require_once(dirname(__FILE__)."/../../wsp/includes/utils_regexp.inc.php");

class ErrorPage extends Page {
	function __construct() {}
	
	public function Load() {
		header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
		
		parent::$PAGE_TITLE = __(ERROR_PAGE)." - ".__(SITE_NAME);
		parent::$PAGE_META_ROBOTS = "noindex, nofollow";
		
		// check if URL is not bad, but could be a good URL
		if (isset($_GET['error-redirect-url']) && $_GET['error-redirect-url'] != "") {
			$url_to_check = trim($_GET['error-redirect-url']);
		} else {
			$url_to_check = trim($this->getCurrentUrl());
		}
		
		$base_url_tmp = BASE_URL;
		if ($base_url_tmp[strlen($base_url_tmp)-1] == "/") {
			$base_url_tmp = substr($base_url_tmp, 0, strlen($base_url_tmp)-1);
		}
		$url_to_check = str_replace("%22", "\"", str_replace("%5C", "\\", str_replace("%5c", "\\", str_replace("%27", "'", $url_to_check))));
		$redirect_bad_url_to = "";
		if (preg_match("@".$base_url_tmp."([^?]*)/'(http://|https://|http:/|https:/)(.+)/'@i", $url_to_check, $matches) == 1) { // url detect with /' in the end
			$redirect_bad_url_to = $matches[3];
			$redirect_bad_url_to_http = $matches[2];
		} else if (preg_match("@".$base_url_tmp."([^?]*)/'(http://|https://|http:/|https:/)(.+)'@i", $url_to_check, $matches) == 1) { // url detect with '
			$redirect_bad_url_to = $matches[3];
			$redirect_bad_url_to_http = $matches[2];
		} else if (preg_match("@".$base_url_tmp."([^?]*)/\\\'(http://|https://|http:/|https:/)(.+)\\\'@i", $url_to_check, $matches) == 1) { // url detect with \'
			$redirect_bad_url_to = $matches[3];
			$redirect_bad_url_to_http = $matches[2];
		} else if (preg_match("@".$base_url_tmp."([^?]*)/\"(http://|https://|http:/|https:/)(.+)\"@i", $url_to_check, $matches) == 1) { // url detect with "
			$redirect_bad_url_to = $matches[3];
			$redirect_bad_url_to_http = $matches[2];
		} else if (preg_match("@".$base_url_tmp."([^?]*)/(http://|https://|http:/|https:/)(.+)@i", $url_to_check, $matches) == 1) { // url detect without no '
			$redirect_bad_url_to = $matches[3];
			$redirect_bad_url_to_http = $matches[2];
		} else if (preg_match("@".BASE_URL."combine-css/'/(.+)'@i", $url_to_check, $matches) == 1) { // combine-css url with '
			$redirect_bad_url_to = BASE_URL.$matches[1];
			$redirect_bad_url_to_http = "";
		}
		
		// check apple icon
		if ($redirect_bad_url_to == "" && find ($url_to_check, "apple-touch-icon") > 0) {
			if ($url_to_check == BASE_URL."apple-touch-icon.png" || $url_to_check == BASE_URL."apple-touch-icon-precomposed.png") {
				if (defined('SITE_META_IPHONE_IMAGE_114PX')) {
					$redirect_bad_url_to = SITE_META_IPHONE_IMAGE_114PX;
				} else if (defined('SITE_META_IPHONE_IMAGE_72PX')) {
					$redirect_bad_url_to = SITE_META_IPHONE_IMAGE_72PX;
				} else if (defined('SITE_META_IPHONE_IMAGE_57PX')) {
					$redirect_bad_url_to = SITE_META_IPHONE_IMAGE_57PX;
				}
			} else if ($url_to_check == BASE_URL."apple-touch-icon-57x57.png" || $url_to_check == BASE_URL."apple-touch-icon-57x57-precomposed.png") {
				if (defined('SITE_META_IPHONE_IMAGE_57PX')) {
					$redirect_bad_url_to = SITE_META_IPHONE_IMAGE_57PX;
				}
			}
			if ($redirect_bad_url_to != "") {
				if (strtoupper(substr($redirect_bad_url_to, 0, 7)) != "HTTP://" && strtoupper(substr($redirect_bad_url_to, 0, 8)) != "HTTPS://") {
					$redirect_bad_url_to = BASE_URL.$redirect_bad_url_to;
				}
			}
		}
		// End check if URL is not bad
		
		if ($redirect_bad_url_to != "") { // if URL is detect as bad but can be redirect to good URL
			if ($redirect_bad_url_to_http != "") {
				$redirect_bad_url_to = str_replace(":/", "", str_replace("://", "", $redirect_bad_url_to_http))."://".$redirect_bad_url_to;
			}
			$this->redirect($redirect_bad_url_to);
			
			$msg_redirect = new Label(__(REDIRECT_URL_TO, $redirect_bad_url_to, $redirect_bad_url_to));
			$this->render = new ErrorTemplate($msg_redirect, parent::$PAGE_TITLE);
			
		} else { // display the error page if the URL is correct
			$error_msg_title = "";
			$array_code_error = array(401, 403, 404, 500);
			if (in_array($_GET['error-redirect'], $array_code_error)) {
				$_SESSION['calling_page'] = "";
				$error_msg = constant("ERROR_".$_GET['error-redirect']."_MSG");
				parent::$PAGE_TITLE = constant("ERROR_".$_GET['error-redirect']."_MSG")." - ".__(SITE_NAME);
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
			$back_link = new Link(BASE_URL, Link::TARGET_NONE, __(SITE_NAME));
			$obj_error_msg->add("<br/><br/>", __(MAIN_PAGE_GO_BACK), $back_link, "<br/><br/>");
			
			$this->render = new ErrorTemplate($obj_error_msg, $error_msg_title);
			
			// check if URL is not banned
			if (!isset($_GET['banned_url'])) {
				if (file_exists(dirname(__FILE__)."/../../wsp/config/banned_url.cnf")) {
					$list_banned_url = file_get_contents(dirname(__FILE__)."/../../wsp/config/banned_url.cnf");
					$array_banned_url = explode("\n", str_replace("\r", "", $list_banned_url));
				} else {
					$array_banned_url = array();
				}
				if (find($this->getCurrentUrl(), $this->getBaseLanguageURL()) > 0) {
					$url_without_base = str_replace($this->getBaseLanguageURL(), "", $this->getCurrentUrl());
				} else {
					$url_without_base = str_replace($this->getBaseURL(), "", $this->getCurrentUrl());
				}
				if (isset($_GET['error-redirect-url']) && $_GET['error-redirect-url'] != "") {
					if (find($_GET['error-redirect-url'], $this->getBaseLanguageURL()) > 0) {
						$url_without_base = str_replace($this->getBaseLanguageURL(), "", $_GET['error-redirect-url']);
					} else {
						$url_without_base = str_replace($this->getBaseURL(), "", $_GET['error-redirect-url']);
					}
				}
				if ($url_without_base[0] != '/') {
					$url_without_base = "/".$url_without_base;
				}
				$url_without_base_array = split("\?", $url_without_base);
				$url_without_base = $url_without_base_array[0];
				if (in_array(trim($url_without_base), $array_banned_url)) {
					$_GET['banned_url'] = "true";
				}
			}
			$nb_user_bad_url_access = 0;
			if ($_GET['banned_url'] == "true" && !$this->isCrawlerBot()) {
				WspBannedVisitors::addIP($this->getRemoteIP());
				$nb_user_bad_url_access = WspBannedVisitors::getIpNbBadAccess($this->getRemoteIP());
			}
			
			// send error by mail
			if (defined('SEND_ERROR_BY_MAIL') && SEND_ERROR_BY_MAIL == true && !isLocalDebug()) {
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
					// list of files without error email
					$array_file_no_mail = array("", "crossdomain.xml", "sitemap.xml", "error-page.html", "undefined", "&", "browserconfig.xml",
												"favicon.gif", "favicon.png", "ui.item.id;", "url;", "javascript:void(0);");
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
					} else if ($this->getBrowserName() == "Firefox" && ($this->getBrowserVersion() == "3.6" || $this->getBrowserVersion() == "3.5") && 
							(substr($filename, strlen($filename)-6, 6) == "%5C%27" || substr($filename, strlen($filename)-3, 3) == "%22" || substr($filename, strlen($filename)-3, 3) == "%5C")) { 
						// Interpretation error by firefox 3.6 and 3.5
						$send_error_mail = false;
					} else if ($this->getBrowserName() == "IE" && $this->getBrowserVersion() < 7) { // Error with IE <= 6.0
						$send_error_mail = false;
					} else if ($this->getBrowserName() == "BlackBerry" && $this->getBrowserVersion() == 0) { // Error with BlackBerry version 0
						$send_error_mail = false;
					} else { // no mail for some referers (html transformed or base href not take into account)
						$array_exluded_referer = array("translate.googleusercontent.com",
														"webcache.googleusercontent.com");
						$array_referer_url = explode('/', str_replace("http://", "", str_replace("https://", "", $this->getRefererURL())));
						$base_referer_url = $array_referer_url[0];
						if (in_array($base_referer_url, $array_exluded_referer)) {
							$send_error_mail = false;
						} else { // test if there is regexp in the administrator exclude list
							for ($i=0; $i < sizeof($array_files_ex); $i++) {
								if (is_regexp($array_files_ex[$i], true)) {
									$path_or_filename = $filename;
									if (find($array_files_ex[$i], "\/") > 0) { // detect is regex on a path
										$path_or_filename = str_replace(BASE_URL, "", $current_url);
									}
									if (preg_match($array_files_ex[$i], $path_or_filename)) {
										$send_error_mail = false;
										break;
									}
								}
							}
						}
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
						$debug_mail .= "Browser : ";
						if ($this->getBrowserName() == "Default Browser") {
							$debug_mail .= $this->getBrowserUserAgent();
						} else {
							$debug_mail .= $this->getBrowserName()." (version: ".$this->getBrowserVersion().")";
						}
						$debug_mail .= "<br/>";
						$debug_mail .= "Crawler : ".($this->isCrawlerBot()?"true":"false")."<br/>";
						
						if ($_GET['banned_url'] == "true" && $nb_user_bad_url_access > 0) {
							$debug_mail .= "<br/><font color='red'>This user already tried to access to ".$nb_user_bad_url_access." forbidden URL.</font><br/>";
							$debug_mail .= "(User will be blocked with captcha code after ".MAX_BAD_URL_BEFORE_BANNED." attempts)<br/>";
						}
						
						try {
							$mail = new SmtpMail(SEND_ERROR_BY_MAIL_TO, __(SEND_ERROR_BY_MAIL_TO), "ERROR on ".__(SITE_NAME)." !!!", __($debug_mail), SMTP_MAIL, __(SMTP_NAME));
							$mail->setPriority(SmtpMail::PRIORITY_HIGH);
							$mail->send();
						} catch (Exception $e) {}
					}
			}
		}
	}
}
?>
