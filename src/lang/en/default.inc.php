<?php
	define("ERROR", "Error");
	define("WARNING", "Warning");
	define("LOADING", "Loading");
	define("CLOSE", "Close");
	
	define("ERROR_LANG", "Language error");
	define("ERROR_LANG_MSG", "Error unknown language.");
	
	define("ERROR_PAGE", "Page error");
	define("ERROR_PAGE_MSG", "Error unknown page %s.");
	
	define("ERROR_USER_RIGHTS", "User rights error");
	define("ERROR_USER_RIGHTS_MSG", "Error, user has no rights to display this page.");
	
	define("ERROR_DATABASE", "Database error");
	define("ERROR_DATABASE_MSG", "Error: %s");
	
	define("ERROR_DEBUG_MAIL_SENT", "A technical problem occurred. An administrator has been notified and the problem should be solved quickly.");
	
	define("ERROR_401", "Error 401");
	define("ERROR_401_MSG", "Error 401 : Authorization Required");
	define("ERROR_403", "Error 403");
	define("ERROR_403_MSG", "Error 403 : Access Denied");
	define("ERROR_404", "Error 404");
	define("ERROR_404_MSG", "Error 404 : Page not found");
	define("ERROR_500", "Error 500");
	define("ERROR_500_MSG", "Error 500 : Internal Server Error");
	
	define("MAIN_PAGE_GO_BACK", "Go back to the main page");
	
	define("BOX_LANGUAGE_TITLE", "Languages");
	define("CAPTCHA_CODE", "Enter Code Below");
	define("ERROR_CAPTCHA", "Code captcha error.");
	
	define("DECRYPT_ERROR", "Decrypt message error, please retry");
	define("SUBMIT_ERROR", "<table><tr><td><img src='{#BASE_URL#}wsp/img/warning.png' height='48' width='48' border='0' align='absmidlle'/></td><td><b>{#SIMPLE_QUOTE#} + ucfirst(transport.statusText) + {#SIMPLE_QUOTE#}</b></td></tr></table>{#SIMPLE_QUOTE#} + (transport.responseText!={#SIMPLE_QUOTE#}{#SIMPLE_QUOTE#}?{#SIMPLE_QUOTE#}<br/> {#SIMPLE_QUOTE#} + transport.responseText:{#SIMPLE_QUOTE#}{#SIMPLE_QUOTE#}) + {#SIMPLE_QUOTE#}");
	define("SUBMIT_UNKNOW_ERROR", "<table><tr><td><img src='{#BASE_URL#}wsp/img/warning.png' height='48' width='48' border='0' align='absmidlle'/></td><td><b>Unknow error</b></td></tr></table>");
	define("SUBMIT_LOADING", "Please wait during form validation ...");
	define("SUBMIT_LOADING_2", "Please wait ...");
	define("DOWNLOAD_FLASH_PLAYER", "<a href=\"http://www.macromedia.com/go/getflashplayer\" rel=\"nofollow\">Download Flash Player</a> to see it.");
	
	define("LIVE_VALIDATION_FORMULAR_ERROR", "Your formular is not correct, please check all the fields.");
	define("LIVE_VALIDATION_FORMULAR_FIELD_ERROR", "Your formular is not correct, please check the field {#SIMPLE_QUOTE#} + lv_error_alert_field_name + {#SIMPLE_QUOTE#}.");
	define("LIVE_VALIDATION_FORMULAR_ERROR_DEBUG", "Your formular is not correct, please check the field {#SIMPLE_QUOTE#} + lv_error_alert_id + {#SIMPLE_QUOTE#}.");
	define("LIVE_VALIDATION_FORMULAR_ERROR_MSG", "lv_error_alert_msg");
	define("INCLUDE_OBJECT_TO_MAIN_PAGE", "Please include %s object to the parent page (\$this->includeJsAndCssFromObjectToPage('%s')).");
	
	define('NOT_SUPPORTED_BROWSER_TITLE', 'Not supported browser');
	define('NOT_SUPPORTED_BROWSER', '<b>Internet Explorer 6 and older version are not fully supported.</b><br/>We recommand to use an other browser.<br/><br/>There must be 50 ways to leave your browser - here are 5:<br/><br/>');
	
	define("JAVASCRIPT_NOT_ACTIVATE", "JavaScript is turned off in your web browser. Turn it on to take full advantage of this site, then refresh the page.");
?>