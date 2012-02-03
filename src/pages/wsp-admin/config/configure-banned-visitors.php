<?php
/**
 * PHP file pages\wsp-admin\config\configure-banned-visitors.php
 */
/**
 * Content of the Page configure-banned-visitors
 * URL: http://127.0.0.1/website-php-install/wsp-admin/config/configure-banned-visitors.html
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2012 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 03/02/2012
 * @version     1.0.103
 * @access      public
 * @since       1.0.103
 */

/**
 * PHP file pages\wsp-admin\config\configure-users.php
 */
/**
 * Content of the Page configure-users
 * URL: http://127.0.0.1/website-php-install/wsp-admin/config/configure-users.html
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2012 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 06/06/2011
 * @version     1.0.102
 * @access      public
 * @since       1.0.85
 */

require_once(dirname(__FILE__)."/../includes/admin-template-form.inc.php");

class ConfigureBannedVisitors extends Page {
	protected $USER_RIGHTS = "administrator";
	protected $USER_NO_RIGHTS_REDIRECT = "wsp-admin/connect.html";
	
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		parent::$PAGE_TITLE = __(CONFIGURE_BANNED_VISITORS);
		
		$this->array_wsp_banned_users = SharedMemory::get("wsp_banned_users");
		if ($this->array_wsp_banned_users == null) {
			$this->array_wsp_banned_users = array();
		}
		$this->array_wsp_banned_users_last_access = SharedMemory::get("wsp_banned_users_last_access");
		if ($this->array_wsp_banned_users_last_access == null) {
			$this->array_wsp_banned_users_last_access = array();
		}
		
		$this->table_ban = new Table();
		$this->table_ban->setId("table_ban")->activateAdvanceTable()->activatePagination()->activateSort(1)->setWidth(500);
		$this->table_ban->addRowColumns("IP", __(LAST_ACCESS), __(AUTHORIZE))->setHeaderClass(0);
		$ban_vistors_obj = new Object("<br/><br/>", $this->table_ban, "<br/><br/>");
		
		$this->render = new AdminTemplateForm($this, $ban_vistors_obj);
	}
	
	public function Loaded() {
		$nb_banned_visitors = 0;
		foreach ($this->array_wsp_banned_users as $ip => $val) {
			if ($val >= MAX_BAD_URL_BEFORE_BANNED) {
				$btn_authorize = new Picture("img/wsp-admin/button_ok_16.png", 16, 16, 0, Picture::ALIGN_ABSMIDDLE, __(AUTHORIZE));
				$btn_authorize->onClick($this, "onAuthorizeVisitor", $ip)->setAjaxEvent()->disableAjaxWaitMessage();
				if (!$btn_authorize->isClicked()) {
					$link_ip = new Link("http://www.infosniper.net/index.php?ip_address=".$ip, Link::TARGET_BLANK, $ip);
					$row = $this->table_ban->addRowColumns($link_ip, $this->array_wsp_banned_users_last_access[$ip], $btn_authorize);
					$row->setColumnAlign(3, RowTable::ALIGN_CENTER);
					$nb_banned_visitors++;
				}
			}
		}
		if ($nb_banned_visitors == 0) {
			$this->table_ban->addRowColumns("&nbsp;", __(NO_BANNED_VISITORS), "&nbsp;");
		}
	}
	
	public function onAuthorizeVisitor($sender, $ip) {
		if ($ip != "" && $this->array_wsp_banned_users[$ip] > 0) {
			unset($this->array_wsp_banned_users[$ip]);
			unset($this->array_wsp_banned_users_last_access[$ip]);
			SharedMemory::add("wsp_banned_users", $this->array_wsp_banned_users);
			SharedMemory::add("wsp_banned_users_last_access", $this->array_wsp_banned_users_last_access);
			$this->table_ban->setAjaxRefreshAllTable();
		}
	}
}
?>
