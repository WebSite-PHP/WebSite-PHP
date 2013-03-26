var debug_sortable_js = false;

var lastMovedSortableId = null;
var lastSortableObjectMoveFrom = null;
var sortableObjectMoveFrom = Array();
var sortableObjectMoveTo = Array();
var sortableObjectToMove = Array();
var sortableObjectNewPosition = Array();
var sortableObjectOldPosition = "";
var sortableObjectSerialize = Array();
var sortableIsStarting = false;

var sortableMoveFromObjectPile = Array();

function extractSortableObject(str_serilize, move_item) {
	if (str_serilize != null) {
		var serial = myReplaceAll(str_serilize, '[]=', '_');
		var position = 0;
		var array_pos = serial.split('&');
		for (var i=0; i < array_pos.length; i++) {
			if (trim(array_pos[i]) != "" && array_pos[i].substr(0, 9) != "Callback_") {
				position++;
				if (array_pos[i] == move_item) {
					return position;
				}
			}
		}
	}
	return false;
}

function numberOfSortableObject(str_serilize) {
	if (str_serilize != null) {
		var serial = myReplaceAll(str_serilize, '[]=', '_');
		var array_pos = serial.split('&');
		var nb_object = 0;
		for (var i=0; i < array_pos.length; i++) {
			if (trim(array_pos[i]) != "" && array_pos[i].substr(0, 9) != "Callback_") {
				nb_object++;
			}
		}
		return nb_object;
	}
	return 0;
}

saveSerializeSortableObject = function(sortable_id) {
	sortableObjectSerialize[sortable_id] = $('#' + sortable_id).sortable('serialize');
	//if (debug_sortable_js) { window.console.log('save object ' + sortable_id + ': ' + sortableObjectSerialize[sortable_id]); }
};

sortableEventStart = function(sortable_id, ui) {
	if (!sortableIsStarting) { 
		if (debug_sortable_js) { window.console.log('starting [' + sortable_id + ']'); }
		sortableIsStarting = sortable_id;
		
		var serial = $('#' + sortable_id).sortable('serialize');
		var position = extractSortableObject(serial, ui.item[0].id);
		sortableObjectOldPosition = position;
	}
	return true;
}

sortableEventStop = function(sortable_id, ui) {
	if (!sortableIsStarting) { return true; }
	
	if (debug_sortable_js) { window.console.log('lastMovedSortableId = '+lastMovedSortableId + ' [' + sortable_id + ']'); }
	if (lastMovedSortableId != null) {
		sortableIsStarting = false;
		var sortable_id = lastMovedSortableId;
		if (sortableObjectMoveFrom[sortable_id] != null && sortableObjectToMove[sortable_id] != null && sortableObjectNewPosition[sortable_id] != null) {
			if (debug_sortable_js) { window.console.log('Move ' + sortableObjectToMove[sortable_id] + ' from ' + sortableObjectMoveFrom[sortable_id] + ' to ' + sortableObjectMoveTo[sortable_id] + ' [position:' + sortableObjectNewPosition[sortable_id] + ', oldPosition:' + sortableObjectOldPosition + ']'); }
			eval('move_' + sortable_id + '_ObjectEvent("' + sortableObjectToMove[sortable_id] + '","' + sortableObjectMoveFrom[sortable_id] + '","' + sortableObjectMoveTo[sortable_id] + '",' + sortableObjectNewPosition[sortable_id] + ',' + sortableObjectOldPosition + ');');

			saveSerializeSortableObject(sortableObjectMoveFrom[sortable_id]);
			saveSerializeSortableObject(sortableObjectMoveTo[sortable_id]);
			
			sortableObjectMoveFrom[sortable_id] = null;
			sortableObjectMoveTo[sortable_id] = null;
			sortableObjectToMove[sortable_id] = null;
			sortableObjectNewPosition[sortable_id] = null;
		}
		saveSerializeSortableObject(sortable_id);
		lastMovedSortableId = null;
	} else if (sortable_id != null) {
		if (sortableMoveFromObjectPile.length > 0) {
			for (var i=0; i < sortableMoveFromObjectPile.length; i++) {
				if (lastMovedSortableId == null) {
					sortableEventUpdate(sortableMoveFromObjectPile[i], ui);
				} else {
					break;
				}
			}
			sortableEventStop();
		}
	}
	sortableIsStarting = false;
	return true;
};

