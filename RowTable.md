# Class RowTable #

WebSitePhpObject
> |
> --RowTable



Location: /display/RowTable.class.php


---



**Remarks**

Class RowTable


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

  * `ALIGN_CENTER` = ` 'center'`

> RowTable alignment
    * `ALIGN_LEFT` = ` 'left'`

> RowTable alignment
    * `ALIGN_RIGHT` = ` 'right'`

> RowTable alignment
    * `STYLE_MAIN` = ` '1'`

> RowTable style class
    * `STYLE_SECOND` = ` '2'`

> RowTable style class
    * `VALIGN_BOTTOM` = ` 'bottom'`

> RowTable vertical alignment
    * `VALIGN_CENTER` = ` 'center'`

> RowTable vertical alignment
    * `VALIGN_TOP` = ` 'top'`

> RowTable vertical alignment


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



# RowTable::add #

**add(**
[**object**
_$content\_object_ = null], [**string**
_$align_ = ''], [**string**
_$width_ = ''], [**string**
_$class_ = ''], [**string**
_$valign_ = ''], [**string**
_$style_ = ''], [**string**
_$colspan_ = ''], [**string**
_$rowspan_ = '']**);**





**Parameters**
> _$content\_object_ [value: null](default.md)
> _$align_
> _$width_
> _$class_
> _$valign_
> _$style_
> _$colspan_
> _$rowspan_

**Remarks**

Method add


**since:** 1.0.36

**access:** public



# RowTable::construct #

**construct(**
[**string**
_$align_ = 'center'], [**string**
_$width_ = ''], [**string**
_$class_ = ''], [**string**
_$valign_ = '']**);**


Overrides WebSitePhpObject::construct() (Constructor WebSitePhpObject)



**Parameters**
> _$align_ [value: center](default.md)
> _$width_
> _$class_
> _$valign_

**Remarks**

Constructor RowTable




# RowTable::delete #

**delete(**
**);**





**Remarks**

Method delete


**since:** 1.0.93

**access:** public



# RowTable::getAjaxRender #

**getAjaxRender(**
**);**


Overrides WebSitePhpObject::getAjaxRender() (Method getAjaxRender)



**Returns**
> javascript code to update initial html of object RowTable (call with AJAX)

**Remarks**

Method getAjaxRender


**since:** 1.0.85

**access:** public



# RowTable::getClass #

**getClass(**
**);**


Overrides WebSitePhpObject::getClass() (parent method not documented)



**Remarks**

Method getClass


**since:** 1.0.36

**access:** public



# RowTable::getId #

**getId(**
**);**





**Remarks**

Method getId


**since:** 1.0.93

**access:** public



# RowTable::getNbColumns #

**getNbColumns(**
**);**





**Remarks**

Method getNbColumns


**since:** 1.0.93

**access:** public



# RowTable::getRowColumnsArray #

**getRowColumnsArray(**
**);**





**Remarks**

Method getRowColumnsArray


**since:** 1.0.96

**access:** public



# RowTable::hide #

**hide(**
**);**





**Remarks**

Method hide


**since:** 1.0.85

**access:** public



# RowTable::isDeleted #

**isDeleted(**
**);**





**Remarks**

Method isDeleted


**since:** 1.0.93

**access:** public



# RowTable::isHeader #

**isHeader(**
**);**





**Remarks**

Method isHeader


**since:** 1.0.96

**access:** public



# RowTable::isNew #

**isNew(**
**);**





**Remarks**

Method isNew


**since:** 1.0.93

**access:** public



# RowTable::render #

**render(**
[**boolean**
_$ajax\_render_ = false]**);**


Overrides WebSitePhpObject::render() (Method render)



**Parameters**
> _$ajax\_render_ [value: false](default.md)

**Returns**
> html code of object RowTable

**Remarks**

Method render


**since:** 1.0.36

**access:** public



# RowTable::setAlign #

**setAlign(**
**string**
_$align_**);**





**Parameters**
> _$align_

**Remarks**

Method setAlign


**since:** 1.0.36

**access:** public



# RowTable::setBorderPredefinedStyle #

**setBorderPredefinedStyle(**
[**string**
_$style_ = &quot;1&quot;]**);**





**Parameters**
> _$style_ [value: 1](default.md)

**Remarks**

Method setBorderPredefinedStyle


**since:** 1.0.89

**access:** public



# RowTable::setClass #

**setClass(**
**mixed**
_$class_**);**





**Parameters**
> _$class_

**Remarks**

Method setClass


**since:** 1.0.36

**access:** public



# RowTable::setColspan #

**setColspan(**
**mixed**
_$colspan_**);**





**Parameters**
> _$colspan_

**Remarks**

Method setColspan


**since:** 1.0.36

**access:** public



# RowTable::setColumnAlign #

**setColumnAlign(**
**mixed**
_$column\_ind_, **string**
_$align_**);**





**Parameters**
> _$column\_ind_
> _$align_

**Remarks**

Method setColumnAlign


**since:** 1.0.36

**access:** public



# RowTable::setColumnClass #

**setColumnClass(**
**mixed**
_$column\_ind_, **mixed**
_$class_**);**





**Parameters**
> _$column\_ind_
> _$class_

**Remarks**

Method setColumnClass


**since:** 1.0.36

**access:** public



# RowTable::setColumnColspan #

