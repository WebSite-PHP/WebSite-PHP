<?php 
/**
 * PHP file wsp\class\modules\Authentication\Authentication.class.php
 * @package modules
 * @subpackage Authentication
 */
/**
 * Class Authentication
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package modules
 * @subpackage Authentication
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 31/05/2011
 * @version     1.0.84
 * @access      public
 * @since       1.0.84
 */

class Authentication extends WebSitePhpObject {
	/**#@+
	* Authentication style
	* @access public
	* @var string
	*/
	const STYLE_1_LINE = 1;
	const STYLE_1_LINE_NO_TEXT = 2;
	const STYLE_2_LINES = 3;
	const STYLE_2_LINES_NO_TEXT = 4;
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $page_object = null;
	private $error_obj = null;
	private $login = null;
	private $password = null;
	private $connect_button = null;
	private $render = null;
	
	private $authentication_msg = true;
	private $color_ok = "green";
	private $color_error = "red";
	/**#@-*/
	
	/**
	 * Constructor Authentication
	 * @param Page $page_object 
	 * @param string $connect_method 
	 * @param mixed $style [default value: Authentication::STYLE_2_LINES]
	 * @param boolean $encrypt [default value: true]
	 * @param string $button_class 
	 * @param string $table_style 
	 */
	function __construct($page_object, $connect_method, $style=Authentication::STYLE_2_LINES, $encrypt=true, $button_class='', $table_style='') {
		parent::__construct();
		
		if (!isset($page_object) || !isset($connect_method)) {
			throw new NewException("2 arguments for ".get_class($this)."::__construct() are mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		if (gettype($page_object) != "object" || !is_subclass_of($page_object, "Page")) {
			throw new NewException("Argument page_object for ".get_class($this)."::__construct() error", 0, 8, __FILE__, __LINE__);
		}
		
		$this->page_object = $page_object;
		
		$table_main = new Table();
		$table_main->setClass($table_style);
		
		$form = new Form($this->page_object);
		if ($encrypt && extension_loaded('openssl')) {
			$form->setEncryptObject(new EncryptDataWspObject("wsp-authentication", 2048));
		}
		
		$this->error_obj = new Object();
		$this->error_obj->setId("wsp_auth_IdErrorMsg");
		
		$this->login = new TextBox($form, "wsp_auth_login");
		$login_validation = new LiveValidation();
		$this->login->setLiveValidation($login_validation->addValidatePresence()->setFieldName(__(AUTHENTICATION_LOGIN)));
		
		$this->password = new Password($form, "wsp_auth_passwd");
		$passwd_validation = new LiveValidation();
		$this->password->setLiveValidation($passwd_validation->addValidatePresence()->setFieldName(__(AUTHENTICATION_PASSWD)));
		
		$this->connect_button = new Button($form, "wsp_auth_connect", "", __(AUTHENTICATION_CONNECT));
		if ($button_class != '') {
			$this->connect_button->setClass($button_class);
		}
		$this->connect_button->assignEnterKey()->onClick($connect_method)->setAjaxEvent();
		
		if ($style == Authentication::STYLE_2_LINES) {
			$table_main->addRow($this->error_obj)->setColspan(2)->setAlign(RowTable::ALIGN_CENTER);
			
			$table_main->addRowColumns(__(AUTHENTICATION_LOGIN).":&nbsp;", $this->login->setFocus())->setColumnWidth(2, "100%")->setNowrap();
			$table_main->addRowColumns(__(AUTHENTICATION_PASSWD).":&nbsp;", $this->password)->setNowrap();
			$table_main->addRow();
			$table_main->addRow($this->connect_button)->setColspan(2);
		} else if ($style == Authentication::STYLE_2_LINES_NO_TEXT) {
			$table_main->addRow($this->error_obj)->setAlign(RowTable::ALIGN_CENTER);
			
			$this->login->setValue(__(AUTHENTICATION_LOGIN));
			$this->login->onClickJs("\$('#".$this->login->getId()."').val('');");
			$this->password->setValue(__(AUTHENTICATION_PASSWD));
			$this->password->onClickJs("\$('#".$this->password->getId()."').val('');");
			
			$table_main->addRowColumns($this->login->setFocus())->setColumnWidth(2, "100%")->setNowrap();
			$table_main->addRowColumns($this->password)->setNowrap();
			$table_main->addRow();
			$table_main->addRow($this->connect_button);
		} else if ($style == Authentication::STYLE_1_LINE) {
			$table_main->addRow($this->error_obj)->setColspan(5)->setAlign(RowTable::ALIGN_CENTER);
			
			$table_main->addRowColumns(new Object(__(AUTHENTICATION_LOGIN), ":<br/>", $this->login->setFocus()), "&nbsp;", 
										new Object(__(AUTHENTICATION_PASSWD), ":<br/>", $this->password), "&nbsp;", 
										$this->connect_button)->setNowrap();
		} else if ($style == Authentication::STYLE_1_LINE_NO_TEXT) {
			$table_main->addRow($this->error_obj)->setColspan(3)->setAlign(RowTable::ALIGN_CENTER);
			
			$this->login->setValue(__(AUTHENTICATION_LOGIN));
			$this->login->onClickJs("\$('#".$this->login->getId()."').val('');");
			$this->password->setValue(__(AUTHENTICATION_PASSWD));
			$this->password->onClickJs("\$('#".$this->password->getId()."').val('');");
			
			$table_main->addRowColumns($this->login->setFocus(), "&nbsp;", 
										 $this->password, "&nbsp;", 
										$this->connect_button)->setNowrap();
		}
		
		$form->setContent($table_main);
		$this->render = $form;
	}
	
	/**
	 * Method getLogin
	 * @access public
	 * @return mixed
	 * @since 1.0.84
	 */
	public function getLogin() {
		return $this->login->getValue();
	}
	
	/**
	 * Method getPassword
	 * @access public
	 * @return mixed
	 * @since 1.0.84
	 */
	public function getPassword() {
		return $this->passwd->getValue();
	}
	
	/**
	 * Method setAuthentificationMessage
	 * @access public
	 * @param boolean $display_msg [default value: true]
	 * @param string $color_ok [default value: green]
	 * @param string $color_error [default value: red]
	 * @return Authentication
	 * @since 1.0.84
	 */
	public function setAuthentificationMessage($display_msg=true, $color_ok='green', $color_error='red') {
		$this->authentication_msg = $display_msg;
		$this->color_ok = $color_ok;
		$this->color_error = $color_error;
		return $this;
	}
	
	/**
	 * Method wspAdminConnect
	 * @access public
	 * @param boolean $redirect [default value: true]
	 * @param string $redirect_url 
	 * @since 1.0.84
	 */
	public function wspAdminConnect($redirect=true, $redirect_url='') {
		require_once(dirname(__FILE__)."/../../../config/config_admin.inc.php");
		require_once(dirname(__FILE__)."/../../../../pages/".WSP_ADMIN_URL."/includes/utils.inc.php");
		
		list($strAdminLogin, $strAdminPasswd, $strAdminRights) = getWspUserRightsInfo($this->login->getValue());
		
		if ($strAdminLogin != "" && $strAdminLogin == $this->login->getValue() && $strAdminPasswd == sha1($this->password->getValue())) {
			$this->page_object->setUserRights($strAdminRights);
			if ($redirect) {
				if ($this->authentication_msg) {
					$str_msg = new Font(__(AUTHENTICATION_LOGIN_OK_REDIRECT));
					$this->error_obj->add($str_msg->setFontColor($this->color_ok));
				}
				if ($redirect_url == "") {
					$this->page_object->redirect($this->page_object->getBaseLanguageURL().WSP_ADMIN_URL."/admin.html");
				} else {
					$this->page_object->redirect($redirect_url);
				}
			} else if ($this->authentication_msg) {
				$str_msg = new Font(__(AUTHENTICATION_LOGIN_OK));
				$this->error_obj->add($str_msg->setFontColor($this->color_ok));
			}
		} else if ($this->authentication_msg) {
			$str_msg = new Font(__(AUTHENTICATION_ERROR_LOGIN_PASS));
			$this->error_obj->add($str_msg->setFontColor($this->color_error));
		}
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return mixed
	 * @since 1.0.84
	 */
	public function render($ajax_render=false) {
		return $this->render->render();
	}
}
?>
