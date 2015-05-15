<?php
/**
 * PHP file wsp\includes\utils_openssl.inc.php
 */
/**
 * WebSite-PHP file utils_openssl.inc.php
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.67
 */

	function createKeys($passphrase='passphrase', $private_key_bits=1024, $private_key_type=OPENSSL_KEYTYPE_RSA, $encrypte_key=true) {
		if (!extension_loaded('openssl')) {
			throw new NewException("Please activate openssl php lib, to use encryption.", 0, getDebugBacktrace(1));
		} else {
			$openssl_conf_file = str_replace("\\", "/", dirname(__FILE__)).'/../config/openssl.cnf';
			if (!file_exists($openssl_conf_file)) {
				throw new NewException("openssl.cnf doesn't exists (".$openssl_conf_file.").", 0, getDebugBacktrace(1));
			}
			
			// Create the keypair
			$config_key=array(
				"config" => $openssl_conf_file,
				"digest_alg" => "sha1",
				"x509_extensions" => "v3_ca",
				"req_extensions" => "v3_req",
				"private_key_bits" => $private_key_bits,
				"private_key_type" => $private_key_type,
				"encrypte_key" => $encrypte_key
				);
			$res=openssl_pkey_new($config_key);
			
			if ($res != false) {
				// Get private key. A pass phrase is required for proper encryption/decryption.
				openssl_pkey_export($res, $privkey, $passphrase, $config_key);
				
				// Get public key
				$pubkey = openssl_pkey_get_details($res);
				$pubkey = $pubkey['key'];
				
				$keys = array();
				$keys['private'] = $privkey;
				$keys['public'] = $pubkey;
				
				openssl_pkey_free($res);
				
				return $keys;
			} else {
				$error = "";
				while ($msg = openssl_error_string()) {
					$error .= $msg."<br />\n";
				}
		    	$error = "Error generation private key".($error!=""?" : ".$error:"");
		    	throw new NewException($error, 0, getDebugBacktrace(1));
			}
		}
		return null;
	}
	
	function decryptMessage($crypttext, $priv_key, $passphrase='passphrase') {
		$crypttext = base64_decode($crypttext);
		
		$res = openssl_pkey_get_private($priv_key, $passphrase);
		if ($res != false) {
			if (openssl_private_decrypt($crypttext, $text, $res)) {
				return $text;
			} else {
				$error = "";
				while ($msg = openssl_error_string()) {
					$error .= $msg."<br />\n";
				}
				$error = __(DECRYPT_ERROR).(DEBUG && $error!=""?" : ".$error:"");
				throw new NewException($error, 0, false);
			}
		} else {
			$error = "";
			while ($msg = openssl_error_string()) {
				$error .= $msg."<br />\n";
			}
			$error = "Error parsing private key".($error!=""?" : ".$error:"");
			throw new NewException($error, 0, getDebugBacktrace(1));
		}
		return "";
	}
	
	// use by Page and WebSitePhpEventObject
	global $form_object_decrypted;
	$form_object_decrypted = array();
	function decryptRequestEncryptData($object, $name, $submit_method='POST') {
		if (get_class($object) == "Form" && $object->isEncrypted()) { // object is a Form
			$form_object_decrypted = $GLOBALS['form_object_decrypted'];
			if (!in_array($object, $form_object_decrypted)) {
				$temp_var_form = "";
				$name = "EncryptData_".$name;
				$form_object_decrypted[] = $object;
				$submit_method = $object->getMethod();
				if ($submit_method == "POST") {
					if (isset($_POST[$name]) && is_array($_POST[$name])) {
						for ($i=0; $i < sizeof($_POST[$name]); $i++) {
							$temp_var_form .= $object->getEncryptObject()->decrypt($_POST[$name][$i]);
						}
					}
				} else if (isset($_GET[$name]) && is_array($_GET[$name])) {
					for ($i=0; $i < sizeof($_GET[$name]); $i++) {
						$temp_var_form .= $object->getEncryptObject()->decrypt($_GET[$name][$i]);
					}
				}
				if ($temp_var_form != "") {
					parse_str($temp_var_form, $array_request);
					if ($submit_method == "POST") {
						$_POST = array_merge($_POST, $array_request);
					} else {
						$_GET = array_merge($_GET, $array_request);
					}
				}
			}
		} else if (method_exists($object, "isEncrypted") && $object->isEncrypted()) { // Encrypted object
			if ($submit_method == "POST") {
				parse_str($_POST[$name], $array_request);
				$_POST = array_merge($_POST, $array_request);
				
				$temp_var = "";
				$name = "EncryptData_".$name;
				if (isset($_POST[$name]) && is_array($_POST[$name])) {
					for ($i=0; $i < sizeof($_POST[$name]); $i++) {
						$temp_var .= $object->getEncryptObject()->decrypt($_POST[$name][$i]);
					}
				}
				return $temp_var;
			} else {
				parse_str($_GET[$name], $array_request);
				$_GET = array_merge($_GET, $array_request);
				
				$temp_var = "";
				$name = "EncryptData_".$name;
				if (isset($_GET[$name]) && is_array($_GET[$name])) {
					for ($i=0; $i < sizeof($_GET[$name]); $i++) {
						$temp_var .= $object->getEncryptObject()->decrypt($_GET[$name][$i]);
					}
				}
				return $temp_var;
			}
		} else {
			// return request data
			if ($submit_method == "POST") {
				return $_POST[$name];
			} else {
				return $_GET[$name];
			}
		}
	}
?>
