<?php
class Url extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $url = "http://";
	/**#@-*/
	
	function __construct($url) {
		parent::__construct();
		
		if (!isset($url)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->url = $url;
	}
	
	public function render($ajax_render=false) {
		if (strtoupper(substr($this->url, 0, 7)) != "HTTP://") {
			$this->url = BASE_URL.$_SESSION['lang']."/".$this->url;
		}
		return $this->url;
	}
}
?>
