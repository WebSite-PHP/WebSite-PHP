<?php
/**
 * PHP file pages\wsp-admin\config\configure-site.php
 */
/**
 * Content of the Page configure-site
 * URL: http://127.0.0.1/website-php-install/wsp-admin/config/configure-site.html
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
 * @since       1.0.25
 */

require_once(dirname(__FILE__)."/../includes/admin-template-form.inc.php");

class ConfigureSite extends Page {
	protected $USER_RIGHTS = Page::RIGHTS_ADMINISTRATOR;
	protected $USER_NO_RIGHTS_REDIRECT = "wsp-admin/admin.html";
	
	private $edtName = null;
	private $edtDesc = null;
	private $edtKey = null;
	private $cmbRating = null;
	private $edtAuthor = null;
	private $cmbLanguage = null;
	private $cmbSiteType = null;
	private $edtSiteImage = null;
	private $edtSiteIphoneImage57 = null;
	private $edtSiteIphoneImage72 = null;
    private $edtSiteIphoneImage114 = null;
    private $edtSiteIphoneImage152 = null;
	private $edtGoogleTracker = null;
	private $edtGoogleMapKey = null;
	private $cmbMetaRobots = null;
	private $cmbMetaGooglebot = null;
	private $edtRevisitAfter = null;
	private $cmbCachingAllPage = null;
	private $edtCacheTime = null;
	private $cmbJqueryLocal = null;
	private $cmbJsCompression = null;
	private $cmbDebug = null;
	private $edtForceServerName = null;
	private $edtDefaultTimezone = null;
	//private $ = null;
	private $edt_exclude_files_change = false;
	private $nb_min_exclude_files = 2;
	private $edt_exclude_files = array();
	
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		parent::$PAGE_TITLE = __(CONFIGURE_SITE);
		
		// Admin
		$this->form = new Form($this);
		
		$table_form = new Table();
		$table_form->addRow();
		
		$this->edtName = new TextBox($this->form, "edtName");
		$this->edtName->setValue(__(SITE_NAME))->setWidth(300);
		$this->edtName->onChange("changeSiteName")->setAjaxEvent()->disableAjaxWaitMessage();
		$edtValidation = new LiveValidation();
		$table_form->addRowColumns(__(EDT_NAME).":&nbsp;", $this->edtName->setLiveValidation($edtValidation->addValidatePresence()->setFieldName(__(EDT_NAME))));
		
		$this->edtDesc = new Editor($this->form, "edtDesc");
		$this->edtDesc->setValue(__(SITE_DESC));
		$this->edtDesc->setToolbar(Editor::TOOLBAR_NONE)->setWidth(290)->setHeight(100);
		$edtValidation = new LiveValidation();
		$table_form->addRowColumns(__(EDT_DESC).":&nbsp;", $this->edtDesc->setLiveValidation($edtValidation->addValidatePresence()->setFieldName(__(EDT_DESC))));
		
		$this->edtKey = new TextBox($this->form, "edtKey");
		$this->edtKey->setValue(__(SITE_KEYS))->setWidth(300);
		$edtValidation = new LiveValidation();
		$table_form->addRowColumns(__(EDT_KEY).":&nbsp;", $this->edtKey->setLiveValidation($edtValidation->addValidatePresence()->setFieldName(__(EDT_KEY))));
		
		$table_form->addRow();
		
		$this->cmbRating = new ComboBox($this->form, "cmbRating");
		$this->cmbRating->addItem("general", "general", (SITE_RATING=="general")?true:false)->addItem("mature", "mature", (SITE_RATING=="mature")?true:false)->addItem("restricted", "restricted", (SITE_RATING=="restricted")?true:false)->addItem("14years", "14years", (SITE_RATING=="14years")?true:false)->setWidth(143);
		$table_form->addRowColumns(__(CMB_RATING).":&nbsp;", $this->cmbRating);
		
		$this->edtAuthor = new TextBox($this->form, "edtAuthor");
		$this->edtAuthor->setValue(__(SITE_AUTHOR));
		$edtValidation = new LiveValidation();
		$table_form->addRowColumns(__(EDT_AUTHOR).":&nbsp;", $this->edtAuthor->setLiveValidation($edtValidation->addValidatePresence()->setFieldName(__(EDT_AUTHOR))));
		
		$this->cmbLanguage = new ComboBox($this->form, "cmbLanguage");
		$this->cmbLanguage->addItem("en", __(ENGLISH), (SITE_DEFAULT_LANG=="en")?true:false, "wsp/img/lang/en.png")->addItem("fr", __(FRENCH), (SITE_DEFAULT_LANG=="fr")?true:false, "wsp/img/lang/fr.png");
		//->addItem("de", __(GERMAN), (SITE_DEFAULT_LANG=="de")?true:false, "wsp/img/lang/de.png")->addItem("es", __(SPANISH), (SITE_DEFAULT_LANG=="es")?true:false, "wsp/img/lang/es.png")
		$this->cmbLanguage->setWidth(143);
		$table_form->addRowColumns(__(CMB_LANGUAGE).":&nbsp;", $this->cmbLanguage);
		
		$table_form->addRow();
		
