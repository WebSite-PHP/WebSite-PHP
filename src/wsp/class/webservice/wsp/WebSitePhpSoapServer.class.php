<?php
class WebSitePhpSoapServer {
	function __construct($class_name) {
		include_once('wsp/class/webservice/Soap/AutoDiscover.php');
		
		if (find(BASE_URL, "127.0.0.1/", 0, 0) > 0 || find(BASE_URL, "localhost/", 0, 0) > 0) { // localhost
			ini_set("soap.wsdl_cache_enabled", "0");
		} else {
			ini_set("soap.wsdl_cache_enabled", "1");
		}
		
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