**setColumnColspan(**
**mixed**
_$column\_ind_, **mixed**
_$colspan_**);**





**Parameters**
> _$column\_ind_
> _$colspan_

**Remarks**

Method setColumnColspan


**since:** 1.0.36

**access:** public



# RowTable::setColumnContent #

**setColumnContent(**
**mixed**
_$column\_ind_, **object**
_$content\_object_**);**





**Parameters**
> _$column\_ind_
> _$content\_object_

**Remarks**

Method setColumnContent


**since:** 1.0.36

**access:** public



# RowTable::setColumnHeight #

**setColumnHeight(**
**mixed**
_$column\_ind_, **integer**
_$height_**);**





**Parameters**
> _$column\_ind_
> _$height_

**Remarks**

Method setColumnHeight


**since:** 1.0.36

**access:** public



# RowTable::setColumnNowrap #

**setColumnNowrap(**
**mixed**
_$column\_ind_**);**





**Parameters**
> _$column\_ind_

**Remarks**

Method setColumnNowrap


**since:** 1.0.102

**access:** public



# RowTable::setColumnRowspan #

**setColumnRowspan(**
**mixed**
_$column\_ind_, **mixed**
_$rowspan_**);**





**Parameters**
> _$column\_ind_
> _$rowspan_

**Remarks**

Method setColumnRowspan


**since:** 1.0.36

**access:** public



# RowTable::setColumnStyle #

**setColumnStyle(**
**mixed**
_$column\_ind_, **mixed**
_$style_**);**





**Parameters**
> _$column\_ind_
> _$style_

**Remarks**

Method setColumnStyle


**since:** 1.0.36

**access:** public



# RowTable::setColumnValign #

**setColumnValign(**
**integer**
_$column\_ind_, **string**
_$valign_**);**





**Parameters**
> _$column\_ind_
> _$valign_

**Remarks**

Method setColumnValign


**since:** 1.0.36

**access:** public



# RowTable::setColumnWidth #

**setColumnWidth(**
**mixed**
_$column\_ind_, **integer**
_$width_**);**





**Parameters**
> _$column\_ind_
> _$width_

**Remarks**

Method setColumnWidth


**since:** 1.0.36

**access:** public



# RowTable::setHeaderClass #

**setHeaderClass(**
[**string**
_$class_ = &quot;1&quot;], [**boolean**
_$default\_border\_style_ = true]**);**





**Parameters**
> _$class_ [value: 1](default.md)
> _$default\_border\_style_ [value: true](default.md)

**Remarks**

Method setHeaderClass


**since:** 1.0.36

**access:** public



# RowTable::setHeight #

**setHeight(**
**integer**
_$height_**);**





**Parameters**
> _$height_

**Remarks**

Method setHeight


**since:** 1.0.36

**access:** public



# RowTable::setId #

**setId(**
**mixed**
_$id_**);**





**Parameters**
> _$id_

**Remarks**

Method setId


**since:** 1.0.85

**access:** public



# RowTable::setNowrap #

**setNowrap(**
**);**





**Remarks**

Method setNowrap


**since:** 1.0.36

**access:** public



# RowTable::setRowClass #

**setRowClass(**
**mixed**
_$class_**);**





**Parameters**
> _$class_

**Remarks**

Method setRowClass


**since:** 1.1.6

**access:** public



# RowTable::setRowspan #

**setRowspan(**
**mixed**
_$rowspan_**);**





**Parameters**
> _$rowspan_

**Remarks**

Method setRowspan


**since:** 1.0.36

**access:** public



# RowTable::setStyle #

**setStyle(**
**mixed**
_$style_**);**





**Parameters**
> _$style_

**Remarks**

Method setStyle


**since:** 1.0.36

**access:** public



# RowTable::setValign #

**setValign(**
**string**
_$valign_**);**





**Parameters**
> _$valign_

**Remarks**

Method setValign


**since:** 1.0.36

**access:** public



# RowTable::setWidth #

**setWidth(**
**integer**
_$width_**);**





**Parameters**
> _$width_

**Remarks**

Method setWidth


**since:** 1.0.36

**access:** public



# RowTable::show #

**show(**
**);**





**Remarks**

Method show


**since:** 1.0.85

**access:** public




---


## Variable Detail ##


---

## Class Constant Detail ##

**`ALIGN_CENTER` = ` 'center'` (line 41)**


**Remarks**

RowTable alignment


**access:** public


**`ALIGN_LEFT` = ` 'left'` (line 40)**


**Remarks**

RowTable alignment


**access:** public


**`ALIGN_RIGHT` = ` 'right'` (line 42)**


**Remarks**

RowTable alignment


**access:** public


**`STYLE_MAIN` = ` '1'` (line 31)**


**Remarks**

RowTable style class


**access:** public


**`STYLE_SECOND` = ` '2'` (line 32)**


**Remarks**

RowTable style class


**access:** public


**`VALIGN_BOTTOM` = ` 'bottom'` (line 52)**


**Remarks**

RowTable vertical alignment


**access:** public


**`VALIGN_CENTER` = ` 'center'` (line 51)**


**Remarks**

RowTable vertical alignment


**access:** public


**`VALIGN_TOP` = ` 'top'` (line 50)**


**Remarks**

RowTable vertical alignment


**access:** public




---