		$this->cmbSiteType = new ComboBox($this->form, "cmbSiteType");
		$this->cmbSiteType->addItem("", "&nbsp;", (SITE_META_OPENGRAPH_TYPE=="")?true:false);
		$this->cmbSiteType->addItem("activity", "activity", (SITE_META_OPENGRAPH_TYPE=="activity")?true:false);
		$this->cmbSiteType->addItem("sport", "sport", (SITE_META_OPENGRAPH_TYPE=="sport")?true:false);
		$this->cmbSiteType->addItem("bar", "bar", (SITE_META_OPENGRAPH_TYPE=="bar")?true:false);
		$this->cmbSiteType->addItem("company", "company", (SITE_META_OPENGRAPH_TYPE=="company")?true:false);
		$this->cmbSiteType->addItem("cafe", "cafe", (SITE_META_OPENGRAPH_TYPE=="cafe")?true:false);
		$this->cmbSiteType->addItem("hotel", "hotel", (SITE_META_OPENGRAPH_TYPE=="hotel")?true:false);
		$this->cmbSiteType->addItem("restaurant", "restaurant", (SITE_META_OPENGRAPH_TYPE=="restaurant")?true:false);
		$this->cmbSiteType->addItem("cause", "cause", (SITE_META_OPENGRAPH_TYPE=="cause")?true:false);
		$this->cmbSiteType->addItem("sports_league", "sports league", (SITE_META_OPENGRAPH_TYPE=="sports_league")?true:false);
		$this->cmbSiteType->addItem("sports_team", "sports team", (SITE_META_OPENGRAPH_TYPE=="sports_team")?true:false);
		$this->cmbSiteType->addItem("band", "band", (SITE_META_OPENGRAPH_TYPE=="band")?true:false);
		$this->cmbSiteType->addItem("government", "government", (SITE_META_OPENGRAPH_TYPE=="government")?true:false);
		$this->cmbSiteType->addItem("non_profit", "non profit", (SITE_META_OPENGRAPH_TYPE=="non_profit")?true:false);
		$this->cmbSiteType->addItem("school", "school", (SITE_META_OPENGRAPH_TYPE=="school")?true:false);
		$this->cmbSiteType->addItem("university", "university", (SITE_META_OPENGRAPH_TYPE=="university")?true:false);
		$this->cmbSiteType->addItem("actor", "actor", (SITE_META_OPENGRAPH_TYPE=="actor")?true:false);
		$this->cmbSiteType->addItem("athlete", "athlete", (SITE_META_OPENGRAPH_TYPE=="athlete")?true:false);
		$this->cmbSiteType->addItem("author", "author", (SITE_META_OPENGRAPH_TYPE=="author")?true:false);
		$this->cmbSiteType->addItem("director", "director", (SITE_META_OPENGRAPH_TYPE=="director")?true:false);
		$this->cmbSiteType->addItem("musician", "musician", (SITE_META_OPENGRAPH_TYPE=="musician")?true:false);
		$this->cmbSiteType->addItem("politician", "politician", (SITE_META_OPENGRAPH_TYPE=="politician")?true:false);
		$this->cmbSiteType->addItem("profile", "profile", (SITE_META_OPENGRAPH_TYPE=="profile")?true:false);
		$this->cmbSiteType->addItem("public_figure", "public figure", (SITE_META_OPENGRAPH_TYPE=="public_figure")?true:false);
		$this->cmbSiteType->addItem("city", "city", (SITE_META_OPENGRAPH_TYPE=="city")?true:false);
		$this->cmbSiteType->addItem("country", "country", (SITE_META_OPENGRAPH_TYPE=="country")?true:false);
		$this->cmbSiteType->addItem("landmark", "landmark", (SITE_META_OPENGRAPH_TYPE=="landmark")?true:false);
		$this->cmbSiteType->addItem("state_province", "state province", (SITE_META_OPENGRAPH_TYPE=="state_province")?true:false);
		$this->cmbSiteType->addItem("album", "album", (SITE_META_OPENGRAPH_TYPE=="album")?true:false);
		$this->cmbSiteType->addItem("book", "book", (SITE_META_OPENGRAPH_TYPE=="book")?true:false);
		$this->cmbSiteType->addItem("drink", "drink", (SITE_META_OPENGRAPH_TYPE=="drink")?true:false);
		$this->cmbSiteType->addItem("food", "food", (SITE_META_OPENGRAPH_TYPE=="food")?true:false);
		$this->cmbSiteType->addItem("game", "game", (SITE_META_OPENGRAPH_TYPE=="game")?true:false);
		$this->cmbSiteType->addItem("movie", "movie", (SITE_META_OPENGRAPH_TYPE=="movie")?true:false);
		$this->cmbSiteType->addItem("product", "product", (SITE_META_OPENGRAPH_TYPE=="product")?true:false);
		$this->cmbSiteType->addItem("song", "song", (SITE_META_OPENGRAPH_TYPE=="song")?true:false);
		$this->cmbSiteType->addItem("tv_show", "tv show", (SITE_META_OPENGRAPH_TYPE=="tv_show")?true:false);
		$this->cmbSiteType->addItem("article", "article", (SITE_META_OPENGRAPH_TYPE=="article")?true:false);
		$this->cmbSiteType->addItem("blog", "blog", (SITE_META_OPENGRAPH_TYPE=="blog")?true:false);
		$this->cmbSiteType->addItem("website", "website", (SITE_META_OPENGRAPH_TYPE=="website")?true:false);
		$this->cmbSiteType->setWidth(143);
		$table_form->addRowColumns(__(CMB_SITE_TYPE).":&nbsp;", $this->cmbSiteType);
		
		$this->edtSiteImage = new TextBox($this->form, "edtSiteImage");
		$this->edtSiteImage->setValue(SITE_META_OPENGRAPH_IMAGE)->setWidth(300);
		$table_form->addRowColumns(__(EDT_SITE_IMAGE).":&nbsp;", $this->edtSiteImage);
		
		$table_form->addRow();
		
		$this->edtSiteIphoneImage57 = new TextBox($this->form, "edtSiteIphoneImage57");
		$this->edtSiteIphoneImage57->setValue(SITE_META_IPHONE_IMAGE_57PX)->setWidth(300);
		$table_form->addRowColumns(__(EDT_SITE_IPHONE_IMAGE_57PX).":&nbsp;", $this->edtSiteIphoneImage57);
		
