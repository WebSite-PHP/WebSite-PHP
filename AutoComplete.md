# Class AutoComplete #

WebSitePhpObject
> |
> --AutoComplete



Location: /display/advanced\_object/autocomplete/AutoComplete.class.php


---



**Remarks**

Class AutoComplete


WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)  Copyright (c) 2009-2014 WebSite-PHP.com  PHP versions >= 5.2Licensed under The MIT License  Redistributions of files must retain the above copyright notice.


**author:** Emilien MOREL <>

**version:** 1.2.8

**copyright:** WebSite-PHP.com 17/01/2014

**link:**

**since:** 1.0.17

**access:** public



---

## Class Variable Summary ##


---

## Class Constant Summary ##



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



# AutoComplete::construct #

**construct(**
**Url**
_$url\_object_, [**double**
_$min\_lenght_ = 4], [**AutoCompleteEvent**
_$autocomplete\_event_ = null], [**string**
_$indicator\_id_ = &quot;&quot;]**);**


Overrides WebSitePhpObject::construct() (Constructor WebSitePhpObject)



**Parameters**
> _$url\_object_
> _$min\_lenght_ [value: 4](default.md)
> _$autocomplete\_event_ [value: null](default.md)
> _$indicator\_id_ id of object to display when searching

**Remarks**

Constructor AutoComplete




# AutoComplete::render #

**render(**
[**boolean**
_$ajax\_render_ = false]**);**


Overrides WebSitePhpObject::render() (Method render)



**Parameters**
> _$ajax\_render_ [value: false](default.md)

**Returns**
> html code of object AutoComplete

**Remarks**

Method render


**since:** 1.0.35

**access:** public



# AutoComplete::setLinkObjectId #

**setLinkObjectId(**
**string**
_$id_**);**





**Parameters**
> _$id_

**Remarks**

Method setLinkObjectId


**since:** 1.0.59

**access:** public



# AutoComplete::setTrackEvent #

**setTrackEvent(**
**mixed**
_$category_, **mixed**
_$action_, [**string**
_$label_ = ''], [**boolean**
_$use\_search\_value_ = true]**);**





**Parameters**
> _$category_
> _$action_
> _$label_
> _$use\_search\_value_ [value: true](default.md)

**Remarks**

Method setTrackEvent


**since:** 1.0.95

**access:** public



# AutoComplete::setTrackPageView #

**setTrackPageView(**
**);**





**Remarks**

Method setTrackPageView


**since:** 1.0.95

**access:** public




---


## Variable Detail ##


---

## Class Constant Detail ##



---
