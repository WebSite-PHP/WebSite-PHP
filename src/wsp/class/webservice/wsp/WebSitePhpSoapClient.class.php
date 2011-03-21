<?php
/**
 * PHP file wsp\class\webservice\wsp\WebSitePhpSoapClient.class.php
 * @package webservice
 * @subpackage wsp
 */
/**
 * Class WebSitePhpSoapClient
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package webservice
 * @subpackage wsp
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 03/10/2010
 * @version     1.0.62
 * @access      public
 * @since       1.0.17
 */

class WebSitePhpSoapClient extends SoapClient {
	private $session = "";
	
	/**
	 * Constructor WebSitePhpSoapClient
	 * @param mixed $wsdl 
	 */
	function __construct($wsdl) {
		$wsdl = urlencode($wsdl);
		parent::__construct($wsdl);
		$this->session = $this->getSessionId();
		$this->__setCookie('WSP_WS_SESSION', $this->session);
	}
	
	/**
	 * Method getSession
	 * @access public
	 * @return mixed
	 * @since 1.0.55
	 */
	public function getSession() {
		return $this->session;
	}
}
?>
