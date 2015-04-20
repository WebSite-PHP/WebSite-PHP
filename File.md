# Class File #





Location: /utils/File.class.php


---



**Remarks**

Class File


WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)  Copyright (c) 2009-2014 WebSite-PHP.com  PHP versions >= 5.2Licensed under The MIT License  Redistributions of files must retain the above copyright notice.


**author:** Emilien MOREL <>

**version:** 1.2.7

**copyright:** WebSite-PHP.com 17/01/2014

**link:**

**since:** 1.0.13

**access:** public



---

## Class Variable Summary ##
  * `$action_before_reading` = `false`


  * `$binary` = ``


  * `$debug` = `true`


  * `$exists` = ` false`


  * `$file` = ``


  * `$name` = ``


  * `$size` = ``




---

## Class Constant Summary ##



---

## Inherited Class Constant Summary ##



---

## Inherited Class Variable Summary ##



---

## Method Summary ##


## Inherited Method Summary ##


---

## Method Detail ##



# File::construct #

**construct(**
**mixed**
_$filename_, [**boolean**
_$binary_ = false], [**boolean**
_$delete\_if\_exists_ = false], [**boolean**
_$debug_ = true]**);**





**Parameters**
> _$filename_ path to the file
> _$binary_ [value: false](default.md)
> _$delete\_if\_exists_ [value: false](default.md)
> _$debug_ [value: true](default.md)

**Remarks**

Constructor File




# File::close #

**close(**
**);**





**Remarks**

Method close


Close the file


**since:** 1.0.59

**access:** public



# File::copy #

**copy(**
**string**
_$destination_**);**





**Parameters**
> _$destination_ The new file destination

**Returns**
> Returns TRUE if file could bie copied, FALSE if not

**Remarks**

Method copy


**since:** 1.0.35

**access:** public



# File::debug\_mode #

**debug\_mode(**
[**boolean**
_$debug_ = true]**);**





**Parameters**
> _$debug_ [value: true](default.md)

**Remarks**

Method debug\_mode


**since:** 1.0.59

**access:** public



# File::exists #

**exists(**
**);**





**Remarks**

Method exists


Close the file


**since:** 1.0.35

**access:** public



# File::get\_group\_id #

**get\_group\_id(**
**);**





**Returns**
> The group id of the file

**Remarks**

Method get\_group\_id


**since:** 1.0.35

**access:** public



# File::get\_name #

**get\_name(**
**);**





**Returns**
> The filename

**Remarks**

Method get\_name


**since:** 1.0.35

**access:** public



# File::get\_owner\_id #

**get\_owner\_id(**
**);**





**Returns**
> The user id of the file

**Remarks**

Method get\_owner\_id


**since:** 1.0.35

**access:** public



# File::get\_size #

**get\_size(**
**);**





**Returns**
> The filesize in bytes

**Remarks**

Method get\_size


**since:** 1.0.35

**access:** public



# File::get\_suffix #

**get\_suffix(**
**);**





**Returns**
> The suffix of the file. If no suffix exists FALSE will be returned

**Remarks**

Method get\_suffix


**since:** 1.0.35

**access:** public



# File::get\_time #

**get\_time(**
**);**





**Returns**
> The time of the last change as timestamp

**Remarks**

Method get\_time


**since:** 1.0.35

**access:** public



# File::halt #

**halt(**
**string**
_$message_**);**





**Parameters**
> _$message_ all occurred errors as array

**Remarks**

Method halt


**since:** 1.0.59

**access:** public



# File::pointer\_get #

**pointer\_get(**
**);**





**Remarks**

Method pointer\_get


**since:** 1.0.35

**access:** public



# File::pointer\_set #

**pointer\_set(**
**mixed**
_$offset_**);**





**Parameters**
> _$offset_

**Returns**
> Returns the actual pointer position

**Remarks**

Method pointer\_set


**since:** 1.0.35

**access:** public



# File::read #

**read(**
**);**





**Returns**
> return data

**Remarks**

Method read


**since:** 1.0.64

**access:** public



# File::read\_bytes #

**read\_bytes(**
**mixed**
_$bytes_, [**double**
_$start\_byte_ = 0]**);**





**Parameters**
> _$bytes_
> _$start\_byte_ [value: 0](default.md)

**Returns**
> Data from a binary file

**Remarks**

Method read\_bytes


**since:** 1.0.35

**access:** public



# File::read\_line #

**read\_line(**
**);**





**Returns**
> A line from the file. If is EOF, false will be returned

**Remarks**

Method read\_line


**since:** 1.0.35

**access:** public



# File::search #

**search(**
**string**
_$string_**);**





**Parameters**
> _$string_ The string which have to be searched

**Returns**
> Pointer offsets where string have been found. On no match, function returns false

**Remarks**

Method search


**since:** 1.0.35

**access:** public



# File::write #

**write(**
**string**
_$data_**);**





**Parameters**
> _$data_ The data which have to be written

**Returns**
> Returns TRUE if data could be written, FALSE if not

**Remarks**

Method write


**since:** 1.0.35

**access:** public




---


## Variable Detail ##
**`$action_before_reading` = `false` (line 33)** **Data type:** `mixed`

**`$binary` = `` (line 27)** **Data type:** `mixed`

**`$debug` = `true` (line 32)** **Data type:** `mixed`

**`$exists` = ` false` (line 30)** **Data type:** `mixed`

**`$file` = `` (line 26)** **Data type:** `mixed`

**`$name` = `` (line 28)** **Data type:** `mixed`

**`$size` = `` (line 29)** **Data type:** `mixed`



---

## Class Constant Detail ##



---
