<?php
/**
 * PHP file pages\wsp-admin\config\configure-banned-visitors.php
 */
/**
 * Content of the Page configure-banned-visitors
 * URL: http://127.0.0.1/website-php-install/wsp-admin/config/configure-banned-visitors.html
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.103
 */

require_once(dirname(__FILE__)."/../includes/admin-template-form.inc.php");

class ConfigureBannedVisitors extends Page {
	protected $USER_RIGHTS = array(Page::RIGHTS_ADMINISTRATOR, Page::RIGHTS_MODERATOR);
	protected $USER_NO_RIGHTS_REDIRECT = "wsp-admin/admin.html";
	
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		parent::$PAGE_TITLE = __(CONFIGURE_BANNED_VISITORS);
		
		if (!defined('MAX_BAD_URL_BEFORE_BANNED')) {
			define("MAX_BAD_URL_BEFORE_BANNED", 4);
		}
		$this->array_wsp_banned_users = WspBannedVisitors::getBannedVisitors();
		
		$this->table_ban = new Table();
		$this->table_ban->setId("table_ban")->activateAdvanceTable()->activatePagination()->activateSort(2, "desc")->setWidth(500);
		$this->table_ban->addRowColumns("IP", __(LAST_ACCESS), __(DURATION), __(AUTHORIZE))->setHeaderClass(0);
		$ban_vistors_obj = new Object("<br/><br/>", $this->table_ban, "<br/><br/>");
		
		$ban_ip_table = new Table();
		$form = new Form($this);
		$this->ip_edt = new TextBox($form);
		$validation = new LiveValidation();
		$validation->addValidatePresence();
		$this->ip_edt->setLiveValidation($validation);
		$this->duration_edt = new TextBox($form);
		$this->duration_edt->setValue(0);
		$validation = new LiveValidation();
		$validation->addValidatePresence()->addValidateNumericality(true);
		$this->duration_edt->setLiveValidation($validation);
		$ip_btn = new Button($form);
		$ip_btn->setValue(__(BAN_IP))->onClick("onBannedIP")->setAjaxEvent();
		$ban_ip_table->addRowColumns("IP : ", $this->ip_edt);
		$ban_ip_table->addRowColumns( __(DURATION)." : ", $this->duration_edt);
		$form->setContent(new Object($ban_ip_table, $ip_btn));
		
		$ban_vistors_obj->add($form, "<br/><br/>");
		
		$this->render = new AdminTemplateForm($this, $ban_vistors_obj);
	}
	
	public function Loaded() {
		$nb_banned_visitors = 0;
		foreach ($this->array_wsp_banned_users as $ip => $array_ip_info) {
			if ($array_ip_info['cnt'] >= MAX_BAD_URL_BEFORE_BANNED) {
				$btn_authorize = new Picture("img/wsp-admin/button_ok_16.png", 16, 16, 0, Picture::ALIGN_ABSMIDDLE, __(AUTHORIZE));
				$btn_authorize->onClick($this, "onAuthorizeVisitor", $ip)->setAjaxEvent();
				if (!$btn_authorize->isClicked()) {
					$link_ip = new Link("http://www.infosniper.net/index.php?ip_address=".$ip, Link::TARGET_BLANK, $ip);
					$row = $this->table_ban->addRowColumns($link_ip, $array_ip_info['dte'], $array_ip_info['len'], $btn_authorize);
					$row->setColumnAlign(3, RowTable::ALIGN_CENTER);
					$nb_banned_visitors++;
				}
			}
		}
		if ($nb_banned_visitors == 0) {
			$this->table_ban->addRowColumns("&nbsp;", __(NO_BANNED_VISITORS), "&nbsp;", "&nbsp;");
		}
	}
	
	public function onAuthorizeVisitor($sender, $ip) {
		if ($ip != "" && $this->array_wsp_banned_users[$ip] > 0) {
			WspBannedVisitors::resetBannedIP($ip);
			$this->table_ban->setAjaxRefreshAllTable();
		}
	}
	
	public function onBannedIP($sender) {
		if ($this->ip_edt->getValue() != "") {
			WspBannedVisitors::setIpBanned($this->ip_edt->getValue(), $this->duration_edt->getValue());
			$this->array_wsp_banned_users = WspBannedVisitors::getBannedVisitors();
			$this->table_ban->setAjaxRefreshAllTable();
		}
	}
}
?>
