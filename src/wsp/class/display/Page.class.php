<?php
/**
 * Class Page
 * 
 * Instance of a new Page.
 * @access public
 * @author Emilien MOREL <admin@website-php.com>
 * @link http://www.website-php.com
 * @copyright website-php.com 30/11/2009
 * @version 1.0
 */
 
class Page {
	protected $render = null;
	private $add_to_render = array();
	
	protected static $PAGE_TITLE = "";
	protected static $PAGE_KEYWORDS = "";
	protected static $PAGE_DESCRIPTION = "";
	protected static $PAGE_META_ROBOTS = "";
	protected static $PAGE_META_GOOGLEBOTS = "";
	protected static $PAGE_META_REVISIT_AFTER = "";
	
	protected $USER_RIGHTS = "";
	protected $PAGE_CACHING = false;
	
	private $page_is_display = false;
	
	private $page_is_caching = false;
	private $class_name = "";
	private $page = "";
	private $cache_file_name = "";
	private $cache_time = 0;
	
	private $is_browser_ie_6 = false;
	private $is_browser_ie = false;
	
	private $objects = array();
	private $force_objects_default_values = false;
	private $log_debug_str = array();
	
	private $callback_method = "";
	private $callback_object = null;
	private $callback_method_params = array();
	private $array_callback_object = array("Button", "ComboBox", "TextBox", "Password", "ColorPicker", 
											"ContextMenuEvent", "DroppableEvent", "SortableEvent", "Object");
	
	private $create_object_to_get_css_js = false;
	
	/**
	 * Constructor Page
	 */
	function __construct() {
		$this->is_browser_ie_6 = is_browser_ie_6();
		$this->is_browser_ie = is_browser_ie();
		ob_start(array('NewException', 'redirectOnError'));
	}
	
	/**
	 * Destructor Page
	 */
	function __destruct() {
		if ($this->page_is_display) {
			if ((CACHING_ALL_PAGES || $this->PAGE_CACHING) && !$this->page_is_caching) {
				if (strtoupper(substr($this->class_name, 0, 5)) != "ERROR") {
					$cache_file = $this->cache_file_name;
					$pointeur = fopen($cache_file, 'w'); 
					fwrite($pointeur, ob_get_contents()); 
					fclose($pointeur);
				}
			}
		}
		ob_end_flush();
	}
	
	final public static function getInstance($page) {
		$page_tmp = str_replace("_", "-", $page);
		$page_tmp = explode('/', $page_tmp);
		$page_names = explode('-', $page_tmp[sizeof($page_tmp)-1]);
		$page_class_name = "";
		for ($i=0; $i < sizeof($page_names); $i++) {
			$page_class_name .= ucfirst($page_names[$i]);
		}
		
		static $aoInstance = array();
		if (!isset($aoInstance[$page_class_name])) {
			if (strtoupper(substr($page, 0, 5)) == "ERROR") {
				require_once("pages/error/".$page.".php");
			} else {
				require_once("pages/".$page.".php");
			}
			$aoInstance[$page_class_name] = new $page_class_name();
			$aoInstance[$page_class_name]->page = $page;
			$aoInstance[$page_class_name]->setCacheFileName($page);
			$aoInstance[$page_class_name]->class_name = $page_class_name;
		}
		return $aoInstance[$page_class_name];
	}
   
	public function setCache() {
		$this->page_is_display = true;
		$this->PAGE_CACHING = true;
		if (CACHING_ALL_PAGES || $this->PAGE_CACHING) {
			$cache_file = $this->cache_file_name;
			$cache_file_existe = (@file_exists($cache_file)) ? @filemtime($cache_file) : 0;
			$cache_time = CACHE_TIME;
			if ($this->cache_time > 0) {
				$cache_time = $this->cache_time;
			} 
			if ($cache_file_existe > time() - $cache_time) { 
				$this->render = file_get_contents($cache_file);
				if ($this->render == null) {
					throw new NewException("Cache file is empty", 0, 8, __FILE__, __LINE__);
				}
				$this->page_is_caching = true;
				return true;
			}
			return false;
		}
		return false;
	}
	
