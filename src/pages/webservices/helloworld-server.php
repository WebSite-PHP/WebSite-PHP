<?php
/*
 * Exemple Webservice Server (Helloworld)
 * WSDL access : http://YOUR_DOMAIN/webservices/helloworld-server.wsdl?wsdl
 */

require_once(dirname(__FILE__)."/MySoapableObject.class.php");

class HelloworldServer extends WebSitePhpSoapServer {
	function __construct() {
		parent::__construct('Helloworld');
	}
}

class Helloworld extends WebSitePhpSoapServerObject {
	private $login = "";
	
	/**
    * setLogin
    *
    * @param string $login, the user login
    * @return string str, please set the return to be sure object is setting
    */
	public function setLogin($login) {
		$this->login = $login;
		return "";
	}
	
	/**
    * helloWorld
    *
    * @return string str, helloworld text
    */
	public function helloWorld() {
		return "HelloWorld, ".$this->login." !!!";
	}
	
	/**
    * welcommeMessage
    *
    * @param string $color, text color
    * @return string str, welcome text
    */
	public function welcommeMessage($color) {
		return "<font color=\"".$color."\">Welcome, ".$this->login." !!!</font>";
	}
	
	/**
    * echoObject
    *
    * @param MySoapableObject $object, object
    * @return string str, object description
    */
	public function echoObject($object) {
		return echo_r($object);
	}
	
	/**
    * getObjectSubText
    *
    * @param MySoapableObject $object, object
    * @return string str, get text from sub object
    */
	public function getObjectSubText($object) {
		return $object->sub_object->sub_text;
	}
}
?>