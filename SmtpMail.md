# Class SmtpMail #





Location: /utils/SmtpMail.class.php


---




---

## Class Variable Summary ##


---

## Class Constant Summary ##

  * `PRIORITY_HIGH` = ` '1'`

> Priority level
    * `PRIORITY_LOW` = ` '5'`

> Priority level
    * `PRIORITY_NORMAL` = ` '3'`

> Priority level


---

## Inherited Class Constant Summary ##



---

## Inherited Class Variable Summary ##



---

## Method Summary ##


## Inherited Method Summary ##


---

## Method Detail ##



# SmtpMail::construct #

**construct(**
**mixed**
_$to\_mail_, **mixed**
_$to\_name_, **mixed**
_$subject_, **mixed**
_$message_, [**string**
_$from\_mail_ = ''], [**string**
_$from\_name_ = '']**);**





**Parameters**
> _$to\_mail_
> _$to\_name_
> _$subject_
> _$message_
> _$from\_mail_
> _$from\_name_

**Remarks**

Constructor SmtpMail




# SmtpMail::addAddress #

**addAddress(**
**mixed**
_$to\_mail_, **mixed**
_$to\_name_**);**





**Parameters**
> _$to\_mail_
> _$to\_name_

**Remarks**

Method addAddress


**since:** 1.0.35

**access:** public



# SmtpMail::addAttachment #

**addAttachment(**
**mixed**
_$file\_path_, [**string**
_$file\_name_ = &quot;&quot;]**);**





**Parameters**
> _$file\_path_
> _$file\_name_

**Remarks**

Method addAttachment


**since:** 1.0.35

**access:** public



# SmtpMail::getErrorInfo #

**getErrorInfo(**
**);**





**Remarks**

Method getErrorInfo


**since:** 1.0.35

**access:** public



# SmtpMail::send #

**send(**
**);**





**Remarks**

Method send


**since:** 1.0.35

**access:** public



# SmtpMail::setPriority #

**setPriority(**
**mixed**
_$priority\_level_**);**





**Parameters**
> _$priority\_level_

**Remarks**

Method setPriority


**since:** 1.0.100

**access:** public




---


## Variable Detail ##


---

## Class Constant Detail ##

**`PRIORITY_HIGH` = ` '1'` (line 36)**


**Remarks**

Priority level


**access:** public


**`PRIORITY_LOW` = ` '5'` (line 34)**


**Remarks**

Priority level


**access:** public


**`PRIORITY_NORMAL` = ` '3'` (line 35)**


**Remarks**

Priority level


**access:** public




---
