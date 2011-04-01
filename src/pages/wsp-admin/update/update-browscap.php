<?php
require_once(dirname(__FILE__)."/../../../lang/".$_SESSION['lang']."/wsp-admin/all.inc.php");

class UpdateBrowscap extends Page {
	protected $USER_RIGHTS = "administrator";
	protected $USER_NO_RIGHTS_REDIRECT = "wsp-admin/connect.html";
	
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		$this->updateFileFromUrl(dirname(__FILE__)."/../../../wsp/includes/browscap/lite_php_browscap.ini", 
									"http://browsers.garykeith.com/stream.asp?Lite_PHP_BrowsCapINI");
		
		$this->updateFileFromUrl(dirname(__FILE__)."/../../../wsp/includes/browscap/php_browscap.ini", 
									"http://browsers.garykeith.com/stream.asp?PHP_BrowsCapINI");
		
		unset($_SESSION['user_browscap_version']);
		
		$congratulation_pic = new Picture("img/wsp-admin/button_ok_64.png", 64, 64);
		$this->render = new Object($congratulation_pic, "<br/>", __(UPDATE_FRAMEWORK_COMPLETE_OK, "Browscap.ini"));
		$this->render->setAlign(Object::ALIGN_CENTER);
		
		// refresh the page
		$this->addObject(new JavaScript("setTimeout('location.href=location.href;', 1000);"));
	}
	
	private function updateFileFromUrl($file, $url) {
		$browscap_file = new File($file, false, true);
		
		// Simulate user browser
		$opts = array(
		  'http'=>array(
		    'method'=>"GET",
		    'header'=>"Accept-language: en\r\n" .
		              "Cookie: foo=bar\r\n",
			'user_agent'=>$_SERVER['HTTP_USER_AGENT']
		  )
		);
		$context = stream_context_create($opts);
		
		// get new file version
		$data = file_get_contents($url, FILE_USE_INCLUDE_PATH, $context);
		
		// write file
		if ($data != "") {
			$browscap_file->write($data);
		}
		$browscap_file->close();
	}
}
?>
