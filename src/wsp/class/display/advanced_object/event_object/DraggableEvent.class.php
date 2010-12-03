<?php
class DraggableEvent extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $draggable_object = null;
	private $draggable_id = "";
	
	private $ondragstart = "";
	private $ondragend = "";
	/**#@-*/
	
	function __construct($page_object) {
		parent::__construct();
		
		if (!isset($page_object) || gettype($page_object) != "object" || !is_subclass_of($page_object, "Page")) {
			throw new NewException("Argument page_object for ".get_class($this)."::__construct() error", 0, 8, __FILE__, __LINE__);
		}
		
		$this->page_object = $page_object;
		$this->name = $this->page_object->createObjectName($this);
		$this->id = $name;
	}
	
	public function getOnDragStartJs() {
		return $this->ondragstart;
	}
	
	public function onDragStartJs($js_function) {
		$this->ondragstart = trim($js_function);
		return $this;
	}
	
	public function getOnDragEndJs() {
		return $this->ondragend;
	}
	
	public function onDragEndJs($js_function) {
		$this->ondragend = trim($js_function);
		return $this;
	}
	
	/* Intern management of DraggableEvent */
	public function setDraggableId($id) {
		$this->draggable_id = $id;
	}
	
	public function getDraggableId() {
		return $this->draggable_id;
	}
	
	public function render($ajax_render=false) {
		if (DialogBox::getCurrentDialogBoxLevel() > -1) {
			$this->ondragstart  = "wspDialogBox".DialogBox::getCurrentDialogBoxLevel().".dialog('widget').css('overflow', 'visible'); wspDialogBox".DialogBox::getCurrentDialogBoxLevel().".dialog('widget').find('.ui-dialog-content').css('overflow', 'visible');".$this->ondragstart;
			$this->ondragend  = "wspDialogBox".DialogBox::getCurrentDialogBoxLevel().".dialog('widget').css('overflow', 'hidden'); wspDialogBox".DialogBox::getCurrentDialogBoxLevel().".dialog('widget').find('.ui-dialog-content').css('overflow', 'hidden');".$this->ondragend;
		} else if (isset($_GET['tabs_object_id'])) {
			$this->ondragstart  = "$('#".$_GET['tabs_object_id']."').tabs().css('overflow', 'visible');$('#".$_GET['tabs_object_id']."').tabs().find('.ui-widget-content').css('overflow', 'visible');".$this->ondragstart;
			$this->ondragend  = "$('#".$_GET['tabs_object_id']."').tabs().css('overflow', 'hidden');$('#".$_GET['tabs_object_id']."').tabs().find('.ui-widget-content').css('overflow', 'hidden');".$this->ondragend;
		}
		
		if ($this->ondragstart != "") {
			$this->page_object->addObject(new JavaScript("$('#".$this->draggable_id."').bind('dragstart', function(event, ui) { ".$this->ondragstart." });"));
		}
		if ($this->ondragend != "") {
			$this->page_object->addObject(new JavaScript("$('#".$this->draggable_id."').bind('dragstop', function(event, ui) { ".$this->ondragend." });"));
		}
		$this->object_change = false;
		return "";
	}
}
?>
