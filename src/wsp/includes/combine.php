<?php
include("../config/config.inc.php");

$_GET['files'] = str_replace("|", "/", $_GET['files']);
if ($_GET['type'] == "js") {
	include("php-closure.php");
	
	$c = new PhpClosure();
	
	$nb_file = 0;
	$array_files = explode(',', $_GET['files']);
	for ($i=0; $i < sizeof($array_files); $i++) {
		$file = "../js/".$array_files[$i];
		if (file_exists($file) && is_file($file)) {
			$c->add($file);
			$nb_file++;
		} else if (is_file($file)) {
			echo "alert('Unable to load js file: ".$file."');\n";
		}
	}
	
	if (!is_dir("../cache/js/")) {
		mkdir("../cache/js/");
	}
	
	$c->simpleMode();
	
	if (!defined('JS_COMPRESSION_TYPE')) {
		define("JS_COMPRESSION_TYPE", "NONE");
	}
	
	if (JS_COMPRESSION_TYPE == "GOOGLE_WS") {
		$c->compressionGoogle();
	} else if (JS_COMPRESSION_TYPE == "LOCAL") {
		$c->compressionLocal();
	} else {
		$c->compressionNone();
	}
	
	if ($nb_file > 0) {
		$c->cacheDir("../cache/js/");
	}
	if (!DEBUG) {
		$c->hideDebugInfo();
	}
	$c->write();
} else if ($_GET['type'] == "css") {
	if (!is_dir("../cache/css/")) {
		mkdir("../cache/css/");
	}
	
	$_GET['type']="css";
	include("css-merge.php");
}
?>