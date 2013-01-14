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
 * Copyright (c) 2009-2013 WebSite-PHP.com
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
 * @version     1.2.0
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
	private $connect_method = "connect";
	private $style=Authentication::STYLE_2_LINES;
	private $encrypt=true;
	private $button_class='';
	private $table_style='';
	private $input_width = 150;
	private $table_width = "";
	
	protected $authentication_msg = true;
	protected $color_ok = "#00FF33";
	protected $color_error = "red";
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
		require_once(dirname(__FILE__)."/../../../config/config_admin.inc.php");
		
		if (!isset($page_object) || !isset($connect_method)) {
			$nb_argument = 2;
			throw new NewException($nb_argument." arguments for ".get_class($this)."::__construct() are mandatory", 0, getDebugBacktrace(1));
		}
		
		if (gettype($page_object) != "object" || !is_subclass_of($page_object, "Page")) {
			throw new NewException("Argument page_object for ".get_class($this)."::__construct() error", 0, getDebugBacktrace(1));
		}
		
		$this->page_object = $page_object;
		$this->connect_method = $connect_method;
		$this->style = $style;
		$this->encrypt = $encrypt;
		$this->button_class = $button_class;
		$this->table_style = $table_style;
		
		$this->createRender();
	}
	
	/**
	 * Method setStyle
	 * @access public
	 * @param mixed $style [default value: Authentication::STYLE_2_LINES]
	 * @return Authentication
	 * @since 1.1.11
	 */
	public function setStyle($style=Authentication::STYLE_2_LINES) {
		$this->style = $style;
		
		$this->createRender(false);
		return $this;
	}
	
	/**
	 * Method setEncrypt
	 * @access public
	 * @param boolean $encrypt [default value: true]
	 * @return Authentication
	 * @since 1.1.11
	 */
	public function setEncrypt($encrypt=true) {
		$this->encrypt = $encrypt;
		
		$this->createRender(false);
		return $this;
	}

	/**
	 * Method setButtonClass
	 * @access public
	 * @return Authentication
	 * @since 1.1.11
	 */
	public function setButtonClass() {
		$this->button_class = $button_class;
		
		$this->createRender(false);
		return $this;
	}
	
	/**
	 * Method setTableStyle
	 * @access public
	 * @return Authentication
	 * @since 1.1.11
	 */
	public function setTableStyle() {
		$this->table_style = $table_style;
		
		$this->createRender(false);
		return $this;
	}
	
	/**
	 * Method setTableWidth
	 * @access public
	 * @param integer $width 
	 * @return Authentication
	 * @since 1.2.0
	 */
	public function setTableWidth($width) {
		$this->table_width = $width;
		if ($this->table_main != null) {
			$this->table_main->setWidth($this->table_width);
		}
		return $this;
	}
	
	/**
	 * Method setInputWidth
	 * @access public
	 * @param integer $width 
	 * @return Authentication
	 * @since 1.2.0
	 */
	public function setInputWidth($width) {
		$this->input_width = $width;
		if ($this->login != null) {
			$this->login->setWidth($this->input_width);
			$this->password->setWidth($this->input_width);
		}
		return $this;
	}
	
	/**
	 * Method createRender
	 * @access private
	 * @param boolean $first_time [default value: true]
	 * @since 1.1.11
	 */
	private function createRender($first_time=true) {
		$this->table_main = new Table();
		$this->table_main->setClass($this->table_style);
		$this->table_main->setWidth($this->table_width);
		
		if ($first_time) {
			$this->form = new Form($this->page_object);
			
			$this->error_obj = new Object();
			$this->error_obj->setId("wsp_auth_IdErrorMsg");
			
			$this->login = new TextBox($this->form, "wsp_auth_login");
			$login_validation = new LiveValidation();
			$this->login->setLiveValidation($login_validation->addValidatePresence()->setFieldName(__(AUTHENTICATION_LOGIN)));
			$this->login->setFocus()->setStripTags()->setWidth($this->input_width);
			
			$this->password = new Password($this->form, "wsp_auth_passwd");
			$passwd_validation = new LiveValidation();
			$this->password->setLiveValidation($passwd_validation->addValidatePresence()->setFieldName(__(AUTHENTICATION_PASSWD)));
			$this->password->setStripTags()->setWidth($this->input_width);
			
			$this->connect_button = new Button($this->form, "wsp_auth_connect", "", __(AUTHENTICATION_CONNECT));
			$this->hdnReferer = new Hidden($this->form, "wsp_auth_referer");
		}
		
		if ($this->encrypt && extension_loaded('openssl')) {
			$this->form->setEncryptObject(new EncryptDataWspObject("wsp-authentication"));
		} else {
			$this->form->disableEncryptObject();
		}
		
		if ($this->button_class != '') {
			$this->connect_button->setClass($this->button_class);
		}
		$this->connect_button->assignEnterKey()->onClick($this->connect_method)->setAjaxEvent();
		
		if ($this->style == Authentication::STYLE_2_LINES) {
			$this->table_main->addRow($this->error_obj)->setColspan(2)->setAlign(RowTable::ALIGN_CENTER);
			
			$this->table_main->addRowColumns(__(AUTHENTICATION_LOGIN).":&nbsp;", $this->login)->setColumnWidth(2, "100%")->setNowrap();
			$this->table_main->addRowColumns(__(AUTHENTICATION_PASSWD).":&nbsp;", $this->password)->setNowrap();
			$this->table_main->addRow();
			$this->table_main->addRow($this->connect_button)->setColspan(2);
		} else if ($this->style == Authentication::STYLE_2_LINES_NO_TEXT) {
			$this->table_main->addRow($this->error_obj)->setAlign(RowTable::ALIGN_CENTER);
			
			$this->login->setValue(__(AUTHENTICATION_LOGIN));
			$this->login->onClickJs("\$('#".$this->login->getId()."').val('');");
			$this->password->setValue(__(AUTHENTICATION_PASSWD));
			$this->password->onClickJs("\$('#".$this->password->getId()."').val('');");
			
			$this->table_main->addRowColumns($this->login->setFocus())->setColumnWidth(2, "100%")->setNowrap();
			$this->table_main->addRowColumns($this->password)->setNowrap();
			$this->table_main->addRow();
			$this->table_main->addRow($this->connect_button);
		} else if ($this->style == Authentication::STYLE_1_LINE) {
			$this->table_main->addRow($this->error_obj)->setColspan(5)->setAlign(RowTable::ALIGN_CENTER);
			
			$this->table_main->addRowColumns(new Object(__(AUTHENTICATION_LOGIN), ":<br/>", $this->login->setFocus()), "&nbsp;", 
										new Object(__(AUTHENTICATION_PASSWD), ":<br/>", $this->password), "&nbsp;", 
										$this->connect_button)->setNowrap();
		} else if ($this->style == Authentication::STYLE_1_LINE_NO_TEXT) {
			$this->table_main->addRow($this->error_obj)->setColspan(3)->setAlign(RowTable::ALIGN_CENTER);
			
			$this->login->setValue(__(AUTHENTICATION_LOGIN));
			$this->login->onClickJs("\$('#".$this->login->getId()."').val('');");
			$this->password->setValue(__(AUTHENTICATION_PASSWD));
			$this->password->onClickJs("\$('#".$this->password->getId()."').val('');");
			
			$this->table_main->addRowColumns($this->login->setFocus(), "&nbsp;", 
										 $this->password, "&nbsp;", 
										$this->connect_button)->setNowrap();
		}
		
		if (isset($_GET['referer'])) {
			$this->hdnReferer->setValue(trim($_GET['referer']));
		}
		
		$this->form->setContent(new Object($this->table_main, $this->hdnReferer));
		$this->render = $this->form;
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
		return $this->password->getValue();
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
	 * Method connect
	 * @access public
	 * @param boolean $redirect [default value: true]
	 * @param string $redirect_url [default value: REFERER]
	 * @return boolean
	 * @since 1.1.11
	 */
	public function connect($redirect=true, $redirect_url='REFERER') {
		require_once(dirname(__FILE__)."/../../../../pages/".WSP_ADMIN_URL."/includes/utils-users.inc.php");
		
		list($strAdminLogin, $strAdminPasswd, $strUserRights) = getWspUserRightsInfo($this->getLogin());
		
		if ($strAdminLogin != "" && $strAdminLogin == $this->getLogin() && $strAdminPasswd == sha1($this->getPassword())) {
			$this->userIsAuthentificated($strUserRights, $redirect, $redirect_url);
		} else if ($this->authentication_msg) {
			$str_msg = new Label(__(AUTHENTICATION_ERROR_LOGIN_PASS));
			$str_msg->setStyle("text-shadow:#888888 1px 1px 1px;");
			$this->error_obj->add($str_msg->setColor($this->color_error));
			return false;
		}
		return true;
	}
	
	/**
	 * Method userIsAuthentificated
	 * @access protected
	 * @param mixed $strUserRights 
	 * @param mixed $redirect 
	 * @param mixed $redirect_url 
	 * @since 1.1.11
	 */
	protected function userIsAuthentificated($strUserRights, $redirect, $redirect_url) {
		$this->page_object->setUserRights($strUserRights);
		$_SESSION['wsp-login'] = $this->getLogin();
		if ($redirect) {
			if ($this->authentication_msg) {
				$str_msg = new Label(__(AUTHENTICATION_LOGIN_OK_REDIRECT));
				$str_msg->setStyle("text-shadow:#888888 1px 1px 1px;");
				$this->error_obj->add($str_msg->setColor($this->color_ok));
			}
			if ($redirect_url == "") {
				$this->page_object->redirect($this->page_object->getBaseLanguageURL().WSP_ADMIN_URL."/admin.html");
			} else if (strtoupper($redirect_url) == "REFERER") {
				if ($this->getReferer() != "") {
					$this->page_object->redirect($this->getReferer());
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
