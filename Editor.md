# Class Editor #

WebSitePhpObject
> |
> --WebSitePhpEventObject
> > |
> > --Editor



Location: /display/Editor.class.php


---



**Remarks**

Class Editor


WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)  Copyright (c) 2009-2014 WebSite-PHP.com  PHP versions >= 5.2Licensed under The MIT License  Redistributions of files must retain the above copyright notice.


**author:** Emilien MOREL <>

**version:** 1.2.7

**copyright:** WebSite-PHP.com 17/01/2014

**link:**

**since:** 1.0.17

**access:** public



---

## Class Variable Summary ##
  * `$class_name` = ` ''`


  * `$form_object` = ` null`


  * `$name` = ` ''`


  * `$page_object` = ` null`




---

## Class Constant Summary ##

  * `TOOLBAR_DEFAULT` = ` 'default'`


> Editor toolbar config
    * `TOOLBAR_MEDIUM` = ` 'medium'`

> Editor toolbar config
    * `TOOLBAR_NONE` = ` 'none'`

> Editor toolbar config
    * `TOOLBAR_SIMPLE` = ` 'simple'`

> Editor toolbar config


---

## Inherited Class Constant Summary ##



---

## Inherited Class Variable Summary ##

### Inherited From Class WebSitePhpEventObject ###

  * `WebSitePhpEventObject::$ajax_wait_message` = ` ''`


  * `WebSitePhpEventObject::$disable_ajax_wait_message` = ` false`


  * `WebSitePhpEventObject::$id` = ` ''`


  * `WebSitePhpEventObject::$is_ajax_event` = ` false`


  * `WebSitePhpEventObject::$on_form_is_changed_js` = ` ''`


  * `WebSitePhpEventObject::$on_form_is_changed_revert` = ` false`




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



# Editor::construct #

**construct(**
**Page|Object**
_$page\_or\_form\_object_, [**string**
_$name_ = ''], [**string**
_$width_ = ''], [**string**
_$height_ = '']**);**


Overrides WebSitePhpEventObject::construct() (Constructor WebSitePhpEventObject)



**Parameters**
> _$page\_or\_form\_object_
> _$name_
> _$width_
> _$height_

**Remarks**

Constructor Editor




# Editor::collapseToolbar #

**collapseToolbar(**
**);**





**Remarks**

Method collapseToolbar


**since:** 1.0.36

**access:** public



# Editor::getAjaxRender #

**getAjaxRender(**
**);**


Overrides WebSitePhpObject::getAjaxRender() (Method getAjaxRender)



**Returns**
> javascript code to update initial html of object Editor (call with AJAX)

**Remarks**

Method getAjaxRender


**since:** 1.0.36

**access:** public



# Editor::getContent #

**getContent(**
**);**





**Remarks**

Method getContent


**since:** 1.0.36

**access:** public



# Editor::getDefaultContent #

**getDefaultContent(**
**);**





**Remarks**

Method getDefaultContent


**since:** 1.0.36

**access:** public



# Editor::getDefaultValue #

**getDefaultValue(**
**);**





**Remarks**

Method getDefaultValue


**since:** 1.0.36

**access:** public



# Editor::getEncryptObject #

**getEncryptObject(**
**);**





**Remarks**

Method getEncryptObject


**since:** 1.0.67

**access:** public



# Editor::getEventObjectName #

**getEventObjectName(**
**);**


Overrides WebSitePhpEventObject::getEventObjectName() (Method getEventObjectName)



**Remarks**

Method getEventObjectName


**since:** 1.0.36

**access:** public



# Editor::getFormObject #

**getFormObject(**
**);**


Overrides WebSitePhpEventObject::getFormObject() (Method getFormObject)



**Remarks**

Method getFormObject


**since:** 1.0.36

**access:** public



# Editor::getHiddenId #

**getHiddenId(**
**);**





**Remarks**

Method getHiddenId


**since:** 1.0.36

**access:** public



# Editor::getId #

**getId(**
**);**


Overrides WebSitePhpEventObject::getId() (Method getId)



**Remarks**

Method getId


**since:** 1.0.36

**access:** public



# Editor::getName #

**getName(**
**);**


Overrides WebSitePhpEventObject::getName() (Method getName)



