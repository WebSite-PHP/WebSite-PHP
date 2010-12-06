<?php
class ContextMenuEvent extends WebSitePhpEventObject {
	/**#@+
	* @access private
	*/
	private $onclick = "";
	private $callback_onclick = "";
	private $is_clicked = false;
	/**#@-*/
	
	function __construct($page_object) {
		parent::__construct();
		
		if (!isset($page_object) || gettype($page_object) != "object" || !is_subclass_of($page_object, "Page")) {
			throw new NewException("Argument page_object for ".get_class($this)."::__construct() error", 0, 8, __FILE__, __LINE__);
		}
		
		$this->page_object = $page_object;
		$this->class_name = get_class($this->page_object);
		$this->form_object = $form;
		
		$this->name = $this->page_object->createObjectName($this);
		$this->id = $name;
		$this->ajax_wait_message = __(SUBMIT_LOADING_2);
		
		$this->page_object->addEventObject($this, $this->form_object);
	}
	
	/* Intern management of ContextMenuEvent */
	public function setClick() {
		if ($GLOBALS['__LOAD_VARIABLES__']) { 
			$this->is_clicked = true; 
		}
		return $this;
	}
	
	public function getOnClickJs() {
		return $this->onclick;
	}
	
	public function onClick($str_function, $arg1=null, $arg2=null, $arg3=null, $arg4=null, $arg5=null) {
		$args = func_get_args();
		$str_function = array_shift($args);
		$this->callback_onclick = $this->loadCallbackMethod($str_function, $args);
		return $this;
	}
	
	public function onClickJs($js_function) {
		$this->onclick = trim($js_function);
		return $this;
	}
	
	public function isClicked() {
		if (!$this->is_clicked) {
			$this->page_object->getUserEventObject();
		}
		return $this->is_clicked;
	}
	
	public function render($ajax_render=false) {
		$event_obj = new Object();
		$html = "";
		if ($this->callback_onclick != "") {
			$html .= "<input type='hidden' id='Callback_".$this->getEventObjectName()."' name='Callback_".$this->getEventObjectName()."' value=''/>\n";
		}
		
		$html .= $this->getJavascriptTagOpen();
		if ($this->is_ajax_event) {
			if ($this->callback_onclick == "") {
				throw new NewException("Unable to activate action to this ".get_class($this)." : You must set a onclick event (method onChange)", 0, 8, __FILE__, __LINE__);
			}
			$html .= $this->getAjaxEventFunctionRender();
		}
		
		if ($this->onclick != "" || $this->callback_onclick != "") {
			$html .= "	function onClickContextMenu_".$this->getEventObjectName()."(selected_object_id) {\n";
			$html .= $this->getObjectEventValidationRender($this->onclick, $this->callback_onclick, "' + selected_object_id + '");
			$html .= "	}\n";
		}
		$html .= $this->getJavascriptTagClose();
		
		$this->object_change = false;
		return $html;
	}
}
?>