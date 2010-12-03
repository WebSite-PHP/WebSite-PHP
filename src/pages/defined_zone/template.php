<?php
class Template extends DefinedZone {
	function __construct($page_object, $content) {
		parent::__construct();
		
		$this->render = new Table();
		$this->render->setWidth("100%");
		$row_main_table = new RowTable(RowTable::ALIGN_CENTER);
		
		// Header
		$this->render->addRow(new Header());
		
		// Main
		$this->render->addRow($content);
		
		$this->render->addRow();
		
		$lang_box = new LanguageBox(true, Box::STYLE_MAIN, Box::STYLE_MAIN);
		$lang_box->setWidth(600);
		$lang_box->addLanguage("en");
		$lang_box->addLanguage("fr");
		$this->render->addRow($lang_box);
		
		// Footer
		$this->render->addRow(new Footer());
	}
}
?>