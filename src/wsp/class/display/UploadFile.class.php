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
 * @copyright   WebSite-PHP.com 11/04/2013
 * @version     1.2.5
 * @access      public
 * @since       1.2.3
 */

class UploadFile extends WebSitePhpEventObject {
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
	
	private $is_changed = false;
	private $onchange = "";
	private $callback_onchange = "";
	private $callback_onchange_params = array();
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
		
		JavaScriptInclude::getInstance()->addToEnd(BASE_URL."wsp/js/jquery.upload.js", "", true);
	}
	
	/**
	 * Method setValue
	 * @access public
	 * @param mixed $value 
	 * @return UploadFile
	 * @since 1.2.5
	 */
	public function setValue($value) {
		// This method exists only for technical reason  
		return $this;
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
	 * Method onChange
	 * @access public
	 * @param mixed $str_function 
	 * @param mixed $arg1 [default value: null]
	 * @param mixed $arg2 [default value: null]
	 * @param mixed $arg3 [default value: null]
	 * @param mixed $arg4 [default value: null]
	 * @param mixed $arg5 [default value: null]
	 * @return UploadFile
	 * @since 1.2.5
	 */
	public function onChange($str_function, $arg1=null, $arg2=null, $arg3=null, $arg4=null, $arg5=null) {
		if (!$this->is_ajax_event) {
			throw new NewException(get_class($this)."->onChange(): onChange function is available only for UploadFile with ajax event. Please call the function ".get_class($this)."->setAjaxEvent().", 0, getDebugBacktrace(1));
		}
		
		$args = func_get_args();
		$this->callback_onchange_params = $args;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method onChangeJs
	 * @access public
	 * @param mixed $js_function 
	 * @return UploadFile
	 * @since 1.2.5
	 */
	public function onChangeJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript") {
			throw new NewException(get_class($this)."->onChangeJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript") {
			$js_function = $js_function->render();
		}
		$this->onchange = trim($js_function);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/* Intern management of UploadFile */
	/**
	 * Method setChange
	 * @access public
	 * @return UploadFile
	 * @since 1.2.5
	 */
	public function setChange() {
		if ($GLOBALS['__LOAD_VARIABLES__']) {
			$GLOBALS['__WSP_OBJECT_UPLOADFILE_CHANGED__'] = true;
			$this->is_changed = true; 
		}
		return $this;
	}
	
	/**
	 * Method isChanged
	 * @access public
	 * @return mixed
	 * @since 1.2.5
	 */
	public function isChanged() {
		return $this->is_changed;
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
		
		// check if the UploadFile is linked to a Form with Ajax button
		if ($this->form_object != null) {
			$array_form_object = $this->form_object->getFormObjects();
			for ($i=0; $i < sizeof($array_form_object); $i++) {
				if (get_class($array_form_object[$i]) == "Button") {
					if ($array_form_object[$i]->isAjaxEvent()) {
						throw new NewException(get_class($this)." error: You cannot use ajax event on a Button if you include ".get_class($this)." in a Form object.", 0, getDebugBacktrace(1));
						break;
					}
				}
			}
		}
		
		// check if the UploadFile is used in AjaxLoadPage (Tabs, DialogBox)
		if ($this->getPage()->isAjaxLoadPage()) {
			// In this case UploadFile need to be sublit with ajax event
			if (!$this->is_ajax_event) {
				throw new NewException(get_class($this)." error: You need to use ".get_class($this)." with ajax event (".get_class($this)."->setAjaxEvent()) when loaded in AjaxLoadPage (Tabs, DialogBox).", 0, getDebugBacktrace(1));
			}
			if ($this->form_object != null) {
				throw new NewException(get_class($this)." error: You cannot use ".get_class($this)." in a Form object when loaded in AjaxLoadPage (Tabs, DialogBox).", 0, getDebugBacktrace(1));
			}
		}
		
		if (sizeof($this->callback_onchange_params) > 0) {
			$args = $this->callback_onchange_params;
			$str_function = array_shift($args);
			$this->callback_onchange = $this->loadCallbackMethod($str_function, $args);
		}
		
		if ($this->callback_onchange != "") {
			$html .= "<input type='hidden' id='Callback_".$this->getEventObjectName()."' name='Callback_".$this->getEventObjectName()."' value=''/>\n";
		}
		if ($this->is_ajax_event) {
			$html .= $this->getJavascriptTagOpen();
			$html .= $this->getAjaxEventFunctionRender();
			$html .= $this->getJavascriptTagClose();
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
		$html .= "\$('#UploadFile_Button_".$this->id."').click(function(event){\n";
		$html .= "	\$('#".$this->id."').click()\n";
		$html .= "});\n";
		$html .= "\$('#".$this->id."').change(function(){\n";
		$html .= "	var current_file = myReplaceAll(\$(this).val(), '\\\\', '/').split('/');\n";
		$html .= "	current_file = current_file[current_file.length-1];\n";
		$html .= "	\$('#UploadFile_Path_".$this->id."').val(current_file);\n";
		if ($this->onchange != "" || $this->callback_onchange != "") {
			$html .= "	".str_replace("\n", "", $this->getObjectEventValidationRender($this->onchange, $this->callback_onchange))."\n";
		}
		$html .= "});";
		$html .= $this->getJavascriptTagClose();
		
		$this->object_change = false;
		return $html;
	}
}
?>
