# Class Object #

WebSitePhpObject
> |
> --WebSitePhpEventObject
> > |
> > --Object



Location: /display/Object.class.php


---



**Remarks**

Class Object


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


> align properties
    * `ALIGN_LEFT` = ` 'left'`

> align properties
    * `ALIGN_RIGHT` = ` 'right'`

> align properties
    * `BORDER_STYLE_DASHED` = ` 'dashed'`

> border style properties
    * `BORDER_STYLE_DOTTED` = ` 'dotted'`

> border style properties
    * `BORDER_STYLE_DOUBLE` = ` 'double'`

> border style properties
    * `BORDER_STYLE_GROOVE` = ` 'groove'`

> border style properties
    * `BORDER_STYLE_INSET` = ` 'inset'`

> border style properties
    * `BORDER_STYLE_OUTSET` = ` 'outset'`

> border style properties
    * `BORDER_STYLE_RIDGE` = ` 'ridge'`

> border style properties
    * `BORDER_STYLE_SOLID` = ` 'solid'`

> border style properties
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

### Inherited From Class WebSitePhpEventObject ###

  * `WebSitePhpEventObject::$ajax_wait_message` = ` ''`


  * `WebSitePhpEventObject::$class_name` = ` ''`


  * `WebSitePhpEventObject::$disable_ajax_wait_message` = ` false`


  * `WebSitePhpEventObject::$form_object` = ` null`


  * `WebSitePhpEventObject::$id` = ` ''`


  * `WebSitePhpEventObject::$is_ajax_event` = ` false`


  * `WebSitePhpEventObject::$name` = ` ''`


  * `WebSitePhpEventObject::$on_form_is_changed_js` = ` ''`


  * `WebSitePhpEventObject::$on_form_is_changed_revert` = ` false`


  * `WebSitePhpEventObject::$page_object` = ` null`




### Inherited From Class WebSitePhpObject ###

  * `WebSitePhpObject::$is_javascript_object` = ` false`


  * `WebSitePhpObject::$is_new_object_after_init` = ` false`


  * `WebSitePhpObject::$object_change` = ` false`


  * `WebSitePhpObject::$tag` = ` ''`






---

## Method Summary ##


## Inherited Method Summary ##

### Inherited From Class WebSitePhpEventObject ###

  * `WebSitePhpEventObject::__construct()`
> Constructor WebSitePhpEventObject
    * `WebSitePhpEventObject::automaticAjaxEvent()`
> Method automaticAjaxEvent
    * `WebSitePhpEventObject::disableAjaxWaitMessage()`
> Method disableAjaxWaitMessage
    * `WebSitePhpEventObject::getAjaxEventFunctionRender()`
> Method getAjaxEventFunctionRender
    * `WebSitePhpEventObject::getEventObjectName()`
> Method getEventObjectName
    * `WebSitePhpEventObject::getFormObject()`
> Method getFormObject
    * `WebSitePhpEventObject::getId()`
> Method getId
    * `WebSitePhpEventObject::getName()`
> Method getName
    * `WebSitePhpEventObject::getObjectEventValidationRender()`
> Method getObjectEventValidationRender
    * `WebSitePhpEventObject::getSubmitValueIsInit()`

  * `WebSitePhpEventObject::initSubmitValue()`
> Method initSubmitValue  Internal method used by an object like ComboBox or TextBox to init it with submitted value (if not already done).
    * `WebSitePhpEventObject::isAjaxEvent()`
> Method isAjaxEvent
    * `WebSitePhpEventObject::isEventObject()`
> Method isEventObject
    * `WebSitePhpEventObject::loadCallbackMethod()`
> Method loadCallbackMethod
    * `WebSitePhpEventObject::onFormIsChangedJs()`
> Method onFormIsChangedJs
    * `WebSitePhpEventObject::setAjaxEvent()`
> Method setAjaxEvent
    * `WebSitePhpEventObject::setAjaxWaitMessage()`
> Method setAjaxWaitMessage
    * `WebSitePhpEventObject::setSubmitValueIsInit()`
> Method setSubmitValueIsInit

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



# Object::construct #

**construct(**
[**string|WspObject|Url**
_$str\_or\_object_ = null], [**string|WspObject**
_$str\_or\_object2_ = null], [**string|WspObject**
_$str\_or\_object3_ = null], [**string|WspObject**
_$str\_or\_object4_ = null], [**string|WspObject**
_$str\_or\_object5_ = null]**);**


