<?php
define(GOOGLE_CODE_TRACKER_NOT_ACTIF, true);

class Disconnect extends Page {
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		$this->setUserRights("");
		$this->redirect("connect.html");
	}
}
?>