<?php
// Warning, this script is use to update the framework WebSite-PHP
// This script will delete some files to clean the wsp files and folders

if (isset($is_call_from_wsp_admin_update) && $is_call_from_wsp_admin_update == true && 
	isset($_SESSION['USER_RIGHTS']) && ($_SESSION['USER_RIGHTS'] == "administrator" || in_array("administrator", $_SESSION['USER_RIGHTS']))) {
	
	include_once(dirname(__FILE__)."/../../../wsp/class/utils/File.class.php");
	$script_log_file = new File(dirname(__FILE__)."/tmp/wsp-update-script.log", false, true);
	$script_log_file->write("WSP clean script log:\n");
	
	$base_dir = dirname(__FILE__)."/../../../";
	
	// Update: delete non used lanaguages
	if (!isset($array_lang_used) && !is_array($array_lang_used)) {
		$array_lang_used = array('en', 'fr', 'de');
	}
	$array_lang_dir = scandir($base_dir."/lang");
	for ($i=0; $i < sizeof($array_lang_dir); $i++) {
		if (is_dir($base_dir."/lang/".$array_lang_dir[$i]) && $array_lang_dir[$i] != "" && 
			$array_lang_dir[$i] != "." && $array_lang_dir[$i] != ".." && $array_lang_dir[$i] != ".svn" && 
			strlen($array_lang_dir[$i]) == 2) {
				if (!in_array($array_lang_dir[$i], $array_lang_used)) {
					rrmdir($base_dir."/lang/".$array_lang_dir[$i]."/");
				}
		}
	}
	
	// Init version variables
	if (!isset($old_wsp_vserion)) {
		$old_wsp_vserion = "1.0.84";
	}
	$older_version = false;
	
	// Update: version 1.0.84
	if (version_compare($old_wsp_vserion, '1.0.84') <= 0 || $older_version) {
		$script_log_file->write("[".date("Y-m-d H:i:s")."] Start version 1.0.84 clean ...\n");
		
		rrmdir($base_dir."/wsp/class/display/advanced_object/google/googlesearch/");
		unlink($base_dir."/wsp/class/display/advanced_object/ContactForm.class.php");
		if (!file_exists($base_dir."/wsp/config/modules.cnf")) {
			$modules_conf = new File($base_dir."/wsp/config/modules.cnf");
			$modules_conf->write("Authentication\n");
			$modules_conf->close();
		}
		
		$script_log_file->write("[".date("Y-m-d H:i:s")."] End version 1.0.84 clean\n");
		$older_version = true;
	}
	
	// Update: version 1.0.86
	if (version_compare($old_wsp_vserion, '1.0.86') <= 0 || $older_version) {
		$script_log_file->write("[".date("Y-m-d H:i:s")."] Start version 1.0.86 clean ...\n");
		
		unlink($base_dir."/wsp/js/jquery-1.4.4.min.js");
		unlink($base_dir."/wsp/js/jquery-ui-1.8.6.custom.min.js");
		
		$script_log_file->write("[".date("Y-m-d H:i:s")."] End version 1.0.86 clean\n");
		$older_version = true;
	}
	
	// Update: version 1.0.87
	if (version_compare($old_wsp_vserion, '1.0.87') <= 0 || $older_version) {
		$script_log_file->write("[".date("Y-m-d H:i:s")."] Start version 1.0.87 clean ...\n");
		
		unlink($base_dir."/wsp/class/display/advanced_object/DownloadButton.class.php");
		unlink($base_dir."/wsp/class/display/advanced_object/ImageRotator.class.php");
		unlink($base_dir."/wsp/class/display/advanced_object/Video.class.php");
		
		$script_log_file->write("[".date("Y-m-d H:i:s")."] End version 1.0.87 clean\n");
		$older_version = true;
	}
	
	// Update: version 1.0.88
	if (version_compare($old_wsp_vserion, '1.0.88') <= 0 || $older_version) {
		$script_log_file->write("[".date("Y-m-d H:i:s")."] Start version 1.0.88 clean ...\n");
		
		rrmdir($base_dir."/wsp/class/display/advanced_object/social_network/");
		
		$script_log_file->write("[".date("Y-m-d H:i:s")."] End version 1.0.88 clean\n");
		$older_version = true;
	}
	
	// Update: version 1.0.90
	if (version_compare($old_wsp_vserion, '1.0.90') <= 0 || $older_version) {
		$script_log_file->write("[".date("Y-m-d H:i:s")."] Start version 1.0.90 clean ...\n");
		
		rrmdir($base_dir."/wsp/css/jquery1.8.6/");
		unlink($base_dir."/wsp/js/jquery-1.5.2.min.js");
		unlink($base_dir."/wsp/js/jquery-ui-1.8.12.custom.min.js");
		unlink($base_dir."/wsp/js/jquery.qtip-1.0.0-rc3.min.js");
		
		$script_log_file->write("[".date("Y-m-d H:i:s")."] End version 1.0.90 clean\n");
		$older_version = true;
	}
	
	// Update: version 1.0.91
	if (version_compare($old_wsp_vserion, '1.0.91') <= 0 || $older_version) {
		$script_log_file->write("[".date("Y-m-d H:i:s")."] Start version 1.0.91 clean ...\n");
		
		rrmdir($base_dir."/wsp/includes/GraphicLib");
		rrmdir($base_dir."/wsp/includes/fpdf");
		rrmdir($base_dir."/wsp/includes/RSS-Generator");
		rrmdir($base_dir."/wsp/includes/RSS-Reader");
		
		$script_log_file->write("[".date("Y-m-d H:i:s")."] End version 1.0.91 clean\n");
		$older_version = true;
	}
	
	// Update: version 1.0.98
	if (version_compare($old_wsp_vserion, '1.0.98') <= 0 || $older_version) {
		$script_log_file->write("[".date("Y-m-d H:i:s")."] Start version 1.0.98 clean ...\n");
		
		unlink($base_dir."/404.php");
		
		$script_log_file->write("[".date("Y-m-d H:i:s")."] End version 1.0.98 clean\n");
		$older_version = true;
	}
	
	// Update: version 1.0.100
	if (version_compare($old_wsp_vserion, '1.0.100') <= 0 || $older_version) {
		$script_log_file->write("[".date("Y-m-d H:i:s")."] Start version 1.0.100 clean ...\n");
		
		unlink($base_dir."/pages/error/error-404.php");
		unlink($base_dir."/pages/error/error-database.php");
		
		$script_log_file->write("[".date("Y-m-d H:i:s")."] End version 1.0.100 clean\n");
		$older_version = true;
	}
	
	// Update: version 1.2.1
	if (version_compare($old_wsp_vserion, '1.2.1') <= 0 || $older_version) {
		$script_log_file->write("[".date("Y-m-d H:i:s")."] Start version 1.2.1 clean ...\n");
		
		rrmdir($base_dir."/pages/wsp-admin/template");
		rrmdir($base_dir."/wsp/class/modules/ImageRotator");
		rrmdir($base_dir."/lang/en/wsp-admin/template");
		rrmdir($base_dir."/lang/fr/wsp-admin/template");
		unlink($base_dir."/wsp/class/WebSitePhpEventObject.class.php");
		unlink($base_dir."/wsp/class/WebSitePhpObject.class.php");
		
		$script_log_file->write("[".date("Y-m-d H:i:s")."] End version 1.2.1 clean\n");
		$older_version = true;
	}
	
	// Update: version 1.2.2
	if (version_compare($old_wsp_vserion, '1.2.2') <= 0 || $older_version) {
		$script_log_file->write("[".date("Y-m-d H:i:s")."] Start version 1.2.2 clean ...\n");
		
		unlink($base_dir."/wsp/class/database/DbTableObject.class.php");
		
		$script_log_file->write("[".date("Y-m-d H:i:s")."] End version 1.2.2 clean\n");
		$older_version = true;
	}
	
	// Update: version 1.2.3
	if (version_compare($old_wsp_vserion, '1.2.3') <= 0 || $older_version) {
		$script_log_file->write("[".date("Y-m-d H:i:s")."] Start version 1.2.3 clean ...\n");
		
		unlink($base_dir."/wsp/class/display/RadioButton.class.php");
		
		$script_log_file->write("[".date("Y-m-d H:i:s")."] End version 1.2.3 clean\n");
		$older_version = true;
	}
	
	// Update: version 1.2.9
	if (version_compare($old_wsp_vserion, '1.2.9') <= 0 || $older_version) {
		$script_log_file->write("[".date("Y-m-d H:i:s")."] Start version 1.2.9 clean ...\n");
		
		unlink($base_dir."/wsp/class/modules/PDF/fpdf.php");
		
		$script_log_file->write("[".date("Y-m-d H:i:s")."] End version 1.2.9 clean\n");
		$older_version = true;
	}
	
	// reset current CSS and JS cache
	$script_log_file->write("[".date("Y-m-d H:i:s")."] Start purge cache folders ...\n");
	rrmdir($base_dir."/wsp/cache/css/");
	rrmdir($base_dir."/wsp/cache/js/");
	rrmdir($base_dir."/wsp/cache/adsense/");
	$script_log_file->write("[".date("Y-m-d H:i:s")."] End purge cache folders\n");
	
	// Move wsp-admin folder to the define folder on the file wsp/config/config_admin.inc.php
	include_once($base_dir."/wsp/config/config_admin.inc.php");
	if (WSP_ADMIN_URL != "wsp-admin") {
		$script_log_file->write("[".date("Y-m-d H:i:s")."] Start wsp-admin folder move ...\n");
		copy($base_dir."/pages/".WSP_ADMIN_URL."/.passwd", $base_dir."/pages/wsp-admin/.passwd");
		rrmdir($base_dir."/pages/".WSP_ADMIN_URL);
		rename($base_dir."/pages/wsp-admin", $base_dir."/pages/".WSP_ADMIN_URL);
		$script_log_file->write("[".date("Y-m-d H:i:s")."] End wsp-admin folder move\n");
	}
	
	// Update: .htaccess
	if (file_exists($base_dir."/update.htaccess")) {
		$script_log_file->write("[".date("Y-m-d H:i:s")."] Start update .htaccess ...\n");
		
		$htaccess_data = "";
		if (file_exists($base_dir."/.htaccess")) {
			$ht_file = new File($base_dir."/.htaccess");
			while (($line = $ht_file->read_line()) != false) {
				if (find($line, "# End zone for your URL rewriting") > 0) {
					break;
				}
				$htaccess_data .= $line;
			}
			$ht_file->close();
		} else {
			$htaccess_data = "# Rule file .htaccess
RewriteEngine on
Options +FollowSymLinks
Options -indexes
AddDefaultCharset utf-8

<IfModule mod_rewrite.c>
	# Redirecting www
	# Configure if you want redirect url http://example.com to http://www.example.com
	RewriteCond %{HTTP_HOST} ^mydomain\.com$ [NC]
	RewriteRule ^(.*)$ http://www.mydomain.com/$1 [R=301,L] 
	
	# Alias: If you have configured an alias in the httpd.conf of Apache
	# Uncomment this line and configure the name of your alias.
	# If you are not sure don't change this line.
	#RewriteBase /myAliasName/
	
	# Zone to define your URL rewriting
	# Exemple 1: 
	# Create an URL with 1 virtual folder (myfolder)
	# RewriteRule ^myfolder/(.+)\.html$ index.php?p=$1&l=en&%{QUERY_STRING} [L]
	# In this case the first parameter is the language (ie: en, fr, de, ...) 
	# RewriteRule ^([a-z]{2})/myfolder/(.+)\.html$ index.php?p=$2&l=$1&%{QUERY_STRING} [L] 
	# 
	# Exemple 2: 
	# Create an URL with 2 virtuals folders (myfolder and myfolder2)
	# RewriteRule ^myfolder/myfolder2/(.+)\.html$ index.php?p=$1&l=en&%{QUERY_STRING} [L] 
	# RewriteRule ^([a-z]{2})/myfolder/myfolder2/(.+)\.html$ index.php?p=$2&l=$1&%{QUERY_STRING} [L] 
	# 
	# Exemple 3: 
	# Create an URL with 1 variable virtual folder
	# The 2nd parameter exclude the folders ajax (use by the ajax pages of the framework) and wsp-admin (admin part of WSP)
	# RewriteRule ^([a-z]{2})/((?!(ajax|wsp\-admin)).+)/(.+)\.html$ index.php?p=my_page&l=$1&param1=$2&param2=$3&%{QUERY_STRING} [L]
	# 
	# Warning: Create your rules only if the framework can't support your special URL => virtual folder (the framework manages the real folders)
	#
	\n";
		}
		$htaccess_data = $htaccess_data.file_get_contents($base_dir."/update.htaccess");
		
		$ht_file = new File($base_dir."/.htaccess", false, true);
		$ht_file->write($htaccess_data);
		$ht_file->close();
		
		unlink($base_dir."/update.htaccess");
		
		$script_log_file->write("[".date("Y-m-d H:i:s")."] End update .htaccess\n");
	}
	
	$script_log_file->write("[".date("Y-m-d H:i:s")."] Start unset variables ...\n");
	require_once(dirname(__FILE__)."/../includes/utils-unset-var.inc.php");
	unsetWspAdminVariables();
	$script_log_file->write("[".date("Y-m-d H:i:s")."] End unset variables\n");
	
	$script_log_file->close();
} else {
	$bool = false;
}
?>