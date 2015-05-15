<?php
/**
 * PHP file wsp\class\display\advanced_object\treeview\TreeView.class.php
 * @package display
 * @subpackage advanced_object.treeview
 */
/**
 * Class TreeView
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object.treeview
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.17
 */

class TreeView extends WebSitePhpObject {
	private static $refresh_all_ids = false;
	
	/**#@+
	* @access private
	*/
	private $treeview_items = null;
	
	private $context_menu_root = null;
	private $context_menu_file = null;
	private $context_menu_folder = null;
	private $context_menu_item = array();
	
	private $load_from_path = "";
	private $is_root_dir = false;
	private $synchronize_dir = false;
	/**#@-*/
	
	/**
	 * Constructor TreeView
	 * @param string $id 
	 */
	function __construct($id) {
		parent::__construct();
		
		if (!isset($id)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, getDebugBacktrace(1));
		}
		
		$this->id = $id;
		
		$this->addCss(BASE_URL."wsp/css/jquery.treeview.css", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/jquery.treeview.min.js", "", true);
	}
	
	/**
	 * Method setTreeViewItems
	 * @access public
	 * @param TreeViewItems $treeview_items_object 
	 * @return TreeView
	 * @since 1.0.35
	 */
	public function setTreeViewItems($treeview_items_object) {
		if (get_class($treeview_items_object) != "TreeViewItems") {
			throw new NewException("Error TreeViewItem->setTreeViewItems(): $treeview_items_object is not a TreeViewItems object", 0, getDebugBacktrace(1));
		}
		$this->treeview_items = $treeview_items_object;
		$treeview_items_object->setTreeViewItemParent($this);
		return $this;
	}
	
	/**
	 * Method generateTreeViewIds
	 * @access public
	 * @since 1.0.59
	 */
	public function generateTreeViewIds() {
		if (self::$refresh_all_ids) {
			$this->generateTreeViewItemId($this->treeview_items->getTreeViewItemArray(), $this->id);
			self::$refresh_all_ids = false;
		}
	}
	
	/**
	 * Method generateTreeViewItemId
	 * @access private
	 * @param TreeviewItems $treeview_items 
	 * @param string $parent_id 
	 * @since 1.0.59
	 */
	private function generateTreeViewItemId($treeview_items, $parent_id) {
		for ($i=0; $i < sizeof($treeview_items); $i++) {
			if ($treeview_items[$i] != null) {
				$treeview_items[$i]->setPrefixId($parent_id);
				if ($treeview_items[$i]->getTreeViewItemsObject() != null) {
					$this->generateTreeViewItemId($treeview_items[$i]->getTreeViewItemsObject()->getTreeViewItemArray(), $treeview_items[$i]->getId());
				}
			}
		}
	}
	
	/* Intern management of TreeView */
	/**
	 * Method refreshAllIds
	 * @access static
	 * @since 1.0.59
	 */
	public static function refreshAllIds() {
		self::$refresh_all_ids = true;
	}
	
	/**
	 * Method loadFromPath
	 * @access public
	 * @param string $path path to the folder to load
	 * @param string|Link|DialogBox $link_file_template template when click a TreeViewFile : new DialogBox('open file', 'open file {#file}');
	 * @param string $root_dir_name name of the root directory
	 * @return TreeView
	 * @since 1.0.35
	 */
	public function loadFromPath($path, $link_file_template='', $root_dir_name='') {
		$this->load_from_path = $path;
		$this->is_root_dir = ($root_dir_name!="")?true:false;
		$this->synchronize_dir = true;
		if ($root_dir_name != "") {
			$root_folder = new TreeViewFolder($root_dir_name);
			$this->setTreeViewItems(new TreeViewItems($root_folder));
		} else {
			$root_folder = $this;
		}
		$this->createFolderNode($path, $root_folder, $link_file_template);
		$this->generateTreeViewIds();
		return $this;
	}
	
