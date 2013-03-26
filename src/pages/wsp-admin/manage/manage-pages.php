<?php
require_once(dirname(__FILE__)."/../includes/admin-template-form.inc.php");

class ManagePages extends Page {
	protected $USER_RIGHTS = array(Page::RIGHTS_ADMINISTRATOR, Page::RIGHTS_DEVELOPER);
	protected $USER_NO_RIGHTS_REDIRECT = "wsp-admin/admin.html";
	
	private $array_files_label = array();
	
	public function Load() {
		parent::$PAGE_TITLE = __(MANAGE_PAGES);
		
		$content = new Object();
		
		// Search all php files in the folder pages with the synstax "class * extends Page"
		$code_editor_table = new Table();
		$code_editor_table->setDefaultValign(RowTable::VALIGN_TOP);
		
		$form = new Form($this);
		$this->hdn_old_file = new Hidden($this);
		$content->add($this->hdn_old_file);
		
		$tree = new TreeView("wsp_files");
		$array_path = explode("/", $this->getRootWspDirectory());
		$root = new TreeViewFolder($array_path[sizeof($array_path)-1]);
		$tree_page_items = new TreeViewItems();
		
		$dir = $this->getRootWspDirectory()."/pages/";
		$array_files = $this->loadFiles($dir);
		foreach ($array_files as $key => $value) {
			$tree_page_type = new TreeViewFolder($key);
			if ($key == "Page classes") {
				$tree_page_type->expand();
			} else {
				$tree_page_type->collapse();
			}
			$tree_page_items->add($tree_page_type);
			$tree_items = new TreeViewItems();
			
			$array_folder = array();
			for ($i=0; $i < sizeof($value); $i++) {
				$file = $value[$i];
				$array_path = explode('/', $file);
				$file_name = $array_path[sizeof($array_path)-1];
				$array_path[sizeof($array_path)-1] = null;
				$folder = implode('/', $array_path);
				
				if ($folder == "") {
					$parent_tree_items = $tree_items;
				} else {
					if (isset($array_folder[$folder])) {
						$parent_tree_items = $array_folder[$folder];
					} else {
						$tree_folder = new TreeViewFolder($folder);
						$tree_folder->collapse();
						$tree_items->add($tree_folder);
						$parent_tree_items = new TreeViewItems();
						$tree_folder->setTreeViewItems($parent_tree_items);
						$array_folder[$folder] = $parent_tree_items;
					}
				}
				$file_link = new Button($this);
				$file_name_label = new Label($file_name);
				$file_name_label->setId("file_label_".str_replace("/", "_slashsep_", str_replace(".", "_", str_replace("-", "_", $file))));
				$this->array_files_label[$file] = $file_name_label;
				$file_link->setValue($file_name_label)->setIsLink();
				$file_link->onClick("loadFile", $file, $this->hdn_old_file)->setAjaxEvent();
				$tree_file = new TreeViewFile($file_link);
				$parent_tree_items->add($tree_file);
			}
			$tree_page_type->setTreeViewItems($tree_items);
		}
		$root->setTreeViewItems($tree_page_items);
		$root_items = new TreeViewItems();
		$root_items->add($root);
		$tree->setTreeViewItems($root_items);
		
		$tree_obj = new Object($tree);
		$tree_obj->setAlign(Object::ALIGN_LEFT)->setWidth(220)->setHeight(630)->setMaxHeight(630);
		
		$this->code_editor = new TextArea($form);
		$this->code_editor->setWidth(600)->setHeight(620)->allowTabulation()->activateSourceCodeEdit("php")->noWrap();
		$code_editor_table->addRowColumns($tree_obj, $this->code_editor);
		
		$this->btn_save = new Button($form);
		$this->btn_save->setValue(__(BTN_SAVE))->setAjaxEvent()->hide();
		$this->btn_save->forceSpanTag();
		
		if (Page::getInstance("wsp-admin/manage/manage-translations")->userHaveRights()) {
			$this->tranlate_links_obj = new Object(__(MANAGE_TRANSLATIONS).": ");
			$this->tranlate_links_obj->setId("tranlate_links_obj");
		}
		
		$code_editor_table->addRow(new Object($this->tranlate_links_obj, "&nbsp;", $this->btn_save))->setColspan(2);
		$code_editor_table->addRow();
		
		$form->setContent($code_editor_table);
		
		// Create a link to the labels of this page
		// TODO
		
		$this->render = new AdminTemplateForm($this, $content->add($form));
		
		if (isset($_GET['file'])) {
			$this->loadFile(null, $_GET['file'], "");
		} else if (!$this->isAjaxPage()) {
			$this->loadFile(null, "home.php", "");
		}
	}
	
