<?php
/**
 * PHP file wsp\class\display\advanced_object\treeview\TreeViewFolder.class.php
 * @package display
 * @subpackage advanced_object.treeview
 */
/**
 * Class TreeViewFolder
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

include_once("TreeViewItem.class.php");

class TreeViewFolder extends TreeViewItem {
	private $treeview_object = null;
	
	/**
	 * Constructor TreeViewFolder
	 * @param string $value folder node text
	 * @param string $path_folder path to the folder
	 */
	function __construct($value, $path_folder) {
		parent::__construct($value, '', false, $path_folder);
	}
	
	/**
	 * Method getLocalPath
	 * @access public
	 * @return string
	 * @since 1.0.35
	 */
	public function getLocalPath() {
		$path = $this->getPath();
		if ($this->treeview_object == null) {
			$this->treeview_object = $this->getTreeViewObject();
		}
		if ($this->treeview_object->isRootFolder()) {
			$path = substr($path, find($path, "/", 0, 0), strlen($path));
		}
		return str_replace("\\", "/", $this->treeview_object->getLoadedPath().$path);
	}
	
	/**
	 * Method addFolder
	 * @access public
	 * @param string $value new folder node text [default value: New Folder]
	 * @param ContextMenu $context_menu_object [default value: null]
	 * @param boolean $collapse [default value: true]
	 * @return mixed
	 * @since 1.0.35
	 */
	public function addFolder($value="New Folder", $context_menu_object=null, $collapse=true) {
		$path = $this->getLocalPath();
		
		if ($this->treeview_object == null) {
			$this->treeview_object = $this->getTreeViewObject();
		}
		$is_dir_ok = true;
		if ($this->treeview_object->isSynchronizeWithDir()) {
			if (!mkdir($path.$value."/")) {
				$is_dir_ok = false;
			}
		}
		
		if ($is_dir_ok) {
			$new_item = new TreeViewFolder($value, $path.$value."/");
			$this->addItem($new_item);
			if ($collapse) {
				$new_item->collapse();
			}
			if ($context_menu_object != null) {
				$this->treeview_object->setContextMenuOnTreeViewItem($context_menu_object, $new_item);
			}
			
			return $new_item;
		}
		return null;
	}
	
	/**
	 * Method addFile
	 * @access public
	 * @param string $value new file name [default value: New File]
	 * @param string $data data to set in the file if TreeView synchronized with directory
	 * @param string $link node link
	 * @param ContextMenu $context_menu_object [default value: null]
	 * @return mixed
	 * @since 1.0.35
	 */
	public function addFile($value="New File", $data='', $link='', $context_menu_object=null) {
		$file = null;
		$path = $this->getLocalPath();
		
		if ($this->treeview_object == null) {
			$this->treeview_object = $this->getTreeViewObject();
		}
		$is_file_ok = true;
		if ($this->treeview_object->isSynchronizeWithDir()) {
			if ($data == "") { $data  = " "; }
			$file = new File($path.$value);
			if ($file->write($data) == false) {
				$is_file_ok = false;
			}
		}
		
		if ($is_file_ok) {
			$new_item = new TreeViewFile($value, $path.$value, $link);
			$this->addItem($new_item);
			if ($context_menu_object != null) {
				$this->treeview_object->setContextMenuOnTreeViewItem($context_menu_object, $new_item);
			}
			if ($file != null) {
				$file->close();
			}
			return $new_item;
		}
		return null;
	}
	
	/**
	 * Method remove
	 * @access public
	 * @return mixed
	 * @since 1.0.59
	 */
	public function remove() {
		$path = $this->getLocalPath();
		
		if ($this->treeview_object == null) {
			$this->treeview_object = $this->getTreeViewObject();
		}
		$is_dir_ok = true;
		if ($this->treeview_object->isSynchronizeWithDir()) {
			if (is_dir($path)) {
				if (!$this->rrmdir($path)) {
					$is_dir_ok = false;
				}
			} else {
				$is_dir_ok = false;
			}
		}
		
		if ($is_dir_ok) {
			$this->removeItem();
		}
		return $is_file_ok;
	}
	
	/**
	 * Method rrmdir
	 * @access private
	 * @param string $dir 
	 * @return boolean
	 * @since 1.0.35
	 */
	private function rrmdir($dir) {
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir."/".$object) == "dir") $this->rrmdir($dir."/".$object); else unlink($dir."/".$object);
				}
			}
			reset($objects);
			return rmdir($dir);
		}
		return false;
	} 
	
	/**
	 * Method rename
	 * @access public
	 * @param string $value new folder name (rename real folder if synchronized)
	 * @since 1.0.59
	 */
	public function rename($value) {
		if (!$this->nodeValueAlreadyExists($value)) {
			$path = $this->getLocalPath();
		
			if ($this->treeview_object == null) {
				$this->treeview_object = $this->getTreeViewObject();
			}
			$is_dir_ok = true;
			if ($this->treeview_object->isSynchronizeWithDir()) {
				if (is_dir($path)) {
					if (!rename($path, str_replace("/".$this->getValue()."/", "/".$value."/", $path))) {
						$is_dir_ok = false;
					}
				} else {
					$is_dir_ok = false;
				}
			}
		
			if ($is_dir_ok) {
				$this->setValue($value);
			}
		}
	}
}
?>