sortableEventUpdate = function(sortable_id, ui) {
	if (!sortableIsStarting) { return true; }
	
	var serial = $('#' + sortable_id).sortable('serialize');
	if (debug_sortable_js) { window.console.log('sortupdate: ' + sortable_id); }
	//if (debug_sortable_js) { window.console.log('sortupdate save: ' + sortableObjectSerialize[sortable_id]); }
	//if (debug_sortable_js) { window.console.log('sortupdate new: ' + serial); }
	if (sortableObjectSerialize[sortable_id] != serial) {
		if (debug_sortable_js) { window.console.log('update: ' + sortable_id + " -> " + numberOfSortableObject(sortableObjectSerialize[sortable_id]) + " <= " + numberOfSortableObject(serial)); }
		if (numberOfSortableObject(sortableObjectSerialize[sortable_id]) <= numberOfSortableObject(serial)) { // add or move
			if (ui.item[0].id != '') {
				var position = extractSortableObject(serial, ui.item[0].id);
				if (debug_sortable_js) { window.console.log('Move to position : ' + position + ' [' + serial + ']'); }
				if (position != false) { 
					if (lastSortableObjectMoveFrom == null) { sortableObjectMoveFrom[sortable_id] = sortable_id; }
					else { sortableObjectMoveFrom[sortable_id] = lastSortableObjectMoveFrom; }
					sortableObjectMoveTo[sortable_id] = sortable_id;
					sortableObjectToMove[sortable_id] = ui.item[0].id;
					sortableObjectNewPosition[sortable_id] = position;
					lastMovedSortableId = sortable_id;
					lastSortableObjectMoveFrom = null;
					sortableMoveFromObjectPile = Array();
				}
				saveSerializeSortableObject(lastMovedSortableId);
				saveSerializeSortableObject(sortable_id);
			}
		} else { // remove
			sortableEventRemove(sortable_id);
		}
	}
	return true;
};

sortableEventRemove = function(sortable_id, ui) {
	if (!sortableIsStarting) { return true; }
	
	var serial = $('#' + sortable_id).sortable('serialize');
	if (sortableObjectSerialize[sortable_id] != serial) {
		if (debug_sortable_js) { window.console.log('sortremove: ' + sortable_id + " -> " + numberOfSortableObject(sortableObjectSerialize[sortable_id]) + " > " + numberOfSortableObject(serial)); }
		if (numberOfSortableObject(sortableObjectSerialize[sortable_id]) > numberOfSortableObject(serial)) { // remove
			lastSortableObjectMoveFrom = sortable_id;
		}
	}
	return true;
};

sortableEventChangeSaveObject = function(sortable_id, ui) {
	if (!sortableIsStarting) { return true; }
	if (sortable_id != sortableIsStarting && sortableMoveFromObjectPile[0] != sortable_id) {
		for (var i=sortableMoveFromObjectPile.length-1; i >= 0; i--) {
			sortableMoveFromObjectPile[i+1]=sortableMoveFromObjectPile[i];
		}
		sortableMoveFromObjectPile[0] = sortable_id;
		if (debug_sortable_js) { window.console.log('sortchange: add ' + sortable_id + ' in array sortableMoveFromObjectPile'); }
	}
};

var sortableObjectLastWidth = Array();
var sortableObjectLastMinWidth = Array();
var sortableObjectLastHeight = Array();
var sortableObjectLastMinHeight = Array();
var sortableObjectOverPadding = 10;
sortableEventOver = function(sortable_id, ui, over_style) {
	var sortable_obj = $('#' + sortable_id);
	sortable_obj.addClass(over_style);
	if (sortable_obj.width() < ui.item[0].offsetWidth + sortableObjectOverPadding) {
		if (!browserIsIE()) {
			sortableObjectLastMinWidth[sortable_id] = sortable_obj.css('min-width');
			sortable_obj.css('min-width', (ui.item[0].offsetWidth + sortableObjectOverPadding) + 'px'); 
		} else {
			sortableObjectLastWidth[sortable_id] = sortable_obj.css('width');
			sortable_obj.css('width', (ui.item[0].offsetWidth + sortableObjectOverPadding) + 'px');
		}
		sortable_obj.sortable('refresh');
	}
	if (sortable_obj.height() < ui.item[0].offsetHeight + sortableObjectOverPadding) {
		if (!browserIsIE()) {
			sortableObjectLastMinHeight[sortable_id] = sortable_obj.css('min-height');
			sortable_obj.css('min-height', (ui.item[0].offsetHeight + sortableObjectOverPadding) + 'px'); 
		} else {
			sortableObjectLastHeight[sortable_id] = sortable_obj.css('height');
			sortable_obj.css('height', (ui.item[0].offsetHeight + sortableObjectOverPadding) + 'px');
		}
	}
	return true;
};

sortableEventOut = function(sortable_id, ui, over_style) {
	var sortable_obj = $('#' + sortable_id);
	sortable_obj.removeClass(over_style);
	if (!browserIsIE()) {
		if (sortableObjectLastMinWidth[sortable_id] == null) {
			sortable_obj.animate({'min-width': 'none'}, 500);
		} else {
			sortable_obj.animate({'min-width': sortableObjectLastMinWidth[sortable_id]}, 500);
		}
		if (sortableObjectLastMinHeight[sortable_id] == null) {
			sortable_obj.animate({'min-height': 'none'}, 500);
		} else {
			sortable_obj.animate({'min-height': sortableObjectLastMinHeight[sortable_id]}, 500);
		}
	} else {
		if (sortableObjectLastWidth[sortable_id] == null) {
			sortable_obj.css('width', 'auto');
		} else {
			sortable_obj.css('width', sortableObjectLastWidth[sortable_id]);
		}
		if (sortableObjectLastHeight[sortable_id] == null) {
			sortable_obj.css('height', 'auto');
		} else {
			sortable_obj.css('height', sortableObjectLastHeight[sortable_id]);
		}
	}
	return true;
};