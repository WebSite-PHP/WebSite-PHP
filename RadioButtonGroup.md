# Class RadioButtonGroup #

WebSitePhpObject
> |
> --WebSitePhpEventObject
> > |
> > --RadioButtonGroup



Location: /display/RadioButtonGroup.class.php


---



**Remarks**

Class RadioButtonGroup


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


  * `$name` = ` ''`


  * `$page_object` = ` null`


  * `$value` = ` ''`




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



# RadioButtonGroup::construct #

**construct(**
**mixed**
_$page\_or\_form\_object_, [**string**
_$name_ = '']**);**


Overrides WebSitePhpEventObject::construct() (Constructor WebSitePhpEventObject)



**Parameters**
> _$page\_or\_form\_object_
> _$name_

**Remarks**

Constructor RadioButtonGroup




# RadioButtonGroup::addRadioButton #

**addRadioButton(**
**mixed**
_$value_, [**string**
_$text_ = ''], [**boolean**
_$selected_ = false]**);**





**Parameters**
> _$value_
> _$text_
> _$selected_ [value: false](default.md)

**Remarks**

Method addRadioButton


**since:** 1.2.3

**access:** public



# RadioButtonGroup::disable #

**disable(**
**);**





**Remarks**

Method disable


**since:** 1.2.3

**access:** public



# RadioButtonGroup::enable #

**enable(**
**);**





**Remarks**

Method enable


**since:** 1.2.3

**access:** public



# RadioButtonGroup::getAjaxRender #

**getAjaxRender(**
**);**


Overrides WebSitePhpObject::getAjaxRender() (Method getAjaxRender)



**Returns**
> javascript code to update initial html of object RadioButtonGroup (call with AJAX)

**Remarks**

Method getAjaxRender


**since:** 1.2.3

**access:** public



# RadioButtonGroup::getDefaultValue #

**getDefaultValue(**
**);**





**Remarks**

Method getDefaultValue


**since:** 1.2.3

**access:** public



# RadioButtonGroup::getEventObjectName #

**getEventObjectName(**
**);**


Overrides WebSitePhpEventObject::getEventObjectName() (Method getEventObjectName)



**Remarks**

Method getEventObjectName


**since:** 1.2.3

**access:** public



# RadioButtonGroup::getFormObject #

**getFormObject(**
**);**


Overrides WebSitePhpEventObject::getFormObject() (Method getFormObject)



**Remarks**

Method getFormObject


**since:** 1.2.3

**access:** public



# RadioButtonGroup::getId #

**getId(**
**mixed**
_$radio\_value_**);**


Overrides WebSitePhpEventObject::getId() (Method getId)



**Parameters**
> _$radio\_value_

**Remarks**

Method getId


**since:** 1.2.3

**access:** public



# RadioButtonGroup::getName #

**getName(**
**);**


Overrides WebSitePhpEventObject::getName() (Method getName)



**Remarks**

Method getName


**since:** 1.2.3

**access:** public



# RadioButtonGroup::getValue #

**getValue(**
**);**





**Remarks**

Method getValue


**since:** 1.2.3

**access:** public



# RadioButtonGroup::isChanged #

**isChanged(**
**);**





**Remarks**

Method isChanged


**since:** 1.2.3

**access:** public



# RadioButtonGroup::onChange #

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


**since:** 1.2.3

**access:** public



# RadioButtonGroup::onChangeJs #

**onChangeJs(**
**mixed**
_$js\_function_**);**





**Parameters**
> _$js\_function_

**Remarks**

Method onChangeJs


**since:** 1.2.3

**access:** public



# RadioButtonGroup::render #

**render(**
[**boolean**
_$ajax\_render_ = false]**);**


Overrides WebSitePhpObject::render() (Method render)



**Parameters**
> _$ajax\_render_ [value: false](default.md)

**Returns**
> html code of object RadioButtonGroup

**Remarks**

Method render


**since:** 1.2.3

**access:** public



# RadioButtonGroup::setDefaultValue #

**setDefaultValue(**
**mixed**
_$value_**);**





**Parameters**
> _$value_

**Remarks**

Method setDefaultValue


**since:** 1.2.3

**access:** public



# RadioButtonGroup::setName #

**setName(**
**mixed**
_$name_**);**





**Parameters**
> _$name_

**Remarks**

Method setName


**since:** 1.2.3

**access:** public



# RadioButtonGroup::setValue #

**setValue(**
**mixed**
_$value_**);**





**Parameters**
> _$value_

**Remarks**

Method setValue


**since:** 1.2.3

**access:** public




---


## Variable Detail ##
**`$class_name` = ` ''` (line 29)** **Data type:** `mixed`**Overrides:** Array
**access:** protected


**`$form_object` = ` null` (line 31)** **Data type:** `mixed`**Overrides:** Array
**access:** protected


**`$name` = ` ''` (line 32)** **Data type:** `mixed`**Overrides:** Array
**access:** protected


**`$page_object` = ` null` (line 30)** **Data type:** `mixed`**Overrides:** Array
**access:** protected


**`$value` = ` ''` (line 33)** **Data type:** `mixed`
**access:** protected




---

## Class Constant Detail ##



---
