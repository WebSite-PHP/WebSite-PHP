# Class DataBase #





Location: /database/DataBase.class.php


---



**Remarks**

Class DataBase


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



---

## Method Summary ##

  * `static DataBase getInstance()`
> Method getInstance
    * `DataBase getInstance()`
> Method getInstance

## Inherited Method Summary ##


---

## Method Detail ##


# static DataBase::getInstance #

**static getInstance(**
[**boolean**
_$connect_ = true]**);**





**Parameters**
> _$connect_ [value: true](default.md)

**Remarks**

Method getInstance


**since:** 1.0.35

**access:** public




# DataBase::construct #

**construct(**
**string**
_$host_, **string**
_$root_, **string**
_$password_, [**string**
_$database_ = ''], [**double**
_$port_ = 3306]**);**





**Parameters**
> _$host_
> _$root_
> _$password_
> _$database_
> _$port_ [value: 3306](default.md)

**Remarks**

Constructor DataBase




# DataBase::beginTransaction #

**beginTransaction(**
**);**





**Remarks**

Method beginTransaction


**since:** 1.0.35

**access:** public



# DataBase::commitTransaction #

**commitTransaction(**
**);**





**Remarks**

Method commitTransaction


**since:** 1.0.59

**access:** public



# DataBase::connect #

**connect(**
**);**





**Remarks**

Method connect


**since:** 1.0.35

**access:** public



# DataBase::disconnect #

**disconnect(**
**);**





**Remarks**

Method disconnect


**since:** 1.0.59

**access:** public



# DataBase::getLastInsertId #

**getLastInsertId(**
**);**





**Remarks**

Method getLastInsertId


**since:** 1.0.35

**access:** public



# DataBase::isConnect #

**isConnect(**
**);**





**Remarks**

Method isConnect


**since:** 1.0.103

**access:** public



# DataBase::prepareStatement #

**prepareStatement(**
**string**
_$query_, [**array**
_$stmt\_objects_ = array()]**);**





**Parameters**
> _$query_
> _$stmt\_objects_ [value: array()](default.md)

**Remarks**

Method prepareStatement


**since:** 1.0.35

**access:** public



# DataBase::rollbackTransaction #

**rollbackTransaction(**
**);**





**Remarks**

Method rollbackTransaction


**since:** 1.0.59

**access:** public



# DataBase::select\_db #

**select\_db(**
**string**
_$schema_**);**





**Parameters**
> _$schema_

**Remarks**

Method select\_db


**since:** 1.0.35

**access:** public



# DataBase::setUTF8QueryCharset #

**setUTF8QueryCharset(**
**);**





**Remarks**

Method setUTF8QueryCharset


**since:** 1.2.2

**access:** public



# DataBase::stmtBindAssoc #

**stmtBindAssoc(**

_&$stmt_, **mixed**
_$&stmt_**);**





**Parameters**
> _$&stmt_
> _&$stmt_

**Remarks**

Method stmtBindAssoc


**since:** 1.0.35

**access:** public




---


## Variable Detail ##


---

## Class Constant Detail ##



---
