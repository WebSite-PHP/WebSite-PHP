<?php
class Anchor extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $name = "";
	/**#@-*/
	
	function __construct($name) {
		parent::__construct();
		
		if (!isset($name)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->name = $name;
	}
	
	public function render($ajax_render=false) {
		$html = "<a name=\"".$this->name."\"></a>";
		$this->object_change = false;
		return $html;
	}
}
?>
