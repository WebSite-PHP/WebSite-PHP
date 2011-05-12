<?php
/**
 * PHP file pages\wsp-admin\connect.php
 */
/**
 * Page connect
 * URL: http://127.0.0.1/website-php/wsp-admin/connect.html
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
 * @version     1.0.77
 * @access      public
 * @since       1.0.25
 */

require_once(dirname(__FILE__)."/includes/utils.inc.php");
require_once(dirname(__FILE__)."/../../wsp/config/config_admin.inc.php");
define(GOOGLE_CODE_TRACKER_NOT_ACTIF, true);

class Connect extends Page {
	private $edtLogin = null;
	private $edtPassword = null;
	private $error_obj = null;
	private $btn_validate = null;
	
	private $obj_br_before = null;
	private $mod_obj = null;
	
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		require_once(dirname(__FILE__)."/includes/utils-unset-var.inc.php");
		unsetWspAdminVariables();
		
		parent::$PAGE_TITLE = __(CONNECT_PAGE_TITLE);
		$this->setUserRights("");
		
		// Welcome message
		$this->render = new Table();
		$this->render->setWidth("100%");
		
		$connect_box = new RoundBox(RoundBox::STYLE_SECOND, "connect_box", 400, 150);
		$connect_box->setShadow(true);
		$connect_box->setValign(RoundBox::VALIGN_CENTER);
		
		$connect_table = new Table();
		$connect_table->setWidth("100%")->setDefaultAlign(RowTable::ALIGN_LEFT);
		$admin_pic = new Picture("img/wsp-admin/admin_128.png", 128, 128);
		
		$form = new Form($this);
		if (extension_loaded('openssl')) {
			$form->setEncryptObject(new EncryptDataWspObject("wsp-admin connection"));
		}
		$con_table = new Table();
		
		$this->error_obj = new Object();
		$this->error_obj->setId("idErrorMsg");
		$con_table->addRow($this->error_obj)->setColspan(2)->setAlign(RowTable::ALIGN_CENTER);
		
		$this->edtLogin = new TextBox($form);
		$loginValid = new LiveValidation();
		$con_table->addRowColumns(__(LOGIN)." :&nbsp;", $this->edtLogin->setFocus()->setLiveValidation($loginValid->addValidatePresence()))->setNowrap();
		
		$this->edtPassword = new Password($form);
		$passValid = new LiveValidation();
		$con_table->addRowColumns(__(PASSWORD)." :&nbsp;", $this->edtPassword->setLiveValidation($passValid->addValidatePresence()))->setNowrap();
		
		$con_table->addRow();
		
		$this->btn_validate = new Button($form);
		$this->btn_validate->assignEnterKey()->setValue(__(BTN_VALIDATE))->onClick("connect")->setAjaxEvent();
		$con_table->addRowColumns($this->btn_validate)->setColspan(2)->setAlign(RowTable::ALIGN_CENTER);
		
		$form->setContent($con_table);
		
		$connect_table->addRowColumns($admin_pic, $form);
		$connect_box->setContent($connect_table);
		
		$this->render->addRow("<br/><br/><br/><br/><br/>");
		
		$this->obj_br_before = new Object();
		$this->obj_br_before->setId("divBrBefore");
		$this->render->addRow($this->obj_br_before);
		
		$this->mod_obj = new Object();
		$this->mod_obj->setId("divConfigRecommandation")->setWidth(400);
		$this->render->addRow($this->mod_obj);
		$this->render->addRow("");
		
		$this->render->addRow($connect_box, RowTable::ALIGN_CENTER, RowTable::VALIGN_CENTER);
		$this->render->addRow("<br/>");
	}
	
	public function Loaded() {
		$nb_mod_error = 0;
		$nb_mod = 3;
		if (strtolower(substr($_SERVER['SERVER_SOFTWARE'], 0, 6)) == "apache") {
			if(!in_array("mod_expires", apache_get_modules())) {
				$this->mod_obj->add("<li>We recomand to activate the apache mod_expires module.</li>");
				$nb_mod_error++;
			}
			if(!in_array("mod_headers", apache_get_modules())) {
				$this->mod_obj->add("<li>We recomand to activate the apache mod_headers module.</li>");
				$nb_mod_error++;
			}
			if(!in_array("mod_deflate", apache_get_modules())) {
				$this->mod_obj->add("<li>We recomand to activate the apache mod_deflate module.</li>");
				$nb_mod_error++;
			}
		}
		if (!extension_loaded('soap')) {
		    $this->mod_obj->add("<li>We recomand to install PHP lib SOAP.</li>");
			$nb_mod_error++;
		}
		if (!extension_loaded('gd') || !function_exists('imagecreatetruecolor')) {
		    $this->mod_obj->add("<li>We recomand to install PHP lib GD2.</li>");
			$nb_mod_error++;
		}
		if (!extension_loaded('curl')) {
		    $this->mod_obj->add("<li>We recomand to install PHP lib curl. (To use GoogleWeather)</li>");
			$nb_mod_error++;
		}
		$zlib_OC_is_set = preg_match('/On|(^[0-9]+$)/i', ini_get('zlib.output_compression'));
		if (!$zlib_OC_is_set) { 
			$this->mod_obj->add("<li>We recomand to configure php.ini with zlib.output_compression = On.</li>");
			$nb_mod_error++;
		}
		if ($nb_mod_error > 0) {
			$this->mod_obj->setClass("warning");
		} else {
			$this->mod_obj->setClass("");
		}
		$str_br_before = "";
		for ($i=$nb_mod_error; $i < $nb_mod; $i++) {
			$str_br_before .= "<br/>";
		}
		$this->obj_br_before->add($str_br_before);
	}
	
	public function connect() {
		list($strAdminLogin, $strAdminPasswd, $strAdminRights) = getWspUserRightsInfo($this->edtLogin->getValue());
		
		if ($strAdminLogin != "" && $strAdminLogin == $this->edtLogin->getValue() && $strAdminPasswd == sha1($this->edtPassword->getValue())) {
			$this->setUserRights($strAdminRights);
			$str_error = new Font(__(LOGIN_OK_REDIRECT));
			$this->error_obj->add($str_error->setFontColor("green"));
			$this->redirect($this->getBaseLanguageURL().WSP_ADMIN_URL."/admin.html");
		} else {
			$str_error = new Font(__(ERROR_LOGIN_PASS));
			$this->error_obj->add($str_error->setFontColor("red"));
		}
	}
}
?>
