<?php
/**
 * PHP file pages\error\error-user-ban.php
 */
/**
 * Page error-user-ban
 * URL: http://127.0.0.1/website-php/error/error-user-ban.html
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2012 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 02/02/2012
 * @version     1.0.103
 * @access      public
 * @since       1.0.103
 */

/**
 * PHP file pages\error\error-lang.php
 */
/**
 * Page error-lang
 * URL: http://127.0.0.1/website-php/error/error-lang.html
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
 * @version     1.0.89
 * @access      public
 * @since       1.0.18
 */

require_once(dirname(__FILE__)."/error-template.php");

class ErrorUserBan extends Page {
	function __construct() {}
	
	public function Load() {
		parent::$PAGE_TITLE = __(ERROR_USER_BANNED)." - ".SITE_NAME;
		parent::$PAGE_META_ROBOTS = "noindex, nofollow";
		
		$obj_error_msg = new Object(new Picture("wsp/img/warning.png", 48, 48, 0, "absmidlle"), "<br/><br/>", new Label(__(ERROR_USER_BANNED_MSG), true));
		$this->captcha_error_obj = new Object();
		$form = new Form($this);
		$this->captcha = new Captcha($form);
		$this->captcha->setFocus();
		$unblock_btn = new Button($form);
		$unblock_btn->setValue(__(ERROR_USER_BUTTON))->onClick("onClickUnblock");
		$form->setContent(new Object($this->captcha, "<br/>", $unblock_btn));
		$obj_error_msg->add("<br/><br/>", $this->captcha_error_obj, "<br/>", $form, "<br/><br/>", __(MAIN_PAGE_GO_BACK), new Link(BASE_URL, Link::TARGET_NONE, SITE_NAME));
		
		$this->render = new ErrorTemplate($obj_error_msg, __(ERROR_USER_BANNED));
	}
	
	public function onClickUnblock($sender) {
		$this->captcha_error_obj->emptyObject();
		if ($this->captcha->check()) {
			$array_wsp_banned_users = SharedMemory::get("wsp_banned_users");
			if ($array_wsp_banned_users == null) {
				$array_wsp_banned_users = array();
			}
			unset($array_wsp_banned_users[$this->getRemoteIP()]);
			SharedMemory::add("wsp_banned_users", $array_wsp_banned_users);
			
			$array_wsp_banned_users_last_access = SharedMemory::get("wsp_banned_users_last_access");
			unset($array_wsp_banned_users_last_access[$this->getRemoteIP()]);
			SharedMemory::add("wsp_banned_users_last_access", $array_wsp_banned_users_last_access);
			
			$this->refreshPage();
		} else {
			$error = new Label(__(ERROR_CAPTCHA));
			$error->setColor("red");
			$this->captcha_error_obj->add($error);
		}
	}
}
?>
