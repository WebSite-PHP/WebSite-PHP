<?php
/**
 * PHP file pages\wsp-admin\theme\configure-css.php
 */
/**
 * Content of the Page configure-css
 * URL: http://127.0.0.1/website-php-install/wsp-admin/theme/configure-css.html
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
 * @copyright   WebSite-PHP.com 03/10/2010
 * @version     1.0.66
 * @access      public
 * @since       1.0.25
 */

require_once(dirname(__FILE__)."/../includes/admin-template-form.inc.php");

class ConfigureCss extends Page {
	protected $USER_RIGHTS = "administrator";
	
	private $background_body = null;
	private $color_body = null;
	private $link_color = null;
	private $link_hover_color = null;
	
	private $background_picture_1 = null;
	private $background_1_header = null;
	private $color_1_header = null;
	private $style1_header_link = null;
	private $style1_header_link_hover = null;
	private $background_1 = null;
	private $color_1 = null;
	private $style1_color_link = null;
	private $style1_color_link_hover = null;
	private $border_table_1 = null;
	private $color_shadow = null;
	
	private $style_font = null;
	private $style_font_serif = null;
	private $style_font_size = null;
	
	private $example_obj = null;
	
	private $array_font = array('body', 'form', 'blockquote', 'p', 'h1', 'h2,h3,h4,h5,h6', 'a,.link', 'a:hover', '.table_1', '.table_1_bckg', '.bckg_1', '.header_1_bckg', '.header_1_bckg a', '.header_1_bckg a:hover', '.table_2', '.table_2_bckg', '.bckg_2', '.header_2_bckg', '.header_2_bckg a', '.header_2_bckg a:hover', 'td');
	private $array_round_box_1 = array('.AngleRond1', '.AngleRond1Ombre');
	
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		parent::$PAGE_TITLE = __(CONFIGURE_CSS);
		
		JavaScriptInclude::getInstance()->add(BASE_URL."wsp/js/wsp-admin.js");
		
		//Admin
		$table = new Table();
		$table->setDefaultValign(RowTable::VALIGN_TOP);
		
		$form = new Form($this);
		
		$table_form = new Table();
		$table_form->setClass(Table::STYLE_SECOND);
		$table_form->addRow();
		
