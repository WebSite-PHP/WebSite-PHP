# Class NewException #

Exception
> |
> --NewException



Location: /NewException.class.php


---




---

## Class Variable Summary ##


---

## Class Constant Summary ##



---

## Inherited Class Constant Summary ##



---

## Inherited Class Variable Summary ##

### Inherited From Class Exception (Internal Class) ###

  * `$code` = ``


  * `$file` = ``


  * `$line` = ``


  * `$message` = ``


  * `$previous` = ``


  * `$string` = ``


  * `$trace` = ``






---

## Method Summary ##

  * `static string generateErrorMessage()`
> Method generateErrorMessage
    * `static void getStaticException()`
> Method getStaticException
    * `static void printStaticDebugMessage()`
> Method printStaticDebugMessage
    * `static void printStaticException()`
> Method printStaticException
    * `static mixed redirectOnError()`
> Method redirectOnError
    * `static void sendErrorByMail()`
> Method sendErrorByMail
    * `string generateErrorMessage()`
> Method generateErrorMessage
    * `void getStaticException()`
> Method getStaticException
    * `void printStaticDebugMessage()`
> Method printStaticDebugMessage
    * `void printStaticException()`
> Method printStaticException
    * `mixed redirectOnError()`
> Method redirectOnError
    * `void sendErrorByMail()`
> Method sendErrorByMail

## Inherited Method Summary ##

### Inherited From Class Exception (Internal Class) ###

  * `constructor __construct ( [$message = ], [$code = ], [$previous = ] )`

  * `getCode (  )`

  * `getFile (  )`

  * `getLine (  )`

  * `getMessage (  )`

  * `getPrevious (  )`

  * `getTrace (  )`

  * `getTraceAsString (  )`

  * `__clone (  )`

  * `__toString (  )`



---

## Method Detail ##


# static NewException::generateErrorMessage #

**static generateErrorMessage(**
**string**
_$code_, **string**
_$message_, **string**
_$file_, **string**
_$line_, [**string**
_$class\_name_ = ''], [**string**
_$method_ = ''], [**string**
_$trace_ = '']**);**





**Parameters**
> _$code_
> _$message_
> _$file_
> _$line_
> _$class\_name_
> _$method_
> _$trace_

**Remarks**

Method generateErrorMessage


**since:** 1.0.35

**access:** public



# static NewException::getStaticException #

**static getStaticException(**
**string|Exception**
_$exception_**);**





**Parameters**
> _$exception_

**Remarks**

Method getStaticException


**since:** 1.0.59

**access:** public



# static NewException::printStaticDebugMessage #

**static printStaticDebugMessage(**
**string|object**
_$debug\_msg_**);**





**Parameters**
> _$debug\_msg_

**Remarks**

Method printStaticDebugMessage


**since:** 1.0.59

**access:** public



# static NewException::printStaticException #

**static printStaticException(**
**string|Exception**
_$exception_**);**





**Parameters**
> _$exception_

**Remarks**

Method printStaticException


**since:** 1.0.59

**access:** public



# static NewException::redirectOnError #

**static redirectOnError(**
**string**
_$buffer_**);**





**Parameters**
> _$buffer_

**Remarks**

Method redirectOnError


**since:** 1.0.35

**access:** public



# static NewException::sendErrorByMail #

**static sendErrorByMail(**
**mixed**
_$debug\_msg_, [**string**
_$attachment\_file_ = &quot;&quot;], [**string**
_$error\_log\_file_ = &quot;error\_send\_by\_mail.log&quot;], [**mixed**
_$cache\_time_ = CacheFile::CACHE\_TIME\_2MIN]**);**





**Parameters**
> _$debug\_msg_
> _$attachment\_file_
> _$error\_log\_file_ [value: error\_send\_by\_mail.log](default.md)
> _$cache\_time_ [value: CacheFile::CACHE\_TIME\_2MIN](default.md)

**Remarks**

Method sendErrorByMail


**since:** 1.0.100

**access:** public




# NewException::construct #

**construct(**
**string**
_$message_, [**mixed**
_$code_ = NULL], [**string**
_$trace_ = '']**);**


Overrides Exception::constructor construct ( [$message = ], [$code = ], [$previous = ] ) (parent method not documented)



**Parameters**
> _$message_
> _$code_ [value: NULL](default.md)
> _$trace_

**Remarks**

Constructor NewException


**access:** public



# NewException::getException #

**getException(**
**);**





**Remarks**

Method getException


**since:** 1.0.35

**access:** public



# NewException::toString #

**toString(**
**);**


Overrides Exception::toString (  ) (parent method not documented)



**Remarks**

Method toString


**since:** 1.0.35

**access:** public




---


## Variable Detail ##


---

## Class Constant Detail ##



---