Overrides WebSitePhpEventObject::construct() (Constructor WebSitePhpEventObject)



**Parameters**
> _$str\_or\_object_ [value: null](default.md)
> _$str\_or\_object2_ [value: null](default.md)
> _$str\_or\_object3_ [value: null](default.md)
> _$str\_or\_object4_ [value: null](default.md)
> _$str\_or\_object5_ [value: null](default.md)

**Remarks**

Constructor Object




# Object::add #

**add(**
**string|WspObject|Url**
_$str\_or\_object_, [**string|WspObject**
_$str\_or\_object2_ = null], [**string|WspObject**
_$str\_or\_object3_ = null], [**string|WspObject**
_$str\_or\_object4_ = null], [**string|WspObject**
_$str\_or\_object5_ = null]**);**





**Parameters**
> _$str\_or\_object_
> _$str\_or\_object2_ [value: null](default.md)
> _$str\_or\_object3_ [value: null](default.md)
> _$str\_or\_object4_ [value: null](default.md)
> _$str\_or\_object5_ [value: null](default.md)

**Remarks**

Method add


**since:** 1.0.36

**access:** public



# Object::emptyObject #

**emptyObject(**
**);**





**Remarks**

Method emptyObject


**since:** 1.0.36

**access:** public



# Object::forceDivTag #

**forceDivTag(**
**);**





**Remarks**

Method forceDivTag


**since:** 1.0.36

**access:** public



# Object::forceSpanTag #

**forceSpanTag(**
**);**





**Remarks**

Method forceSpanTag


**since:** 1.0.36

**access:** public



# Object::getAjaxRender #

**getAjaxRender(**
**);**


Overrides WebSitePhpObject::getAjaxRender() (Method getAjaxRender)



**Returns**
> javascript code to update initial html of object Object (call with AJAX)

**Remarks**

Method getAjaxRender


**since:** 1.0.36

**access:** public



# Object::getId #

**getId(**
**);**


Overrides WebSitePhpEventObject::getId() (Method getId)



**Remarks**

Method getId


**since:** 1.0.36

**access:** public



# Object::getIsDraggable #

**getIsDraggable(**
**);**





**Remarks**

Method getIsDraggable


**since:** 1.0.36

**access:** public



# Object::getIsDroppable #

**getIsDroppable(**
**);**





**Remarks**

Method getIsDroppable


**since:** 1.0.36

**access:** public



# Object::getIsSortable #

**getIsSortable(**
**);**





**Remarks**

Method getIsSortable


**since:** 1.0.36

**access:** public



# Object::getOnClickJs #

**getOnClickJs(**
**);**





**Remarks**

Method getOnClickJs


**since:** 1.0.36

**access:** public



# Object::hide #

**hide(**
**);**





**Remarks**

Method hide


**since:** 1.0.36

**access:** public



# Object::isClicked #

**isClicked(**
**);**





**Remarks**

Method isClicked


**since:** 1.0.36

**access:** public



# Object::onClick #

**onClick(**
**Page|Form**
_$page\_or\_form\_object_, **string**
_$str\_function_, [**mixed**
_$arg1_ = null], [**mixed**
_$arg2_ = null], [**mixed**
_$arg3_ = null], [**mixed**
_$arg4_ = null], [**mixed**
_$arg5_ = null]**);**





**Parameters**
> _$page\_or\_form\_object_
> _$str\_function_
> _$arg1_ [value: null](default.md)
> _$arg2_ [value: null](default.md)
> _$arg3_ [value: null](default.md)
> _$arg4_ [value: null](default.md)
> _$arg5_ [value: null](default.md)

**Remarks**

Method onClick


**since:** 1.0.36

**access:** public



# Object::onClickJs #

**onClickJs(**
**string|JavaScript**
_$js\_function_**);**





**Parameters**
> _$js\_function_

**Remarks**

Method onClickJs


**since:** 1.0.36

**access:** public



# Object::onDblClick #

**onDblClick(**
**mixed**
_$page\_or\_form\_object_, **mixed**
_$str\_function_, [**mixed**
_$arg1_ = null], [**mixed**
_$arg2_ = null], [**mixed**
_$arg3_ = null], [**mixed**
_$arg4_ = null], [**mixed**
_$arg5_ = null]**);**





**Parameters**
> _$page\_or\_form\_object_
> _$str\_function_
> _$arg1_ [value: null](default.md)
> _$arg2_ [value: null](default.md)
> _$arg3_ [value: null](default.md)
> _$arg4_ [value: null](default.md)
> _$arg5_ [value: null](default.md)

