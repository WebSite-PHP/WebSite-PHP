<?php
/**
 * PHP file wsp\class\display\Editor.class.php
 * @package display
 */
/**
 * Class Editor
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.17
 */

class Editor extends WebSitePhpEventObject {
	/**#@+
	* Editor toolbar config
	* @access public
	* @var string
	*/
	const TOOLBAR_DEFAULT = "default";
	const TOOLBAR_MEDIUM = "medium";
	const TOOLBAR_SIMPLE = "simple";
	const TOOLBAR_NONE = "none";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	protected $class_name = "";
	protected $page_object = null;
	protected $form_object = null;
	protected $name = "";
	private $content = null;
	private $default_content = null;
	private $width = "";
	private $height = "";
	private $color = "";
	private $collapse_toolbar = false;
	private $resizable = false;
	
	private $live_validation = null;
	private $encrypt_object = null;
	/**#@-*/
	
	/**
	 * Constructor Editor
	 * @param Page|Object $page_or_form_object 
	 * @param string $name 
	 * @param string $width 
	 * @param string $height 
	 */
	function __construct($page_or_form_object, $name='', $width='', $height='') {
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
		
		$this->width = $width;
		$this->height = $height;
		
		$this->addJavaScript(BASE_URL."wsp/includes/ckeditor/ckeditor.js");
	}
	
