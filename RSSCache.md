# Class RSSCache #





Location: /modules/RSS-Reader/rss\_cache.inc


---




---

## Class Variable Summary ##
  * `$BASE_CACHE` = ` './cache'`


  * `$ERROR` = ` ''`


  * `$MAX_AGE` = ` 3600`




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



# RSSCache::RSSCache #

**RSSCache(**
[
_$base_ = ''], [
_$age_ = '']**);**





**Parameters**
> _$base_
> _$age_


# RSSCache::cache\_age #

**cache\_age(**

_$cache\_key_**);**





**Parameters**
> _$cache\_key_


# RSSCache::check\_cache #

**check\_cache(**

_$url_**);**





**Parameters**
> _$url_


# RSSCache::debug #

**debug(**

_$debugmsg_, [
_$lvl_ = E\_USER\_NOTICE]**);**





**Parameters**
> _$debugmsg_
> _$lvl_


# RSSCache::error #

**error(**

_$errormsg_, [
_$lvl_ = E\_USER\_WARNING]**);**





**Parameters**
> _$errormsg_
> _$lvl_


# RSSCache::file\_name #

**file\_name(**

_$url_**);**





**Parameters**
> _$url_


# RSSCache::get #

**get(**

_$url_**);**





**Parameters**
> _$url_


# RSSCache::serialize #

**serialize(**

_$rss_**);**





**Parameters**
> _$rss_


# RSSCache::set #

**set(**

_$url_, 
_$rss_**);**





**Parameters**
> _$url_
> _$rss_


# RSSCache::unserialize #

**unserialize(**

_$data_**);**





**Parameters**
> _$data_



---


## Variable Detail ##
**`$BASE_CACHE` = ` './cache'` (line 25)** **Data type:** `mixed`

**`$ERROR` = ` ''` (line 27)** **Data type:** `mixed`

**`$MAX_AGE` = ` 3600` (line 26)** **Data type:** `mixed`



---

## Class Constant Detail ##



---
