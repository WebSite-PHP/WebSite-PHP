# Class Slider #

WebSitePhpObject
> |
> --Slider



Location: /display/advanced\_object/Slider.class.php


---



**Remarks**

Class Slider


WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)  Copyright (c) 2009-2014 WebSite-PHP.com  PHP versions >= 5.2Licensed under The MIT License  Redistributions of files must retain the above copyright notice.


**author:** Emilien MOREL <>

**version:** 1.2.9

**copyright:** WebSite-PHP.com 17/01/2014

**link:**

**since:** 1.2.7

**access:** public



---

## Class Variable Summary ##


---

## Class Constant Summary ##

  * `HORIZONTAL_SLIDER` = ` ''`

> Slider style
    * `VERTICAL_SLIDER` = ` 'vertical'`

> Slider style


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



# Slider::construct #

**construct(**
[**double**
_$value_ = 0], [**double**
_$min\_value_ = 0], [**double**
_$max\_value_ = 100], [**string**
_$id_ = 'slider'], [**mixed**
_$orientation_ = Slider::HORIZONTAL\_SLIDER]**);**


Overrides WebSitePhpObject::construct() (Constructor WebSitePhpObject)



**Parameters**
> _$value_ [value: 0](default.md)
> _$min\_value_ [value: 0](default.md)
> _$max\_value_ [value: 100](default.md)
> _$id_ [value: slider](default.md)
> _$orientation_ [value: Slider::HORIZONTAL\_SLIDER](default.md)

**Remarks**

Constructor Slider




# Slider::displayText #

**displayText(**
[
_$title_ = ''], [
_$text\_pattern_ = '{#value}€'], [
_$text\_pattern\_range\_max_ = '{#value}€']**);**





**Parameters**
> _$title_
> _$text\_pattern_
> _$text\_pattern\_range\_max_
  * ccess:**public**



# Slider::getId #

**getId(**
**);**





**Remarks**

Method getId


**since:** 1.2.7

**access:** public



# Slider::onChangeJs #

**onChangeJs(**
**mixed**
_$js\_function_**);**





**Parameters**
> _$js\_function_

**Remarks**

Method onChangeJs


**since:** 1.2.7

**access:** public



# Slider::onSlideJs #

**onSlideJs(**
**mixed**
_$js\_function_**);**





**Parameters**
> _$js\_function_

**Remarks**

Method onSlideJs


**since:** 1.2.7

**access:** public



# Slider::render #

**render(**
[**boolean**
_$ajax\_render_ = false]**);**


Overrides WebSitePhpObject::render() (Method render)



**Parameters**
> _$ajax\_render_ [value: false](default.md)

**Returns**
> html code of object Slider

**Remarks**

Method render


**since:** 1.2.7

**access:** public



# Slider::setBackgroundColor #

**setBackgroundColor(**
**mixed**
_$background\_color_**);**





**Parameters**
> _$background\_color_

**Remarks**

Method setBackgroundColor


**since:** 1.2.7

**access:** public



# Slider::setCursorColor #

**setCursorColor(**
**mixed**
_$cursur\_color_**);**





**Parameters**
> _$cursur\_color_

**Remarks**

Method setCursorColor


**since:** 1.2.7

**access:** public



# Slider::setId #

**setId(**
**mixed**
_$id_**);**





**Parameters**
> _$id_

**Remarks**

Method setId


**since:** 1.2.7

**access:** public



# Slider::setMaxValue #

**setMaxValue(**
**mixed**
_$max\_value_**);**





**Parameters**
> _$max\_value_

**Remarks**

Method setMaxValue


**since:** 1.2.7

**access:** public



# Slider::setMinValue #

**setMinValue(**
**mixed**
_$min\_value_**);**





**Parameters**
> _$min\_value_

**Remarks**

Method setMinValue


**since:** 1.2.7

**access:** public



# Slider::setRangeValues #

**setRangeValues(**
**mixed**
_$min\_rangle\_value_, **mixed**
_$max\_rangle\_value_**);**





**Parameters**
> _$min\_rangle\_value_
> _$max\_rangle\_value_

**Remarks**

Method setRangeValues


**since:** 1.2.7

**access:** public



# Slider::setStep #

**setStep(**
**mixed**
_$step_**);**





**Parameters**
> _$step_

**Remarks**

Method setStep


**since:** 1.2.7

**access:** public



# Slider::setValue #

**setValue(**
**mixed**
_$value_**);**





**Parameters**
> _$value_

**Remarks**

Method setValue


**since:** 1.2.7

**access:** public




---


## Variable Detail ##


---

## Class Constant Detail ##

**`HORIZONTAL_SLIDER` = ` ''` (line 33)**


**Remarks**

Slider style


**access:** public


**`VERTICAL_SLIDER` = ` 'vertical'` (line 34)**


**Remarks**

Slider style


**access:** public




---
