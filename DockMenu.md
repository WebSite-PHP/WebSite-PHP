# Class DockMenu #

WebSitePhpObject
> |
> --DockMenu



Location: /display/advanced\_object/menu/dockmenu/DockMenu.class.php


---



**Remarks**

Class DockMenu


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

  * `DOCK_ALIGN_BOTTOM` = ` 'bottom'`


  * `DOCK_ALIGN_LEFT` = ` 'left'`


  * `DOCK_ALIGN_NONE` = ` ''`


  * `DOCK_ALIGN_RIGHT` = ` 'right'`


  * `DOCK_ALIGN_TOP` = ` 'top'`




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



# DockMenu::construct #

**construct(**
[**string**
_$id_ = 'menu\_dock'], [**string**
_$align_ = ''], [**double**
_$top_ = 0], [**double**
_$left_ = 0], [**double**
_$img\_size_ = 48], [**string**
_$opacity_ = '']**);**


Overrides WebSitePhpObject::construct() (Constructor WebSitePhpObject)



**Parameters**
> _$id_ [value: menu\_dock](default.md)
> _$align_
> _$top_ [value: 0](default.md)
> _$left_ [value: 0](default.md)
> _$img\_size_ [value: 48](default.md)
> _$opacity_

**Remarks**

Constructor DockMenu




# DockMenu::addDockMenuItem #

**addDockMenuItem(**
**mixed**
_$dock\_menu\_item\_object_**);**





**Parameters**
> _$dock\_menu\_item\_object_

**Remarks**

Method addDockMenuItem


**since:** 1.0.35

**access:** public



# DockMenu::render #

**render(**
[**boolean**
_$ajax\_render_ = false]**);**


Overrides WebSitePhpObject::render() (Method render)



**Parameters**
> _$ajax\_render_ [value: false](default.md)

**Returns**
> html code of object DockMenu

**Remarks**

Method render


**since:** 1.0.35

**access:** public



# DockMenu::setDockBackground #

**setDockBackground(**
[**string**
_$color_ = '#a5b5d3'], [**string**
_$border\_color_ = '#7890be']**);**





**Parameters**
> _$color_ [value: #a5b5d3](default.md)
> _$border\_color_ [value: #7890be](default.md)

**Remarks**

Method setDockBackground


**since:** 1.0.35

**access:** public



# DockMenu::setDockOpacity #

**setDockOpacity(**
[**double**
_$opacity_ = 0.8]**);**





**Parameters**
> _$opacity_ [value: 0.8](default.md)

**Remarks**

Method setDockOpacity


**since:** 1.0.35

**access:** public



# DockMenu::setLabelsColor #

**setLabelsColor(**
**mixed**
_$color_**);**





**Parameters**
> _$color_

**Remarks**

Method setLabelsColor


**since:** 1.0.35

**access:** public




---


## Variable Detail ##


---

## Class Constant Detail ##

**`DOCK_ALIGN_BOTTOM` = ` 'bottom'` (line 31)**


**`DOCK_ALIGN_LEFT` = ` 'left'` (line 32)**


**`DOCK_ALIGN_NONE` = ` ''` (line 34)**


**`DOCK_ALIGN_RIGHT` = ` 'right'` (line 33)**


**`DOCK_ALIGN_TOP` = ` 'top'` (line 30)**




---
