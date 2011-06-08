<?php
// Warning, this script is use to update the framework WebSite-PHP
// This script will delete some files to clean the wsp files and folders

if (isset($is_call_from_wsp_admin_update) && $is_call_from_wsp_admin_update == true) {
	$base_dir = dirname(__FILE__)."/../../../";
	
	// Update: delete non used lanaguages
	if (!isset($array_lang_used) && !is_array($array_lang_used)) {
		$array_lang_used = array('en', 'fr');
	}
	$array_lang_dir = scandir($base_dir."/lang");
	for ($i=0; $i < sizeof($array_lang_dir); $i++) {
		if (is_dir($base_dir."/lang/".$array_lang_dir[$i])) {
			if (!in_array($array_lang_dir[$i], $array_lang_used)) {
				rrmdir($base_dir."/lang/".$array_lang_dir[$i]."/");
			}
		}
	}
	
	// Update: version 1.0.84
	rrmdir($base_dir."/wsp/class/display/advanced_object/google/googlesearch/");
	unlink($base_dir."/wsp/class/display/advanced_object/ContactForm.class.php");
	if (!file_exists($base_dir."/wsp/config/modules.cnf")) {
		$modules_conf = new File($base_dir."/wsp/config/modules.cnf");
		$modules_conf->write("Authentication\n");
		$modules_conf->close();
	}
	
	
	// Update: .htaccess
	$htaccess_data = "";
	$ht_file = new File($base_dir."/.htaccess");
	while (($line = $ht_file->read_line()) != false) {
		if (find($line, "# End zone for your URL rewriting") > 0) {
			break;
		}
		$htaccess_data .= $line;
	}
	$htaccess_data = $htaccess_data.file_get_contents($base_dir."/update.htaccess");
	$ht_file->close();
	
	$ht_file = new File($base_dir."/.htaccess", false, true);
	$ht_file->write($htaccess_data);
	$ht_file->close();
	
	unlink($base_dir."/update.htaccess");
}
?>