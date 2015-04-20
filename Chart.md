# Class Chart #

WebSitePhpObject
> |
> --Chart



Location: /modules/Graphic/Chart.class.php


---



**Remarks**

Class Chart


WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)  Copyright (c) 2009-2014 WebSite-PHP.com  PHP versions >= 5.2Licensed under The MIT License  Redistributions of files must retain the above copyright notice.


**author:** Emilien MOREL <>

**version:** 1.2.7

**copyright:** WebSite-PHP.com 17/01/2014

**link:**

**since:** 1.0.91

**access:** public



---

## Class Variable Summary ##


---

## Class Constant Summary ##

  * `DATA_TYPE_DATE` = ` 'time_date'`

> Chart data type
    * `DATA_TYPE_DATETIME` = ` 'time_datetime'`

> Chart data type
    * `DATA_TYPE_DAY` = ` 'time_day'`

> Chart data type
    * `DATA_TYPE_DAYMONTH` = ` 'time_daymonth'`

> Chart data type
    * `DATA_TYPE_MONTH` = ` 'time_month'`

> Chart data type
    * `DATA_TYPE_NUMERIC` = ` ''`

> Chart data type
    * `DATA_TYPE_TIME` = ` 'time_time'`

> Chart data type
    * `DATA_TYPE_YEAR` = ` 'time_year'`

> Chart data type
    * `DESIGN_BARS` = ` 'bars'`

> Chart line design
    * `DESIGN_LINES` = ` 'lines'`

> Chart line design
    * `DESIGN_LINES_POINTS` = ` 'lines_points'`

> Chart line design
    * `DESIGN_LINES_POINTS_WITH_STEPS` = ` 'lines_points_with_steps'`

> Chart line design
    * `DESIGN_LINES_WITH_STEPS` = ` 'lines_with_steps'`

> Chart line design
    * `DESIGN_POINTS` = ` 'points'`

> Chart line design
    * `STYLE_NO_STACKING` = ` 'no_stack'`

> Chart stack style
    * `STYLE_STACKING` = ` 'stack'`

> Chart stack style
    * `TRACKING_MODE_X` = ` 'x'`

> Chart tracking mode
    * `TRACKING_MODE_Y` = ` 'y'`

> Chart tracking mode


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



# Chart::construct #

**construct(**
[**string**
_$id_ = &quot;graphic\_chart\_id&quot;], [**double**
_$width_ = 500], [**double**
_$height_ = 300], [**boolean**
_$legend_ = false], [**string**
_$bar\_width_ = &quot;&quot;]**);**


Overrides WebSitePhpObject::construct() (Constructor WebSitePhpObject)



**Parameters**
> _$id_ [value: graphic\_chart\_id](default.md)
> _$width_ [value: 500](default.md)
> _$height_ [value: 300](default.md)
> _$legend_ [value: false](default.md)
> _$bar\_width_

**Remarks**

Constructor Chart




# Chart::addPoints #

**addPoints(**
**mixed**
_$title_, **mixed**
_$array\_data_, [**string**
_$chart\_design_ = &quot;lines&quot;], [**string**
_$stack_ = &quot;no\_stack&quot;], [**boolean**
_$fill_ = false]**);**





**Parameters**
> _$title_
> _$array\_data_
> _$chart\_design_ [value: lines](default.md)
> _$stack_ [value: no\_stack](default.md)
> _$fill_ [value: false](default.md)

**Remarks**

Method addPoints


**since:** 1.0.91

**access:** public



# Chart::render #

**render(**
[**boolean**
_$ajax\_render_ = false]**);**


Overrides WebSitePhpObject::render() (Method render)



**Parameters**
> _$ajax\_render_ [value: false](default.md)

**Returns**
> html code of object Chart

**Remarks**

Method render


**since:** 1.0.91

**access:** public



# Chart::setLegend #

**setLegend(**
[**boolean**
_$bool_ = true]**);**





**Parameters**
> _$bool_ [value: true](default.md)

**Remarks**

Method setLegend


**since:** 1.0.91

**access:** public



# Chart::setXAxisDataType #

**setXAxisDataType(**
[**string**
_$x\_data\_type_ = &quot;&quot;]**);**





