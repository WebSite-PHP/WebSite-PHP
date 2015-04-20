# Class LiveValidation #

WebSitePhpObject
> |
> --LiveValidation



Location: /display/advanced\_object/LiveValidation.class.php


---



**Remarks**

Class LiveValidation


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



# LiveValidation::construct #

**construct(**
[**boolean**
_$onlyOnSubmit_ = false]**);**


Overrides WebSitePhpObject::construct() (Constructor WebSitePhpObject)



**Parameters**
> _$onlyOnSubmit_ [value: false](default.md)

**Remarks**

Constructor LiveValidation




# LiveValidation::activeValidationOnInit #

**activeValidationOnInit(**
**);**





**Remarks**

Method activeValidationOnInit


**since:** 1.2.6

**access:** public



# LiveValidation::addValidateAcceptance #

**addValidateAcceptance(**
**);**





**Remarks**

Method addValidateAcceptance


**since:** 1.0.35

**access:** public



# LiveValidation::addValidateCalendar #

**addValidateCalendar(**
**mixed**
_$calendar\_format_**);**





**Parameters**
> _$calendar\_format_

**Remarks**

Method addValidateCalendar


**since:** 1.2.7

**access:** public



# LiveValidation::addValidateConfirmation #

**addValidateConfirmation(**
**string**
_$confirm\_from\_id_**);**





**Parameters**
> _$confirm\_from\_id_

**Remarks**

Method addValidateConfirmation


**since:** 1.0.35

**access:** public



# LiveValidation::addValidateCustom #

**addValidateCustom(**
**);**





**Remarks**

Method addValidateCustom


**since:** 1.0.35

**access:** public



# LiveValidation::addValidateEmail #

**addValidateEmail(**
**);**





**Remarks**

Method addValidateEmail


**since:** 1.0.35

**access:** public



# LiveValidation::addValidateExclusion #

**addValidateExclusion(**
**);**





**Remarks**

Method addValidateExclusion


**since:** 1.0.35

**access:** public



# LiveValidation::addValidateFormat #

**addValidateFormat(**
**string**
_$pattern_**);**





**Parameters**
> _$pattern_

**Remarks**

Method addValidateFormat


**since:** 1.0.35

**access:** public



# LiveValidation::addValidateInclusion #

**addValidateInclusion(**
**);**





**Remarks**

Method addValidateInclusion


**since:** 1.0.35

**access:** public



# LiveValidation::addValidateLength #

**addValidateLength(**
**integer**
_$length_**);**





**Parameters**
> _$length_

**Remarks**

Method addValidateLength


**since:** 1.0.35

**access:** public



# LiveValidation::addValidateNumericality #

**addValidateNumericality(**
[**boolean**
_$onlyInteger_ = false], [**integer**
_$minimum_ = ''], [**integer**
_$maximum_ = ''], [**integer**
_$is_ = '']**);**





**Parameters**
> _$onlyInteger_ [value: false](default.md)
> _$minimum_
> _$maximum_
> _$is_

**Remarks**

Method addValidateNumericality


**since:** 1.0.35

**access:** public



# LiveValidation::addValidatePresence #

**addValidatePresence(**
**);**





**Remarks**

Method addValidatePresence


**since:** 1.0.35

**access:** public



# LiveValidation::getFieldName #

**getFieldName(**
**);**





**Remarks**

Method getFieldName


**since:** 1.2.2

**access:** public



# LiveValidation::render #

**render(**
[**boolean**
_$ajax\_render_ = false]**);**


Overrides WebSitePhpObject::render() (Method render)



**Parameters**
> _$ajax\_render_ [value: false](default.md)

**Returns**
> html code of object LiveValidation

**Remarks**

Method render


**since:** 1.0.35

**access:** public



# LiveValidation::setAlertMessage #

**setAlertMessage(**
**string**
_$message_**);**





**Parameters**
> _$message_

**Remarks**

Method setAlertMessage


**since:** 1.0.35

**access:** public



# LiveValidation::setFieldName #

**setFieldName(**
**string**
_$name_**);**





**Parameters**
> _$name_

**Remarks**

Method setFieldName


**since:** 1.0.35

**access:** public



# LiveValidation::setObject #

**setObject(**
**WebSitePhpObject**
_$object_**);**





**Parameters**
> _$object_

**Remarks**

Method setObject


**since:** 1.0.35

**access:** public




---


## Variable Detail ##


---

## Class Constant Detail ##



---