	protected function setCacheFileName($file_name) {
		$cache_directory = SITE_DIRECTORY."/wsp/cache";
		if (!is_dir($cache_directory)) {
			mkdir($cache_directory);
		}
		if ($_SESSION['lang'] != "") {
			$cache_directory = $cache_directory."/".$_SESSION['lang'];
			if (!is_dir($cache_directory)) {
				mkdir($cache_directory);
			}
		}
		if (find($file_name, ".cache", 1, 0) == 0) {
			$file_name .= ".cache";
		}
		if ($this->is_browser_ie_6) {
			$this->cache_file_name = urlencode(str_replace(".cache", "_ie6.cache", $file_name));
		} else if ($this->is_browser_ie) {
			$this->cache_file_name = urlencode(str_replace(".cache", "_ie".get_browser_ie_version().".cache", $file_name));
		} else {
			$this->cache_file_name = urlencode($file_name);
		}
		$this->cache_file_name = $cache_directory."/".$this->cache_file_name;
	}
	
	protected function setCacheTime($cache_time) {
		$this->cache_time = $cache_time;
	}
	
	protected function disableCache() {
		$this->PAGE_CACHING = false;
	}
		
	public function getPageTitle() {
		return self::$PAGE_TITLE;
	}
	
	public function getPageKeywords() {
		return self::$PAGE_KEYWORDS;
	}
	
	public function getPageDescription() {
		return self::$PAGE_DESCRIPTION;
	}
	
	public function getPageMetaRobots() {
		return self::$PAGE_META_ROBOTS;
	}
	
	public function getPageMetaGooglebots() {
		return self::$PAGE_META_GOOGLEBOTS;
	}
	
	public function getPageMetaRevisitAfter() {
		return self::$PAGE_META_REVISIT_AFTER;
	}
	
	public function getPageIsCaching() {
		return $this->page_is_caching;
	}
	
	public function getPage() {
		return $this->page;
	}
	
	public function addEventObject($object, $form_object=null) {
		if ($object->isEventObject() && !$this->create_object_to_get_css_js) {
			$class_name = get_class($object);
			if ($form_object != null) {
				if (get_class($form_object) != "Form") {
					throw new NewException("addEventObject error in the second parameter : must be a Form object", 0, 8, __FILE__, __LINE__);
				}
				$class_name .= "_".$form_object->getName();
				$form_object->registerObjectToForm($object);
			}
			if (!isset($this->objects[$class_name])) {
				$this->objects[$class_name] = array();
			}
			$this->objects[$class_name][] = $object;
		}
	}
	
	public function getEventObjects($event_object_name) {
		if (isset($this->objects[$event_object_name])) {
			return $this->objects[$event_object_name];
		} else {
			return array();
		}
	}
	
	public function getAllEventObjects() {
		return $this->objects;
	}
	
	public function getObjectId($id) {
		$register_objects = WebSitePhpObject::getRegisterObjects();
		for ($i=0; $i < sizeof($register_objects); $i++) {
			if (method_exists($register_objects[$i], "getId")) {
				if ($register_objects[$i]->getId() == $id || $register_objects[$i]->getId()."_id" == $id) {
					return $register_objects[$i];
				}
			}
		}
		return null;
	}
	
	/**
	 * function createObjectName
	 * @param Object $object event object (ex: TextBox, Editor, Button, ...)
	 * Create an automatique and unique name for an event object
	 */
	public function createObjectName($object) {
		$class_name = get_class($object);
		$form_object = null;
		if ($class_name != "Form") {
			if (method_exists($object, "getForm")) {
				$form_object = $object->getForm();
				if ($form_object != null) {
					$class_name .= "_".$form_object->getName();
				}
			}
		} else {
			$form_object = $object;
		}
		$nb_elem_object = sizeof($this->getEventObjects($class_name));
		if (isset($_GET['tabs_object_id'])) {
			$nb_elem_object = $_GET['tabs_object_id']."_".$nb_elem_object;
		}
		if (DialogBox::getCurrentDialogBoxLevel() != -1) {
			$nb_elem_object = (DialogBox::getCurrentDialogBoxLevel()*1000) + $nb_elem_object;
		}
		$this->addEventObject($object, $form_object);
		return $class_name."_".$nb_elem_object;
	}
	
