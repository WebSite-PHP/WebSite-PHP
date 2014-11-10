<?php
/**
 * PHP file pages\defined_zone\header.php
 */
/**
 * Defined zone header: define the render of the zone header
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

class Header extends DefinedZone {
	function __construct() {
		// Header
		$logo = new Picture("img/logo_128x400_".$_SESSION['lang'].".png", 128, 400);
		$logo->setTitle(__(SITE_NAME));
		$logo_link = new Link(BASE_URL.$_SESSION['lang']."/", Link::TARGET_NONE, $logo);
		$img_obj = new Object($logo_link);
		$img_obj->add("<br/><br/>");
		
		$this->render = $img_obj;
	}
}
?>
