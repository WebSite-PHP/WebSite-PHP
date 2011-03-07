<?php
/**
 * Description of PHP file wsp\class\display\Password.class.php
 * Class Password
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
 * @copyright   WebSite-PHP.com 22/10/2010
 *
 * @version     1.0.40
 * @access      public
 * @since       1.0.17
 */

include_once("TextBox.class.php");

class Password extends TextBox {
	/**
	 * Constructor Password
	 * @param mixed $page_or_form_object 
	 * @param string $name 
	 * @param string $id 
	 * @param string $value 
	 * @param string $width 
	 * @param double $length [default value: 0]
	 */
	function __construct($page_or_form_object, $name='', $id='', $value='', $width='', $length=0) {
		parent::__construct($page_or_form_object, $name, $id, $value, $width, $length);
		$this->type = "password";
	}
}
?>
