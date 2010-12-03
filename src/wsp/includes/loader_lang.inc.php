<?php
	// default language parameters files
	$list_lang_param_files = array();
	$list_lang_param_files[] = "all";
	$list_lang_param_files[] = "default";
	$list_lang_param_files[] = "calendar";

	$last_lang = SITE_DEFAULT_LANG;
	if ($last_lang == "SITE_DEFAULT_LANG") {
		$last_lang = "en";
	}
	$redirect_to_default_lang = false;
	if (isset($_SESSION['lang']) && $_SESSION['lang'] != "") {
		$last_lang = $_SESSION['lang'];
	} else {
		$redirect_to_default_lang = true;
	}
	
	if (isset($_GET['l']) && $_GET['l'] != "") {
		$_SESSION['lang'] = $_GET['l'];
		$redirect_to_default_lang = false;
	}
	if (!isset($_SESSION['lang'])) {
		$default_language_exist = false;
		$detected_language = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
		if ($detected_language[0] != "") {
			$detected_language = strtolower(substr(chop($detected_language[0]),0,2));
			$array_lang_dir = scandir("lang");
			for ($i=0; $i < sizeof($array_lang_dir); $i++) {
				if ($array_lang_dir[$i] != "." && $array_lang_dir[$i] != ".." && is_dir("lang/".$array_lang_dir[$i])) {
					$_SESSION['lang'] = $array_lang_dir[$i];
					if ($_SESSION['lang'] == $detected_language) {
						$default_language_exist = false;
						break;
					}
					if ($_SESSION['lang'] == SITE_DEFAULT_LANG) {
						$default_language_exist = true;
					}
				}
			}
		}
		if (!isset($_SESSION['lang']) || $default_language_exist) {
			$_SESSION['lang'] = SITE_DEFAULT_LANG;
		}
	}
	
	for ($i=0; $i < sizeof($list_lang_param_files); $i++) {
		if (file_exists("lang/".$_SESSION['lang']."/".$list_lang_param_files[$i].".inc.php")) {
			require("lang/".$_SESSION['lang']."/".$list_lang_param_files[$i].".inc.php");
		} else if ($list_lang_param_files[$i] != "all") {
			if (file_exists("lang/".$last_lang."/".$list_lang_param_files[$i].".inc.php")) {
				require("lang/".$last_lang."/".$list_lang_param_files[$i].".inc.php");
			}
			$_GET['p'] = "error-lang";
		}
	}
	if ($_GET['p'] == "error-lang") {
		$_SESSION['lang'] = $last_lang;
	}
	
	// check if it's an URL with language info
	if (LANGUAGE_URL != $_SESSION['lang'] || LANGUAGE_URL == "") {
		$redirect_to_default_lang = true;
	}
	if ($redirect_to_default_lang) {
		if (file_exists('install.htaccess')) {
	    	rename('install.htaccess', '.htaccess');
	    	$test_url = @file_get_contents(BASE_URL.$_SESSION['lang']."/".PARAMS_URL);
	    	if ($test_url == "") {
	    		rename('.htaccess', 'install.htaccess');
	    		exit("The webserver needs to support either mod_rewrite or \"AllowOverride All\" for your website directory!\n");
	    	}
		}
		
		header('HTTP/1.1 301 Moved Temporarily');  
		header('Status: 301 Moved Temporarily');  
		header("Location:".BASE_URL.$_SESSION['lang']."/".PARAMS_URL);
		//echo "DEBUG : redirect to ".BASE_URL.$_SESSION['lang']."/".PARAMS_URL."<br>";
		exit;
	}
	
	if (file_exists("lang/".$_SESSION['lang']."/".$_GET['p'].".inc.php")) {
		require("lang/".$_SESSION['lang']."/".$_GET['p'].".inc.php");
	}
?>