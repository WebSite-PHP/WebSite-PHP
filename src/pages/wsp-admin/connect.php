<?php
/**
 * PHP file pages\wsp-admin\connect.php
 */
/**
 * Page connect
 * URL: http://127.0.0.1/website-php/wsp-admin/connect.html
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2016 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 10/05/2016
 * @version     1.2.14
 * @access      public
 * @since       1.0.25
 */

define(GOOGLE_CODE_TRACKER_NOT_ACTIF, true);

class Connect extends Page {
	
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		require_once(dirname(__FILE__)."/includes/utils-unset-var.inc.php");
		if (!$this->isAjaxPage()) {
			unsetWspAdminVariables();
		}
		
		parent::$PAGE_TITLE = __(CONNECT_PAGE_TITLE);
		$this->setUserRights("");
		
		// Welcome message
		$this->render = new Table();
		$this->render->setWidth("100%");
		
		$connect_box = new RoundBox(RoundBox::STYLE_SECOND, "connect_box", 420, 150);
		$connect_box->setShadow(true);
		$connect_box->setValign(RoundBox::VALIGN_CENTER);
		
		$connect_table = new Table();
		$connect_table->setWidth("100%")->setDefaultAlign(RowTable::ALIGN_LEFT);
		$admin_pic = new Picture("img/wsp-admin/admin_128.png", 128, 128);
		
		$this->auth_obj = new Authentication($this, "connect");
		$this->auth_obj->setTableWidth(265);
		$connect_table->addRowColumns($admin_pic, $this->auth_obj);
		$connect_box->setContent($connect_table);
		
		$this->render->addRow("<br/><br/><br/><br/><br/>");
		
		$this->obj_br_before = new Object();
		$this->obj_br_before->setId("divBrBefore");
		$this->render->addRow($this->obj_br_before);
		
		$this->mod_obj = new Object();
		$this->mod_obj->setId("divConfigRecommandation")->setWidth(400);
		$this->render->addRow($this->mod_obj);
		$this->render->addRow("");
		
		$this->render->addRow($connect_box, RowTable::ALIGN_CENTER, RowTable::VALIGN_CENTER);
		$this->render->addRow("<br/>");
	}
	
	public function Loaded() {
		$this->mod_obj->emptyObject();
		
		$nb_mod_error = 0;
		$nb_mod = 3;
		if (strtolower(substr($_SERVER['SERVER_SOFTWARE'], 0, 6)) == "apache") {
			$mod_expires = false;
			$mod_headers = false;
			$mod_deflate = false;
			if (function_exists('apache_get_modules')) {
				$mod_expires = in_array("mod_expires", apache_get_modules());
				$mod_headers = in_array("mod_headers", apache_get_modules());
				$mod_deflate = in_array("mod_deflate", apache_get_modules());
			} else {
				ob_start();
				phpinfo(INFO_MODULES);
				$contents = ob_get_contents();
				ob_end_clean();
				$mod_rewrite = (strpos($contents, 'mod_expires') !== false);
				$mod_rewrite = (strpos($contents, 'mod_headers') !== false);
				$mod_rewrite = (strpos($contents, 'mod_deflate') !== false);
			}
			if(!$mod_expires) {
				$this->mod_obj->add("<li>We recomand to activate the apache mod_expires module.</li>");
				$nb_mod_error++;
			}
			if(!$mod_headers) {
				$this->mod_obj->add("<li>We recomand to activate the apache mod_headers module.</li>");
				$nb_mod_error++;
			}
			if(!$mod_deflate) {
				$this->mod_obj->add("<li>We recomand to activate the apache mod_deflate module.</li>");
				$nb_mod_error++;
			}
		}
		if (!extension_loaded('soap')) {
		    $this->mod_obj->add("<li>We recomand to install PHP lib SOAP.</li>");
			$nb_mod_error++;
		}
		if (!extension_loaded('gd') || !function_exists('imagecreatetruecolor')) {
		    $this->mod_obj->add("<li>We recomand to install PHP lib GD2.</li>");
			$nb_mod_error++;
		}
		/*if (!extension_loaded('curl')) {
		    $this->mod_obj->add("<li>We recomand to install PHP lib curl. (To use GoogleWeather)</li>");
			$nb_mod_error++;
		}*/
		/*$zlib_OC_is_set = preg_match('/On|(^[0-9]+$)/i', ini_get('zlib.output_compression'));
		if (!$zlib_OC_is_set) { 
			$this->mod_obj->add("<li>We recomand to configure php.ini with zlib.output_compression = On.</li>");
			$nb_mod_error++;
		}*/
		if ($nb_mod_error > 0) {
			$this->mod_obj->setClass("warning");
		} else {
			$this->mod_obj->setClass("");
		}
		$str_br_before = "";
		for ($i=$nb_mod_error; $i < $nb_mod; $i++) {
			$str_br_before .= "<br/>";
		}
		$this->obj_br_before->add($str_br_before);
	}
	
	public function connect() {
		if (!isset($_SESSION['user_try_connect_wsp_admin']) && $_SESSION['user_try_connect_wsp_admin'] != true) {
			if (defined('SEND_ADMIN_CONNECT_BY_MAIL') && SEND_ADMIN_CONNECT_BY_MAIL == true && !isLocalDebug()) {
					
					$connect_mail .= "<b>User tried or is connected on administration :</b><br/>";
					$connect_mail .= "URL : ".$this->getCurrentUrl()."<br/>";
					$connect_mail .= "Referer : ".$this->getRefererURL()."<br/>";
					$connect_mail .= "IP : <a href='http://www.infosniper.net/index.php?ip_address=".$this->getRemoteIP()."' target='_blank'>".$this->getRemoteIP()."</a><br/>";
					$connect_mail .= "Browser : ";
					if ($this->getBrowserName() == "Default Browser") {
						$connect_mail .= $this->getBrowserUserAgent();
					} else {
						$connect_mail .= $this->getBrowserName()." (version: ".$this->getBrowserVersion().")";
					}
					$connect_mail .= "<br/>";
					$connect_mail .= "Crawler : ".($this->isCrawlerBot()?"true":"false")."<br/><br/>";
					$connect_mail .= "If it's not you or another member of your organisation, we recommand to ban this IP.<br/>";
					
					try {
						$mail = new SmtpMail(SEND_ADMIN_CONNECT_BY_MAIL_TO, __(SEND_ADMIN_CONNECT_BY_MAIL_TO), "Admin connection on ".__(SITE_NAME)." !!!", __($connect_mail), SMTP_MAIL, __(SMTP_NAME));
						$mail->setPriority(SmtpMail::PRIORITY_HIGH);
						$mail->send();
					} catch (Exception $e) {}
					
					$_SESSION['user_try_connect_wsp_admin'] = true;
			}
		}
		$this->auth_obj->connect();
	}
}
?>
