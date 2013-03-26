<?php
require_once(dirname(__FILE__)."/../includes/admin-template-form.inc.php");

class ManageTranslations extends Page {
	protected $USER_RIGHTS = array(Page::RIGHTS_ADMINISTRATOR, Page::RIGHTS_TRANSLATOR, Page::RIGHTS_DEVELOPER);
	protected $USER_NO_RIGHTS_REDIRECT = "wsp-admin/admin.html";
	
	private $array_files_label = array();
	private $array_lang_link = array();
	private $array_translation_input = array();
	private $array_translation_double_quote = array();
	private $array_translation_position = array();
	
	public function Load() {
		parent::$PAGE_TITLE = __(MANAGE_TRANSLATIONS);
		
		$content = new Object();
		
		// Search in all translation files the labels
		// Features :
		// - get the list of the labels for a page / language
		// - display for each label if there is a translation in all the language of the website
		// - enter a new label
		// - update a label
		// - delete a label
		
		$translate_table = new Table();
		$translate_table->setDefaultValign(RowTable::VALIGN_TOP);
		
		if (!isset($_GET['language'])) {
			$_GET['language'] = $this->getLanguage();
		}
		
		$this->form = new Form($this);
		$this->form->setAction($this->getCurrentURLWithoutParameters()."?language=".$_GET['language']);
		$this->hdn_old_file = new Hidden($this->form, "hdn_old_file");
		$content->add($this->hdn_old_file);
		
		$tree = new TreeView("wsp_lang_files");
		$array_path = explode("/", $this->getRootWspDirectory());
		$root = new TreeViewFolder($array_path[sizeof($array_path)-1]);
		$tree_page_items = new TreeViewItems();
		
		$dir = $this->getRootWspDirectory()."/lang/".$_GET['language']."/";
		$array_files = $this->loadFiles($dir, '', $_GET['language']);
		foreach ($array_files as $key => $value) {
			$tree_page_type = new TreeViewFolder($key);
			$tree_page_type->expand();
			$tree_page_items->add($tree_page_type);
			$tree_items = new TreeViewItems();
			
			$array_folder = array();
			for ($i=0; $i < sizeof($value); $i++) {
				$file = $value[$i];
				$expand = false;
				if ($file == $_GET['file']) {
					$expand = true;
				}
				$array_path = explode('/', $file);
				$file_name = $array_path[sizeof($array_path)-1];
				$array_path[sizeof($array_path)-1] = null;
				$folder = implode('/', $array_path);
				
				if ($folder == "") {
					$parent_tree_items = $tree_items;
				} else {
					if (isset($array_folder[$folder])) {
						$parent_tree_items = $array_folder[$folder];
						$tree_folder = $parent_tree_items->getTreeViewItemParent();
						if (!$tree_folder->isExpand()) {
							if ($expand) { $tree_folder->expand(); }  else { $tree_folder->collapse(); }
						}
					} else {
						$tree_folder = new TreeViewFolder($folder);
						if ($expand) { $tree_folder->expand(); }  else { $tree_folder->collapse(); }
						$tree_items->add($tree_folder);
						$parent_tree_items = new TreeViewItems();
						$tree_folder->setTreeViewItems($parent_tree_items);
						$array_folder[$folder] = $parent_tree_items;
					}
				}
				$file_link = new Button($this->form);
				$file_name_label = new Label($file_name);
				$file_name_label->setId("file_label_".str_replace("/", "_slashsep_", str_replace(".", "_", str_replace("-", "_", $file))));
				$this->array_files_label[$file] = $file_name_label;
				$file_link->setValue($file_name_label)->setIsLink();
				$file_link->onClick("loadTranslation", $file, $this->hdn_old_file, $_GET['language'], 1)->setAjaxEvent();
				$tree_file = new TreeViewFile($file_link);
				$parent_tree_items->add($tree_file);
			}
			$tree_page_type->setTreeViewItems($tree_items);
		}
		$root->setTreeViewItems($tree_page_items);
		$root_items = new TreeViewItems();
		$root_items->add($root);
		$tree->setTreeViewItems($root_items);
		
		$language_selector = new Object();
		$array_lang_dir = scandir($this->getRootWspDirectory()."/lang", 0);
		for ($i=0; $i < sizeof($array_lang_dir); $i++) {
			if (is_dir($this->getRootWspDirectory()."/lang/".$array_lang_dir[$i]) && $array_lang_dir[$i] != "" && 
				$array_lang_dir[$i] != "." && $array_lang_dir[$i] != ".." && $array_lang_dir[$i] != ".svn" && 
				strlen($array_lang_dir[$i]) == 2) {
					$lang_link = $this->getCurrentURLWithoutParameters()."?language=".$array_lang_dir[$i];
					$language_link = new Link($lang_link, Link::TARGET_NONE, new Picture("wsp/img/lang/".$array_lang_dir[$i].".png", 24, 24, 0, Picture::ALIGN_ABSMIDDLE));
					if ($array_lang_dir[$i] == $_GET['language']) {
						$language_link->setStyle("border:1px solid red;padding-bottom: 4px;");
					}
					$language_link->setId("lang_link_".$array_lang_dir[$i]);
					$this->array_lang_link[] = $language_link;
					$language_selector->add($language_link);
			}
		}
		
		$lang_tree_obj = new Object($language_selector, "<br/>");
		$tree_obj = new Object($tree);
		$tree_obj->setAlign(Object::ALIGN_LEFT)->setWidth(200)->setHeight(608)->setMaxHeight(608);
		$lang_tree_obj->add($tree_obj);
		
		// create translate area with all translation labels and sortable
		$this->translate_area = new Object();
		$this->translate_area->setWidth(600)->setHeight(620)->setStyle("border:1px solid gray;overflow:auto;padding:5px;");
		$this->translate_area->emptyObject()->setId("translate_area");
		$this->sort_label_event = new SortableEvent($this->form);
		$this->sort_label_event->onSort("onSort", "");
		$this->sort_label_event->setAjaxEvent()->disableAjaxWaitMessage();
		$this->translate_area->setSortable(true, $this->sort_label_event);
		$translate_table->addRowColumns($lang_tree_obj, $this->translate_area);
		
		$translate_table->addRow();
		
		$this->btn_save = new Button($this->form);
		$this->btn_save->setValue(__(BTN_SAVE))->onClick("save", "")->setAjaxEvent();
		$this->btn_save->forceSpanTag();
		
		if (Page::getInstance("wsp-admin/manage/manage-pages")->userHaveRights()) {
			$this->btn_page = new Button($this);
			$this->btn_page->setValue(__(BTN_PHP_PAGE))->forceSpanTag()->disable();
		}
		
		$this->btn_add_label = new Button($this);
		$this->btn_add_label->setValue(__(ADD_LABEL))->onClick("addLabel", "")->setAjaxEvent();
		$this->btn_add_label->forceSpanTag();
		
		$translate_table->addRow(new Object($this->btn_page, "&nbsp;", $this->btn_add_label, "&nbsp;", $this->btn_save))->setColspan(2);
		$translate_table->addRow();
		
		$this->form->setContent($translate_table);
		
		// Create a link to the page
		// TODO
		
		$this->render = new AdminTemplateForm($this, $content->add($this->form));
		
		if ($this->btn_save->isClicked() || $this->sort_label_event->isSorted() || $this->btn_add_label->isClicked()) {
			// do nothing, translation load is done by the callback function
		} else if (isset($_GET['file'])) {
			$this->loadTranslation(null, $_GET['file'], "", $_GET['language']);
			
			if (isset($_GET['saved'])) {
				alert(__(FILE_SAVED, $_GET['file']));
			}
		} else if (!$this->isAjaxPage()) {
			$this->loadTranslation(null, "all.inc.php", "", $_GET['language']);
		}
		
		// Create addLabel form
		$this->form_add_label = new Form($this);
		$this->form_add_label->setAction($this->getCurrentURLWithoutParameters()."?language=".$_GET['language']);
		$table_add_label = new Table();
		$this->add_label_label_name = new TextBox($this->form_add_label, "add_label_label_name");
		$this->add_label_label_name->setWidth(200);
		$table_add_label->addRowColumns(__(LABEL_NAME).":&nbsp;", $this->add_label_label_name);
		$this->add_label_label_value = new TextArea($this->form_add_label, "add_label_label_value");
		$this->add_label_label_value->setAutoHeight()->setWidth(200);
		$table_add_label->addRowColumns(__(LABEL_VALUE).":&nbsp;", $this->add_label_label_value);
		$this->btn_create_label = new Button($this->form_add_label, "btn_create_label");
		$this->btn_create_label->setValue(__(ADD_LABEL))->setAjaxEvent();
		$table_add_label->addRowColumns($this->btn_create_label)->setColspan(2)->setAlign(RowTable::ALIGN_CENTER);
		$this->form_add_label->setContent($table_add_label);
	}

