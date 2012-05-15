(function( $ ) {
	var currentWspPageIsStopped = false;
	var lastObjectTypeUserClick = "";
	var lastObjectIdUserClick = "";
	var lastObjectNameUserClick = "";
	$(window).bind('beforeunload', function() {
		currentWspPageIsStopped = true;
	});
	$('*').click(function(event) {
		lastObjectTypeUserClick = "";
		lastObjectIdUserClick = "";
		lastObjectNameUserClick = "";
		if ($(event.target) != null) {
			if ($(event.target).attr('type') != null) {
				lastObjectTypeUserClick = $(event.target).attr('type');
			}
			if ($(event.target).attr('id') != null) {
				lastObjectIdUserClick = $(event.target).attr('id');
			}
			if ($(event.target).attr('name') != null) {
				lastObjectNameUserClick = $(event.target).attr('name');
			}
			//if(window.console) console.log("Debug: click on " + lastObjectTypeUserClick + " " + lastObjectIdUserClick + " " + lastObjectNameUserClick);
		}
	});
	$.fn.jsErrorHandler = function() {
		onJsErrorWspHandling = function(msg, url, line) {
			var e = null;
			if (typeof(msg) === "object") {
				e = msg;
				msg = e.message;
				url = e.filename;
				line = e.lineno;
			}
			
			// Check if this error is signifiant
			if (msg == "" || msg == null || msg === undefined || msg == "undefined") {
				return true; // no error message
			}
			if (currentWspPageIsStopped == true) { // the user leave the current page
				return true;
			}
			if (browserIsIE()) { // Internet Explorer
				var arVersion = navigator.appVersion.split("MSIE");
				var version = parseFloat(arVersion[1]);
				if (version < 7) {
					if(window.console) console.log("You have javascript error with an old IE version, please update your browser");
					return true;
				} else if (version == 7 && line == 2) { // insignificant error
					return true;
				}
			}
			// Not an URL of this website
			if (url != null && (url.substring(0, 7) == "http://" ||  url.substring(0, 8) == "https://")
				&& url.substring(0, wsp_javascript_base_url.length) != wsp_javascript_base_url) {
					if(window.console) console.log("You have javascript error, but this error is not linked to the website " + wsp_javascript_base_url);
					return true;
			}
			if ((line == 0 || line == 1) && 
				(url == "" || url == null || url === undefined || url == "undefined")) {
					return true;
			}
			
			// send the javascript error
			msg = "<font color='red'><b>JavaScript Error:</b></font><br/><b>Error:</b> " + msg + "<br/><b>Line:</b> " + line + "<br/><b>URL:</b> " + location.href + "<br/>";
			if (url != location.href && url != "" && url != null && url !== undefined && url != "undefined") {
				msg = msg + "<b>Script URL:</b> " + url + "<br/>";
			}
			if (lastObjectTypeUserClick != "" || lastObjectIdUserClick != "" || lastObjectNameUserClick != "") {
				msg = msg + "<b>Last click:</b> ";
				if (lastObjectTypeUserClick != "") {
					msg = msg + "Type -> " + lastObjectTypeUserClick + " ";
				}
				if (lastObjectIdUserClick != "") {
					msg = msg + "Id -> " + lastObjectIdUserClick + " ";
				}
				if (lastObjectNameUserClick != "") {
					msg = msg + "Name -> " + lastObjectNameUserClick + " ";
				}
				msg = msg + "<br/>";
			}
			var cache_filename = "";
			if (wsp_cache_filename != null && wsp_cache_filename != "") {
				cache_filename = myReplaceAll(wsp_cache_filename, "{#%2F#}", "/");
				if (cache_filename != "") {
					msg = msg + "<b>Cache file:</b> " + cache_filename + "*.cache ('*': depends of the browser)<br/>";
				}
			}
			msg = msg + "<br/>";
			if (e != null && typeof(e) === "object") {
				var traceArray = printStackTrace({e:e, guess:true});
				traceArray.pop(); // remove last element of the trace
				msg = msg + "<b>Trace:</b><br/>" + traceArray.join('<br/>') + "<br/>";
			}
			
			$.ajax({
				type: 'POST',
				cache: false,
				url: wsp_javascript_base_url + wsp_user_language + "/error-debug.html",
				data: $.param({'debug':msg, 'cache_filename':cache_filename}),
				success: function(test) {
					if(window.console) console.log("Report sent about the javascript error");
				}
			});
			return true;
		};
		if (window.addEventListener) {
			window.addEventListener("error", onJsErrorWspHandling, false);
		} else if (window.attachEvent) {
			window.attachEvent("onerror", onJsErrorWspHandling);
		}
	};
})( jQuery );

