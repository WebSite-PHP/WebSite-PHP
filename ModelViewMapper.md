# Class ModelViewMapper #





Location: /database/ModelViewMapper.class.php


---



**Remarks**

Class ModelViewMapper


WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)  Copyright (c) 2009-2014 WebSite-PHP.com  PHP versions >= 5.2Licensed under The MIT License  Redistributions of files must retain the above copyright notice.


**author:** Emilien MOREL <>

**version:** 1.2.7

**copyright:** WebSite-PHP.com 17/01/2014

**link:**

**since:** 1.2.1

**access:** public



---

## Class Variable Summary ##


---

## Class Constant Summary ##

  * `PROPERTIES_ALL` = ` 'properties_apply_to_all'`

> Properties to apply to all fields


---

## Inherited Class Constant Summary ##



---

## Inherited Class Variable Summary ##



---

## Method Summary ##


## Inherited Method Summary ##


---

## Method Detail ##



# ModelViewMapper::construct #

**construct(**
**mixed**
_$page\_or\_form\_object_, **mixed**
_$database\_model\_object_, **mixed**
_$database\_object_**);**





**Parameters**
> _$page\_or\_form\_object_
> _$database\_model\_object_
> _$database\_object_

**Remarks**

Constructor ModelViewMapper




# ModelViewMapper::getField #

**getField(**
**mixed**
_$attribute\_name_**);**





**Parameters**
> _$attribute\_name_

**Remarks**

Method getField


**since:** 1.2.1

**access:** public



# ModelViewMapper::getSynchronizeModelObject #

**getSynchronizeModelObject(**
**);**





**Remarks**

Method getSynchronizeModelObject


**since:** 1.2.1

**access:** public



# ModelViewMapper::getTableFields #

**getTableFields(**
**);**





**Remarks**

Method getTableFields


**since:** 1.2.1

**access:** public



# ModelViewMapper::prepareFieldsArray #

**prepareFieldsArray(**
[**mixed**
_$properties_ = array()]**);**





**Parameters**
> _$properties_ [value: array(](default.md)

**Remarks**

Method prepareFieldsArray


**since:** 1.2.1

**access:** public



# ModelViewMapper::save #

**save(**
**);**





**Remarks**

Method save


**since:** 1.2.1

**access:** public



# ModelViewMapper::setField #

**setField(**
**mixed**
_$attribute\_name_, **mixed**
_$field_**);**





**Parameters**
> _$attribute\_name_
> _$field_

**Remarks**

Method setField


**since:** 1.2.1

**access:** public



# ModelViewMapper::setFieldValue #

**setFieldValue(**
**mixed**
_$attribute\_name_, **mixed**
_$value_**);**





**Parameters**
> _$attribute\_name_
> _$value_

**Remarks**

Method setFieldValue


**since:** 1.2.1

**access:** public




---


## Variable Detail ##


---

## Class Constant Detail ##

**`PROPERTIES_ALL` = ` 'properties_apply_to_all'` (line 34)**


**Remarks**

Properties to apply to all fields


Example: $properties = array(ModelViewMapper::PROPERTIES\_ALL =>  							array(&quot;update&quot; => false), ...);


**access:** public




---
