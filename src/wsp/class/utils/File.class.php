<?php
/**
 * PHP file wsp\class\utils\File.class.php
 * @package utils
 */
/**
 * Class File
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
 * @since       1.0.13
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
     * Constructor File
     * @param mixed $filename path to the file
     * @param boolean $binary [default value: false]
     * @param boolean $delete_if_exists [default value: false]
     * @param boolean $debug [default value: true]
     */
    function __construct($filename, $binary=false, $delete_if_exists=false, $debug=true){
        $this->debug = $debug;
        $filename = str_replace("\\", "/", $filename);

        $this->name=$filename;
        $this->binary=$binary;

        if (file_exists($filename)) {
            $this->exists = true;
        } else if (find($filename, "http://") == 0 && find($filename, "https://") == 0 && find($filename, "ftp://") == 0) {
            // we don't create a directory if it's a web file
            if (!is_dir(substr(0, strrpos($filename, "/"), $filename))) {
                $create_folder = "";
                $tmp_filename = $filename;
                if (ini_get('open_basedir') != "") {
                    $open_basedir_array = explode(":", ini_get('open_basedir'));
                    for ($i=0; $i < sizeof($open_basedir_array); $i++) {
                        if (trim($open_basedir_array[$i]) != "" && substr($filename, 0, strlen($open_basedir_array[$i])) == $open_basedir_array[$i]) {
                            $create_folder = $open_basedir_array[$i];
                            if ($create_folder[strlen($create_folder)-1] != "/") {
                                $create_folder .= "/";
                            }
                            $tmp_filename = substr($filename, strlen($create_folder));
                            break;
                        }
                    }
                }
                $array_dir = explode("/", $tmp_filename);
                for ($i=0; $i < sizeof($array_dir)-1; $i++) {
                    $create_folder_before = $create_folder;
                    $create_folder .= $array_dir[$i]."/";
                    if (!file_exists($dir) && !is_dir($create_folder) && $create_folder != "/") {
                        if (!mkdir($create_folder)) {
                            if (!mkdir(realpath($create_folder_before)."/".$array_dir[$i]."/")) {
                                $this->halt("Can't create folder ".$create_folder.".");
                            }
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
     * Method close
     * Close the file
     * @access public
     * @since 1.0.59
     */
    public function close(){
        @fclose($this->file);
    }

    /**
     * Method exists
     * Close the file
     * @access public
     * @return mixed
     * @since 1.0.35
     */
    public function exists(){
        return $this->exists;
    }

    /**
     * Method get_size
     * @access public
     * @return int $filesize The filesize in bytes
     * @since 1.0.35
     */
    public function get_size(){
        return filesize($this->name);
    }

    /**
     * Method get_time
     * @access public
     * @return timestamp $timestamp The time of the last change as timestamp
     * @since 1.0.35
     */
    public function get_time(){
        return fileatime($this->name);
    }

    /**
     * Method get_name
     * @access public
     * @return string $filename The filename
     * @since 1.0.35
     */
    public function get_name(){
        return $this->name;
    }

    /**
     * Method get_owner_id
     * @access public
     * @return string $user_id The user id of the file
     * @since 1.0.35
     */
    public function get_owner_id(){
        return fileowner($this->name);
    }

    /**
     * Method get_group_id
     * @access public
     * @return string $group_id The group id of the file
     * @since 1.0.35
     */
    public function get_group_id(){
        return filegroup($this->name);
    }

    /**
     * Method get_suffix
     * @access public
     * @return string $suffix The suffix of the file. If no suffix exists FALSE will be returned
     * @since 1.0.35
     */
    public function get_suffix(){
        $file_array=explode("\.",$this->name); // Splitting prefix and suffix of real filename
        $suffix=$file_array[count($file_array)-1]; // Returning file type
        if(strlen($suffix)>0){
            return $suffix;
        }else{
            return false;
        }
    }

    /**
     * Method pointer_set
     * @access public
     * @param mixed $offset
     * @return int $offset Returns the actual pointer position
     * @since 1.0.35
     */
    public function pointer_set($offset){
        $this->action_before_reading=true;
        return fseek($this->file,$offset);
    }

    /**
     * Method pointer_get
     * @access public
     * @return mixed
     * @since 1.0.35
     */
    public function pointer_get(){
        return ftell($this->file);
    }

    /**
     * Method read
     * @access public
     * @return string return data
     * @since 1.0.64
     */
    public function read(){
        if($this->action_before_reading){
            rewind($this->file);
        }
        $data = "";
        while (($buffer = fgets($this->file, 4096)) !== false) {
            $data .= $buffer;
        }
        return $data;
    }

    /**
     * Method read_line
     * @access public
     * @return string $line A line from the file. If is EOF, false will be returned
     * @since 1.0.35
     */
    public function read_line(){
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
     * Method read_bytes
     * @access public
     * @param mixed $bytes
     * @param double $start_byte [default value: 0]
     * @return string $line Data from a binary file
     * @since 1.0.35
     */
    public function read_bytes($bytes,$start_byte=0){
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
     * Method write
     * @access public
     * @param string $data The data which have to be written
     * @return boolean $written Returns TRUE if data could be written, FALSE if not
     * @since 1.0.35
     */
    public function write($data){
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
     * Method copy
     * @access public
     * @param string $destination The new file destination
     * @return boolean $copied Returns TRUE if file could bie copied, FALSE if not
     * @since 1.0.35
     */
    public function copy($destination){
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
     * Method search
     * @access public
     * @param string $string The string which have to be searched
     * @return array $found_bytes Pointer offsets where string have been found. On no match, function returns false
     * @since 1.0.35
     */
    public function search($string){
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
     * Method halt
     * @access public
     * @param string $message all occurred errors as array
     * @since 1.0.59
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
