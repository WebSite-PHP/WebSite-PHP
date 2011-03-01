<?php
/**
 * Description of PHP file wsp\class\utils\File.class.php
 * Class File
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
 * @copyright   WebSite-PHP.com 03/10/2010
 *
 * @version     1.0.30
 * @access      public
 * @since       1.0.13
 */

/**
* File handling class
*
* @author    Sven Wagener <wagener_at_indot_dot_de>
* @include 	 Funktion:_include_
*
*/
class File{
	var $file;
	var $binary;
	var $name;
	var $size;
	var $exists = false;
	
	var $debug=true;
	var $action_before_reading=false;
	
	/**
	* Constructor of class
	* @param string $filename The name of the file
	* @param boolean $binarty Optional. If file is a binary file then set TRUE, otherwise FALSE
	* @desc Constructor of class
	*/
	function File($filename,$binary=false,$delete_if_exists=false){
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
		
		if ($delete_if_exists && $this->exists) {
			if (!unlink($filename)) {
				$this->halt("Can't delete exists file ".$filename.".");
			}
		}
		
		$this->name=$filename;
		$this->binary=$binary;
		
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
	* Close the file
	*/
	function close(){
		fclose($this->file);
	}
	
	/**
	* Close the file
	*/
	function exists(){
		return $this->exists;
	}
	
	/**
	* Returns the filesize in bytes
	* @return int $filesize The filesize in bytes
	* @desc Returns the filesize in bytes
	*/
	function get_size(){
		return filesize($this->name);
	}
	
	/**
	* Returns the timestamp of the last change
	* @return timestamp $timestamp The time of the last change as timestamp
	* @desc Returns the timestamp of the last change
	*/
	function get_time(){
		return fileatime($this->name);
	}
	
	/**
	* Returns the filename
	* @return string $filename The filename
	* @desc Returns the filename
	*/
	function get_name(){
		return $this->name;
	}
	
	/**
	* Returns user id of the file
	* @return string $user_id The user id of the file
	* @desc Returns user id of the file
	*/
	function get_owner_id(){
		return fileowner($this->name);
	}
	
	/**
	* Returns group id of the file
	* @return string $group_id The group id of the file
	* @desc Returns group id of the file
	*/
	function get_group_id(){
		return filegroup($this->name);
	}
	
	/**
	* Returns the suffix of the file
	* @return string $suffix The suffix of the file. If no suffix exists FALSE will be returned
	* @desc Returns the suffix of the file
	*/
	function get_suffix(){
		$file_array=explode("\.",$this->name); // Splitting prefix and suffix of real filename
		$suffix=$file_array[count($file_array)-1]; // Returning file type
		if(strlen($suffix)>0){
			return $suffix;
		}else{
			return false;
		}
	}
	
	/**
	* Sets the actual pointer position
	* @return int $offset Returns the actual pointer position
	* @desc Returns the actual pointer position
	*/
	function pointer_set($offset){
		$this->action_before_reading=true;
		return fseek($this->file,$offset);
	}
	
	/**
	* Returns the actual pointer position
	* @param int $offset Returns the actual pointer position
	* @desc Returns the actual pointer position
	*/
	function pointer_get(){
		return ftell($this->file);
	}
	
	/**
	* Reads a line from the file
	* @return string $line A line from the file. If is EOF, false will be returned
	* @desc Reads a line from the file
	*/
	function read_line(){
		if($this->action_before_reading){
			if(rewind($this->file)){
				$this->action_before_reading=false;
				return fgets($this->file);
			}else{
				$this->halt("Pointer couldn't be reset");
				return false;
			}
		}else{
			return fgets($this->file);
		}
	}
	
	/**
	* Reads data from a binary file
	* @return string $line Data from a binary file
	* @desc Reads data from a binary file
	*/
	function read_bytes($bytes,$start_byte=0){
		if(is_int($start_byte)){
			if(rewind($this->file)){
				if($start_byte>0){
					$this->pointer_set($start_byte);
					return fread($this->file,$bytes);
				}else{
					return fread($this->file,$bytes);
				}
			}else{
				$this->halt("Pointer couldn't be reset");
				return false;
			}
		}else{
			$this->halt("Start byte have to be an integer");
			return false;
		}
	}
	
	/**
	* Writes data to the file
	* @param string $data The data which have to be written
	* @return boolean $written Returns TRUE if data could be written, FALSE if not
	* @desc Writes data to the file
	*/
	function write($data){
		$this->action_before_reading=true;
		if(strlen($data)>0){
			if($this->binary){
				$bytes=fwrite($this->file,$data);
				if(is_int($bytes)){
					return $bytes;
				}else{
					$this->halt("Couldn't write data to file, please check permissions");
					return false;
				}
			}else{
				$bytes=fputs($this->file,$data);
				if(is_int($bytes)){
					return $bytes;
				}else{
					$this->halt("Couldn't write data to file, please check permissions");
					return false;
				}
			}
		}else{
			$this->halt("Data must have at least one byte");
		}
	}
	
	/**
	* Copies a file to the given destination
	* @param string $destination The new file destination
	* @return boolean $copied Returns TRUE if file could bie copied, FALSE if not
	* @desc Copies a file to the given destination
	*/
	function copy($destination){
		if(strlen($destination)>0){
			if(copy($this->name,$destination)){
				return true;
			}else{
				$this->halt("Couldn't copy file to destination, please check permissions");
				return false;
			}
		}else{
			$this->halt("Destination must have at least one char");
		}
	}
	
	/**
	* Searches a string in file
	* @param string $string The string which have to be searched
	* @return array $found_bytes Pointer offsets where string have been found. On no match, function returns false
	* @desc Searches a string in file
	*/
	function search($string){
		if(strlen($string)!=0){
			
			$offsets=array();
			
			$offset=$this->pointer_get();
			rewind($this->file);
			
			// Getting all data from file
			$data=fread($this->file,$this->get_size());
			
		    // Replacing \r in windows new lines
			$data=preg_replace("[\r]","",$data);
			
			$found=false;
			$k=0;
			
			for($i=0;$i<strlen($data);$i++){
				
				$char=$data[$i];
				$search_char=$string[0];
				
				// If first char of string have been found and first char havn't been found
				if($char==$search_char && $found==false){
					$j=0;
					$found=true;
					$found_now=true;
				}				
				
				// If beginning of the string have been found and next char have been set
				if($found==true && $found_now==false){
					$j++;
					// If next char have been found
					if($data[$i]==$string[$j]){
						// If complete string have been matched
						if(($j+1)==strlen($string)){
							$found_offset=$i-strlen($string)+2;
							$offsets[$k++]=$found_offset;
						}						
					}else{
						$found=false;
					}
					
				}
				
				$found_now=false;				
			}
			
			$this->pointer_set($offset);
			
			return $offsets;
		}else{
			$this->halt("Search String have to be at least 1 chars");
		}
	}
	
	/**
	* Prints out a error message
	* @param string $message all occurred errors as array
	* @desc Returns all occurred errors
	*/
	function halt($message){
		if($this->debug){
			throw new NewException($message, 0, 8, __FILE__, __LINE__);
		}
	}
	
	/**
	* Switches to debug mode
	* @param boolean $switch
	* @desc Switches to debug mode
	*/
	function debug_mode($debug=true){
		$this->debug=$debug;
		if(!$this->file){
			$this->halt("File couln't be opened, please check permissions");
		}
	}
}
?>
