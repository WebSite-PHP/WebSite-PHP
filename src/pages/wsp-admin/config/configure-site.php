<?php
/**
 * PHP file pages\wsp-admin\config\configure-site.php
 */
/**
 * Content of the Page configure-site
 * URL: http://127.0.0.1/website-php-install/wsp-admin/config/configure-site.html
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
 * @copyright   WebSite-PHP.com 26/05/2011
 * @version     1.0.98
 * @access      public
 * @since       1.0.25
 */

require_once(dirname(__FILE__)."/../includes/admin-template-form.inc.php");

class ConfigureSite extends Page {
	protected $USER_RIGHTS = "administrator";
	protected $USER_NO_RIGHTS_REDIRECT = "wsp-admin/connect.html";
	
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
	
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		parent::$PAGE_TITLE = __(CONFIGURE_SITE);
		
		// Admin
		$form = new Form($this);
		
		$table_form = new Table();
		$table_form->setClass(Table::STYLE_SECOND);
		$table_form->addRow();
		
		$this->edtName = new TextBox($form);
		$this->edtName->setValue(SITE_NAME)->setWidth(300);
		$edtValidation = new LiveValidation();
		$table_form->addRowColumns(__(EDT_NAME).":&nbsp;", $this->edtName->setLiveValidation($edtValidation->addValidatePresence()->setFieldName(__(EDT_NAME))));
		
		$this->edtDesc = new Editor($form);
		$this->edtDesc->setValue(SITE_DESC);
		$this->edtDesc->setToolbar(Editor::TOOLBAR_NONE)->setWidth(290)->setHeight(100);
		$edtValidation = new LiveValidation();
		$table_form->addRowColumns(__(EDT_DESC).":&nbsp;", $this->edtDesc->setLiveValidation($edtValidation->addValidatePresence()->setFieldName(__(EDT_DESC))));
		
		$this->edtKey = new TextBox($form);
		$this->edtKey->setValue(SITE_KEYS)->setWidth(300);
		$edtValidation = new LiveValidation();
		$table_form->addRowColumns(__(EDT_KEY).":&nbsp;", $this->edtKey->setLiveValidation($edtValidation->addValidatePresence()->setFieldName(__(EDT_KEY))));
		
		$table_form->addRow();
		
		$this->cmbRating = new ComboBox($form);
		$this->cmbRating->addItem("general", "general", (SITE_RATING=="general")?true:false)->addItem("mature", "mature", (SITE_RATING=="mature")?true:false)->addItem("restricted", "restricted", (SITE_RATING=="restricted")?true:false)->addItem("14years", "14years", (SITE_RATING=="14years")?true:false)->setWidth(143);
		$table_form->addRowColumns(__(CMB_RATING).":&nbsp;", $this->cmbRating);
		
		$this->edtAuthor = new TextBox($form);
		$this->edtAuthor->setValue(SITE_AUTHOR);
		$edtValidation = new LiveValidation();
		$table_form->addRowColumns(__(EDT_AUTHOR).":&nbsp;", $this->edtAuthor->setLiveValidation($edtValidation->addValidatePresence()->setFieldName(__(EDT_AUTHOR))));
		
		$this->cmbLanguage = new ComboBox($form);
		$this->cmbLanguage->addItem("en", __(ENGLISH), (SITE_DEFAULT_LANG=="en")?true:false, "wsp/img/lang/en.png")->addItem("fr", __(FRENCH), (SITE_DEFAULT_LANG=="fr")?true:false, "wsp/img/lang/fr.png")->addItem("de", __(GERMAN), (SITE_DEFAULT_LANG=="de")?true:false, "wsp/img/lang/de.png")->addItem("es", __(SPANISH), (SITE_DEFAULT_LANG=="es")?true:false, "wsp/img/lang/es.png")->setWidth(143);
		$table_form->addRowColumns(__(CMB_LANGUAGE).":&nbsp;", $this->cmbLanguage);
		
		$table_form->addRow();
		
		$this->cmbSiteType = new ComboBox($form);
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
		
		$this->edtSiteImage = new TextBox($form);
		$this->edtSiteImage->setValue(SITE_META_OPENGRAPH_IMAGE)->setWidth(300);
		$table_form->addRowColumns(__(EDT_SITE_IMAGE).":&nbsp;", $this->edtSiteImage);
		