	/**
	 * function existsObjectName
	 * @param string $name
	 * Test if an event object already exists for this name
	 */
	public function existsObjectName($name) {
		foreach ($this->objects as $object_array) {
			foreach ($object_array as $object) {
				if ($object->getName() == $name) {
					return $object;
				}
			}
		}
		return false;
	}
	
	/**
	 * function getObjectValue
	 * @param string $name get the value of an event object (ex: TextBox, Editor, Button, ...)
	 */
	public function getObjectValue($name) {
		$object = $this->existsObjectName($name);
		if ($object != false) {
			return $object->getValue();
		}
		return false;
	}
	
	/**
	 * function setObjectValue
	 * @param string $name set the value of an event object (ex: TextBox, Editor, Button, ...)
	 */
	public function setObjectValue($name, $value) {
		$object = $this->existsObjectName($name);
		if ($object != false) {
			$object->setValue($value);
		}
	}
	
	/**
	 * function loadAllVariables
	 * Load all GET and POST Varaibles after submit a form
	 */
	public function loadAllVariables() {
		//$this->addLogDebug(echo_r($_POST));
		$GLOBALS['__LOAD_VARIABLES__'] = true;
		foreach ($this->objects as $class_name => $object_array) {
			$array_class_name = explode('_', $class_name);
			// Load variables for all event objects except Form object
			if ($array_class_name[0] != "Form") {
				$form_name = "";
				for ($i=1; $i < sizeof($array_class_name); $i++) {
					if ($i > 1) {
						$form_name .= "_";
					}
					$form_name .= $array_class_name[$i];
				}
				foreach ($object_array as $object) {
					// create object name
					if ($form_name == "") {
						$name = $this->class_name."_".$object->getName();
					} else {
						$name = $this->class_name."_".$form_name."_".$object->getName();
					}
					$name_hidden = "";
					// use for component with hidden value
					if ($array_class_name[0] == "Editor" && $GLOBALS['__AJAX_PAGE__'] == true) { 
						if ($form_name == "") {
							$name_hidden = $this->class_name."_hidden_".$object->getName();
						} else {
							$name_hidden = $this->class_name."_".$form_name."_hidden_".$object->getName();
						}
					}
					if (method_exists($object, "getFormObject")) {
						$form_object = $object->getFormObject();
					} else {
						$form_object = null;
					}
					// check object's form rights (POST or GET) before load variable
					// If this variable exists load it into the object
					if ($form_object == null) { // no form associate to event object
						if (isset($_POST[$name])) {
							if ($name_hidden != "") {
								$object->setValue($_POST[$name_hidden]);
							} else {
								$object->setValue($_POST[$name]);
							}
						} else if (isset($_GET[$name])) {
							if ($name_hidden != "") {
								$object->setValue($_GET[$name_hidden]);
							} else {
								$object->setValue($_GET[$name]);
							}
						}
					} else if ($form_object->getMethod() == "POST") { // form rights is POST
						if (isset($_POST[$name])) {
							if ($name_hidden != "") {
								$object->setValue($_POST[$name_hidden]);
							} else {
								$object->setValue($_POST[$name]);
							}
						}
					} else { // form rights is GET
						if (isset($_GET[$name])) {
							if ($name_hidden != "") {
								$object->setValue($_GET[$name_hidden]);
							} else {
								$object->setValue($_GET[$name]);
							}
						}
					}
					//$this->addLogDebug("Page->loadAllVariables: ".$name." - ".$_REQUEST[$name]);
				}
			}
		}
		$GLOBALS['__LOAD_VARIABLES__'] = false;
	}
	
