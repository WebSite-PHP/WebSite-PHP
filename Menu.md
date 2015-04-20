# Class Menu #

WebSitePhpObject
> |
> --Menu



Location: /display/advanced\_object/menu/Menu.class.php


---



**Remarks**

Class Menu


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

  * `POSITION_HORIZONTAL` = ` 'Horizontal'`

> Menu position style
    * `POSITION_NAV_BAR` = ` 'Nav Bar'`

> Menu position style
    * `POSITION_VERTICAL` = ` 'Vertical'`

> Menu position style


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



# Menu::construct #

**construct(**
[**string**
_$position_ = 'Horizontal'], [**string**
_$id_ = 'listMenu']**);**


Overrides WebSitePhpObject::construct() (Constructor WebSitePhpObject)



**Parameters**
> _$position_ [value: Horizontal](default.md)
> _$id_ [value: listMenu](default.md)

**Remarks**

Constructor Menu




# Menu::activateSupersubs #

**activateSupersubs(**
**);**





**Remarks**

Method activateSupersubs


**since:** 1.0.35

**access:** public



# Menu::render #

**render(**
[**boolean**
_$ajax\_render_ = false]**);**


Overrides WebSitePhpObject::render() (Method render)



**Parameters**
> _$ajax\_render_ [value: false](default.md)

**Returns**
> html code of object Menu

**Remarks**

Method render


**since:** 1.0.35

**access:** public



# Menu::setMaxWidth #

**setMaxWidth(**
**mixed**
_$max\_width_**);**





**Parameters**
> _$max\_width_

**Remarks**

Method setMaxWidth


**since:** 1.0.35

**access:** public



# Menu::setMenuItems #

**setMenuItems(**
**MenuItems**
_$menu\_items\_object_**);**





**Parameters**
> _$menu\_items\_object_

**Remarks**

Method setMenuItems


**since:** 1.0.35

**access:** public



# Menu::setMinWidth #

**setMinWidth(**
**mixed**
_$min\_width_**);**





**Parameters**
> _$min\_width_

**Remarks**

Method setMinWidth


**since:** 1.0.35

**access:** public



# Menu::setPosition #

**setPosition(**
**mixed**
_$position_**);**





**Parameters**
> _$position_

**Remarks**

Method setPosition


**since:** 1.0.35

**access:** public




---


## Variable Detail ##


---

## Class Constant Detail ##

**`POSITION_HORIZONTAL` = ` 'Horizontal'` (line 36)**


**Remarks**

Menu position style


**access:** public


**`POSITION_NAV_BAR` = ` 'Nav Bar'` (line 37)**


**Remarks**

Menu position style


**access:** public


**`POSITION_VERTICAL` = ` 'Vertical'` (line 35)**


**Remarks**

Menu position style


**access:** public




---
