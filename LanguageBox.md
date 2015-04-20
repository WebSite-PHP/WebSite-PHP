# Class LanguageBox #

WebSitePhpObject
> |
> --LanguageBox



Location: /display/advanced\_object/language/LanguageBox.class.php


---



**Remarks**

Class LanguageBox


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

  * `STYLE_MAIN` = ` '1'`

> LanguageBox style
    * `STYLE_SECOND` = ` '2'`

> LanguageBox style


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



# LanguageBox::construct #

**construct(**
[**boolean**
_$shadow_ = false], [**string**
_$style\_header_ = '1'], [**string**
_$style\_content_ = '1']**);**


Overrides WebSitePhpObject::construct() (Constructor WebSitePhpObject)



**Parameters**
> _$shadow_ if box has shadow [value: false](default.md)
> _$style\_header_ style of the header (Box::STYLE\_MAIN or Box::STYLE\_SECOND) [value: 1](default.md)
> _$style\_content_ style of the content (Box::STYLE\_MAIN or Box::STYLE\_SECOND) [value: 1](default.md)

**Remarks**

Constructor LanguageBox




# LanguageBox::addLanguage #

**addLanguage(**
**string**
_$language\_code_**);**





**Parameters**
> _$language\_code_ language code (ex: en, fr, de, ...)

**Remarks**

Method addLanguage


**since:** 1.0.33

**access:** public



# LanguageBox::render #

**render(**
[**boolean**
_$ajax\_render_ = false]**);**


Overrides WebSitePhpObject::render() (Method render)



**Parameters**
> _$ajax\_render_ [value: false](default.md)

**Returns**
> html box with country flag

**Remarks**

Method render


**since:** 1.0.33

**access:** public



# LanguageBox::setBigIcon #

**setBigIcon(**
**mixed**
_$icon\_48\_pixels_, [**string**
_$text_ = '']**);**





**Parameters**
> _$icon\_48\_pixels_
> _$text_

**Remarks**

Method setBigIcon


**since:** 1.0.33

**access:** public



# LanguageBox::setSmallIcon #

**setSmallIcon(**
**mixed**
_$icon\_16\_pixels_, [**string**
_$text_ = '']**);**





**Parameters**
> _$icon\_16\_pixels_
> _$text_

**Remarks**

Method setSmallIcon


**since:** 1.0.33

**access:** public



# LanguageBox::setWidth #

**setWidth(**
**integer**
_$width_**);**





**Parameters**
> _$width_

**Remarks**

Method setWidth


**since:** 1.0.33

**access:** public




---


## Variable Detail ##


---

## Class Constant Detail ##

**`STYLE_MAIN` = ` '1'` (line 33)**


**Remarks**

LanguageBox style


**access:** public


**`STYLE_SECOND` = ` '2'` (line 34)**


**Remarks**

LanguageBox style


**access:** public




---