	/**
	 * function forceObjectsDefaultValues
	 * Force all event object (ex: TextBox, Editor, Button, ...) to the default value (like a reset)
	 * Cancel method loadAllVariables
	 */
	public function forceObjectsDefaultValues() {
		foreach ($this->objects as $class_name => $object_array) {
			if ($class_name != "Form") {
				foreach ($object_array as $object) {
					if (get_class($object) != "Button") {
						$object->setValue($object->getDefaultValue());
					}
				}
			}
		}
		$this->force_objects_default_values = true;
	}
	
	/**
	 * function getUserEventObject
	 * Save the callback method and params from user event
	 */
	public function getUserEventObject() {
		if ($this->callback_method == "") {
			foreach ($this->objects as $class_name => $object_array) {
				$array_class_name = explode('_', $class_name);
				// For all event objects (button, combobox, ...), check if event exists
				if (in_array($array_class_name[0], $this->array_callback_object)) {
					foreach ($object_array as $object) {
						// WARNING if change : This code is identical with WebSitePhpEventObject->initSubmitValue()
						 
						// create object name
						if ($object->getFormObject() == null) {
							$name = "Callback_".$this->class_name."_".$object->getName();
						} else {
							$name = "Callback_".$this->class_name."_".$object->getFormObject()->getName()."_".$object->getName();
						}
						$form_object = $object->getFormObject();
						// check button form rights (POST or GET) before execute function
						$callback_method = "";
						$callback_params = "";
						if ($form_object == null) { // no form associate to event object
							if (isset($_POST[$name]) && $_POST[$name] != "") {
								list($callback_method, $callback_params) = $this->extractCallbackParameters($_POST[$name]);
							} else if (isset($_GET[$name]) && $_GET[$name] != "") {
								list($callback_method, $callback_params) = $this->extractCallbackParameters($_GET[$name]);
							}
						} else if ($form_object->getMethod() == "POST") { // form rights is POST
							if (isset($_POST[$name]) && $_POST[$name] != "") {
								list($callback_method, $callback_params) = $this->extractCallbackParameters($_POST[$name]);
							}
						} else { // form rights is GET
							if (isset($_GET[$name]) && $_GET[$name] != "") {
								list($callback_method, $callback_params) = $this->extractCallbackParameters($_GET[$name]);
							}
						}
						
						if ($callback_method != "") {
							//$this->addLogDebug("Page->executeCallback: ".$name." - ".$_REQUEST[$name]." - ".$callback_method);
							
							// ack to set button, textbox, combobox, context menu event (is_clicked, is_changed)
							$save_load_variables = $GLOBALS['__LOAD_VARIABLES__'];
							$GLOBALS['__LOAD_VARIABLES__'] = true;
							if (get_class($object) == "Object" || get_class($object) == "ContextMenuEvent") {
								$object->setClick();
							} else if (get_class($object) == "DroppableEvent") {
								$object->setDrop();
							} else if (get_class($object) == "SortableEvent") {
								$object->setSort();
							} else {
								$object->setValue($object->getValue());
							} 
							$GLOBALS['__LOAD_VARIABLES__'] = $save_load_variables;
							
							$callback_params[0] = $object;
							$this->callback_method_params = $callback_params;
							$this->callback_method = $callback_method;
							$this->callback_object = $object;
							return $object;
						}
					}
				}
			}
			// if method is call from an other page
			foreach ($_REQUEST as $key => $value) {
				if (find($key, "Callback_", 0, 0) > 0 && find($value, get_class($this)."().", 0, 0) > 0 && 
					find($value, ").public_", 0, 0) > 0) {
					list($callback_method, $callback_params) = $this->extractCallbackParameters(str_replace(get_class($this)."().", "", $value));
					
					if ($callback_method != "") {
						$callback_params[0] = $object;
						$this->callback_method_params = $callback_params;
						$this->callback_method = $callback_method;
						$this->callback_object = $object;
						return $object;
					}
				}
			}
		} else {
			return $this->callback_object;
		}
	}
	
