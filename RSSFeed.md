# Class RSSFeed #

RSSFeedBase
> |
> --RSSFeed



Location: /modules/RSS-Generator/RSSFeed.class.php


---



**Remarks**




**author:** : Hugo 'Emacs' HAMON

**version:** : 1.0



---

## Class Variable Summary ##


---

## Class Constant Summary ##

  * `RSS_ENCODING_UTF8` = `'utf-8'`




---

## Inherited Class Constant Summary ##



---

## Inherited Class Variable Summary ##

### Inherited From Class RSSFeedBase ###

  * `RSSFeedBase::$_categories` = `array()`


  * `RSSFeedBase::$_description` = ` ''`


  * `RSSFeedBase::$_link` = ` ''`


  * `RSSFeedBase::$_pubDate` = ` ''`


  * `RSSFeedBase::$_title` = ` ''`






---

## Method Summary ##

  * `static : appendItem()`
  * 
    * `static : display()`
  * 
    * `static : regenerate()`
  * 
    * `static : render()`
  * 
    * `static : __construct()`
  * 
    * `static : __destruct()`
  * 
    * `static : save()`
  * 
    * `static : setCloud()`
  * 
    * `static : setCopyright()`
  * 
    * `static : setDocs()`
  * 
    * `static : setGenerator()`
  * 
    * `static : setImage()`
  * 
    * `static : setLanguage()`
  * 
    * `static : setLastBuildDate()`
  * 
    * `static : setManagingEditor()`
  * 
    * `static : setProtectString()`
  * 
    * `static : setRating()`
  * 
    * `static : setSkipDay()`
  * 
    * `static : setSkipHour()`
  * 
    * `static : setTimeToLive()`
  * 
    * `static : setTitle()`
  * 
    * `static : setWebMaster()`
  * 
    * `static : _getIndentationNumber()`
  * 
    * `: appendItem()`
  * 
    * `: display()`
  * 
    * `: regenerate()`
  * 
    * `: render()`
  * 
    * `: __construct()`
  * 
    * `: __destruct()`
  * 
    * `: save()`
  * 
    * `: setCloud()`
  * 
    * `: setCopyright()`
  * 
    * `: setDocs()`
  * 
    * `: setGenerator()`
  * 
    * `: setImage()`
  * 
    * `: setLanguage()`
  * 
    * `: setLastBuildDate()`
  * 
    * `: setManagingEditor()`
  * 
    * `: setProtectString()`
  * 
    * `: setRating()`
  * 
    * `: setSkipDay()`
  * 
    * `: setSkipHour()`
  * 
    * `: setTimeToLive()`
  * 
    * `: setTitle()`
  * 
    * `: setWebMaster()`
  * 
    * `: _getIndentationNumber()`
  * 

## Inherited Method Summary ##

### Inherited From Class RSSFeedBase ###

  * `RSSFeedBase::getCategories()`
  * 
    * `RSSFeedBase::getDescription()`
  * 
    * `RSSFeedBase::getLink()`
  * 
    * `RSSFeedBase::getPubDate()`
  * 
    * `RSSFeedBase::getTitle()`
  * 
    * `RSSFeedBase::setCategory()`
  * 
    * `RSSFeedBase::setDescription()`
  * 
    * `RSSFeedBase::setLink()`
  * 
    * `RSSFeedBase::setPubDate()`
  * 
    * `RSSFeedBase::setTitle()`
  * 


---

## Method Detail ##


# static RSSFeed::appendItem #

**static appendItem(**
**RSSFeedItem**
_$rssFeedItem_**);**





**Parameters**
> _$rssFeedItem_ RSSFeedItem $rssFeedItem

**Returns**
> void 

**Remarks**




**access:** public



# static RSSFeed::display #

**static display(**
**:**
_0_**);**





**Parameters**
> _0_ void

**Returns**
> void 

**Remarks**




**access:** public



# static RSSFeed::regenerate #

**static regenerate(**
**:**
_0_**);**





**Parameters**
> _0_ void

**Returns**
> void 

**Remarks**




**access:** public



# static RSSFeed::render #

**static render(**
**:**
_0_**);**





**Parameters**
> _0_ void

**Returns**
> void 

**Remarks**




**access:** public



# static RSSFeed::construct #

**static construct(**
**:**
_$encoding_**);**





**Parameters**
> _$encoding_ string $encoding

**Returns**
> void 

**Remarks**




**access:** public



# static RSSFeed::destruct #

**static destruct(**
**:**
_0_**);**





**Parameters**
> _0_ void