function printStackTrace(b){var c=(b&&b.e)?b.e:null;var e=b?!!b.guess:true;var d=new printStackTrace.implementation();var a=d.run(c);return(e)?d.guessFunctions(a):a}printStackTrace.implementation=function(){};printStackTrace.implementation.prototype={run:function(a){a=a||(function(){try{var c=__undef__<<1}catch(d){return d}})();var b=this._mode||this.mode(a);if(b==="other"){return this.other(arguments.callee)}else{return this[b](a)}},mode:function(a){if(a["arguments"]){return(this._mode="chrome")}else{if(window.opera&&a.stacktrace){return(this._mode="opera10")}else{if(a.stack){return(this._mode="firefox")}else{if(window.opera&&!("stacktrace" in a)){return(this._mode="opera")}}}}return(this._mode="other")},instrumentFunction:function(a,b,c){a=a||window;a["_old"+b]=a[b];a[b]=function(){c.call(this,printStackTrace());return a["_old"+b].apply(this,arguments)};a[b]._instrumented=true},deinstrumentFunction:function(a,b){if(a[b].constructor===Function&&a[b]._instrumented&&a["_old"+b].constructor===Function){a[b]=a["_old"+b]}},chrome:function(a){return a.stack.replace(/^[^\(]+?[\n$]/gm,"").replace(/^\s+at\s+/gm,"").replace(/^Object.<anonymous>\s*\(/gm,"{anonymous}()@").split("\n")},firefox:function(a){return a.stack.replace(/(?:\n@:0)?\s+$/m,"").replace(/^\(/gm,"{anonymous}(").split("\n")},opera10:function(g){var k=g.stacktrace;var m=k.split("\n"),a="{anonymous}",h=/.*line (\d+), column (\d+) in ((<anonymous function\:?\s*(\S+))|([^\(]+)\([^\)]*\))(?: in )?(.*)\s*$/i,d,c,f;for(d=2,c=0,f=m.length;d<f-2;d++){if(h.test(m[d])){var l=RegExp.$6+":"+RegExp.$1+":"+RegExp.$2;var b=RegExp.$3;b=b.replace(/<anonymous function\:?\s?(\S+)?>/g,a);m[c++]=b+"@"+l}}m.splice(c,m.length-c);return m},opera:function(h){var c=h.message.split("\n"),b="{anonymous}",g=/Line\s+(\d+).*script\s+(http\S+)(?:.*in\s+function\s+(\S+))?/i,f,d,a;for(f=4,d=0,a=c.length;f<a;f+=2){if(g.test(c[f])){c[d++]=(RegExp.$3?RegExp.$3+"()@"+RegExp.$2+RegExp.$1:b+"()@"+RegExp.$2+":"+RegExp.$1)+" -- "+c[f+1].replace(/^\s+/,"")}}c.splice(d,c.length-d);return c},other:function(h){var b="{anonymous}",g=/function\s*([\w\-$]+)?\s*\(/i,a=[],d=0,e,c;var f=10;while(h&&a.length<f){e=g.test(h.toString())?RegExp.$1||b:b;c=Array.prototype.slice.call(h["arguments"]);a[d++]=e+"("+this.stringifyArguments(c)+")";h=h.caller}return a},stringifyArguments:function(b){for(var c=0;c<b.length;++c){var a=b[c];if(a===undefined){b[c]="undefined"}else{if(a===null){b[c]="null"}else{if(a.constructor){if(a.constructor===Array){if(a.length<3){b[c]="["+this.stringifyArguments(a)+"]"}else{b[c]="["+this.stringifyArguments(Array.prototype.slice.call(a,0,1))+"..."+this.stringifyArguments(Array.prototype.slice.call(a,-1))+"]"}}else{if(a.constructor===Object){b[c]="#object"}else{if(a.constructor===Function){b[c]="#function"}else{if(a.constructor===String){b[c]='"'+a+'"'}}}}}}}}return b.join(",")},sourceCache:{},ajax:function(a){var b=this.createXMLHTTPObject();if(!b){return}b.open("GET",a,false);b.setRequestHeader("User-Agent","XMLHTTP/1.0");b.send("");return b.responseText},createXMLHTTPObject:function(){var c,a=[function(){return new XMLHttpRequest()},function(){return new ActiveXObject("Msxml2.XMLHTTP")},function(){return new ActiveXObject("Msxml3.XMLHTTP")},function(){return new ActiveXObject("Microsoft.XMLHTTP")}];for(var b=0;b<a.length;b++){try{c=a[b]();this.createXMLHTTPObject=a[b];return c}catch(d){}}},isSameDomain:function(a){return a.indexOf(location.hostname)!==-1},getSource:function(a){if(!(a in this.sourceCache)){this.sourceCache[a]=this.ajax(a).split("\n")}return this.sourceCache[a]},guessFunctions:function(b){for(var d=0;d<b.length;++d){var h=/\{anonymous\}\(.*\)@(\w+:\/\/([\-\w\.]+)+(:\d+)?[^:]+):(\d+):?(\d+)?/;var g=b[d],a=h.exec(g);if(a){var c=a[1],f=a[4];if(c&&this.isSameDomain(c)&&f){var e=this.guessFunctionName(c,f);b[d]=g.replace("{anonymous}",e)}}}return b},guessFunctionName:function(a,c){try{return this.guessFunctionNameFromLines(c,this.getSource(a))}catch(b){return"getSource failed with url: "+a+", exception: "+b.toString()}},guessFunctionNameFromLines:function(h,f){var c=/function ([^(]*)\(([^)]*)\)/;var g=/['"]?([0-9A-Za-z_]+)['"]?\s*[:=]\s*(function|eval|new Function)/;var b="",d=10;for(var e=0;e<d;++e){b=f[h-e]+b;if(b!==undefined){var a=g.exec(b);if(a&&a[1]){return a[1]}else{a=c.exec(b);if(a&&a[1]){return a[1]}}}}return"(?)"}};