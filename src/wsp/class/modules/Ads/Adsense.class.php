<?php
/**
 * PHP file wsp\class\modules\Ads\Adsense.class.php
 * @package modules
 * @subpackage Ads
 */
/**
 * Class Adsense
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package modules
 * @subpackage Ads
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.2.13
 */

/**
 * PHP file wsp\class\display\advanced_object\google\Adsense.class.php
 * @package display
 * @subpackage advanced_object.google
 */
/**
 * Class Adsense
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2014 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object.google
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 10/11/2014
 * @version     1.2.10
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
	private $is_async = true;
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
	 * Method disableAsynchronous
	 * @access public
	 * @since 1.2.7
	 */
	public function disableAsynchronous() {
		$this->is_async = false;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Adsense
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
        if ($this->is_async || $this->getPage()->isThirdPartyCookiesFilterEnable()) {
            if ($this->getPage()->isThirdPartyCookiesFilterEnable()) {
                $adsense_html = "<script type=\"text/javascript\">\n";
                $adsense_html .= "(tarteaucitron.job = tarteaucitron.job || []).push('adsense');\n";
                $adsense_html .= "(adsbygoogle = window.adsbygoogle || []).push({});\n";
                $adsense_html .= "</script>\n";
            } else {
                $adsense_html = "<script async src=\"//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js\"></script>\n";
            }
            $adsense_html .= "<ins class=\"adsbygoogle\"\n";
            $adsense_html .= "     style=\"display:inline-block;width:" . $this->google_ad_width . "px;height:" . $this->google_ad_height . "px\"\n";
            $adsense_html .= "     data-ad-client=\"" . $this->google_ad_client . "\"\n";
            $adsense_html .= "     data-ad-slot=\"" . $this->google_ad_slot . "\"\n";
            if (GOOGLE_CODE_TRACKER != "" && !isLocalDebug() &&
                !defined('GOOGLE_CODE_TRACKER_NOT_ACTIF')
            ) {
                $adsense_html .= "     data-analytics-uacct=\"" . GOOGLE_CODE_TRACKER . "\"\n";
            }
            $adsense_html .= "></ins>\n";
            if (!$this->getPage()->isThirdPartyCookiesFilterEnable()) {
                $adsense_html .= "<script>\n";
                $adsense_html .= "(adsbygoogle = window.adsbygoogle || []).push({});\n";
                $adsense_html .= "</script>\n";
            }
        } else {
            $adsense_html = $this->getJavascriptTagOpen();
            $adsense_html .= "	google_ad_client=\"" . $this->google_ad_client . "\";\n";
            $adsense_html .= "	google_ad_slot=\"" . $this->google_ad_slot . "\";\n";
            $adsense_html .= "	google_ad_width=" . $this->google_ad_width . ";\n";
            $adsense_html .= "	google_ad_height=" . $this->google_ad_height . ";\n";
            if (GOOGLE_CODE_TRACKER != "" && !isLocalDebug() &&
                !defined('GOOGLE_CODE_TRACKER_NOT_ACTIF')
            ) {
                $adsense_html .= "	window.google_analytics_uacct=\"" . GOOGLE_CODE_TRACKER . "\";\n";
                if (SUBDOMAIN_URL != "") {
                    $adsense_html .= "	google_analytics_domain_name=\"";
                    if (!defined('FORCE_SERVER_NAME') || FORCE_SERVER_NAME == "") {
                        $adsense_html .= str_replace(SUBDOMAIN_URL . ".", ".", $_SERVER['SERVER_NAME']);
                    } else {
                        $adsense_html .= str_replace(SUBDOMAIN_URL . ".", ".", FORCE_SERVER_NAME);
                    }
                    $adsense_html .= "\";\n";
                } else {
                    $adsense_html .= "	google_analytics_domain_name=\"none\";\n";
                }
            }
            $adsense_html .= $this->getJavascriptTagClose();
            $adsense_html .= "<script src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\"></script>\n";
        }
		$html = $adsense_html;
		
		$this->object_change = false;
		return $html;
	}
}
?>
