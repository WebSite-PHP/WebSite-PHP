# Class JavaScriptInclude #





Location: /JavaScriptInclude.class.php


---




---

## Class Variable Summary ##


---

## Class Constant Summary ##



---

## Inherited Class Constant Summary ##



---

## Inherited Class Variable Summary ##



---

## Method Summary ##

  * `static JavaScriptInclude getInstance()`
> Method getInstance
    * `JavaScriptInclude getInstance()`
> Method getInstance

## Inherited Method Summary ##


---

## Method Detail ##


# static JavaScriptInclude::getInstance #

**static getInstance(**
**);**





**Remarks**

Method getInstance


**since:** 1.0.35

**access:** public




# JavaScriptInclude::construct #

**construct(**
**);**





**Remarks**

Constructor JavaScriptInclude




# JavaScriptInclude::add #

**add(**
**string**
_$js\_url_, [**string**
_$conditional\_comment_ = ''], [**boolean**
_$combine_ = false], [**string**
_$js\_script_ = ''], [**boolean**
_$async_ = false]**);**





**Parameters**
> _$js\_url_
> _$conditional\_comment_
> _$combine_ [value: false](default.md)
> _$js\_script_
> _$async_ [value: false](default.md)

**Remarks**

Method add


**since:** 1.0.59

**access:** public



# JavaScriptInclude::addToBegin #

**addToBegin(**
**string**
_$js\_url_, [**string**
_$conditional\_comment_ = ''], [**boolean**
_$combine_ = false], [**boolean**
_$async_ = false]**);**





**Parameters**
> _$js\_url_
> _$conditional\_comment_
> _$combine_ [value: false](default.md)
> _$async_ [value: false](default.md)

**Remarks**

Method addToBegin


**since:** 1.0.80

**access:** public



# JavaScriptInclude::addToEnd #

**addToEnd(**
**string**
_$js\_url_, [**string**
_$conditional\_comment_ = ''], [**boolean**
_$combine_ = false], [**boolean**
_$async_ = false]**);**





**Parameters**
> _$js\_url_
> _$conditional\_comment_
> _$combine_ [value: false](default.md)
> _$async_ [value: false](default.md)

**Remarks**

Method addToEnd


**since:** 1.0.80

**access:** public



# JavaScriptInclude::addUrlWithScript #

**addUrlWithScript(**
**string**
_$js\_url_, **string**
_$js\_script_, [**string**
_$conditional\_comment_ = '']**);**





**Parameters**
> _$js\_url_
> _$js\_script_
> _$conditional\_comment_

**Remarks**

Method addUrlWithScript


With this method you can include javascript file with script like 

&lt;script src=...&gt;$js\_script&lt;/script&gt;

  Warning this script can be only load in standard page (.html)


**since:** 1.0.88

**access:** public



# JavaScriptInclude::get #

**get(**
[**boolean**
_$sort_ = false]**);**





**Parameters**
> _$sort_ [value: false](default.md)

**Remarks**

Method get


**since:** 1.0.35

**access:** public



# JavaScriptInclude::getArrayJsToBegin #

**getArrayJsToBegin(**
**);**





**Remarks**

Method getArrayJsToBegin


**since:** 1.0.80

**access:** public



# JavaScriptInclude::getArrayJsToEnd #

**getArrayJsToEnd(**
**);**





**Remarks**

Method getArrayJsToEnd


**since:** 1.0.80

**access:** public



# JavaScriptInclude::getCombine #

**getCombine(**
**mixed**
_$indice_**);**





**Parameters**
> _$indice_

**Remarks**

Method getCombine


**since:** 1.0.35

**access:** public



# JavaScriptInclude::getConditionalComment #

**getConditionalComment(**
**mixed**
_$indice_**);**





**Parameters**
> _$indice_

**Remarks**

Method getConditionalComment


**since:** 1.0.35

**access:** public



# JavaScriptInclude::getIsAsync #

**getIsAsync(**
**mixed**
_$indice_**);**





**Parameters**
> _$indice_

**Remarks**

Method getIsAsync


**since:** 1.2.9

**access:** public



# JavaScriptInclude::getJsIncludeScript #

**getJsIncludeScript(**
**mixed**
_$indice_**);**





**Parameters**
> _$indice_

**Remarks**

Method getJsIncludeScript


**since:** 1.0.88

**access:** public




---


## Variable Detail ##


---

## Class Constant Detail ##



---
