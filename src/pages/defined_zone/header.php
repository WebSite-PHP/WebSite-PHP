<?php
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