<?php
/**
 * PHP file wsp\class\utils\SharedMemory.class.php
 * @package utils
 */
/**
 * Class SharedMemory
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package utils
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.103
 */

class SharedMemory {
	private static $handle        = null; // only set if in transaction mode.
	private static $wsp_shared_memory = null;
	
	/**
	 * Method _open
	 * @access static
	 * @return mixed
	 * @since 1.0.103
	 */
	private static function _open() {
		$file = "wsp/shared_memory";
		$mode = 'a+';
		
		$option_perms = 0666 & ~umask();
		$mask = 0666 & ~$option_perms;
		$old_mask = umask($mask);
		$result = fopen($file, $mode);
		umask($old_mask);
		if (!$result) {
			throw new NewException("The WSP framework needs to create the file ".$file.". Please give write rights on the folder or create manually the file (with write rights).", 0, getDebugBacktrace(1));
		}
		return $result;
	}


	/**
	 * Method transaction_start
	 * @access static
	 * @return boolean
	 * @since 1.0.103
	 */
	private static function transaction_start() {
		if (!isset($handle)) {
			$handle = self::_open();
			return flock($handle, LOCK_EX); // exclusive lock
		}
		return false;
	}

	/**
	 * Method transaction_finish
	 * @access static
	 * @return boolean
	 * @since 1.0.103
	 */
	private static function transaction_finish() {
		if (isset($handle)) {
			$h = $handle;
			$handle = null;
			flock($h, LOCK_UN);
			return fclose($h);
		}
		return false;
	}

	/**
	 * Method fetch
	 * @access static
	 * @return mixed
	 * @since 1.0.103
	 */
	private static function fetch() {
		$h = null;
		if (isset($handle)) {
			$h = $handle;
		}
		else {
			$h = self::_open();
			flock($h, LOCK_SH); // shared lock for reading
		}
		fseek($h,0);
		$result = '';
		while (!feof($h)) {
			$result .= fread($h, 8192);
		}
		if (is_null($handle)) {
			flock($h, LOCK_UN);
			fclose($h);
		}
		return $result;
	}

	/**
	 * Method store
	 * @access static
	 * @param mixed $value 
	 * @since 1.0.103
	 */
	private static function store($value) {
		$h = null;
		if (isset($handle)) {
			$h = $handle;
		}
		else {
			$h = self::_open();
			flock($h, LOCK_EX); // exclusive lock for writing
		}
		ftruncate($h,0);
		$result = fwrite($h, $value);
		if (is_null($handle)) {
			flock($h, LOCK_UN);
			fclose($h);
		}
	}
	
	/**
	 * Method add
	 * @access static
	 * @param mixed $key 
	 * @param mixed $string_or_object 
	 * @since 1.0.103
	 */
	public static function add($key, $string_or_object) {
		self::transaction_start();
		$tmp_mem = self::fetch();
		if ($tmp_mem != "") {
			$wsp_shared_memory = unserialize($tmp_mem);
		} else {
			$wsp_shared_memory = array();
		}
		unset($wsp_shared_memory[$key]);
		if (gettype($string_or_object) == "object" || gettype($string_or_object) == "array") {
			$wsp_shared_memory[$key] = array('serialize' => true, 'value' => serialize($string_or_object));
		} else {
			$wsp_shared_memory[$key] = array('serialize' => false, 'value' => $string_or_object);
		}
		self::store(serialize($wsp_shared_memory));
		self::transaction_finish();
	}
	
	/**
	 * Method get
	 * @access static
	 * @param mixed $key 
	 * @return mixed
	 * @since 1.0.103
	 */
	public static function get($key) {
		self::transaction_start();
		$tmp_mem = self::fetch();
		if ($tmp_mem != "") {
			$wsp_shared_memory = unserialize($tmp_mem);
		} else {
			$wsp_shared_memory = array();
			self::store(serialize($wsp_shared_memory));
		}
		self::transaction_finish();
		
		if (isset($wsp_shared_memory[$key])) {
			if ($wsp_shared_memory[$key]['serialize']) {
				return unserialize($wsp_shared_memory[$key]['value']);
			} else {
				return $wsp_shared_memory[$key]['value'];
			}
		} else {
			return null;
		}
	}
	
	/**
	 * Method toString
	 * @access static
	 * @return mixed
	 * @since 1.0.103
	 */
	public static function toString() {
		self::transaction_start();
		$tmp_mem = self::fetch();
		self::transaction_finish();
		return echo_r(unserialize($tmp_mem));
	}
}
?>
