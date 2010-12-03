<?php
/*
 * Exemple Webservice Client (Helloworld)
 * Use : http://YOUR_DOMAIN/webservices/helloworld-client.html
 */

require_once(dirname(__FILE__)."/MySoapableObject.class.php");

class HelloworldClient extends Page {
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		// Init webservice
		$client = new WebSitePhpSoapClient(BASE_URL.$_SESSION['lang']."/webservices/helloworld-server.wsdl?wsdl");
		
	    // call web services methods
	    $client->setLogin("Your Login");
	    $hello = $client->helloWorld();
	    $welcome = $client->welcommeMessage("red");
	    
	    // test with a complex object
	    $my_obj = new MySoapableObject();
	    $my_obj->setText("It's my object");
	    $obj_echo = $client->echoObject(new SoapVar($my_obj, SOAP_ENC_OBJECT));
	    $sub_text = $client->getObjectSubText(new SoapVar($my_obj, SOAP_ENC_OBJECT));
	    
	    // display result message
		$this->render = new Object($hello, "<br/>", $welcome, "<br/><br/>", $obj_echo, "<br/>", $sub_text);
	}
}
?>