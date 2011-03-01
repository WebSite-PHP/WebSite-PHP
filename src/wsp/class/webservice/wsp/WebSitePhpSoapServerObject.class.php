<?php
/**
 * Description of PHP file wsp\class\webservice\wsp\WebSitePhpSoapServerObject.class.php
 * Class WebSitePhpSoapServerObject
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 03/10/2010
 *
 * @version     1.0.30
 * @access      public
 * @since       1.0.17
 */

class WebSitePhpSoapServerObject {
	function __construct() {}
	
	/**
    * getSessionId
    *
    * @return string str, session id
    */
	public function getSessionId() {
    	return session_id();
    }
}
?>
