<?php
/**
 * Description of PHP file wsp\class\display\advanced_object\treeview\TreeViewItems.class.php
 * Class TreeViewItems
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

class TreeViewItems extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $treeview_items = array();
	private $parent_treeview_item = null;
	private $array_added_treeview_item = array();
	private $array_removed_treeview_item = array();
	/**#@-*/
	
	function __construct($treeview_item_object=null, $treeview_item_object2=null, $treeview_item_object3=null, $treeview_item_object4=null, $treeview_item_object5=null) {
		parent::__construct();
		
		$args = func_get_args();
		for ($i=0; $i < sizeof($args); $i++) {
    		if ($args[$i] != null) {
				$this->add($args[$i]);
    		}
    	}
	}
	
	public function add($treeview_item_object, $treeview_item_object2=null, $treeview_item_object3=null, $treeview_item_object4=null, $treeview_item_object5=null) {
		$add_noded = false;
		$args = func_get_args();
		$treeview_item_object = array_shift($args);
		if (get_class($treeview_item_object) != "TreeViewItem" && !is_subclass_of($treeview_item_object, "TreeViewItem")) {
			throw new NewException("Error TreeViewItems->add(): treeview_item_object is not a TreeViewItem object", 0, 8, __FILE__, __LINE__);
		}
		if (!$this->nodeValueAlreadyExists($treeview_item_object)) {
			if ($this->parent_treeview_item != null) { $treeview_item_object->setTreeViewItemParent($this->parent_treeview_item, sizeof($this->treeview_items)); }
			$this->treeview_items[] = $treeview_item_object;
			if ($GLOBALS['__PAGE_IS_INIT__']) { $this->array_added_treeview_item[] = $treeview_item_object; }
			$add_noded = true;
		}
		
    	for ($i=0; $i < sizeof($args); $i++) {
    		if ($args[$i] != null) {
				if (get_class($args[$i]) != "TreeViewItem") {
					throw new NewException("Error TreeViewItems->add(): treeview_item_object is not a TreeViewItem object", 0, 8, __FILE__, __LINE__);
				}
				if (!$this->nodeValueAlreadyExists($args[$i])) {
					if ($this->parent_treeview_item != null) { $args[$i]->setTreeViewItemParent($this->parent_treeview_item, sizeof($this->treeview_items)); }
					$this->treeview_items[] = $args[$i];
	    			if ($GLOBALS['__PAGE_IS_INIT__']) { $this->array_added_treeview_item[] = $args[$i]; }
	    			$add_noded = true;
				}
    		}
    	}
    	if ($add_noded) {
			if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
			TreeView::refreshAllIds();
    	}
    	return $this;
	}
	
	private function nodeValueAlreadyExists($treeview_item_object) {
		for ($i=0; $i < sizeof($this->treeview_items); $i++) {
			if ($this->treeview_items[$i]->getValue() == $treeview_item_object->getValue()) {
				return true;
			}
		}
		return false;
	}
	
	public function remove($indice) {
		if (isset($this->treeview_items[$indice])) {
			if ($GLOBALS['__PAGE_IS_INIT__']) { 
				$this->array_removed_treeview_item[] = $this->treeview_items[$indice];
				$this->object_change =true; 
			}
			$this->treeview_items[$indice] = null;
		}
    	return $this;
	}
	
	/* Intern management of TreeView */
	public function setTreeViewItemParent($treeview_item_object) {
		if (get_class($treeview_item_object) != "TreeViewItem" && get_class($treeview_item_object) != "TreeViewFolder" && 
			get_class($treeview_item_object) != "TreeViewFile" && get_class($treeview_item_object) != "TreeView") {
			throw new NewException("Error TreeViewItems->setTreeViewItemParent(): $treeview_items_object is not a TreeViewItem object", 0, 8, __FILE__, __LINE__);
		}
		$this->parent_treeview_item = $treeview_item_object;
		for ($i=0; $i < sizeof($this->treeview_items); $i++) {
			$this->treeview_items[$i]->setTreeViewItemParent($this->parent_treeview_item, $i);
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function getTreeViewItemArray() {
		return $this->treeview_items;
	}
	
	public function render($ajax_render=false) {
		$html = "";
		if ($this->parent_treeview_item != null) {
			$html .= "<ul";
			$html .= " id=\"".$this->parent_treeview_item->getId()."\"";
			if (get_class($this->parent_treeview_item) == "TreeView") {
				$html .= " class=\"filetree\"";
			}
			
			$html .= ">\n";
			for ($i=0; $i < sizeof($this->treeview_items); $i++) {
				if ($this->treeview_items[$i] != null) {
					$html .= $this->treeview_items[$i]->render(false);
				}
			}
			$html .= "</ul>\n";
			$this->object_change = false;
		}
		return $html;
	}
	
	/**
	 * function getAjaxRender
	 * @return string javascript code to update initial html with ajax call
	 */
	public function getAjaxRender() {
		$html = "";
		if ($this->object_change) {
			$treeview_object = $this->parent_treeview_item;
			while (get_class($treeview_object) != "TreeView") {
				if ($treeview_object == null) {
					return;
				}
				$treeview_object = $treeview_object->getParentTreeViewItem();
			}
			$treeview_object->generateTreeViewIds();
			
			for ($i=0; $i < sizeof($this->array_removed_treeview_item); $i++) {
				$html .= "$(\"#".$this->array_removed_treeview_item[$i]->getId()."_id\").parent(\"span\").parent(\"li\").remove();";
			}
			// current dir has no sub_folder or sub file
			if (sizeof($this->array_added_treeview_item) > 0) {
				if (sizeof($this->parent_treeview_item->getChildsTreeViewItemArray()) == sizeof($this->array_added_treeview_item)) {
					$html .= "$(\"#".$this->parent_treeview_item->getId()."_id\").parent(\"span\").parent(\"li\").html($(\"#".$this->parent_treeview_item->getId()."_id\").parent(\"span\").parent(\"li\").html() + \"<ul id=\\\"".$this->parent_treeview_item->getId()."\\\"></ul>\");";
				}
				for ($i=0; $i < sizeof($this->array_added_treeview_item); $i++) {
					$html .= "var new_treeview_node = $(\"".str_replace('"', '\"', str_replace("\n", "", str_replace("\r", "", $this->array_added_treeview_item[$i]->render(false))))."\").";
					$html .= "appendTo('#".$this->parent_treeview_item->getId()."');$('#".$treeview_object->getId()."').treeview({ add: new_treeview_node });";
				}
			}
			
			if ($html != "") {
				$html .= $treeview_object->getAjaxRender();
			}
		}
		return $html;
	}
}
?>
