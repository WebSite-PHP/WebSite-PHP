/*
 * jQuery.upload for WSP (http://www.website-php.com)
 * This library used jquery.form.js (http://malsup.com/jquery/form/)
 */
(function($) {
	var uuid = 0;

    var isFeatureFileapi = $("<input type='file'/>").get(0).files !== undefined;
    var isFeatureFormdata = window.FormData !== undefined;
    var isFileAPIActivate = isFeatureFileapi && isFeatureFormdata;

	$.fn.upload = function(url, data, callback, type, progressbar_obj, obj_to_hide, check_size_fct, upload_size, check_mime_fct, mime_types) {
		var self = this, inputs, checkbox, checked;

        if (isFileAPIActivate && typeof check_size_fct == "function") {
            if (upload_size != "" && upload_size > 0) {
                var files = document.getElementById(self.attr('id')).files;
                for (var i=0; i < files.length; i++) {
                    var file = files[i];
                    if (file != null && file.size > upload_size) {
                        check_size_fct(file.name);
                        return false;
                    }
                }
            }
        }
        if (isFileAPIActivate && typeof check_mime_fct == "function") {
            if (mime_types != "") {
                var files = document.getElementById(self.attr('id')).files;
                var mime_types_array = mime_types.split(', ');
                for (var i=0; i < files.length; i++) {
                    var file = files[i];
                    if (file != null && file.type != null && file.type != "") {
                        var file_mime_type_ok = false;
                        for (var j=0; j < mime_types_array.length; j++) {
                            console.log(mime_types_array[j].toLowerCase()+" == "+file.type.toLowerCase());
                            if (mime_types_array[j] != "" && mime_types_array[j].toLowerCase() == file.type.toLowerCase()) {
                                file_mime_type_ok = true;
                            }
                        }
                        if (!file_mime_type_ok) {
                            check_mime_fct(file.name, file.type);
                            return false;
                        }
                    }
                }
            }
        }

        var form = '<form method="post" enctype="multipart/form-data" />';

		if ($.isFunction(data)) {
			type = callback;
			callback = data;
			data = {};
		}

		checkbox = $('input:checkbox', this);
		checked = $('input:checked', this);
		form = self.wrapAll(form).parent('form').attr('action', url);

		// Make sure radios and checkboxes keep original values
		// (IE resets checkd attributes when appending)
		checkbox.removeAttr('checked');
		checked.attr('checked', true);

		inputs = createInputs(data);
		inputs = inputs ? $(inputs).appendTo(form) : null;

        form.ajaxSubmit({
            beforeSend: function () {
                if (isFileAPIActivate) {
                    if (obj_to_hide != null) {
                        obj_to_hide.hide();
                    }
                    if (progressbar_obj != null) {
                        progressbar_obj.show();
                    }
                }
            },
            uploadProgress: function (event, position, total, percentComplete) {
                if (isFileAPIActivate && progressbar_obj != null) {
                    // Increase the progress bar length.
                    if (percentComplete <= 100) {
                        var progressTxtObj = progressbar_obj.find(".wsp-progress-bar span");
                        if (percentComplete < 50) {
                            if (!progressTxtObj.hasClass('wsp-progress-bar-1')) {
                                if (progressTxtObj.hasClass('wsp-progress-bar-2')) {
                                    progressTxtObj.removeClass('wsp-progress-bar-2');
                                }
                                progressTxtObj.addClass('wsp-progress-bar-1');
                            }
                        } else {
                            if (!progressTxtObj.hasClass('wsp-progress-bar-2')) {
                                if (progressTxtObj.hasClass('wsp-progress-bar-1')) {
                                    progressTxtObj.removeClass('wsp-progress-bar-1');
                                }
                                progressTxtObj.addClass('wsp-progress-bar-2');
                            }
                        }
                        progressTxtObj.html(percentComplete+"%");
                        progressbar_obj.find('.wsp-progress-bar>div').css({'width': percentComplete + '%'});

                        if (percentComplete >= 100) {
                            setTimeout(function() {revertUploadProgressBar(progressbar_obj, obj_to_hide);}, 100);
                        }
                    }
                }
            },
            success: function (responseText, statusText, xhr) {
                revertUploadProgressBar(progressbar_obj, obj_to_hide);
                var data = handleData(responseText, type);
                var checked = $('input:checked', self);

                form.after(self).remove();
                checkbox.removeAttr('checked');
                checked.attr('checked', true);
                if (inputs) {
                    inputs.remove();
                }

                setTimeout(function() {
                    if (type === 'script') {
                        $.globalEval(data);
                    }
                    if (typeof callback == 'function') {
                        callback(data);
                    }
                }, 0);
            }
        });
		return true;
	};

    function revertUploadProgressBar(progressbar_obj, obj_to_hide) {
        if (isFileAPIActivate) {
            if (progressbar_obj != null) {
                progressbar_obj.hide();
            }
            if (obj_to_hide != null) {
                obj_to_hide.show();
            }
        }
    }

	function createInputs(data) {
		return $.map(param(data), function(param) {
			return '<input type="hidden" name="' + param.name + '" value="' + param.value + '"/>';
		}).join('');
	}

	function param(data) {
		if ($.isArray(data)) {
			return data;
		}
		var params = [];

		function add(name, value) {
			params.push({name:name, value:value});
		}

		if (typeof data === 'object') {
			$.each(data, function(name) {
				if ($.isArray(this)) {
					$.each(this, function() {
						add(name, this);
					});
				} else {
					add(name, $.isFunction(this) ? this() : this);
				}
			});
		} else if (typeof data === 'string') {
			$.each(data.split('&'), function() {
				var param = $.map(this.split('='), function(v) {
					return decodeURIComponent(v.replace(/\+/g, ' '));
				});

				add(param[0], param[1]);
			});
		}

		return params;
	}

	function handleData(data, type) {
		switch (type) {
			case 'xml':
				data = parseXml(data);
				break;
			case 'json':
				data = eval('(' + data + ')');
				break;
		}
		return data;
	}

	function parseXml(text) {
		if (window.DOMParser) {
			return new DOMParser().parseFromString(text, 'application/xml');
		} else {
			var xml = new ActiveXObject('Microsoft.XMLDOM');
			xml.async = false;
			xml.loadXML(text);
			return xml;
		}
	}

})(jQuery);