		$table_form->addRow();
		
		$this->edtSiteIphoneImage57 = new TextBox($form);
		$this->edtSiteIphoneImage57->setValue(SITE_META_IPHONE_IMAGE_57PX)->setWidth(300);
		$table_form->addRowColumns(__(EDT_SITE_IPHONE_IMAGE_57PX).":&nbsp;", $this->edtSiteIphoneImage57);
		
		$this->edtSiteIphoneImage72 = new TextBox($form);
		$this->edtSiteIphoneImage72->setValue(SITE_META_IPHONE_IMAGE_72PX)->setWidth(300);
		$table_form->addRowColumns(__(EDT_SITE_IPHONE_IMAGE_72PX).":&nbsp;", $this->edtSiteIphoneImage72);
		
		$this->edtSiteIphoneImage114 = new TextBox($form);
		$this->edtSiteIphoneImage114->setValue(SITE_META_IPHONE_IMAGE_114PX)->setWidth(300);
		$table_form->addRowColumns(__(EDT_SITE_IPHONE_IMAGE_114PX).":&nbsp;", $this->edtSiteIphoneImage114);
		
		$table_form->addRow();
		
		$this->edtGoogleTracker = new TextBox($form);
		$this->edtGoogleTracker->setValue(GOOGLE_CODE_TRACKER);
		$table_form->addRowColumns(__(EDT_GOOGLE_CODE_TRACKER).":&nbsp;", $this->edtGoogleTracker);
		
		$this->edtGoogleMapKey = new TextBox($form);
		$this->edtGoogleMapKey->setValue(GOOGLE_MAP_KEY);
		$table_form->addRowColumns(__(EDT_GOOGLE_MAP_KEY).":&nbsp;", $this->edtGoogleMapKey);
		
		$table_form->addRow();
		
		$this->cmbMetaRobots = new ComboBox($form);
		$this->cmbMetaRobots->addItem("index, follow", "index, follow", (SITE_META_ROBOTS=="index, follow")?true:false);
		$this->cmbMetaRobots->addItem("noindex, follow", "noindex, follow", (SITE_META_ROBOTS=="noindex, follow")?true:false);
		$this->cmbMetaRobots->addItem("index, nofollow", "index, nofollow", (SITE_META_ROBOTS=="index, nofollow")?true:false);
		$this->cmbMetaRobots->addItem("noindex, nofollow", "noindex, nofollow", (SITE_META_ROBOTS=="noindex, nofollow")?true:false);
		$this->cmbMetaRobots->setWidth(143);
		$table_form->addRowColumns(__(CMB_META_ROBOTS).":&nbsp;", $this->cmbMetaRobots);
		
		$this->cmbMetaGooglebot = new ComboBox($form);
		$this->cmbMetaGooglebot->addItem("", "&nbsp;", (SITE_META_GOOGLEBOTS=="")?true:false);
		$this->cmbMetaGooglebot->addItem("archive", "archive", (SITE_META_ROBOTS=="archive")?true:false);
		$this->cmbMetaGooglebot->addItem("noarchive", "noarchive", (SITE_META_ROBOTS=="noarchive")?true:false);
		$this->cmbMetaGooglebot->setWidth(143);
		$table_form->addRowColumns(__(CMB_META_GOOGLEBOTS).":&nbsp;", $this->cmbMetaGooglebot);
		
		$this->edtRevisitAfter = new TextBox($form);
		$this->edtRevisitAfter->setValue(SITE_META_REVISIT_AFTER)->setWidth(80);
		$edtValidation = new LiveValidation();
		$table_form->addRowColumns(__(EDT_REVISIT_AFTER).":&nbsp;", new Object($this->edtRevisitAfter->setLiveValidation($edtValidation->addValidatePresence()->addValidateNumericality(true)->setFieldName(__(EDT_REVISIT_AFTER))), "&nbsp;".__(DAYS)));
		
		$table_form->addRow();
		
