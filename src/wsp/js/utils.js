function ResetCallbackObjectValue(){
	var arrayInput=document.getElementsByTagName("INPUT");
	for(var i=0;i<arrayInput.length;i++) {
		if(arrayInput[i].type.toUpperCase()=="HIDDEN") {
			if(arrayInput[i].id.indexOf("Callback_")!=-1) {
				arrayInput[i].value="";
			}
		}
	}
}
function htmlentities(a,b){var c={},symbol='',tmp_str='',entity='';tmp_str=a.toString();if(false===(c=this.get_html_translation_table('HTML_ENTITIES',b))){return false}c["'"]='&#039;';for(symbol in c){entity=c[symbol];tmp_str=tmp_str.split(symbol).join(entity)}return tmp_str}function getEditorContent(a){GetScrollPosition(a);return FCKeditorAPI.GetInstance(a).GetHTML()}function setEditorContent(a,b){var c=FCKeditorAPI.GetInstance(a);c.Events.AttachEvent('OnAfterSetHTML',SetScrollPosition);c.SetHTML(b)}function myReplace(a,b,c){var d=a.indexOf(b);var e=parseInt(a.indexOf(b))+parseInt(b.length);var f=a.length;return a.substring(0,d)+c+a.substring(e,f)}function myReplaceAll(a,b,c){iPos=-1;while(a!=''){iPos=a.indexOf(b);if(iPos==-1){return a}else{a=myReplace(a,b,c)}}return''}function html_entity_decode(a){var b,tarea=document.createElement('textarea');tarea.innerHTML=a;b=tarea.value;return b}function rand(a,b){var c=arguments.length;if(c==0){a=0;b=2147483647}else if(c==1){throw new Error('Warning: rand() expects exactly 2 parameters, 1 given');}return Math.floor(Math.random()*(b-a+1))+a}function ucfirst(a){a+='';var f=a.charAt(0).toUpperCase();return f+a.substr(1)}function get_html_translation_table(a,b){var c={},hash_map={},decimal=0,symbol='';var d={},constMappingQuoteStyle={};var e={},useQuoteStyle={};d[0]='HTML_SPECIALCHARS';d[1]='HTML_ENTITIES';constMappingQuoteStyle[0]='ENT_NOQUOTES';constMappingQuoteStyle[2]='ENT_COMPAT';constMappingQuoteStyle[3]='ENT_QUOTES';e=!isNaN(a)?d[a]:a?a.toUpperCase():'HTML_SPECIALCHARS';useQuoteStyle=!isNaN(b)?constMappingQuoteStyle[b]:b?b.toUpperCase():'ENT_COMPAT';if(e!=='HTML_SPECIALCHARS'&&e!=='HTML_ENTITIES'){throw new Error("Table: "+e+' not supported');}c['38']='&amp;';if(e==='HTML_ENTITIES'){c['160']='&nbsp;';c['161']='&iexcl;';c['162']='&cent;';c['163']='&pound;';c['164']='&curren;';c['165']='&yen;';c['166']='&brvbar;';c['167']='&sect;';c['168']='&uml;';c['169']='&copy;';c['170']='&ordf;';c['171']='&laquo;';c['172']='&not;';c['173']='&shy;';c['174']='&reg;';c['175']='&macr;';c['176']='&deg;';c['177']='&plusmn;';c['178']='&sup2;';c['179']='&sup3;';c['180']='&acute;';c['181']='&micro;';c['182']='&para;';c['183']='&middot;';c['184']='&cedil;';c['185']='&sup1;';c['186']='&ordm;';c['187']='&raquo;';c['188']='&frac14;';c['189']='&frac12;';c['190']='&frac34;';c['191']='&iquest;';c['192']='&Agrave;';c['193']='&Aacute;';c['194']='&Acirc;';c['195']='&Atilde;';c['196']='&Auml;';c['197']='&Aring;';c['198']='&AElig;';c['199']='&Ccedil;';c['200']='&Egrave;';c['201']='&Eacute;';c['202']='&Ecirc;';c['203']='&Euml;';c['204']='&Igrave;';c['205']='&Iacute;';c['206']='&Icirc;';c['207']='&Iuml;';c['208']='&ETH;';c['209']='&Ntilde;';c['210']='&Ograve;';c['211']='&Oacute;';c['212']='&Ocirc;';c['213']='&Otilde;';c['214']='&Ouml;';c['215']='&times;';c['216']='&Oslash;';c['217']='&Ugrave;';c['218']='&Uacute;';c['219']='&Ucirc;';c['220']='&Uuml;';c['221']='&Yacute;';c['222']='&THORN;';c['223']='&szlig;';c['224']='&agrave;';c['225']='&aacute;';c['226']='&acirc;';c['227']='&atilde;';c['228']='&auml;';c['229']='&aring;';c['230']='&aelig;';c['231']='&ccedil;';c['232']='&egrave;';c['233']='&eacute;';c['234']='&ecirc;';c['235']='&euml;';c['236']='&igrave;';c['237']='&iacute;';c['238']='&icirc;';c['239']='&iuml;';c['240']='&eth;';c['241']='&ntilde;';c['242']='&ograve;';c['243']='&oacute;';c['244']='&ocirc;';c['245']='&otilde;';c['246']='&ouml;';c['247']='&divide;';c['248']='&oslash;';c['249']='&ugrave;';c['250']='&uacute;';c['251']='&ucirc;';c['252']='&uuml;';c['253']='&yacute;';c['254']='&thorn;';c['255']='&yuml;'}if(useQuoteStyle!=='ENT_NOQUOTES'){c['34']='&quot;'}if(useQuoteStyle==='ENT_QUOTES'){c['39']='&#39;'}c['60']='&lt;';c['62']='&gt;';for(decimal in c){symbol=String.fromCharCode(decimal);hash_map[symbol]=c[decimal]}return hash_map}
function addslashes(str) {
	return (str+'').replace(/([\\"'])/g, "\\$1").replace(/\0/g, "\\0");
}
function trim(str) { 
	var str2 = "" + str;
	return str2.replace(/(^\s*)|(\s*$)/g,''); 
}
function strip_tags(html){
	//PROCESS STRING
	if(arguments.length < 3) {
		html=html.replace(/<\/?(?!\!)[^>]*>/gi, '');
	} else {
		var allowed = arguments[1];
		var specified = eval("["+arguments[2]+"]");
		if(allowed){
			var regex='</?(?!(' + specified.join('|') + '))\b[^>]*>';
			html=html.replace(new RegExp(regex, 'gi'), '');
		} else{
			var regex='</?(' + specified.join('|') + ')\b[^>]*>';
			html=html.replace(new RegExp(regex, 'gi'), '');
		}
	}
	//CHANGE NAME TO CLEAN JUST BECAUSE 
	var clean_string = html;
	//RETURN THE CLEAN STRING
	return trim(clean_string);
}
function urlencode(str) {
	var ret = str;
	ret = ret.toString();
	ret = encodeURIComponent(ret);
	ret = ret.replace(/%20/g, '+');
	return ret;
}
function urldecode(str) {
    return decodeURIComponent((str + '').replace(/\+/g, '%20'));
}
function noaccent(chaine) {
  temp = chaine.replace(/[¿¡¬√ƒ≈‡·‚„‰Â]/gi,"a")
  temp = temp.replace(/[»… ÀËÈÍÎ]/gi,"e")
  temp = temp.replace(/[ÃÕŒœÏÌÓÔ]/gi,"i")
  temp = temp.replace(/[“”‘’÷ÿÚÛÙıˆ¯]/gi,"o")
  temp = temp.replace(/[Ÿ⁄€‹˘˙˚¸]/gi,"u")
  temp = temp.replace(/[«Á]/gi,"c")
  temp = temp.replace(/[ˇ]/gi,"y")
  temp = temp.replace(/[—Ò]/gi,"n")
  temp = myReplaceAll(temp, "ú", "oe")
  return temp
}

// Fonction de stockage des scripts ‡ charger 
FuncOL = new Array(); 
function StkFunc(Obj) { 
    FuncOL[FuncOL.length] = Obj; 
} 
     
// Execution des scripts au chargement de la page 
window.onload = function() { 
    for(i=0; i<FuncOL.length; i++) 
        {FuncOL[i]();} 
}

// Fonction de stockage des scripts ‡ charger lors d'un resize
FuncOR = new Array(); 
function StkFuncOR(Obj) { 
    FuncOR[FuncOR.length] = Obj; 
} 
     
// Execution des scripts au resize de la page 
window.onresize = function() { 
    for(i=0; i<FuncOR.length; i++) 
        {FuncOR[i]();} 
}

//Preload Image
function PreloadPicture(picture_url) {
	preload_image_object = new Image();
	preload_image_object.src = picture_url;
}

function SaveDocumentSize() {
	$.cookie("wsp_document_width", $(document).width(), { path: '/', expires: 1 });
	$.cookie("wsp_document_height", $(document).height(), { path: '/', expires: 1 });
}

function SaveWindowSize() {
	$.cookie("wsp_window_width", $(window).width(), { path: '/', expires: 1 });
	$.cookie("wsp_window_height", $(window).height(), { path: '/', expires: 1 });
}

function addToFavorite(siteURL, siteNOM) {
	/*-- MESSAGE --*/
	function myMessageAddToFav(raccourciClavier) {
		alert ("Utilisez '" + raccourciClavier + "'\npour ajouter " + siteNOM + " dans vos favoris !");
	}
	
	//Konqueror
	if (navigator.userAgent.indexOf('Konqueror') >= 0) {
	/*Test a effectuer avant tout les autres car repond TRUE aux differents tests sans pouvoir les exploiter*/
		myMessageAddToFav("CTRL + B");
	} else if (window.sidebar) {
		/* Netscape 6+ ; Mozilla, FireFox et compagnie (K-Meleon ...) */
		window.sidebar.addPanel(siteNOM,siteURL,"");
	} else if (window.external) {
		/* Internet Explorer 4+, et ses dÈrivÈs (Crazy Browser, Avent Browser ...) */
		window.external.AddFavorite(siteURL,siteNOM);
	} else if (document.all && (navigator.userAgent.indexOf('Win') < 0)) {
		/* Internet Explorer Mac */
		myMessageAddToFav("POMME + D");
	} else if (window.opera && window.print) {
		/* Opera 6+ */
		myMessageAddToFav("CTRL + T");
	} else if (document.layers) {
		/* Netsccape 4 */
		myMessageAddToFav("CTRL + D");
	} else {
		alert("Cette fonction n'est pas disponible pour votre navigateur.");
	}
}

function f_clientWidth() {
	return f_filterResults (
		window.innerWidth ? window.innerWidth : 0,
		document.documentElement ? document.documentElement.clientWidth : 0,
		document.body ? document.body.clientWidth : 0
	);
}
function f_clientHeight() {
	return f_filterResults (
		window.innerHeight ? window.innerHeight : 0,
		document.documentElement ? document.documentElement.clientHeight : 0,
		document.body ? document.body.clientHeight : 0
	);
}
function f_scrollLeft() {
	return f_filterResults (
		window.pageXOffset ? window.pageXOffset : 0,
		document.documentElement ? document.documentElement.scrollLeft : 0,
		document.body ? document.body.scrollLeft : 0
	);
}
function f_scrollTop() {
	return f_filterResults (
		window.pageYOffset ? window.pageYOffset : 0,
		document.documentElement ? document.documentElement.scrollTop : 0,
		document.body ? document.body.scrollTop : 0
	);
}
function f_filterResults(n_win, n_docel, n_body) {
	var n_result = n_win ? n_win : 0;
	if (n_docel && (!n_result || (n_result > n_docel)))
		n_result = n_docel;
	return n_body && (!n_result || (n_result > n_body)) ? n_body : n_result;
}

var arrayDynamicJsScriptLoaded = new Array();
function loadDynamicJS(src, ind_load) {
	if (typeof(arrayDynamicJsScriptLoaded[ind_load]) == "undefined") {
		arrayDynamicJsScriptLoaded[ind_load] = new Array();
	}
	var ind_src=arrayDynamicJsScriptLoaded[ind_load].length;
	arrayDynamicJsScriptLoaded[ind_load][ind_src] = false;
	var head= document.getElementsByTagName('head')[0];
	var script= document.createElement("script");
	script.type= 'text/javascript';
	script.src= src;
	script.onreadystatechange = function(){
		arrayDynamicJsScriptLoaded[ind_load][ind_src] = true;
	};
	script.onload = function(){
		arrayDynamicJsScriptLoaded[ind_load][ind_src] = true;
	};
	head.appendChild(script);
}
var arrayIntervalWaitForJsScripts = new Array();
function waitForJsScripts(ind_load) {
	if (arrayIntervalWaitForJsScripts[ind_load] != null) {
		clearInterval(arrayIntervalWaitForJsScripts[ind_load]);
	}
	if (typeof(arrayDynamicJsScriptLoaded[ind_load]) == "undefined") {
		arrayDynamicJsScriptLoaded[ind_load] = new Array();
	} 
	var all_scripts_loaded = true;
	for (var i=0; i<arrayDynamicJsScriptLoaded[ind_load].length; i++) {
		if (!arrayDynamicJsScriptLoaded[ind_load][i]) {
			all_scripts_loaded = false;
			break;
		}
	}
	if (!all_scripts_loaded) {
		arrayIntervalWaitForJsScripts[ind_load] = setInterval("waitForJsScripts(" + ind_load + ")", 200);
	} else {
		eval("lauchJavascriptPage_" + ind_load + "();");
	}
}
function loadDynamicCSS(src) {
	var head= document.getElementsByTagName('head')[0];
	var link= document.createElement("link");
	link.type= 'text/css';
	link.rel= 'StyleSheet';
	link.media= 'screen';
	link.href= src;
	head.appendChild(link);
}
function browserIsIE6() {
	var browserIsIE6 = true;
	var arVersion = navigator.appVersion.split("MSIE");
	var version = parseFloat(arVersion[1]);
	if ((navigator.appVersion.indexOf("MSIE")!=-1 && version>=7) || navigator.appVersion.indexOf("MSIE")==-1) {
		browserIsIE6 = false;
	}
	return browserIsIE6;
}
function browserIsIE() {
	var browserIsIE = true;
	if (navigator.appVersion.indexOf("MSIE")==-1) {
		browserIsIE = false;
	}
	return browserIsIE;
}
function stopEventPropagation(e) {
	if (e == null) {
		if (window.event!=null) {
			e = window.event;
		} else {
			return;
		}
	}
	e.cancelBubble = true;
	if (e.stopPropagation) e.stopPropagation();
}
function refreshPage() { location.reload(true); }