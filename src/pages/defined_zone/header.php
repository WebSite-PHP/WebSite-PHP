<?php
/**
 * Description of PHP file pages\defined_zone\header.php
 * Defined zone header: define the render of the zone header
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
 * @copyright   WebSite-PHP.com 17/03/2010
 *
 * @version     1.0.30
 * @access      public
 * @since       1.0.27
 */

class Header extends DefinedZone {
	function __construct() {
		parent::__construct();
		
		// Header
		$logo = new Picture("img/logo_128x400_".$_SESSION['lang'].".png", 128, 400);
		$logo->setTitle(SITE_NAME);
		$logo_link = new Link(BASE_URL.$_SESSION['lang']."/", Link::TARGET_NONE, $logo);
		$img_obj = new Object($logo_link);
		$img_obj->add("<br/><br/>");
		
		$this->render = $img_obj;
	}
}
?>
