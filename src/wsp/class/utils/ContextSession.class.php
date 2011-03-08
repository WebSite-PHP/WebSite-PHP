<?php
/**
 * PHP file wsp\class\utils\ContextSession.class.php
 * @package utils
 */
/**
 * Class ContextSession
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package utils
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 03/10/2010
 * @version     1.0.57
 * @access      public
 * @since       1.0.36
 */

class ContextSession {
	
	/**
	 * Method add
	 * @access public
	 * @param mixed $key 
	 * @param mixed $string_or_object 
	 */
	public static function add($key, $string_or_object) {
		if (!is_array($_SESSION['wsp_context_session'])) {
			$_SESSION['wsp_context_session'] = array();
		}
		if (gettype($string_or_object) == "object" || gettype($string_or_object) == "array") {
			$_SESSION['wsp_context_session'][$key] = array('serialize' => true, 'value' => serialize($string_or_object));
		} else {
			$_SESSION['wsp_context_session'][$key] = array('serialize' => false, 'value' => $string_or_object);
		}
	}
	
	/**
	 * Method get
	 * @access public
	 * @param mixed $key 
	 * @return mixed
	 * @since 1.0.35
	 */
	public static function get($key) {
		if (!is_array($_SESSION['wsp_context_session'])) {
			$_SESSION['wsp_context_session'] = array();
		}
		if (isset($_SESSION['wsp_context_session'][$key])) {
			if ($_SESSION['wsp_context_session'][$key]['serialize']) {
				return unserialize($_SESSION['wsp_context_session'][$key]['value']);
			} else {
				return $_SESSION['wsp_context_session'][$key]['value'];
			}
		} else {
			return null;
		}
	}
}
?>
