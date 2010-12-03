<?php
class WebSitePhpObject {
	/**#@+
	* @access protected
	*/
	protected $object_change = false;
	protected $is_javascript_object = false;
	protected $is_new_object_after_init = false;
	protected $tag = "";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $display_javascript_tag = false;
	private $array_js = array();
	private $array_css = array();
	/**#@-*/
	
	function __construct() {
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->is_new_object_after_init = true; }
		$this->registerObject();
	}
	
	public function setTag($value) {
		$this->tag = $value;
		return $this;
	}
	
	private function registerObject() {
		$register_objects = WebSitePhpObject::getRegisterObjects();
		$register_objects[] = $this;
		$_SESSION['websitephp_register_object'] = $register_objects;
	}
	
	public static function getRegisterObjects() {
		if (!isset($_SESSION['websitephp_register_object'])) {
			$_SESSION['websitephp_register_object'] = array();
		}
		return $_SESSION['websitephp_register_object'];
	}
	
	protected function addJavaScript($js_url, $conditional_comment='', $conbine=false) {
		$this->array_js[] = $js_url;
		JavaScriptInclude::getInstance()->add($js_url, $conditional_comment, $conbine);
	}
	
	public function getJavaScriptArray() {
		return $this->array_js;
	}
	
	protected function addCss($css_url, $conditional_comment='', $conbine=false) {
		$this->array_css[] = $css_url;
		CssInclude::getInstance()->add($css_url, $conditional_comment, $conbine);
	}
	
	public function getCssArray() {
		return $this->array_css;
	}
	
	public function getName() {
		if (isset($this->name)) {
			return $this->name;
		} else {
			return "";
		}
	}
	
	public function isEventObject() {
		if (isset($this->page_object) && $this->page_object != null) {
			if (get_class($this->page_object) == "Form") {
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	
	public function displayJavascriptTag() {
		if (!$this->is_javascript_object) {
			throw new NewException("displayJavascriptTag Error : You display JavaScript tag only for Javascript object", 0, 8, __FILE__, __LINE__);
		}
		$this->display_javascript_tag = true;
		return $this;
	}
	
	public function isJavascriptObject() {
		return $this->is_javascript_object;
	}
	
	public function isObjectChange() {
		return $this->object_change;
	}
	
	public function getTag() {
		return $this->tag;
	}
	
	public function getJavascriptTagOpen() {
		return "<script type='text/javascript'>\n	//<![CDATA[\n";
	}
	
	public function getJavascriptTagClose() {
		return "	//]]>\n</script>\n";
	}
	
	/**
	 * function render
	 * @return string html code from object
	 */
	public function render($ajax_render=false) {
		return "<!-- Warning: No render method for object ".get_class($this)." !!! -->\n";
	}
	
	/**
	 * function getAjaxRender
	 * @return string javascript code to update initial html with ajax call
	 */
	public function getAjaxRender() {
		if ($this->object_change && !$this->is_new_object_after_init) {
			$alert_box = new DialogBox("Ajax Error", "Warning: No Ajax render for object ".get_class($this), '', true);
			return $alert_box->render(true);
		}
	}
}
?>
