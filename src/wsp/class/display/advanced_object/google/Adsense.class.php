<?php
/**
 * Description of PHP file wsp\class\display\advanced_object\google\Adsense.class.php
 * Class Adsense
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 22/10/2010
 *
 * @version     1.0.40
 * @access      public
 * @since       1.0.17
 */

class Adsense extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $google_ad_client = "";
	private $google_ad_slot = "";
	private $google_ad_width = 0;
	private $google_ad_height = 0;
	/**#@-*/
	
	/**
	 * Constructor Adsense
	 * @param mixed $google_ad_client 
	 * @param mixed $google_ad_slot 
	 * @param mixed $google_ad_width 
	 * @param mixed $google_ad_height 
	 */
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
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Adsense
	 * @since 1.0.35
	 */
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
