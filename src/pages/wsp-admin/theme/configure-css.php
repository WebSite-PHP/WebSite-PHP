<?php
require_once(dirname(__FILE__)."/../includes/admin-template-form.inc.php");

class ConfigureCss extends Page {
	protected $USER_RIGHTS = "administrator";
	
	private $background_body = null;
	private $color_body = null;
	private $link_color = null;
	private $link_hover_color = null;
	
	private $background_picture_main = null;
	private $background_main_header = null;
	private $color_main_header = null;
	private $background_main = null;
	private $color_main = null;
	private $border_table_main = null;
	private $main_header_link = null;
	private $main_header_link_hover = null;
	private $color_shadow = null;
	
	private $style_font = null;
	private $style_font_serif = null;
	private $style_font_size = null;
	
	private $example_obj = null;
	
	private $array_font = array('body', 'form', 'blockquote', 'p', 'h1', 'h2,h3,h4,h5,h6', 'a,.link', 'a:hover', '.table_main', '.table_main_bckg', '.main_bckg', '.header_main_bckg', '.header_main_bckg a', '.header_main_bckg a:hover', '.table_second', '.table_second_bckg', '.second_bckg', '.header_second_bckg', '.header_second_bckg a', '.header_second_bckg a:hover', 'td');
	private $array_round_box_main = array('.AngleRondMain', '.AngleRondMainOmbre');
	
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
		
		$this->background_picture_main = new ComboBox($form);
		$this->background_picture_main->addItem("", __(NO_PICTURE));
		if (DEFINE_STYLE_BCK_PICTURE_MAIN != "") {
			$this->background_picture_main->addItem(str_replace("../img/", "img/", DEFINE_STYLE_BCK_PICTURE_MAIN), DEFINE_STYLE_BCK_PICTURE_MAIN." (".__(CURRENT).")", true);
		}
		if ($handle = opendir(dirname(__FILE__)."/../../../wsp/img/round_bgd/")) {
			while (false !== ($file = readdir($handle))) {
				if (is_file(dirname(__FILE__)."/../../../wsp/img/round_bgd/".$file)) {
					$this->background_picture_main->addItem("wsp/img/round_bgd/".$file, $file, (DEFINE_STYLE_BCK_PICTURE_MAIN=="img/round_bgd/".$file?true:false));
				}
			}
			closedir($handle);
		}
		$this->background_picture_main->onChange("changeBackgroundPictureMain")->setAjaxEvent()->disableAjaxWaitMessage();
		$table_form->addRowColumns(__(CMB_BCK_PICTURE_MAIN).":&nbsp;", $this->background_picture_main->setWidth(200));
		
