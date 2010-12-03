<?php
class Footer extends DefinedZone {
	function __construct() {
		parent::__construct();
		
		// Footer
		$footer_obj = new Object("<br/>", "Copyright © 2009-".date("Y"));
		$footer_link = new Link(BASE_URL, Link::TARGET_NONE, SITE_NAME);
		$footer_obj->add($footer_link);
		
		$footer_obj = new Font($footer_obj, 9);
		
		$this->render = $footer_obj;
	}
}
?>