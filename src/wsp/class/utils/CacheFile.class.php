<?php
/**
 * PHP file wsp\class\utils\CacheFile.class.php
 * @package utils
 */
/**
 * Class CacheFile
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2016 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package utils
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 10/05/2016
 * @version     1.2.14
 * @access      public
 * @since       1.0.64
 */

class CacheFile {
	/**#@+
	* cache time
	* @access public
	* @var integer
	*/
	const CACHE_TIME_1MIN = 60;
	const CACHE_TIME_2MIN = 120;
	const CACHE_TIME_10MIN = 600;
	const CACHE_TIME_20MIN = 1200;
	const CACHE_TIME_30MIN = 1800;
	const CACHE_TIME_1HOUR = 3600;
	const CACHE_TIME_2HOURS = 7200;
	const CACHE_TIME_3HOURS = 10800;
	const CACHE_TIME_4HOURS = 14400;
	const CACHE_TIME_6HOURS = 21600;
	const CACHE_TIME_8HOURS = 28800;
	const CACHE_TIME_10HOURS = 36000;
	const CACHE_TIME_12HOURS = 43200;
	const CACHE_TIME_1DAY = 86400;
	const CACHE_TIME_2DAYS = 172800;
	const CACHE_TIME_3DAYS = 259200;
	const CACHE_TIME_4DAYS = 345600;
	const CACHE_TIME_7DAYS = 604800;
	const CACHE_TIME_14DAYS = 1209600;
	const CACHE_TIME_1MONTH = 2678400;
	const CACHE_TIME_2MONTHS = 5270400;
	const CACHE_TIME_3MONTHS = 8035200;
	const CACHE_TIME_4MONTHS = 10713600;
	const CACHE_TIME_6MONTHS = 15724800;
	const CACHE_TIME_1YEAR = 31536000;
	const CACHE_TIME_2YEARS = 63072000;
	/**#@-*/
	
	var $file;
	var $filename;
	var $binary;
	var $name;
	var $cache_time;
	var $exists = false;
	var $read_current_cache = false;
	var $debug=true;
	
	/**
	 * Constructor CacheFile
	 * @param string $filename path to cache file
	 * @param integer $cache_time cache time in seconds [default value: 0]
	 * @param boolean $binary [default value: false]
	 * @param boolean $cache_reset_on_midnight [default value: false]
	 * @param string $cache_timezone 
	 * @param boolean $debug [default value: true]
	 */
	function __construct($filename, $cache_time=0, $binary=false, $cache_reset_on_midnight=false, $cache_timezone='', $debug=true){
		$this->debug = $debug;
		$filename = str_replace("\\", "/", $filename);
		
		$this->name=$filename;
		$this->filename=$filename;
		$this->binary=$binary;
		$this->cache_time=$cache_time;
		
		if (file_exists($filename)) {
			$this->exists = true;
		} else {
			$array_dir = explode("/", $filename);
			if (!is_dir(substr(0, strrpos($filename, "/"), $filename))) {
				$create_folder = "";
				for ($i=0; $i < sizeof($array_dir)-1; $i++) {
					$create_folder_before = $create_folder;
					$create_folder .= $array_dir[$i]."/";
					if (!is_dir($create_folder) && $create_folder != "/") {
						if (!mkdir($create_folder)) {
							if (!mkdir(realpath($create_folder_before)."/".$array_dir[$i]."/")) {
								$this->halt("Can't create folder ".$create_folder.".");
							}
						}
					}
				}
			}
		}
		
		$cache_file_existe = (@file_exists($this->name)) ? @filemtime($this->name) : 0;
		
		$this->read_current_cache = false;
		// cache is always to define time
		if ($cache_file_existe > time() - $this->cache_time) {
			$this->read_current_cache = true;
				
			// if cache_reset_on_midnight is true and the caching file has not the same date like today
			$date_cachefile = date("Ymd", $cache_file_existe);
			$date_timezone = date("Ymd");
			if ($cache_timezone == "") {
				$cache_timezone = date_default_timezone_get();
			}
			if ($cache_timezone != "") {
				// Compute date of the defined timezone to check if the day change
				$offset_server = SERVER_TIMEZONE_OFFSET_SECONDES;
				$tmp_date = new DateTime(null, new DateTimeZone($cache_timezone));
				$offset_timezone = $tmp_date->getOffset();
				if (is_numeric($offset_timezone) && is_numeric($offset_server)) {
					$diff_time = $offset_timezone - $offset_server;
					// compute dates with diff timezone
					$date_cachefile = date("Ymd", $cache_file_existe + $diff_time);
					$date_timezone = date("Ymd", time() + $diff_time);
				}
			}
			
			// if cache_reset_on_midnight is true and the caching file has not the same date like today
			if ($cache_reset_on_midnight && $date_cachefile != $date_timezone) {
				$this->read_current_cache = false;
			}
		}
		
		if($binary){
			$this->file=@fopen($filename,"a+b");
			if(!$this->file){
				$this->file=@fopen($filename,"rb");
			}
		}else{
			$this->file=@fopen($filename,"a+");
			if(!$this->file){
				$this->file=@fopen($filename,"r");
			}
		}
	}
	
	/**
	 * Method readCache
	 * @access public
	 * @return string|boolean return false if no cache or old cache
	 * @since 1.0.64
	 */
	public function readCache(){
		if (!$this->read_current_cache) {
			return false;
		}
		
		$cache = "";
		fseek($this->file, 0);
		while (($buffer = fgets($this->file, 4096)) !== false) {
			$cache .= $buffer;
		}
		if ($cache == "") {
			return false;
		} else {
			return $cache;
		}
	}
	
	/**
	 * Method isCached
	 * @access public
	 * @return mixed
	 * @since 1.1.9
	 */
	public function isCached() {
		return $this->read_current_cache;
	}
	
	/**
	 * Method writeCache
	 * @access public
	 * @param mixed $data 
	 * @return boolean
	 * @since 1.0.64
	 */
	public function writeCache($data){
		file_put_contents($this->filename, "");
		
		if(strlen($data)>0){
			if($this->binary){
				$bytes=fwrite($this->file,$data);
				if(is_int($bytes)){
					return $bytes;
				}else{
					return false;
				}
			}else{
				$bytes=fputs($this->file,$data);
				if(is_int($bytes)){
					return $bytes;
				}else{
					return false;
				}
			}
		}
	}
	
	/**
	 * Method close
	 * @access public
	 * @since 1.0.64
	 */
	public function close() {
		@fclose($this->file);
	}
	
	/**
	 * Method halt
	 * @access public
	 * @param mixed $message 
	 * @since 1.0.100
	 */
	public function halt($message){
		if($this->debug){
			throw new NewException($message." (filename: ".$this->name.")", 0, getDebugBacktrace(1));
		}
	}
	
	/**
	 * Method debug_mode
	 * @access public
	 * @param boolean $debug [default value: true]
	 * @since 1.0.59
	 */
	public function debug_mode($debug=true){
		$this->debug=$debug;
		if(!$this->file){
			$this->halt("File couln't be opened, please check permissions");
		}
	}
}
?>