**Returns**
> void 

**Remarks**




**access:** public



# static RSSFeed::save #

**static save(**
[**:**
_$xmlFileName_ = '']**);**





**Parameters**
> _$xmlFileName_ string $fileName

**Returns**
> void 

**Remarks**




**access:** public



# static RSSFeed::setCloud #

**static setCloud(**
**:**
_$domain_, **:**
_$port_, **:**
_$path_, **:**
_$registerProcedure_, **:**
_$protocol_**);**





**Parameters**
> _$domain_ string $domain
> _$port_ int $port
> _$path_ string $path
> _$registerProcedure_ string $registerProcedure
> _$protocol_ string $protocol

**Returns**
> void 

**Remarks**




**access:** public



# static RSSFeed::setCopyright #

**static setCopyright(**
**:**
_$copyright_**);**





**Parameters**
> _$copyright_ string $copyright

**Returns**
> void 

**Remarks**




**access:** public



# static RSSFeed::setDocs #

**static setDocs(**
**:**
_$docs_**);**





**Parameters**
> _$docs_ string $docs

**Returns**
> void 

**Remarks**




**access:** public



# static RSSFeed::setGenerator #

**static setGenerator(**
**:**
_$generator_**);**





**Parameters**
> _$generator_ string $generator

**Returns**
> void 

**Remarks**




**access:** public



# static RSSFeed::setImage #

**static setImage(**
**:**
_$url_, **:**
_$title_, **:**
_$link_, [**:**
_$description_ = ''], [**:**
_$width_ = 0], [**:**
_$height_ = 0]**);**





**Parameters**
> _$url_ string $url
> _$title_ string $title
> _$link_ string $link
> _$description_ string $description
> _$width_ int $width
> _$height_ int $height

**Returns**
> void 

**Remarks**




**access:** public



# static RSSFeed::setLanguage #

**static setLanguage(**
**:**
_$language_**);**





**Parameters**
> _$language_ string $language

**Returns**
> void 

**Remarks**




**access:** public



# static RSSFeed::setLastBuildDate #

**static setLastBuildDate(**
**:**
_$lastBuildDate_**);**





**Parameters**
> _$lastBuildDate_ string $lastBuildDate

**Returns**
> void 

**Remarks**




**access:** public



# static RSSFeed::setManagingEditor #

**static setManagingEditor(**
**:**
_$email_, [**:**
_$name_ = '']**);**





**Parameters**
> _$email_ string $email
> _$name_ string $name

**Returns**
> void 

**Remarks**




**access:** public



# static RSSFeed::setProtectString #

**static setProtectString(**
**:**
_$protectString_**);**





**Parameters**
> _$protectString_ boolean $protectString

**Returns**
> void 

**Remarks**




**access:** public



# static RSSFeed::setRating #

**static setRating(**
**:**
_$rating_**);**





**Parameters**
> _$rating_ string $rating

**Returns**
> void 

**Remarks**




**access:** public



# static RSSFeed::setSkipDay #

**static setSkipDay(**
**:**
_$day_**);**





**Parameters**
> _$day_ int $day

**Returns**
> void 

**Remarks**




**access:** public



# static RSSFeed::setSkipHour #

**static setSkipHour(**
**:**
_$hour_**);**





**Parameters**
> _$hour_ int $hour

**Returns**
> void 

**Remarks**




**access:** public



# static RSSFeed::setTimeToLive #

**static setTimeToLive(**
**:**
_$timeToLive_**);**





**Parameters**
> _$timeToLive_ int $timeToLive

**Returns**
> void 

**Remarks**




**access:** public



# static RSSFeed::setTitle #

**static setTitle(**
**:**
_$title_**);**


Overrides RSSFeedBase::setTitle() ()



**Parameters**
> _$title_ string $title

**Returns**
> void 

**Remarks**




**access:** public



# static RSSFeed::setWebMaster #

**static setWebMaster(**
**:**
_$email_, [**:**
_$name_ = '']**);**





**Parameters**
> _$email_ string $email
> _$name_ string $name

**Returns**
> void 

**Remarks**




**access:** public



# static RSSFeed::_getIndentationNumber #_

_static **getIndentationNumber(**
**:**_$parentNode_**);**_





**Parameters**
> _$parentNode_ string $parentNode

**Returns**
> integer $indentationNumber 

**Remarks**




**access:** protected





---


## Variable Detail ##


---

## Class Constant Detail ##

**`RSS_ENCODING_UTF8` = `'utf-8'` (line 73)**




---