	/**
	 * Method createFolderNode
	 * @access private
	 * @param string $path 
	 * @param TreeViewFolder $treeview_folder 
	 * @param string $link_file_template 
	 * @since 1.0.59
	 */
	private function createFolderNode($path, $treeview_folder, $link_file_template) {
		$treeview_items = null;
		$nb_file = 0;
		if (is_dir($path)) {
			$treeview_items = new TreeViewItems();
		    $files = scandir($path); 
			for($i=0; $i < sizeof($files); $i++) {
				$file = $files[$i];
		    	if ($file == "." || $file == ".." || $file == ".svn") {
		    		continue;
		    	}
		    	if (is_dir($path.$file)) {
		    		$treeview_sub_folder = new TreeViewFolder($file, $path.$file."/");
		    		$treeview_sub_folder->collapse();
		    		$treeview_items->add($treeview_sub_folder);
		    		$this->createFolderNode($path.$file."/", $treeview_sub_folder, $link_file_template);
		    	} else {
		    		$treeview_items->add(new TreeViewFile($file, $path.$file, $link_file_template));
		    	}
		    	$nb_file++;
		    }
		}
		if ($treeview_items != null && $nb_file > 0) {
			$treeview_folder->setTreeViewItems($treeview_items);
		}
	}
	
	/**
	 * Method synchronizeWithDir
	 * @access public
	 * @return TreeView
	 * @since 1.0.35
	 */
	public function synchronizeWithDir() {
		$this->synchronize_dir = true;
		return $this;
	}
	
	/**
	 * Method unSynchronizeWithDir
	 * @access public
	 * @return TreeView
	 * @since 1.0.35
	 */
	public function unSynchronizeWithDir() {
		$this->synchronize_dir = false;
		return $this;
	}
	
	/**
	 * Method isSynchronizeWithDir
	 * @access public
	 * @return boolean
	 * @since 1.0.35
	 */
	public function isSynchronizeWithDir() {
		return $this->synchronize_dir;
	}
	
	/**
	 * Method setContextMenuRoot
	 * @access public
	 * @param ContextMenu $context_menu_object 
	 * @return TreeView
	 * @since 1.0.35
	 */
	public function setContextMenuRoot($context_menu_object) {
		if (get_class($context_menu_object) != "ContextMenu") {
			throw new NewException("Error TreeView->setContextMenuRoot(): $context_menu_object is not a ContextMenu object", 0, getDebugBacktrace(1));
		}
		$this->context_menu_root = $context_menu_object;
		$this->context_menu_root->attachContextMenuToObjectId("$(\"#".$this->id." LI .folder A\")");
		return $this;
	}
	
	/**
	 * Method setContextMenuFile
	 * @access public
	 * @param ContextMenu $context_menu_object 
	 * @return TreeView
	 * @since 1.0.35
	 */
	public function setContextMenuFile($context_menu_object) {
		if (get_class($context_menu_object) != "ContextMenu") {
			throw new NewException("Error TreeView->setContextMenuFile(): $context_menu_object is not a ContextMenu object", 0, getDebugBacktrace(1));
		}
		$this->context_menu_file = $context_menu_object;
		$this->context_menu_file->attachContextMenuToObjectId("$(\"#".$this->id." LI UL LI .file A\")");
		return $this;
	}
	
	/**
	 * Method setContextMenuFolder
	 * @access public
	 * @param ContextMenu $context_menu_object 
	 * @return TreeView
	 * @since 1.0.35
	 */
	public function setContextMenuFolder($context_menu_object) {
		if (get_class($context_menu_object) != "ContextMenu") {
			throw new NewException("Error TreeView->setContextMenuFolder(): $context_menu_object is not a ContextMenu object", 0, getDebugBacktrace(1));
		}
		$this->context_menu_folder = $context_menu_object;
		$this->context_menu_folder->attachContextMenuToObjectId("$(\"#".$this->id." LI UL LI .folder A\")");
		return $this;
	}
	
	/**
	 * Method setContextMenuOnTreeViewItem
	 * @access public
	 * @param ContextMenu $context_menu_object 
	 * @param TreeViewItem|TreeViewFolder|TreeViewFile|TreeView $treeview_item_object 
	 * @return TreeView
	 * @since 1.0.35
	 */
	public function setContextMenuOnTreeViewItem($context_menu_object, $treeview_item_object) {
		if (get_class($context_menu_object) != "ContextMenu") {
			throw new NewException("Error TreeView->setContextMenuOnTreeViewItem(): $context_menu_object is not a ContextMenu object", 0, getDebugBacktrace(1));
		}
		if (get_class($treeview_item_object) != "TreeViewItem" && get_class($treeview_item_object) != "TreeViewFolder" && 
			get_class($treeview_item_object) != "TreeViewFile"  && get_class($treeview_item_object) != "TreeView") {
			throw new NewException("Error TreeView->setContextMenuOnTreeViewItem(): $treeview_item_object is not a TreeViewItem object", 0, getDebugBacktrace(1));
		}
		if ($treeview_item_object->getParentTreeViewItem() == null) {
			throw new NewException("Error TreeView->setContextMenuOnTreeViewItem(): you must associate object ".get_class($treeview_item_object)." to an other TreeViewItem before setting the ContextMenu", 0, getDebugBacktrace(1));
		}
		$this->generateTreeViewIds();
		$this->context_menu_item[$treeview_item_object->getId()] = $context_menu_object;
		return $this;
	}
	