		$this->background_main_header = new ColorPicker($form);
		$this->background_main_header->setValue(DEFINE_STYLE_BCK_MAIN_HEADER)->hash(true)->setWidth(200);
		$this->background_main_header->disableAjaxWaitMessage()->onChange("changeBackgroundMainHeader")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_BCK_MAIN_HEADER).":&nbsp;", $this->background_main_header);
		
		$this->color_main_header = new ColorPicker($form);
		$this->color_main_header->setValue(DEFINE_STYLE_COLOR_MAIN_HEADER)->hash(true)->required(false)->setWidth(200);
		$this->color_main_header->disableAjaxWaitMessage()->onChange("changeColorMainHeader")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_COLOR_MAIN_HEADER).":&nbsp;", $this->color_main_header);
		
		$this->background_main = new ColorPicker($form);
		$this->background_main->setValue(DEFINE_STYLE_BCK_MAIN)->hash(true)->setWidth(200);
		$this->background_main->disableAjaxWaitMessage()->onChange("changeBackgroundMain")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_BCK_MAIN).":&nbsp;", $this->background_main);
		
		$this->color_main = new ColorPicker($form);
		$this->color_main->setValue(DEFINE_STYLE_COLOR_MAIN)->hash(true)->setWidth(200);
		$this->color_main->disableAjaxWaitMessage()->onChange("changeColorMain")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_COLOR_MAIN).":&nbsp;", $this->color_main);
		
		$this->border_table_main = new ColorPicker($form);
		$this->border_table_main->setValue(DEFINE_STYLE_BORDER_TABLE_MAIN)->hash(true)->setWidth(200);
		$this->border_table_main->disableAjaxWaitMessage()->onChange("changeBorderTableMain")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_BCK_BORDER_TABLE_MAIN).":&nbsp;", $this->border_table_main);
		
		$this->main_header_link = new ColorPicker($form);
		$this->main_header_link->setValue(DEFINE_STYLE_COLOR_MAIN_HEADER_LINK)->hash(true)->required(false)->setWidth(200);
		if ($this->color_main_header->getValue() != "") {
			$this->main_header_link->forceEmptyValue();
		}
		$this->main_header_link->disableAjaxWaitMessage()->onChange("changeMainHeaderLink")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_COLOR_MAIN_HEADER_LINK).":&nbsp;", $this->main_header_link);
		
		$this->main_header_link_hover = new ColorPicker($form);
		$this->main_header_link_hover->setValue(DEFINE_STYLE_COLOR_MAIN_HEADER_LINK_HOVER)->hash(true)->required(false)->setWidth(200);
		if ($this->main_header_link->getValue() == "") {
			$this->main_header_link_hover->disable();
			$this->main_header_link_hover->forceEmptyValue();
		}
		$this->main_header_link_hover->disableAjaxWaitMessage()->onChange("changeMainHeaderLinkHover")->setAjaxEvent();
		$table_form->addRowColumns(__(EDT_COLOR_MAIN_HEADER_LINK_HOVER).":&nbsp;", $this->main_header_link_hover);
		
		$table_form->addRow();
		
		$this->color_shadow = new ColorPicker($form);
		if (DEFINE_STYLE_BCK_PICTURE_MAIN != "" && DEFINE_STYLE_BCK_PICTURE_SECOND != "") {
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
		
		$main_box = new Box("link", false, Box::STYLE_MAIN, Box::STYLE_MAIN, BASE_URL, "box_main", 200);
		if ($this->background_picture_main->getValue() != "") {
			$main_box->forceBoxWithPicture(true, $this->border_table_main->getValue());
		} else {
			$main_box->forceBoxWithPicture(false);
		}
		$main_box->setDraggable(true)->setShadow(true);
		$table_box->addRow($main_box->setContent("Box Object [style main]"));
		
		$main_box = new RoundBox(Box::STYLE_MAIN, "round_box_main", 200);
		$main_box->setDraggable(true)->setShadow(true);
		if ($this->background_picture_main->getValue() != "") {
			$main_box->forceBoxWithPicture(true, $this->border_table_main->getValue());
		} else {
			$main_box->forceBoxWithPicture(false);
		}
		$table_box->addRow($main_box->setContent("RoundBox Object<br/>[style main]"));
		
		$table_box->addRow();
		
		$second_box = new Box("link", false, Box::STYLE_SECOND, Box::STYLE_SECOND, BASE_URL, "box_second", 200);
		$second_box->setDraggable(true);
		$table_box->addRow($second_box->setContent("Box Object [style second]"));
		
		$second_box = new RoundBox(Box::STYLE_SECOND, "round_box_second", 200);
		$second_box->setDraggable(true);
		$table_box->addRow($second_box->setContent("RoundBox Object<br/>[style second]"));
		
		$table_box->addRow();
		
		$button_main = new Button($this);
		$table_box->addRow($button_main->setValue("Button [style jquery]"));
		
		return $table_box;
	}
	
	public function changeBackgroundBody($sender) {
		$this->addObject(new JavaScript("changeStyleSheetProperty('styles.php.css', 'body', 'background-color', '".addslashes($this->background_body->getValue())."');"));
	}
	
	public function changeColorBody($sender) {
		$this->addObject(new JavaScript("changeStyleSheetProperty('styles.php.css', 'body', 'color', '".addslashes($this->color_body->getValue())."');"));
	}
	
	public function changeLinkColor($sender) {
		$array_link_color = array('a,.link', 'a:hover');
		$this->changeStyleSheetProperty("styles.php.css", $array_link_color, "color", $this->link_color->getValue());
	}
	
	public function changeLinkHoverColor($sender) {
		$this->addObject(new JavaScript("changeStyleSheetProperty('styles.php.css', 'a:hover', 'color', '".addslashes($this->link_hover_color->getValue())."');"));
	}
	
	public function changeBackgroundPictureMain($sender) {
		$this->example_obj->emptyObject();
		$this->example_obj->add($this->createExamples());
		if ($this->background_picture_main->getValue() != "") {
			$this->color_shadow->disable();
		} else {
			$this->color_shadow->enable();
		}
		$this->changeBackgroundMainHeader();
	}
	
	public function changeBackgroundMainHeader($sender) {
		$this->changeStyleSheetProperty("angle.php.css", $this->array_round_box_main, "background", $this->background_main_header->getValue());
		$this->changeStyleSheetProperty("styles.php.css", array(".main_bckg", ".header_main_bckg", ".table_main_round"), "background", $this->background_main_header->getValue());
		
		$this->changeStyleSheetProperty("angle.php.css", array('#topMain'), "background", $this->background_main_header->getValue()." url(".BASE_URL.$this->background_picture_main->getValue().") no-repeat top right");
		$this->changeStyleSheetProperty("angle.php.css", array('#topMain div'), "background", $this->background_main_header->getValue()." url(".BASE_URL.$this->background_picture_main->getValue().") no-repeat top left");
		$this->changeStyleSheetProperty("angle.php.css", array('#leftMain'), "background", $this->background_main_header->getValue()." url(".BASE_URL.$this->background_picture_main->getValue().") no-repeat bottom left");
		$this->changeStyleSheetProperty("angle.php.css", array('#rightMain'), "background", $this->background_main_header->getValue()." url(".BASE_URL.$this->background_picture_main->getValue().") no-repeat bottom right");
	}
	
	public function changeColorMainHeader($sender) {
		$this->main_header_link->setValue("");
		$this->main_header_link_hover->setValue("");
		$this->main_header_link_hover->disable();
		
		$array_color_main_header = array('.header_main_bckg', '.header_main_bckg a', '.header_main_bckg a:hover');
		$this->changeStyleSheetProperty("styles.php.css", $array_color_main_header, "color", $this->color_main_header->getValue());
		$this->changeStyleSheetProperty("angle.php.css", array('#leftMain'), "color", $this->color_main_header->getValue());
	}
	
	public function changeBackgroundMain($sender) {
		$array_background_color_main = array('.table_main_angle', '.table_main', '.table_main_bckg', '.main_bckg');
		$this->changeStyleSheetProperty("styles.php.css", $array_background_color_main, "background", $this->background_main->getValue());
	}
	
	public function changeColorMain($sender) {
		$array_color_main = array('.table_main_angle', '.table_main', '.table_main_bckg', '.main_bckg');
		$this->changeStyleSheetProperty("styles.php.css", $array_color_main, "color", $this->color_main->getValue());
	}
	
	public function changeBorderTableMain($sender) {
		$array_round_box_border_main = array('.pix1Main', '.pix1MainOmbre');
		$this->changeStyleSheetProperty("angle.php.css", $this->array_round_box_main, "border-left", "1px solid ".$this->border_table_main->getValue());
		$this->changeStyleSheetProperty("angle.php.css", $this->array_round_box_main, "border-right", "1px solid ".$this->border_table_main->getValue());
		$this->changeStyleSheetProperty("angle.php.css", $array_round_box_border_main, "background", $this->border_table_main->getValue());
		
		if ($this->background_picture_main->getValue() != "") {
			$this->addObject(new JavaScript("$('#wsp_box_content_box_main').css('border', '1px solid ".$this->border_table_main->getValue()."');\n"));
		}
		
		$array_box_border_main = array('.table_main_angle');
		$this->changeStyleSheetProperty("styles.php.css", $array_box_border_main, "border-left", "1px solid ".$this->border_table_main->getValue());
		$this->changeStyleSheetProperty("styles.php.css", $array_box_border_main, "border-right", "1px solid ".$this->border_table_main->getValue());
		$this->changeStyleSheetProperty("styles.php.css", $array_box_border_main, "border-bottom", "1px solid ".$this->border_table_main->getValue());
	}
	
	public function changeMainHeaderLink($sender) {
		$this->main_header_link_hover->enable();
		if ($this->main_header_link_hover->getValue() == "") {
			$array_color_main_header_link = array('.header_main_bckg a', '.header_main_bckg a:hover');
		} else {
			$array_color_main_header_link = array('.header_main_bckg a');
		}
		$this->changeStyleSheetProperty("styles.php.css", $array_color_main_header_link, "color", $this->main_header_link->getValue());
	}
	
	public function changeMainHeaderLinkHover($sender) {
		$array_color_main_header_link_hover = array('.header_main_bckg a:hover');
		$this->changeStyleSheetProperty("styles.php.css", $array_color_main_header_link_hover, "color", $this->main_header_link_hover->getValue());
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