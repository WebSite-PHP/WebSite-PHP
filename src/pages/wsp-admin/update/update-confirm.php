<?php
require_once(dirname(__FILE__)."/../../../lang/".$_SESSION['lang']."/wsp-admin/all.inc.php");

class UpdateConfirm extends Page {
	protected $USER_RIGHTS = "administrator";
	protected $USER_NO_RIGHTS_REDIRECT = "wsp-admin/connect.html";
	
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		$dialog_update = new DialogBox(__(UPDATE_FRAMEWORK), new Url($this->getBaseLanguageURL()."wsp-admin/update/update-framework.call?update=".$_GET['update']."&parent_dialog_level=".DialogBox::getCurrentDialogBoxLevel()));
		$dialog_update->displayFormURL()->modal();
		
		$button_yes = new Button($this);
		$button_yes->onClickJs($dialog_update->render())->setValue(__(UPDATE_FRAMEWORK_YES));
		
		$button_no = new Button($this);
		$button_no->onClickJs(DialogBox::closeAll())->setValue(__(UPDATE_FRAMEWORK_NO));
		
		$table_yes_no = new Table();
		$table_yes_no->addRowColumns($button_yes, "&nbsp;", $button_no);
		
		if ($_GET['update'] == "update-wsp") {
			$warning_lbl = new Label(__(UPDATE_FRAMEWORK_WSP_WARNING));
			$warning_lbl->setColor("red")->setItalic();
			$this->render = new Object(__(UPDATE_FRAMEWORK_CONFIRM, $_GET['text']), "<br/><br/>", $warning_lbl, "<br/><br/>", $table_yes_no);
		} else {
			$this->render = new Object(__(UPDATE_FRAMEWORK_CONFIRM, $_GET['text']), "<br/><br/>", $table_yes_no);
		}
		$this->render->setAlign(Object::ALIGN_CENTER);
	}
}
?>
