# Class Snoopy #





Location: /modules/RSS-Reader/extlib/Snoopy.class.inc


---



**Remarks**




Snoopy - the PHP net client  Author: Monte Ohrt <monte@ispi.net>  Copyright (c): 1999-2000 ispi, all rights reserved  Version: 1.0




---

## Class Variable Summary ##
  * `$accept` = `   'image/gif, image/x-xbitmap, image/jpeg, image/pjpeg, */*'`


  * `$agent` = `   'Snoopy v1.0'`


  * `$cookies` = `array()`


  * `$curl_path` = `   '/usr/bin/curl'`


  * `$error` = `   ''`


  * `$expandlinks` = `   true`


  * `$headers` = `array()`


  * `$host` = `   'www.php.net'`

  * Public variables *** `$lastredirectaddr` = `   ''`**


  * `$maxframes` = `   0`


  * `$maxlength` = `   500000`


  * `$maxredirs` = `   5`


  * `$offsiteok` = `   true`


  * `$pass` = `   ''`


  * `$passcookies` = `   true`


  * `$port` = `   80`


  * `$proxy_host` = `   ''`


  * `$proxy_port` = `   ''`


  * `$rawheaders` = `array()`


  * `$read_timeout` = `   0`


  * `$referer` = `   ''`


  * `$response_code` = `   ''`


  * `$results` = `   ''`


  * `$status` = `   0`


  * `$timed_out` = `   false`


  * `$user` = `   ''`


  * `$use_gzip` = ` true`


  * `$_fp_timeout` = `   30`


  * `$_framedepth` = `   0`


  * `$_frameurls` = `array()`


  * `$_httpmethod` = `   'GET'`


  * `$_httpversion` = `   'HTTP/1.0'`


  * `$_isproxy` = `   false`


  * `$_maxlinelen` = `   4096`

  * Private variables *** `$_mime_boundary` = `   ''`**


  * `$_redirectaddr` = `   false`


  * `$_redirectdepth` = `   0`


  * `$_submit_method` = `   'POST'`


  * `$_submit_type` = `   'application/x-www-form-urlencoded'`




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



# Snoopy::fetch #

**fetch(**

_$URI_**);**





**Parameters**
> _$URI_


# Snoopy::setcookies #

**setcookies(**
**);**






# Snoopy::_check\_timeout #_

_**check\_timeout(**_$fp_**);**_





**Parameters**
> _$fp_


# Snoopy::_connect #_

_**connect(**_&$fp_**);**_





**Parameters**
> _&$fp_


# Snoopy::_disconnect #_

_**disconnect(**_$fp_**);**_





**Parameters**
> _$fp_


# Snoopy::_expandlinks #_

_**expandlinks(**_$links_,_$URI_**);**_





**Parameters**
> _$links_
> _$URI_


# Snoopy::_httprequest #_

_**httprequest(**_$url_,_$fp_,_$URI_,_$http\_method_, [_$content\_type_= &quot;&quot;], [_$body_= &quot;&quot;]**);**_





**Parameters**
> _$url_
> _$fp_
> _$URI_
> _$http\_method_
> _$content\_type_
> _$body_


# Snoopy::_httpsrequest #_

_**httpsrequest(**_$url_,_$URI_,_$http\_method_, [_$content\_type_= &quot;&quot;], [_$body_= &quot;&quot;]**);**_





**Parameters**
> _$url_
> _$URI_
> _$http\_method_
> _$content\_type_
> _$body_


# Snoopy::_prepare\_post\_body #_

_**prepare\_post\_body(**_$formvars_,_$formfiles_**);**_





**Parameters**
> _$formvars_
> _$formfiles_


# Snoopy::_stripform #_

_**stripform(**_$document_**);**_





**Parameters**
> _$document_


# Snoopy::_striplinks #_

_**striplinks(**_$document_**);**_





**Parameters**
> _$document_


# Snoopy::_striptext #_

_**striptext(**_$document_**);**_





**Parameters**
> _$document_



---


## Variable Detail ##
**`$accept` = `   'image/gif, image/x-xbitmap, image/jpeg, image/pjpeg, */*'` (line 74)** **Data type:** `mixed`

**`$agent` = `   'Snoopy v1.0'` (line 52)** **Data type:** `mixed`

**`$cookies` = `array()` (line 54)** **Data type:** `mixed`

**`$curl_path` = `   '/usr/bin/curl'` (line 88)** **Data type:** `mixed`

**`$error` = `   ''` (line 78)** **Data type:** `mixed`

**`$expandlinks` = `   true` (line 63)** **Data type:** `mixed`

**`$headers` = `array()` (line 80)** **Data type:** `mixed`

**`$host` = `   'www.php.net'` (line 48)** **Data type:** `mixed`

**Remarks**

 Public variables 



**`$lastredirectaddr` = `   ''` (line 60)** **Data type:** `mixed`

**`$maxframes` = `   0` (line 62)** **Data type:** `mixed`

**`$maxlength` = `   500000` (line 81)** **Data type:** `mixed`

**`$maxredirs` = `   5` (line 59)** **Data type:** `mixed`

**`$offsiteok` = `   true` (line 61)** **Data type:** `mixed`

**`$pass` = `   ''` (line 71)** **Data type:** `mixed`

**`$passcookies` = `   true` (line 66)** **Data type:** `mixed`

**`$port` = `   80` (line 49)** **Data type:** `mixed`

**`$proxy_host` = `   ''` (line 50)** **Data type:** `mixed`

**`$proxy_port` = `   ''` (line 51)** **Data type:** `mixed`

**`$rawheaders` = `array()` (line 56)** **Data type:** `mixed`

**`$read_timeout` = `   0` (line 82)** **Data type:** `mixed`

**`$referer` = `   ''` (line 53)** **Data type:** `mixed`

**`$response_code` = `   ''` (line 79)** **Data type:** `mixed`

**`$results` = `   ''` (line 76)** **Data type:** `mixed`

**`$status` = `   0` (line 86)** **Data type:** `mixed`

**`$timed_out` = `   false` (line 85)** **Data type:** `mixed`

**`$user` = `   ''` (line 70)** **Data type:** `mixed`

**`$use_gzip` = ` true` (line 101)** **Data type:** `mixed`

**`$_fp_timeout` = `   30` (line 118)** **Data type:** `mixed`

**`$_framedepth` = `   0` (line 115)** **Data type:** `mixed`

**`$_frameurls` = `array()` (line 114)** **Data type:** `mixed`

**`$_httpmethod` = `   'GET'` (line 107)** **Data type:** `mixed`

**`$_httpversion` = `   'HTTP/1.0'` (line 108)** **Data type:** `mixed`

**`$_isproxy` = `   false` (line 117)** **Data type:** `mixed`

**`$_maxlinelen` = `   4096` (line 105)** **Data type:** `mixed`

**Remarks**

 Private variables 



**`$_mime_boundary` = `   ''` (line 111)** **Data type:** `mixed`

**`$_redirectaddr` = `   false` (line 112)** **Data type:** `mixed`

**`$_redirectdepth` = `   0` (line 113)** **Data type:** `mixed`

**`$_submit_method` = `   'POST'` (line 109)** **Data type:** `mixed`

**`$_submit_type` = `   'application/x-www-form-urlencoded'` (line 110)** **Data type:** `mixed`



---

## Class Constant Detail ##



---
