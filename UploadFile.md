# Class UploadFile #

WebSitePhpObject
> |
> --WebSitePhpEventObject
> > |
> > --UploadFile



Location: /display/UploadFile.class.php


---



**Remarks**

Class UploadFile


WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)  Copyright (c) 2009-2014 WebSite-PHP.com  PHP versions >= 5.2Licensed under The MIT License  Redistributions of files must retain the above copyright notice.


**author:** Emilien MOREL <>

**version:** 1.2.9

**copyright:** WebSite-PHP.com 17/01/2014

**link:**

**since:** 1.2.3

**access:** public



---

## Class Variable Summary ##
  * `$class_name` = ` ''`


  * `$form_object` = ` null`


  * `$page_object` = ` null`




---

## Class Constant Summary ##



---

## Inherited Class Constant Summary ##



---

## Inherited Class Variable Summary ##

### Inherited From Class WebSitePhpEventObject ###

  * `WebSitePhpEventObject::$ajax_wait_message` = ` ''`


  * `WebSitePhpEventObject::$disable_ajax_wait_message` = ` false`


  * `WebSitePhpEventObject::$id` = ` ''`


  * `WebSitePhpEventObject::$is_ajax_event` = ` false`


  * `WebSitePhpEventObject::$name` = ` ''`


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



# UploadFile::construct #

**construct(**
**mixed**
_$page\_or\_form\_object_, [**string**
_$name_ = ''], [**string**
_$id_ = '']**);**


Overrides WebSitePhpEventObject::construct() (Constructor WebSitePhpEventObject)



**Parameters**
> _$page\_or\_form\_object_
> _$name_
> _$id_

**Remarks**

Constructor UploadFile




# UploadFile::checkFileSize #

**checkFileSize(**
**);**





**Remarks**

Method checkFileSize


**since:** 1.2.3

**access:** public



# UploadFile::checkMimeType #

**checkMimeType(**
**);**





**Remarks**

Method checkMimeType


**since:** 1.2.3

**access:** public



# UploadFile::getEventObjectName #

**getEventObjectName(**
**);**


Overrides WebSitePhpEventObject::getEventObjectName() (Method getEventObjectName)



**Remarks**

Method getEventObjectName


**since:** 1.2.3

**access:** public



# UploadFile::getFileContent #

**getFileContent(**
**);**





**Remarks**

Method getFileContent


**since:** 1.2.3

**access:** public



# UploadFile::getFileMimeType #

**getFileMimeType(**
**);**





**Remarks**

Method getFileMimeType


**since:** 1.2.3

**access:** public



# UploadFile::getFileName #

**getFileName(**
**);**





**Remarks**

Method getFileName


**since:** 1.2.3

**access:** public



# UploadFile::getFilePath #

**getFilePath(**
**);**





**Remarks**

Method getFilePath


**since:** 1.2.3

**access:** public



# UploadFile::getFileSize #

**getFileSize(**
**);**





**Remarks**

Method getFileSize


**since:** 1.2.3

**access:** public



# UploadFile::getFormObject #

**getFormObject(**
**);**


Overrides WebSitePhpEventObject::getFormObject() (Method getFormObject)



**Remarks**

Method getFormObject


**since:** 1.2.3

**access:** public



# UploadFile::getId #

**getId(**
**);**


Overrides WebSitePhpEventObject::getId() (Method getId)



**Remarks**

Method getId


**since:** 1.2.3

**access:** public



# UploadFile::getName #

**getName(**
**);**


Overrides WebSitePhpEventObject::getName() (Method getName)



**Remarks**

Method getName


**since:** 1.2.3

**access:** public



# UploadFile::isChanged #

**isChanged(**
**);**





**Remarks**

Method isChanged


**since:** 1.2.5

**access:** public



# UploadFile::isEmptyFile #

**isEmptyFile(**
**);**





**Remarks**

Method isEmptyFile


**since:** 1.2.3

**access:** public



# UploadFile::moveFile #

**moveFile(**
**mixed**
_$destination\_path_**);**





**Parameters**
> _$destination\_path_

**Remarks**

Method moveFile


**since:** 1.2.3

**access:** public



# UploadFile::onChange #

**onChange(**
**mixed**
_$str\_function_, [**mixed**
_$arg1_ = null], [**mixed**
_$arg2_ = null], [**mixed**
_$arg3_ = null], [**mixed**
_$arg4_ = null], [**mixed**
_$arg5_ = null]**);**





**Parameters**
> _$str\_function_
> _$arg1_ [value: null](default.md)
> _$arg2_ [value: null](default.md)
> _$arg3_ [value: null](default.md)
> _$arg4_ [value: null](default.md)
> _$arg5_ [value: null](default.md)

**Remarks**

Method onChange


**since:** 1.2.5

**access:** public



# UploadFile::onChangeJs #

**onChangeJs(**
**mixed**
_$js\_function_**);**





**Parameters**
> _$js\_function_

**Remarks**

Method onChangeJs


**since:** 1.2.5

**access:** public



# UploadFile::render #

**render(**
[**boolean**
_$ajax\_render_ = false]**);**


Overrides WebSitePhpObject::render() (Method render)



**Parameters**
> _$ajax\_render_ [value: false](default.md)

**Returns**
> html code of object UploadFile

**Remarks**

Method render


**since:** 1.2.3

**access:** public



# UploadFile::setAuthorizedMimeTypes #

**setAuthorizedMimeTypes(**
**mixed**
_$mime\_types_**);**





**Parameters**
> _$mime\_types_

**Remarks**

Method setAuthorizedMimeTypes


**since:** 1.2.3

**access:** public



# UploadFile::setButtonValue #

**setButtonValue(**
**mixed**
_$button\_value_**);**





**Parameters**
> _$button\_value_

**Remarks**

Method setButtonValue


**since:** 1.2.3

**access:** public



# UploadFile::setChange #

**setChange(**
**);**





**Remarks**

Method setChange


**since:** 1.2.5

**access:** public



# UploadFile::setClass #

**setClass(**
**mixed**
_$class_**);**





**Parameters**
> _$class_

**Remarks**

Method setClass


**since:** 1.2.3

**access:** public



# UploadFile::setFileSizeLimit #

**setFileSizeLimit(**
**mixed**
_$bytes\_size_**);**





**Parameters**
> _$bytes\_size_

**Remarks**

Method setFileSizeLimit


**since:** 1.2.3

**access:** public



# UploadFile::setValue #

**setValue(**
**mixed**
_$value_**);**





**Parameters**
> _$value_

**Remarks**

Method setValue


**since:** 1.2.5

**access:** public



# UploadFile::setWidth #

**setWidth(**
**integer**
_$width_**);**





**Parameters**
> _$width_

**Remarks**

Method setWidth


**since:** 1.2.3

**access:** public




---


## Variable Detail ##
**`$class_name` = ` ''` (line 29)** **Data type:** `mixed`**Overrides:** Array
**access:** protected


**`$form_object` = ` null` (line 31)** **Data type:** `mixed`**Overrides:** Array
**access:** protected


**`$page_object` = ` null` (line 30)** **Data type:** `mixed`**Overrides:** Array
**access:** protected




---

## Class Constant Detail ##



---
