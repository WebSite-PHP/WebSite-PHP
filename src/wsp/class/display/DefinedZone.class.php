<?php
/**
 * PHP file wsp\class\display\DefinedZone.class.php
 * @package display
 */
/**
 * Class DefinedZone
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
 * @copyright   WebSite-PHP.com 26/05/2011
 * @version     1.0.89
 * @access      public
 * @since       1.0.17
 */

class DefinedZone extends WebSitePhpObject {
	protected $render = null;
	
	/**
	 * Constructor DefinedZone
	 */
	function __construct() {
		parent::__construct();
	}
	
	/**
	 * Destructor DefinedZone
	 */
	function __destruct() {}
	
	/**
	 * Method getPage
	 * @access public
	 * @return Page
	 * @since 1.0.89
	 */
	public function getPage() {
		return Page::getInstance($_GET['p']);
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return mixed
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		if ($this->render == null) {
			return translate(RENDER_OBJECT_NOT_SET);
		} else {
			return $this->render->render();
		}
	}
}
?>