**Remarks**

Method onDblClick


**since:** 1.0.97

**access:** public



# Object::onDblClickJs #

**onDblClickJs(**
**mixed**
_$js\_function_**);**





**Parameters**
> _$js\_function_

**Remarks**

Method onDblClickJs


**since:** 1.0.97

**access:** public



# Object::onMouseOutJs #

**onMouseOutJs(**
**string|JavaScript**
_$js\_function_**);**





**Parameters**
> _$js\_function_

**Remarks**

Method onMouseOutJs


**since:** 1.0.63

**access:** public



# Object::onMouseOverJs #

**onMouseOverJs(**
**string|JavaScript**
_$js\_function_**);**





**Parameters**
> _$js\_function_

**Remarks**

Method onMouseOverJs


**since:** 1.0.63

**access:** public



# Object::render #

**render(**
[**boolean**
_$ajax\_render_ = false]**);**


Overrides WebSitePhpObject::render() (Method render)



**Parameters**
> _$ajax\_render_ [value: false](default.md)

**Returns**
> html code of object Object

**Remarks**

Method render


**since:** 1.0.36

**access:** public



# Object::setAlign #

**setAlign(**
**string**
_$align_**);**





**Parameters**
> _$align_

**Remarks**

Method setAlign


**since:** 1.0.36

**access:** public



# Object::setBorder #

**setBorder(**
[**integer**
_$border_ = 1], [**string**
_$border\_color_ = &quot;black&quot;], [**string**
_$border\_style_ = &quot;solid&quot;]**);**





**Parameters**
> _$border_ [value: 1](default.md)
> _$border\_color_ [value: black](default.md)
> _$border\_style_ [value: solid](default.md)

**Remarks**

Method setBorder


**since:** 1.0.36

**access:** public



# Object::setClass #

**setClass(**
**string**
_$class_**);**





**Parameters**
> _$class_

**Remarks**

Method setClass


**since:** 1.0.36

**access:** public



# Object::setClick #

**setClick(**
**);**





**Remarks**

Method setClick


**since:** 1.0.36

**access:** public



# Object::setContextMenu #

**setContextMenu(**
**mixed**
_$context\_menu\_object_**);**





**Parameters**
> _$context\_menu\_object_

**Remarks**

Method setContextMenu


**since:** 1.0.97

**access:** public



# Object::setDraggable #

**setDraggable(**
[**boolean**
_$bool_ = true], [**boolean**
_$revert_ = false], [**DraggableEvent**
_$draggable\_event_ = null], [**string**
_$draggable\_params_ = &quot;&quot;]**);**





**Parameters**
> _$bool_ if object can be move [value: true](default.md)
> _$revert_ if object revert first place when dropped [value: false](default.md)
> _$draggable\_event_ [value: null](default.md)
> _$draggable\_params_

**Remarks**

Method setDraggable


**since:** 1.0.36

**access:** public



# Object::setDroppable #

**setDroppable(**
[**boolean**
_$bool_ = true], [**DroppableEvent**
_$droppable\_event_ = null], [**string**
_$droppable\_params_ = &quot;&quot;], [**string**
_$droppable\_style_ = &quot;droppablehover&quot;]**);**





**Parameters**
> _$bool_ if object can be dropped [value: true](default.md)
> _$droppable\_event_ [value: null](default.md)
> _$droppable\_params_
> _$droppable\_style_ [value: droppablehover](default.md)

**Remarks**

Method setDroppable


**since:** 1.0.36

**access:** public



# Object::setFont #

**setFont(**
**integer**
_$font\_size_, **string**
_$font\_family_, **string**
_$font\_weight_**);**





**Parameters**
> _$font\_size_
> _$font\_family_
> _$font\_weight_

**Remarks**

Method setFont


**since:** 1.0.36

**access:** public



# Object::setHeight #

**setHeight(**
**integer**
_$height_**);**





**Parameters**
> _$height_

**Remarks**

Method setHeight


**since:** 1.0.36

**access:** public



# Object::setId #

**setId(**
**string**
_$id_**);**





**Parameters**
> _$id_

**Remarks**

Method setId


**since:** 1.0.36

**access:** public



# Object::setItemProp #

**setItemProp(**
**mixed**
_$itemprop_, [**string**
_$itemprop\_content_ = '']**);**





**Parameters**
> _$itemprop_
> _$itemprop\_content_

**Remarks**

Method setItemProp


**since:** 1.0.103

**access:** public



# Object::setItemType #

