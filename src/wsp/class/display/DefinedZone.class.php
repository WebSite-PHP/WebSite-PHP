<?php
/**
 * PHP file wsp\class\display\DefinedZone.class.php
 * @package display
 */
/**
 * Class DefinedZone
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
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
	 * Method userHaveRights
	 * @access public
	 * @return boolean
	 * @since 1.2.1
	 */
	public function userHaveRights() {
		$user_rights = $this->USER_RIGHTS;
		if (isset($user_rights) && $user_rights != "") {
			if (isset($_SESSION['USER_RIGHTS']) && $_SESSION['USER_RIGHTS'] != "") {
				if (!is_array($user_rights)) {
					$user_rights = array($user_rights);
				}
				if (!is_array($_SESSION['USER_RIGHTS'])) {
					$_SESSION['USER_RIGHTS'] = array($_SESSION['USER_RIGHTS']);
				}
				for ($i=0; $i < sizeof($_SESSION['USER_RIGHTS']); $i++) {
					if (in_array($_SESSION['USER_RIGHTS'][$i], $user_rights)) {
						return true;
					}
				}
			}
			return false;
		}
		return true;
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
			if ($this->userHaveRights()) {
				return $this->render->render();
			} else {
				return new Object();
			}
		}
	}
}
?>
