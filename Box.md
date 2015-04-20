# Class Box #

WebSitePhpObject
> |
> --Box



Location: /display/advanced\_object/Box.class.php


---



**Remarks**

Class Box


WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)  Copyright (c) 2009-2014 WebSite-PHP.com  PHP versions >= 5.2Licensed under The MIT License  Redistributions of files must retain the above copyright notice.


**author:** Emilien MOREL <>

**version:** 1.2.9

**copyright:** WebSite-PHP.com 17/01/2014

**link:**

**since:** 1.0.17

**access:** public



---

## Class Variable Summary ##


---

## Class Constant Summary ##

  * `ALIGN_CENTER` = ` 'center'`

> Box alignment
    * `ALIGN_JUSTIFY` = ` 'justify'`

> Box alignment
    * `ALIGN_LEFT` = ` 'left'`

> Box alignment
    * `ALIGN_RIGHT` = ` 'right'`

> Box alignment
    * `STYLE_MAIN` = ` '1'`

> Box style
    * `STYLE_SECOND` = ` '2'`

> Box style
    * `VALIGN_BOTTOM` = ` 'bottom'`

> Box vertical alignment
    * `VALIGN_CENTER` = ` 'center'`

> Box vertical alignment
    * `VALIGN_TOP` = ` 'top'`

> Box vertical alignment


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



# Box::construct #

**construct(**
**object|string**
_$title_, [**boolean**
_$shadow_ = false], [**string**
_$style\_header_ = '1'], [**string**
_$style\_content_ = '1'], [**string**
_$link_ = ''], [**string**
_$id_ = 'main\_box'], [**string**
_$width_ = '100%'], [**string**
_$height_ = &quot;&quot;], [**string**
_$move_ = false]**);**


Overrides WebSitePhpObject::construct() (Constructor WebSitePhpObject)



**Parameters**
> _$title_ title in the header the box
> _$shadow_ if box has shadow [value: false](default.md)
> _$style\_header_ style of the header (Box::STYLE\_MAIN or Box::STYLE\_SECOND) [value: 1](default.md)
> _$style\_content_ style of the content (Box::STYLE\_MAIN or Box::STYLE\_SECOND) [value: 1](default.md)
> _$link_ heander title link
> _$id_ unique id of the box [value: main\_box](default.md)
> _$width_ width of the box [value: 100%](default.md)
> _$height_ height of the box
> _$move_ if box can be move [value: false](default.md)

**Remarks**

Constructor Box




# Box::forceBoxWithPicture #

**forceBoxWithPicture(**
**boolean**
_$bool_, [**string**
_$border\_color_ = &quot;&quot;]**);**





**Parameters**
> _$bool_
> _$border\_color_

**Remarks**

Method forceBoxWithPicture


**since:** 1.0.35

**access:** public



# Box::getAjaxRender #

**getAjaxRender(**
**);**


Overrides WebSitePhpObject::getAjaxRender() (Method getAjaxRender)



**Returns**
> javascript code to update initial html of object Box (call with AJAX)

**Remarks**

Method getAjaxRender


**since:** 1.0.35

**access:** public



# Box::render #

**render(**
[**boolean**
_$ajax\_render_ = false]**);**


Overrides WebSitePhpObject::render() (Method render)



**Parameters**
> _$ajax\_render_ [value: false](default.md)

**Returns**
> html code of object Box

**Remarks**

Method render


**since:** 1.0.35

**access:** public



# Box::setAlign #

**setAlign(**
**string**
_$align_**);**





**Parameters**
> _$align_

**Remarks**

Method setAlign


**since:** 1.0.35

**access:** public



# Box::setBigIcon #

**setBigIcon(**
**string**
_$icon\_48\_pixels_, [**string**
_$text_ = '']**);**





**Parameters**
> _$icon\_48\_pixels_
> _$text_

**Remarks**

Method setBigIcon


**since:** 1.0.35

**access:** public



# Box::setContent #

**setContent(**
**object|string**
_$content_**);**





**Parameters**
> _$content_ content of the box

**Remarks**

Method setContent


**since:** 1.0.35

**access:** public



# Box::setDraggable #

**setDraggable(**
[**boolean**
_$bool_ = true], [**boolean**
_$revert_ = false]**);**





**Parameters**
> _$bool_ if box can be move [value: true](default.md)
> _$revert_ if box revert first place when dropped [value: false](default.md)

**Remarks**

Method setDraggable


**since:** 1.0.35

**access:** public



# Box::setHeight #

**setHeight(**
**integer**
_$height_**);**





**Parameters**
> _$height_

**Remarks**

Method setHeight


**since:** 1.0.35

**access:** public



# Box::setShadow #

**setShadow(**
**boolean**
_$shadow_**);**





**Parameters**
> _$shadow_

**Remarks**

Method setShadow


**since:** 1.0.35

**access:** public



# Box::setSmallIcon #

**setSmallIcon(**
**string**
_$icon\_16\_pixels_, [**string**
_$text_ = '']**);**





**Parameters**
> _$icon\_16\_pixels_ path to icon 16px x 16px
> _$text_

**Remarks**

Method setSmallIcon


**since:** 1.0.35

**access:** public



# Box::setTitle #

**setTitle(**
**string**
_$title_**);**





**Parameters**
> _$title_

**Remarks**

Method setTitle


**since:** 1.0.75

**access:** public



# Box::setTitleTagH1 #

**setTitleTagH1(**
**);**





**Remarks**

Method setTitleTagH1


**since:** 1.0.35

**access:** public



# Box::setTitleTagH2 #

**setTitleTagH2(**
**);**





**Remarks**

Method setTitleTagH2


**since:** 1.0.35

**access:** public



# Box::setTitleTagH3 #

**setTitleTagH3(**
**);**





**Remarks**

Method setTitleTagH3


**since:** 1.0.35

**access:** public



# Box::setTitleTagH4 #

**setTitleTagH4(**
**);**





**Remarks**

Method setTitleTagH4


**since:** 1.0.35

**access:** public



# Box::setValign #

**setValign(**
**string**
_$valign_**);**





**Parameters**
> _$valign_

**Remarks**

Method setValign


**since:** 1.0.35

**access:** public



# Box::setWidth #

**setWidth(**
**integer**
_$width_**);**





**Parameters**
> _$width_

**Remarks**

Method setWidth


**since:** 1.0.35

**access:** public




---


## Variable Detail ##


---

## Class Constant Detail ##

**`ALIGN_CENTER` = ` 'center'` (line 43)**


**Remarks**

Box alignment


**access:** public


**`ALIGN_JUSTIFY` = ` 'justify'` (line 45)**


**Remarks**

Box alignment


**access:** public


**`ALIGN_LEFT` = ` 'left'` (line 42)**


**Remarks**

Box alignment


**access:** public


**`ALIGN_RIGHT` = ` 'right'` (line 44)**


**Remarks**

Box alignment


**access:** public


**`STYLE_MAIN` = ` '1'` (line 33)**


**Remarks**

Box style


**access:** public


**`STYLE_SECOND` = ` '2'` (line 34)**


**Remarks**

Box style


**access:** public


**`VALIGN_BOTTOM` = ` 'bottom'` (line 55)**


**Remarks**

Box vertical alignment


**access:** public


**`VALIGN_CENTER` = ` 'center'` (line 54)**


**Remarks**

Box vertical alignment


**access:** public


**`VALIGN_TOP` = ` 'top'` (line 53)**


**Remarks**

Box vertical alignment


**access:** public




---