**setItemType(**
**mixed**
_$itemtype_**);**





**Parameters**
> _$itemtype_

**Remarks**

Method setItemType


**since:** 1.0.103

**access:** public



# Object::setMaxHeight #

**setMaxHeight(**
**mixed**
_$max\_height_**);**





**Parameters**
> _$max\_height_

**Remarks**

Method setMaxHeight


**since:** 1.0.97

**access:** public



# Object::setMinHeight #

**setMinHeight(**
**integer**
_$min\_height_**);**





**Parameters**
> _$min\_height_

**Remarks**

Method setMinHeight


**since:** 1.0.36

**access:** public



# Object::setProperty #

**setProperty(**
**mixed**
_$property_**);**





**Parameters**
> _$property_

**Remarks**

Method setProperty


**since:** 1.1.8

**access:** public



# Object::setSortable #

**setSortable(**
[**boolean**
_$bool_ = true], [**SortableEvent**
_$sortable\_event_ = null], [**string**
_$sortable\_params_ = &quot;&quot;], [**boolean**
_$disable\_selection_ = false]**);**





**Parameters**
> _$bool_ if object can be sort [value: true](default.md)
> _$sortable\_event_ [value: null](default.md)
> _$sortable\_params_
> _$disable\_selection_ [value: false](default.md)

**Remarks**

Method setSortable


**since:** 1.0.36

**access:** public



# Object::setStyle #

**setStyle(**
**string**
_$style_**);**





**Parameters**
> _$style_

**Remarks**

Method setStyle


**since:** 1.0.36

**access:** public



# Object::setTypeOf #

**setTypeOf(**
**mixed**
_$typeof_**);**





**Parameters**
> _$typeof_

**Remarks**

Method setTypeOf


**since:** 1.1.8

**access:** public



# Object::setWidth #

**setWidth(**
**integer**
_$width_**);**





**Parameters**
> _$width_

**Remarks**

Method setWidth


**since:** 1.0.36

**access:** public



# Object::setXmlns #

**setXmlns(**
**mixed**
_$xmlns_**);**





**Parameters**
> _$xmlns_

**Remarks**

Method setXmlns


**since:** 1.1.8

**access:** public



# Object::setXmlnsV #

**setXmlnsV(**
**mixed**
_$xmlnsv_**);**





**Parameters**
> _$xmlnsv_

**Remarks**

Method setXmlnsV


**since:** 1.1.8

**access:** public



# Object::show #

**show(**
**);**





**Remarks**

Method show


**since:** 1.0.36

**access:** public




---


## Variable Detail ##


---

## Class Constant Detail ##

**`ALIGN_CENTER` = ` 'center'` (line 32)**


**Remarks**

align properties


**access:** public


**`ALIGN_LEFT` = ` 'left'` (line 31)**


**Remarks**

align properties


**access:** public


**`ALIGN_RIGHT` = ` 'right'` (line 33)**


**Remarks**

align properties


**access:** public


**`BORDER_STYLE_DASHED` = ` 'dashed'` (line 42)**


**Remarks**

border style properties


**access:** public


**`BORDER_STYLE_DOTTED` = ` 'dotted'` (line 41)**


**Remarks**

border style properties


**access:** public


**`BORDER_STYLE_DOUBLE` = ` 'double'` (line 44)**


**Remarks**

border style properties


**access:** public


**`BORDER_STYLE_GROOVE` = ` 'groove'` (line 45)**


**Remarks**

border style properties


**access:** public


**`BORDER_STYLE_INSET` = ` 'inset'` (line 47)**


**Remarks**

border style properties


**access:** public


**`BORDER_STYLE_OUTSET` = ` 'outset'` (line 48)**


**Remarks**

border style properties


**access:** public


**`BORDER_STYLE_RIDGE` = ` 'ridge'` (line 46)**


**Remarks**

border style properties


**access:** public


**`BORDER_STYLE_SOLID` = ` 'solid'` (line 43)**


**Remarks**

border style properties


**access:** public


**`FONT_ARIAL` = ` 'Arial'` (line 56)**


**Remarks**

Font family


**access:** public


**`FONT_TIMES` = ` 'Times New Roman'` (line 57)**


**Remarks**

Font family


**access:** public


**`FONT_WEIGHT_BOLD` = ` 'bold'` (line 65)**


**Remarks**

Font weight


**access:** public


**`FONT_WEIGHT_NONE` = ` 'none'` (line 66)**


**Remarks**

Font weight


**access:** public




---
