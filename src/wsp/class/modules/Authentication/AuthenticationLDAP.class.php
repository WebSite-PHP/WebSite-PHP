<?php 
/**
 * PHP file wsp\class\modules\Authentication\AuthenticationLDAP.class.php
 * @package modules
 * @subpackage Authentication
 */
/**
 * Class AuthenticationLDAP
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2017 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package modules
 * @subpackage Authentication
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 20/07/2016
 * @version     1.2.15
 * @access      public
 * @since       1.2.14
 */

class AuthenticationLDAP extends Authentication {
	
	private $ldap_dn = "";
	private $ldap_host = "localhost";
	private $ldap_port = "389";
	private $ldap_login = "";
	private $ldap_password = "";
	private $ldap_object_class = "person";
	private $ldap_username_attribute = "uid";
	private $default_right = Page::RIGHTS_GUEST;
	private $rights_mapping = array();
	private $ldap_user_info = array();
	private $enable_subtree_search = false;
	
	/**
	 * Constructor AuthenticationLDAP
	 * @param mixed $page_object 
	 * @param mixed $connect_method 
	 * @param string $ldap_dn 
	 * @param string $ldap_host [default value: localhost]
	 * @param double $ldap_port [default value: 389]
	 * @param string $ldap_object_class [default value: person]
	 * @param string $ldap_username_attribute [default value: uid]
	 * @param mixed $ldap_login [default value: null]
	 * @param mixed $ldap_password [default value: null]
	 * @param mixed $style [default value: Authentication::STYLE_2_LINES]
	 * @param boolean $encrypt [default value: true]
	 * @param string $button_class 
	 * @param string $table_style 
	 */
	function __construct($page_object, $connect_method, $ldap_dn='', $ldap_host='localhost', $ldap_port=389, $ldap_object_class="person", $ldap_username_attribute="uid", $ldap_login=null, $ldap_password=null, $style=Authentication::STYLE_2_LINES, $encrypt=true, $button_class='', $table_style='') {
		if (!extension_loaded('ldap')) {
			throw new NewException("You need to install PHP lib php-ldap", 0, getDebugBacktrace(1));
		}
		
		parent::__construct($page_object, $connect_method, $style, $encrypt, $button_class, $table_style);
		
		$this->ldap_dn = $ldap_dn;
		$this->ldap_user_domain = $ldap_user_domain;
		$this->ldap_host = $ldap_host;
		$this->ldap_port = $ldap_port;
		$this->ldap_login = $ldap_login;
		$this->ldap_password = $ldap_password;
		$this->ldap_object_class = $ldap_object_class;
		$this->ldap_username_attribute = $ldap_username_attribute;
		$this->ldap_dn_attr = "dn";
	}
	
	/**
	 * Method setLDAPHost
	 * @access public
	 * @param mixed $ldap_host 
	 * @param double $ldap_port [default value: 389]
	 * @return AuthenticationLDAP
	 * @since 1.2.14
	 */
	public function setLDAPHost($ldap_host, $ldap_port=389) {
		$this->ldap_host = $ldap_host;
		$this->ldap_port = $ldap_port;
		return $this;
	}
	
	/**
	 * Method setLDAPLoginPassword
	 * @access public
	 * @param mixed $ldap_login 
	 * @param mixed $ldap_password 
	 * @return AuthenticationLDAP
	 * @since 1.2.14
	 */
	public function setLDAPLoginPassword($ldap_login, $ldap_password) {
		$this->ldap_login = $ldap_login;
		$this->ldap_password = $ldap_password;
		return $this;
	}
	
	/**
	 * Method setLDAPDN
	 * @access public
	 * @param mixed $ldap_dn 
	 * @return AuthenticationLDAP
	 * @since 1.2.14
	 */
	public function setLDAPDN($ldap_dn) {
        $this->ldap_dn = $ldap_dn;
        return $this;
    }
	
	/**
	 * Method setLDAPObjectClass
	 * @access public
	 * @param mixed $ldap_object_class 
	 * @return AuthenticationLDAP
	 * @since 1.2.14
	 */
	public function setLDAPObjectClass($ldap_object_class) {
        $this->ldap_object_class = $ldap_object_class;
        return $this;
    }
	
	/**
	 * Method setLDAPUsernameAttribute
	 * @access public
	 * @param mixed $ldap_username_attribute 
	 * @return AuthenticationLDAP
	 * @since 1.2.14
	 */
	public function setLDAPUsernameAttribute($ldap_username_attribute) {
        $this->ldap_username_attribute = $ldap_username_attribute;
        return $this;
    }
	