	/**
	 * Method createContextMenu
	 * @access private
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of TreeView ContextMenu
	 * @since 1.0.35
	 */
	private function createContextMenu($ajax_render=false) {
		$html = "";
		if ($this->context_menu_root != null) {
			$html .= $this->context_menu_root->render($ajax_render);
		}
		
		if ($this->context_menu_file != null) {
			$html .= $this->context_menu_file->render($ajax_render);
		}
		
		if ($this->context_menu_folder != null) {
			$html .= $this->context_menu_folder->render($ajax_render);
		}
		
		foreach ($this->context_menu_item as $id => $context_menu_item) {
			if ($context_menu_item != null) {
				$context_menu_item->attachContextMenuToObjectId("$(\"#".$id."_id\")");
				$html .= $context_menu_item->render($ajax_render);
			}
		}
		return $html;
	}
	
	/**
	 * Method getLoadedPath
	 * @access public
	 * @return string
	 * @since 1.0.35
	 */
	public function getLoadedPath() {
		return $this->load_from_path;
	}
	
	/**
	 * Method isRootFolder
	 * @access public
	 * @return boolean
	 * @since 1.0.35
	 */
	public function isRootFolder() {
		return $this->is_root_dir;
	}
	
	/**
	 * Method getId
	 * @access public
	 * @return string
	 * @since 1.0.35
	 */
	public function getId() {
		return $this->id;
	}
	
	/* Intern management of TreeView */
	/**
	 * Method getTreeViewItemsObject
	 * @access public
	 * @return TreeViewItems
	 * @since 1.0.35
	 */
	public function getTreeViewItemsObject() {
		return $this->treeview_items;
	}
	
	/**
	 * Method getChildsTreeViewItemArray
	 * @access public
	 * @return array
	 * @since 1.0.35
	 */
	public function getChildsTreeViewItemArray() {
		return ($this->treeview_items == null)?array():$this->treeview_items->getTreeViewItemArray();
	}
	
	/**
	 * Method searchTreeViewItemId
	 * @access public
	 * @param string $id 
	 * @return TreeViewItem
	 * @since 1.0.35
	 */
	public function searchTreeViewItemId($id) {
		if (substr($id, strlen($id)-3, strlen($id)) == "_id") {
			$id = substr($id, 0, strlen($id)-3);
		}
		$this->generateTreeViewIds();
		return $this->searchNodeId($this, $id);
	}
	
	/**
	 * Method searchNodeId
	 * @access private
	 * @param TreeViewItem $treeview_item 
	 * @param string $id 
	 * @return TreeViewItem
	 * @since 1.0.35
	 */
	private function searchNodeId($treeview_item, $id) {
		if ($treeview_item != null) {
			if ($treeview_item->getId() == $id) {
				return $treeview_item;
			} else if ($treeview_item->getTreeViewItemsObject() != null) {
				$node_treeview_items = $treeview_item->getTreeViewItemsObject()->getTreeViewItemArray();
				for ($i=0; $i < sizeof($node_treeview_items); $i++) {
					$search_item = $this->searchNodeId($node_treeview_items[$i], $id);
					if ($search_item != null) {
						return $search_item;
					}
				}
			}
		}
		return null;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object TreeView
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$html = "";
		if ($this->treeview_items != null) {
			if (!$ajax_render) {
				$this->generateTreeViewIds();
				$html .= $this->treeview_items->render($ajax_render, $this);
				$html .= $this->getJavascriptTagOpen();
			}
			$html .= "	$(document).ready(function(){\n";
			$html .= "		$('#".$this->id."').treeview();\n";
			$html .= "	});\n";
			if (!$ajax_render) {
				$html .= $this->getJavascriptTagClose();
				$html .= $this->createContextMenu();
			}
		}
		return $html;
	}
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html of object TreeView (call with AJAX)
	 * @since 1.0.35
	 */
	public function getAjaxRender() {
		$html = str_replace("\n", "", str_replace("\r", "", $this->createContextMenu(true)));
		return $html;
	}
}
?>
