<?php
/**
 * PHP file wsp\includes\utils_openssl.inc.php
 */
/**
 * WebSite-PHP file utils_openssl.inc.php
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 26/05/2011
 * @version     1.0.99
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
				if (DEBUG) {
					while ($msg = openssl_error_string()) {
						$error .= $msg."<br />\n";
					}
				}
		    if ($GLOBALS['__AJAX_PAGE__'] == true && $GLOBALS['__AJAX_LOAD_PAGE__'] == false) {
		    	header('HTTP/1.1 500 Error: generation private key');
		    	echo $error;
		    	exit;
		    } else {
		    	$error = "Error generation private key".($error!=""?" : ".$error:"");
		    	throw new NewException($error, 0, getDebugBacktrace(1));
		    }
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
				if (DEBUG) {
					while ($msg = openssl_error_string()) {
						$error .= $msg."<br />\n";
					}
			  }
		    if ($GLOBALS['__AJAX_PAGE__'] == true && $GLOBALS['__AJAX_LOAD_PAGE__'] == false) {
		    	header('HTTP/1.1 500 '.__(DECRYPT_ERROR));
		    	echo $error;
		    	exit;
		    } else {
		    	$error = __(DECRYPT_ERROR).($error!=""?" : ".$error:"");
		    	throw new NewException($error, 0, getDebugBacktrace(1));
		    }
			}
		} else {
			$error = "";
			if (DEBUG) {
				while ($msg = openssl_error_string()) {
					$error .= $msg."<br />\n";
				}
		  }
		  if ($GLOBALS['__AJAX_PAGE__'] == true && $GLOBALS['__AJAX_LOAD_PAGE__'] == false) {
	    	header('HTTP/1.1 500 Error: parsing private key');
	    	echo $error;
	    	exit;
	    } else {
	    	$error = "Error parsing private key".($error!=""?" : ".$error:"");
		    throw new NewException($error, 0, getDebugBacktrace(1));
	    }
		}
		return "";
	}
	
	// use by Page and WebSitePhpEventObject
	global $form_object_decrypted;
	$form_object_decrypted = array();
	function decryptRequestEncryptData($object, $name, $submit_method='POST') {
		$decrypt = false;
		if (get_class($object) == "Form") { // object is a Form
			$form_object_decrypted = $GLOBALS['form_object_decrypted'];
			if (!in_array($object, $form_object_decrypted)) {
				$form_object_decrypted[] = $object;
				$submit_method = $object->getMethod();
				if ($submit_method == "POST") {
					if (isset($_POST[$name]) && $_POST[$name] != "") {
						parse_str($object->getEncryptObject()->decrypt($_POST[$name]), $_POST);
					}
				} else if (isset($_GET[$name]) && $_GET[$name] != "") {
					parse_str($object->getEncryptObject()->decrypt($_GET[$name]), $_GET);
				}
			}
		} else if (method_exists($object, "isEncrypted") && $object->isEncrypted()) { // Encrypted object
			if ($submit_method == "POST") {
				return $object->getEncryptObject()->decrypt($_POST[$name]);
			} else {
				return $object->getEncryptObject()->decrypt($_GET[$name]);
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
