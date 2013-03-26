<?php
/**
 * PHP file wsp\class\display\UploadFile.class.php
 * @package display
 */
/**
 * Class UploadFile
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2013 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 25/03/2013
 * @version     1.2.3
 * @access      public
 * @since       1.2.3
 */

class UploadFile extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	protected $class_name = "";
	protected $page_object = null;
	protected $form_object = null;
	
	private $array_mime_types = array();
	private $file_size_limit = -1;
	private $file_path = "";
	private $button_value = "";
	private $class = "";
	private $width = "";
	/**#@-*/
	
	/**
	 * Constructor UploadFile
	 * @param mixed $page_or_form_object 
	 * @param string $name 
	 * @param string $id 
	 */
	function __construct($page_or_form_object, $name='', $id='') {
		parent::__construct();
		
		if (!isset($page_or_form_object) || gettype($page_or_form_object) != "object" || (!is_subclass_of($page_or_form_object, "Page") && get_class($page_or_form_object) != "Form")) {
			throw new NewException("Argument page_or_form_object for ".get_class($this)."::__construct() error", 0, getDebugBacktrace(1));
		}
		
		if (is_subclass_of($page_or_form_object, "Page")) {
			$this->class_name = get_class($page_or_form_object);
			$this->page_object = $page_or_form_object;
			$this->form_object = null;
		} else {
			$this->page_object = $page_or_form_object->getPageObject();
			$this->class_name = get_class($this->page_object)."_".$page_or_form_object->getName();
			$this->form_object = $page_or_form_object;
			$this->form_object->setEnctypeMultipart();
		}
		
		if ($name == "") {
			$name = $this->page_object->createObjectName($this);
			$this->name = $name;
		} else {
			$exist_object = $this->page_object->existsObjectName($name);
			$this->name = $name;
			if ($exist_object != false) {
				throw new NewException("Tag name \"".$name."\" for object ".get_class($this)." already use for other object ".get_class($exist_object), 0, getDebugBacktrace(1));
			}
			$this->page_object->addEventObject($this, $this->form_object);
		}
		
		if ($id == "") {
			$this->id = $name;
		} else {
			$this->id = $id;
		}
		
		$this->button_value = __(WSP_BTN_UPLOAD_FILE);
	}
	
	/**
	 * Method getName
	 * @access public
	 * @return mixed
	 * @since 1.2.3
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * Method getId
	 * @access public
	 * @return mixed
	 * @since 1.2.3
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Method getEventObjectName
	 * @access public
	 * @return mixed
	 * @since 1.2.3
	 */
	public function getEventObjectName() {
		return $this->class_name."_".$this->name;
	}
	
	/**
	 * Method getFormObject
	 * @access public
	 * @return mixed
	 * @since 1.2.3
	 */
	public function getFormObject() {
		return $this->form_object;
	}
	
	/**
	 * Method setClass
	 * @access public
	 * @param mixed $class 
	 * @return UploadFile
	 * @since 1.2.3
	 */
	public function setClass($class) {
		$this->class = $class;
		return $this;
	}
	
	/**
	 * Method setWidth
	 * @access public
	 * @param integer $width 
	 * @return UploadFile
	 * @since 1.2.3
	 */
	public function setWidth($width) {
		$this->width = $width;
		return $this;
	}
	
	/**
	 * Method setButtonValue
	 * @access public
	 * @param mixed $button_value 
	 * @return UploadFile
	 * @since 1.2.3
	 */
	public function setButtonValue($button_value) {
		$this->button_value = $button_value;
		return $this;
	}
	
	/**
	 * Method setAuthorizedMimeTypes
	 * @access public
	 * @param mixed $mime_types 
	 * @return UploadFile
	 * @since 1.2.3
	 */
	public function setAuthorizedMimeTypes($mime_types) {
		if (!is_array($mime_types)) {
			$mime_types = array($mime_types);
		}
		$this->array_mime_types = $mime_types;
		return $this;
	}
	
	/**
	 * Method setFileSizeLimit
	 * @access public
	 * @param mixed $bytes_size 
	 * @return UploadFile
	 * @since 1.2.3
	 */
	public function setFileSizeLimit($bytes_size) {
		$this->file_size_limit = $bytes_size;
		return $this;
	}
	
	/**
	 * Method getFileMimeType
	 * @access public
	 * @return mixed
	 * @since 1.2.3
	 */
	public function getFileMimeType() {
		$file_info = new finfo(FILEINFO_MIME);
		$mime_type = split(";", $file_info->buffer(file_get_contents($this->getFilePath())));  // e.g. gives "image/jpeg"
		return trim($mime_type[0]);
	}
	
	/**
	 * Method checkMimeType
	 * @access public
	 * @return boolean
	 * @since 1.2.3
	 */
	public function checkMimeType() {
		$mime_type = $this->getFileMimeType();
		if (in_array($mime_type, $this->array_mime_types)) {
			return true;
		}
		return false;
	}
	
	/**
	 * Method checkFileSize
	 * @access public
	 * @return boolean
	 * @since 1.2.3
	 */
	public function checkFileSize() {
		$size = $this->getFileSize();
		if ($size <= $this->file_size_limit || $this->file_size_limit == -1) {
			return true;
		}
		return false;
	}
	
	/**
	 * Method getFileSize
	 * @access public
	 * @return mixed
	 * @since 1.2.3
	 */
	public function getFileSize() {
		return filesize($this->getFilePath());
	}
	
	/**
	 * Method isEmptyFile
	 * @access public
	 * @return mixed
	 * @since 1.2.3
	 */
	public function isEmptyFile() {
		return ($this->getFileSize() == 0);
	}
	
	/**
	 * Method moveFile
	 * @access public
	 * @param mixed $destination_path 
	 * @return boolean
	 * @since 1.2.3
	 */
	public function moveFile($destination_path) {
		if (sizeof($this->array_mime_types) > 0) {
			if (!$this->checkMimeType()) {
				throw new NewException("Mime type not supported.", 0, getDebugBacktrace(1));
			}
		}
		if (!$this->checkFileSize()) {
			throw new NewException("Uploaded file is bigger than file size limit.", 0, getDebugBacktrace(1));
		}
		
		if (move_uploaded_file($this->getFilePath(), $destination_path.$_FILES[$this->getEventObjectName()]["name"])) {
			$this->file_path = $destination_path.$_FILES[$this->getEventObjectName()]["name"];
			return true;
		}
		return false;
	}
	
	/**
	 * Method getFileContent
	 * @access public
	 * @return mixed
	 * @since 1.2.3
	 */
	public function getFileContent() {
		if (sizeof($this->array_mime_types) > 0) {
			if (!$this->checkMimeType()) {
				throw new NewException("Mime type not supported.", 0, getDebugBacktrace(1));
			}
		}
		if (!$this->checkFileSize()) {
			throw new NewException("Uploaded file is bigger than file size limit.", 0, getDebugBacktrace(1));
		}
		
		$file = new File($this->getFilePath());
		$content = $file->read();
		$file->close();
		
		return $content;
	}
	
	/**
	 * Method getFileName
	 * @access public
	 * @return mixed
	 * @since 1.2.3
	 */
	public function getFileName() {
		if (sizeof($this->array_mime_types) > 0) {
			if (!$this->checkMimeType()) {
				throw new NewException("Mime type not supported.", 0, getDebugBacktrace(1));
			}
		}
		if (!$this->checkFileSize()) {
			throw new NewException("Uploaded file is bigger than file size limit.", 0, getDebugBacktrace(1));
		}
		
		return $_FILES[$this->getEventObjectName()]["name"];
	}
	
	/**
	 * Method getFilePath
	 * @access public
	 * @return mixed
	 * @since 1.2.3
	 */
	public function getFilePath() {
		if ($this->file_path == "") {
			$this->file_path = $_FILES[$this->getEventObjectName()]["tmp_name"];
		}
		return $this->file_path;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object UploadFile
	 * @since 1.2.3
	 */
	public function render($ajax_render=false) {
		$html = "";
		
		// TODO: to remove when UploadFile will be compatible with ajax event
		if ($this->form_object != null) {
			$array_form_object = $this->form_object->getFormObjects();
			for ($i=0; $i < sizeof($array_form_object); $i++) {
				if (get_class($array_form_object[$i]) == "Button") {
					if ($array_form_object[$i]->isAjaxEvent() || $this->getPage()->isAjaxLoadPage()) {
						throw new NewException("UploadFile is not yet compatible with Ajax event.", 0, getDebugBacktrace(1));
					}
				}
			}
		}
		
		// Generate HTML
		$html .= "<span class=\"UploadFile\">";
		$html .= "<input type=\"text\" id=\"UploadFile_Path_".$this->id."\"";
		if ($this->width != "") {
			$html .= " width=\"".$this->width."\"";
		}
		$html .= " disabled/>";
		$html .= "<label id=\"UploadFile_Button_".$this->id."\" class=\"button";
		if ($this->class != "") {
			$html .= " ".$this->class."'";
		}
		$html .= "\">".$this->button_value."</label><input type='file' name='".$this->getEventObjectName()."' id='".$this->id."' class='UploadFileInput'/>";
		$html .= "</span>";
		
		$html .= $this->getJavascriptTagOpen();
		$html .= "\$('#UploadFile_Button_".$this->id."').click(function(event){";
		$html .= "	\$('#".$this->id."').click()";
		$html .= "});";
		$html .= "\$('#".$this->id."').change(function(){";
		$html .= "	var current_file = myReplaceAll(\$(this).val(), '\\\\', '/').split('/');";
		$html .= "	current_file = current_file[current_file.length-1];";
		$html .= "	\$('#UploadFile_Path_".$this->id."').val(current_file);";
		$html .= "});";
		$html .= $this->getJavascriptTagClose();
		
		$this->object_change = false;
		return $html;
	}
}
?>
