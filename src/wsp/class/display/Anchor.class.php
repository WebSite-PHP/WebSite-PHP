<?php
/**
 * PHP file wsp\class\display\Anchor.class.php
 * @package display
 */
/**
 * Class Anchor
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 22/10/2010
 * @version     1.0.66
 * @access      public
 * @since       1.0.17
 */

class Anchor extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $name = "";
	/**#@-*/
	
	/**
	 * Constructor Anchor
	 * @param mixed $name 
	 */
	function __construct($name) {
		parent::__construct();
		
		if (!isset($name)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->name = $name;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Anchor
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$html = "<a name=\"".$this->name."\"></a>";
		$this->object_change = false;
		return $html;
	}
}
?>
