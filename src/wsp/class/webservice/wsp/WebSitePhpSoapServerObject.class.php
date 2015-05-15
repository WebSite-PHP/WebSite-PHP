<?php
/**
 * PHP file wsp\class\webservice\wsp\WebSitePhpSoapServerObject.class.php
 * @package webservice
 * @subpackage wsp
 */
/**
 * Class WebSitePhpSoapServerObject
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package webservice
 * @subpackage wsp
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.17
 */

class WebSitePhpSoapServerObject {
	/**
	 * Constructor WebSitePhpSoapServerObject
	 */
	function __construct() {}
	
	/**
    * getSessionId
    *
    * @return string str, session id
    */
	/**
	 * Method getSessionId
	 * @access public
	 * @return mixed
	 * @since 1.0.55
	 */
	public function getSessionId() {
    	return session_id();
    }
}
?>
