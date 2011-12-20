jQuery.fn.dataTableExt.oSort['alt-string-asc']  = function(a,b) {
   var x = a.match(/alt="(.*?)"/)[1].toLowerCase();
   var y = b.match(/alt="(.*?)"/)[1].toLowerCase();
   return ((x < y) ? -1 : ((x > y) ?  1 : 0));
};
 
jQuery.fn.dataTableExt.oSort['alt-string-desc'] = function(a,b) {
   var x = a.match(/alt="(.*?)"/)[1].toLowerCase();
   var y = b.match(/alt="(.*?)"/)[1].toLowerCase();
   return ((x < y) ?  1 : ((x > y) ? -1 : 0));
};
jQuery.fn.dataTableExt.oSort['anti-the-asc']  = function(a,b) {
    var x = a.replace(/^the /i, "");
    var y = b.replace(/^the /i, "");
    return ((x < y) ? -1 : ((x > y) ? 1 : 0));
};
 
jQuery.fn.dataTableExt.oSort['anti-the-desc'] = function(a,b) {
    var x = a.replace(/^the /i, "");
    var y = b.replace(/^the /i, "");
    return ((x < y) ? 1 : ((x > y) ? -1 : 0));
};
jQuery.fn.dataTableExt.oSort['numeric-comma-asc']  = function(a,b) {
    var x = (a == "-") ? 0 : a.replace( /,/, "." );
    var y = (b == "-") ? 0 : b.replace( /,/, "." );
    x = parseFloat( x );
    y = parseFloat( y );
    return ((x < y) ? -1 : ((x > y) ?  1 : 0));
};
 
jQuery.fn.dataTableExt.oSort['numeric-comma-desc'] = function(a,b) {
    var x = (a == "-") ? 0 : a.replace( /,/, "." );
    var y = (b == "-") ? 0 : b.replace( /,/, "." );
    x = parseFloat( x );
    y = parseFloat( y );
    return ((x < y) ?  1 : ((x > y) ? -1 : 0));
};
jQuery.fn.dataTableExt.oSort['currency-asc'] = function(a,b) {
    /* Remove any commas (assumes that if present all strings will have a fixed number of d.p) */
    var x = a == "-" ? 0 : a.replace( /,/g, "" );
    var y = b == "-" ? 0 : b.replace( /,/g, "" );
     
    /* Remove the currency sign */
    x = x.substring( 1 );
    y = y.substring( 1 );
     
    /* Parse and return */
    x = parseFloat( x );
    y = parseFloat( y );
    return x - y;
};
 
jQuery.fn.dataTableExt.oSort['currency-desc'] = function(a,b) {
    /* Remove any commas (assumes that if present all strings will have a fixed number of d.p) */
    var x = a == "-" ? 0 : a.replace( /,/g, "" );
    var y = b == "-" ? 0 : b.replace( /,/g, "" );
     
    /* Remove the currency sign */
    x = x.substring( 1 );
    y = y.substring( 1 );
     
    /* Parse and return */
    x = parseFloat( x );
    y = parseFloat( y );
    return y - x;
};
jQuery.fn.dataTableExt.oSort['date-euro-asc'] = function(a, b) {
    if (trim(a) != '') {
        var frDatea = trim(a).split(' ');
        var frTimea = frDatea[1].split(':');
        var frDatea2 = frDatea[0].split('/');
        var x = (frDatea2[2] + frDatea2[1] + frDatea2[0] + frTimea[0] + frTimea[1] + frTimea[2]) * 1;
    } else {
        var x = 10000000000000; // = l'an 1000 ...
    }
 
    if (trim(b) != '') {
        var frDateb = trim(b).split(' ');
        var frTimeb = frDateb[1].split(':');
        frDateb = frDateb[0].split('/');
        var y = (frDateb[2] + frDateb[1] + frDateb[0] + frTimeb[0] + frTimeb[1] + frTimeb[2]) * 1;                      
    } else {
        var y = 10000000000000;                     
    }
    var z = ((x < y) ? -1 : ((x > y) ? 1 : 0));
    return z;
};
 
