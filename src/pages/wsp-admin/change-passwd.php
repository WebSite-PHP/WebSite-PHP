<?php
/**
 * PHP file pages\wsp-admin\change-passwd.php
 */
/**
 * Page change-passwd
 * URL: http://127.0.0.1/website-php/wsp-admin/change-passwd.html
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
 * @since       1.0.25
 */

require_once(dirname(__FILE__)."/includes/utils-users.inc.php");
require_once(dirname(__FILE__)."/../../lang/".$_SESSION['lang']."/wsp-admin/all.inc.php");

class ChangePasswd extends Page {
	protected $USER_RIGHTS = Page::RIGHTS_ADMINISTRATOR;
	protected $USER_NO_RIGHTS_REDIRECT = "wsp-admin/connect.html";
	
	private $edt_old_passwd = null;
	private $edt_new_passwd = null;
	private $edt_confirm_passwd = null;
	private $validate_btn = null;
	
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		parent::$PAGE_TITLE = __(CHANGE_PASSWD);
		
		$form = new Form($this, "Form_change_passwd");
		if (extension_loaded('openssl')) {
			//$form->setEncryptObject(new EncryptDataWspObject("change wsp password", 2048));
		}
		$table = new Table();
		
		$table->addRow();
		
		$this->edt_old_passwd = new Password($form, "wsp_old_password");
		$this->edt_old_passwd->setFocus();
		$live_validation = new LiveValidation();
		$live_validation->addValidatePresence()->setFieldName(__(OLD_PASSWD));
		$table->addRowColumns(__(OLD_PASSWD)." :&nbsp;", $this->edt_old_passwd->setLiveValidation($live_validation))->setStyle("color:black;");
		
		$this->edt_new_passwd = new Password($form, "wsp_new_password");
		$live_validation = new LiveValidation();
		$live_validation->addValidatePresence()->setFieldName(__(NEW_PASSWD));
		$table->addRowColumns(__(NEW_PASSWD)." :&nbsp;", $this->edt_new_passwd->setLiveValidation($live_validation))->setStyle("color:black;");
		
		$this->edt_confirm_passwd = new Password($form, "wsp_confirm_password");
		$live_validation = new LiveValidation();
		$live_validation->addValidatePresence()->setFieldName(__(CONFIRM_PASSWD));
		$live_validation->addValidateConfirmation("wsp_new_password");
		$table->addRowColumns(__(CONFIRM_PASSWD)." :&nbsp;", $this->edt_confirm_passwd->setLiveValidation($live_validation))->setStyle("color:black;");
		
		$table->addRow();
		
		$this->validate_btn = new Button($form);
		$this->validate_btn->setValue(__(CHANGE_PASSWD))->onClick("onChangePasswd")->setAjaxEvent();
		$table->addRow($this->validate_btn)->setColspan(2)->setAlign(RowTable::ALIGN_CENTER);
		
		$table->addRow();
		
		$form->setContent($table);
		
		$table = new Table();
		$table->setWidth("100%");
		$table->addRow($form, RowTable::ALIGN_CENTER);
		
		$this->render = $table;
	}
	
	public function onChangePasswd() {
		if ($this->edt_new_passwd->getValue() != "" && $this->edt_new_passwd->getValue() != "admin" && $this->edt_new_passwd->getValue() == $this->edt_confirm_passwd->getValue()) {
			if (changeWspUser("admin", $this->edt_old_passwd->getValue(), $this->edt_new_passwd->getValue(), "administrator")) {
				$this->addObject(DialogBox::closeAll());
				$result_dialogbox = new DialogBox(__(CHANGE_PASSWD), __(CHANGE_PASSWD_CONGRATULATION));
			} else {
				$result_dialogbox = new DialogBox(__(CHANGE_PASSWD), __(CHANGE_PASSWD_ERROR));
			}
		} else {
			$result_dialogbox = new DialogBox(__(CHANGE_PASSWD), __(CHANGE_PASSWD_ERROR));
		}
		$result_dialogbox->activateCloseButton();
		$this->addObject($result_dialogbox);
	}
}
?>