		$this->edtSiteIphoneImage72 = new TextBox($this->form, "edtSiteIphoneImage72");
		$this->edtSiteIphoneImage72->setValue(SITE_META_IPHONE_IMAGE_72PX)->setWidth(300);
		$table_form->addRowColumns(__(EDT_SITE_IPHONE_IMAGE_72PX).":&nbsp;", $this->edtSiteIphoneImage72);

        $this->edtSiteIphoneImage114 = new TextBox($this->form, "edtSiteIphoneImage114");
        $this->edtSiteIphoneImage114->setValue(SITE_META_IPHONE_IMAGE_114PX)->setWidth(300);
        $table_form->addRowColumns(__(EDT_SITE_IPHONE_IMAGE_114PX).":&nbsp;", $this->edtSiteIphoneImage114);

        if (!defined("SITE_META_IPHONE_IMAGE_152PX")) {
            define("SITE_META_IPHONE_IMAGE_152PX", "");
        }
        $this->edtSiteIphoneImage152 = new TextBox($this->form, "edtSiteIphoneImage152");
        $this->edtSiteIphoneImage152->setValue(SITE_META_IPHONE_IMAGE_152PX)->setWidth(300);
        $table_form->addRowColumns(__(EDT_SITE_IPHONE_IMAGE_152PX).":&nbsp;", $this->edtSiteIphoneImage152);
		
		$table_form->addRow();
		
		$this->edtGoogleTracker = new TextBox($this->form, "edtGoogleTracker");
		$this->edtGoogleTracker->setValue(GOOGLE_CODE_TRACKER);
		$table_form->addRowColumns(__(EDT_GOOGLE_CODE_TRACKER).":&nbsp;", $this->edtGoogleTracker);
		
		/*$this->edtGoogleMapKey = new TextBox($this->form, "edtGoogleMapKey");
		$this->edtGoogleMapKey->setValue(GOOGLE_MAP_KEY);
		$table_form->addRowColumns(__(EDT_GOOGLE_MAP_KEY).":&nbsp;", $this->edtGoogleMapKey);*/
		
		$table_form->addRow();
		
		$this->cmbMetaRobots = new ComboBox($this->form, "cmbMetaRobots");
		$this->cmbMetaRobots->addItem("index, follow", "index, follow", (SITE_META_ROBOTS=="index, follow")?true:false);
		$this->cmbMetaRobots->addItem("noindex, follow", "noindex, follow", (SITE_META_ROBOTS=="noindex, follow")?true:false);
		$this->cmbMetaRobots->addItem("index, nofollow", "index, nofollow", (SITE_META_ROBOTS=="index, nofollow")?true:false);
		$this->cmbMetaRobots->addItem("noindex, nofollow", "noindex, nofollow", (SITE_META_ROBOTS=="noindex, nofollow")?true:false);
		$this->cmbMetaRobots->setWidth(143);
		$table_form->addRowColumns(__(CMB_META_ROBOTS).":&nbsp;", $this->cmbMetaRobots);
		
		$this->cmbMetaGooglebot = new ComboBox($this->form, "cmbMetaGooglebot");
		$this->cmbMetaGooglebot->addItem("", "&nbsp;", (SITE_META_GOOGLEBOTS=="")?true:false);
		$this->cmbMetaGooglebot->addItem("archive", "archive", (SITE_META_ROBOTS=="archive")?true:false);
		$this->cmbMetaGooglebot->addItem("noarchive", "noarchive", (SITE_META_ROBOTS=="noarchive")?true:false);
		$this->cmbMetaGooglebot->setWidth(143);
		$table_form->addRowColumns(__(CMB_META_GOOGLEBOTS).":&nbsp;", $this->cmbMetaGooglebot);
		
		$this->edtRevisitAfter = new TextBox($this->form, "edtRevisitAfter");
		$this->edtRevisitAfter->setValue(SITE_META_REVISIT_AFTER)->setWidth(80);
		$edtValidation = new LiveValidation();
		$table_form->addRowColumns(__(EDT_REVISIT_AFTER).":&nbsp;", new Object($this->edtRevisitAfter->setLiveValidation($edtValidation->addValidatePresence()->addValidateNumericality(true)->setFieldName(__(EDT_REVISIT_AFTER))), "&nbsp;".__(DAYS)));
		
		$table_form->addRow();
		
		$this->btnValidateF1 = new Button($this->form, "btnValidateF1");
		$this->btnValidateF1->setValue(__(BTN_VALIDATE))->onClick("configureSite")->setAjaxEvent();
		$table_form->addRowColumns($this->btnValidateF1)->setColumnColspan(1, 3)->setColumnAlign(1, RowTable::ALIGN_CENTER);
		
		$this->form->setContent($table_form);
		
		// advance tab
		$this->form2 = new Form($this);
		
		$table_form2 = new Table();
		$table_form2->addRow();
		
		$this->cmbJQueryVersion = new ComboBox($this->form2, "cmbJQueryVersion");
		$this->cmbJQueryVersion->setWidth(143);
		$table_form2->addRowColumns(__(CMB_JQUERY_VERSION).":&nbsp;", $this->cmbJQueryVersion);
		
		$this->cmbJQueryUIVersion = new ComboBox($this->form2, "cmbJQueryUIVersion");
		$this->cmbJQueryUIVersion->setWidth(143);
		$table_form2->addRowColumns(__(CMB_JQUERY_UI_VERSION).":&nbsp;", $this->cmbJQueryUIVersion);
		