**Parameters**
> _$x\_data\_type_

**Remarks**

Method setXAxisDataType


**since:** 1.0.91

**access:** public



# Chart::setXAxisMax #

**setXAxisMax(**
**mixed**
_$x\_max_**);**





**Parameters**
> _$x\_max_

**Remarks**

Method setXAxisMax


**since:** 1.0.91

**access:** public



# Chart::setXAxisMin #

**setXAxisMin(**
**mixed**
_$x\_min_**);**





**Parameters**
> _$x\_min_

**Remarks**

Method setXAxisMin


**since:** 1.0.91

**access:** public



# Chart::setYAxisDataType #

**setYAxisDataType(**
[**string**
_$y\_data\_type_ = &quot;&quot;]**);**





**Parameters**
> _$y\_data\_type_

**Remarks**

Method setYAxisDataType


**since:** 1.0.91

**access:** public



# Chart::setYAxisMax #

**setYAxisMax(**
**mixed**
_$y\_max_**);**





**Parameters**
> _$y\_max_

**Remarks**

Method setYAxisMax


**since:** 1.0.91

**access:** public



# Chart::setYAxisMin #

**setYAxisMin(**
**mixed**
_$y\_min_**);**





**Parameters**
> _$y\_min_

**Remarks**

Method setYAxisMin


**since:** 1.0.91

**access:** public



# Chart::trackingWithMouse #

**trackingWithMouse(**
[**string**
_$tracking\_mode_ = &quot;x&quot;], [**boolean**
_$tracking\_text_ = true]**);**





**Parameters**
> _$tracking\_mode_ [value: x](default.md)
> _$tracking\_text_ [value: true](default.md)

**Remarks**

Method trackingWithMouse


**since:** 1.0.91

**access:** public




---


## Variable Detail ##


---

## Class Constant Detail ##

**`DATA_TYPE_DATE` = ` 'time_date'` (line 65)**


**Remarks**

Chart data type


**access:** public


**`DATA_TYPE_DATETIME` = ` 'time_datetime'` (line 67)**


**Remarks**

Chart data type


**access:** public


**`DATA_TYPE_DAY` = ` 'time_day'` (line 68)**


**Remarks**

Chart data type


**access:** public


**`DATA_TYPE_DAYMONTH` = ` 'time_daymonth'` (line 70)**


**Remarks**

Chart data type


**access:** public


**`DATA_TYPE_MONTH` = ` 'time_month'` (line 69)**


**Remarks**

Chart data type


**access:** public


**`DATA_TYPE_NUMERIC` = ` ''` (line 64)**


**Remarks**

Chart data type


**access:** public


**`DATA_TYPE_TIME` = ` 'time_time'` (line 66)**


**Remarks**

Chart data type


**access:** public


**`DATA_TYPE_YEAR` = ` 'time_year'` (line 71)**


**Remarks**

Chart data type


**access:** public


**`DESIGN_BARS` = ` 'bars'` (line 33)**


**Remarks**

Chart line design


**access:** public


**`DESIGN_LINES` = ` 'lines'` (line 34)**


**Remarks**

Chart line design


**access:** public


**`DESIGN_LINES_POINTS` = ` 'lines_points'` (line 37)**


**Remarks**

Chart line design


**access:** public


**`DESIGN_LINES_POINTS_WITH_STEPS` = ` 'lines_points_with_steps'` (line 38)**


**Remarks**

Chart line design


**access:** public


**`DESIGN_LINES_WITH_STEPS` = ` 'lines_with_steps'` (line 35)**


**Remarks**

Chart line design


**access:** public


**`DESIGN_POINTS` = ` 'points'` (line 36)**


**Remarks**

Chart line design


**access:** public


**`STYLE_NO_STACKING` = ` 'no_stack'` (line 47)**


**Remarks**

Chart stack style


**access:** public


**`STYLE_STACKING` = ` 'stack'` (line 46)**


**Remarks**

Chart stack style


**access:** public


**`TRACKING_MODE_X` = ` 'x'` (line 55)**


**Remarks**

Chart tracking mode


**access:** public


**`TRACKING_MODE_Y` = ` 'y'` (line 56)**


**Remarks**

Chart tracking mode


**access:** public




---
