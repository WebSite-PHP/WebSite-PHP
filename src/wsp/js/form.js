createOnChangeFormEvent = function(id) {
	$('#' + id).change(function(e) { 
		var obj = document.getElementById(e.target.id);
		setFormObjectChangeEvent(id, obj);
	});
};
setFormObjectChangeEvent = function(id, obj) {
	var selectedValue = "";
	var defaultValue = "";
	switch (obj.type) {
		case 'text' : case 'textarea' : case 'file' : case 'hidden' : selectedValue = obj.value; defaultValue = obj.defaultValue; obj.defaultValue = obj.value; break;
		case 'checkbox' : case 'radio' : selectedValue = obj.checked; defaultValue = obj.defaultChecked; obj.defaultChecked = obj.checked; break;
		case 'select-one' : case 'select-multiple' :
			for (var j = 0; j < obj.options.length; j++) { if (obj.options[j].selected) { selectedValue = j; break; } }
			for (var j = 0; j < obj.options.length; j++) { if (obj.options[j].defaultSelected) { defaultValue = j; obj.options[j].defaultSelected = false; break; } }
			for (var j = 0; j < obj.options.length; j++) { if (obj.options[j].selected) { obj.options[j].defaultSelected = true; break; } }
		break;
	}
	if (selectedValue == defaultValue) { return false; } // no change
	var list_obj_change = $('#' + id + '_WspFormChange').val();
	if (list_obj_change.indexOf(";" + obj.id + ";") == -1) {
		if (list_obj_change == "") { list_obj_change =";"; }
		list_obj_change = list_obj_change + obj.id + ";";
		$('#' + id + '_WspFormChange').val(list_obj_change);
	}
	$('#' + id + '_LastChangeObjectValue').val(defaultValue);
};
revertLastFormChangeObjectToDefaultValue = function(class_name, id, form_id) {
	var obj = document.getElementById(id);
	if (class_name == "ComboBox") {
		for (var j = 0; j < obj.options.length; j++) {
			if (j == $('#' + form_id + '_LastChangeObjectValue').val()) {
	    		obj.options[j].selected = true;
	    		obj.options[j].defaultSelected = true;
	    	} else {
	    		obj.options[j].selected = false;
	    		obj.options[j].defaultSelected = false;
	    	}
		}
		document.getElementById(id).refresh();
	} else if (class_name == "CheckBox" || class_name == "RadioButton") {
		$('#' + id).attr('checked', $('#' + form_id + '_LastChangeObjectValue').val());
		obj.defaultChecked = $('#' + id).attr('checked');
	} else if (class_name == "Editor") {
		eval("setEditorContent_" + id + "('" + addslashes($('#' + form_id + '_LastChangeObjectValue').val()) + "');");
	} else {
		$('#' + id).val($('#' + form_id + '_LastChangeObjectValue').val());
		obj.defaultValue = $('#' + id).val();
	}
};