	private function loadFiles($dir, $sub_dir='', $language) {
		$array_files = array();
		
		$files = scandir($dir.$sub_dir, 0);
		for($i=0; $i < sizeof($files); $i++) {
			$file = $files[$i];
			if (is_file($dir.$sub_dir.$file) && substr($file, strlen($file)-8, strlen($file)) == ".inc.php") {
				$array_forbidden_file = array("calendar.inc.php", "default.inc.php");
				if (!in_array($sub_dir.$file, $array_forbidden_file)) {
					$array_files[$language][] = $sub_dir.$file;
				}
			} else if (is_dir($dir.$sub_dir.$file) && $file != "." && $file != ".." && $file != ".svn") {
				$array_forbidden_folder = array("wsp-admin", "modules");
				if (!in_array($sub_dir.$file, $array_forbidden_folder)) {
					$tmp_array_files = $this->loadFiles($dir, $sub_dir.$file."/", $language);
					$array_files[$language] = array_merge($array_files[$language], $tmp_array_files[$language]);
				}
			}
		}
		return $array_files;
	}
	
	public function loadTranslation($sender, $file, $old_file, $language, $click_on_treeview=false) {
		if ($click_on_treeview || $sender == null) {
			$this->btn_save->onClick("save", $file);
			$this->btn_add_label->onClick("addLabel", $file);
			if (!$this->sort_label_event->isSorted()) {
				$this->sort_label_event->onSort("onSort", $file);
			}
		}
		
		if (isset($this->array_files_label[$old_file])) {
			$this->array_files_label[$old_file]->setColor(DEFINE_STYLE_LINK_COLOR);
		}
		if (isset($this->array_files_label[$file])) {
			$this->array_files_label[$file]->setColor("red");
		}
		$this->hdn_old_file->setValue($file);
		
		for ($i=0; $i < sizeof($this->array_lang_link); $i++) {
			$this->array_lang_link[$i]->setLink($this->array_lang_link[$i]->getLink()."&file=".$file);
		}
		
		$dir = $this->getRootWspDirectory()."/pages/";
		$page_file = str_replace(".inc.php", ".php", $file);
		if ($this->btn_page != null) {
			if (file_exists($dir.$page_file)) {
				$this->btn_page->onClickJs("location.href='".$this->getBaseLanguageURL()."wsp-admin/manage/manage-pages.html?file=".$page_file."'; return false;");
				$this->btn_page->enable();
			} else {
				$this->btn_page->disable();
			}
		}
				
		$translation_code = "";
		$dir = $this->getRootWspDirectory()."/lang/".$language."/";
		if (is_file($dir.$file)) {
			$f = new File($dir.$file);
			$translation_code = $f->read();
			$f->close();
		}
		
		if (!$this->btn_save->isClicked() && !$this->sort_label_event->isSorted() && !$this->btn_add_label->isClicked()) {
			$this->translate_area->emptyObject();
		}
		$array_label = explode('define(', $translation_code);
		for ($i=1; $i < sizeof($array_label); $i++) {
			$label = trim($array_label[$i]);
			$label_quote = $label[0];
			$sep_pos = find($label, ",");
			$label_name = str_replace($label_quote, "", substr($label, 0, $sep_pos-1));
			$label_value = substr($label, $sep_pos-1, strlen($label));
			
			$val_pos1 = find($label_value, "'");
			$val_pos2 = find($label_value, "\"");
			$val_pos = -1;
			if ($val_pos1 > 0) {
				$val_pos = $val_pos1;
				$quote = "'";
			}
			if ($val_pos2 > 0 && ($val_pos2 < $val_pos1 || $val_pos1 == 0)) {
				$val_pos = $val_pos2;
				$quote = "\"";
			}
			if ($val_pos != -1) {
				$label_value = substr($label_value, $val_pos, strrpos($label_value, $quote)-$val_pos);
				$this->array_translation_double_quote[$label_name] = ($quote == "\""? true: false);
			} else {
				continue;
			}
			
			$this->addDraggableTranslationEditor($label_name, $label_value);
		}
	}
	
