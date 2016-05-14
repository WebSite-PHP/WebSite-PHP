<?php
/**
 * PHP file wsp\class\display\UploadFile.class.php
 * @package display
 */
/**
 * Class UploadFile
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2016 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 11/05/2016
 * @version     1.2.14
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
    private $file_size_limit_str = "";
	private $file_path = array();
	private $button_value = "";
	private $class = "";
	private $width = "";
	private $tooltip = "";
	private $is_multiple = false;
    private $select_file_icon = "";

    private $file_size_limit_js_check = false;
    private $mime_types_js_check = false;
	
	private $is_changed = false;
	private $onchange = "";
	private $callback_onchange = "";
	private $callback_onchange_params = array();

    private $object_drop_zone = null;
    private $drop_zone_over_style = "";
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

        JavaScriptInclude::getInstance()->addToEnd(BASE_URL."wsp/js/jquery.form.js", "", true);
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
	 * Method setTooltip
	 * @access public
	 * @param mixed $tooltip 
	 * @return UploadFile
	 * @since 1.2.10
	 */
	public function setTooltip($tooltip) {
		$this->tooltip = $tooltip;
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
		if (!extension_loaded('fileinfo')) {
			throw new NewException("You need to install PHP lib fileinfo.", 0, getDebugBacktrace(1));
		}
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
        $this->file_size_limit_str = $bytes_size;

		$apache_conf_size =  $this->convertSizeToBytes(ini_get('upload_max_filesize'));
		$bytes_size =  $this->convertSizeToBytes($bytes_size);
		if ($bytes_size > $apache_conf_size) {
			throw new NewException(get_class($this)."->setFileSizeLimit() error : \$bytes_size greater than the PHP configuration variable upload_max_filesize.", 0, getDebugBacktrace(1));
		}
		$this->file_size_limit = $bytes_size;
		return $this;
	}
	
	/**
	 * Method convertSizeToBytes
	 * @access private
	 * @param mixed $val 
	 * @return mixed
	 * @since 1.2.10
	 */
	private function convertSizeToBytes($val) {
        if(empty($val))return 0;

        $val = trim($val);

        preg_match('#([0-9]+)[\s]*([a-z]+)#i', $val, $matches);

        $last = '';
        if(isset($matches[2])){
            $last = $matches[2];
        }

        if(isset($matches[1])){
            $val = (int) $matches[1];
        }

        switch (strtolower($last))
        {
            case 'g':
            case 'gb':
                $val *= 1024;
            case 'm':
            case 'mb':
                $val *= 1024;
            case 'k':
            case 'kb':
                $val *= 1024;
        }

        return (int) $val;
    }
    
	/**
	 * Method activateMultipleFiles
	 * @access public
	 * @return UploadFile
	 * @since 1.2.11
	 */
    public function activateMultipleFiles() {
    	$this->is_multiple = true;
    	return $this;
    }

	/**
	 * Method setSelectFileIcon
	 * @access public
	 * @param mixed $icon 
	 * @param double $height [default value: 32]
	 * @param double $width [default value: 32]
	 * @param string $align [default value: Picture::ALIGN_ABSMIDDLE]
	 * @param string $title 
	 * @return UploadFile
	 * @since 1.2.13
	 */
    public function setSelectFileIcon($icon, $height=32, $width=32, $align=Picture::ALIGN_ABSMIDDLE, $title='') {
        if (gettype($this->select_file_icon) != "string" && (gettype($this->select_file_icon) == "object" && get_class($this->select_file_icon) != "Picture")) {
            throw new NewException(get_class($this)."->setSelectFileIcon() error: \$icon need to be the icon path or a Picture object.", 0, getDebugBacktrace(1));
        }
        if (gettype($this->select_file_icon) == "string") {
            $icon = new Picture($icon, $height, $width, 0, $align, $title);
        }
        $icon->setId("UploadFilePic_" . $this->id );
        $icon->onClickJs("\$('#".$this->id."').click();");
        $this->select_file_icon = $icon;
        return $this;
    }
	
	/**
	 * Method getFileMimeType
	 * @access public
	 * @param double $file_index [default value: 0]
	 * @return mixed
	 * @since 1.2.3
	 */
	public function getFileMimeType($file_index=0) {
		$file_info = new finfo(FILEINFO_MIME);
		$mime_type = explode(";", $file_info->buffer(file_get_contents($this->getFilePath($file_index))));  // e.g. gives "image/jpeg"
		return trim($mime_type[0]);
	}
	
	/**
	 * Method checkMimeType
	 * @access public
	 * @param double $file_index [default value: 0]
	 * @return boolean
	 * @since 1.2.3
	 */
	public function checkMimeType($file_index=0) {
		$mime_type = $this->getFileMimeType($file_index);
		if (in_array($mime_type, $this->array_mime_types)) {
			return true;
		}
		return false;
	}
	
	/**
	 * Method checkFileSize
	 * @access public
	 * @param double $file_index [default value: 0]
	 * @return boolean
	 * @since 1.2.3
	 */
	public function checkFileSize($file_index=0) {
		$size = $this->getFileSize($file_index);
		if (is_numeric($size) && ($size <= $this->file_size_limit || $this->file_size_limit == -1)) {
			return true;
		}
		return false;
	}
	
	/**
	 * Method getFileSize
	 * @access public
	 * @param double $file_index [default value: 0]
	 * @return mixed
	 * @since 1.2.3
	 */
	public function getFileSize($file_index=0) {
		return filesize($this->getFilePath($file_index));
	}
	
	/**
	 * Method isEmptyFile
	 * @access public
	 * @param double $file_index [default value: 0]
	 * @return mixed
	 * @since 1.2.3
	 */
	public function isEmptyFile($file_index=0) {
		return ($this->getFileSize($file_index) === 0);
	}
	
	/**
	 * Method moveFile
	 * @access public
	 * @param mixed $destination_path 
	 * @param double $file_index [default value: 0]
	 * @return boolean
	 * @since 1.2.3
	 */
	public function moveFile($destination_path, $file_index=0) {
		// To check mime type and size call getFileName to block the unauthorized format and size file
		$filename = $this->getFileName($file_index, true);
		
		// Move file
		if (move_uploaded_file($this->getFilePath($file_index), $destination_path.$filename)) {
			$this->file_path[$file_index] = $destination_path.$filename;
			return true;
		}
		return false;
	}
	
	/**
	 * Method getFileContent
	 * @access public
	 * @param double $file_index [default value: 0]
	 * @return mixed
	 * @since 1.2.3
	 */
	public function getFileContent($file_index=0) {
		//To check mime type and size call getFileName to block the unauthorized format and size file
		$filename = $this->getFileName($file_index, true);
		
		// Get file content
		$file = new File($this->getFilePath($file_index));
		$content = $file->read();
		$file->close();
		
		return (binary) $content;
	}
	
	/**
	 * Method getFileName
	 * @access public
	 * @param double $file_index [default value: 0]
	 * @param boolean $check_mime_size [default value: false]
	 * @return mixed
	 * @since 1.2.3
	 */
	public function getFileName($file_index=0, $check_mime_size=false) {
		if ($this->is_multiple) {
			$filename = $_FILES[$this->getEventObjectName()]["name"][$file_index];
		} else {
			$filename = $_FILES[$this->getEventObjectName()]["name"];
		}
		if ($check_mime_size == true) {
			if (sizeof($this->array_mime_types) > 0) {
				if (!$this->checkMimeType($file_index)) {
					throw new NewException("Mime type of file ".$filename." not supported.", 0, getDebugBacktrace(1));
				}
			}
			if (!$this->checkFileSize($file_index)) {
				throw new NewException("Uploaded file ".$filename." is bigger than file size limit.", 0, getDebugBacktrace(1));
			}
		}
		
		return $filename;
	}
	
	/**
	 * Method getFilePath
	 * @access public
	 * @param double $file_index [default value: 0]
	 * @return mixed
	 * @since 1.2.3
	 */
	public function getFilePath($file_index=0) {
		if ($this->file_path[$file_index] == "") {
			if ($this->is_multiple) {
				$this->file_path[$file_index] = $_FILES[$this->getEventObjectName()]["tmp_name"][$file_index];
			} else {
				$this->file_path[$file_index] = $_FILES[$this->getEventObjectName()]["tmp_name"];
			}
		}
		return $this->file_path[$file_index];
	}
	
	/**
	 * Method count
	 * @access public
	 * @return mixed
	 * @since 1.2.11
	 */
	public function count() {
		return sizeof($_FILES[$this->getEventObjectName()]["tmp_name"]);
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
			throw new NewException(get_class($this)."->onChange(): onChange function is available only for ".get_class($this)." with ajax event. Please call the function ".get_class($this)."->setAjaxEvent().", 0, getDebugBacktrace(1));
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
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onChangeJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
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
	 * Method setObjectDropZone
	 * @access public
	 * @param mixed $object 
	 * @param string $over_style [default value: 1px dashed red]
	 * @return UploadFile
	 * @since 1.2.13
	 */
    public function setObjectDropZone($object, $over_style='1px dashed red') {
        if (gettype($object) != "object" || get_class($object) != "Object") {
            throw new NewException(get_class($this)."->setObjectDropZone() error: \$object need to be a WSP Object.", 0, getDebugBacktrace(1));
        }
        $this->object_drop_zone = $object;
        $this->drop_zone_over_style = $over_style;
        return $this;
    }

	/**
	 * Method activateSizeLimitJsCheck
	 * @access public
	 * @return UploadFile
	 * @since 1.2.13
	 */
    public function activateSizeLimitJsCheck() {
        $this->file_size_limit_js_check = true;
        return $this;
    }

	/**
	 * Method activateMimeTypeJsCheck
	 * @access public
	 * @return UploadFile
	 * @since 1.2.13
	 */
    public function activateMimeTypeJsCheck() {
        $this->mime_types_js_check = true;
        return $this;
    }

	/**
	 * Method isSizeLimitJsCheckActivated
	 * @access public
	 * @return mixed
	 * @since 1.2.13
	 */
    public function isSizeLimitJsCheckActivated() {
        return $this->file_size_limit_js_check;
    }

	/**
	 * Method isMimeTypeJsCheckActivated
	 * @access public
	 * @return mixed
	 * @since 1.2.13
	 */
    public function isMimeTypeJsCheckActivated() {
        return $this->mime_types_js_check;
    }

	/**
	 * Method getFileSizeLimit
	 * @access public
	 * @return mixed
	 * @since 1.2.13
	 */
    public function getFileSizeLimit() {
        return $this->file_size_limit;
    }

	/**
	 * Method getFileSizeLimitStr
	 * @access public
	 * @return mixed
	 * @since 1.2.13
	 */
    public function getFileSizeLimitStr() {
        return $this->file_size_limit_str;
    }

	/**
	 * Method getAuthorizedMimeTypes
	 * @access public
	 * @return mixed
	 * @since 1.2.13
	 */
    public function getAuthorizedMimeTypes() {
        return $this->array_mime_types;
    }

	/**
	 * Method getProgressBarObject
	 * @access public
	 * @return mixed
	 * @since 1.2.13
	 */
    public function getProgressBarObject() {
        $loading_sub_percent_obj = new Object();
        $loading_sub_percent_obj->forceDivTag();
        $loading_sub_percent_txt_obj = new Object();
        $loading_sub_percent_txt_obj->forceSpanTag();
        $loading_percent_obj = new Object($loading_sub_percent_obj, $loading_sub_percent_txt_obj);
        $loading_percent_obj->setClass("wsp-progress-bar")->forceDivTag();
        $loading_obj = new Object($loading_percent_obj);
        $loading_obj->setClass("wsp-progress-bar-container")->forceDivTag();
        $loading_obj->setId("wspAjaxEventLoadingObj".get_class($this)."_".$this->getEventObjectName());
        $loading_obj->hide();
        return $loading_obj;
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
		
		if ($this->button_value == "") {
			if ($this->is_multiple) {
				$this->button_value = __(WSP_BTN_UPLOAD_FILES);
			} else {
				$this->button_value = __(WSP_BTN_UPLOAD_FILE);
			}
		}
		
		// Generate HTML
        if ($this->object_drop_zone == null || (is_browser_ie() && get_browser_ie_version() <= 9)) {
            if ($this->select_file_icon == "" || gettype($this->select_file_icon) != "object" || get_class($this->select_file_icon) != "Picture") {
                if (!is_browser_ie()) {
                    $html .= "<span class=\"UploadFile\">";
                    $html .= "<input type=\"text\" id=\"UploadFile_Path_" . $this->id . "\" disabled/>";
                    $html .= "<label id=\"UploadFile_Button_" . $this->id . "\" class=\"button";
                    if ($this->class != "") {
                        $html .= " " . $this->class;
                    }
                    $html .= "\"";
                    if ($this->tooltip != "") {
                        $html .= " title=\"" . $this->tooltip . "\"";
                    }
                    $html .= ">" . $this->button_value . "</label><input type='file' name='" . $this->getEventObjectName() . ($this->is_multiple ? "[]" : "") . "' id='" . $this->id . "' class='UploadFileInput'";
                    if ($this->is_multiple) {
                        $html .= " multiple";
                    }
                    $html .= "/>";
                    $html .= "</span>";
                } else {
                    $html .= "<input type='file' name='" . $this->getEventObjectName() . ($this->is_multiple ? "[]" : "") . "' id='" . $this->id . "'";
                    if ($this->is_multiple) {
                        $html .= " multiple";
                    }
                    if ($this->width != "") {
                        $html .= " style=\"width:";
                        if (is_integer($this->width)) {
                            $html .= $this->width . "px";
                        } else {
                            $html .= $this->width;
                        }
                        $html .= ";\"";
                    }
                    if ($this->class != "") {
                        $html .= " class='" . $this->class . "'";
                    }
                    if ($this->tooltip != "") {
                        $html .= " title='" . $this->tooltip . "'";
                    }
                    $html .= "/>";
                }
            } else {
                $html .= "<input type='file' name='" . $this->getEventObjectName() . ($this->is_multiple ? "[]" : "") . "' id='" . $this->id . "'";
                if ($this->is_multiple) {
                    $html .= " multiple";
                }
                $html .= " style='display:none;'/>";
                $html .= $this->select_file_icon->render($ajax_render);
            }

            $html .= $this->getJavascriptTagOpen();
            if (!is_browser_ie() && $this->select_file_icon == "") {
                $html .= "\$('#UploadFile_Button_".$this->id."').click(function(event){\n";
                $html .= "	\$('#".$this->id."').click();\n";
                $html .= "});\n";
                if ($this->width != "") {
                    $html .= "\$('#UploadFile_Path_".$this->id."').css('width', (";
                    if (is_integer($this->width)) {
                        $html .= $this->width;
                    } else {
                        $html .= trim(str_replace("px", "", $this->width));
                    }
                    $html .= " - myReplace($('#UploadFile_Button_".$this->id."').css('width'), 'px', '')) + 'px');\n";
                }
            }
            $html .= "\$('#".$this->id."').change(function(){\n";
            if (!is_browser_ie()) {
                $html .= "	var current_file = myReplaceAll(\$(this).val(), '\\\\', '/').split('/');\n";
                $html .= "	current_file = current_file[current_file.length-1];\n";
                $html .= "	\$('#UploadFile_Path_".$this->id."').val(current_file);\n";
            }
            if ($this->onchange != "" || $this->callback_onchange != "") {
                $html .= "	".str_replace("\n", "", $this->getObjectEventValidationRender($this->onchange, $this->callback_onchange))."\n";
            }
            $html .= "});";
            $html .= $this->getJavascriptTagClose();
        } else {
            $html .= $this->object_drop_zone->render($ajax_render);
            $html .= "<input type='file' name='".$this->getEventObjectName() . ($this->is_multiple ? "[]" : "") ."' id='" . $this->id . "' style='display:none;'/>";
            $html .= $this->getJavascriptTagOpen();
            $html .= "$(document).on('dragenter', '#".$this->object_drop_zone->getId()."', function() {
                $(this).css('border', '".$this->drop_zone_over_style."');
                return false;
            });

            $(document).on('dragover', '#".$this->object_drop_zone->getId()."', function(e){
                e.preventDefault();
                e.stopPropagation();
                $(this).css('border', '".$this->drop_zone_over_style."');
                return false;
            });

            $(document).on('dragleave', '#".$this->object_drop_zone->getId()."', function(e) {
                e.preventDefault();
                e.stopPropagation();\n";
            if ($this->object_drop_zone->getStyle() != "") {
                $html .= "$(this).attr('style', '" . $this->object_drop_zone->getStyle() . "');\n";
            }
            $html .= "return false;
            });
            $(document).on('drop', '#".$this->object_drop_zone->getId()."', function(e) {
                if(e.originalEvent.dataTransfer){
                   if(e.originalEvent.dataTransfer.files.length) {
                       e.preventDefault();
                       e.stopPropagation();\n";
            $html .= "document.getElementById('".$this->id."').files = e.originalEvent.dataTransfer.files;\n";
            $html .= str_replace("\n", "", $this->getObjectEventValidationRender($this->onchange, $this->callback_onchange))."\n";
            $html .= "}
                }\n";
            if ($this->object_drop_zone->getStyle() != "") {
                $html .= "$(this).attr('style', '" . $this->object_drop_zone->getStyle() . "');\n";
            }
            $html .= "return false;
            });";
            $html .= $this->getJavascriptTagClose();
        }
		
		$this->object_change = false;
		return $html;
	}
}
?>