	private function loadFiles($dir, $sub_dir='') {
		$array_files = array();
		$array_files["Page classes"] = array();
		$array_files["DefinedZone classes"] = array();
		
		$files = scandir($dir.$sub_dir, 0);
		for($i=0; $i < sizeof($files); $i++) {
			$file = $files[$i];
			if (is_file($dir.$sub_dir.$file) && substr($file, strlen($file)-4, strlen($file)) == ".php") {
				$is_page = false;
				$is_defined_zone = false;
				$f = new File($dir.$sub_dir.$file);
				while (($line = $f->read_line()) != false) {
					if (find($line, "class ") > 0 && 
						(find($line, " extends Page") > 0 || 
						find($line, " extends DefinedZone") > 0)) {
							$is_page = true;
							if (find($line, " extends DefinedZone") > 0) {
								$is_defined_zone = true;
							}
							break;
					}
				}
				$f->close();
				if ($is_page) {
					$key = "Page classes";
					if ($is_defined_zone) {
						$key = "DefinedZone classes";
					}
					$array_files[$key][] = $sub_dir.$file;
				}
			} else if (is_dir($dir.$sub_dir.$file) && $file != "." && $file != ".." && $file != ".svn") {
				$array_forbidden_folder = array("error", "wsp-admin");
				if (!in_array($sub_dir.$file, $array_forbidden_folder)) {
					$tmp_array_files = $this->loadFiles($dir, $sub_dir.$file."/");
					$array_files["Page classes"] = array_merge($array_files["Page classes"], $tmp_array_files["Page classes"]);
					$array_files["DefinedZone classes"] = array_merge($array_files["DefinedZone classes"], $tmp_array_files["DefinedZone classes"]);
				}
			}
		}
		return $array_files;
	}
	
	public function loadFile($sender, $file, $old_file) {
		if (isset($this->array_files_label[$old_file])) {
			$this->array_files_label[$old_file]->setColor(DEFINE_STYLE_LINK_COLOR);
		}
		if (isset($this->array_files_label[$file])) {
			$this->array_files_label[$file]->setColor("red");
		}
		$this->hdn_old_file->setValue($file);
		
		if ($this->tranlate_links_obj != null) {
			$is_translation = false;
			$dir = $this->getRootWspDirectory()."/lang/";
			$array_lang_dir = scandir($dir, 0);
			for ($i=0; $i < sizeof($array_lang_dir); $i++) {
				if (is_dir($dir.$array_lang_dir[$i]) && $array_lang_dir[$i] != "" && 
					$array_lang_dir[$i] != "." && $array_lang_dir[$i] != ".." && $array_lang_dir[$i] != ".svn" && 
					strlen($array_lang_dir[$i]) == 2) {
						$translation_file = str_replace(".php", ".inc.php", $file);
						if (file_exists($dir.$array_lang_dir[$i]."/".$translation_file)) {
							$lang_link = $this->getBaseLanguageURL()."wsp-admin/manage/manage-translations.html?language=".$array_lang_dir[$i]."&file=".$translation_file;
							$language_link = new Link($lang_link, Link::TARGET_NONE, new Picture("wsp/img/lang/".$array_lang_dir[$i].".png", 24, 24, 0, Picture::ALIGN_ABSMIDDLE));
							$this->tranlate_links_obj->add($language_link);
							$is_translation = true;
						}
				}
			}
			if (!$is_translation) {
				$this->tranlate_links_obj->emptyObject();
			}
		}
		
		$code = "";
		$dir = $this->getRootWspDirectory()."/pages/";
		if (is_file($dir.$file)) {
			$f = new File($dir.$file);
			$code = $f->read();
			$f->close();
		}
		$this->code_editor->setValue($code);
		$this->btn_save->onClick("save", $file)->show();
	}
	
	public function save($sender, $file) {
		$dir = $this->getRootWspDirectory()."/pages/";
		if (is_file($dir.$file)) {
			$f = new File($dir.$file, false, true);
			$code = $f->write($this->code_editor->getValue());
			$f->close();
			
			alert(__(FILE_SAVED, $file));
		}
	}
}
?>
