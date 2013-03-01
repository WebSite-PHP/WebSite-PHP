<?php
require_once(dirname(__FILE__)."/../includes/admin-template-form.inc.php");

class ManagePages extends Page {
	protected $USER_RIGHTS = Page::RIGHTS_ADMINISTRATOR;
	protected $USER_NO_RIGHTS_REDIRECT = "wsp-admin/connect.html";
	
	public function Load() {
		parent::$PAGE_TITLE = __(MANAGE_PAGES);
		
		$content = new Object();
		
		$construction_page = new Object(__(PAGE_IN_CONSTRUCTION));
		$construction_page->setClass("warning");
		$content->add($construction_page);
		
		// Search all php files in the folder pages with the synstax "class * extends Page"
		$code_editor_table = new Table();
		$code_editor_table->setDefaultValign(RowTable::VALIGN_TOP);
		
		$form = new Form($this);
		
		$tree = new TreeView("wsp_files");
		$array_path = explode("/", SITE_DIRECTORY);
		$root = new TreeViewFolder($array_path[sizeof($array_path)-1]);
		$tree_page_items = new TreeViewItems();
		
		$dir = SITE_DIRECTORY."/pages/";
		$array_files = $this->loadFiles($dir);
		foreach ($array_files as $key => $value) {
			$tree_page_type = new TreeViewFolder($key);
			$tree_page_type->collapse();
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
				$file_link->setValue($file_name)->setIsLink();
				$file_link->onClick("loadFile", $file)->setAjaxEvent();
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
		$tree_obj->setAlign(Object::ALIGN_LEFT)->setWidth(250)->setMaxHeight(500)->setStyle("overflow:auto;");
		
		$this->code_editor = new TextArea($form);
		$this->code_editor->setWidth(600)->setHeight(500)->noWrap();
		$code_editor_table->addRowColumns($tree_obj, $this->code_editor);
		
		$this->btn_save = new Button($form);
		$this->btn_save->setValue(__(BTN_SAVE))->onClick("save")->setAjaxEvent();
		$code_editor_table->addRow($this->btn_save)->setColspan(2);
		$code_editor_table->addRow();
		
		$form->setContent($code_editor_table);
		
		// Create a link to the labels of this page
		// TODO
		
		$this->render = new AdminTemplateForm($this, $content->add($form));
		
		if (!$this->isAjaxPage()) {
			$this->loadFile(null, "home.php");
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
	
	public function loadFile($sender, $file) {
		$code = "";
		$dir = SITE_DIRECTORY."/pages/";
		if (is_file($dir.$file)) {
			$f = new File($dir.$file);
			$code = $f->read();
			$f->close();
		}
		$this->code_editor->setValue($code);
	}
	
	public function save($sender) {
		$dir = SITE_DIRECTORY."/pages/";
		if (is_file($dir.$this->cmb_files->getValue())) {
			$f = new File($dir.$this->cmb_files->getValue(), false, true);
			$code = $f->write($this->code_editor->getValue());
			$f->close();
		}
	}
}
?>
