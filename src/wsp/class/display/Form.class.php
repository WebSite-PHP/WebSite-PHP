<?php
class Form extends WebSitePhpObject {
	/**#@+
	* method properties
	* @access public
	* @var string
	*/
	const METHOD_POST = "POST";
	const METHOD_GET = "GET";
	
	/**#@+
	* @access private
	*/
	protected $page_object = null;
	private $name = "";
	private $id = "";
	private $method = "POST";
	private $action = "";
	private $content = null;
	
	private $register_object = array();
	/**#@-*/
	
	function __construct($page_object, $name='', $id='', $method="POST") {
		parent::__construct();
		
		if (!isset($page_object) || gettype($page_object) != "object" || !is_subclass_of($page_object, "Page")) {
			throw new NewException("Argument page_object for ".get_class($this)."::__construct() error", 0, 8, __FILE__, __LINE__);
		}
		
		if ($name == "") {
			$name = $page_object->createObjectName($this);
		} else {
			$exist_object = $page_object->existsObjectName($name);
			if ($exist_object != false) {
				throw new NewException("Tag name \"".$name."\" for object ".get_class($this)." already use for other object ".get_class($exist_object), 0, 8, __FILE__, __LINE__);
			}
		}
		
		$this->page_object = $page_object;
		$this->name = $name;
		if ($id == "") {
			$this->id = $name;
		} else {
			$this->id = $id;
		}
		$this->method = $method;
		
		$page_object->addEventObject($this);
	}
	
	public function setName($name) {
		$this->name = $name;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setMethod($method) {
		$this->method = $method;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setContent($content) {
		$this->content = $content;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setAction($action_file_name) {
		$this->action = str_replace(".php", ".html", str_replace(".call", ".html", str_replace(".do", ".html", str_replace(".xhtml", ".html", $action_file_name))));
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
		
	public function getName() {
		return $this->name;
	}
		
	public function getMethod() {
		return $this->method;
	}
		
	public function getPageObject() {
		return $this->page_object;
	}
		
	public function getId() {
		return $this->id;
	}
	
	public function registerObjectToForm($object) {
		if ($object->isEventObject()) {
			$this->register_object[] = $object;
		}
		return $this;
	}
	
	public function getFormObjects() {
		return $this->register_object;
	}
	
	public function getAction() {
		return $this->action;
	}
	
	public function render($ajax_render=false) {
		$html = "";
		if ($this->page_object != null) {
			$html .= "<form name=\"".get_class($this->page_object)."_".$this->name."\" ";
			if ($this->id != "") {
				$html .= "id=\"".$this->id."\" ";
			}
			$html .= "action=\"";
			if ($this->action == "") {
				$html .= str_replace("ajax/", "", $this->page_object->getCurrentURL());
			} else {
				$html .= $this->page_object->getBaseLanguageURL().$this->action;
			}
			$html .= "\" ";
			$html .= "method=\"".$this->method."\" ";
			$html .= ">\n";
			if ($this->content != null) {
				if (gettype($this->content) == "object") {
					$html .= $this->content->render();
				} else {
					$html .= $this->content;
				}
			}
			$html .= "</form>\n";
		}
		$this->object_change = false;
		return $html;
	}
}
?>
