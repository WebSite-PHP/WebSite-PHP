<?php
/**
 * PHP file wsp\class\webservice\wsp\WebSitePhpSoapServer.class.php
 * @package webservice
 * @subpackage wsp
 */
/**
 * Class WebSitePhpSoapServer
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package webservice
 * @subpackage wsp
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.17
 */

class WebSitePhpSoapServer {
	/**
	 * Constructor WebSitePhpSoapServer
	 * @param mixed $class_name 
	 */
	function __construct($class_name) {
		include_once('wsp/class/webservice/Soap/AutoDiscover.php');
		
		ini_set("soap.wsdl_cache_enabled", "0");
		if(isset($_GET['wsdl'])) {
			$this->server = new Zend_Soap_AutoDiscover();
			$this->server->setClass($class_name);
			$this->server->handle();
		} else {
			// pointing to the current file here
			$this->server = new SoapServer(BASE_URL.$_SESSION['lang']."/".$_SESSION['calling_page'].".wsdl?wsdl");
			$this->server->setClass($class_name);
			$this->server->setPersistence(SOAP_PERSISTENCE_SESSION);
			$this->server->handle();
		}
	}
}
?>
