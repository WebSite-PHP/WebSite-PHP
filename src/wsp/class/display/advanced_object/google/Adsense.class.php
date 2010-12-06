<?php
class Adsense extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $google_ad_client = "";
	private $google_ad_slot = "";
	private $google_ad_width = 0;
	private $google_ad_height = 0;
	/**#@-*/
	
	function __construct($google_ad_client, $google_ad_slot, $google_ad_width, $google_ad_height) {
		parent::__construct();
		
		if (!isset($google_ad_client) && !isset($google_ad_slot) && !isset($google_ad_width) && !isset($google_ad_height)) {
			throw new NewException("4 arguments for ".get_class($this)."::__construct() are mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->google_ad_client = $google_ad_client;
		$this->google_ad_slot = $google_ad_slot;
		$this->google_ad_width = $google_ad_width;
		$this->google_ad_height = $google_ad_height;
	}
	
	public function render($ajax_render=false) {
		$dirname = "wsp/cache/adsense/";
		$file = $dirname.$this->google_ad_client."-".$this->google_ad_slot."-".$this->google_ad_width."x".$this->google_ad_height.".html";
		$f = new File($file);
		if (!$f->exists()) {
			$f->debug_mode(true);
			$data = "<script>google_ad_client=\"".$this->google_ad_client."\";google_ad_slot=\"".$this->google_ad_slot."\";google_ad_width=".$this->google_ad_width.";google_ad_height=".$this->google_ad_height.";</script>\n";
			$data .= "<script src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\"></script>";
			$f->write($data);
		}
		$f->close();
		
		$html = "<iframe name=\"".$this->google_ad_client."-".$this->google_ad_slot."-".$this->google_ad_width."x".$this->google_ad_height."\" ";
		$html .= "src=\"".BASE_URL.$file."\" width=\"".$this->google_ad_width."\" height=\"".$this->google_ad_height."\" ";
		$html .= "frameborder=\"0\" marginwidth=\"0\" marginheight=\"0\" vspace=\"0\" hspace=\"0\" allowtransparency=\"true\" scrolling=\"no\"></iframe>";
		
		$this->object_change = false;
		return $html;
	}
}
?>