		$jquery_dir = SITE_DIRECTORY."/wsp/js/jquery/";
		$files = scandir($jquery_dir, 0);
		for($i=0; $i < sizeof($files); $i++) {
			$file = $files[$i];
			if (is_file($jquery_dir.$file)) {
				$version = str_replace("jquery-", "", str_replace(".min.js", "", $file));
				if (is_numeric(str_replace(".", "", $version))) {
					$this->cmbJQueryVersion->addItem($version, $version, (JQUERY_VERSION==$version)?true:false);
				} else if (substr($version, 0, 3) == "ui-" && substr($version, strlen($version)-7, strlen($version)) == ".custom") {
					$version = str_replace("ui-", "", str_replace(".custom", "", $version));
					$this->cmbJQueryUIVersion->addItem($version, $version, (JQUERY_UI_VERSION==$version)?true:false);
				}
			}
		}
		
		$this->cmbJqueryLocal = new ComboBox($this->form2, "cmbJqueryLocal");
		$this->cmbJqueryLocal->addItem("true", "true", (JQUERY_LOAD_LOCAL==true)?true:false);
		$this->cmbJqueryLocal->addItem("false", "false", (JQUERY_LOAD_LOCAL==false)?true:false);
		$this->cmbJqueryLocal->setWidth(143);
		$table_form2->addRowColumns(__(CMB_JQUERY_LOAD_LOCAL).":&nbsp;", $this->cmbJqueryLocal);
		
		$table_form2->addRow();
		
		$this->edtDefaultTimezone = new TextBox($this->form2, "edtDefaultTimezone");
		$this->edtDefaultTimezone->setValue(DEFAULT_TIMEZONE);
		$edtValidation = new LiveValidation();
		$table_form2->addRowColumns(__(EDT_DEFAULT_TIMEZONE).":&nbsp;", $this->edtDefaultTimezone->setLiveValidation($edtValidation->addValidatePresence()->setFieldName(__(EDT_DEFAULT_TIMEZONE))));
		
		$table_form2->addRow();

		$this->edtMaxSessionTime = new TextBox($this->form2, "edtMaxSessionTime");
		$this->edtMaxSessionTime->setValue(MAX_SESSION_TIME)->setWidth(80);
		$edtValidation = new LiveValidation();
		$table_form2->addRowColumns(__(EDT_MAX_SESSION_TIME).":&nbsp;", new Object($this->edtMaxSessionTime->setLiveValidation($edtValidation->addValidatePresence()->addValidateNumericality(true)->setFieldName(__(EDT_MAX_SESSION_TIME))), "&nbsp;".__(SECONDS)));
		
		$table_form2->addRow();
		
		$this->cmbCachingAllPage = new ComboBox($this->form2, "cmbCachingAllPage");
		$this->cmbCachingAllPage->addItem("true", "true", (CACHING_ALL_PAGES==true)?true:false);
		$this->cmbCachingAllPage->addItem("false", "false", (CACHING_ALL_PAGES==false)?true:false);
		$this->cmbCachingAllPage->onChange("changeCachingAllPage")->setAjaxEvent()->disableAjaxWaitMessage();
		$this->cmbCachingAllPage->setWidth(143);
		$table_form2->addRowColumns(__(CMB_CACHING_ALL_PAGES).":&nbsp;", $this->cmbCachingAllPage);
		
		$this->edtCacheTime = new TextBox($this->form2, "edtCacheTime");
		$this->edtCacheTime->setValue(CACHE_TIME)->setWidth(80);
		if (CACHING_ALL_PAGES == false) {
			$this->edtCacheTime->disable();
			$this->edtCacheTime->setValue("");
		}
		$edtValidation = new LiveValidation();
		$table_form2->addRowColumns(__(EDT_CACHE_TIME).":&nbsp;", new Object($this->edtCacheTime->setLiveValidation($edtValidation->addValidatePresence()->addValidateNumericality(true)->setFieldName(__(EDT_CACHE_TIME))), "&nbsp;".__(SECONDS)));

		/*if (!defined("LITE_PHP_BROWSCAP")) {
			define("LITE_PHP_BROWSCAP", true);
		}
		$this->cmbBrowscap = new ComboBox($this->form2, "cmbBrowscap");
		$this->cmbBrowscap->addItem("true", "true", (LITE_PHP_BROWSCAP==true)?true:false);
		$this->cmbBrowscap->addItem("false", "false", (LITE_PHP_BROWSCAP==false)?true:false);
		$this->cmbBrowscap->setWidth(143);
		$table_form2->addRowColumns(__(CMB_LITE_PHP_BROWSCAP).":&nbsp;", $this->cmbBrowscap);
		$table_form2->addRowColumns("&nbsp;", __(LITE_PHP_BROWSCAP_EXPLANATION));*/

		/*$this->cmbJsCompression = new ComboBox($this->form);
		$this->cmbJsCompression->addItem("NONE", "NONE", (JS_COMPRESSION_TYPE=="NONE")?true:false);
		$this->cmbJsCompression->addItem("GOOGLE_WS", "GOOGLE_WS", (JS_COMPRESSION_TYPE=="GOOGLE_WS")?true:false);
		$this->cmbJsCompression->addItem("LOCAL", "LOCAL", (JS_COMPRESSION_TYPE=="LOCAL")?true:false);
		$this->cmbJsCompression->setWidth(143);
		$table_form->addRowColumns(__(CMB_JS_COMPRESSION_TYPE).":&nbsp;", $this->cmbJsCompression);*/
		
		$table_form2->addRow();
		
		$this->cmbDebug = new ComboBox($this->form2, "cmbDebug");
		$this->cmbDebug->addItem("true", "true", (DEBUG==true)?true:false);
		$this->cmbDebug->addItem("false", "false", (DEBUG==false)?true:false);
		$this->cmbDebug->setWidth(143);
		$table_form2->addRowColumns(__(CMB_DEBUG).":&nbsp;", $this->cmbDebug);
		
		$table_form2->addRow();
		
