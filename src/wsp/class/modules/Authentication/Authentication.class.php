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
 * Copyright (c) 2009-2012 WebSite-PHP.com
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
 * @version     1.1.2
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
	private $authentication_msg = true;
	private $color_ok = "#00FF33";
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
			throw new NewException("2 arguments for ".get_class($this)."::__construct() are mandatory", 0, getDebugBacktrace(1));
		}
		
		if (gettype($page_object) != "object" || !is_subclass_of($page_object, "Page")) {
			throw new NewException("Argument page_object for ".get_class($this)."::__construct() error", 0, getDebugBacktrace(1));
		}
		
		$this->page_object = $page_object;
		
		$table_main = new Table();
		$table_main->setClass($table_style);
		
		$form = new Form($this->page_object);
		if ($encrypt && extension_loaded('openssl')) {
			$form->setEncryptObject(new EncryptDataWspObject("wsp-authentication"));
		}
		
		$this->error_obj = new Object();
		$this->error_obj->setId("wsp_auth_IdErrorMsg");
		
		$this->login = new TextBox($form, "wsp_auth_login");
		$login_validation = new LiveValidation();
		$this->login->setLiveValidation($login_validation->addValidatePresence()->setFieldName(__(AUTHENTICATION_LOGIN)));
		$this->login->setFocus()->setStripTags();
		
		$this->password = new Password($form, "wsp_auth_passwd");
		$passwd_validation = new LiveValidation();
		$this->password->setLiveValidation($passwd_validation->addValidatePresence()->setFieldName(__(AUTHENTICATION_PASSWD)));
		$this->password->setStripTags();
		
		$this->connect_button = new Button($form, "wsp_auth_connect", "", __(AUTHENTICATION_CONNECT));
		if ($button_class != '') {
			$this->connect_button->setClass($button_class);
		}
		$this->connect_button->assignEnterKey()->onClick($connect_method)->setAjaxEvent();
		
		if ($style == Authentication::STYLE_2_LINES) {
			$table_main->addRow($this->error_obj)->setColspan(2)->setAlign(RowTable::ALIGN_CENTER);
			
			$table_main->addRowColumns(__(AUTHENTICATION_LOGIN).":&nbsp;", $this->login)->setColumnWidth(2, "100%")->setNowrap();
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
		
		$this->hdnReferer = new Hidden($form, "wsp_auth_referer");
		if (isset($_GET['referer'])) {
			$this->hdnReferer->setValue(trim($_GET['referer']));
		}
		
		$form->setContent(new Object($table_main, $this->hdnReferer));
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
	 * Method getReferer
	 * @access public
	 * @return mixed
	 * @since 1.0.100
	 */
	public function getReferer() {
		return $this->hdnReferer->getValue();
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
	 * @param string $redirect_url [default value: REFERER]
	 * @since 1.0.84
	 */
	public function wspAdminConnect($redirect=true, $redirect_url='REFERER') {
		require_once(dirname(__FILE__)."/../../../config/config_admin.inc.php");
		require_once(dirname(__FILE__)."/../../../../pages/".WSP_ADMIN_URL."/includes/utils-users.inc.php");
		
		list($strAdminLogin, $strAdminPasswd, $strAdminRights) = getWspUserRightsInfo($this->login->getValue());
		
		if ($strAdminLogin != "" && $strAdminLogin == $this->login->getValue() && $strAdminPasswd == sha1($this->password->getValue())) {
			$this->page_object->setUserRights($strAdminRights);
			$_SESSION['wsp-login'] = $this->login->getValue();
			if ($redirect) {
				if ($this->authentication_msg) {
					$str_msg = new Label(__(AUTHENTICATION_LOGIN_OK_REDIRECT));
					$str_msg->setStyle("text-shadow:#888888 1px 1px 1px;");
					$this->error_obj->add($str_msg->setColor($this->color_ok));
				}
				if ($redirect_url == "") {
					$this->page_object->redirect($this->page_object->getBaseLanguageURL().WSP_ADMIN_URL."/admin.html");
				} else if (strtoupper($redirect_url) == "REFERER") {
					if ($this->hdnReferer->getValue() != "") {
						$this->page_object->redirect($this->hdnReferer->getValue());
					} else {
						$this->page_object->redirect($this->page_object->getBaseLanguageURL().WSP_ADMIN_URL."/admin.html");
					}
				} else {
					$this->page_object->redirect($redirect_url);
				}
			} else if ($this->authentication_msg) {
				$str_msg = new Label(__(AUTHENTICATION_LOGIN_OK));
				$str_msg->setStyle("text-shadow:#888888 1px 1px 1px;");
				$this->error_obj->add($str_msg->setColor($this->color_ok));
			}
		} else if ($this->authentication_msg) {
			$str_msg = new Label(__(AUTHENTICATION_ERROR_LOGIN_PASS));
			$str_msg->setStyle("text-shadow:#888888 1px 1px 1px;");
			$this->error_obj->add($str_msg->setColor($this->color_error));
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
