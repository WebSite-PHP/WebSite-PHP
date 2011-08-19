<?php 
	function getCurrentWspVersion() {
		return file_get_contents(dirname(__FILE__)."/../../../wsp/version.txt");
	}
	
	function isNewWspVersion() {
		if (extension_loaded('soap')) {
			$user_wsp_version = getCurrentWspVersion();
			if (!isset($_SESSION['server_wsp_version'])) {
				$client = new WebSitePhpSoapClient("http://www.website-php.com/en/webservices/wsp-information-server.wsdl?wsdl");
				$_SESSION['server_wsp_version'] = $client->getLastVersionNumber();
			}
			//echo trim($user_wsp_version)." != ".trim($_SESSION['server_wsp_version']);
			if (trim($user_wsp_version) != trim($_SESSION['server_wsp_version'])) {
				return trim($_SESSION['server_wsp_version']);
			}
		}
		return false;
	}
	
	function getCurrentBrowscapVersion() {
		$db = dirname(__FILE__)."/../../../wsp/includes/browscap/php_browscap.ini";
		$browscapIni=defined('INI_SCANNER_RAW') ? parse_ini_file($db,true,INI_SCANNER_RAW) : parse_ini_file($db,true);
		uksort($browscapIni,'_sortBrowscap');
		$browscapIni=array_map('_lowerBrowscap',$browscapIni);
		
		return $browscapIni['GJK_Browscap_Version']['version'];
	}
	
	function isNewBrowscapVersion() {
		if (!isset($_SESSION['user_browscap_version'])) {
			$_SESSION['user_browscap_version'] = getCurrentBrowscapVersion();
		}
		if (!isset($_SESSION['server_browscap_version'])) {
			$timeout_ctx = stream_context_create(array('http' => array('timeout' => 2))); 
			$_SESSION['server_browscap_version'] = file_get_contents("http://browsers.garykeith.com/versions/version-number.asp", 0, $timeout_ctx);
		}
		if (trim($_SESSION['user_browscap_version']) != trim($_SESSION['server_browscap_version'])) {
			return trim($_SESSION['server_browscap_version']);
		}
		return false;
	}
	
	function getAlertVersiobObject($page) {
		$alert_version_obj = null;
		$wsp_version = isNewWspVersion();
		$browscap_version = isNewBrowscapVersion();
		if ($wsp_version != false || $browscap_version != false) {
			$alert_version_obj = new Object();
			$alert_version_obj->setClass("warning");
			if ($wsp_version != false) {
				if (extension_loaded('zip')) {
					$dialog_update_wsp = new DialogBox(__(UPDATE_FRAMEWORK), new Url("wsp-admin/update/update-confirm.call?update=update-wsp&text=WebSite-PHP"));
					$dialog_update_wsp->displayFormURL();
					$alert_version_obj->add(__(NEW_WSP_VERSION, $dialog_update_wsp->render(), $wsp_version));
				} else {
					$alert_version_obj->add(__(NEW_WSP_VERSION, "location.href='http://www.website-php.com/download/website-php-update.zip';", $wsp_version));
				}
			}
			if ($browscap_version != false) {
				$dialog_update_browscap = new DialogBox(__(UPDATE_FRAMEWORK), new Url("wsp-admin/update/update-confirm.call?update=update-browscap&text=Browscap.ini"));
				$dialog_update_browscap->displayFormURL()->modal();
				$alert_version_obj->add(__(NEW_BROWSCAP_VERSION, $dialog_update_browscap->render(), $browscap_version));
			}
		}
		if (!extension_loaded('soap')) {
			if ($alert_version_obj == null) {
				$alert_version_obj = new Object();
			}
			$soap_alert = new Label(__(INSTALL_PHP_SOAP));
			$alert_version_obj->add($soap_alert);
		}
		return $alert_version_obj;
	}
?>