<?php 
/**
 * PHP file wsp\class\modules\Notification\IOSNotifications.class.php
 * @package modules
 * @subpackage Notification
 */
/**
 * Class IOSNotifications
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package modules
 * @subpackage Notification
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.2.9
 */

class IOSNotifications extends JavaScript {
	private $title = "";
	private $message = "";
	private $delay = 3000;
	
	/**
	 * Constructor IOSNotifications
	 * @param mixed $title 
	 * @param mixed $message 
	 * @param double $delay [default value: 3000]
	 */
	function __construct($title, $message, $delay=3000) {
		$this->title = $title;
		$this->message = $message;
		$this->delay = $delay;
		
		$js = "";
		$js .= "ios.notify({
  title: '".addslashes($this->title)."',
  message: '".addslashes($this->message)."',
  delay: '".addslashes($this->delay)."'
});";
		
		parent::__construct($js);
		
		$this->addJavaScript(BASE_URL."wsp/js/ios.notify.js", "", true);
		$this->addCss(BASE_URL."wsp/css/ios-notify/ios.notify.css", "", true);
		$this->addCss(BASE_URL."wsp/css/ios-notify/ios.notify.webkit.css");
	}
}
?>
