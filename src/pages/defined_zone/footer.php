<?php
/**
 * PHP file pages\defined_zone\footer.php
 */
/**
 * Defined zone footer: define the render of the zone footer
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
 * @copyright   WebSite-PHP.com 26/05/2011
 * @version     1.0.87
 * @access      public
 * @since       1.0.51
 */

class Footer extends DefinedZone {
	function __construct() {
		parent::__construct();
		
		// Footer
		$footer_obj = new Object("<br/>", "Copyright &copy; 2011-".date("Y"));
		$footer_link = new Link(BASE_URL, Link::TARGET_NONE, SITE_NAME);
		$footer_obj->add($footer_link);
		
		$footer_obj = new Font($footer_obj, 9);
		
		$this->render = $footer_obj;
	}
}
?>