	/**
	 * function executeCallback
	 * Execute method link to the user action
	 */
	public function executeCallback() {
		$this->getUserEventObject();
		if ($this->callback_method != "") {
			for ($i=0; $i < sizeof($this->callback_method_params); $i++) {
				if ($this->callback_method_params[$i] != "" && gettype($this->callback_method_params[$i]) == "string") {
					// remove quote
					$this->callback_method_params[$i] = trim($this->callback_method_params[$i]);
					if (substr($this->callback_method_params[$i], 0, 1) == "'") {
						$this->callback_method_params[$i] = substr($this->callback_method_params[$i], 1);
					}
					if (substr($this->callback_method_params[$i], strlen($this->callback_method_params[$i])-1, 1) == "'") {
						$this->callback_method_params[$i] = substr($this->callback_method_params[$i], 0, strlen($this->callback_method_params[$i])-1);
					}
					
					// search if string is linked with object
					$param_object = $this->getObjectId($this->callback_method_params[$i]);
					if ($param_object != null) {
						$this->callback_method_params[$i] = $param_object;
					}
				}
			}
			if (call_user_func_array(array($this, $this->callback_method), $this->callback_method_params) === false) {
				throw new NewException("Unable to call callback method ".$this->callback_method."!", 0, 8, __FILE__, __LINE__);
			}
		}
	}
	
	private function extractCallbackParameters($callback_value) {
		if (find($callback_value, ").public_", 0, 0) > 0) {
			$callback_method = "";
			$callback_params = "";
		} else {
			$pos = find($callback_value, "(", 0, 0);
			$pos2 = find($callback_value, ")", 0, 0);
			$callback_params = ",".substr($callback_value, $pos, $pos2-$pos-1);
			$callback_method = substr($callback_value, 0, $pos-1);
		}
		
 		return array($callback_method, explodeFunky(",", $callback_params));
	}
	
	/**
	 * function addObject
	 * @param Object $object add script after the render of the page (ex: DialogBox, ...)
	 */
	public function addObject($object) {
		if (!is_subclass_of($object, "WebSitePhpObject")) {
			throw new NewException("You can't add this object ".get_class($this)." to the page, you must add WebSitePhpObject", 0, 8, __FILE__, __LINE__);
		}
		$this->add_to_render[] = $object;
	}
	
	public function getAddedObjects() {
		return $this->add_to_render;
	}
	
	/**
	 * function addLogDebug
	 * @param string $str add string to debug consol
	 */
	public function addLogDebug($str) {
		$this->log_debug_str[] = $str;
	}
	
	public function getLogDebug() {
		return $this->log_debug_str;
	}
	
	/**
	 * function render
	 * Render the page
	 */
	public function render() {
		if ($this->render == null) {
			throw new NewException("Render object not set for the page ".$this->page." (Please set the variable \$this->render in class ".$this->class_name.")", 0, 8, __FILE__, __LINE__);
		} else {
			$html = "";
			if (gettype($this->render) == "object" && method_exists($this->render, "render")) {
				$html .= $this->render->render();
			} else {
				$html .= $this->render;
			}
			$html .= "\n";
			for ($i=0; $i < sizeof($this->add_to_render); $i++) {
				if ($this->add_to_render[$i]->isJavascriptObject()) {
					$html .= $this->add_to_render[$i]->getJavascriptTagOpen();
				}
				if (gettype($this->add_to_render[$i]) == "object" && method_exists($this->add_to_render[$i], "render")) {
					$html .= $this->add_to_render[$i]->render();
				} else {
					$html .= $this->add_to_render[$i];
				}
				$html .= "\n";
				if ($this->add_to_render[$i]->isJavascriptObject()) {
					$html .= $this->add_to_render[$i]->getJavascriptTagClose();
				}
			}
			if (DEBUG) {
				$html_debug = "";
				for ($i=0; $i < sizeof($this->log_debug_str); $i++) {
					$html_debug .= $this->log_debug_str[$i]."<br/>\n";
				}
				if ($html_debug != "") {
					$html .= "<div style=\"background-color:white;color:black;padding:5px;margin:10px;border:1px solid black;\"><b>DEBUG Page ".$this->getPage().".php :</b><br/>".$html_debug."</div>";
				}
			}
			return str_replace("{#QUOTE#}", "\"", str_replace("{#SIMPLE_QUOTE#}", "'", $html));
		}
	}
	
