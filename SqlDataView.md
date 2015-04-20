# Class SqlDataView #





Location: /database/SqlDataView.class.php


---



**Remarks**

Class SqlDataView


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

  * `JOIN_TYPE_INNER` = ` 'INNER'`


  * `JOIN_TYPE_LEFT` = ` 'LEFT'`


  * `JOIN_TYPE_LEFT_OUTER` = ` 'LEFT OUTER'`


  * `JOIN_TYPE_RIGHT` = ` 'RIGHT'`


  * `JOIN_TYPE_RIGHT_OUTER` = ` 'RIGHT OUTER'`


  * `ORDER_ASC` = ` 'ASC'`


  * `ORDER_DESC` = ` 'DESC'`




---

## Inherited Class Constant Summary ##



---

## Inherited Class Variable Summary ##



---

## Method Summary ##


## Inherited Method Summary ##


---

## Method Detail ##



# SqlDataView::construct #

**construct(**
**mixed**
_$db\_table\_object_**);**





**Parameters**
> _$db\_table\_object_

**Remarks**

Constructor SqlDataView




# SqlDataView::addGroup #

**addGroup(**
**mixed**
_$attribute_**);**





**Parameters**
> _$attribute_

**Remarks**

Method addGroup


**since:** 1.0.103

**access:** public



# SqlDataView::addJoinAttribute #

**addJoinAttribute(**
**mixed**
_$db\_table\_object\_join_, **mixed**
_$join\_attribute\_1_, **mixed**
_$join\_attribute\_2_, [**string**
_$join\_type_ = 'INNER']**);**





**Parameters**
> _$db\_table\_object\_join_
> _$join\_attribute\_1_
> _$join\_attribute\_2_
> _$join\_type_ [value: INNER](default.md)

**Remarks**

Method addJoinAttribute


**since:** 1.0.59

**access:** public



# SqlDataView::addJoinClause #

**addJoinClause(**
**mixed**
_$db\_table\_object\_join_, **mixed**
_$join\_clause_, [**string**
_$join\_type_ = 'INNER']**);**





**Parameters**
> _$db\_table\_object\_join_
> _$join\_clause_
> _$join\_type_ [value: INNER](default.md)

**Remarks**

Method addJoinClause


**since:** 1.0.59

**access:** public



# SqlDataView::addJoinTableAttribute #

**addJoinTableAttribute(**
**mixed**
_$db\_table\_object\_join\_1_, **mixed**
_$db\_table\_object\_join\_2_, **mixed**
_$join\_attribute\_1_, **mixed**
_$join\_attribute\_2_, [**string**
_$join\_type_ = 'INNER']**);**





**Parameters**
> _$db\_table\_object\_join\_1_
> _$db\_table\_object\_join\_2_
> _$join\_attribute\_1_
> _$join\_attribute\_2_
> _$join\_type_ [value: INNER](default.md)

**Remarks**

Method addJoinTableAttribute


**since:** 1.0.59

**access:** public



# SqlDataView::addOrder #

**addOrder(**
**mixed**
_$attribute_, [**string**
_$order_ = 'ASC']**);**





**Parameters**
> _$attribute_
> _$order_ [value: ASC](default.md)

**Remarks**

Method addOrder


**since:** 1.0.35

**access:** public



# SqlDataView::createEmpty #

**createEmpty(**
**);**





**Remarks**

Method createEmpty


**since:** 1.0.35

**access:** public



# SqlDataView::enableHtmlentitiesMode #

**enableHtmlentitiesMode(**
**);**





**Remarks**

Method enableHtmlentitiesMode


**since:** 1.0.35

**access:** public



# SqlDataView::getCustomFields #

**getCustomFields(**
**);**





**Remarks**

Method getCustomFields


**since:** 1.1.12

**access:** public



# SqlDataView::getDbTableObject #

**getDbTableObject(**
**);**





**Remarks**

Method getDbTableObject


**since:** 1.1.6

**access:** public



# SqlDataView::getLastQuery #

**getLastQuery(**
[**boolean**
_$display\_params_ = true]**);**





**Parameters**
> _$display\_params_ [value: true](default.md)

**Remarks**

Method getLastQuery


**since:** 1.0.35

**access:** public



# SqlDataView::getListAttributeArray #

**getListAttributeArray(**
**);**





**Remarks**

Method getListAttributeArray


**since:** 1.1.6

**access:** public



# SqlDataView::getListAttributeTypeArray #

**getListAttributeTypeArray(**
**);**





**Remarks**

Method getListAttributeTypeArray


**since:** 1.1.6

**access:** public



# SqlDataView::getPrimaryKeysAttributes #

**getPrimaryKeysAttributes(**
**);**





**Remarks**

Method getPrimaryKeysAttributes


**since:** 1.1.6

**access:** public



# SqlDataView::isQueryWithJoin #

**isQueryWithJoin(**
**);**





**Remarks**

Method isQueryWithJoin


**since:** 1.1.6

**access:** public



# SqlDataView::retrieve #

**retrieve(**
**);**





**Remarks**

Method retrieve


**since:** 1.0.35

**access:** public



# SqlDataView::retrieveCount #

**retrieveCount(**
**);**





**Remarks**

Method retrieveCount


**since:** 1.0.99

**access:** public



# SqlDataView::setClause #

**setClause(**
**mixed**
_$clause_, [**mixed**
_$clause\_objects_ = array()]**);**





**Parameters**
> _$clause_
> _$clause\_objects_ [value: array(](default.md)

**Remarks**

Method setClause


**since:** 1.0.35

**access:** public



# SqlDataView::setCustomFields #

**setCustomFields(**
**mixed**
_$field1_, [**mixed**
_$field2_ = null], [**mixed**
_$field3_ = null], [**mixed**
_$field4_ = null], [**mixed**
_$field5_ = null]**);**





**Parameters**
> _$field1_
> _$field2_ [value: null](default.md)
> _$field3_ [value: null](default.md)
> _$field4_ [value: null](default.md)
> _$field5_ [value: null](default.md)

**Remarks**

Method setCustomFields


Note: Don't forget to prefix the fields if you use join and there is 2 fields with the same name


**since:** 1.0.103

**access:** public



# SqlDataView::setLimit #

**setLimit(**
**mixed**
_$offset_, **mixed**
_$row\_count_**);**





**Parameters**
> _$offset_
> _$row\_count_

**Remarks**

Method setLimit


**since:** 1.0.35

**access:** public




---


## Variable Detail ##


---

## Class Constant Detail ##

**`JOIN_TYPE_INNER` = ` 'INNER'` (line 30)**

**access:** public


**`JOIN_TYPE_LEFT` = ` 'LEFT'` (line 31)**

**access:** public


**`JOIN_TYPE_LEFT_OUTER` = ` 'LEFT OUTER'` (line 32)**

**access:** public


**`JOIN_TYPE_RIGHT` = ` 'RIGHT'` (line 33)**

**access:** public


**`JOIN_TYPE_RIGHT_OUTER` = ` 'RIGHT OUTER'` (line 34)**

**access:** public


**`ORDER_ASC` = ` 'ASC'` (line 42)**

**access:** public


**`ORDER_DESC` = ` 'DESC'` (line 41)**

**access:** public




---