	/**
	 * Method setDefaultUserRights
	 * @access public
	 * @param mixed $rights 
	 * @return AuthenticationLDAP
	 * @since 1.2.14
	 */
	public function setDefaultUserRights($rights) {
		$this->default_right = $rights;
		return $this;
	}
	
	/**
	 * Method setRightsMapping
	 * @access public
	 * @param string $rights_mapping [default value: Administrator]
	 * @return AuthenticationLDAP
	 * @since 1.2.14
	 */
	public function setRightsMapping($rights_mapping=array("Administrator" => Page::RIGHTS_ADMINISTRATOR)) {
		$this->rights_mapping = $rights_mapping;
		return $this;
	}
	
	/**
	 * Method getLDAPUserInfo
	 * @access public
	 * @return mixed
	 * @since 1.2.14
	 */
	public function getLDAPUserInfo() {
		return $this->ldap_user_info;
	}
	
	/**
	 * Method enableSubtreeSearch
	 * @access public
	 * @return AuthenticationLDAP
	 * @since 1.2.14
	 */
	public function enableSubtreeSearch() {
		$this->enable_subtree_search = true;
		return $this;
	}
	
	/**
	 * Method connect
	 * @access public
	 * @param boolean $redirect [default value: true]
	 * @param string $redirect_url [default value: REFERER]
	 * @return boolean
	 * @since 1.2.14
	 */
	public function connect($redirect=true, $redirect_url='REFERER') {
		$this->error_obj->emptyObject();
		$ldap = @ldap_connect($this->ldap_host, $this->ldap_port);  // doit être un serveur LDAP valide !
		if ($this->enable_subtree_search) {
			ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
		}
		if ($ldap !== false) {
			if ($this->ldap_login != null) {
				$r = @ldap_bind($ldap, $this->ldap_login, $this->ldap_password);
			}
			if ($r !== false || $this->ldap_login == null) {
				$filter = "(&(objectClass=".$this->ldap_object_class.")(".$this->ldap_username_attribute."=".$this->getLogin()."))";
				$result = @ldap_search($ldap, $this->ldap_dn, $filter);
		        if ($result !== false) {
		        	$strUserRights = $this->default_right;
					$info = ldap_get_entries($ldap, $result);
					if (isset($info[0])) {
						$this->ldap_user_info = $info[0];
						if (isset($info[0]["memberof"])) {
							$rights_exists = false;
							for ($i=0; $i < sizeof($info[0]["memberof"]); $i++) {
								$tmp_rights = $info[0]["memberof"][$i];
								foreach ($this->rights_mapping as $key => $value) {
									if ($this->rights_mapping[$i][0] == $key) {
										$strUserRights = $value;
										$rights_exists = true;
										break;
									}
								}
								if ($rights_exists == true) {
									break;
								}
							}
						}
						if (!is_array($info[0][strtolower($this->ldap_dn_attr)])) {
							$dn = $info[0][strtolower($this->ldap_dn_attr)];
						} else {
							$dn = $info[0][strtolower($this->ldap_dn_attr)][0];
						}
						$r = @ldap_bind($ldap, $dn, html_entity_decode($this->getPassword()));
						if ($r !== false) {
							$this->userIsAuthentificated($strUserRights, $redirect, $redirect_url);
						} else {
							$str_msg = new Label(__(AUTHENTICATION_ERROR_LOGIN_PASS));
							$str_msg->setStyle("text-shadow:#888888 1px 1px 1px;");
							$this->error_obj->add($str_msg->setColor($this->color_error));
							return false;
						}
					} else {
						$str_msg = new Label(__(AUTHENTICATION_ERROR_LOGIN_PASS));
						$str_msg->setStyle("text-shadow:#888888 1px 1px 1px;");
						$this->error_obj->add($str_msg->setColor($this->color_error));
						return false;
					}
		        } else {
		        	throw new NewException("Unable to search on LDAP server", 0, getDebugBacktrace(1));
		        }
			} else {
				$str_msg = new Label(__(AUTHENTICATION_ERROR_LOGIN_PASS));
				$str_msg->setStyle("text-shadow:#888888 1px 1px 1px;");
				$this->error_obj->add($str_msg->setColor($this->color_error));
				return false;
			}
			ldap_close($ldap);
			return true;
		} else {
			throw new NewException("Unable to connect on LDAP server", 0, getDebugBacktrace(1));
		}
	}
}
?>