		if (!defined("SEND_ERROR_BY_MAIL")) {
			define(SEND_ERROR_BY_MAIL, false);
		}
		$this->cmbSendErrorByMail = new ComboBox($this->form2, "cmbSendErrorByMail");
		$this->cmbSendErrorByMail->addItem("true", "true", (SEND_ERROR_BY_MAIL==true)?true:false);
		$this->cmbSendErrorByMail->addItem("false", "false", (SEND_ERROR_BY_MAIL==false)?true:false);
		$this->cmbSendErrorByMail->setWidth(143);
		$this->cmbSendErrorByMail->onChange("changeSendErrorByMail")->setAjaxEvent()->disableAjaxWaitMessage();
		$table_form2->addRowColumns(__(CMB_SEND_ERROR_BY_MAIL).":&nbsp;", $this->cmbSendErrorByMail);
		
		$this->edtSendErrorByMailTo = new TextBox($this->form2, "edtSendErrorByMailTo");
		$this->edtSendErrorByMailTo->setWidth(143)->setValue((defined("SEND_ERROR_BY_MAIL_TO")?SEND_ERROR_BY_MAIL_TO:""));
		if (SEND_ERROR_BY_MAIL == false) {
			$this->edtSendErrorByMailTo->disable();
		}
		$edtValidation = new LiveValidation();
		$this->edtSendErrorByMailTo->setLiveValidation($edtValidation->addValidateEmail()->setFieldName(__(EDT_SEND_ERROR_BY_MAIL_TO)));
		$table_form2->addRowColumns(__(EDT_SEND_ERROR_BY_MAIL_TO).":&nbsp;", new Object($this->edtSendErrorByMailTo, "&nbsp;", __(SEND_ERROR_BY_MAIL_CMT)));
		
		if (!defined("SEND_JS_ERROR_BY_MAIL")) {
			define(SEND_JS_ERROR_BY_MAIL, false);
		}
		$this->cmbSendJsErrorByMail = new ComboBox($this->form2, "cmbSendJsErrorByMail");
		$this->cmbSendJsErrorByMail->addItem("true", "true", (SEND_JS_ERROR_BY_MAIL==true)?true:false);
		$this->cmbSendJsErrorByMail->addItem("false", "false", (SEND_JS_ERROR_BY_MAIL==false)?true:false);
		$this->cmbSendJsErrorByMail->setWidth(143);
		$table_form2->addRowColumns(__(CMB_SEND_JS_ERROR_BY_MAIL).":&nbsp;", $this->cmbSendJsErrorByMail);
		
		
		if (defined("SEND_BY_MAIL_FILE_EX")) {
			$this->array_files_ex = explode(',', SEND_BY_MAIL_FILE_EX);
		} else {
			$this->array_files_ex = array();
		}
		
		$this->hidden_nb_exclude_files = new Hidden($this->form2, "hidden_nb_exclude_files");
		if ($this->hidden_nb_exclude_files->getValue() == "") {
			if (sizeof($this->array_files_ex) > 0) {
				$this->hidden_nb_exclude_files->setValue(sizeof($this->array_files_ex) + 1);
			} else {
				$this->hidden_nb_exclude_files->setValue($this->nb_min_exclude_files);
			}
		}
		
		$table_form2->addRowColumns("", $this->hidden_nb_exclude_files);
		
		$this->exclude_files_table = new Table();
		$this->exclude_files_table->setId("exclude_files_table_id");
		
		$this->nb_empty_exclude_files = 0;
		$this->edt_exclude_files = array();
		for ($i=1; $i <= $this->hidden_nb_exclude_files->getValue(); $i++) {
			$edt_exclude_files = $this->createExcludedFile();
			if (trim($edt_exclude_files->getValue()) == "") {
				if ($this->edt_exclude_files_focus == null) {
					$this->edt_exclude_files_focus = $edt_exclude_files;
				}
				$this->nb_empty_exclude_files++;
			}
		}
		$table_form2->addRowColumns(__(EDT_SEND_BY_MAIL_FILE_EX).":&nbsp;<br/><i><font size=1>".__(EDT_SEND_BY_MAIL_FILE_EX_CMT)."</font></i>", $this->exclude_files_table)->setValign(RowTable::VALIGN_TOP);
		$this->changeSendErrorByMail();
		
		$table_form2->addRow();
		
		$this->edtMaxBadUrlBeforeBan = new TextBox($this->form2, "edtMaxBadUrlBeforeBan");
		$this->edtMaxBadUrlBeforeBan->setWidth(143)->setValue(MAX_BAD_URL_BEFORE_BANNED);
		$edtValidation = new LiveValidation();
		$this->edtMaxBadUrlBeforeBan->setLiveValidation($edtValidation->addValidatePresence()->addValidateNumericality()->setFieldName(__(EDT_MAX_BAD_URL_BEFORE_BANNED)));
		$table_form2->addRowColumns(__(EDT_MAX_BAD_URL_BEFORE_BANNED).":&nbsp;",$this->edtMaxBadUrlBeforeBan);
		
		$table_form2->addRow();
		
		if (!defined("SEND_ADMIN_CONNECT_BY_MAIL")) {
			define(SEND_ADMIN_CONNECT_BY_MAIL, false);
		}
		$this->cmbSendAdminConnectByMail = new ComboBox($this->form2, "cmbSendAdminConnectByMail");
		$this->cmbSendAdminConnectByMail->addItem("true", "true", (SEND_ADMIN_CONNECT_BY_MAIL==true)?true:false);
		$this->cmbSendAdminConnectByMail->addItem("false", "false", (SEND_ADMIN_CONNECT_BY_MAIL==false)?true:false);
		$this->cmbSendAdminConnectByMail->setWidth(143);
		$this->cmbSendAdminConnectByMail->onChange("changeSendAdminConnectByMail")->setAjaxEvent()->disableAjaxWaitMessage();
		$table_form2->addRowColumns(__(CMB_SEND_ADMIN_CONNECT_BY_MAIL).":&nbsp;", $this->cmbSendAdminConnectByMail);
		
