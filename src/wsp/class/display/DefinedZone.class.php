<?php
/**
 * Class DefinedZone
 * 
 * Instance of a new DefinedZone.
 * @access public
 * @author Emilien MOREL <admin@website-php.com>
 * @link http://www.website-php.com
 * @copyright website-php.com 30/11/2009
 * @version 1.0
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
