<?php 
/**
 * PHP file wsp\class\modules\Authentication\AuthenticationActiveDirectory.class.php
 * @package modules
 * @subpackage Authentication
 */
/**
 * Class AuthenticationActiveDirectory
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
 * @since       1.1.11
 */

class AuthenticationActiveDirectory extends Authentication {
	
	private $ldap_dn = "";
	private $ldap_host = "localhost";
	private $ldap_port = "389";
	private $ldap_user_domain = "@college.school.edu";
	private $default_right = Page::RIGHTS_GUEST;
	private $rights_mapping = array();
	private $ldap_user_info = array();
	private $enable_subtree_search = false;
	
	/**
	 * Constructor AuthenticationActiveDirectory
	 * @param mixed $page_object 
	 * @param mixed $connect_method 
	 * @param string $ldap_user_domain 
	 * @param string $ldap_dn 
	 * @param string $ldap_host [default value: localhost]
	 * @param double $ldap_port [default value: 389]
	 * @param mixed $style [default value: Authentication::STYLE_2_LINES]
	 * @param boolean $encrypt [default value: true]
	 * @param string $button_class 
	 * @param string $table_style 
	 */
	function __construct($page_object, $connect_method, $ldap_user_domain='', $ldap_dn='', $ldap_host='localhost', $ldap_port=389, $style=Authentication::STYLE_2_LINES, $encrypt=true, $button_class='', $table_style='') {
		if (!extension_loaded('ldap')) {
			throw new NewException("You need to install PHP lib php-ldap", 0, getDebugBacktrace(1));
		}
		
		parent::__construct($page_object, $connect_method, $style, $encrypt, $button_class, $table_style);
		
		$this->ldap_dn = $ldap_dn;
		$this->ldap_user_domain = $ldap_user_domain;
		$this->ldap_host = $ldap_host;
		$this->ldap_port = $ldap_port;
	}
	
	/**
	 * Method setLDAPHost
	 * @access public
	 * @param mixed $ldap_host 
	 * @param double $ldap_port [default value: 389]
	 * @return AuthenticationActiveDirectory
	 * @since 1.1.11
	 */
	public function setLDAPHost($ldap_host, $ldap_port=389) {
		$this->ldap_host = $ldap_host;
		$this->ldap_port = $ldap_port;
		return $this;
	}
	
	/**
	 * Method setLDAPUserDomain
	 * @access public
	 * @param mixed $ldap_user_domain 
	 * @return AuthenticationActiveDirectory
	 * @since 1.1.11
	 */
	public function setLDAPUserDomain($ldap_user_domain) {
		$this->ldap_user_domain = $ldap_user_domain;
		return $this;
	}
	
	/**
	 * Method setLDAPDN
	 * @access public
	 * @param mixed $ldap_dn 
	 * @return AuthenticationActiveDirectory
	 * @since 1.2.2
	 */
	public function setLDAPDN($ldap_dn) {
        $this->ldap_dn = $ldap_dn;
        return $this;
    }
	
	/**
	 * Method setDefaultUserRights
	 * @access public
	 * @param mixed $rights 
	 * @return AuthenticationActiveDirectory
	 * @since 1.1.11
	 */
	public function setDefaultUserRights($rights) {
		$this->default_right = $rights;
		return $this;
	}
	
	/**
	 * Method setRightsMapping
	 * @access public
	 * @param string $rights_mapping [default value: Administrator]
	 * @return AuthenticationActiveDirectory
	 * @since 1.1.11
	 */
	public function setRightsMapping($rights_mapping=array("Administrator" => Page::RIGHTS_ADMINISTRATOR)) {
		$this->rights_mapping = $rights_mapping;
		return $this;
	}
	
	/**
	 * Method getLDAPUserInfo
	 * @access public
	 * @return mixed
	 * @since 1.1.11
	 */
	public function getLDAPUserInfo() {
		return $this->ldap_user_info;
	}
	
	/**
	 * Method enableSubtreeSearch
	 * @access public
	 * @return AuthenticationActiveDirectory
	 * @since 1.2.3
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
	 * @since 1.1.11
	 */
	public function connect($redirect=true, $redirect_url='REFERER') {
		$this->error_obj->emptyObject();
		$ldap = @ldap_connect($this->ldap_host, $this->ldap_port);  // doit être un serveur LDAP valide !
		if ($this->enable_subtree_search) {
			ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
		}
		if ($ldap !== false) {
			$r = ldap_bind($ldap, $this->getLogin().$this->ldap_user_domain, $this->getPassword());
			if ($r !== false) {
				$filter = "(sAMAccountName=".$this->getLogin().")";
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
						$this->userIsAuthentificated($strUserRights, $redirect, $redirect_url);
					} else {
						$str_msg = new Label(__(AUTHENTICATION_ERROR_LOGIN_PASS));
						$str_msg->setStyle("text-shadow:#888888 1px 1px 1px;");
						$this->error_obj->add($str_msg->setColor($this->color_error));
						return false;
					}
		        } else {
		        	throw new NewException("Unable to search on LDAP server", 0, getDebugBacktrace(1));
		        }
				ldap_unbind($ldap);
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
