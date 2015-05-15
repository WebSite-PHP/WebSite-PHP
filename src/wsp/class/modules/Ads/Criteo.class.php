<?php
/**
 * PHP file wsp\class\modules\Ads\Criteo.class.php
 * @package modules
 * @subpackage Ads
 */
/**
 * Class Criteo
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

class Criteo extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
    private $criteo_zone_id = "";
    private $width = "";
    private $height = "";
	/**#@-*/
	
	/**
	 * Constructor Criteo
	 * @param mixed $criteo_zone_id 
	 * @param string $width 
	 * @param string $height 
	 */
	function __construct($criteo_zone_id, $width='', $height='') {
		parent::__construct();
		
		if (!isset($criteo_zone_id)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, getDebugBacktrace(1));
		}

        $this->criteo_zone_id = $criteo_zone_id;
        $this->width = $width;
        $this->height = $height;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Criteo
	 * @since 1.2.13
	 */
	public function render($ajax_render=false) {
        $html = "";
        if ($this->getPage()->isThirdPartyCookiesFilterEnable()) {
            $html .= "<div class=\"criteo-canvas\" zoneid=\"".$this->criteo_zone_id."\"";
            if ($this->width != "" || $this->height != "") {
                $html .= " style=\"";
                if ($this->width != "") {
                    $html .= "width:".$this->width."px;";
                }
                if ($this->height != "") {
                    $html .= "height:".$this->height."px;";
                }
                $html .= "\"";
            }
            $html .= "></div>";
            $this->getPage()->addObject(new JavaScript("(tarteaucitron.job = tarteaucitron.job || []).push('criteo');"), false, true);
        } else {
            $html .= "<script type=\"text/javascript\">
document.MAX_ct0 ='';
var m3_u = (location.protocol=='https:'?'https://cas.criteo.com/delivery/ajs.php?':'http://cas.criteo.com/delivery/ajs.php?');
var m3_r = Math.floor(Math.random()*99999999999);
document.write (\"<scr\"+\"ipt type='text/javascript' src='\"+m3_u);
document.write (\"zoneid=".$this->criteo_zone_id."\");document.write(\"&amp;nodis=1\");
document.write ('&amp;cb=' + m3_r);
if (document.MAX_used != ',') document.write (\"&amp;exclude=\" + document.MAX_used);
document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
document.write (\"&amp;loc=\" + escape(window.location));
if (document.referrer) document.write (\"&amp;referer=\" + escape(document.referrer));
if (document.context) document.write (\"&context=\" + escape(document.context));
if ((typeof(document.MAX_ct0) != 'undefined') && (document.MAX_ct0.substring(0,4) == 'http')) {
    document.write (\"&amp;ct0=\" + escape(document.MAX_ct0));
}
if (document.mmm_fo) document.write (\"&amp;mmm_fo=1\");
document.write (\"'></scr\"+\"ipt>\");
</script>";
        }
		
		$this->object_change = false;
		return $html;
	}
}
?>
