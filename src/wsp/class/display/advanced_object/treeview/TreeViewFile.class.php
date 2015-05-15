<?php
/**
 * PHP file wsp\class\display\advanced_object\treeview\TreeViewFile.class.php
 * @package display
 * @subpackage advanced_object.treeview
 */
/**
 * Class TreeViewFile
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

class TreeViewFile extends TreeViewItem {
	/**
	 * Constructor TreeViewFile
	 * @param string $value file node text
	 * @param string $path_file path to the file
	 * @param string $link file node link
	 */
	function __construct($value, $path_file='', $link='') {
		parent::__construct($value, $link, true, $path_file);
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
		return $is_file_ok;
	} 
	
	/**
	 * Method rename
	 * @access public
	 * @param string $value new file node text
	 * @since 1.0.59
	 */
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