		$this->edtSendAdminConnectByMailTo = new TextBox($this->form2, "edtSendAdminConnectByMailTo");
		$this->edtSendAdminConnectByMailTo->setWidth(143)->setValue((defined("SEND_ADMIN_CONNECT_BY_MAIL_TO")?SEND_ADMIN_CONNECT_BY_MAIL_TO:""));
		if (SEND_ADMIN_CONNECT_BY_MAIL == false) {
			$this->edtSendAdminConnectByMailTo->disable();
		}
		$edtValidation = new LiveValidation();
		$this->edtSendAdminConnectByMailTo->setLiveValidation($edtValidation->addValidateEmail()->setFieldName(__(EDT_SEND_ADMIN_CONNECT_BY_MAIL_TO)));
		$table_form2->addRowColumns(__(EDT_SEND_ADMIN_CONNECT_BY_MAIL_TO).":&nbsp;", new Object($this->edtSendAdminConnectByMailTo, "&nbsp;", __(SEND_ADMIN_CONNECT_BY_MAIL_CMT)));
		
		$table_form2->addRow();
		
		$this->edtCdnServer = new TextBox($this->form2, "edtCdnServer");
		if (!defined("CDN_SERVER") || CDN_SERVER == "") {
			$this->edtCdnServer->setValue("http://");
		} else {
			$this->edtCdnServer->setValue(CDN_SERVER);
		}
		$table_form2->addRowColumns(__(EDT_CDN_SERVER).":&nbsp;",$this->edtCdnServer->setWidth(300));
		$table_form2->addRowColumns("&nbsp;", __(CDN_SERVER_CMT));
		
		$this->edtForceServerName = new TextBox($this->form2, "edtForceServerName");
		if (FORCE_SERVER_NAME == "") {
			$this->edtForceServerName->setValue("http://");
		} else {
			$this->edtForceServerName->setValue(FORCE_SERVER_NAME);
		}
		$table_form2->addRowColumns(__(EDT_FORCE_SERVER_NAME).":&nbsp;",$this->edtForceServerName->setWidth(300));
		$table_form2->addRowColumns("&nbsp;", __(PROBLEM_WITH_REDIRECT));
		
		$table_form2->addRow();
		
		$this->btnValidateF2 = new Button($this->form2, "btnValidateF2");
		$this->btnValidateF2->setValue(__(BTN_VALIDATE))->onClick("configureSite")->setAjaxEvent();
		$table_form2->addRowColumns($this->btnValidateF2)->setColumnColspan(1, 3)->setColumnAlign(1, RowTable::ALIGN_CENTER);
		
		$table_form2->addRow();
		$this->form2->setContent($table_form2);
		
		$tabs = new Tabs("tabs_id");
		$tabs->addTab(__(TAB_SITE), $this->form);
		$tabs->addTab(__(TAB_ADVANCE), $this->form2);
		
