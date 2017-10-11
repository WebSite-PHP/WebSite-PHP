<?php
/**
 * PHP file pages\error\error-user-ban.php
 */
/**
 * Page error-user-ban
 * URL: http://127.0.0.1/website-php/error/error-user-ban.html
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
 * @since       1.0.103
 */

require_once(dirname(__FILE__)."/error-template.php");

class ErrorUserBan extends Page {
	function __construct() {}
	
	public function Load() {
		parent::$PAGE_TITLE = __(ERROR_USER_BANNED)." - ".__(SITE_NAME);
		parent::$PAGE_META_ROBOTS = "noindex, nofollow";
		
		$can_use_captacha = true;
		if (WspBannedVisitors::isBannedIp($this->getRemoteIP())) {
			$last_access = new DateTime(WspBannedVisitors::getBannedIpLastAccess($this->getRemoteIP()));
			$duration = WspBannedVisitors::getBannedIpDuration($this->getRemoteIP());
			$dte_ban = $last_access->modify("+".$duration." seconds");
			
			if ($dte_ban > new DateTime()) {
				$can_use_captacha = false;
			}
		}
	
		$obj_error_msg = new Object(new Picture("wsp/img/warning.png", 48, 48, 0, "absmidlle"), "<br/><br/>");
		$obj_error_msg->add(new Label(__(ERROR_USER_BANNED_MSG_1), true), "<br/>");
		if ($can_use_captacha) {
			$obj_error_msg->add(new Label(__(ERROR_USER_BANNED_MSG_2), true), "<br/><br/>");
			$this->captcha_error_obj = new Object();
			$form = new Form($this);
			$this->captcha = new Captcha($form);
			$this->captcha->setFocus();
			$unblock_btn = new Button($form);
			$unblock_btn->setValue(__(ERROR_USER_BUTTON))->onClick("onClickUnblock");
			$form->setContent(new Object($this->captcha, "<br/>", $unblock_btn));
			$obj_error_msg->add($this->captcha_error_obj, "<br/>", $form);
		}
		$back_link = new Link(BASE_URL, Link::TARGET_NONE, __(SITE_NAME));
		$obj_error_msg->add("<br/><br/>", __(MAIN_PAGE_GO_BACK), $back_link, "<br/><br/>");
		
		$this->render = new ErrorTemplate($obj_error_msg, __(ERROR_USER_BANNED));
	}
	
	public function onClickUnblock($sender) {
		$this->captcha_error_obj->emptyObject();
		if ($this->captcha->check()) {
			WspBannedVisitors::resetBannedIP($this->getRemoteIP());
                        WspBannedVisitors::resetBannedIP($_SERVER["REMOTE_ADDR"]); // To be sure (case of proxy)
			$this->refreshPage();
		} else {
			$error = new Label(__(ERROR_CAPTCHA));
			$error->setColor("red");
			$this->captcha_error_obj->add($error);
		}
	}
}
?>
