<?php
include_once(dirname(__FILE__)."/wsp/includes/utils.inc.php");

$_GET['error-redirect'] = "";
if (isset($_GET['error'])) {
	$_GET['error-redirect'] = $_GET['error'];
}

$http_type = "";
if ($_SERVER['SERVER_PORT'] == 443) {
	$current_url = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$http_type = "https://";
} else {
	$port = "";
	if ($_SERVER['SERVER_PORT'] != 80 &&  $_SERVER['SERVER_PORT'] != "") {
		$port = ":".$_SERVER['SERVER_PORT'];
	}
	$current_url = $_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
	$http_type = "http://";
}

if (isset($_GET['url'])) {
	$_GET['error-redirect-url'] = $_GET['url'];
} else {
	$_GET['error-redirect-url'] = $http_type.$current_url;
}

error_reporting(E_ALL);
include_once("wsp/config/config.inc.php");

// define language
if (!isset($_SESSION['lang']) && !isset($_GET['l'])) {
	$_GET['l'] = SITE_DEFAULT_LANG;
}
$temp_lang = substr($_SERVER['REQUEST_URI'], 0, 4);
if (strlen($temp_lang)==4 && $temp_lang[0] == "/" && $temp_lang[3] == "/" && 
	is_dir(dirname(__FILE__)."/lang/".$temp_lang)) {
		// set the url language
		$_GET['l'] = str_replace("/", "", $temp_lang);
}

include_once("wsp/includes/utils_session.inc.php");
include_once("wsp/includes/utils_url.inc.php");
$__AJAX_PAGE__ = false; // use for return catch exception and loadAllVariables method
$__AJAX_LOAD_PAGE__ = false;
$__PAGE_IS_INIT__ = false;
$__LOAD_VARIABLES__ = false;
$__DEBUG_PAGE_IS_PRINTING__ = false;
$__GEOLOC_ASK_USER_SHARE_POSITION__ = false;

@session_set_cookie_params(0, "/", $_SERVER['SERVER_NAME'], false, true);
@session_name(formalize_to_variable(SITE_NAME));
@session_start();

$_GET['p'] = "error/error-page";
include_once("wsp/includes/init.inc.php");

$page_object = Page::getInstance($_GET['p']);
if (method_exists($page_object, "InitializeComponent")) {
	$page_object->InitializeComponent();
}
if (method_exists($page_object, "Load")) {
	$page_object->Load();
}

$page_object->loadAllVariables();
$__PAGE_IS_INIT__ = true;
$page_object->executeCallback();

if (method_exists($page_object, "Loaded")) {
	$page_object->Loaded();
}

echo "<html><head><title>".$page_object->getPageTitle()."</title>\n";
$jquery_style = "";
if (DEFINE_STYLE_JQUERY != "") {
	$jquery_style = DEFINE_STYLE_JQUERY;
}
echo "<link type=\"text/css\" rel=\"StyleSheet\" href=\"".BASE_URL."combine-css/styles.php.css,angle.php.css,jquery".JQUERY_UI_VERSION."|".$jquery_style."|jquery-ui-".JQUERY_UI_VERSION.".custom.css\" media=\"screen\" />\n";
echo "<script type=\"text/javascript\" src=\"".BASE_URL."combine-js/jquery|jquery-".JQUERY_VERSION.".min.js,jquery|jquery-ui-".JQUERY_UI_VERSION.".custom.min.js,jquery.cookie.js,pngfix.js,utils.js\"></script>\n";
echo "<script type=\"text/javascript\" src=\"".BASE_URL."wsp/js/jquery.backstretch.min.js\"></script>\n";
echo "<meta name=\"Robots\" content=\"noindex, nofollow\" />\n";
echo "<base href=\"".BASE_URL."\" />\n";
echo "</head><body>\n";
echo $page_object->render();
echo "</body></html>\n";

exit;
?>