	private function addDraggableTranslationEditor($label_name, $label_value) {
		$label_input = new TextArea($this->form);
		$label_input->setAutoHeight();
		$label_input->setValue(str_replace("\\'", "'", $label_value));
		$label_input->setName("TextArea_".$label_name)->setWidth(320);
			
		// Saved position of the label when dragged
		$hdn_label = new Hidden($this->form, "Hdn_Position_".$label_name);
		$hdn_label->setValue(sizeof($this->array_translation_position)+1);
		$this->array_translation_position[$label_name] = $hdn_label;
			
		// Create draggable label object
		$translate_obj = new Object();
		$translate_obj->setWidth(588)->setId("Draggable_".$label_name);
        	
		$pic_drag = new Picture("wsp/img/drag_arrow_16x16.png", 16, 16, 0, Picture::ALIGN_ABSMIDDLE);
		$pic_drag->setStyle("cursor:pointer;");
		$label_obj = new Object($pic_drag, $label_name.":&nbsp;");
		$label_obj->setWidth(250)->setStyle("float: left;");
			
		$translate_obj->add($label_obj, $hdn_label, $label_input);
		if (!$this->btn_save->isClicked() && !$this->sort_label_event->isSorted() && !$this->btn_add_label->isClicked()) {
			$this->translate_area->add($translate_obj);
		}
			
		$this->array_translation_input[$label_name] = $label_input;
	}
	
