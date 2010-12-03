function DisplayPngPicture(img) {
         var imgID = (img.id) ? "id='" + img.id + "' " : "";
         var imgClass = (img.className) ? "class='" + img.className + "' " : "";
         var imgTitle = (img.title) ? "title=\"" + img.title + "\" " : "title=\"" + img.alt + "\" ";
         var imgStyle = "display:inline-block;" + img.style.cssText ;
         if (img.align == "left") imgStyle = "float:left;" + imgStyle;
         if (img.align == "right") imgStyle = "float:right;" + imgStyle;
         if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle;
         var imgOnClick = (img.onclick) ? " onClick=\"" + img.onclick + "\" " : "";
         if (imgOnClick != "") {
         	imgOnClick = imgOnClick.replace("function anonymous()\n{\n","").replace("\n}","");
         }
         var imgOnMouseOver = (img.onmouseover) ? " OnMouseOver=\"" + img.onmouseover + "\" " : "";
         if (imgOnMouseOver != "") {
         	imgOnMouseOver = imgOnMouseOver.replace("function anonymous()\n{\n","").replace("\n}","");
         }
         var imgOnMouseOut = (img.onmouseout) ? " OnMouseOut=\"" + img.onmouseout + "\" " : "";
         if (imgOnMouseOut != "") {
         	imgOnMouseOut = imgOnMouseOut.replace("function anonymous()\n{\n","").replace("\n}","");
         }
         var strNewHTML = "<span " + imgID + imgClass + imgTitle + imgOnClick + imgOnMouseOver + imgOnMouseOut
         + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
         + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
         + "(src=\'" + img.src + "\', sizingMethod='scale');\"></span>" ;
         img.outerHTML = strNewHTML;
}

var arVersion = navigator.appVersion.split("MSIE")
var version = parseFloat(arVersion[1])

function LoadPngPicture() {
	if ((version >= 5.5 && version < 7) && (document.body.filters)) 
	{
	   for(var i=0; i<document.images.length; i++)
	   {
	      var img = document.images[i]
		  	var imgName = img.src.toUpperCase();
	      if (imgName.substring(imgName.length-3, imgName.length) == "PNG")
	      {
		    	DisplayPngPicture(img);
					i = i-1;
		  	}
	   }
	}
}
