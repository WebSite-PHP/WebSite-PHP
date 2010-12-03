<?php
class WebSitePhpSoapClient extends SoapClient {
	private $session = "";
	
	function __construct($wsdl) {
		$wsdl = urlencode($wsdl);
		parent::__construct($wsdl);
		$this->session = $this->getSessionId();
		$this->__setCookie('WSP_WS_SESSION', $this->session);
	}
	
	public function getSession() {
		return $this->session;
	}
}
?>
