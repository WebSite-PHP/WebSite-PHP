<?php
// Warning, this script is use to update the framework WebSite-PHP
// This script will delete some files to clean the wsp files and folders
if ($is_call_from_wsp_admin_update == true) {
	$base_dir = dirname(__FILE__)."/../../../";
	
	// version 1.0.84
	rrmdir($base_dir."/wsp/class/display/advanced_object/google/googlesearch/");
	unlink($base_dir."/wsp/class/display/advanced_object/ContactForm.class.php");
	if (!file_exists($base_dir."/wsp/config/modules.cnf")) {
		$modules_conf = new File($base_dir."/wsp/config/modules.cnf");
		$modules_conf->write("Authentication\n");
		$modules_conf->close();
	}
	
	// TODO : update .htaccess
}
?>