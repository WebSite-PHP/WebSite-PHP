<?php
/**
 * Description of PHP file wsp\class\display\advanced_object\treeview\TreeViewFile.class.php
 * Class TreeViewFile
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
 * @copyright   WebSite-PHP.com 22/10/2010
 *
 * @version     1.0.30
 * @access      public
 * @since       1.0.17
 */

include_once("TreeViewItem.class.php");

class TreeViewFile extends TreeViewItem {
	function __construct($value, $path_file='', $link='') {
		parent::__construct($value, $link, true, $path_file);
	}
	
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
	
	public function remove() {
		$path = $this->getLocalPath();
		
		if ($this->treeview_object == null) {
			$this->treeview_object = $this->getTreeViewObject();
		}
		$is_file_ok = true;
		if ($this->treeview_object->isSynchronizeWithDir()) {
			if (is_file($path)) {
				if (!unlink($path)) {
					$is_file_ok = false;
				}
			} else {
				$is_file_ok = false;
			}
		}
		
		if ($is_file_ok) {
			$this->removeItem();
		}
	} 
	
	public function rename($value) {
		if (!$this->nodeValueAlreadyExists($value)) {
			$path = $this->getLocalPath();
		
			if ($this->treeview_object == null) {
				$this->treeview_object = $this->getTreeViewObject();
			}
			$is_file_ok = true;
			if ($this->treeview_object->isSynchronizeWithDir()) {
				if (is_file($path)) {
					if (!rename($path, str_replace("/".$this->getValue(), "/".$value, $path))) {
						$is_file_ok = false;
					}
				} else {
					$is_file_ok = false;
				}
			}
		
			if ($is_file_ok) {
				$this->setValue($value);
			}
		}
	}
}
?>