	public function getRenderObject() {
		return $this->render;
	}
	
	public function userHaveRights() {
		$user_rights = $this->USER_RIGHTS;
		if (isset($user_rights) && $user_rights != "") {
			if (isset($_SESSION['USER_RIGHTS']) && $_SESSION['USER_RIGHTS'] != "") {
				if (find($user_rights, $_SESSION['USER_RIGHTS'], 1, 0) > 0) {
					return true;
				}
			}
			return false;
		}
		return true;
	}
	
	public function setUserRights($rights) {
		$_SESSION['USER_RIGHTS'] = $rights;
	}

	
	public function redirect($url) {
		if ($GLOBALS['__AJAX_PAGE__'] == true) {
			$this->addObject(new JavaScript("location.href='".$url."';"));
		} else {
			header('HTTP/1.1 301 Moved Temporarily');  
			header('Status: 301 Moved Temporarily');
			header("Location:".$url);
			exit;
		}
	}
	
	public function setTimeout($timeout=30) {
		set_time_limit($timeout);
	}
	
	public function getLanguage() {
		return $_SESSION['lang'];
	}
	
	public function getCurrentURL() {
		if (!defined('FORCE_SERVER_NAME') || FORCE_SERVER_NAME == "") {
			return "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		} else {
			return "http://".FORCE_SERVER_NAME.$_SERVER['REQUEST_URI'];
		}
	}
	
	public function getCurrentURLDirectory() {
		$current_url = $this->getCurrentURL();
		$current_dir = substr($current_url, 0, strrpos($current_url, "/"))."/";
		return $current_dir;
	}
	
	public function getBaseURL() {
		return BASE_URL;
	}
	
	public function getBaseLanguageURL() {
		return BASE_URL.$_SESSION['lang']."/";
	}
	
	public function getSubDomainURL() {
		return SUBDOMAIN_URL;
	}
	
	public function getRefererURL() {
		return $_SERVER['HTTP_REFERER'];
	}
	
	public function getDocumentHeight() {
		return ($_COOKIE['wsp_document_height']==""?null:$_COOKIE['wsp_document_height']);
	}
	
	public function getDocumentWidth() {
		return ($_COOKIE['wsp_document_width']==""?null:$_COOKIE['wsp_document_width']);
	}
	
	public function getWindowHeight() {
		return ($_COOKIE['wsp_window_height']==""?null:$_COOKIE['wsp_window_height']);
	}
	
	public function getWindowWidth() {
		return ($_COOKIE['wsp_window_width']==""?null:$_COOKIE['wsp_window_width']);
	}
	
	/*
	 * Use to add JS and CSS to the page when when Object never load on init, but load dynamically (on DialogBox, Map, ...)
	 */
	public function includeJsAndCssFromObjectToPage($str_object) {
		$this->create_object_to_get_css_js = true;
		if (find($str_object, "(", 0, 0) > 0) {
			eval("\$temp_obj = new ".$str_object.";");
		} else {
			$temp_obj = new $str_object();
		}
		$js_array = $temp_obj->getJavaScriptArray();
		for ($i=0; $i < sizeof($js_array); $i++) {
			JavaScriptInclude::getInstance()->add($js_array[$i]);
		}
		$css_array = $temp_obj->getCssArray();
		for ($i=0; $i < sizeof($css_array); $i++) {
			CssInclude::getInstance()->add($css_array[$i]);
		}
		$this->create_object_to_get_css_js = false;
	}
}
?>