		$this->cmbCachingAllPage = new ComboBox($form);
		$this->cmbCachingAllPage->addItem("true", "true", (CACHING_ALL_PAGES==true)?true:false);
		$this->cmbCachingAllPage->addItem("false", "false", (CACHING_ALL_PAGES==false)?true:false);
		$this->cmbCachingAllPage->onChange("changeCachingAllPage")->setAjaxEvent()->disableAjaxWaitMessage();
		$this->cmbCachingAllPage->setWidth(143);
		$table_form->addRowColumns(__(CMB_CACHING_ALL_PAGES).":&nbsp;", $this->cmbCachingAllPage);
		
		$this->edtCacheTime = new TextBox($form);
		$this->edtCacheTime->setValue(CACHE_TIME)->setWidth(80);
		if (CACHING_ALL_PAGES == false) {
			$this->edtCacheTime->disable();
			$this->edtCacheTime->setValue("");
		}
		$edtValidation = new LiveValidation();
		$table_form->addRowColumns(__(EDT_CACHE_TIME).":&nbsp;", new Object($this->edtCacheTime->setLiveValidation($edtValidation->addValidatePresence()->addValidateNumericality(true)->setFieldName(__(EDT_CACHE_TIME))), "&nbsp;".__(SECONDS)));
		
		$table_form->addRow();
		
		$this->cmbJqueryLocal = new ComboBox($form);
		$this->cmbJqueryLocal->addItem("true", "true", (JQUERY_LOAD_LOCAL==true)?true:false);
		$this->cmbJqueryLocal->addItem("false", "false", (JQUERY_LOAD_LOCAL==false)?true:false);
		$this->cmbJqueryLocal->setWidth(143);
		$table_form->addRowColumns(__(CMB_JQUERY_LOAD_LOCAL).":&nbsp;", $this->cmbJqueryLocal);
		
		/*$this->cmbJsCompression = new ComboBox($form);
		$this->cmbJsCompression->addItem("NONE", "NONE", (JS_COMPRESSION_TYPE=="NONE")?true:false);
		$this->cmbJsCompression->addItem("GOOGLE_WS", "GOOGLE_WS", (JS_COMPRESSION_TYPE=="GOOGLE_WS")?true:false);
		$this->cmbJsCompression->addItem("LOCAL", "LOCAL", (JS_COMPRESSION_TYPE=="LOCAL")?true:false);
		$this->cmbJsCompression->setWidth(143);
		$table_form->addRowColumns(__(CMB_JS_COMPRESSION_TYPE).":&nbsp;", $this->cmbJsCompression);*/
		
		$table_form->addRow();
		
		$this->cmbDebug = new ComboBox($form);
		$this->cmbDebug->addItem("true", "true", (DEBUG==true)?true:false);
		$this->cmbDebug->addItem("false", "false", (DEBUG==false)?true:false);
		$this->cmbDebug->setWidth(143);
		$table_form->addRowColumns(__(CMB_DEBUG).":&nbsp;", $this->cmbDebug);
		
		$table_form->addRow();
		
		$this->edtForceServerName = new TextBox($form);
		if (FORCE_SERVER_NAME == "") {
			$this->edtForceServerName->setValue("http://");
		} else {
			$this->edtForceServerName->setValue(FORCE_SERVER_NAME);
		}
		$table_form->addRowColumns(__(EDT_FORCE_SERVER_NAME).":&nbsp;",$this->edtForceServerName);
		$table_form->addRowColumns("&nbsp;", __(PROBLEM_WITH_REDIRECT));
		
		$table_form->addRow();

		$this->edtDefaultTimezone = new TextBox($form);
		$this->edtDefaultTimezone->setValue(DEFAULT_TIMEZONE);
		$edtValidation = new LiveValidation();
		$table_form->addRowColumns(__(EDT_DEFAULT_TIMEZONE).":&nbsp;", $this->edtDefaultTimezone->setLiveValidation($edtValidation->addValidatePresence()->setFieldName(__(EDT_DEFAULT_TIMEZONE))));
		
		$table_form->addRow();
		
		$btnValidate = new Button($form);
		$btnValidate->setValue(__(BTN_VALIDATE))->onClick("configureSite")->setAjaxEvent();
		$table_form->addRowColumns($btnValidate)->setColumnColspan(1, 3)->setColumnAlign(1, RowTable::ALIGN_CENTER);
		
		$table_form->addRow();
		
