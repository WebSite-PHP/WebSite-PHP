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
 * Copyright (c) 2009-2016 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package modules
 * @subpackage Authentication
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 11/05/2016
 * @version     1.2.14
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
	
	private $is_ajax_event = true;
	private $ajax_wait_message = "";
	private $disable_ajax_wait_message = false;
	private $prefill_login_passwd = true;
    private $custom_field_array = array();
    private $custom_label_array = array();
    
    private $login_validation = null;
    private $passwd_validation = null;
    private $login_label = "";
    private $password_label = "";
    private $button_label = "";
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
		
		$this->login_label = __(AUTHENTICATION_LOGIN);
		$this->password_label = __(AUTHENTICATION_PASSWD);
		$this->button_label = __(AUTHENTICATION_CONNECT);
		
		$this->onsubmit_args = array();
		
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
	 * @param mixed $button_class 
	 * @return Authentication
	 * @since 1.1.11
	 */
	public function setButtonClass($button_class) {
		$this->button_class = $button_class;
		
		$this->createRender(false);
		return $this;
	}
	
	/**
	 * Method setTableStyle
	 * @access public
	 * @param mixed $table_style 
	 * @return Authentication
	 * @since 1.1.11
	 */
	public function setTableStyle($table_style) {
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
	 * Method onSubmitButtonArgs
	 * @access public
	 * @param mixed $arg1 [default value: null]
	 * @param mixed $arg2 [default value: null]
	 * @param mixed $arg3 [default value: null]
	 * @param mixed $arg4 [default value: null]
	 * @param mixed $arg5 [default value: null]
	 * @return Authentication
	 * @since 1.2.14
	 */
	public function onSubmitButtonArgs($arg1=null, $arg2=null, $arg3=null, $arg4=null, $arg5=null) {
		$this->onsubmit_args = func_get_args();
		$this->createRender(false);
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
			$this->login_validation = new LiveValidation();
			$this->login->setLiveValidation($this->login_validation->addValidatePresence()->setFieldName($this->login_label));
			$this->login->setFocus()->setStripTags()->setWidth($this->input_width);
			
			$this->password = new Password($this->form, "wsp_auth_passwd");
			$this->passwd_validation = new LiveValidation();
			$this->password->setLiveValidation($this->passwd_validation->addValidatePresence()->setFieldName($this->password_label));
			$this->password->setStripTags()->setWidth($this->input_width);
			
			$this->connect_button = new Button($this->form, "wsp_auth_connect", "", $this->button_label);
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
		if ($this->ajax_wait_message != "") {
			$this->connect_button->setAjaxWaitMessage($this->ajax_wait_message);
		}
		if ($this->disable_ajax_wait_message) {
			$this->connect_button->disableAjaxWaitMessage();
		}
		$this->connect_button->assignEnterKey()->onClick($this->connect_method, $this->onsubmit_args[0], $this->onsubmit_args[1], $this->onsubmit_args[2], $this->onsubmit_args[3], $this->onsubmit_args[4]);
		$this->connect_button->setAjaxEvent($this->is_ajax_event);
		
		if ($this->style == Authentication::STYLE_2_LINES) {
			$this->table_main->addRow($this->error_obj)->setColspan(2)->setAlign(RowTable::ALIGN_CENTER);
			
			$this->table_main->addRowColumns($this->login_label.":&nbsp;", $this->login)->setColumnWidth(2, "100%")->setNowrap();
			$this->table_main->addRowColumns($this->password_label.":&nbsp;", $this->password)->setNowrap();
            for ($i=0; $i < sizeof($this->custom_field_array); $i++) {
               $this->table_main->addRowColumns($this->custom_label_array[$i].":&nbsp;", $this->custom_field_array[$i])->setNowrap();
            }
			$this->table_main->addRow();
			$this->table_main->addRow($this->connect_button)->setColspan(2);
		} else if ($this->style == Authentication::STYLE_2_LINES_NO_TEXT) {
			$this->table_main->addRow($this->error_obj)->setAlign(RowTable::ALIGN_CENTER);
			
			$this->table_main->addRowColumns($this->login->setFocus())->setColumnWidth(2, "100%")->setNowrap();
			$this->table_main->addRowColumns($this->password)->setNowrap();
            for ($i=0; $i < sizeof($this->custom_field_array); $i++) {
               $this->table_main->addRowColumns($this->custom_field_array[$i])->setNowrap();
            }
			$this->table_main->addRow();
			$this->table_main->addRow($this->connect_button);
		} else if ($this->style == Authentication::STYLE_1_LINE) {
			$this->table_main->addRow($this->error_obj)->setColspan(5)->setAlign(RowTable::ALIGN_CENTER);
			
			$row = new RowTable();
			$row->add(new Object($this->login_label, ":&nbsp;", $this->login->setFocus()))->add("&nbsp;") 
						->add(new Object($this->password_label, ":&nbsp;", $this->password))->add("&nbsp;");
			for ($i=0; $i < sizeof($this->custom_field_array); $i++) {
               $row->add(new Object($this->custom_label_array[$i], ":&nbsp;"))->add($this->custom_field_array[$i])->add("&nbsp;");
            }
            $row->add($this->connect_button)->setNowrap();
            $this->table_main->addRow($row);
		} else if ($this->style == Authentication::STYLE_1_LINE_NO_TEXT) {
			$this->table_main->addRow($this->error_obj)->setColspan(3)->setAlign(RowTable::ALIGN_CENTER);
			
			$row = new RowTable();
            $row->add($this->login->setFocus())->add("&nbsp;")->add($this->password)->add("&nbsp;");
            for ($i=0; $i < sizeof($this->custom_field_array); $i++) {
               $row->add($this->custom_field_array[$i])->add("&nbsp;");
            }
			$row->add($this->connect_button)->setNowrap();
            $this->table_main->addRow($row);
		}
		
		if (isset($_GET['referer'])) {
			$this->hdnReferer->setValue(trim($_GET['referer']));
		}
		
		$this->form->setContent(new Object($this->table_main, $this->hdnReferer));
		$this->render = $this->form;
	}
	
	/**
	 * Method addCustomField
	 * @access public
	 * @param mixed $field_obj 
	 * @param string $label 
	 * @return Authentication
	 * @since 1.2.2
	 */
    public function addCustomField($field_obj, $label='') {
        if (gettype($field_obj) != "object" || (!is_subclass_of($field_obj, "WebSitePhpObject") && !is_subclass_of($field_obj, "WebSitePhpEventObject"))) {
            throw new NewException(get_class($this)."->addCustomField() error, \$field_obj need to be a WebSitePHPObject object", 0, getDebugBacktrace(1));
        }
        $this->custom_field_array[] = $field_obj;
        $this->custom_label_array[] = $label;
        $this->createRender(false);
        return $this;
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
	 * Method getForm
	 * @access public
	 * @return mixed
	 * @since 1.2.2
	 */
    public function getForm() {
        return $this->form;
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
	 * Method setLoginLiveValidation
	 * @access public
	 * @param mixed $live_validation_object 
	 * @return Authentication
	 * @since 1.2.2
	 */
	public function setLoginLiveValidation($live_validation_object) {
		if (get_class($live_validation_object) != "LiveValidation") {
			throw new NewException("setLoginLiveValidation(): \$live_validation_object must be a valid LiveValidation object", 0, getDebugBacktrace(1));
		}
		$this->login_validation = $live_validation_object;
		if ($this->login_validation->getFieldName() == "") {
			$this->login_validation->setFieldName($this->login_label);
		}
		$this->login->setLiveValidation($this->login_validation);
		return $this;
	}
	
	/**
	 * Method setPasswordLiveValidation
	 * @access public
	 * @param mixed $live_validation_object 
	 * @return Authentication
	 * @since 1.2.2
	 */
	public function setPasswordLiveValidation($live_validation_object) {
		if (get_class($live_validation_object) != "LiveValidation") {
			throw new NewException("setPasswordLiveValidation(): \$live_validation_object must be a valid LiveValidation object", 0, getDebugBacktrace(1));
		}
		$this->passwd_validation = $live_validation_object;
		if ($this->passwd_validation->getFieldName() == "") {
			$this->passwd_validation->setFieldName($this->password_label);
		}
		$this->password->setLiveValidation($this->passwd_validation);
		return $this;
	}
	
	/**
	 * Method setLoginLabel
	 * @access public
	 * @param mixed $label 
	 * @return Authentication
	 * @since 1.2.2
	 */
	public function setLoginLabel($label) {
		$this->login_label = $label;
		if ($this->login_validation != null) {
			$this->login_validation->setFieldName($label);
		}
		$this->createRender(false);
		return $this;
	}
	
	/**
	 * Method setPasswordLabel
	 * @access public
	 * @param mixed $label 
	 * @return Authentication
	 * @since 1.2.2
	 */
	public function setPasswordLabel($label) {
		$this->password_label = $label;
		if ($this->passwd_validation != null) {
			$this->passwd_validation->setFieldName($label);
		}
		$this->createRender(false);
		return $this;
	}
	
	/**
	 * Method setButtonLabel
	 * @access public
	 * @param mixed $label 
	 * @return Authentication
	 * @since 1.2.2
	 */
	public function setButtonLabel($label) {
		$this->button_label = $label;
		$this->createRender(false);
		return $this;
	}
	
	/**
	 * Method disableAjaxEvent
	 * @access public
	 * @return Authentication
	 * @since 1.2.1
	 */
	public function disableAjaxEvent() {
		$this->is_ajax_event = false;
		
		$this->createRender(false);
		return $this;
	}
	
	/**
	 * Method setAjaxWaitMessage
	 * @access public
	 * @param mixed $message_or_object 
	 * @return Authentication
	 * @since 1.2.1
	 */
	public function setAjaxWaitMessage($message_or_object) {
		if (gettype($message_or_object) == "object") {
			if (get_class($message_or_object) != "Object") {
				throw new NewException("Error ".get_class($this)."->setAjaxWaitMessage(): \$message_or_object must be an Object and not ".get_class($message_or_object).".", 0, getDebugBacktrace(1));
			}
			$message_or_object->hide();
		}
		$this->ajax_wait_message = $message_or_object;
		
		$this->createRender(false);
		return $this;
	}
	
	/**
	 * Method disableAjaxWaitMessage
	 * @access public
	 * @return Authentication
	 * @since 1.2.1
	 */
	public function disableAjaxWaitMessage() {
		$this->disable_ajax_wait_message = true;
		
		$this->createRender(false);
		return $this;
	}
	
	/**
	 * Method disablePrefillLoginPassword
	 * @access public
	 * @return Authentication
	 * @since 1.2.2
	 */
	public function disablePrefillLoginPassword() {
		$this->prefill_login_passwd = false;
		
		$this->createRender(false);
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
		$this->error_obj->emptyObject();
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
		if ($this->prefill_login_passwd) {
			if ($this->login->getValue() == "") {
				$this->login->setValue($this->login_label);
			}
			$this->login->onClickJs("if (\$('#".$this->login->getId()."').val() == '".addslashes($this->login_label)."') { \$('#".$this->login->getId()."').val(''); }");
			$this->login->onBlurJs("if (\$('#".$this->login->getId()."').val() == '') { \$('#".$this->login->getId()."').val('".addslashes($this->login_label)."'); }");
			if ($this->password->getValue() == "") {
				$this->password->setValue($this->password_label);
			}
			$this->password->onClickJs("if (\$('#".$this->password->getId()."').val() == '".addslashes($this->password_label)."') { \$('#".$this->password->getId()."').val(''); }");
			$this->password->onBlurJs("if (\$('#".$this->password->getId()."').val() == '') { \$('#".$this->password->getId()."').val('".addslashes($this->password_label)."'); }");
		}
        return $this->render->render();
	}
}
?>