	/**
	 * Method setWidth
	 * @access public
	 * @param integer $width 
	 * @return Editor
	 * @since 1.0.36
	 */
	public function setWidth($width) {
		$this->width = $width;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setHeight
	 * @access public
	 * @param integer $height 
	 * @return Editor
	 * @since 1.0.36
	 */
	public function setHeight($height) {
		$this->height = $height;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setValue
	 * @access public
	 * @param mixed $value 
	 * @return mixed
	 * @since 1.0.36
	 */
	public function setValue($value) {
		return $this->setContent($value);
	}

	/**
	 * Method setDefaultValue
	 * @access public
	 * @param mixed $value 
	 * @return Editor
	 * @since 1.0.36
	 */
	public function setDefaultValue($value) {
		$this->setDefaultContent($value);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setName
	 * @access public
	 * @param mixed $name 
	 * @return Editor
	 * @since 1.0.36
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	
	/**
	 * Method setContent
	 * @access public
	 * @param object $content 
	 * @return Editor
	 * @since 1.0.36
	 */
	public function setContent($content) {
		$this->content = $content;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setDefaultContent
	 * @access public
	 * @param object $content 
	 * @return Editor
	 * @since 1.0.36
	 */
	public function setDefaultContent($content) {
		$this->default_content = $content;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
		
	/**
	 * Method setColor
	 * @access public
	 * @param mixed $color 
	 * @return Editor
	 * @since 1.0.36
	 */
	public function setColor($color) {
		$this->color = $color;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
		
	/**
	 * Method setToolbar
	 * @access public
	 * @param mixed $toolbar 
	 * @return Editor
	 * @since 1.0.36
	 */
	public function setToolbar($toolbar) {
		if ($toolbar != Editor::TOOLBAR_DEFAULT && $toolbar != Editor::TOOLBAR_MEDIUM && $toolbar != Editor::TOOLBAR_SIMPLE && $toolbar != Editor::TOOLBAR_NONE) {
			throw new NewException("Editor->setToolbar() : Undefined toolbar type", 0, getDebugBacktrace(1));
		}
		
		$this->toolbar = $toolbar;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setLiveValidation
	 * @access public
	 * @param mixed $live_validation_object 
	 * @return Editor
	 * @since 1.0.36
	 */
	public function setLiveValidation($live_validation_object) {
		if (get_class($live_validation_object) != "LiveValidation") {
			throw new NewException("setLiveValidation(): \$live_validation_object must be a valid LiveValidation object", 0, getDebugBacktrace(1));
		}
		$live_validation_object->setObject($this);
		$this->live_validation = $live_validation_object;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setEncryptObject
	 * @access public
	 * @param mixed $encrypt_object 
	 * @return Editor
	 * @since 1.0.67
	 */
	public function setEncryptObject($encrypt_object) {
		if ($encrypt_object == null) {
			$encrypt_object = new EncryptDataWspObject();
		}
		if (gettype($encrypt_object) != "object" || get_class($encrypt_object) != "EncryptDataWspObject") {
			throw new NewException(get_class($this)."->setEncryption(): \$encrypt_object must be a EncryptDataWspObject object.", 0, getDebugBacktrace(1));
		}
		
		$this->addJavaScript(BASE_URL."wsp/js/jsbn.js", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/lowpro.jquery.js", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/rsa.js", "", true);
		
		$this->encrypt_object = $encrypt_object;
		$this->encrypt_object->setObject($this);
		
		return $this;
	}
	
	/**
	 * Method getEncryptObject
	 * @access public
	 * @return mixed
	 * @since 1.0.67
	 */
	public function getEncryptObject() {
		return $this->encrypt_object;
	}
	
	/**
	 * Method isEncrypted
	 * @access public
	 * @return mixed
	 * @since 1.0.67
	 */
	public function isEncrypted() {
		return ($this->encrypt_object==null?false:true);
	}
		
	/**
	 * Method collapseToolbar
	 * @access public
	 * @return Editor
	 * @since 1.0.36
	 */
	public function collapseToolbar() {
		$this->collapse_toolbar = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
		
	/**
	 * Method resizable
	 * @access public
	 * @param mixed $bool 
	 * @return Editor
	 * @since 1.0.36
	 */
	public function resizable($bool) {
		$this->resizable = $bool;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
		
	/**
	 * Method getName
	 * @access public
	 * @return mixed
	 * @since 1.0.36
	 */
	public function getName() {
		return $this->name;
	}
		
	/**
	 * Method getId
	 * @access public
	 * @return mixed
	 * @since 1.0.36
	 */
	public function getId() {
		return $this->name;
	}
		
	/**
	 * Method getHiddenId
	 * @access public
	 * @return mixed
	 * @since 1.0.36
	 */
	public function getHiddenId() {
		return "hidden_".$this->name;
	}
	
	/**
	 * Method getEventObjectName
	 * @access public
	 * @return mixed
	 * @since 1.0.36
	 */
	public function getEventObjectName() {
		return $this->class_name."_".$this->name;
	}

	/**
	 * Method getValue
	 * @access public
	 * @return mixed
	 * @since 1.0.36
	 */
	public function getValue() {
		return $this->getContent();
	}

	/**
	 * Method getDefaultValue
	 * @access public
	 * @return mixed
	 * @since 1.0.36
	 */
	public function getDefaultValue() {
		return $this->getDefaultContent();
	}
	
	/**
	 * Method getContent
	 * @access public
	 * @return mixed
	 * @since 1.0.36
	 */
	public function getContent() {
		$this->initSubmitValue(); // init value with submit value if not already do
		return $this->content;
	}
	
	/**
	 * Method getDefaultContent
	 * @access public
	 * @return mixed
	 * @since 1.0.36
	 */
	public function getDefaultContent() {
		return $this->default_content;
	}

	/**
	 * Method getFormObject
	 * @access public
	 * @return mixed
	 * @since 1.0.36
	 */
	public function getFormObject() {
		return $this->form_object;
	}
	
	/**
	 * Method getCreateEditorJs
	 * @access private
	 * @return mixed
	 * @since 1.0.36
	 */
	private function getCreateEditorJs() {
		$html .= "	createEditor_".$this->name." = function() {
						if (CKEDITOR.instances['".$this->name."']) {
							CKEDITOR.remove(CKEDITOR.instances['".$this->name."']);
						}
						CKEDITOR.replace( '".$this->name."', {\n";
		$html .= "						language: '".$_SESSION['lang']."'\n";
		$html .= "						, enterMode: CKEDITOR.ENTER_BR\n";
		if ($this->resizable) {
			$html .= "						, resize_enabled: true\n";
		} else {
			$html .= "						, resize_enabled: false\n";
		}
		if ($this->toolbar == Editor::TOOLBAR_NONE || $this->collapse_toolbar) {
			$html .= "						, toolbarStartupExpanded: false\n";
            $html .= "						, toolbarCanCollapse: true\n";
		}
		if ($this->toolbar != "" && $this->toolbar != Editor::TOOLBAR_DEFAULT) {
			$html .= "						, toolbar: '".$this->toolbar."'\n";
		}
		if ($this->color != "") {
			$html .= "						, uiColor: '".$this->color."'\n";
		}
		if ($this->height != "" || $this->width != "") {
			if ($this->height != "") {
				$html .= "						, height: '".$this->height."px'\n";
			}
			if ($this->width != "") {
				$html .= "						, width: '".$this->width."px'\n";
			}
		}
		$html .= "				 });
						CKEDITOR.instances['".$this->name."'].on('blur', function() { copyEditorContent_".$this->name."ToHidden();";
		if ($this->form_object != null) {
			$html .= "setFormObjectChangeEvent('".$this->form_object->getId()."', document.getElementById('hidden_".$this->name."'));";
		}
		$html .= " });\n";
		$html .= "				};";
		$html .= "	copyEditorContent_".$this->name."ToHidden = function() {
						if (CKEDITOR.instances['".$this->name."']) {
                            var content_editor=getEditorContent_".$this->name."();
                            $('#hidden_".$this->name."').val(content_editor);
                            $('#".$this->getId()."').val('');
                        } else if (trim($('#".$this->name."').val()) != '') {
                            $('#hidden_".$this->name."').val($('#".$this->getId()."').val());
                        }
		            };\n";
		$html .= "	setEditorContent_".$this->name." = function(content) {
						if (CKEDITOR.instances['".$this->name."']) {
							CKEDITOR.document.getById('".$this->name."').setHtml(content);
						}
					};";
		$html .= "	getEditorContent_".$this->name." = function() {
						if (CKEDITOR.instances['".$this->name."']) {
							var content_editor = CKEDITOR.instances['".$this->name."'].getData();
							if (strip_tags(content_editor)==''||strip_tags(content_editor)=='&nbsp;') {
								return '';
							} else { 
								return content_editor;
							}
						} else if (trim($('#".$this->name."').val()) != '') {
						    return $('#".$this->name."').val();
						}
						return '';
					};";
		$html .= "	getEditorSelectedContent_".$this->name." = function() {
						var selected_text = \"\"; 
						if (CKEDITOR.instances['".$this->name."']) {
							if(CKEDITOR.env.ie) {
								CKEDITOR.instances['".$this->name."'].getSelection().unlock(true);
								selected_text = CKEDITOR.instances['".$this->name."'].getSelection().getNative().createRange().text;
							} else {
								var selected_text = CKEDITOR.instances['".$this->name."'].getSelection().getNative();
							}
						}
						return selected_text;
					};";
		$html .= "  createEditor_".$this->name."();\n";
		if ($this->content != null) {
			$html .= "  setEditorContent_".$this->name."('";
			if (gettype($this->content) == "object" && method_exists($this->content, "render")) {
				$html .= addslashes(str_replace("\n", "", str_replace("\r", "", $this->content->render())));
			} else {
				$html .= addslashes(str_replace("\n", "", str_replace("\r", "", $this->content)));
			}
			$html .= "');\n";
		}
		return $html;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Editor
	 * @since 1.0.36
	 */
	public function render($ajax_render=false) {
		$html = "";
		if ($this->class_name != "") {
			if (!$ajax_render) {
				$html .= "<div id=\"wsp_editor_".$this->name."\">\n";
			}
			$html .= "<textarea name=\"".$this->getEventObjectName()."\" id=\"".$this->name."\"";
			$html .= " style=\"height:";
            if ($this->height != "") {
                $html .= $this->height;
            } else {
                $html .= "100";
            }
            $html .= "px;width:";
            if ($this->width != "") {
                $html .= $this->width."px";
            } else {
                $html .= "98%";
            }
            $html .= ";\">";
			if ($this->form_object != null) {
				$hidden_text = new TextBox($this->form_object, "hidden_".$this->name);
			} else {
				$hidden_text = new TextBox($this->page_object, "hidden_".$this->name);
			}
			$html .= $this->getValue()."</textarea>\n";
			$hidden_text->setStyle("display:none;")->forceEmpty();
			$html .= $hidden_text->render()."\n";
			
			if (!$ajax_render) {
				$html .= "</div>\n";
				$html .= $this->getJavascriptTagOpen();
				$html .= $this->getCreateEditorJs();
				$html .= $this->getJavascriptTagClose();
				if ($this->live_validation != null) {
					$html .= $this->live_validation->render();
				}
			} else {
				// For Ajax render: Extract JavaScript from HTML
				$array_ajax_render = extract_javascript($this->live_validation->render());
				for ($i=1; $i < sizeof($array_ajax_render); $i++) {
					new JavaScript($array_ajax_render[$i], true);
				}
			}
		}
		$this->object_change = false;
		return $html;
	}
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html of object Editor (call with AJAX)
	 * @since 1.0.36
	 */
	public function getAjaxRender() {
		$html = "";
		if ($this->object_change && !$this->is_new_object_after_init) {
			new JavaScript($this->getCreateEditorJs(), true);
			$html = "$('#wsp_editor_".$this->name."').html(\"".str_replace('"', '\"', str_replace("\n", "", str_replace("\r", "", $this->render(true))))."\");\n";
		}
		return $html;
	}
	
}
?>