		$form->setContent($table_form);
		$this->render = new AdminTemplateForm($this, $form);
	}
	
	public function configureSite() {
		$data_config_file = "<?php\n";
		$data_config_file .= "define(\"SITE_NAME\", \"".str_replace("\"", "\\\"", utf8_decode($this->edtName->getValue()))."\");\n";
		$data_config_file .= "define(\"SITE_DESC\", \"".str_replace("\"", "\\\"", html_entity_decode(utf8_decode($this->edtDesc->getValue())))."\");\n";
		$data_config_file .= "define(\"SITE_KEYS\", \"".str_replace("\"", "\\\"", utf8_decode($this->edtKey->getValue()))."\");\n";
		$data_config_file .= "define(\"SITE_RATING\", \"".$this->cmbRating->getValue()."\"); // general, mature, restricted, 14years\n";
		$data_config_file .= "define(\"SITE_AUTHOR\", \"".str_replace("\"", "\\\"", $this->edtAuthor->getValue())."\");\n";
		$data_config_file .= "define(\"SITE_DEFAULT_LANG\", \"".$this->cmbLanguage->getValue()."\"); // en, fr, ...\n";
		$data_config_file .= "\n";
		$data_config_file .= "define(\"SITE_META_OPENGRAPH_TYPE\", \"".$this->cmbSiteType->getValue()."\");\n";
		$data_config_file .= "define(\"SITE_META_OPENGRAPH_IMAGE\", \"".$this->edtSiteImage->getValue()."\");\n";
		$data_config_file .= "define(\"SITE_META_IPHONE_IMAGE_57PX\", \"".$this->edtSiteIphoneImage57->getValue()."\");\n";
		$data_config_file .= "define(\"SITE_META_IPHONE_IMAGE_72PX\", \"".$this->edtSiteIphoneImage72->getValue()."\");\n";
		$data_config_file .= "define(\"SITE_META_IPHONE_IMAGE_114PX\", \"".$this->edtSiteIphoneImage114->getValue()."\");\n";
		$data_config_file .= "\n";
		$data_config_file .= "define(\"GOOGLE_CODE_TRACKER\", \"".$this->edtGoogleTracker->getValue()."\");\n";
		$data_config_file .= "define(\"GOOGLE_MAP_KEY\", \"".$this->edtGoogleMapKey->getValue()."\");\n";
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
		$data_config_file .= "\n";
		$data_config_file .= "define(\"JQUERY_LOAD_LOCAL\", ".$this->cmbJqueryLocal->getValue()."); // if false load jquery from google else load from local\n";
		$data_config_file .= "define(\"JQUERY_VERSION\", \"1.6.2\");\n";
		$data_config_file .= "define(\"JQUERY_UI_VERSION\", \"1.8.14\");\n";
		//$data_config_file .= "define(\"JS_COMPRESSION_TYPE\", \"".$this->cmbJsCompression->getValue()."\"); // type of Javascript compression (GOOGLE_WS, LOCAL, NONE)\n";
		$data_config_file .= "define(\"JS_COMPRESSION_TYPE\", \"NONE\"); // Javascript compression (GOOGLE_WS, LOCAL, NONE (recommand))\n";
		$data_config_file .= "\n";
		$data_config_file .= "define(\"DEBUG\", ".$this->cmbDebug->getValue()."); // autorize use of method addLogDebug\n";
		$data_config_file .= "define(\"FORCE_SERVER_NAME\", \"";
		if ($this->edtForceServerName->getValue() != "http://") {
			$data_config_file .= $this->edtForceServerName->getValue();
		}
		$data_config_file .= "\"); // Force site base url (problem with redirect), whithout http:// (ex: www.website-php.com)\n";
		$data_config_file .= "\n";
		$data_config_file .= "define(\"DEFAULT_TIMEZONE\", \"".$this->edtDefaultTimezone->getValue()."\");\n";
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
	}
	
	public function changeCachingAllPage() {
		if ($this->cmbCachingAllPage->getValue() == "true") {
			$this->edtCacheTime->enable();
			if ($this->edtCacheTime->getValue() == "") {
				$this->edtCacheTime->setValue(43200);
			}
		} else {
			$this->edtCacheTime->setValue("");
			$this->edtCacheTime->disable();
		}
	}
}
?>
