<?php
/**
 * Class TreeViewFile
 * 
 * Instance of a new TreeViewFile.
 * @access public
 * @author Emilien MOREL <admin@website-php.com>
 * @link http://www.website-php.com
 * @copyright website-php.com 23/08/2010
 * @version 1.0
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
