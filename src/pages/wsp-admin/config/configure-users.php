<?php
/**
 * PHP file pages\wsp-admin\config\configure-users.php
 */
/**
 * Content of the Page configure-users
 * URL: http://127.0.0.1/website-php-install/wsp-admin/config/configure-users.html
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2016 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 11/05/2016
 * @version     1.2.14
 * @access      public
 * @since       1.0.85
 */

require_once(dirname(__FILE__)."/../includes/admin-template-form.inc.php");

class ConfigureUsers extends Page {
	protected $USER_RIGHTS = Page::RIGHTS_ADMINISTRATOR;
	protected $USER_NO_RIGHTS_REDIRECT = "wsp-admin/admin.html";
	
	private $result_obj = null;
	private $edt_login = null;
	private $cmb_rights = null;
	private $edt_password = null;
	private $edt_old_password = null;
	private $edt_confirm_passwd = null;
	private $validate_btn = null;
	private $modify_btn = null;
	private $cancel_btn = null;
	private $users_table_obj = null;
	
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		parent::$PAGE_TITLE = __(CONFIGURE_USERS);
		
		$config_users_obj = new Object("<br/>");
		
		$this->result_obj = new Object();
		$this->result_obj->setId("page_result_area");
		$config_users_obj->add($this->result_obj);
		
		$this->users_table_obj = new Object();
		$this->users_table_obj->setId("users_table_obj");
		$config_users_obj->add($this->users_table_obj, "<br/><br/>");
		
		$user_table = new Table();
		$form = new Form($this);
		if (extension_loaded('openssl')) {
			$form->setEncryptObject(new EncryptDataWspObject());
		}
		
		$this->edt_login = new TextBox($form);
		$validation = new LiveValidation();
		$user_table->addRowColumns(__(LOGIN).":&nbsp;", $this->edt_login->setLiveValidation($validation->addValidatePresence()));
		
		$this->cmb_rights = new ComboBox($form);
		$this->cmb_rights->addItem(Page::RIGHTS_ADMINISTRATOR, "Administrator");
		$this->cmb_rights->addItem(Page::RIGHTS_MODERATOR, "Moderator");
		$this->cmb_rights->addItem(Page::RIGHTS_TRANSLATOR, "Translator");
		$this->cmb_rights->addItem(Page::RIGHTS_DEVELOPER, "Developer");
		$this->cmb_rights->addItem(Page::RIGHTS_AUTH_USER, "Authentificated user");
		$this->cmb_rights->addItem(Page::RIGHTS_GUEST, "Guest");
		$user_table->addRowColumns(__(RIGHTS).":&nbsp;", $this->cmb_rights);
		
		$this->edt_old_password = new Password($form);
		$validation = new LiveValidation();
		$this->old_passwd_row = $user_table->addRowColumns(__(OLD_PASSWORD).":&nbsp;", $this->edt_old_password->setLiveValidation($validation->addValidatePresence()->setFieldName(__(OLD_PASSWORD))));
		$this->old_passwd_row->setId("old_passwd_row");
				
		$this->edt_password = new Password($form);
		$validation = new LiveValidation();
		$user_table->addRowColumns(__(PASSWORD).":&nbsp;", $this->edt_password->setLiveValidation($validation->addValidatePresence()->setFieldName(__(PASSWORD))));
		
		$this->edt_confirm_passwd = new Password($form);
		$live_validation = new LiveValidation();
		$live_validation->addValidatePresence()->setFieldName(__(CONFIRM_PASSWD));
		$live_validation->addValidateConfirmation($this->edt_password->getId());
		$user_table->addRowColumns(__(CONFIRM_PASSWD)." :&nbsp;", $this->edt_confirm_passwd->setLiveValidation($live_validation))->setStyle("color:black;");
		
		$user_table->addRow();
		
		$this->validate_btn = new Button($form);
		$this->validate_btn->setValue(__(ADD))->onClick("addWspUser")->setAjaxEvent()->disableAjaxWaitMessage()->assignEnterKey();
		
		$this->modify_btn = new Button($form);
		$this->modify_btn->setValue(__(SAVE))->onClick("changeWspUser")->setAjaxEvent()->disableAjaxWaitMessage()->assignEnterKey();
		
		$this->cancel_btn = new Button($this);
		$this->cancel_btn->setValue(__(CANCEL))->onClick("refresh")->setAjaxEvent()->disableAjaxWaitMessage();
		
