# Class AutoCompleteEvent #

WebSitePhpObject
> |
> --WebSitePhpEventObject
> > |
> > --AutoCompleteEvent



Location: /display/advanced\_object/autocomplete/AutoCompleteEvent.class.php


---



**Remarks**

Class AutoCompleteEvent


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



# AutoCompleteEvent::construct #

**construct(**
[**mixed**
_$page\_or\_form\_object_ = null], [**string**
_$name_ = '']**);**


Overrides WebSitePhpEventObject::construct() (Constructor WebSitePhpEventObject)



**Parameters**
> _$page\_or\_form\_object_ [value: null](default.md)
> _$name_

**Remarks**

Constructor AutoCompleteEvent




# AutoCompleteEvent::getOnSelectJs #

**getOnSelectJs(**
**);**





**Remarks**

Method getOnSelectJs


**since:** 1.0.95

**access:** public



# AutoCompleteEvent::isSelected #

**isSelected(**
**);**





**Remarks**

Method isSelected


**since:** 1.0.95

**access:** public



# AutoCompleteEvent::onSelect #

**onSelect(**
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

Method onSelect


**since:** 1.0.95

**access:** public



# AutoCompleteEvent::onSelectJs #

**onSelectJs(**
**mixed**
_$js\_function_**);**





**Parameters**
> _$js\_function_

**Remarks**

Method onSelectJs


**since:** 1.0.35

**access:** public



# AutoCompleteEvent::render #

**render(**
[**boolean**
_$ajax\_render_ = false]**);**


Overrides WebSitePhpObject::render() (Method render)



**Parameters**
> _$ajax\_render_ [value: false](default.md)

**Returns**
> html code of object AutoCompleteEvent

**Remarks**

Method render


**since:** 1.0.35

**access:** public



# AutoCompleteEvent::setClick #

**setClick(**
**);**





**Remarks**

Method setClick


**since:** 1.0.95

**access:** public




---


## Variable Detail ##


---

## Class Constant Detail ##



---