		$this->render = new AdminTemplateForm($this, $tabs);
	}
	
	public function Loaded() {
		if ($this->btnValidateF2->isClicked() || $this->edt_exclude_files_change) {
			$nb_exclude_files = sizeof($this->edt_exclude_files);
			if ($this->nb_empty_exclude_files < 1) {
				$this->edt_exclude_files_focus = $this->createExcludedFile();
				$nb_exclude_files++;
			} else if ($this->hidden_nb_exclude_files->getValue() > $this->nb_min_exclude_files && $this->nb_empty_exclude_files > 1) {
				for ($i=$this->hidden_nb_exclude_files->getValue()-1; $i >= $this->nb_min_exclude_files; $i--) {
					if ($this->edt_exclude_files[$i]->getValue() == "") {
						$this->exclude_files_table->deleteRow($i);
						$this->nb_empty_exclude_files--;
						$nb_exclude_files--;
					}
					if ($this->nb_empty_exclude_files <= 1) {
						break;
					}
				}
			}
			$this->edt_exclude_files_focus->setFocus();
			$this->hidden_nb_exclude_files->setValue($nb_exclude_files);
		}
	}
	
	private function createExcludedFile() {
		$i = sizeof($this->edt_exclude_files);
		$this->edt_exclude_files[$i] = new TextBox($this->form2, "edt_exclude_files".$i);
		$this->edt_exclude_files[$i]->setWidth(300);
		$this->edt_exclude_files[$i]->onChange("onChangeExcludedFile")->setAjaxEvent()->disableAjaxWaitMessage();
		if (!$this->isAjaxPage() && isset($this->array_files_ex[$i])) {
			$this->edt_exclude_files[$i]->setValue($this->array_files_ex[$i]);
		}
		if ($i == 0) {
			$this->exclude_files_table->addRow($this->edt_exclude_files[$i])->setId($i);
		} else{
			$this->exclude_files_table->addRow($this->edt_exclude_files[$i])->setId($i);
		}
		
		return $this->edt_exclude_files[$i];
	}
	
	public function onChangeExcludedFile($sender) {
		$this->edt_exclude_files_change = true;
	}
	
	public function configureSite() {
		$data_config_file = "<?php\n";
		$site_name = ($this->btnValidateF1->isClicked()?utf8_decode($this->edtName->getValue()):$this->edtName->getValue());
		$data_config_file .= "define(\"SITE_NAME\", \"".str_replace("\"", "\\\"", $site_name)."\");\n";
		$data_config_file .= "define(\"SITE_DESC\", \"".str_replace("\"", "\\\"", html_entity_decode($this->edtDesc->getValue(), ENT_QUOTES))."\");\n";
		$data_config_file .= "define(\"SITE_KEYS\", \"".str_replace("\"", "\\\"", ($this->btnValidateF1->isClicked()?utf8_decode($this->edtKey->getValue()):$this->edtKey->getValue()))."\");\n";
		$data_config_file .= "define(\"SITE_RATING\", \"".$this->cmbRating->getValue()."\"); // general, mature, restricted, 14years\n";
		$data_config_file .= "define(\"SITE_AUTHOR\", \"".str_replace("\"", "\\\"", $this->edtAuthor->getValue())."\");\n";
		$data_config_file .= "define(\"SITE_DEFAULT_LANG\", \"".$this->cmbLanguage->getValue()."\"); // en, fr, ...\n";
		$data_config_file .= "\n";
		$data_config_file .= "define(\"SITE_META_OPENGRAPH_TYPE\", \"".$this->cmbSiteType->getValue()."\");\n";
		$data_config_file .= "define(\"SITE_META_OPENGRAPH_IMAGE\", \"".$this->edtSiteImage->getValue()."\");\n";
		$data_config_file .= "define(\"SITE_META_IPHONE_IMAGE_57PX\", \"".$this->edtSiteIphoneImage57->getValue()."\");\n";
		$data_config_file .= "define(\"SITE_META_IPHONE_IMAGE_72PX\", \"".$this->edtSiteIphoneImage72->getValue()."\");\n";
        $data_config_file .= "define(\"SITE_META_IPHONE_IMAGE_114PX\", \"".$this->edtSiteIphoneImage114->getValue()."\");\n";
        $data_config_file .= "define(\"SITE_META_IPHONE_IMAGE_152PX\", \"".$this->edtSiteIphoneImage152->getValue()."\");\n";
		$data_config_file .= "\n";
		$data_config_file .= "define(\"GOOGLE_CODE_TRACKER\", \"".$this->edtGoogleTracker->getValue()."\");\n";
		//$data_config_file .= "define(\"GOOGLE_MAP_KEY\", \"".$this->edtGoogleMapKey->getValue()."\");\n";
		$data_config_file .= "define(\"GOOGLE_MAP_KEY\", \"".GOOGLE_MAP_KEY."\"); // Deprecated (We recommand to use MapLeafLet)\n";
		$data_config_file .= "\n";
		$data_config_file .= "define(\"SITE_META_ROBOTS\", \"".$this->cmbMetaRobots->getValue()."\");\n";
		$data_config_file .= "define(\"SITE_META_GOOGLEBOTS\", \"".$this->cmbMetaGooglebot->getValue()."\");\n";
		$data_config_file .= "define(\"SITE_META_REVISIT_AFTER\", ".$this->edtRevisitAfter->getValue().");\n";
		$data_config_file .= "\n";
		$data_config_file .= "define(\"CACHING_ALL_PAGES\", ".$this->cmbCachingAllPage->getValue()."); // If use user rights, warning, you may have rights problems\n";
		$data_config_file .= "define(\"CACHE_TIME\", ";
		if ($this->cmbCachingAllPage->getValue() == "false") {
			$data_config_file .= "0";
		} else {
			$data_config_file .= $this->edtCacheTime->getValue();
		}
		$data_config_file .= "); // 12 heures = 60*60*12\n";
		//$data_config_file .= "define(\"LITE_PHP_BROWSCAP\", ".$this->cmbBrowscap->getValue()."); // is lite or normal version of Browscap used\n";
		$data_config_file .= "\n";
		$data_config_file .= "define(\"JQUERY_LOAD_LOCAL\", ".$this->cmbJqueryLocal->getValue()."); // if false load jquery from google else load from local\n";
		$data_config_file .= "define(\"JQUERY_VERSION\", \"".$this->cmbJQueryVersion->getValue()."\");\n";
		$data_config_file .= "define(\"JQUERY_UI_VERSION\", \"".$this->cmbJQueryUIVersion->getValue()."\");\n";
		//$data_config_file .= "define(\"JS_COMPRESSION_TYPE\", \"".$this->cmbJsCompression->getValue()."\"); // type of Javascript compression (GOOGLE_WS, LOCAL, NONE)\n";
		$data_config_file .= "define(\"JS_COMPRESSION_TYPE\", \"NONE\"); // Javascript compression (GOOGLE_WS, LOCAL, NONE (recommand))\n";
		$data_config_file .= "\n";
		$data_config_file .= "define(\"DEBUG\", ".$this->cmbDebug->getValue()."); // autorize use of method addLogDebug\n";
		$data_config_file .= "\n";
		
		$data_config_file .= "define(\"SEND_ERROR_BY_MAIL\", ".$this->cmbSendErrorByMail->getValue()."); // send error by mail if not local URL (http://127.0.0.1/)\n";
		$data_config_file .= "define(\"SEND_ERROR_BY_MAIL_TO\", \"".$this->edtSendErrorByMailTo->getValue()."\"); // send error to this email\n";
		$data_config_file .= "define(\"SEND_JS_ERROR_BY_MAIL\", ".$this->cmbSendJsErrorByMail->getValue()."); // send JS error by mail if not local URL (http://127.0.0.1/)\n";
		if ($this->btnValidateF2->isClicked()) {
			$list_files = "";
			for ($i=0; $i < $this->hidden_nb_exclude_files->getValue(); $i++) {
				if ($this->edt_exclude_files[$i]->getValue() != "") {
					if ($list_files != "") { $list_files .= ","; }
					$list_files .= str_replace("'", "", str_replace("\"", "", str_replace(",", "", $this->edt_exclude_files[$i]->getValue())));
				}
			}
			$data_config_file .= "define(\"SEND_BY_MAIL_FILE_EX\", \"".trim($list_files)."\"); // list of files exluded by send error by mail\n";
		} else if (defined("SEND_BY_MAIL_FILE_EX")) {
			$data_config_file .= "define(\"SEND_BY_MAIL_FILE_EX\", \"".SEND_BY_MAIL_FILE_EX."\"); // list of files exluded by send error by mail\n";
		} else {
			$data_config_file .= "define(\"SEND_BY_MAIL_FILE_EX\", \"\"); // list of files exluded by send error by mail\n";
		}
		$data_config_file .= "\n";
		
		$data_config_file .= "define(\"MAX_BAD_URL_BEFORE_BANNED\", ".$this->edtMaxBadUrlBeforeBan->getValue()."); // Nb max URL before banned visitor\n";
		$data_config_file .= "\n";
		
		$data_config_file .= "define(\"SEND_ADMIN_CONNECT_BY_MAIL\", ".$this->cmbSendAdminConnectByMail->getValue()."); // send wsp-admin connection notice, if not local URL (http://127.0.0.1/)\n";
		$data_config_file .= "define(\"SEND_ADMIN_CONNECT_BY_MAIL_TO\", \"".$this->edtSendAdminConnectByMailTo->getValue()."\"); // send wsp-admin connection notice to this email\n";
		$data_config_file .= "\n";
		
		$data_config_file .= "define(\"CDN_SERVER\", \"";
		if ($this->edtCdnServer->getValue() != "http://") {
			$data_config_file .= $this->edtCdnServer->getValue();
		}
		$data_config_file .= "\"); // CDN server URL (used to increase picture, JS and CSS loading time)\n";
		
		$data_config_file .= "define(\"FORCE_SERVER_NAME\", \"";
		if ($this->edtForceServerName->getValue() != "http://") {
			$data_config_file .= $this->edtForceServerName->getValue();
		}
		$data_config_file .= "\"); // Force site base url (problem with redirect), whithout http:// (ex: www.website-php.com)\n";
		$data_config_file .= "\n";
		$data_config_file .= "define(\"DEFAULT_TIMEZONE\", \"".$this->edtDefaultTimezone->getValue()."\");\n";
		$data_config_file .= "define(\"MAX_SESSION_TIME\", ".$this->edtMaxSessionTime->getValue()."); // 30min. = 1800\n";
		$data_config_file .= "?>";
		
		$config_file = new File(dirname(__FILE__)."/../../../wsp/config/config.inc.php", false, true);
		if ($config_file->write($data_config_file)){
			$config_ok = true;
		}
		$config_file->close();
		
		if ($config_ok) {
			$result_dialogbox = new DialogBox(__(CONFIG_FILE), __(CONFIG_FILE_OK));
		} else {
			$result_dialogbox = new DialogBox(__(CONFIG_FILE), __(CONFIG_FILE_NOT_OK));
		}
		$result_dialogbox->activateCloseButton();
		$this->addObject($result_dialogbox);
		
		if (formalize_to_variable($site_name) != formalize_to_variable(SITE_NAME) && $this->userHaveRights()) {
			$this->redirect($this->getBaseLanguageURL()."wsp-admin/disconnect.html?referer=".urlencode(str_replace("ajax/", "", $this->getCurrentURL())));
		}
	}
	
	public function changeCachingAllPage() {
		if ($this->cmbCachingAllPage->getValue() == "true") {
			$this->edtCacheTime->enable();
			if ($this->edtCacheTime->getValue() == "") {
				$this->edtCacheTime->setValue(43200);
			}
		} else {
			$this->edtCacheTime->disable()->forceEmpty();
		}
	}
	
	public function changeSendErrorByMail($sender) {
		if ($this->cmbSendErrorByMail->getValue() == "true") {
			if (SMTP_MAIL == "") {
				$this->addObject(new DialogBox(__(ERROR), __(PLEASE_CONFIGURE_SMTP)));
				$this->edtSendErrorByMailTo->disable();
				$this->cmbSendJsErrorByMail->disable();
				$this->cmbSendJsErrorByMail->setValue("false");
				for ($i=0; $i < $this->hidden_nb_exclude_files->getValue(); $i++) {
					$this->edt_exclude_files[$i]->disable();
				}
			} else {
				$this->edtSendErrorByMailTo->enable();
				$this->cmbSendJsErrorByMail->enable();
				if ($this->edtSendErrorByMailTo->getValue() == "") {
					$this->edtSendErrorByMailTo->setValue("@");
				}
				for ($i=0; $i < $this->hidden_nb_exclude_files->getValue(); $i++) {
					$this->edt_exclude_files[$i]->enable();
				}
			}
		} else {
			$this->edtSendErrorByMailTo->disable()->forceEmpty();
			$this->cmbSendJsErrorByMail->disable();
			$this->cmbSendJsErrorByMail->setValue("false");
			for ($i=0; $i < $this->hidden_nb_exclude_files->getValue(); $i++) {
				$this->edt_exclude_files[$i]->disable();
			}
		}
	}
	
	public function changeSendAdminConnectByMail($sender) {
		if ($this->cmbSendAdminConnectByMail->getValue() == "true") {
			if (SMTP_MAIL == "") {
				$this->addObject(new DialogBox(__(ERROR), __(PLEASE_CONFIGURE_SMTP)));
				$this->edtSendAdminConnectByMailTo->disable();
			} else {
				$this->edtSendAdminConnectByMailTo->enable();
				if ($this->edtSendAdminConnectByMailTo->getValue() == "") {
					$this->edtSendAdminConnectByMailTo->setValue("@");
				}
			}
		} else {
			$this->edtSendAdminConnectByMailTo->disable()->forceEmpty();
		}
	}
	
	public function changeSiteName($sender) {
		$dialog = new DialogBox(__(WARNING), __(WARNING_SITE_NAME_DISONNCET));
		$this->addObject($dialog->activateCloseButton());
	}
}
?>
