<?php
/**
 * PHP file wsp\includes\utils_label.inc.php
 */
/**
 * WebSite-PHP file utils_label.inc.php
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
 * @since       1.2.1
 */

	global $WSP_AUTO_CREATE_CONSTANT;
	$GLOBALS['WSP_AUTO_CREATE_CONSTANT'] = isLocalDebug();

	function __() {
		$args = func_get_args();
		return translate($args);
	}
	
	function translate($txt) {
		if (is_array($txt)) {
			$args = $txt;
		} else {
			$args = func_get_args();
		}
		$txt = array_shift($args);
		
		// Test if constant exists (constant without space)
		if (!defined($txt) && find($txt, " ") == 0) {
			if (!($key = getConstantName($txt))) {
				// auto create constant in translation files
				create_label_translation($txt);
			}
		}
		
		// Encode data
		$array_lang_convert_html = array('ru');
		if ($GLOBALS['__AJAX_LOAD_PAGE__'] == true && !in_array($_GET['l'], $array_lang_convert_html) && 
			(find($_GET['mime'], "xml") > 0 || find($_GET['mime'], "rss") > 0)) {
				$txt = utf8decode($txt);
		} else {
			$txt = utf8encode($txt);
		}
		
		// convert %s by args
		for ($i=0; $i < sizeof($args); $i++) {
			if ($GLOBALS['__AJAX_LOAD_PAGE__'] == true && !in_array($_GET['l'], $array_lang_convert_html) && 
				(find($_GET['mime'], "xml") > 0 || find($_GET['mime'], "rss") > 0)) {
					$txt = preg_replace('/%s/', utf8decode($args[$i]), $txt, 1);
			} else {
				$txt = preg_replace('/%s/', utf8encode($args[$i]), $txt, 1);
			}
    	}
    	
    	if ($GLOBALS['__AJAX_LOAD_PAGE__'] == true && in_array($_GET['l'], $array_lang_convert_html) && 
			(find($_GET['mime'], "xml") > 0 || find($_GET['mime'], "rss") > 0)) {
				$txt = convert_utf8_to_html($txt);	
		}
    	return $txt;
	}
	
	function getConstantName($constantValue) {
		foreach(get_defined_constants() as $key => $value) {
			if(constant($key)===$constantValue) {
				return $key; 
			}
		}
		return false;
	}
	
	function create_label_translation($constantValue) {
		$translate_file = $_GET['p'].".inc.php";
		
		// Check if translation needs to be writed in all.inc.php
		$trace_array = explode("\n", getDebugBacktrace(2));
		if (isset($trace_array[1])) {
			$trace_array[1] = str_replace("\\", "/", $trace_array[1]);
			if (find($trace_array[1], "wsp/includes/utils_label.inc.php") > 0) { // call function __()
				$trace = (isset($trace_array[4])?$trace_array[4]:"");
			} else { // call function translate()
				$trace = (isset($trace_array[1])?$trace_array[1]:"");
			}
			$trace = str_replace("\\", "/", $trace);
			if (($pos = find($trace, SITE_DIRECTORY)) > 0) {
				$trace_file = substr($trace, $pos, strlen($trace));
				$page_label = str_replace("/pages/", "", substr($trace_file, 0, strlen($trace_file)-4));
				if ($page_label != $_GET['p']) {
					$translate_file = "all.inc.php";
				}
			}
		}
		
		// Create new label in each languages
		$creation_message = "";
		$base_dir = dirname(__FILE__)."/../..";
		$array_lang_dir = scandir($base_dir."/lang");
		for ($i=0; $i < sizeof($array_lang_dir); $i++) {
			if (is_dir($base_dir."/lang/".$array_lang_dir[$i]) && $array_lang_dir[$i] != "" && 
				$array_lang_dir[$i] != "." && $array_lang_dir[$i] != ".." && $array_lang_dir[$i] != ".svn" && 
				strlen($array_lang_dir[$i]) == 2) {
					$lang_file_path = str_replace("\\", "/", realpath($base_dir."/lang/".$array_lang_dir[$i]))."/".$translate_file;
					
					// Read File
					$lang_file_content = "";
					if (file_exists($lang_file_path)) {
						$lang_file = new File($lang_file_path);
						$lang_file_content = $lang_file->read();
						$lang_file->close();
					}
					
					// Check if the label doesn't already exists for this language
					if (!label_exists($lang_file_content, $constantValue)) {
						// Create new label
						if ($lang_file_content == "") {
							$lang_file_content = "<?php\n";
						}
						$lang_file_content = str_replace("\r", "", $lang_file_content);
						$lang_file_content = str_replace_last("?>", "", $lang_file_content);
						$lang_file_content .= "	define('".addslashes($constantValue)."', '".addslashes($constantValue)."'); // TODO: Label needs to be translated\n";
						$lang_file_content .= "?>";
						
						// Write File
						if ($GLOBALS['WSP_AUTO_CREATE_CONSTANT']) {
							$lang_file = new File($lang_file_path, false, true);
							if ($lang_file->write($lang_file_content) !== false) {
								$creation_message .= "Information: Constant <font color='blue'>".$constantValue."</font> automatically <font color='green'>CREATED</font> in the file ".$lang_file_path.".<br/>";
							}
							$lang_file->close();
						}
						
						// Check if this label doesn't exists in other language for the current page
						if ($translate_file == "all.inc.php") {
							$page_lang_file_path = str_replace("\\", "/", realpath($base_dir."/lang/".$array_lang_dir[$i]))."/".$_GET['p'].".inc.php";
							if (file_exists($page_lang_file_path)) {
								$lang_file = new File($page_lang_file_path);
								$lang_file_content = $lang_file->read();
								$lang_file->close();
								
								if (!label_exists($lang_file_content, $constantValue)) {
									$label_found = false;
									if (find($lang_file_content, "define(\"".$constantValue."\"") > 0) {
										$lang_file_content = str_replace_first("define(\"".$constantValue."\"", "// TODO: Remove label (now in all.inc.php) -> define(\"".$constantValue."\"", $lang_file_content);
										$label_found = true;
									} else if (find($lang_file_content, "define('".$constantValue."'") > 0) {
										$lang_file_content = str_replace_first("define('".$constantValue."'", "// TODO: Remove label (now in all.inc.php) -> define('".$constantValue."'", $lang_file_content);
										$label_found = true;
									}
									
									// Write File
									if ($label_found && $GLOBALS['WSP_AUTO_CREATE_CONSTANT']) {
										$lang_file = new File($page_lang_file_path, false, true);
										if ($lang_file->write($lang_file_content) !== false) {
											$creation_message .= "Information: Constant <font color='blue'>".$constantValue."</font> automatically <font color='red'>COMMENT</font> in the file ".$page_lang_file_path.".<br/>";
										}
										$lang_file->close();
									}
								}
							}
						}
					}
					
			}
		}
		if ($creation_message != "") {
			// Simulate the new label is loaded 
			define($constantValue, $constantValue);
			
			// Inform the developer by DialogBox
			if ($GLOBALS['__AJAX_LOAD_PAGE__'] == false || 
				($GLOBALS['__AJAX_LOAD_PAGE__'] == true && find($_GET['mime'], "html") > 0)) {
					$dialog = new DialogBox("Alert translation", $creation_message);
					$dialog->activateCloseButton()->setWidth(600);
					Page::getInstance($_GET['p'])->addObject($dialog);
			}
			// Inform the developer by mail
			if (defined('SEND_ERROR_BY_MAIL') && SEND_ERROR_BY_MAIL == true && !isLocalDebug()) {
					try {
						$mail = new SmtpMail(SEND_ERROR_BY_MAIL_TO, __(SEND_ERROR_BY_MAIL_TO), "New label on ".__(SITE_NAME)." !!!", $creation_message, SMTP_MAIL, __(SMTP_NAME));
						$mail->setPriority(SmtpMail::PRIORITY_HIGH);
						$mail->send();
					} catch (Exception $e) {}
			}
		}
	}
	
	// Check if the label exists in the specified content and is not comment
	function label_exists($labels_content, $constantValue) {
		$label_exists = false;
		if (trim($labels_content) != "") {
			$labels_content = str_replace("\"", "", str_replace("'", "", str_replace(" ", "", $labels_content)));
			$pos = find($labels_content, "define(".$constantValue.",");
			if ($pos > 0) {
				$label_exists = true;
				
				$content_begin = substr($labels_content, 0, $pos);
				$pos2 = strrpos($content_begin, "\n")+$pos2+1;
				$content_end = substr($labels_content, $pos, strlen($labels_content));
				$pos3 = strpos($content_end, "\n")+$pos;
				if ($pos3 == 0) { $pos3 = strlen($labels_content); }
				$constantLine = substr($labels_content, $pos2, $pos3-$pos2);
				//echo $constantValue.": ".str_replace("\n", "<br/>", htmlentities($constantLine))."<br/>";
				
				$pos4 = find($constantLine, "define(".$constantValue.",");
				if ($pos4 > 0) {
					$pos5 = $pos4 - strlen("define(".$constantValue.",");
					$beforeConstant = substr($constantLine, 0, $pos5);
					if (find($beforeConstant, "//") > 0 || (find($beforeConstant, "/*") > 0 && find($beforeConstant, "*/") == 0)) {
						$label_exists = false;
					}
					//echo $constantValue.": ".str_replace("\n", "<br/>", htmlentities($beforeConstant))."<br/>";
				}
			}
		}
		return $label_exists;
	}
?>
