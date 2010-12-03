<?php
class WebSitePhpSoapServerObject {
	function __construct() {}
	
	/**
    * getSessionId
    *
    * @return string str, session id
    */
	public function getSessionId() {
    	return session_id();
    }
}
?>