**Remarks**

Method getName


**since:** 1.0.36

**access:** public



# Editor::getValue #

**getValue(**
**);**





**Remarks**

Method getValue


**since:** 1.0.36

**access:** public



# Editor::isEncrypted #

**isEncrypted(**
**);**





**Remarks**

Method isEncrypted


**since:** 1.0.67

**access:** public



# Editor::render #

**render(**
[**boolean**
_$ajax\_render_ = false]**);**


Overrides WebSitePhpObject::render() (Method render)



**Parameters**
> _$ajax\_render_ [value: false](default.md)

**Returns**
> html code of object Editor

**Remarks**

Method render


**since:** 1.0.36

**access:** public



# Editor::resizable #

**resizable(**
**mixed**
_$bool_**);**





**Parameters**
> _$bool_

**Remarks**

Method resizable


**since:** 1.0.36

**access:** public



# Editor::setColor #

**setColor(**
**mixed**
_$color_**);**





**Parameters**
> _$color_

**Remarks**

Method setColor


**since:** 1.0.36

**access:** public



# Editor::setContent #

**setContent(**
**object**
_$content_**);**





**Parameters**
> _$content_

**Remarks**

Method setContent


**since:** 1.0.36

**access:** public



# Editor::setDefaultContent #

**setDefaultContent(**
**object**
_$content_**);**





**Parameters**
> _$content_

**Remarks**

Method setDefaultContent


**since:** 1.0.36

**access:** public



# Editor::setDefaultValue #

**setDefaultValue(**
**mixed**
_$value_**);**





**Parameters**
> _$value_

**Remarks**

Method setDefaultValue


**since:** 1.0.36

**access:** public



# Editor::setEncryptObject #

**setEncryptObject(**
**mixed**
_$encrypt\_object_**);**





**Parameters**
> _$encrypt\_object_

**Remarks**

Method setEncryptObject


**since:** 1.0.67

**access:** public



# Editor::setHeight #

**setHeight(**
**integer**
_$height_**);**





**Parameters**
> _$height_

**Remarks**

Method setHeight


**since:** 1.0.36

**access:** public



# Editor::setLiveValidation #

**setLiveValidation(**
**mixed**
_$live\_validation\_object_**);**





**Parameters**
> _$live\_validation\_object_

**Remarks**

Method setLiveValidation


**since:** 1.0.36

**access:** public



# Editor::setName #

**setName(**
**mixed**
_$name_**);**





**Parameters**
> _$name_

**Remarks**

Method setName


**since:** 1.0.36

**access:** public



# Editor::setToolbar #

**setToolbar(**
**mixed**
_$toolbar_**);**





**Parameters**
> _$toolbar_

**Remarks**

Method setToolbar


**since:** 1.0.36

**access:** public



# Editor::setValue #

**setValue(**
**mixed**
_$value_**);**





**Parameters**
> _$value_

**Remarks**

Method setValue


**since:** 1.0.36

**access:** public



# Editor::setWidth #

**setWidth(**
**integer**
_$width_**);**





**Parameters**
> _$width_

**Remarks**

Method setWidth


**since:** 1.0.36

**access:** public




---


## Variable Detail ##
**`$class_name` = ` ''` (line 40)** **Data type:** `mixed`**Overrides:** Array
**access:** protected


**`$form_object` = ` null` (line 42)** **Data type:** `mixed`**Overrides:** Array
**access:** protected


**`$name` = ` ''` (line 43)** **Data type:** `mixed`**Overrides:** Array
**access:** protected


**`$page_object` = ` null` (line 41)** **Data type:** `mixed`**Overrides:** Array
**access:** protected




---

## Class Constant Detail ##

**`TOOLBAR_DEFAULT` = ` 'default'` (line 31)**


**Remarks**

Editor toolbar config


**access:** public


**`TOOLBAR_MEDIUM` = ` 'medium'` (line 32)**


**Remarks**

Editor toolbar config


**access:** public


**`TOOLBAR_NONE` = ` 'none'` (line 34)**


**Remarks**

Editor toolbar config


**access:** public


**`TOOLBAR_SIMPLE` = ` 'simple'` (line 33)**


**Remarks**

Editor toolbar config


**access:** public




---
