# Class CacheFile #





Location: /utils/CacheFile.class.php


---



**Remarks**

Class CacheFile


WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)  Copyright (c) 2009-2014 WebSite-PHP.com  PHP versions >= 5.2Licensed under The MIT License  Redistributions of files must retain the above copyright notice.


**author:** Emilien MOREL <>

**version:** 1.2.7

**copyright:** WebSite-PHP.com 17/01/2014

**link:**

**since:** 1.0.64

**access:** public



---

## Class Variable Summary ##
  * `$binary` = ``


  * `$cache_time` = ``


  * `$debug` = `true`


  * `$exists` = ` false`


  * `$file` = ``


  * `$filename` = ``


  * `$name` = ``


  * `$read_current_cache` = ` false`




---

## Class Constant Summary ##

  * `CACHE_TIME_1DAY` = ` 86400`

> cache time
    * `CACHE_TIME_1HOUR` = ` 3600`

> cache time
    * `CACHE_TIME_1MIN` = ` 60`

> cache time
    * `CACHE_TIME_1MONTH` = ` 2678400`

> cache time
    * `CACHE_TIME_1YEAR` = ` 31536000`

> cache time
    * `CACHE_TIME_2DAYS` = ` 172800`

> cache time
    * `CACHE_TIME_2HOURS` = ` 7200`

> cache time
    * `CACHE_TIME_2MIN` = ` 120`

> cache time
    * `CACHE_TIME_2MONTHS` = ` 5270400`

> cache time
    * `CACHE_TIME_2YEARS` = ` 63072000`

> cache time
    * `CACHE_TIME_3DAYS` = ` 259200`

> cache time
    * `CACHE_TIME_3HOURS` = ` 10800`

> cache time
    * `CACHE_TIME_3MONTHS` = ` 8035200`

> cache time
    * `CACHE_TIME_4DAYS` = ` 345600`

> cache time
    * `CACHE_TIME_4HOURS` = ` 14400`

> cache time
    * `CACHE_TIME_4MONTHS` = ` 10713600`

> cache time
    * `CACHE_TIME_6HOURS` = ` 21600`

> cache time
    * `CACHE_TIME_6MONTHS` = ` 15724800`

> cache time
    * `CACHE_TIME_7DAYS` = ` 604800`

> cache time
    * `CACHE_TIME_8HOURS` = ` 28800`

> cache time
    * `CACHE_TIME_10HOURS` = ` 36000`

> cache time
    * `CACHE_TIME_10MIN` = ` 600`

> cache time
    * `CACHE_TIME_12HOURS` = ` 43200`

> cache time
    * `CACHE_TIME_14DAYS` = ` 1209600`

> cache time
    * `CACHE_TIME_20MIN` = ` 1200`

> cache time
    * `CACHE_TIME_30MIN` = ` 1800`

> cache time


---

## Inherited Class Constant Summary ##



---

## Inherited Class Variable Summary ##



---

## Method Summary ##


## Inherited Method Summary ##


---

## Method Detail ##



# CacheFile::construct #

**construct(**
**string**
_$filename_, [**integer**
_$cache\_time_ = 0], [**boolean**
_$binary_ = false], [**boolean**
_$cache\_reset\_on\_midnight_ = false], [**string**
_$cache\_timezone_ = ''], [**boolean**
_$debug_ = true]**);**





**Parameters**
> _$filename_ path to cache file
> _$cache\_time_ cache time in seconds [value: 0](default.md)
> _$binary_ [value: false](default.md)
> _$cache\_reset\_on\_midnight_ [value: false](default.md)
> _$cache\_timezone_
> _$debug_ [value: true](default.md)

**Remarks**

Constructor CacheFile




# CacheFile::close #

**close(**
**);**





**Remarks**

Method close


**since:** 1.0.64

**access:** public



# CacheFile::debug\_mode #

**debug\_mode(**
[**boolean**
_$debug_ = true]**);**





**Parameters**
> _$debug_ [value: true](default.md)

**Remarks**

Method debug\_mode


**since:** 1.0.59

**access:** public



# CacheFile::halt #

**halt(**
**mixed**
_$message_**);**





**Parameters**
> _$message_

**Remarks**

Method halt


**since:** 1.0.100

**access:** public



# CacheFile::isCached #

**isCached(**
**);**





**Remarks**

Method isCached


**since:** 1.1.9

**access:** public



# CacheFile::readCache #

**readCache(**
**);**





**Returns**
> return false if no cache or old cache

**Remarks**

Method readCache


**since:** 1.0.64

**access:** public



# CacheFile::writeCache #

**writeCache(**
**mixed**
_$data_**);**





**Parameters**
> _$data_

**Remarks**

Method writeCache


**since:** 1.0.64

**access:** public




---


## Variable Detail ##
**`$binary` = `` (line 61)** **Data type:** `mixed`

**`$cache_time` = `` (line 63)** **Data type:** `mixed`

**`$debug` = `true` (line 66)** **Data type:** `mixed`

**`$exists` = ` false` (line 64)** **Data type:** `mixed`

**`$file` = `` (line 59)** **Data type:** `mixed`

**`$filename` = `` (line 60)** **Data type:** `mixed`

**`$name` = `` (line 62)** **Data type:** `mixed`

**`$read_current_cache` = ` false` (line 65)** **Data type:** `mixed`



---

## Class Constant Detail ##

**`CACHE_TIME_1DAY` = ` 86400` (line 44)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_1HOUR` = ` 3600` (line 36)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_1MIN` = ` 60` (line 31)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_1MONTH` = ` 2678400` (line 50)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_1YEAR` = ` 31536000` (line 55)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_2DAYS` = ` 172800` (line 45)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_2HOURS` = ` 7200` (line 37)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_2MIN` = ` 120` (line 32)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_2MONTHS` = ` 5270400` (line 51)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_2YEARS` = ` 63072000` (line 56)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_3DAYS` = ` 259200` (line 46)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_3HOURS` = ` 10800` (line 38)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_3MONTHS` = ` 8035200` (line 52)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_4DAYS` = ` 345600` (line 47)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_4HOURS` = ` 14400` (line 39)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_4MONTHS` = ` 10713600` (line 53)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_6HOURS` = ` 21600` (line 40)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_6MONTHS` = ` 15724800` (line 54)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_7DAYS` = ` 604800` (line 48)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_8HOURS` = ` 28800` (line 41)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_10HOURS` = ` 36000` (line 42)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_10MIN` = ` 600` (line 33)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_12HOURS` = ` 43200` (line 43)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_14DAYS` = ` 1209600` (line 49)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_20MIN` = ` 1200` (line 34)**


**Remarks**

cache time


**access:** public


**`CACHE_TIME_30MIN` = ` 1800` (line 35)**


**Remarks**

cache time


**access:** public




---
