<?php
/**
 * PHP file wsp\class\display\advanced_object\google\Adsense.class.php
 * @package display
 * @subpackage advanced_object.google
 */
/**
 * Class Adsense
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2013 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object.google
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 18/02/2013
 * @version     1.2.3
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
			throw new NewException("4 arguments for ".get_class($this)."::__construct() are mandatory", 0, getDebugBacktrace(1));
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
		$adsense_html = $this->getJavascriptTagOpen();
		$adsense_html .= "	google_ad_client=\"".$this->google_ad_client."\";\n";
		$adsense_html .= "	google_ad_slot=\"".$this->google_ad_slot."\";\n";
		$adsense_html .= "	google_ad_width=".$this->google_ad_width.";\n";
		$adsense_html .= "	google_ad_height=".$this->google_ad_height.";\n";
		if (GOOGLE_CODE_TRACKER != "" && 
			find(BASE_URL, "127.0.0.1".($_SERVER['SERVER_PORT']!=80?":".$_SERVER['SERVER_PORT']:"")."/", 0, 0) == 0 && 
			find(BASE_URL, "localhost".($_SERVER['SERVER_PORT']!=80?":".$_SERVER['SERVER_PORT']:"")."/", 0, 0) == 0 && 
			!defined('GOOGLE_CODE_TRACKER_NOT_ACTIF')) {
				$adsense_html .= "	window.google_analytics_uacct=\"".GOOGLE_CODE_TRACKER."\";\n";
				if (SUBDOMAIN_URL != "") { 
					$adsense_html .= "	google_analytics_domain_name=\"".str_replace(SUBDOMAIN_URL, "", $_SERVER['SERVER_NAME'])."\";\n";
				} else {
					$adsense_html .= "	google_analytics_domain_name=\"none\";\n";
				}
		}
		$adsense_html .= $this->getJavascriptTagClose();
		$adsense_html .= "<script src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\"></script>\n";
		
		//if (is_browser_ie() && get_browser_ie_version() >= 9) {
			$html = $adsense_html;
		/*} else {
			// loading optimisation for other browser
			$rand_val = rand(100000000, 9999999999);
			$html = "<div id=\"adsense_".$rand_val."_".$this->google_ad_client."_".$this->google_ad_slot."_".$this->google_ad_width."x".$this->google_ad_height."\" style=\"width:".$this->google_ad_width."px;height".$this->google_ad_height."px;\"></div>\n";
			
			$ad_html = "<div id=\"ad_data_".$rand_val."_".$this->google_ad_client."_".$this->google_ad_slot."_".$this->google_ad_width."x".$this->google_ad_height."\" style=\"display:none;\">\n";
			$ad_html .= $adsense_html;
			$ad_html .= "</div>";
			$ad_html .= $this->getJavascriptTagOpen();
			$ad_html .= "	$(document).ready(function() {\n";
			$ad_html .= "		document.getElementById('adsense_".$rand_val."_".$this->google_ad_client."_".$this->google_ad_slot."_".$this->google_ad_width."x".$this->google_ad_height."').appendChild(document.getElementById('ad_data_".$rand_val."_".$this->google_ad_client."_".$this->google_ad_slot."_".$this->google_ad_width."x".$this->google_ad_height."'));\n";
			$ad_html .= "		document.getElementById('ad_data_".$rand_val."_".$this->google_ad_client."_".$this->google_ad_slot."_".$this->google_ad_width."x".$this->google_ad_height."').style.display = '';\n";
			$ad_html .= "	});\n";
			$ad_html .= $this->getJavascriptTagClose();
			
			$this->getPage()->addObject(new Object($ad_html), false, true);
		}*/
		
		$this->object_change = false;
		return $html;
	}
}
?>
