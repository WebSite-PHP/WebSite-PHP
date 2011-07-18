changeStyleSheetProperty = function(css_file_name, rule_name, property, value, display_rule_error) {
	stylesheet_ind=-1;
	for (var i=0; i<document.styleSheets.length; i++) {
		if (document.styleSheets[i].href.toUpperCase().indexOf(css_file_name.toUpperCase()) != -1) {
			stylesheet_ind=i;
			break;
		}
	}
	if (stylesheet_ind != -1) {
		stylesheet_rule_ind=-1;
		if (document.styleSheets[stylesheet_ind].cssRules != null) {
			arrayCssRules = document.styleSheets[stylesheet_ind].cssRules;
		} else {
			arrayCssRules = document.styleSheets[stylesheet_ind].rules;
		}
		for (var i=0; i<arrayCssRules.length; i++) {
			if (myReplaceAll(arrayCssRules[i].selectorText, " ", "").toUpperCase()==myReplaceAll(rule_name, " ", "").toUpperCase()) {
				stylesheet_rule_ind=i;
				break;
			}
		}
		if (stylesheet_rule_ind != -1) {
			var cssText=arrayCssRules[stylesheet_rule_ind].style.cssText.toUpperCase();
			cssText=trim(myReplaceAll(myReplaceAll(myReplaceAll(cssText, '\n', ''), '\r', ''), '\t', ''));
			var pos1=cssText.indexOf('; ' + property.toUpperCase() + ':');
			if (pos1==-1) { 
				pos1=cssText.indexOf(property.toUpperCase() + ':'); 
				if (pos1==-1 && property == "background") { pos1=cssText.indexOf("background-color".toUpperCase() + ':'); }
			} else { pos1=pos1+2 }
			if (pos1!=-1) {
				var pos2=cssText.indexOf(';', pos1+1);
				var my_property=cssText.substring(pos1, pos2);
				cssText=cssText.replace(my_property, property.toUpperCase() + ': ' + addslashes(value));
				arrayCssRules[stylesheet_rule_ind].style.cssText=cssText;
			} else if (cssText != "" && display_rule_error != false) {
				alert('can\'t find ' + property + ' in rule ' + rule_name + ' [CssText: ' + cssText + ']')
			}
		} else {
			alert('can\'t find rule ' + rule_name + ' in stylesheet ' + css_file_name + '.');
		}
	} else {
		alert('can\'t find stylesheet ' + css_file_name + '.');
	}
};