		$modif_btn_table = new Table();
		$modif_btn_table->addRowColumns($this->validate_btn, "&nbsp;", $this->modify_btn, "&nbsp;", $this->cancel_btn);
		$user_table->addRow($modif_btn_table)->setColspan(2)->setAlign(RowTable::ALIGN_CENTER);
		
		$config_users_obj->add($form->setContent($user_table), "<br/><br/>");
		
		$this->render = new AdminTemplateForm($this, $config_users_obj);
	}
	
	public function Loaded() {
		$users_table = new Table();
		$users_table->setId("users_table")->activateAdvanceTable()->activateSort(1)->setWidth(400);
		$users_table->addRowColumns(__(LOGIN), __(RIGHTS), __(MODIFY), __(DELETE))->setHeaderClass(0);
		
		$this->old_passwd_row->hide();
		$this->validate_btn->show();
		$this->modify_btn->hide();
		$this->cancel_btn->hide();
		
		$is_modify_mode = false;
		$array_users = getAllWspUsers();
		for ($i=0; $i < sizeof($array_users); $i++) {
			$edit_user = new Picture("img/wsp-admin/edit_16.png", 16, 16);
			$edit_user->onClick($this, "refresh")->setAjaxEvent()->disableAjaxWaitMessage();
			if ($edit_user->isClicked() && !$is_modify_mode) {
				$this->old_passwd_row->show();
				$this->validate_btn->hide();
				$this->modify_btn->show();
				$this->cancel_btn->show();
				
				$this->edt_login->setValue($array_users[$i]['login']);
				$this->edt_old_password->forceEmpty();
				$this->edt_password->forceEmpty();
				$this->edt_confirm_passwd->forceEmpty();
				
				$is_modify_mode = true;
			}
			if ($array_users[$i]['login'] == $_SESSION['wsp-login']) {
				$del_user = new Object();
			} else {
				$del_user = new Picture("img/wsp-admin/delete_16.png", 16, 16);
				$del_user->setId("user_".$array_users[$i]['login']);
				$del_user->onClickJs("if (!confirm('".__(DEL_CONFIRM)."')) { return false; }");
				$del_user->onClick($this, "removeWspUser", $array_users[$i]['login'])->setAjaxEvent();
				if ($del_user->isClicked()) {
					continue;
				}
			}
			$users_table->addRowColumns($array_users[$i]['login'], $array_users[$i]['rights'], $edit_user, $del_user)->setColumnAlign(3, RowTable::ALIGN_CENTER)->setColumnAlign(4, RowTable::ALIGN_CENTER);
		}
		$this->users_table_obj->emptyObject();
		$this->users_table_obj->add($users_table);
	}
	
	public function addWspUser($sender) {
		$this->result_obj->emptyObject();
		if (changeWspUser($this->edt_login->getValue(), $this->edt_password->getValue(), $this->edt_confirm_passwd->getValue(), $this->cmb_rights->getValue(), true)) {
			$this->result_obj->setClass("success");
			$this->result_obj->add(__(ADD_USER_OK, $this->edt_login->getValue()));
		} else {
			$this->result_obj->setClass("error");
			$this->result_obj->add(__(ADD_USER_NOT_OK, $this->edt_login->getValue()));
		}
	}

	public function refresh($sender) { }
	
	public function changeWspUser($sender) {
		$this->result_obj->emptyObject();
		if ($this->edt_login->getValue() != "") {
			if (changeWspUser($this->edt_login->getValue(), $this->edt_old_password->getValue(), $this->edt_password->getValue(), $this->cmb_rights->getValue())) {
				$this->result_obj->setClass("success");
				$this->result_obj->add(__(MODIF_USER_OK, $this->edt_login->getValue()));
			} else {
				$this->result_obj->setClass("error");
				$this->result_obj->add(__(MODIF_USER_NOT_OK, $this->edt_login->getValue()));
			}
		} else {
			$this->result_obj->setClass("error");
			$this->result_obj->add(__(MODIF_USER_NOT_OK, $this->edt_login->getValue()));
		}
	}
	
	public function removeWspUser($sender, $login) {
		$this->result_obj->emptyObject();
		if ($login != $_SESSION['wsp-login']) {
			if (changeWspUser($login, "", "", "", false, true)) {
				$this->result_obj->setClass("success");
				$this->result_obj->add(__(DEL_USER_OK, $login));
			} else {
				$this->result_obj->setClass("error");
				$this->result_obj->add(__(DEL_USER_NOT_OK, $login));
			}
		} else {
			$this->result_obj->setClass("error");
			$this->result_obj->add(__(DEL_USER_NOT_OK, $login));
		}
	}
}
?>
