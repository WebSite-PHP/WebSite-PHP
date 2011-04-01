<?php
/**
 * PHP file wsp\class\utils\CacheFile.class.php
 * @package utils
 */
/**
 * Class CacheFile
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
 * @copyright   WebSite-PHP.com 24/03/2011
 * @version     1.0.68
 * @access      public
 * @since       1.0.64
 */

class CacheFile{
	var $file;
	var $binary;
	var $name;
	var $cache_time;
	var $exists = false;
	var $cache_reset_on_midnight = false;
	
	/**
	 * Constructor CacheFile
	 * @param string $filename path to cache file
	 * @param integer $cache_time cache time in seconds [default value: 0]
	 * @param boolean $binary [default value: false]
	 */
	function __construct($filename,$cache_time=0,$binary=false){
		$filename = str_replace("\\", "/", $filename);
		$project_folder = str_replace("wsp/class/utils", "", dirname(__FILE__));
		
		if (file_exists($filename)) {
			$this->exists = true;
		} else {
			$array_dir = explode("/", str_replace($project_folder, "", $filename));
			if (!is_dir(substr(0, strrpos($filename, "/"), $filename))) {
				$create_folder = "";
				for ($i=0; $i < sizeof($array_dir)-1; $i++) {
					$create_folder .= $array_dir[$i]."/";
					if (!is_dir($create_folder) && $create_folder != "/") {
						if (!mkdir($create_folder)) {
							$this->halt("Can't create folder ".$create_folder.".");
						}
					}
				}
			}
		}
		
		$this->name=$filename;
		$this->binary=$binary;
		$this->cache_time=$cache_time;
		
		$cache_file_existe = (@file_exists($this->name)) ? @filemtime($this->name) : 0;
		
		$read_current_cache = false;
		// cache is always to define time
		if ($cache_file_existe > time() - $this->cache_time) {
			$read_current_cache = true;
			
			// if cache_reset_on_midnight is true and the caching file has not the same date like today
			if ($this->cache_reset_on_midnight && date("Ymd", $cache_file_existe) != date("Ymd")) {
				$read_current_cache = false;
			}
		}
		
		if (!$read_current_cache) {
			unlink($filename);
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
	 * Method resetCacheOnMidnight
	 * @access public
	 * @since 1.0.64
	 */
	public function resetCacheOnMidnight() {
		$this->cache_reset_on_midnight = true;
	}
	
	/**
	 * Method readCache
	 * @access public
	 * @return string|boolean return false if no cache or old cache
	 * @since 1.0.64
	 */
	public function readCache(){
		$cache = "";
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
	 * Method writeCache
	 * @access public
	 * @param mixed $data 
	 * @return boolean
	 * @since 1.0.64
	 */
	public function writeCache($data){
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
}
?>
