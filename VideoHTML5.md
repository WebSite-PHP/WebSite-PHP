# Class VideoHTML5 #

WebSitePhpObject
> |
> --VideoHTML5



Location: /modules/Video/VideoHTML5.class.php


---



**Remarks**

Class VideoHTML5


WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)  Copyright (c) 2009-2014 WebSite-PHP.com  PHP versions >= 5.2Licensed under The MIT License  Redistributions of files must retain the above copyright notice.


**author:** Emilien MOREL <>

**version:** 1.2.9

**copyright:** WebSite-PHP.com 17/01/2014

**link:**

**since:** 1.0.87

**access:** public



---

## Class Variable Summary ##


---

## Class Constant Summary ##

  * `STYLE_NONE` = ` ''`


  * `STYLE_TUBE` = ` 'tube'`




---

## Inherited Class Constant Summary ##



---

## Inherited Class Variable Summary ##

### Inherited From Class WebSitePhpObject ###

  * `WebSitePhpObject::$is_javascript_object` = ` false`


  * `WebSitePhpObject::$is_new_object_after_init` = ` false`


  * `WebSitePhpObject::$object_change` = ` false`


  * `WebSitePhpObject::$tag` = ` ''`






---

## Method Summary ##


## Inherited Method Summary ##

### Inherited From Class WebSitePhpObject ###

  * `WebSitePhpObject::__construct()`
> Constructor WebSitePhpObject
    * `WebSitePhpObject::addCss()`
> Method addCss
    * `WebSitePhpObject::addJavaScript()`
> Method addJavaScript
    * `WebSitePhpObject::displayJavascriptTag()`
> Method displayJavascriptTag
    * `WebSitePhpObject::forceAjaxRender()`

  * `WebSitePhpObject::getAjaxRender()`
> Method getAjaxRender
    * `WebSitePhpObject::getClass()`

  * `WebSitePhpObject::getCssArray()`
> Method getCssArray
    * `WebSitePhpObject::getJavaScriptArray()`
> Method getJavaScriptArray
    * `WebSitePhpObject::getJavascriptTagClose()`
> Method getJavascriptTagClose
    * `WebSitePhpObject::getJavascriptTagOpen()`
> Method getJavascriptTagOpen
    * `WebSitePhpObject::getName()`
> Method getName
    * `WebSitePhpObject::getPage()`
> Method getPage
    * `WebSitePhpObject::getRegisterObjects()`
> Method getRegisterObjects
    * `WebSitePhpObject::getTag()`
> Method getTag
    * `WebSitePhpObject::getType()`

  * `WebSitePhpObject::isEventObject()`
> Method isEventObject
    * `WebSitePhpObject::isJavascriptObject()`
> Method isJavascriptObject
    * `WebSitePhpObject::isObjectChange()`
> Method isObjectChange
    * `WebSitePhpObject::render()`
> Method render
    * `WebSitePhpObject::setTag()`
> Method setTag


---

## Method Detail ##



# VideoHTML5::construct #

**construct(**
**integer**
_$width_, **integer**
_$height_**);**


Overrides WebSitePhpObject::construct() (Constructor WebSitePhpObject)



**Parameters**
> _$width_
> _$height_

**Remarks**

Constructor VideoHTML5




# VideoHTML5::activeAutostart #

**activeAutostart(**
**);**





**Remarks**

Method activeAutostart


**since:** 1.0.87

**access:** public



# VideoHTML5::getOnEndedJs #

**getOnEndedJs(**
**);**





**Remarks**

Method getOnEndedJs


**since:** 1.0.99

**access:** public



# VideoHTML5::getOnPauseJs #

**getOnPauseJs(**
**);**





**Remarks**

Method getOnPauseJs


**since:** 1.0.99

**access:** public



# VideoHTML5::getOnPlayJs #

**getOnPlayJs(**
**);**





**Remarks**

Method getOnPlayJs


**since:** 1.0.99

**access:** public



# VideoHTML5::onEndedJs #

**onEndedJs(**
**mixed**
_$js\_function_**);**





**Parameters**
> _$js\_function_

**Remarks**

Method onEndedJs


**since:** 1.0.99

**access:** public



# VideoHTML5::onPauseJs #

**onPauseJs(**
**mixed**
_$js\_function_**);**





**Parameters**
> _$js\_function_

**Remarks**

Method onPauseJs


**since:** 1.0.99

**access:** public



# VideoHTML5::onPlayJs #

**onPlayJs(**
**mixed**
_$js\_function_**);**





**Parameters**
> _$js\_function_

**Remarks**

Method onPlayJs


**since:** 1.0.99

**access:** public



# VideoHTML5::render #

**render(**
[**boolean**
_$ajax\_render_ = false]**);**


Overrides WebSitePhpObject::render() (Method render)



**Parameters**
> _$ajax\_render_ [value: false](default.md)

**Returns**
> html code of object VideoHTML5

**Remarks**

Method render


**since:** 1.0.87

**access:** public



# VideoHTML5::setAutoBuffering #

**setAutoBuffering(**
**mixed**
_$autobuffering_**);**





**Parameters**
> _$autobuffering_

**Remarks**

Method setAutoBuffering


**since:** 1.0.87

**access:** public



# VideoHTML5::setMP4Video #

**setMP4Video(**
**mixed**
_$video\_mp4_**);**





**Parameters**
> _$video\_mp4_

**Remarks**

Method setMP4Video


**since:** 1.2.2

**access:** public



# VideoHTML5::setOggVideo #

**setOggVideo(**
**mixed**
_$video\_ogg_**);**





**Parameters**
> _$video\_ogg_

**Remarks**

Method setOggVideo


**since:** 1.2.2

**access:** public



# VideoHTML5::setSnapshot #

**setSnapshot(**
**mixed**
_$snapshot_**);**





**Parameters**
> _$snapshot_

**Remarks**

Method setSnapshot


**since:** 1.0.87

**access:** public



# VideoHTML5::setStyle #

**setStyle(**
**mixed**
_$style_**);**





**Parameters**
> _$style_

**Remarks**

Method setStyle


**since:** 1.0.87

**access:** public



# VideoHTML5::setTrackEvent #

**setTrackEvent(**
**mixed**
_$category_, **mixed**
_$action_, [**string**
_$label_ = '']**);**





**Parameters**
> _$category_
> _$action_
> _$label_

**Remarks**

Method setTrackEvent


**since:** 1.0.99

**access:** public



# VideoHTML5::setVideo #

**setVideo(**
**mixed**
_$video\_mp4_, [**string**
_$video\_webm_ = ''], [**string**
_$video\_ogg_ = '']**);**





**Parameters**
> _$video\_mp4_
> _$video\_webm_
> _$video\_ogg_

**Remarks**

Method setVideo


**since:** 1.0.87

**access:** public



# VideoHTML5::setWebMVideo #

**setWebMVideo(**
**mixed**
_$video\_webm_**);**





**Parameters**
> _$video\_webm_

**Remarks**

Method setWebMVideo


**since:** 1.2.2

**access:** public



# VideoHTML5::showDownloadLinks #

**showDownloadLinks(**
**);**





**Remarks**

Method showDownloadLinks


**since:** 1.2.2

**access:** public




---


## Variable Detail ##


---

## Class Constant Detail ##

**`STYLE_NONE` = ` ''` (line 28)**


**`STYLE_TUBE` = ` 'tube'` (line 29)**




---