jQuery.fn.dataTableExt.oSort['date-euro-desc'] = function(a, b) {
    if (trim(a) != '') {
        var frDatea = trim(a).split(' ');
        var frTimea = frDatea[1].split(':');
        var frDatea2 = frDatea[0].split('/');
        var x = (frDatea2[2] + frDatea2[1] + frDatea2[0] + frTimea[0] + frTimea[1] + frTimea[2]) * 1;                       
    } else {
        var x = 10000000000000;                     
    }
 
    if (trim(b) != '') {
        var frDateb = trim(b).split(' ');
        var frTimeb = frDateb[1].split(':');
        frDateb = frDateb[0].split('/');
        var y = (frDateb[2] + frDateb[1] + frDateb[0] + frTimeb[0] + frTimeb[1] + frTimeb[2]) * 1;                      
    } else {
        var y = 10000000000000;                     
    }                   
    var z = ((x < y) ? 1 : ((x > y) ? -1 : 0));                   
    return z;
};
jQuery.fn.dataTableExt.oSort['uk_date-asc']  = function(a,b) {
    var ukDatea = a.split('/');
    var ukDateb = b.split('/');
     
    var x = (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
    var y = (ukDateb[2] + ukDateb[1] + ukDateb[0]) * 1;
     
    return ((x < y) ? -1 : ((x > y) ?  1 : 0));
};
 
jQuery.fn.dataTableExt.oSort['uk_date-desc'] = function(a,b) {
    var ukDatea = a.split('/');
    var ukDateb = b.split('/');
     
    var x = (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
    var y = (ukDateb[2] + ukDateb[1] + ukDateb[0]) * 1;
     
    return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
};
jQuery.fn.dataTableExt.oSort['file-size-asc']  = function(a,b) {
    var x = a.substring(0,a.length - 2);
    var y = b.substring(0,b.length - 2);
        
    var x_unit = (a.substring(a.length - 2, a.length) == "MB" ? 
        1000 : (a.substring(a.length - 2, a.length) == "GB" ? 1000000 : 1));
    var y_unit = (b.substring(b.length - 2, b.length) == "MB" ? 
        1000 : (b.substring(b.length - 2, b.length) == "GB" ? 1000000 : 1));
     
    x = parseInt( x * x_unit );
    y = parseInt( y * y_unit );
     
    return ((x < y) ? -1 : ((x > y) ?  1 : 0));
};
 
jQuery.fn.dataTableExt.oSort['file-size-desc'] = function(a,b) {
    var x = a.substring(0,a.length - 2);
    var y = b.substring(0,b.length - 2);
 
    var x_unit = (a.substring(a.length - 2, a.length) == "MB" ? 
        1000 : (a.substring(a.length - 2, a.length) == "GB" ? 1000000 : 1));
    var y_unit = (b.substring(b.length - 2, b.length) == "MB" ? 
        1000 : (b.substring(b.length - 2, b.length) == "GB" ? 1000000 : 1));
 
    x = parseInt( x * x_unit);
    y = parseInt( y * y_unit);
 
    return ((x < y) ?  1 : ((x > y) ? -1 : 0));
};
jQuery.fn.dataTableExt.oSort['formatted-num-asc'] = function(x,y){
 x = x.replace(/[^\d\-\.\/]/g,'');
 y = y.replace(/[^\d\-\.\/]/g,'');
 if(x.indexOf('/')>=0)x = eval(x);
 if(y.indexOf('/')>=0)y = eval(y);
 return x/1 - y/1;
};
jQuery.fn.dataTableExt.oSort['formatted-num-desc'] = function(x,y){
 x = x.replace(/[^\d\-\.\/]/g,'');
 y = y.replace(/[^\d\-\.\/]/g,'');
 if(x.indexOf('/')>=0)x = eval(x);
 if(y.indexOf('/')>=0)y = eval(y);
 return y/1 - x/1;
};
jQuery.fn.dataTableExt.oSort['title-numeric-asc']  = function(a,b) {
    var x = a.match(/title="*(-?[0-9\.]+)/)[1];
    var y = b.match(/title="*(-?[0-9\.]+)/)[1];
    x = parseFloat( x );
    y = parseFloat( y );
    return ((x < y) ? -1 : ((x > y) ?  1 : 0));
};
 
jQuery.fn.dataTableExt.oSort['title-numeric-desc'] = function(a,b) {
    var x = a.match(/title="*(-?[0-9\.]+)/)[1];
    var y = b.match(/title="*(-?[0-9\.]+)/)[1];
    x = parseFloat( x );
    y = parseFloat( y );
    return ((x < y) ?  1 : ((x > y) ? -1 : 0));
};
jQuery.fn.dataTableExt.oSort['value-numeric-asc']  = function(a,b) {
    var x = a.match(/value="*(-?[0-9\.]+)/)[1];
    var y = b.match(/value="*(-?[0-9\.]+)/)[1];
    x = parseFloat( x );
    y = parseFloat( y );
    return ((x < y) ? -1 : ((x > y) ?  1 : 0));
};
 
jQuery.fn.dataTableExt.oSort['value-numeric-desc'] = function(a,b) {
    var x = a.match(/value="*(-?[0-9\.]+)/)[1];
    var y = b.match(/value="*(-?[0-9\.]+)/)[1];
    x = parseFloat( x );
    y = parseFloat( y );
    return ((x < y) ?  1 : ((x > y) ? -1 : 0));
};
jQuery.fn.dataTableExt.oSort['title-string-asc']  = function(a,b) {
    var x = a.match(/title="(.*?)"/)[1].toLowerCase();
    var y = b.match(/title="(.*?)"/)[1].toLowerCase();
    return ((x < y) ? -1 : ((x > y) ?  1 : 0));
};
 
jQuery.fn.dataTableExt.oSort['title-string-desc'] = function(a,b) {
    var x = a.match(/title="(.*?)"/)[1].toLowerCase();
    var y = b.match(/title="(.*?)"/)[1].toLowerCase();
    return ((x < y) ?  1 : ((x > y) ? -1 : 0));
};
jQuery.fn.dataTableExt.oSort['value-string-asc']  = function(a,b) {
    var x = a.match(/value="(.*?)"/)[1].toLowerCase();
    var y = b.match(/value="(.*?)"/)[1].toLowerCase();
    return ((x < y) ? -1 : ((x > y) ?  1 : 0));
};
 
jQuery.fn.dataTableExt.oSort['value-string-desc'] = function(a,b) {
    var x = a.match(/value="(.*?)"/)[1].toLowerCase();
    var y = b.match(/value="(.*?)"/)[1].toLowerCase();
    return ((x < y) ?  1 : ((x > y) ? -1 : 0));
};
jQuery.fn.dataTableExt.oSort['ip-address-asc']  = function(a,b) {
    var m = a.split("."), x = "";
    var n = b.split("."), y = "";
    for(var i = 0; i < m.length; i++) {
        var item = m[i];
        if(item.length == 1) {
            x += "00" + item;
        } else if(item.length == 2) {
            x += "0" + item;
        } else {
            x += item;
        }
    }
    for(var i = 0; i < n.length; i++) {
        var item = n[i];
        if(item.length == 1) {
            y += "00" + item;
        } else if(item.length == 2) {
            y += "0" + item;
        } else {
            y += item;
        }
    }
    return ((x < y) ? -1 : ((x > y) ? 1 : 0));
};
 
jQuery.fn.dataTableExt.oSort['ip-address-desc']  = function(a,b) {
    var m = a.split("."), x = "";
    var n = b.split("."), y = "";
    for(var i = 0; i < m.length; i++) {
        var item = m[i];
        if(item.length == 1) {
            x += "00" + item;
        } else if (item.length == 2) {
            x += "0" + item;
        } else {
            x += item;
        }
    }
    for(var i = 0; i < n.length; i++) {
        var item = n[i];
        if(item.length == 1) {
            y += "00" + item;
        } else if (item.length == 2) {
            y += "0" + item;
        } else {
            y += item;
        }
    }
    return ((x < y) ? 1 : ((x > y) ? -1 : 0));
};
jQuery.fn.dataTableExt.oSort['monthYear-sort-asc']  = function(a,b) {
    a = new Date('01 '+a);
    b = new Date('01 '+b);
    return ((a < b) ? -1 : ((a > b) ?  1 : 0));
};
 
jQuery.fn.dataTableExt.oSort['monthYear-sort-desc'] = function(a,b) {
    a = new Date('01 '+a);
    b = new Date('01 '+b);
    return ((a < b) ? 1 : ((a > b) ?  -1 : 0));
};
jQuery.fn.dataTableExt.oSort['num-html-asc']  = function(a,b) {
	var x = a.replace( /<.*?>/g, "" );
    var y = b.replace( /<.*?>/g, "" );
    x = parseFloat( x );
    y = parseFloat( y );
    return ((x < y) ? -1 : ((x > y) ?  1 : 0));
};
 
jQuery.fn.dataTableExt.oSort['num-html-desc'] = function(a,b) {
    var x = a.replace( /<.*?>/g, "" );
    var y = b.replace( /<.*?>/g, "" );
    x = parseFloat( x );
    y = parseFloat( y );
    return ((x < y) ?  1 : ((x > y) ? -1 : 0));
};
jQuery.fn.dataTableExt.oSort['percent-asc']  = function(a,b) {
    var x = (a == "-") ? 0 : a.replace( /%/, "" );
    var y = (b == "-") ? 0 : b.replace( /%/, "" );
    x = parseFloat( x );
    y = parseFloat( y );
    return ((x < y) ? -1 : ((x > y) ?  1 : 0));
};
 
jQuery.fn.dataTableExt.oSort['percent-desc'] = function(a,b) {
    var x = (a == "-") ? 0 : a.replace( /%/, "" );
    var y = (b == "-") ? 0 : b.replace( /%/, "" );
    x = parseFloat( x );
    y = parseFloat( y );
    return ((x < y) ?  1 : ((x > y) ? -1 : 0));
};
fnPriority=function( a )
{
    if ( a == "High" )        { return 1; }
    else if ( a == "Medium" ) { return 2; }
    else if ( a == "Low" )    { return 3; }
    return 4;
};
jQuery.fn.dataTableExt.oSort['priority-asc']  = function(a,b) {
    var x = fnPriority( a );
    var y = fnPriority( b );
     
    return ((x < y) ? -1 : ((x > y) ? 1 : 0));
};
jQuery.fn.dataTableExt.oSort['priority-desc'] = function(a,b) {
    var x = fnPriority( a );
    var y = fnPriority( b );
     
    return ((x < y) ? 1 : ((x > y) ? -1 : 0));
};
jQuery.fn.dataTableExt.oSort['signed-num-asc'] = function(x,y){
    x = (x=="-" || x==="") ? 0 : x.replace('+','')*1;
    y = (y=="-" || y==="") ? 0 : y.replace('+','')*1;
    return x - y;
};
jQuery.fn.dataTableExt.oSort['signed-num-desc'] = function(x,y){
    x = (x=="-" || x==="") ? 0 : x.replace('+','')*1;
    y = (y=="-" || y==="") ? 0 : y.replace('+','')*1;
    return y - x;
};