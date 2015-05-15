<?php
/**
 * PHP file wsp\class\utils\WspBannedVisitors.class.php
 * @package utils
 */
/**
 * Class WspBannedVisitors
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
 * @since       1.1.0
 */

class WspBannedVisitors {
	private static $handle        = null; // only set if in transaction mode.
	private static $wsp_banned_visitors = null;
	
	/**
	 * Method _open
	 * @access static
	 * @return mixed
	 * @since 1.1.0
	 */
	private static function _open() {
		$file = "wsp/wsp_banned_visitors";
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
	 * @since 1.1.0
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
	 * @since 1.1.0
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
	 * @since 1.1.0
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
	 * @since 1.1.0
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
	 * Method addIP
	 * @access static
	 * @param mixed $ip 
	 * @param double $duration [default value: 0]
	 * @since 1.1.0
	 */
	public static function addIP($ip, $duration=0) {
		self::transaction_start();
		$tmp_mem = self::fetch();
		if ($tmp_mem != "") {
			$wsp_banned_visitors = unserialize($tmp_mem);
		} else {
			$wsp_banned_visitors = array();
		}
		if (!isset($wsp_banned_visitors[$ip])) {
			$wsp_banned_visitors[$ip] = array();
		}
		if (!isset($wsp_banned_visitors[$ip]['cnt'])) {
			$wsp_banned_visitors[$ip]['cnt'] = 0;
		}
		$wsp_banned_visitors[$ip]['cnt'] = $wsp_banned_visitors[$ip]['cnt'] + 1;
		$wsp_banned_visitors[$ip]['dte'] = date("Y-m-d H:i:s");
		if ((isset($wsp_banned_visitors[$ip]['len']) && $duration != 0) || !isset($wsp_banned_visitors[$ip]['len'])) {
			$wsp_banned_visitors[$ip]['len'] = $duration;
		}
		self::store(serialize($wsp_banned_visitors));
		self::transaction_finish();
	}
	
	/**
	 * Method setIpBanned
	 * @access static
	 * @param mixed $ip 
	 * @param double $duration [default value: 0]
	 * @since 1.1.0
	 */
	public static function setIpBanned($ip, $duration=0) {
		self::transaction_start();
		$tmp_mem = self::fetch();
		if ($tmp_mem != "") {
			$wsp_banned_visitors = unserialize($tmp_mem);
		} else {
			$wsp_banned_visitors = array();
		}
		if (!isset($wsp_banned_visitors[$ip])) {
			$wsp_banned_visitors[$ip] = array();
		}
		if (!isset($wsp_banned_visitors[$ip]['cnt'])) {
			$wsp_banned_visitors[$ip]['cnt'] = 0;
		}
		if (!defined('MAX_BAD_URL_BEFORE_BANNED')) {
			define("MAX_BAD_URL_BEFORE_BANNED", 4);
		}
		$wsp_banned_visitors[$ip]['cnt'] = MAX_BAD_URL_BEFORE_BANNED;
		$wsp_banned_visitors[$ip]['dte'] = date("Y-m-d H:i:s");
		if ((isset($wsp_banned_visitors[$ip]['len']) && $duration != 0) || !isset($wsp_banned_visitors[$ip]['len'])) {
			$wsp_banned_visitors[$ip]['len'] = $duration;
		}
		self::store(serialize($wsp_banned_visitors));
		self::transaction_finish();
	}
	
	/**
	 * Method isBannedIp
	 * @access static
	 * @param mixed $ip 
	 * @return boolean
	 * @since 1.1.0
	 */
	public static function isBannedIp($ip) {
		self::transaction_start();
		$tmp_mem = self::fetch();
		if ($tmp_mem != "") {
			$wsp_banned_visitors = unserialize($tmp_mem);
		} else {
			$wsp_banned_visitors = array();
			self::store(serialize($wsp_banned_visitors));
		}
		self::transaction_finish();
		
		if (!defined('MAX_BAD_URL_BEFORE_BANNED')) {
			define("MAX_BAD_URL_BEFORE_BANNED", 4);
		}
		if (isset($wsp_banned_visitors[$ip])) {
			return ($wsp_banned_visitors[$ip]['cnt'] >= MAX_BAD_URL_BEFORE_BANNED);
		} else {
			return false;
		}
	}
	
	/**
	 * Method getIpNbBadAccess
	 * @access static
	 * @param mixed $ip 
	 * @return double
	 * @since 1.1.0
	 */
	public static function getIpNbBadAccess($ip) {
		self::transaction_start();
		$tmp_mem = self::fetch();
		if ($tmp_mem != "") {
			$wsp_banned_visitors = unserialize($tmp_mem);
		} else {
			$wsp_banned_visitors = array();
			self::store(serialize($wsp_banned_visitors));
		}
		self::transaction_finish();
		
		if (isset($wsp_banned_visitors[$ip])) {
			return $wsp_banned_visitors[$ip]['cnt'];
		} else {
			return 0;
		}
	}
	
	/**
	 * Method getBannedIpDuration
	 * @access static
	 * @param mixed $ip 
	 * @return double
	 * @since 1.1.0
	 */
	public static function getBannedIpDuration($ip) {
		self::transaction_start();
		$tmp_mem = self::fetch();
		if ($tmp_mem != "") {
			$wsp_banned_visitors = unserialize($tmp_mem);
		} else {
			$wsp_banned_visitors = array();
			self::store(serialize($wsp_banned_visitors));
		}
		self::transaction_finish();
		
		if (isset($wsp_banned_visitors[$ip])) {
			return $wsp_banned_visitors[$ip]['len'];
		} else {
			return 0;
		}
	}
	
	/**
	 * Method getBannedIpLastAccess
	 * @access static
	 * @param mixed $ip 
	 * @return double
	 * @since 1.1.0
	 */
	public static function getBannedIpLastAccess($ip) {
		self::transaction_start();
		$tmp_mem = self::fetch();
		if ($tmp_mem != "") {
			$wsp_banned_visitors = unserialize($tmp_mem);
		} else {
			$wsp_banned_visitors = array();
			self::store(serialize($wsp_banned_visitors));
		}
		self::transaction_finish();
		
		if (isset($wsp_banned_visitors[$ip])) {
			return $wsp_banned_visitors[$ip]['dte'];
		} else {
			return 0;
		}
	}
	
	/**
	 * Method getBannedVisitors
	 * @access static
	 * @return mixed
	 * @since 1.1.0
	 */
	public static function getBannedVisitors() {
		self::transaction_start();
		$tmp_mem = self::fetch();
		if ($tmp_mem != "") {
			$wsp_banned_visitors = unserialize($tmp_mem);
		} else {
			$wsp_banned_visitors = array();
			self::store(serialize($wsp_banned_visitors));
		}
		self::transaction_finish();
		
		return $wsp_banned_visitors;
	}
	
	/**
	 * Method resetBannedIP
	 * @access static
	 * @param mixed $ip 
	 * @since 1.1.0
	 */
	public static function resetBannedIP($ip) {
		self::transaction_start();
		$tmp_mem = self::fetch();
		if ($tmp_mem != "") {
			$wsp_banned_visitors = unserialize($tmp_mem);
		} else {
			$wsp_banned_visitors = array();
			self::store(serialize($wsp_banned_visitors));
		}
		
		if (isset($wsp_banned_visitors[$ip])) {
			unset($wsp_banned_visitors[$ip]);
			self::store(serialize($wsp_banned_visitors));
		}
		self::transaction_finish();
	}
	
	/**
	 * Method toString
	 * @access static
	 * @return mixed
	 * @since 1.1.0
	 */
	public static function toString() {
		self::transaction_start();
		$tmp_mem = self::fetch();
		self::transaction_finish();
		return echo_r(unserialize($tmp_mem));
	}
}
?>
