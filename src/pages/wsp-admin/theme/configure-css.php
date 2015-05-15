<?php
/**
 * PHP file pages\wsp-admin\theme\configure-css.php
 */
/**
 * Content of the Page configure-css
 * URL: http://127.0.0.1/website-php-install/wsp-admin/theme/configure-css.html
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

class ConfigureCss extends Page {
	protected $USER_RIGHTS = Page::RIGHTS_ADMINISTRATOR;
	protected $USER_NO_RIGHTS_REDIRECT = "wsp-admin/admin.html";
	
	private $array_font = array('body', 'form', 'blockquote', 'p', 'h1', 'h2,h3,h4,h5,h6', 'a,.link', 'a:hover,.link:hover', 'td');
	private $array_round_box_1 = array();
	private $nb_define_style_val = 1;
	private $jquery_version = JQUERY_UI_VERSION;
	
	private $file_angle_css = "angle.php.css";
	private $file_style_css = "styles.php.css";
	
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		parent::$PAGE_TITLE = __(CONFIGURE_CSS);
		if ($this->jquery_version == "JQUERY_UI_VERSION") {
			$this->jquery_version = "1.8.14";
		}
		
		JavaScriptInclude::getInstance()->add(BASE_URL."wsp/js/wsp-admin.js", "", true);
		JavaScriptInclude::getInstance()->add(BASE_URL."wsp/js/jquery.backstretch.min.js", "", true);
		CssInclude::getInstance()->loadCssConfigFileInMemory();
		
		//Admin
		$table = new Table();
		$table->setDefaultValign(RowTable::VALIGN_TOP);
		
		$construction_page = new Object(__(PAGE_IN_CONSTRUCTION));
		$table->addRow($construction_page->setClass("warning"))->setColspan(2);
		
		$form = new Form($this);
		
		$table_form = new Table();
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
		
		$this->bck_body_pic = new TextBox($form);
		$this->bck_body_pic->setValue(DEFINE_STYLE_BCK_BODY_PIC)->setWidth(200);
		$this->bck_body_pic->disableAjaxWaitMessage()->onChange("changeBackgroundBody")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_BCK_BODY_PIC).":&nbsp;", $this->bck_body_pic);
		
		$this->bck_body_pic_repeat = new ComboBox($form);
		$this->bck_body_pic_repeat->addItem("", "&nbsp;", (DEFINE_STYLE_BCK_BODY_PIC_REPEAT==""?true:false));
		$this->bck_body_pic_repeat->addItem("repeat", "repeat", (DEFINE_STYLE_BCK_BODY_PIC_REPEAT=="repeat"?true:false));
		$this->bck_body_pic_repeat->addItem("repeat-x", "repeat-x", (DEFINE_STYLE_BCK_BODY_PIC_REPEAT=="repeat-x"?true:false));
		$this->bck_body_pic_repeat->addItem("repeat-y", "repeat-y", (DEFINE_STYLE_BCK_BODY_PIC_REPEAT=="repeat-y"?true:false));
		$this->bck_body_pic_repeat->addItem("no-repeat", "no-repeat", (DEFINE_STYLE_BCK_BODY_PIC_REPEAT=="no-repeat"?true:false));
		$this->bck_body_pic_repeat->disableAjaxWaitMessage()->onChange("changeBackgroundBody")->setAjaxEvent()->setWidth(200);
		if ($this->bck_body_pic->getValue() == "") {
			$this->bck_body_pic_repeat->setValue("");
			$this->bck_body_pic_repeat->disable();
		}
		$table_form->addRowColumns(__(EDT_BCK_BODY_PIC_REPEAT).":&nbsp;", $this->bck_body_pic_repeat);
		
		$body_pic_pos = "";
		$body_pic_pos_more = "";
		if (strtolower(DEFINE_STYLE_BCK_BODY_PIC_POSITION) == "stretch") {
			$body_pic_pos = strtolower(DEFINE_STYLE_BCK_BODY_PIC_POSITION);
		} else if (DEFINE_STYLE_BCK_BODY_PIC_POSITION != "") {
			$tmp_array = split(' ', DEFINE_STYLE_BCK_BODY_PIC_POSITION);
			for ($i=0; $i < sizeof($tmp_array); $i++) {
				if (is_numeric(trim(str_replace("px", "", str_replace("%", "", $tmp_array[$i]))))) {
					$body_pic_pos_more .= $tmp_array[$i]." ";
				} else {
					$body_pic_pos .= $tmp_array[$i]." ";
				}
			}
			$body_pic_pos = strtolower(trim($body_pic_pos));
			$body_pic_pos_more = trim($body_pic_pos_more);
		}
		
		$this->bck_body_pic_position = new ComboBox($form);
		$this->bck_body_pic_position->addItem("", "&nbsp;", ($body_pic_pos==""?true:false));
		$this->bck_body_pic_position->addItem("stretch", "stretch", ($body_pic_pos=="stretch"?true:false));
		$this->bck_body_pic_position->addItem("left top", "left top", ($body_pic_pos=="left top"?true:false));
		$this->bck_body_pic_position->addItem("left", "left center", ($body_pic_pos=="left"?true:false));
		$this->bck_body_pic_position->addItem("left bottom", "left bottom", ($body_pic_pos=="left bottom"?true:false));
		$this->bck_body_pic_position->addItem("right top", "right top", ($body_pic_pos=="right top"?true:false));
		$this->bck_body_pic_position->addItem("right", "right center", ($body_pic_pos=="right"?true:false));
		$this->bck_body_pic_position->addItem("right bottom", "right bottom", ($body_pic_pos=="right bottom"?true:false));
		$this->bck_body_pic_position->addItem("top", "center top", ($body_pic_pos=="top"?true:false));
		$this->bck_body_pic_position->addItem("center", "center center", ($body_pic_pos=="center"?true:false));
		$this->bck_body_pic_position->addItem("bottom", "center bottom", ($body_pic_pos=="bottom"?true:false));
		$this->bck_body_pic_position->disableAjaxWaitMessage()->onChange("changeBackgroundBody")->setAjaxEvent()->setWidth(120);
		if ($this->bck_body_pic->getValue() == "") {
			$this->bck_body_pic_position->setValue("");
			$this->bck_body_pic_position->disable();
		}
		
		$this->bck_body_pic_position_more = new TextBox($form);
		$this->bck_body_pic_position_more->setValue($body_pic_pos_more);
		$this->bck_body_pic_position_more->disableAjaxWaitMessage()->onChange("changeBackgroundBody")->setAjaxEvent()->setWidth(77);
		if ($this->bck_body_pic->getValue() == "") {
			$this->bck_body_pic_position_more->setValue("");
			$this->bck_body_pic_position_more->disable();
		}
		$table_form->addRowColumns(__(EDT_BCK_BODY_PIC_POSITION).":&nbsp;", new Object($this->bck_body_pic_position, $this->bck_body_pic_position_more));
		
		$table_form->addRow();
		
		$this->style_jquery = new ComboBox($form);
		if (!defined('DEFINE_STYLE_JQUERY') || DEFINE_STYLE_JQUERY == "") {
			$define_style_jquery = "smoothness";
		} else {
			$define_style_jquery = DEFINE_STYLE_JQUERY;
		}
		$dirname = dirname(__FILE__)."/../../../wsp/css/jquery".$this->jquery_version."/";
		$files = scandir($dirname); 
		for($i=0; $i < sizeof($files); $i++) {
			$file = $files[$i];
			if($file != '.' && $file != '..' && $file != '.svn' && is_dir($dirname.$file)) {
				$this->style_jquery->addItem($file, $file, ($define_style_jquery==$file?true:false));
			}
		}
		$this->style_jquery->disableAjaxWaitMessage()->onChange("changeStyleJquery")->setAjaxEvent()->setWidth(200);
		$table_form->addRowColumns(__(EDT_STYLE_JQUERY).":&nbsp;", $this->style_jquery);
		
		$table_form->addRow();
		
		$this->style_font = new ComboBox($form, "style_font", 200);
		$this->style_font->addItem("Arial", "Arial", (DEFINE_STYLE_FONT=="Arial"?true:false));
		$this->style_font->addItem("Times New Roman", "Times New Roman", (DEFINE_STYLE_FONT=="Times New Roman"?true:false));
		$this->style_font->addItem("Verdana", "Verdana", (DEFINE_STYLE_FONT=="Verdana"?true:false));
		$this->style_font->addItem("Cantarell", "Cantarell", (DEFINE_STYLE_FONT=="Cantarell"?true:false));
		$this->style_font->addItem("Cardo", "Cardo", (DEFINE_STYLE_FONT=="Cardo"?true:false));
		$this->style_font->addItem("Comic Sans MS", "Comic Sans MS", (DEFINE_STYLE_FONT=="Comic Sans MS"?true:false)); 
		$this->style_font->addItem("Courier", "Courier", (DEFINE_STYLE_FONT=="Courier"?true:false));
		$this->style_font->addItem("Courier New", "Courier New", (DEFINE_STYLE_FONT=="Courier New"?true:false));
		$this->style_font->addItem("Crimson Text", "Crimson Text", (DEFINE_STYLE_FONT=="Crimson Text"?true:false));
		$this->style_font->addItem("Droid Sans", "Droid Sans", (DEFINE_STYLE_FONT=="Droid Sans"?true:false));
		$this->style_font->addItem("Droid Sans Mono", "Droid Sans Mono", (DEFINE_STYLE_FONT=="Droid Sans Mono"?true:false));
		$this->style_font->addItem("Droid Serif", "Droid Serif", (DEFINE_STYLE_FONT=="Droid Serif"?true:false));
		$this->style_font->addItem("IM Fell", "IM Fell", (DEFINE_STYLE_FONT=="IM Fell"?true:false));
		$this->style_font->addItem("Impact", "Impact", (DEFINE_STYLE_FONT=="Impact"?true:false));
		$this->style_font->addItem("Inconsolata", "Inconsolata", (DEFINE_STYLE_FONT=="Inconsolata"?true:false));
		$this->style_font->addItem("Lobster", "Lobster", (DEFINE_STYLE_FONT=="Lobster"?true:false));
		$this->style_font->addItem("Molengo", "Molengo", (DEFINE_STYLE_FONT=="Molengo"?true:false));
		$this->style_font->addItem("Monaco", "Monaco", (DEFINE_STYLE_FONT=="Monaco"?true:false));
		$this->style_font->addItem("Nobile", "Nobile", (DEFINE_STYLE_FONT=="Nobile"?true:false));
		$this->style_font->addItem("Old Standard TT", "Old Standard TT", (DEFINE_STYLE_FONT=="Old Standard TT"?true:false));
		$this->style_font->addItem("Reenie Beanie", "Reenie Beanie", (DEFINE_STYLE_FONT=="Reenie Beanie"?true:false));
		$this->style_font->addItem("Tangerine", "Tangerine", (DEFINE_STYLE_FONT=="Tangerine"?true:false));
		$this->style_font->addItem("Vollkorn", "Vollkorn", (DEFINE_STYLE_FONT=="Vollkorn"?true:false));
		$this->style_font->addItem("Yanone Kaffeesatz", "Yanone Kaffeesatz", (DEFINE_STYLE_FONT=="Yanone Kaffeesatz"?true:false));
		$this->style_font->disableAjaxWaitMessage()->onChange("changeStyleFont")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_STYLE_FONT).":&nbsp;", $this->style_font);
		
		$this->style_font_serif = new ComboBox($form);
		$this->style_font_serif->addItem("serif", "serif", (DEFINE_STYLE_FONT_SERIF=="serif"?true:false));
		$this->style_font_serif->addItem("sans serif", "sans serif", (DEFINE_STYLE_FONT_SERIF=="sans serif"||DEFINE_STYLE_FONT_SERIF==""?true:false));
		$this->style_font_serif->addItem("monospace", "monospace", (DEFINE_STYLE_FONT_SERIF=="monospace"?true:false));
		$this->style_font_serif->disableAjaxWaitMessage()->onChange("changeStyleFont")->setAjaxEvent()->setWidth(200);
		$table_form->addRowColumns(__(EDT_STYLE_FONT_SERIF).":&nbsp;", $this->style_font_serif);
		
		$this->style_font_size = new TextBox($form);
		$validation = new LiveValidation();
		$font_size = DEFINE_STYLE_FONT_SIZE;
		if ($font_size == "") { $font_size = "10pt"; }
		$this->style_font_size->setValue(str_replace("pt", "", $font_size))->setWidth(200);
		$this->style_font_size->disableAjaxWaitMessage()->onChange("changeStyleFontSize")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_FONT_SIZE).":&nbsp;", $this->style_font_size->setLiveValidation($validation->addValidateNumericality(true)));
		
		$table_form->addRow();
		
		$this->nb_define_style_bck = new ComboBox($form);
		for ($i=1; $i<=99; $i++) {
			$this->nb_define_style_bck->addItem($i, $i, (!$this->nb_define_style_bck->isChanged() && $i==NB_DEFINE_STYLE_BCK?true:false));
		}
		$this->nb_define_style_bck->onChange("changeNbDefineStyleBck")->setAjaxEvent();
		$this->nb_define_style_bck->onFormIsChangedJs("alert('".__(WARNING_CHANGE_PLEASE_SAVE)."');return false;", true);
		$table_form->addRowColumns(__(CMB_NB_PREDEFINE_STYLE).":&nbsp;", $this->nb_define_style_bck->setWidth(50));
		
		$table_form->addRow();
		
		$this->current_style_display = new ComboBox($form);
		$this->current_style_display->onFormIsChangedJs("alert('".__(WARNING_CHANGE_PLEASE_SAVE)."');return false;", true);
		for ($i=1; $i <= $this->nb_define_style_bck->getValue(); $i++) {
			$this->current_style_display->addItem($i, $i);
		}
		if ($this->current_style_display->getValue() == "") {
			$this->current_style_display->setSelectedIndex(0);
		}
		$this->current_style_display->onChange("changeCurrentStyleBck")->setAjaxEvent();
		$table_form->addRowColumns(__(CMB_CURRENT_PREDEFINE_STYLE).":&nbsp;", $this->current_style_display->setWidth(50));
		
		$this->current_style_val = $this->current_style_display->getValue();
		
		for ($i=1; $i <= $this->nb_define_style_bck->getValue(); $i++) {
			$this->array_round_box_1[] = '.AngleRond'.$i;
			$this->array_round_box_1[] = '.AngleRond'.$i.'Ombre';
			
			$this->array_font[] = '.table_'.$i;
			$this->array_font[] = '.table_'.$i.'_bckg';
			$this->array_font[] = '.bckg_'.$i;
			$this->array_font[] = '.header_'.$i.'_bckg';
			$this->array_font[] = '.header_'.$i.'_bckg a';
			$this->array_font[] = '.header_'.$i.'_bckg_a a';
			$this->array_font[] = '.header_'.$i.'_bckg a:hover';
			$this->array_font[] = '.table_'.$i.'_bckg a, a.box_style_'.$i.':link';
			$this->array_font[] = '.table_'.$i.'_bckg a:hover, a.box_style_'.$i.':hover';
		}
		
		$this->background_picture_1 = new ComboBox($form);
		$this->background_picture_1->addItem("", __(NO_PICTURE));
		if (constant("DEFINE_STYLE_BCK_PICTURE_".$this->current_style_val) != "") {
			$this->background_picture_1->addItem(str_replace("../img/", "img/", str_replace("../wsp/img/", "wsp/img/", constant("DEFINE_STYLE_BCK_PICTURE_".$this->current_style_val))), constant("DEFINE_STYLE_BCK_PICTURE_".$this->current_style_val)." (".__(CURRENT_PICTURE).")", true);
		}
		if ($handle = opendir(dirname(__FILE__)."/../../../wsp/img/round_bgd/")) {
			while (false !== ($file = readdir($handle))) {
				if (is_file(dirname(__FILE__)."/../../../wsp/img/round_bgd/".$file)) {
					$this->background_picture_1->addItem("wsp/img/round_bgd/".$file, $file, (constant("DEFINE_STYLE_BCK_PICTURE_".$this->current_style_val)=="img/round_bgd/".$file?true:false));
				}
			}
			closedir($handle);
		}
		$this->background_picture_1->onChange("changeBackgroundPicture1")->setAjaxEvent()->disableAjaxWaitMessage();
		$table_form->addRowColumns(__(CMB_BCK_PICTURE_1, $this->current_style_val).":&nbsp;", $this->background_picture_1->setWidth(200));
		
		$this->background_1_header = new ColorPicker($form);
		$this->background_1_header->setValue(constant("DEFINE_STYLE_BCK_".$this->current_style_val."_HEADER"))->hash(true)->setWidth(200);
		$this->background_1_header->disableAjaxWaitMessage()->onChange("changeBackground1Header")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_BCK_1_HEADER, $this->current_style_val).":&nbsp;", $this->background_1_header);
		
		$this->border_table_1 = new ColorPicker($form);
		$this->border_table_1->setValue(constant("DEFINE_STYLE_BORDER_TABLE_".$this->current_style_val))->hash(true)->setWidth(200);
		$this->border_table_1->disableAjaxWaitMessage()->onChange("changeBorderTable1")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_BCK_BORDER_TABLE_1, $this->current_style_val).":&nbsp;", $this->border_table_1);
		
		$this->color_1_header = new ColorPicker($form);
		$this->color_1_header->setValue(constant("DEFINE_STYLE_COLOR_".$this->current_style_val."_HEADER"))->hash(true)->required(false)->setWidth(200);
		$this->color_1_header->disableAjaxWaitMessage()->onChange("changeColor1Header")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_COLOR_1_HEADER, $this->current_style_val).":&nbsp;", $this->color_1_header);
		
		$this->style1_header_link = new ColorPicker($form);
		$this->style1_header_link->setValue(constant("DEFINE_STYLE_COLOR_".$this->current_style_val."_HEADER_LINK"))->hash(true)->required(false)->setWidth(200);
		if ($this->color_1_header->getValue() != "") {
			$this->style1_header_link->forceEmptyValue();
		}
		$this->style1_header_link->disableAjaxWaitMessage()->onChange("change1HeaderLink")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_COLOR_1_HEADER_LINK, $this->current_style_val).":&nbsp;", $this->style1_header_link);
		
		$this->style1_header_link_hover = new ColorPicker($form);
		$this->style1_header_link_hover->setValue(constant("DEFINE_STYLE_COLOR_".$this->current_style_val."_HEADER_LINK_HOVER"))->hash(true)->required(false)->setWidth(200);
		if ($this->style1_header_link->getValue() == "") {
			$this->style1_header_link_hover->disable();
			$this->style1_header_link_hover->forceEmptyValue();
		}
		$this->style1_header_link_hover->disableAjaxWaitMessage()->onChange("change1HeaderLinkHover")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_COLOR_1_HEADER_LINK_HOVER, $this->current_style_val).":&nbsp;", $this->style1_header_link_hover);
		
		$this->background_1 = new ColorPicker($form);
		$this->background_1->setValue(constant("DEFINE_STYLE_BCK_".$this->current_style_val))->hash(true)->setWidth(200);
		$this->background_1->disableAjaxWaitMessage()->onChange("changeBackground1")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_BCK_1, $this->current_style_val).":&nbsp;", $this->background_1);
		
		$this->color_1 = new ColorPicker($form);
		$this->color_1->setValue(constant("DEFINE_STYLE_COLOR_".$this->current_style_val))->hash(true)->setWidth(200);
		$this->color_1->disableAjaxWaitMessage()->onChange("changeColor1")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_COLOR_1, $this->current_style_val).":&nbsp;", $this->color_1);
		
		$this->style1_color_link = new ColorPicker($form);
		$this->style1_color_link->setValue(constant("DEFINE_STYLE_COLOR_".$this->current_style_val."_LINK"))->hash(true)->required(false)->setWidth(200);
		if ($this->color_1->getValue() != "") {
			$this->style1_color_link->forceEmptyValue();
		}
		$this->style1_color_link->disableAjaxWaitMessage()->onChange("change1ColorLink")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_COLOR_1_LINK, $this->current_style_val).":&nbsp;", $this->style1_color_link);
		
		$this->style1_color_link_hover = new ColorPicker($form);
		$this->style1_color_link_hover->setValue(constant("DEFINE_STYLE_COLOR_".$this->current_style_val."_LINK_HOVER"))->hash(true)->required(false)->setWidth(200);
		if ($this->style1_color_link->getValue() == "") {
			$this->style1_color_link_hover->disable();
			$this->style1_color_link_hover->forceEmptyValue();
		}
		$this->style1_color_link_hover->disableAjaxWaitMessage()->onChange("change1ColorLinkHover")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_COLOR_1_LINK_HOVER, $this->current_style_val).":&nbsp;", $this->style1_color_link_hover);
		
		$this->style_gradient = new CheckBox($form);
		if (constant("DEFINE_STYLE_GRADIENT_".$this->current_style_val) == true) {
			$this->style_gradient->setChecked();
		}
		$this->style_gradient->activateOnOffStyle();
		$this->style_gradient->disableAjaxWaitMessage()->onChange("changeGradient")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_STYLE_GRADIENT, $this->current_style_val).":&nbsp;", $this->style_gradient);

        $this->color_shadow = new ColorPicker($form);
        if (DEFINE_STYLE_BCK_PICTURE_1 != "" && DEFINE_STYLE_BCK_PICTURE_SECOND != "") {
            $this->color_shadow->disable();
        }
        $this->color_shadow->setValue(constant("DEFINE_STYLE_OMBRE_COLOR_".$this->current_style_val))->hash(true)->setWidth(200);
        $this->color_shadow->disableAjaxWaitMessage()->onChange("changeColorShadow")->setAjaxEvent();
        $table_form->addRowColumns(__(EDT_COLOR_SHADOW, $this->current_style_val).":&nbsp;", $this->color_shadow);

        $table_form->addRow();

        if (!defined('DEFINE_STYLE_COLOR_UPLOAD_PROGRESS_BAR')) {
            define("DEFINE_STYLE_COLOR_UPLOAD_PROGRESS_BAR", "#448ebb");
        }
        $this->style_upload_progress_bar = new ColorPicker($form);
        $this->style_upload_progress_bar->setValue(DEFINE_STYLE_COLOR_UPLOAD_PROGRESS_BAR)->hash(true)->setWidth(200);
        $table_form->addRowColumns(__(EDT_COLOR_UPLOAD_PROGRESS_BAR).":&nbsp;", $this->style_upload_progress_bar);

        $table_form->addRow();

        if (!defined('DEFINE_STYLE_BACKCOLOR_SCROLL_TO_TOP')) {
            define("DEFINE_STYLE_BACKCOLOR_SCROLL_TO_TOP", "#F00001");
        }
        $this->style_scroll_to_top = new ColorPicker($form);
        $this->style_scroll_to_top->setValue(DEFINE_STYLE_BACKCOLOR_SCROLL_TO_TOP)->hash(true)->setWidth(200);
        $table_form->addRowColumns(__(EDT_BACKCOLOR_SCROLL_TO_TOP).":&nbsp;", $this->style_scroll_to_top);
		$this->activateScrollToTop();

        $table_form->addRow();
		
		$btnValidate = new Button($form);
		$btnValidate->setValue(__(BTN_VALIDATE))->onClick("configureCss");
		$table_form->addRowColumns($btnValidate)->setColumnColspan(1, 3)->setColumnAlign(1, RowTable::ALIGN_CENTER);
		
		$table_form->addRow();
		
		$form->setContent($table_form);
		
		$this->text_link_note_obj = new Object();
		$this->text_link_note_obj->setId("id_body_note");
		
		$this->example_obj = new Object();
		$this->example_obj->setId("idExamplesObject");
		if (!$this->current_style_display->isChanged() || $btnValidate->isClicked()) {
			$this->example_obj->add($this->createExamples());
		}
		
		$table->addRowColumns($form);
		
		$this->css_config_obj = new Object($table);
		$this->css_config_obj->setId("css_config_obj");
		
		if (!$this->isAjaxPage()) {
			$this->changeColorBody();
			$this->changeLinkColor();
		}
		
		$this->render = new AdminTemplateForm($this, $this->css_config_obj, $this->example_obj);
	}
	
	public function Loaded() {
		if ($this->bck_body_pic->isChanged() || !$this->isAjaxPage()) {
			if ($this->bck_body_pic->getValue() != "") {
				$this->text_link_note_obj->add("(", new Picture("wsp/img/warning_16.png", 16, 16, 0, Picture::ALIGN_ABSMIDDLE), __(BODY_TEXT_LINK_NOTE), ")");
			} else {
				$this->text_link_note_obj->emptyObject();
			}
		}
	}
	
	public function configureCss($sender) {
		$data_config_file = "";
		$data_config_file .= "<?php\n";
		$data_config_file .= "define(\"DEFINE_STYLE_BCK_BODY\", \"".str_replace("\"", "\\\"", $this->background_body->getValue())."\");\n";
		$data_config_file .= "define(\"DEFINE_STYLE_BCK_BODY_PIC\", \"".str_replace("\"", "\\\"", $this->bck_body_pic->getValue())."\");\n";
		$data_config_file .= "define(\"DEFINE_STYLE_BCK_BODY_PIC_REPEAT\", \"".str_replace("\"", "\\\"", $this->bck_body_pic_repeat->getValue())."\");\n";
		$data_config_file .= "define(\"DEFINE_STYLE_BCK_BODY_PIC_POSITION\", \"".trim(str_replace("\"", "\\\"", $this->bck_body_pic_position->getValue())." ".str_replace("\"", "\\\"", $this->bck_body_pic_position_more->getValue()))."\");\n";
		$data_config_file .= "define(\"DEFINE_STYLE_COLOR_BODY\", \"".str_replace("\"", "\\\"", $this->color_body->getValue())."\");\n";
		$data_config_file .= "\n";
		$data_config_file .= "define(\"DEFINE_STYLE_LINK_COLOR\", \"".str_replace("\"", "\\\"", $this->link_color->getValue())."\");\n";
		$data_config_file .= "define(\"DEFINE_STYLE_LINK_HOVER_COLOR\", \"".str_replace("\"", "\\\"", $this->link_hover_color->getValue())."\");\n";
		$data_config_file .= "\n";
		$data_config_file .= "define(\"NB_DEFINE_STYLE_BCK\", ".str_replace("\"", "\\\"", $this->nb_define_style_bck->getValue())."); \n";
		$data_config_file .= "\n";
		for ($i=1; $i <= $this->nb_define_style_bck->getValue(); $i++) {
			if ($this->current_style_display->getValue() == $i) {
				$data_config_file .= "define(\"DEFINE_STYLE_BCK_".$i."_HEADER\", \"".str_replace("\"", "\\\"", $this->background_1_header->getValue())."\"); // If DEFINE_STYLE_BCK_PICTURE_1 is defined, DEFINE_STYLE_BCK_1_HEADER not use for Box object\n";
				$data_config_file .= "define(\"DEFINE_STYLE_BCK_PICTURE_".$i."\", \"".str_replace("\"", "\\\"", $this->background_picture_1->getValue())."\"); // ex : ../wsp/img/round_bgd/round_bgd.png (please use the default file wsp/img/round_bgd/round_bgd.png to create your own background)\n";
				$data_config_file .= "define(\"DEFINE_STYLE_COLOR_".$i."_HEADER\", \"".str_replace("\"", "\\\"", $this->color_1_header->getValue())."\");\n";
				$data_config_file .= "define(\"DEFINE_STYLE_BCK_".$i."\", \"".str_replace("\"", "\\\"", $this->background_1->getValue())."\");\n";
				$data_config_file .= "define(\"DEFINE_STYLE_COLOR_".$i."\", \"".str_replace("\"", "\\\"", $this->color_1->getValue())."\");\n";
				$data_config_file .= "define(\"DEFINE_STYLE_COLOR_".$i."_LINK\", \"".str_replace("\"", "\\\"", $this->style1_color_link->getValue())."\");\n";
				$data_config_file .= "define(\"DEFINE_STYLE_COLOR_".$i."_LINK_HOVER\", \"".str_replace("\"", "\\\"", $this->style1_color_link_hover->getValue())."\");\n";
				$data_config_file .= "define(\"DEFINE_STYLE_BORDER_TABLE_".$i."\", \"".str_replace("\"", "\\\"", $this->border_table_1->getValue())."\");\n";
				$data_config_file .= "define(\"DEFINE_STYLE_COLOR_".$i."_HEADER_LINK\", \"".str_replace("\"", "\\\"", $this->style1_header_link->getValue())."\");\n";
				$data_config_file .= "define(\"DEFINE_STYLE_COLOR_".$i."_HEADER_LINK_HOVER\", \"".str_replace("\"", "\\\"", $this->style1_header_link_hover->getValue())."\");\n";
				$data_config_file .= "define(\"DEFINE_STYLE_GRADIENT_".$i."\", ".($this->style_gradient->isChecked()?"true":"false").");\n";
				$data_config_file .= "define(\"DEFINE_STYLE_OMBRE_COLOR_".$i."\", \"".str_replace("\"", "\\\"", $this->color_shadow->getValue())."\");\n";
			} else {
				$data_config_file .= "define(\"DEFINE_STYLE_BCK_".$i."_HEADER\", \"".(defined("DEFINE_STYLE_BCK_".$i."_HEADER")?constant("DEFINE_STYLE_BCK_".$i."_HEADER"):"#000000")."\"); // If DEFINE_STYLE_BCK_PICTURE_1 is defined, DEFINE_STYLE_BCK_1_HEADER not use for Box object\n";
				$data_config_file .= "define(\"DEFINE_STYLE_BCK_PICTURE_".$i."\", \"".(defined("DEFINE_STYLE_BCK_PICTURE_".$i)?constant("DEFINE_STYLE_BCK_PICTURE_".$i):"")."\"); // ex : ../wsp/img/round_bgd/round_bgd.png (please use the default file wsp/img/round_bgd/round_bgd.png to create your own background)\n";
				$data_config_file .= "define(\"DEFINE_STYLE_COLOR_".$i."_HEADER\", \"".(defined("DEFINE_STYLE_COLOR_".$i."_HEADER")?constant("DEFINE_STYLE_COLOR_".$i."_HEADER"):"#BFBFBF")."\");\n";
				$data_config_file .= "define(\"DEFINE_STYLE_BCK_".$i."\", \"".(defined("DEFINE_STYLE_BCK_".$i)?constant("DEFINE_STYLE_BCK_".$i):"#FFFFFF")."\");\n";
				$data_config_file .= "define(\"DEFINE_STYLE_COLOR_".$i."\", \"".(defined("DEFINE_STYLE_COLOR_".$i)?constant("DEFINE_STYLE_COLOR_".$i):"#000000")."\");\n";
				$data_config_file .= "define(\"DEFINE_STYLE_COLOR_".$i."_LINK\", \"".(defined("DEFINE_STYLE_COLOR_".$i."_LINK")?constant("DEFINE_STYLE_COLOR_".$i."_LINK"):"#4D4D4D")."\");\n";
				$data_config_file .= "define(\"DEFINE_STYLE_COLOR_".$i."_LINK_HOVER\", \"".(defined("")?constant(""):"")."\");\n";
				$data_config_file .= "define(\"DEFINE_STYLE_BORDER_TABLE_".$i."\", \"".(defined("DEFINE_STYLE_BORDER_TABLE_".$i)?constant("DEFINE_STYLE_BORDER_TABLE_".$i):"#000000")."\");\n";
				$data_config_file .= "define(\"DEFINE_STYLE_COLOR_".$i."_HEADER_LINK\", \"".(defined("DEFINE_STYLE_COLOR_".$i."_HEADER_LINK")?constant("DEFINE_STYLE_COLOR_".$i."_HEADER_LINK"):"#C2C2C2")."\");\n";
				$data_config_file .= "define(\"DEFINE_STYLE_COLOR_".$i."_HEADER_LINK_HOVER\", \"".(defined("DEFINE_STYLE_COLOR_".$i."_HEADER_LINK_HOVER")?constant("DEFINE_STYLE_COLOR_".$i."_HEADER_LINK_HOVER"):"")."\");\n";
				$data_config_file .= "define(\"DEFINE_STYLE_GRADIENT_".$i."\", ".(defined("DEFINE_STYLE_GRADIENT_".$i)?(constant("DEFINE_STYLE_GRADIENT_".$i)?"true":"false"):"false").");\n";
				$data_config_file .= "define(\"DEFINE_STYLE_OMBRE_COLOR_".$i."\", \"".(defined("DEFINE_STYLE_OMBRE_COLOR_".$i)?constant("DEFINE_STYLE_OMBRE_COLOR_".$i):"#000000")."\");\n";
			}
			$data_config_file .= "\n";
		}
		$data_config_file .= "define(\"DEFINE_STYLE_JQUERY\", \"".str_replace("\"", "\\\"", $this->style_jquery->getValue())."\");	// ex: redmond, smoothness, start, flick\n";
		$data_config_file .= "									// complete list : http://www.socialblogr.com/2010/08/how-to-change-jquiery-ui-themes.html\n";
		$data_config_file .= "\n";
		$data_config_file .= "// Define the default font\n";
		$data_config_file .= "define(\"DEFINE_STYLE_FONT\", \"".str_replace("\"", "\\\"", $this->style_font->getValue())."\"); 	// You can use default font (Arial, Times New Roman, Verdana) and Google font (http://code.google.com/webfonts)\n";
		$data_config_file .= "								// List of google web font : Cantarell, Cardo, Crimson Text, Droid Sans, Droid Sans Mono, Droid Serif, IM Fell, Inconsolata, Josefin Sans Std Light, Lobster, Molengo, Nobile, OFL Sorts Mill Goudy TT, Old Standard TT, Reenie Beanie, Tangerine, Vollkorn, Yanone Kaffeesatz.\n";
		$data_config_file .= "define(\"DEFINE_STYLE_FONT_SIZE\", \"".str_replace("\"", "\\\"", $this->style_font_size->getValue())."pt\"); // ex: 12pt, 10pt (defautl), 8pt\n";
		$data_config_file .= "define(\"DEFINE_STYLE_FONT_SERIF\", \"".str_replace("\"", "\\\"", $this->style_font_serif->getValue())."\"); // ex: serif, sans serif (default), monospace\n";
        $data_config_file .= "\n";
        $data_config_file .= "define(\"DEFINE_STYLE_COLOR_UPLOAD_PROGRESS_BAR\", \"".str_replace("\"", "\\\"", $this->style_upload_progress_bar->getValue())."\");\n";
		$data_config_file .= "define(\"DEFINE_STYLE_BACKCOLOR_SCROLL_TO_TOP\", \"".str_replace("\"", "\\\"", $this->style_scroll_to_top->getValue())."\");\n";
        $data_config_file .= "?>\n";
		
		$config_file = new File(dirname(__FILE__)."/../../../wsp/config/config_css.inc.php", false, true);
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
	
	public function createExamples($ind) {
		$table_box = new Table();
		$table_box->setWidth(250)->setDefaultAlign(RowTable::ALIGN_LEFT);
		
		$table_box->addRow();
		
		$body_obj = new Object();
		$body_obj->setAlign(Object::ALIGN_CENTER);
		//->setId("id_body_obj")->setStyle("padding:5px;background:".$this->background_body->getValue().";");
		
		$text_obj = new Object(__(TEXT_ON_BODY));
		$body_obj->add($text_obj->setId("id_body_text"), "<br/>");
		
		$link_obj = new Object(new Link("javascript:void(0);", Link::TARGET_BLANK, __(LINK_ON_BODY)));
		$body_obj->add($link_obj->setId("id_body_link"), "<br/>");
		
		$body_obj->add($this->text_link_note_obj, "<br/>");
		
		$table_box->addRow($body_obj);
		
		$table_box->addRow();
		$table_box->addRow();
		
		$button_1 = new Button($this);
		$button_1->setWidth(245);
		$table_box->addRow($button_1->setValue("Button [style jquery]"));
		
		$table_box->addRow();
		
		$tabs = new Tabs("tab-sample");
		$tabs->addTab("Tab1", "");
		$tabs->addTab("Tab2", "");
		$tabs->addTab("Tab3", "");
		$table_box->addRow($tabs);
		
		$table_box->addRow();
		$table_box->addRow();
		$table_box->addRow();
		$table_box->addRow();
		$table_box->addRow();
		
		$dialogbox = new DialogBox(__(DIALOGBOX_TITLE), __(DIALOGBOX_CONTENT));
		$dialogbox->setWidth(245)->activateOneInstance()->setPosition("");
		$dialogbox_link = new Object(new Link($dialogbox, Link::TARGET_NONE, __(VIEW_DIALOGBOX)));
		$table_box->addRow($dialogbox_link->setId("id_dialogbox_link"));
		$dialogbox->setPositionX("$('#".$dialogbox_link->getId()."').position().left-f_scrollLeft()");
		$dialogbox->setPositionY("$('#".$dialogbox_link->getId()."').position().top-f_scrollTop()-70");
		$this->addObject(clone $dialogbox);
		
		$table_box->addRow();
		$table_box->addRow();
		$table_box->addRow();
		$table_box->addRow();
		$table_box->addRow();
		$table_box->addRow();
		
		$style1_box_text = new Box("text", false, $this->current_style_val, $this->current_style_val, "", "box_text_".$this->current_style_val, 245);
		if ($this->background_picture_1->getValue() != "") {
			$style1_box_text->forceBoxWithPicture(true, $this->border_table_1->getValue());
		} else {
			$style1_box_text->forceBoxWithPicture(false);
		}
		$table_box->addRow($style1_box_text->setContent("Box Object [<a href=\"javascript:void(0);\">style ".$this->current_style_val."</a>]"));
		
		$style1_box = new Box("link", false, $this->current_style_val, $this->current_style_val, "javascript:void(0);", "box_".$this->current_style_val, 245);
		if ($this->background_picture_1->getValue() != "") {
			$style1_box->forceBoxWithPicture(true, $this->border_table_1->getValue());
		} else {
			$style1_box->forceBoxWithPicture(false);
		}
		$style1_box->setShadow(true);
		$table_box->addRow($style1_box->setContent("Box Object [<a href=\"javascript:void(0);\">style ".$this->current_style_val."</a>]"));
		
		$style1_box = new RoundBox($this->current_style_val, "round_box_".$this->current_style_val, 245);
		$style1_box->setShadow(true);
		if ($this->background_picture_1->getValue() != "") {
			$style1_box->forceBoxWithPicture(true, $this->border_table_1->getValue());
		} else {
			$style1_box->forceBoxWithPicture(false);
		}
		$table_box->addRow($style1_box->setContent("RoundBox Object<br/>[style ".$this->current_style_val."]"));
		
		$table_box->addRow();
		
		if (!defined('DEFINE_STYLE_BORDER_TABLE_'.$this->current_style_val)) {
			define('DEFINE_STYLE_BORDER_TABLE_'.$this->current_style_val, $this->border_table_1->getValue());
		}
		
		$table = new Table();
		$table->setId("table_sample")->setWidth(245);
		$table->addRowColumns("header1", "header2", "header3")->setHeaderClass($this->current_style_val);
		$table->addRowColumns("cel 1-1", "cel 1-2", "cel 1-3")->setId("table_tr_sample")->setBorderPredefinedStyle($this->current_style_val)->setAlign(RowTable::ALIGN_CENTER);
		$table_box->addRow($table);
		
		return $table_box;
	}
	
	public function changeBackgroundBody($sender) {
		if ($this->bck_body_pic->getValue() == "") {
			$this->bck_body_pic_repeat->setValue("");
			$this->bck_body_pic_repeat->disable();
			$this->bck_body_pic_position->setValue("");
			$this->bck_body_pic_position->disable();
			$this->bck_body_pic_position_more->setValue("");
			$this->bck_body_pic_position_more->disable();
			
			$background = $this->background_body->getValue();
		} else {
			$this->bck_body_pic_repeat->enable();
			$this->bck_body_pic_position->enable();
			$this->bck_body_pic_position_more->enable();
			
			$body_pic = str_replace("../wsp/img/", $this->getBaseURL()."wsp/img/", $this->bck_body_pic->getValue());
			$body_pic = str_replace("../wsp/css/", $this->getBaseURL()."wsp/css/", $body_pic);
			$body_pic = str_replace("../img/", $this->getBaseURL()."img/", $body_pic);
			
			$this->addObject(new JavaScript("$('#backstretch').remove();"));
			if ($this->bck_body_pic_position->getValue() == "stretch") {
				$this->bck_body_pic_position_more->setValue("");
				$background = $this->background_body->getValue();
				$this->addObject(new JavaScript("$.backstretch(\"".$body_pic."\");"));
				
				$this->bck_body_pic_repeat->setValue("");
				$this->bck_body_pic_repeat->disable();
				$this->bck_body_pic_position_more->setValue("");
				$this->bck_body_pic_position_more->disable();
			} else {
				$background .= $this->background_body->getValue()." ";
				$background .= "url(".$body_pic.") ";
				if ($this->bck_body_pic_repeat->getValue() != "") {
					$background .= $this->bck_body_pic_repeat->getValue()." ";
				}
				if ($this->bck_body_pic_position->getValue() != "") {
					$background .= $this->bck_body_pic_position->getValue()." ";
				}
				if ($this->bck_body_pic_position_more->getValue() != "") {
					$pic_pos_more = "";
					$tmp_array = split(' ', $this->bck_body_pic_position->getValue());
					if (sizeof($tmp_array) <= 1) {
						$tmp_array = split(' ', $this->bck_body_pic_position_more->getValue());
						for ($i=0; $i < sizeof($tmp_array); $i++) {
							if (is_numeric($tmp_array[$i])) {
								$pic_pos_more .= $tmp_array[$i]."px ";
							} else {
								if (is_numeric(trim(str_replace("px", "", str_replace("%", "", $tmp_array[$i]))))) {
									$pic_pos_more .= $tmp_array[$i]." ";
								}
							}
						}
					}
					$this->bck_body_pic_position_more->setValue(trim($pic_pos_more));
					$background .= $this->bck_body_pic_position_more->getValue()." ";
				}
				$background = trim($background);
			}
		}
		$this->addObject(new JavaScript("changeStyleSheetProperty('".$this->file_style_css."', 'body', 'background', '".addslashes($background)."');"));
		//$this->addObject(new JavaScript("$('#wsp_object_id_body_obj').css('background', '".$this->background_body->getValue()."');"));
	}
	
	public function changeColorBody($sender) {
		$this->addObject(new JavaScript("changeStyleSheetProperty('".$this->file_style_css."', 'body', 'color', '".addslashes($this->color_body->getValue())."');"));
		$this->addObject(new JavaScript("$('#wsp_object_id_body_text').css('color', '".$this->color_body->getValue()."');"));
		$this->addObject(new JavaScript("$('#wsp_object_id_body_note').css('color', '".$this->color_body->getValue()."');"));
	}
	
	public function changeLinkColor($sender) {
		$array_link_color = array('a,.link', 'a:hover,.link:hover');
		$this->changeStyleSheetProperty($this->file_style_css, $array_link_color, "color", $this->link_color->getValue());
		$this->addObject(new JavaScript("$('#wsp_object_id_body_link').find('a').css('color', '".$this->link_color->getValue()."');"));
		$this->addObject(new JavaScript("$('#wsp_object_id_body_link').find('a').mouseout(function() { $('#wsp_object_id_body_link').find('a').css('color', '".$this->link_color->getValue()."'); } );"));
		
		$this->changeLinkHoverColor($sender);
	}
	
	public function changeLinkHoverColor($sender) {
		$this->addObject(new JavaScript("changeStyleSheetProperty('".$this->file_style_css."', 'a:hover,.link:hover', 'color', '".addslashes($this->link_hover_color->getValue())."');"));
		$this->addObject(new JavaScript("$('#wsp_object_id_body_link').find('a').mouseover(function() { $('#wsp_object_id_body_link').find('a').css('color', '".$this->link_hover_color->getValue()."'); } );"));
		
		$this->change1HeaderLink($sender);
		$this->change1ColorLink($sender);
	}
	
	public function changeStyleJquery($sender) {
		$this->addObject(new JavaScript("loadDynamicCSS('".$this->getBaseURL()."wsp/css/jquery".$this->jquery_version."/".$this->style_jquery->getValue()."/jquery-ui-".$this->jquery_version.".custom.css');"));
	}
	
	public function changeBackgroundPicture1($sender) {
		$this->example_obj->emptyObject();
		$this->example_obj->add($this->createExamples());
		if ($this->background_picture_1->getValue() != "") {
			$this->color_shadow->disable();
			$this->color_shadow->forceEmptyValue();
		} else {
			$this->color_shadow->enable();
		}
		$this->changeBackground1Header();
	}
	
	public function changeBackground1Header($sender) {
		$this->changeStyleSheetProperty($this->file_angle_css, $this->array_round_box_1, "background", $this->background_1_header->getValue());
		$this->changeStyleSheetProperty($this->file_style_css, array(".bckg_".$this->current_style_val, ".header_".$this->current_style_val."_bckg", ".table_".$this->current_style_val."_round"), "background", $this->background_1_header->getValue());
		
		$this->changeStyleSheetProperty($this->file_angle_css, array('#top'.$this->current_style_val), "background", $this->background_1_header->getValue()." url(".BASE_URL.$this->background_picture_1->getValue().") no-repeat top right");
		$this->changeStyleSheetProperty($this->file_angle_css, array('#top'.$this->current_style_val.' div'), "background", $this->background_1_header->getValue()." url(".BASE_URL.$this->background_picture_1->getValue().") no-repeat top left");
		$this->changeStyleSheetProperty($this->file_angle_css, array('#left'.$this->current_style_val), "background", $this->background_1_header->getValue()." url(".BASE_URL.$this->background_picture_1->getValue().") no-repeat bottom left");
		$this->changeStyleSheetProperty($this->file_angle_css, array('#right'.$this->current_style_val), "background", $this->background_1_header->getValue()." url(".BASE_URL.$this->background_picture_1->getValue().") no-repeat bottom right");
		$this->changeStyleSheetProperty($this->file_angle_css, array('.Css3RadiusBoxTitle'.$this->current_style_val), "background", $this->background_1_header->getValue());
		$this->changeBoxBackgroundGradient();
	}
	
	
	private function changeBoxBackgroundGradient() {
		if ($this->isCss3Browser()) {
			if ($this->getBrowserName() == "Firefox") {
				$this->changeStyleSheetProperty($this->file_angle_css, array('.Css3GradientBoxTitle'.$this->current_style_val), "background", "-moz-linear-gradient(90deg, ".$this->background_1_header->getValue()." 70%, ".$this->border_table_1->getValue()." 100%);");
			} else if ($this->getBrowserName() == "Chrome") {
				$this->changeStyleSheetProperty($this->file_angle_css, array('.Css3GradientBoxTitle'.$this->current_style_val), "background-image", "-webkit-gradient(linear, left bottom, left top, color-stop(0.7,".$this->background_1_header->getValue()."), color-stop(1,".$this->border_table_1->getValue()."));");
			} else {
				$this->changeStyleSheetProperty($this->file_angle_css, array('.Css3GradientBoxTitle'.$this->current_style_val), "background", "-webkit-gradient(linear, left top, left bottom, from(".$this->background_1_header->getValue()."), to(".$this->border_table_1->getValue()."));");
				$this->changeStyleSheetProperty($this->file_angle_css, array('.Css3GradientBoxTitle'.$this->current_style_val), "background-image", "-webkit-gradient(linear, left bottom, left top, color-stop(0.7,".$this->background_1_header->getValue()."), color-stop(1,".$this->border_table_1->getValue()."));");
				$this->changeStyleSheetProperty($this->file_angle_css, array('.Css3GradientBoxTitle'.$this->current_style_val), "filter", "progid:DXImageTransform.Microsoft.gradient(enabled='true',startColorstr=".$this->background_1_header->getValue().",endColorstr=".$this->border_table_1->getValue().",GradientType=0); zoom: 1;", false);
			}
		}
	}
	
	public function changeColor1Header($sender) {
		if ($this->color_1_header->getValue() == "") {
			$this->addObject(new DialogBox(__(ERROR), "Color header can't be empty"));
		} else {
			$array_color_1_header = array('.header_'.$this->current_style_val.'_bckg', '.header_'.$this->current_style_val.'_bckg_a a', '.header_'.$this->current_style_val.'_bckg_a a:hover');
			$this->changeStyleSheetProperty($this->file_style_css, $array_color_1_header, "color", $this->color_1_header->getValue());
			$this->changeStyleSheetProperty($this->file_angle_css, array('#left'.$this->current_style_val), "color", $this->color_1_header->getValue());
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
			$array_color_1_header_link = array('.header_'.$this->current_style_val.'_bckg_a a', '.table_'.$this->current_style_val.'_bckg a, a.box_style_'.$this->current_style_val.':link', '.header_'.$this->current_style_val.'_bckg_a a:hover');
		} else {
			$array_color_1_header_link = array('.header_'.$this->current_style_val.'_bckg_a a', '.table_'.$this->current_style_val.'_bckg a, a.box_style_'.$this->current_style_val.':link');
		}
		if ($this->style1_header_link->getValue() == "") {
			$this->changeStyleSheetProperty($this->file_style_css, $array_color_1_header_link, "color", $this->color_1_header->getValue());
		} else {
			$this->changeStyleSheetProperty($this->file_style_css, $array_color_1_header_link, "color", $this->style1_header_link->getValue());
		}
		$this->change1HeaderLinkHover($sender);
	}
	
	public function change1HeaderLinkHover($sender) {
		if ($this->style1_header_link_hover->getValue() != "") {
			$this->changeStyleSheetProperty($this->file_style_css, array('.header_'.$this->current_style_val.'_bckg_a a:hover'), "color", $this->style1_header_link_hover->getValue());
		}
	}
	
	public function changeBackground1($sender) {
		if ($this->color_1->getValue() == "") {
			$this->addObject(new DialogBox(__(ERROR), "Background can't be empty"));
		} else {
			$array_background_color_1 = array('.table_'.$this->current_style_val.'_angle', '.table_'.$this->current_style_val, '.table_'.$this->current_style_val.'_bckg', '.bckg_'.$this->current_style_val);
			$this->changeStyleSheetProperty($this->file_style_css, $array_background_color_1, "background", $this->background_1->getValue());
			$this->addObject(new JavaScript("$('#wsp_rowtable_table_tr_sample').find('td').css('background', '".$this->background_1->getValue()."');\n"));
		}
	}
	
	public function changeColor1($sender) {
		if ($this->color_1->getValue() == "") {
			$this->addObject(new DialogBox(__(ERROR), "Color can't be empty"));
		} else {
			$array_color_1 = array('.table_'.$this->current_style_val.'_angle', '.table_'.$this->current_style_val, '.table_'.$this->current_style_val.'_bckg', '.bckg_'.$this->current_style_val);
			$this->changeStyleSheetProperty($this->file_style_css, $array_color_1, "color", $this->color_1->getValue());
			$this->addObject(new JavaScript("$('#wsp_rowtable_table_tr_sample').find('td').css('color', '".$this->color_1->getValue()."');\n"));
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
			$array_color_1_link = array('.table_'.$this->current_style_val.'_bckg a,a.box_style_'.$this->current_style_val.':link', '.table_'.$this->current_style_val.'_bckg a:hover,a.box_style_'.$this->current_style_val.':hover');
		} else {
			$array_color_1_link = array('.table_'.$this->current_style_val.'_bckg a,a.box_style_'.$this->current_style_val.':link');
		}
		if ($this->style1_color_link->getValue() == "") {
			$this->changeStyleSheetProperty($this->file_style_css, $array_color_1_link, "color", $this->link_color->getValue());
		} else {
			$this->changeStyleSheetProperty($this->file_style_css, $array_color_1_link, "color", $this->style1_color_link->getValue());
		}
		$this->change1ColorLinkHover($sender);
	}
	
	public function change1ColorLinkHover($sender) {
		if ($this->style1_color_link_hover->getValue() != "") {
			$this->changeStyleSheetProperty($this->file_style_css, array('.table_'.$this->current_style_val.'_bckg a:hover,a.box_style_'.$this->current_style_val.':hover'), "color", $this->style1_color_link_hover->getValue());
		}
	}
	
	public function changeBorderTable1($sender) {
		$array_round_box_border_1 = array('.pix1'.$this->current_style_val, '.pix1'.$this->current_style_val.'Ombre');
		$this->changeStyleSheetProperty($this->file_angle_css, $this->array_round_box_1, "border-left", "1px solid ".$this->border_table_1->getValue());
		$this->changeStyleSheetProperty($this->file_angle_css, $this->array_round_box_1, "border-right", "1px solid ".$this->border_table_1->getValue());
		$this->changeStyleSheetProperty($this->file_angle_css, $array_round_box_border_1, "background", $this->border_table_1->getValue());
		$this->changeStyleSheetProperty($this->file_angle_css, array('.Css3RadiusBox'.$this->current_style_val, '.Css3RadiusRoundBox'.$this->current_style_val), "border-top", "1px solid ".$this->border_table_1->getValue());
		$this->changeStyleSheetProperty($this->file_angle_css, array('.Css3RadiusRoundBox'.$this->current_style_val), "border-bottom", "1px solid ".$this->border_table_1->getValue());
		$this->changeBoxBackgroundGradient();
		
		if ($this->background_picture_1->getValue() != "") {
			$this->addObject(new JavaScript("$('#wsp_box_content_box_".$this->current_style_val."').css('border', '1px solid ".$this->border_table_1->getValue()."');\n"));
			$this->addObject(new JavaScript("$('#wsp_box_content_box_text_".$this->current_style_val."').css('border', '1px solid ".$this->border_table_1->getValue()."');\n"));
		}
		
		$array_box_border_1 = array('.table_'.$this->current_style_val.'_angle');
		$this->changeStyleSheetProperty($this->file_style_css, $array_box_border_1, "border-left", "1px solid ".$this->border_table_1->getValue());
		$this->changeStyleSheetProperty($this->file_style_css, $array_box_border_1, "border-right", "1px solid ".$this->border_table_1->getValue());
		$this->changeStyleSheetProperty($this->file_style_css, $array_box_border_1, "border-bottom", "1px solid ".$this->border_table_1->getValue());
		
		$this->addObject(new JavaScript("$('#box_".$this->current_style_val."').find('td').css('border-top', '1px solid ".$this->border_table_1->getValue()."');\n"));
		$this->addObject(new JavaScript("$('#box_text_".$this->current_style_val."').find('td').css('border-top', '1px solid ".$this->border_table_1->getValue()."');\n"));
		
		$this->addObject(new JavaScript("$('#table_sample').find('td').css('border', '1px solid ".$this->border_table_1->getValue()."');\n"));
	}
	
	public function changeColorShadow($sender) {
		if ($this->isCss3Browser()) {
			$this->addObject(new JavaScript("changeStyleSheetProperty('".$this->file_angle_css."', '.Css3ShadowBox".$this->current_style_val."', 'box-shadow', '5px 5px 5px ".addslashes($this->color_shadow->getValue())."');"));
		} else {
			$this->addObject(new JavaScript("changeStyleSheetProperty('".$this->file_angle_css."', '.ombre".$this->current_style_val."', 'background-color', '".addslashes($this->color_shadow->getValue())."');"));
		}
	}
	
	public function changeStyleFont($sender) {
		$this->addObject(new JavaScript("loadDynamicCSS('http://fonts.googleapis.com/css?family=".str_replace(" ", "+", $this->style_font->getValue())."');"));
		$new_font = "".$this->style_font->getValue()."";
		if ($this->style_font->getValue() != "Arial") {
			$new_font .= ", Arial";
		}
		$new_font .= ", ".$this->style_font_serif->getValue();
		$this->changeStyleSheetProperty($this->file_style_css, $this->array_font, "font-family", $new_font);
		$this->refreshDialogBoxPosition();
	}
	
	public function changeStyleFontSize($sender) {
		if ($this->style_font_size->getValue() == "") {
			$this->style_font_size->setValue(10);
		}
		$this->changeStyleSheetProperty($this->file_style_css, $this->array_font, "font-size", $this->style_font_size->getValue()."pt");
		$this->refreshDialogBoxPosition();
	}
	
	private function refreshDialogBoxPosition() {
		$this->addObject(new JavaScript("wspDialogBox2.dialog('option', 'position', [$('#wsp_object_id_dialogbox_link').position().left-f_scrollLeft(),$('#wsp_object_id_dialogbox_link').position().top-f_scrollTop()-70]);"));
	}
	
	public function changeNbDefineStyleBck($sender) {
		$this->current_style_display->setListItemsChange();
	}
	
	public function changeCurrentStyleBck($sender) {
		$this->css_config_obj->add(); // tips to refresh all object
		$style_val_init = $this->current_style_val;
		
		$this->background_picture_1->setValue(str_replace("../img/", "img/", str_replace("../wsp/img/", "wsp/img/", constant("DEFINE_STYLE_BCK_PICTURE_".$style_val_init))));
		$this->background_1_header->setValue(constant("DEFINE_STYLE_BCK_".$style_val_init."_HEADER"));
		$this->border_table_1->setValue(constant("DEFINE_STYLE_BORDER_TABLE_".$style_val_init));
		$this->color_1_header->setValue(constant("DEFINE_STYLE_COLOR_".$style_val_init."_HEADER"));
		$this->style1_header_link->setValue(constant("DEFINE_STYLE_COLOR_".$style_val_init."_HEADER_LINK"));
		$this->style1_header_link_hover->setValue(constant("DEFINE_STYLE_COLOR_".$style_val_init."_HEADER_LINK_HOVER"));
		$this->background_1->setValue(constant("DEFINE_STYLE_BCK_".$style_val_init));
		$this->color_1->setValue(constant("DEFINE_STYLE_COLOR_".$style_val_init));
		$this->style1_color_link->setValue(constant("DEFINE_STYLE_COLOR_".$style_val_init."_LINK"));
		$this->style1_color_link_hover->setValue(constant("DEFINE_STYLE_COLOR_".$style_val_init."_LINK_HOVER"));
		$this->color_shadow->setValue(constant("DEFINE_STYLE_OMBRE_COLOR_".$style_val_init));
		
		$this->changeBackgroundPicture1();
	}
	
	public function changeGradient($sender) {
		if ($this->style_gradient->isChecked()) {
			
		}
	}
	
	private function changeStyleSheetProperty($css_file_name, $array_properties, $property, $value, $display_rule_error=true) {
		for ($i=0; $i < sizeof($array_properties); $i++) {
			if (is_browser_ie() && get_browser_ie_version() < 9) {
				$array_sub_properties = split(',', $array_properties[$i]);
			} else {
				$array_sub_properties = array($array_properties[$i]);
			}
			for ($j=0; $j < sizeof($array_sub_properties); $j++) {
				$this->addObject(new JavaScript("changeStyleSheetProperty('".$css_file_name."', '".$array_sub_properties[$j]."', '".$property."', '".addslashes($value)."', ".($display_rule_error?"true":"false").");"));
			}
		}
	}
}
?>
