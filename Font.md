# Class Font #

WebSitePhpObject
> |
> --Font



Location: /display/Font.class.php


---



**Remarks**

Class Font


WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)  Copyright (c) 2009-2014 WebSite-PHP.com  PHP versions >= 5.2Licensed under The MIT License  Redistributions of files must retain the above copyright notice.


**author:** Emilien MOREL <>

**version:** 1.2.7

**copyright:** WebSite-PHP.com 17/01/2014

**link:**

**since:** 1.0.17

**access:** public



---

## Class Variable Summary ##


---

## Class Constant Summary ##

  * `FONT_ARIAL` = ` 'Arial'`

> Font family
    * `FONT_TIMES` = ` 'Times New Roman'`

> Font family
    * `FONT_WEIGHT_BOLD` = ` 'bold'`

> Font weight
    * `FONT_WEIGHT_NONE` = ` 'none'`

> Font weight


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



# Font::construct #

**construct(**
**object**
_$content\_object_, [**string**
_$font\_size_ = ''], [**string**
_$font\_family_ = ''], [**string**
_$font\_weight_ = '']**);**


Overrides WebSitePhpObject::construct() (Constructor WebSitePhpObject)



**Parameters**
> _$content\_object_
> _$font\_size_
> _$font\_family_
> _$font\_weight_

**Remarks**

Constructor Font




# Font::getAjaxRender #

**getAjaxRender(**
**);**


Overrides WebSitePhpObject::getAjaxRender() (Method getAjaxRender)



**Returns**
> javascript code to update initial html of object Font (call with AJAX)

**Remarks**

Method getAjaxRender


**since:** 1.0.35

**access:** public



# Font::getId #

**getId(**
**);**





**Remarks**

Method getId


**since:** 1.0.35

**access:** public



# Font::render #

**render(**
[**boolean**
_$ajax\_render_ = false]**);**


Overrides WebSitePhpObject::render() (Method render)



**Parameters**
> _$ajax\_render_ [value: false](default.md)

**Returns**
> html code of object Font

**Remarks**

Method render


**since:** 1.0.35

**access:** public



# Font::setFontColor #

**setFontColor(**
**mixed**
_$font\_color_**);**





**Parameters**
> _$font\_color_

**Remarks**

Method setFontColor


**since:** 1.0.35

**access:** public



# Font::setFontFamily #

**setFontFamily(**
**mixed**
_$font\_family_**);**





**Parameters**
> _$font\_family_

**Remarks**

Method setFontFamily


**since:** 1.0.35

**access:** public



# Font::setFontSize #

**setFontSize(**
**mixed**
_$font\_size_**);**





**Parameters**
> _$font\_size_

**Remarks**

Method setFontSize


**since:** 1.0.35

**access:** public



# Font::setFontWeight #

**setFontWeight(**
**mixed**
_$font\_weight_**);**





**Parameters**
> _$font\_weight_

**Remarks**

Method setFontWeight


**since:** 1.0.35

**access:** public



# Font::setId #

**setId(**
**mixed**
_$id_**);**





**Parameters**
> _$id_

**Remarks**

Method setId


**since:** 1.0.59

**access:** public




---


## Variable Detail ##


---

## Class Constant Detail ##

**`FONT_ARIAL` = ` 'Arial'` (line 31)**


**Remarks**

Font family


**access:** public


**`FONT_TIMES` = ` 'Times New Roman'` (line 32)**


**Remarks**

Font family


**access:** public


**`FONT_WEIGHT_BOLD` = ` 'bold'` (line 40)**


**Remarks**

Font weight


**access:** public


**`FONT_WEIGHT_NONE` = ` 'none'` (line 41)**


**Remarks**

Font weight


**access:** public




---
