<?php
/**
 * PHP file wsp\includes\loader_class.inc.php
 */
/**
 * WebSite-PHP file loader_class.inc.php
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       0
 */

	function loadWspClass($folder, $sub_folder=false) {
		if (is_dir($folder)) {
			$array_components_dir = scandir($folder);
			for ($i=0; $i < sizeof($array_components_dir); $i++) {
				if (is_file($folder."/".$array_components_dir[$i]) && 
					strtolower(substr($array_components_dir[$i], strlen($array_components_dir[$i])-10, 10)) == ".class.php") {
					require_once($folder."/".$array_components_dir[$i]);
				} else if ($sub_folder==true && is_dir($folder."/".$array_components_dir[$i]) && 
					$array_components_dir[$i] != "." && $array_components_dir[$i] != ".." && $array_components_dir[$i] != ".svn") {
					loadWspClass($folder."/".$array_components_dir[$i], $sub_folder);
				}
			}
		}
	}

	loadWspClass("wsp/class/abstract", true);
	
	// Load standard classes
	loadWspClass("wsp/class");
	
	// Load display classes
	loadWspClass("wsp/class/display", true);
	
	// Load database classes
	loadWspClass("wsp/class/database");
	
	// Load database_object classes
	loadWspClass("wsp/class/database_object");
	
	// Load wsp database_model classes
	loadWspClass("wsp/class/database_model/wsp");
	
	// Load database_model classes
	loadWspClass("wsp/class/database_model");
	
	// Load modules classes
	if (file_exists(dirname(__FILE__)."/../config/modules.cnf")) {
		$list_modules = file_get_contents(dirname(__FILE__)."/../config/modules.cnf");
		$array_modules = explode("\n", $list_modules);
		for ($i=0; $i < sizeof($array_modules); $i++) {
			if (trim($array_modules[$i]) != "") {
				loadWspClass("wsp/class/modules/".trim($array_modules[$i]), true);
			}
		}
	}
	
	// Load utils classes
	loadWspClass("wsp/class/utils");
	
	// Load wsp webservice classes
	if (in_array("soap", get_loaded_extensions(false))) {
		loadWspClass("wsp/class/webservice/wsp");
	}

	// Load Defined Zone
	$array_defined_zone_dir = scandir("pages/defined_zone");
	for ($i=0; $i < sizeof($array_defined_zone_dir); $i++) {
		if (is_file("pages/defined_zone/".$array_defined_zone_dir[$i]) && 
				strtolower(substr($array_defined_zone_dir[$i], strlen($array_defined_zone_dir[$i])-4, 4)) == ".php") {
			try {
				require_once("pages/defined_zone/".$array_defined_zone_dir[$i]);
			} catch (Exception $e) {}
		}
	}
?>
