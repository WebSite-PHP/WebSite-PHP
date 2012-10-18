<?php 
	function getCurrentWspVersion() {
		return file_get_contents(dirname(__FILE__)."/../../../wsp/version.txt");
	}
	
	function isNewWspVersion() {
		if (extension_loaded('soap')) {
			$user_wsp_version = getCurrentWspVersion();
			
			if (!isset($_SESSION['server_wsp_version'])) {
				$http = new Http();
				$http->setTimeout(2);
				$http->execute("http://www.website-php.com/en/webservices/wsp-information-server.wsdl?wsdl");
				$wsdl = $http->getResult();
				if ($wsdl != "" && find($wsdl, "<?xml", 1) > 0) {
					$client = new WebSitePhpSoapClient("http://www.website-php.com/en/webservices/wsp-information-server.wsdl?wsdl");
					$_SESSION['server_wsp_version'] = $client->getLastVersionNumber2($user_wsp_version, BASE_URL);
				}
			}
			//echo trim($user_wsp_version)." != ".trim($_SESSION['server_wsp_version']);
			if (trim($user_wsp_version) != trim($_SESSION['server_wsp_version'])) {
				return trim($_SESSION['server_wsp_version']);
			}
		}
		return false;
	}
	
	function getCurrentBrowscapVersion() {
		$db = realpath(dirname(__FILE__)."/../../../wsp/includes/browscap/php_browscap.ini");
		$browscapIni=defined('INI_SCANNER_RAW') ? parse_ini_file($db,true,INI_SCANNER_RAW) : parse_ini_file($db,true);
		return $browscapIni['GJK_Browscap_Version']['Version'];
	}
	
	function isNewBrowscapVersion() {
		if (!isset($_SESSION['user_browscap_version'])) {
			$_SESSION['user_browscap_version'] = getCurrentBrowscapVersion();
		}
		if (!isset($_SESSION['server_browscap_version'])) {
			$server_browscap_version = "";
			if (extension_loaded('soap')) {
				$http = new Http();
				$http->setTimeout(2);
				$http->execute("http://www.website-php.com/en/webservices/wsp-information-server.wsdl?wsdl");
				$wsdl = $http->getResult();
				if ($wsdl != "" && find($wsdl, "<?xml", 1) > 0) {
					$client = new WebSitePhpSoapClient("http://www.website-php.com/en/webservices/wsp-information-server.wsdl?wsdl");
					$server_browscap_version = $client->getBrowscapVersionNumber();
				}
			} else {
				$http = new Http();
				$http->setTimeout(2);
				$http->execute("http://browsers.garykeith.com/versions/version-number.asp");
				$server_browscap_version = $http->getResult();
			}
			if (trim($server_browscap_version) != "") {
				$_SESSION['server_browscap_version'] = $server_browscap_version;
			}
		}
		if (trim($_SESSION['user_browscap_version']) != trim($_SESSION['server_browscap_version'])) {
			return trim($_SESSION['server_browscap_version']);
		}
		return false;
	}
	
	function getAlertVersiobObject($page) {
		$alert_version_obj = null;
		if (extension_loaded('soap')) {
			$wsp_version = isNewWspVersion();
			$browscap_version = isNewBrowscapVersion();
			if ($wsp_version != false || $browscap_version != false) {
				$alert_version_obj = new Object();
				$alert_version_obj->setClass("warning");
				if ($wsp_version != false) {
					if (extension_loaded('zip')) {
						$dialog_update_wsp = new DialogBox(__(UPDATE_FRAMEWORK), new Url("wsp-admin/update/update-confirm.call?update=update-wsp&text=WebSite-PHP"));
						$dialog_update_wsp->displayFormURL();
						$alert_version_obj->add(__(NEW_WSP_VERSION, $dialog_update_wsp->render(), $wsp_version), "<br/>");
					} else {
						$alert_version_obj->add(__(NEW_WSP_VERSION, "location.href='http://www.website-php.com/download/website-php-update.zip';", $wsp_version));
						$alert_version_obj->add(" ", __(NEW_WSP_VERSION_INSTALL_PHP_ZIP), "<br/>");
					}
				}
				if ($browscap_version != false) {
					$dialog_update_browscap = new DialogBox(__(UPDATE_FRAMEWORK), new Url("wsp-admin/update/update-confirm.call?update=update-browscap&text=Browscap.ini"));
					$dialog_update_browscap->displayFormURL()->modal();
					$alert_version_obj->add(__(NEW_BROWSCAP_VERSION, $dialog_update_browscap->render(), $browscap_version));
				}
			}
		} else {
			$alert_version_obj = new Object();
			$alert_version_obj->setClass("warning");
			$soap_alert = new Label(__(INSTALL_PHP_SOAP));
			$alert_version_obj->add($soap_alert);
		}
		return $alert_version_obj;
	}
?>