	public function save($sender, $file) {
		if ($file == "") {
			return;
		}
		
		if ($sender != null) {
			$this->loadTranslation($sender, $file, "", $_GET['language']);
		}
		
		$array_sorted_label = array();
		foreach ($this->array_translation_position as $label_name_other => $hdn_input) {
			$array_sorted_label[$hdn_input->getValue()-1] = $label_name_other;
		}
		
		$php_translation_code = "<?php\r\n";
		for ($i=0; $i < sizeof($array_sorted_label); $i++) {
			$label_name = $array_sorted_label[$i];
			if (isset($this->array_translation_input[$label_name])) {
				$label_input = $this->array_translation_input[$label_name];
				if ($this->array_translation_double_quote[$label_name]) { // if it was double quote change the backslashes
					$label_value = str_replace("\\\"", "\"", str_replace("'", "\\'", $label_input->getValue()));
				} else {
					$label_value = str_replace("'", "\\'", $label_input->getValue());
				}
				$php_translation_code .= "	define('".$label_name."', '".$label_value."');\r\n";
			}
		}
		$php_translation_code .= "?>";
		
		$dir = $this->getRootWspDirectory()."/lang/".$_GET['language']."/";
		if (is_file($dir.$file)) {
			$f = new File($dir.$file, false, true);
			$bool = $f->write($php_translation_code);
			$f->close();
			
			if ($bool) {
				$this->redirect($this->getCurrentURLWithoutParameters()."?language=".$_GET['language']."&file=".$file."&saved=true");
			}
		}
	}
	
	public function onSort($sender, $moved_object, $from_object, $to_object, $position, $old_position, $file) {
		if ($file == "") {
			return;
		}
		$this->loadTranslation($sender, $file, "", $_GET['language']);
		
		$label_name = str_replace("wsp_object_Draggable_", "", $moved_object);
		if (isset($this->array_translation_position[$label_name])) {
			$debug = "";
			foreach ($this->array_translation_position as $label_name_other => $hdn_input) {
				$hdn_val = $hdn_input->getValue();
				$old_hdn_val = $hdn_val;
				if ($hdn_val != $old_position) {
					if ($old_position > $position) {
						if ($hdn_val >= $position && $hdn_val < $old_position) {
							$hdn_val = $hdn_val + 1;
							$hdn_input->setValue($hdn_val)->forceAjaxRender();
						}
					} else if ($old_position < $position) {
						if ($hdn_val <= $position && $hdn_val > $old_position) {
							$hdn_val = $hdn_val - 1;
							$hdn_input->setValue($hdn_val)->forceAjaxRender();
						}
					}
				}
				//$debug .= "Move ".$label_name_other.": ".$old_hdn_val." -> ".$hdn_val."<br/>";
			}
			$this->array_translation_position[$label_name]->setValue($position)->forceAjaxRender();
			//alert($debug."Move ".$label_name.": ".$old_position." -> ".$position);
		}
	}
	
	public function addLabel($sender, $file) {
		$this->btn_create_label->onClick("createLabel", $file, $this->add_label_label_name, $this->add_label_label_value);
		$this->addObject(new DialogBox(__(ADD_LABEL), $this->form_add_label));
	}
	
	public function createLabel($sender, $file, $label_name, $label_value) {
		$this->addObject(DialogBox::closeAll());
		
		$label_name = strtoupper(str_replace("-", "_", url_rewrite_format($label_name)));
		
		$this->loadTranslation($sender, $file, "", $_GET['language']);
		$this->addDraggableTranslationEditor($label_name, $label_value);
		$this->save(null, $file);
	}
}
?>
