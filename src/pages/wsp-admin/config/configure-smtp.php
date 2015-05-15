<?php
/**
 * PHP file pages\wsp-admin\config\configure-smtp.php
 */
/**
 * Content of the Page configure-smtp
 * URL: http://127.0.0.1/website-php-install/wsp-admin/config/configure-smtp.html
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

require_once(dirname(__FILE__)."/../includes/admin-template-form.inc.php");

class ConfigureSmtp extends Page {
	protected $USER_RIGHTS = Page::RIGHTS_ADMINISTRATOR;
	protected $USER_NO_RIGHTS_REDIRECT = "wsp-admin/admin.html";
	
	private $edtHost = null;
	private $edtPort = null;
	private $edtName = null;
	private $edtMail = null;
	private $cmbAuth = null;
	private $edtUser = null;
	private $edtPassword = null;
	
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		parent::$PAGE_TITLE = __(CONFIGURE_SMTP);
		
		// Admin
		$form = new Form($this);
		
		$table_form = new Table();
		$table_form->addRow();
		
		$this->edtHost = new TextBox($form);
		$this->edtHost->setValue(SMTP_HOST);
		$edtHostValidation = new LiveValidation();
		$table_form->addRowColumns(__(EDT_HOST).":&nbsp;", $this->edtHost->setLiveValidation($edtHostValidation->addValidatePresence()->setFieldName(__(EDT_HOST))), "&nbsp;(ssl://smtp.gmail.com)");
		
		$this->edtPort = new TextBox($form);
		$this->edtPort->setValue(SMTP_PORT);
		$edtPortValidation = new LiveValidation();
		$table_form->addRowColumns(__(EDT_PORT).":&nbsp;", $this->edtPort->setLiveValidation($edtPortValidation->addValidateNumericality(true)->setFieldName(__(EDT_PORT))), "&nbsp;(465)");
		
		$this->edtName = new TextBox($form);
		$this->edtName->setValue(utf8encode(SMTP_NAME));
		$edtNameValidation = new LiveValidation();
		$table_form->addRowColumns(__(EDT_NAME).":&nbsp;", $this->edtName->setLiveValidation($edtNameValidation->addValidatePresence()->setFieldName(__(EDT_NAME))), "&nbsp;(Robert Francis)");
		
		$this->edtMail = new TextBox($form);
		$this->edtMail->setValue(SMTP_MAIL);
		$edtMailValidation = new LiveValidation();
		$table_form->addRowColumns(__(EDT_MAIL).":&nbsp;", $this->edtMail->setLiveValidation($edtMailValidation->addValidatePresence()->addValidateEmail()->setFieldName(__(EDT_MAIL))), "&nbsp;(robert.francis@gmail.com)");
		
		$this->cmbAuth = new ComboBox($form);
		$this->cmbAuth->addItem("false", __(DESACTIVATE), (SMTP_AUTH==false)?true:false)->addItem("true", __(ACTIVATE), (SMTP_AUTH==true)?true:false)->setWidth(143)->onChange("changeCmbAuth")->setAjaxEvent()->disableAjaxWaitMessage();
		$table_form->addRowColumns(__(CMB_AUTH).":&nbsp;", $this->cmbAuth, "&nbsp;(".__(ACTIVATE).")");
		
		$this->edtUser = new TextBox($form);
		$this->edtUser->setValue(SMTP_USER);
		if (SMTP_AUTH == false) {
			$this->edtUser->disable();
		}
		$table_form->addRowColumns(__(EDT_USER).":&nbsp;", $this->edtUser, "&nbsp;(robert.francis@gmail.com)");
		
		$this->edtPassword = new Password($form);
		$this->edtPassword->setValue(SMTP_PASS);
		if (SMTP_AUTH == false) {
			$this->edtPassword->disable();
		}
		$table_form->addRowColumns(__(EDT_PASS).":&nbsp;", $this->edtPassword, "&nbsp;(*********)");
		
		$table_form->addRow();
		
		$btnValidate = new Button($form);
		$btnValidate->setValue(__(BTN_VALIDATE))->onClick("configureSmtp")->setAjaxEvent();
		$table_form->addRowColumns($btnValidate)->setColumnColspan(1, 3)->setColumnAlign(1, RowTable::ALIGN_CENTER);
		
		$table_form->addRow();
		
		$form->setContent($table_form);
		$this->render = new AdminTemplateForm($this, $form);
	}
	
	public function configureSmtp() {
		$data_config_file = "<?php\n";
		$data_config_file .= "define(\"SMTP_HOST\", \"".$this->edtHost->getValue()."\"); 	// gmail : ssl://smtp.gmail.com\n";
		$data_config_file .= "define(\"SMTP_PORT\", ".$this->edtPort->getValue()."); 						// default : 25, gmail : 465\n\n";
		$data_config_file .= "define(\"SMTP_NAME\", \"".$this->edtName->getValue()."\"); // Webmaster name\n";
		$data_config_file .= "define(\"SMTP_MAIL\", \"".$this->edtMail->getValue()."\"); // Webmaster user (link with SMTP)\n\n";
		$data_config_file .= "define(\"SMTP_AUTH\", ".$this->cmbAuth->getValue()."); // true or false, gmail : true\n";
		$data_config_file .= "define(\"SMTP_USER\", \"".$this->edtUser->getValue()."\"); // gmail : yourmail@gmail.com\n";
		$data_config_file .= "define(\"SMTP_PASS\", \"".$this->edtPassword->getValue()."\"); // gmail : yourpassword\n";
		$data_config_file .= "?>";
		
		$config_file = new File(dirname(__FILE__)."/../../../wsp/config/config_smtp.inc.php", false, true);
		if ($config_file->write($data_config_file)){
			$config_ok = true;
		}
		$config_file->close();
		
		if ($config_ok) {
			$result_dialogbox = new DialogBox(__(CONFIG_FILE), __(CONFIG_FILE_OK));
		} else {
			$result_dialogbox = new DialogBox(__(CONFIG_FILE), __(CONFIG_FILE_NOT_OK));
		}
		$result_dialogbox->activateCloseButton();
		$this->addObject($result_dialogbox);
	}
	
	public function changeCmbAuth($sender) {
		if ($this->cmbAuth->getValue() == "true") {
			$this->edtUser->enable();
			$this->edtPassword->enable();
		} else {
			$this->edtUser->setValue("");
			$this->edtUser->disable();
			$this->edtPassword->setValue("");
			$this->edtPassword->disable();
		}
	}
}
?>