		$this->background_body = new ColorPicker($form);
		$this->background_body->setValue(DEFINE_STYLE_BCK_BODY)->hash(true)->setWidth(200);
		$this->background_body->disableAjaxWaitMessage()->onChange("changeBackgroundBody")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_BACKGROUND_BODY).":&nbsp;", $this->background_body);
		
		$this->color_body = new ColorPicker($form);
		$this->color_body->setValue(DEFINE_STYLE_COLOR_BODY)->hash(true)->setWidth(200);
		$this->color_body->disableAjaxWaitMessage()->onChange("changeColorBody")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_COLOR_BODY).":&nbsp;", $this->color_body);
		
		$table_form->addRow();
		
		$this->link_color = new ColorPicker($form);
		$this->link_color->setValue(DEFINE_STYLE_LINK_COLOR)->hash(true)->setWidth(200);
		$this->link_color->disableAjaxWaitMessage()->onChange("changeLinkColor")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_LINK_COLOR).":&nbsp;", $this->link_color);
		
		$this->link_hover_color = new ColorPicker($form);
		$this->link_hover_color->setValue(DEFINE_STYLE_LINK_HOVER_COLOR)->hash(true)->setWidth(200);
		$this->link_hover_color->disableAjaxWaitMessage()->onChange("changeLinkHoverColor")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_LINK_HOVER_COLOR).":&nbsp;", $this->link_hover_color);
		
		$table_form->addRow();
		
		$this->background_picture_1 = new ComboBox($form);
		$this->background_picture_1->addItem("", __(NO_PICTURE));
		if (DEFINE_STYLE_BCK_PICTURE_1 != "") {
			$this->background_picture_1->addItem(str_replace("../img/", "img/", str_replace("../wsp/img/", "wsp/img/", DEFINE_STYLE_BCK_PICTURE_1)), DEFINE_STYLE_BCK_PICTURE_1." (".__(CURRENT).")", true);
		}
		if ($handle = opendir(dirname(__FILE__)."/../../../wsp/img/round_bgd/")) {
			while (false !== ($file = readdir($handle))) {
				if (is_file(dirname(__FILE__)."/../../../wsp/img/round_bgd/".$file)) {
					$this->background_picture_1->addItem("wsp/img/round_bgd/".$file, $file, (DEFINE_STYLE_BCK_PICTURE_1=="img/round_bgd/".$file?true:false));
				}
			}
			closedir($handle);
		}
		$this->background_picture_1->onChange("changeBackgroundPicture1")->setAjaxEvent()->disableAjaxWaitMessage();
		$table_form->addRowColumns(__(CMB_BCK_PICTURE_1).":&nbsp;", $this->background_picture_1->setWidth(200));
		
		$this->background_1_header = new ColorPicker($form);
		$this->background_1_header->setValue(DEFINE_STYLE_BCK_1_HEADER)->hash(true)->setWidth(200);
		$this->background_1_header->disableAjaxWaitMessage()->onChange("changeBackground1Header")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_BCK_1_HEADER).":&nbsp;", $this->background_1_header);
		
		$this->border_table_1 = new ColorPicker($form);
		$this->border_table_1->setValue(DEFINE_STYLE_BORDER_TABLE_1)->hash(true)->setWidth(200);
		$this->border_table_1->disableAjaxWaitMessage()->onChange("changeBorderTable1")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_BCK_BORDER_TABLE_1).":&nbsp;", $this->border_table_1);
		
		$this->color_1_header = new ColorPicker($form);
		$this->color_1_header->setValue(DEFINE_STYLE_COLOR_1_HEADER)->hash(true)->required(false)->setWidth(200);
		$this->color_1_header->disableAjaxWaitMessage()->onChange("changeColor1Header")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_COLOR_1_HEADER).":&nbsp;", $this->color_1_header);
		
		$this->style1_header_link = new ColorPicker($form);
		$this->style1_header_link->setValue(DEFINE_STYLE_COLOR_1_HEADER_LINK)->hash(true)->required(false)->setWidth(200);
		if ($this->color_1_header->getValue() != "") {
			$this->style1_header_link->forceEmptyValue();
		}
		$this->style1_header_link->disableAjaxWaitMessage()->onChange("change1HeaderLink")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_COLOR_1_HEADER_LINK).":&nbsp;", $this->style1_header_link);
		
		$this->style1_header_link_hover = new ColorPicker($form);
		$this->style1_header_link_hover->setValue(DEFINE_STYLE_COLOR_1_HEADER_LINK_HOVER)->hash(true)->required(false)->setWidth(200);
		if ($this->style1_header_link->getValue() == "") {
			$this->style1_header_link_hover->disable();
			$this->style1_header_link_hover->forceEmptyValue();
		}
		$this->style1_header_link_hover->disableAjaxWaitMessage()->onChange("change1HeaderLinkHover")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_COLOR_1_HEADER_LINK_HOVER).":&nbsp;", $this->style1_header_link_hover);
		
		$this->background_1 = new ColorPicker($form);
		$this->background_1->setValue(DEFINE_STYLE_BCK_1)->hash(true)->setWidth(200);
		$this->background_1->disableAjaxWaitMessage()->onChange("changeBackground1")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_BCK_1).":&nbsp;", $this->background_1);
		
		$this->color_1 = new ColorPicker($form);
		$this->color_1->setValue(DEFINE_STYLE_COLOR_1)->hash(true)->setWidth(200);
		$this->color_1->disableAjaxWaitMessage()->onChange("changeColor1")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_COLOR_1).":&nbsp;", $this->color_1);
		
		$this->style1_color_link = new ColorPicker($form);
		$this->style1_color_link->setValue(DEFINE_STYLE_COLOR_1_LINK)->hash(true)->required(false)->setWidth(200);
		if ($this->color_1->getValue() != "") {
			$this->style1_color_link->forceEmptyValue();
		}
		$this->style1_color_link->disableAjaxWaitMessage()->onChange("change1ColorLink")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_COLOR_1_LINK).":&nbsp;", $this->style1_color_link);
		
		$this->style1_color_link_hover = new ColorPicker($form);
		$this->style1_color_link_hover->setValue(DEFINE_STYLE_COLOR_1_LINK_HOVER)->hash(true)->required(false)->setWidth(200);
		if ($this->style1_color_link->getValue() == "") {
			$this->style1_color_link_hover->disable();
			$this->style1_color_link_hover->forceEmptyValue();
		}
		$this->style1_color_link_hover->disableAjaxWaitMessage()->onChange("change1ColorLinkHover")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_COLOR_1_LINK_HOVER).":&nbsp;", $this->style1_color_link_hover);
		
		$table_form->addRow();
		
		$this->color_shadow = new ColorPicker($form);
		if (DEFINE_STYLE_BCK_PICTURE_1 != "" && DEFINE_STYLE_BCK_PICTURE_SECOND != "") {
			$this->color_shadow->disable();
		}
		$this->color_shadow->setValue(DEFINE_STYLE_OMBRE_COLOR)->hash(true)->setWidth(200);
		$this->color_shadow->disableAjaxWaitMessage()->onChange("changeColorShadow")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_COLOR_SHADOW).":&nbsp;", $this->color_shadow);
		
		$table_form->addRow();
		
		$this->style_font = new ComboBox($form, "style_font", 200);
		$this->style_font->addItem("Arial", "Arial", (DEFINE_STYLE_FONT=="Arial"?true:false));
		$this->style_font->addItem("Times New Roman", "Times New Roman", (DEFINE_STYLE_FONT=="Times New Roman"?true:false));
		$this->style_font->addItem("Verdana", "Verdana", (DEFINE_STYLE_FONT=="Verdana"?true:false));
		$this->style_font->addItem("Cantarell", "Cantarell", (DEFINE_STYLE_FONT=="Cantarell"?true:false));
		$this->style_font->addItem("Cardo", "Cardo", (DEFINE_STYLE_FONT=="Cardo"?true:false));
		$this->style_font->addItem("Comic Sans MS", "Comic Sans MS", (DEFINE_STYLE_FONT=="Comic Sans MS"?true:false)); 
		$this->style_font->addItem("Courier", "Courier", (DEFINE_STYLE_FONT=="Courier"?true:false));
		$this->style_font->addItem("Courier New ", "Courier New ", (DEFINE_STYLE_FONT=="Courier New "?true:false));
		$this->style_font->addItem("Crimson Text", "Crimson Text", (DEFINE_STYLE_FONT=="Crimson Text"?true:false));
		$this->style_font->addItem("Droid Sans", "Droid Sans", (DEFINE_STYLE_FONT=="Droid Sans"?true:false));
		$this->style_font->addItem("Droid Sans Mono", "Droid Sans Mono", (DEFINE_STYLE_FONT=="Droid Sans Mono"?true:false));
		$this->style_font->addItem("Droid Serif", "Droid Serif", (DEFINE_STYLE_FONT=="Droid Serif"?true:false));
		$this->style_font->addItem("IM Fell", "IM Fell", (DEFINE_STYLE_FONT=="IM Fell"?true:false));
		$this->style_font->addItem("Impact", "Impact", (DEFINE_STYLE_FONT=="Impact"?true:false));
		$this->style_font->addItem("Inconsolata", "Inconsolata", (DEFINE_STYLE_FONT=="Inconsolata"?true:false));
		$this->style_font->addItem("Josefin Sans Std Light", "Josefin Sans Std Light", (DEFINE_STYLE_FONT=="Josefin Sans Std Light"?true:false));
		$this->style_font->addItem("Lobster", "Lobster", (DEFINE_STYLE_FONT=="Lobster"?true:false));
		$this->style_font->addItem("Molengo", "Molengo", (DEFINE_STYLE_FONT=="Molengo"?true:false));
		$this->style_font->addItem("Monaco ", "Monaco ", (DEFINE_STYLE_FONT=="Monaco "?true:false));
		$this->style_font->addItem("Nobile", "Nobile", (DEFINE_STYLE_FONT=="Nobile"?true:false));
		$this->style_font->addItem("OFL Sorts Mill Goudy TT", "OFL Sorts Mill Goudy TT", (DEFINE_STYLE_FONT=="OFL Sorts Mill Goudy TT"?true:false));
		$this->style_font->addItem("Old Standard TT", "Old Standard TT", (DEFINE_STYLE_FONT=="Old Standard TT"?true:false));
		$this->style_font->addItem("Reenie Beanie", "Reenie Beanie", (DEFINE_STYLE_FONT=="Reenie Beanie"?true:false));
		$this->style_font->addItem("Tangerine", "Tangerine", (DEFINE_STYLE_FONT=="Tangerine"?true:false));
		$this->style_font->addItem("Vollkorn", "Vollkorn", (DEFINE_STYLE_FONT=="Vollkorn"?true:false));
		$this->style_font->addItem("Yanone Kaffeesatz", "Yanone Kaffeesatz", (DEFINE_STYLE_FONT=="Yanone Kaffeesatz"?true:false));
		$this->style_font->disableAjaxWaitMessage()->onChange("changeStyleFont")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_STYLE_FONT).":&nbsp;", $this->style_font);
		
		$this->style_font_size = new TextBox($form);
		$validation = new LiveValidation();
		$font_size = DEFINE_STYLE_FONT_SIZE;
		if ($font_size == "") { $font_size = "10pt"; }
		$this->style_font_size->setValue(str_replace("pt", "", $font_size))->setWidth(200);
		$this->style_font_size->disableAjaxWaitMessage()->onChange("changeStyleFontSize")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_FONT_SIZE).":&nbsp;", $this->style_font_size->setLiveValidation($validation->addValidateNumericality(true)));
		
		$table_form->addRow();
		$form->setContent($table_form);
		
		$this->example_obj = new Object($this->createExamples());
		$this->example_obj->setId("idExamplesObject");
		
		$table->addRowColumns($form, "&nbsp;", $this->example_obj)->setColumnWidth(2, 50);
		$this->render = new AdminTemplateForm($this, $table);
	}
	
	public function createExamples() {
		$table_box = new Table();
		$table_box->setWidth(250)->setDefaultAlign(RowTable::ALIGN_LEFT);
		
		$table_box->addRow();
		
		$style1_box = new Box("link", false, Box::STYLE_MAIN, Box::STYLE_MAIN, BASE_URL, "box_1", 200);
		if ($this->background_picture_1->getValue() != "") {
			$style1_box->forceBoxWithPicture(true, $this->border_table_1->getValue());
		} else {
			$style1_box->forceBoxWithPicture(false);
		}
		$style1_box->setDraggable(true)->setShadow(true);
		$table_box->addRow($style1_box->setContent("Box Object [<a href=\"javascript:void(0);\">style 1</a>]"));
		
		$style1_box = new RoundBox(Box::STYLE_MAIN, "round_box_1", 200);
		$style1_box->setDraggable(true)->setShadow(true);
		if ($this->background_picture_1->getValue() != "") {
			$style1_box->forceBoxWithPicture(true, $this->border_table_1->getValue());
		} else {
			$style1_box->forceBoxWithPicture(false);
		}
		$table_box->addRow($style1_box->setContent("RoundBox Object<br/>[style 1]"));
		
		$table_box->addRow();
		
		$style2_box = new Box("link", false, Box::STYLE_SECOND, Box::STYLE_SECOND, BASE_URL, "box_2", 200);
		$style2_box->setDraggable(true);
		$table_box->addRow($style2_box->setContent("Box Object [<a href=\"javascript:void(0);\">style 2</a>]"));
		
		$style2_box = new RoundBox(Box::STYLE_SECOND, "round_box_2", 200);
		$style2_box->setDraggable(true);
		$table_box->addRow($style2_box->setContent("RoundBox Object<br/>[style 2]"));
		
		$table_box->addRow();
		
		$button_1 = new Button($this);
		$table_box->addRow($button_1->setValue("Button [style jquery]"));
		
		$table_box->addRow();
		
		$table_box->addRow(new Link("/", Link::TARGET_BLANK, "My Link"));
		
		return $table_box;
	}
	
	public function changeBackgroundBody($sender) {
		$this->addObject(new JavaScript("changeStyleSheetProperty('styles.php.css', 'body', 'background', '".addslashes($this->background_body->getValue())."');"));
	}
	
	public function changeColorBody($sender) {
		$this->addObject(new JavaScript("changeStyleSheetProperty('styles.php.css', 'body', 'color', '".addslashes($this->color_body->getValue())."');"));
	}
	
	public function changeLinkColor($sender) {
		$array_link_color = array('a,.link', 'a:hover,.link:hover');
		$this->changeStyleSheetProperty("styles.php.css", $array_link_color, "color", $this->link_color->getValue());
		$this->changeLinkHoverColor($sender);
	}
	
	public function changeLinkHoverColor($sender) {
		$this->addObject(new JavaScript("changeStyleSheetProperty('styles.php.css', 'a:hover,.link:hover', 'color', '".addslashes($this->link_hover_color->getValue())."');"));
	}
	
	public function changeBackgroundPicture1($sender) {
		$this->example_obj->emptyObject();
		$this->example_obj->add($this->createExamples());
		if ($this->background_picture_1->getValue() != "") {
			$this->color_shadow->disable();
		} else {
			$this->color_shadow->enable();
		}
		$this->changeBackground1Header();
	}
	
	public function changeBackground1Header($sender) {
		$this->changeStyleSheetProperty("angle.php.css", $this->array_round_box_1, "background", $this->background_1_header->getValue());
		$this->changeStyleSheetProperty("styles.php.css", array(".bckg_1", ".header_1_bckg", ".table_1_round"), "background", $this->background_1_header->getValue());
		
		$this->changeStyleSheetProperty("angle.php.css", array('#top1'), "background", $this->background_1_header->getValue()." url(".BASE_URL.$this->background_picture_1->getValue().") no-repeat top right");
		$this->changeStyleSheetProperty("angle.php.css", array('#top1 div'), "background", $this->background_1_header->getValue()." url(".BASE_URL.$this->background_picture_1->getValue().") no-repeat top left");
		$this->changeStyleSheetProperty("angle.php.css", array('#left1'), "background", $this->background_1_header->getValue()." url(".BASE_URL.$this->background_picture_1->getValue().") no-repeat bottom left");
		$this->changeStyleSheetProperty("angle.php.css", array('#right1'), "background", $this->background_1_header->getValue()." url(".BASE_URL.$this->background_picture_1->getValue().") no-repeat bottom right");
		$this->changeStyleSheetProperty("angle.php.css", array('.Css3RadiusBoxTitle1'), "background", $this->background_1_header->getValue());
		$this->changeBoxBackgroundGradient();
	}
	
	
	private function changeBoxBackgroundGradient() {
		if ($this->isCss3Browser()) {
			if ($this->getBrowserName() == "Firefox") {
				$this->changeStyleSheetProperty("angle.php.css", array('.Css3GradientBoxTitle1'), "background", "-moz-linear-gradient(90deg, ".$this->background_1_header->getValue()." 70%, ".$this->border_table_1->getValue()." 100%);");
			} else {
				$this->changeStyleSheetProperty("angle.php.css", array('.Css3GradientBoxTitle1'), "background", "-webkit-gradient(linear, left top, left bottom, from(".$this->background_1_header->getValue()."), to(".$this->border_table_1->getValue()."));");
				$this->changeStyleSheetProperty("angle.php.css", array('.Css3GradientBoxTitle1'), "background-image", "-webkit-gradient(linear, left bottom, left top, color-stop(0.7,".$this->background_1_header->getValue()."), color-stop(1,".$this->border_table_1->getValue()."));");
				$this->changeStyleSheetProperty("angle.php.css", array('.Css3GradientBoxTitle1'), "filter", "progid:DXImageTransform.Microsoft.gradient(enabled='true',startColorstr=".$this->background_1_header->getValue().",endColorstr=".$this->border_table_1->getValue().",GradientType=0); zoom: 1;");
			}
		}
	}
	
	public function changeColor1Header($sender) {
		if ($this->color_1_header->getValue() == "") {
			$this->addObject(new DialogBox(__(ERROR), "Color header can't be empty"));
		} else {
			$array_color_1_header = array('.header_1_bckg', '.header_1_bckg_a a', '.header_1_bckg_a a:hover');
			$this->changeStyleSheetProperty("styles.php.css", $array_color_1_header, "color", $this->color_1_header->getValue());
			$this->changeStyleSheetProperty("angle.php.css", array('#left1'), "color", $this->color_1_header->getValue());
			$this->change1HeaderLink($sender);
		}
	}

	public function change1HeaderLink($sender) {
		if ($this->style1_header_link->getValue() != "") {
			$this->style1_header_link_hover->enable();
		} else {
			$this->style1_header_link_hover->disable();
			$this->style1_header_link_hover->setValue("");
		}
		if ($this->style1_header_link_hover->getValue() == "") {
			$array_color_1_header_link = array('.header_1_bckg_a a', '.header_1_bckg_a a:hover');
		} else {
			$array_color_1_header_link = array('.header_1_bckg_a a');
		}
		if ($this->style1_header_link->getValue() == "") {
			$this->changeStyleSheetProperty("styles.php.css", $array_color_1_header_link, "color", $this->color_1_header->getValue());
		} else {
			$this->changeStyleSheetProperty("styles.php.css", $array_color_1_header_link, "color", $this->style1_header_link->getValue());
		}
		$this->change1HeaderLinkHover($sender);
	}
	
	public function change1HeaderLinkHover($sender) {
		if ($this->style1_header_link_hover->getValue() != "") {
			$this->changeStyleSheetProperty("styles.php.css", array('.header_1_bckg_a a:hover'), "color", $this->style1_header_link_hover->getValue());
		}
	}
	
	public function changeBackground1($sender) {
		if ($this->color_1->getValue() == "") {
			$this->addObject(new DialogBox(__(ERROR), "Background can't be empty"));
		} else {
			$array_background_color_1 = array('.table_1_angle', '.table_1', '.table_1_bckg', '.bckg_1');
			$this->changeStyleSheetProperty("styles.php.css", $array_background_color_1, "background", $this->background_1->getValue());
		}
	}
	
	public function changeColor1($sender) {
		if ($this->color_1->getValue() == "") {
			$this->addObject(new DialogBox(__(ERROR), "Color can't be empty"));
		} else {
			$array_color_1 = array('.table_1_angle', '.table_1', '.table_1_bckg', '.bckg_1');
			$this->changeStyleSheetProperty("styles.php.css", $array_color_1, "color", $this->color_1->getValue());
			$this->change1ColorLink($sender);
		}
	}
	
	public function change1ColorLink($sender) {
		if ($this->style1_color_link->getValue() != "") {
			$this->style1_color_link_hover->enable();
		} else {
			$this->style1_color_link_hover->disable();
			$this->style1_color_link_hover->setValue("");
		}
		if ($this->style1_color_link_hover->getValue() == "") {
			$array_color_1_link = array('.table_1_bckg a,a.box_style_1:link', '.table_1_bckg a:hover,a.box_style_1:hover');
		} else {
			$array_color_1_link = array('.table_1_bckg a,a.box_style_1:link');
		}
		if ($this->style1_color_link->getValue() == "") {
			$this->changeStyleSheetProperty("styles.php.css", $array_color_1_link, "color", $this->color_1->getValue());
		} else {
			$this->changeStyleSheetProperty("styles.php.css", $array_color_1_link, "color", $this->style1_color_link->getValue());
		}
		$this->change1ColorLinkHover($sender);
	}
	
	public function change1ColorLinkHover($sender) {
		if ($this->style1_color_link_hover->getValue() != "") {
			$this->changeStyleSheetProperty("styles.php.css", array('.table_1_bckg a:hover,a.box_style_1:hover'), "color", $this->style1_color_link_hover->getValue());
		}
	}
	
	public function changeBorderTable1($sender) {
		$array_round_box_border_1 = array('.pix11', '.pix11Ombre');
		$this->changeStyleSheetProperty("angle.php.css", $this->array_round_box_1, "border-left", "1px solid ".$this->border_table_1->getValue());
		$this->changeStyleSheetProperty("angle.php.css", $this->array_round_box_1, "border-right", "1px solid ".$this->border_table_1->getValue());
		$this->changeStyleSheetProperty("angle.php.css", $array_round_box_border_1, "background", $this->border_table_1->getValue());
		$this->changeStyleSheetProperty("angle.php.css", array('.Css3RadiusBox1', '.Css3RadiusRoundBox1'), "border-top", "1px solid ".$this->border_table_1->getValue());
		$this->changeStyleSheetProperty("angle.php.css", array('.Css3RadiusRoundBox1'), "border-bottom", "1px solid ".$this->border_table_1->getValue());
		$this->changeBoxBackgroundGradient();
		
		if ($this->background_picture_1->getValue() != "") {
			$this->addObject(new JavaScript("$('#wsp_box_content_box_1').css('border', '1px solid ".$this->border_table_1->getValue()."');\n"));
		}
		
		$array_box_border_1 = array('.table_1_angle');
		$this->changeStyleSheetProperty("styles.php.css", $array_box_border_1, "border-left", "1px solid ".$this->border_table_1->getValue());
		$this->changeStyleSheetProperty("styles.php.css", $array_box_border_1, "border-right", "1px solid ".$this->border_table_1->getValue());
		$this->changeStyleSheetProperty("styles.php.css", $array_box_border_1, "border-bottom", "1px solid ".$this->border_table_1->getValue());
	}
	
	public function changeColorShadow($sender) {
		$this->addObject(new JavaScript("changeStyleSheetProperty('angle.php.css', '.ombre', 'background-color', '".addslashes($this->color_shadow->getValue())."');"));
	}
	
	public function changeStyleFont($sender) {
		$this->addObject(new JavaScript("loadDynamicCSS('http://fonts.googleapis.com/css?family=".str_replace(" ", "+", $this->style_font->getValue())."');"));
		$new_font = "\"".$this->style_font->getValue()."\"";
		if ($this->style_font->getValue() != "Arial") {
			$new_font .= ", \"Arial\"";
		}
		$this->changeStyleSheetProperty("styles.php.css", $this->array_font, "font-family", $new_font);
	}
	
	public function changeStyleFontSize($sender) {
		if ($this->style_font_size->getValue() == "") {
			$this->style_font_size->setValue(10);
		}
		$this->changeStyleSheetProperty("styles.php.css", $this->array_font, "font-size", $this->style_font_size->getValue()."pt");
	}
	
	private function changeStyleSheetProperty($css_file_name, $array_properties, $property, $value) {
		for ($i=0; $i < sizeof($array_properties); $i++) {
			if (is_browser_ie()) {
				$array_sub_properties = split(',', $array_properties[$i]);
			} else {
				$array_sub_properties = array($array_properties[$i]);
			}
			for ($j=0; $j < sizeof($array_sub_properties); $j++) {
				$this->addObject(new JavaScript("changeStyleSheetProperty('".$css_file_name."', '".$array_sub_properties[$j]."', '".$property."', '".addslashes($value)."');"));
			}
		}
	}
}
?>
