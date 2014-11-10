<?php
/**
 * PHP file pages\defined_zone\footer.php
 */
/**
 * Defined zone footer: define the render of the zone footer
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2014 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 10/11/2014
 * @version     1.2.10
 * @access      public
 * @since       1.0.51
 */

class Footer extends DefinedZone {
	function __construct() {
		// Footer
		$footer_obj = new Object("<br/>", "Copyright &copy; 2013-".date("Y"));
		$footer_link = new Link(BASE_URL, Link::TARGET_NONE, __(SITE_NAME));
		$footer_obj->add($footer_link);
		
		$footer_obj = new Font($footer_obj, 9);
		
		$this->render = $footer_obj;
	}
}
?>
