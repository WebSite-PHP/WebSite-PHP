<?php
/**
 * Description of PHP file wsp\class\display\DefinedZone.class.php
 * Class DefinedZone
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
 * @version     1.0.30
 * @access      public
 * @since       1.0.17
 */

class DefinedZone extends WebSitePhpObject {
	protected $render = null;
	
	/**
	 * Constructor Page
	 */
	function __construct() {
		parent::__construct();
	}
	
	/**
	 * Destructor Page
	 */
	function __destruct() {}
	
	public function render($ajax_render=false) {
		if ($this->render == null) {
			return translate(RENDER_OBJECT_NOT_SET);
		} else {
			return $this->render->render();
		}
	}
}
?>
