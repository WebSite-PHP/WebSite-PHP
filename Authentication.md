# Class Authentication #

WebSitePhpObject
> |
> --Authentication


Classes extended from Authentication:
> AuthenticationLDAP
> > |
> > --Class AuthenticationLDAP



Location: /modules/Authentication/Authentication.class.php


---



**Remarks**

Class Authentication


WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)  Copyright (c) 2009-2014 WebSite-PHP.com  PHP versions >= 5.2Licensed under The MIT License  Redistributions of files must retain the above copyright notice.


**author:** Emilien MOREL <>

**version:** 1.2.7

**copyright:** WebSite-PHP.com 17/01/2014

**link:**

**since:** 1.0.84

**access:** public



---

## Class Variable Summary ##
  * `$authentication_msg` = ` true`


  * `$color_error` = ` 'red'`


  * `$color_ok` = ` '#00FF33'`




---

## Class Constant Summary ##

  * `STYLE_1_LINE` = ` 1`


> Authentication style
    * `STYLE_1_LINE_NO_TEXT` = ` 2`

> Authentication style
    * `STYLE_2_LINES` = ` 3`

> Authentication style
    * `STYLE_2_LINES_NO_TEXT` = ` 4`

> Authentication style


---

## Inherited Class Constant Summary ##



---

## Inherited Class Variable Summary ##

### Inherited From Class WebSitePhpObject ###

  * `WebSitePhpObject::$is_javascript_object` = ` false`


  * `WebSitePhpObject::$is_new_object_after_init` = ` false`


  * `WebSitePhpObject::$object_change` = ` false`


  * `WebSitePhpObject::$tag` = ` ''`






---

## Method Summary ##


## Inherited Method Summary ##

### Inherited From Class WebSitePhpObject ###

  * `WebSitePhpObject::__construct()`
> Constructor WebSitePhpObject
    * `WebSitePhpObject::addCss()`
> Method addCss
    * `WebSitePhpObject::addJavaScript()`
> Method addJavaScript
    * `WebSitePhpObject::displayJavascriptTag()`
> Method displayJavascriptTag
    * `WebSitePhpObject::forceAjaxRender()`

  * `WebSitePhpObject::getAjaxRender()`
> Method getAjaxRender
    * `WebSitePhpObject::getClass()`

  * `WebSitePhpObject::getCssArray()`
> Method getCssArray
    * `WebSitePhpObject::getJavaScriptArray()`
> Method getJavaScriptArray
    * `WebSitePhpObject::getJavascriptTagClose()`
> Method getJavascriptTagClose
    * `WebSitePhpObject::getJavascriptTagOpen()`
> Method getJavascriptTagOpen
    * `WebSitePhpObject::getName()`
> Method getName
    * `WebSitePhpObject::getPage()`
> Method getPage
    * `WebSitePhpObject::getRegisterObjects()`
> Method getRegisterObjects
    * `WebSitePhpObject::getTag()`
> Method getTag
    * `WebSitePhpObject::getType()`

  * `WebSitePhpObject::isEventObject()`
> Method isEventObject
    * `WebSitePhpObject::isJavascriptObject()`
> Method isJavascriptObject
    * `WebSitePhpObject::isObjectChange()`
> Method isObjectChange
    * `WebSitePhpObject::render()`
> Method render
    * `WebSitePhpObject::setTag()`
> Method setTag


---

## Method Detail ##



# Authentication::construct #

**construct(**
**Page**
_$page\_object_, **string**
_$connect\_method_, [**mixed**
_$style_ = Authentication::STYLE\_2\_LINES], [**boolean**
_$encrypt_ = true], [**string**
_$button\_class_ = ''], [**string**
_$table\_style_ = '']**);**


> Overridden in child classes as:
> > AuthenticationLDAP::construct()
> > > Constructor AuthenticationLDAP

> Overrides WebSitePhpObject::construct() (Constructor WebSitePhpObject)



**Parameters**
> _$page\_object_
> _$connect\_method_
> _$style_ [value: Authentication::STYLE\_2\_LINES](default.md)
> _$encrypt_ [value: true](default.md)
> _$button\_class_
> _$table\_style_

**Remarks**

Constructor Authentication




# Authentication::addCustomField #

**addCustomField(**
**mixed**
_$field\_obj_, [**string**
_$label_ = '']**);**





**Parameters**
> _$field\_obj_
> _$label_

**Remarks**

Method addCustomField


**since:** 1.2.2

**access:** public



# Authentication::connect #

**connect(**
[**boolean**
_$redirect_ = true], [**string**
_$redirect\_url_ = 'REFERER']**);**


> Overridden in child classes as:
> > AuthenticationLDAP::connect()
> > > Method connect



**Parameters**

> _$redirect_ [value: true](default.md)
> _$redirect\_url_ [value: REFERER](default.md)

**Remarks**

Method connect


**since:** 1.1.11

**access:** public



# Authentication::disableAjaxEvent #

**disableAjaxEvent(**
**);**





**Remarks**

Method disableAjaxEvent


**since:** 1.2.1

**access:** public



# Authentication::disableAjaxWaitMessage #

**disableAjaxWaitMessage(**
**);**





**Remarks**

Method disableAjaxWaitMessage


**since:** 1.2.1

**access:** public



# Authentication::disablePrefillLoginPassword #

**disablePrefillLoginPassword(**
**);**





**Remarks**

Method disablePrefillLoginPassword


**since:** 1.2.2

**access:** public



# Authentication::getForm #

**getForm(**
**);**





**Remarks**

Method getForm


**since:** 1.2.2

**access:** public



# Authentication::getLogin #

**getLogin(**
**);**





**Remarks**

Method getLogin


**since:** 1.0.84

**access:** public



# Authentication::getPassword #

**getPassword(**
**);**





**Remarks**

Method getPassword


**since:** 1.0.84

**access:** public



# Authentication::getReferer #

**getReferer(**
**);**





**Remarks**

Method getReferer


**since:** 1.0.100

**access:** public



# Authentication::render #

**render(**
[**boolean**
_$ajax\_render_ = false]**);**


Overrides WebSitePhpObject::render() (Method render)



**Parameters**
> _$ajax\_render_ [value: false](default.md)

**Remarks**

Method render


**since:** 1.0.84

**access:** public



# Authentication::setAjaxWaitMessage #

**setAjaxWaitMessage(**
**mixed**
_$message\_or\_object_**);**





**Parameters**
> _$message\_or\_object_

**Remarks**

Method setAjaxWaitMessage


**since:** 1.2.1

**access:** public



# Authentication::setAuthentificationMessage #

**setAuthentificationMessage(**
[**boolean**
_$display\_msg_ = true], [**string**
_$color\_ok_ = 'green'], [**string**
_$color\_error_ = 'red']**);**





**Parameters**
> _$display\_msg_ [value: true](default.md)
> _$color\_ok_ [value: green](default.md)
> _$color\_error_ [value: red](default.md)

**Remarks**

Method setAuthentificationMessage


**since:** 1.0.84

**access:** public



# Authentication::setButtonClass #

**setButtonClass(**
**mixed**
_$button\_class_**);**





**Parameters**
> _$button\_class_

**Remarks**

Method setButtonClass


**since:** 1.1.11

**access:** public



# Authentication::setButtonLabel #

**setButtonLabel(**
**mixed**
_$label_**);**





**Parameters**
> _$label_

**Remarks**

Method setButtonLabel


**since:** 1.2.2

**access:** public



# Authentication::setEncrypt #

**setEncrypt(**
[**boolean**
_$encrypt_ = true]**);**





**Parameters**
> _$encrypt_ [value: true](default.md)

**Remarks**

Method setEncrypt


**since:** 1.1.11

**access:** public



# Authentication::setInputWidth #

**setInputWidth(**
**integer**
_$width_**);**





**Parameters**
> _$width_

**Remarks**

Method setInputWidth


**since:** 1.2.0

**access:** public



# Authentication::setLoginLabel #

**setLoginLabel(**
**mixed**
_$label_**);**





**Parameters**
> _$label_

**Remarks**

Method setLoginLabel


**since:** 1.2.2

**access:** public



# Authentication::setLoginLiveValidation #

**setLoginLiveValidation(**
**mixed**
_$live\_validation\_object_**);**





**Parameters**
> _$live\_validation\_object_

**Remarks**

Method setLoginLiveValidation


**since:** 1.2.2

**access:** public



# Authentication::setPasswordLabel #

**setPasswordLabel(**
**mixed**
_$label_**);**





**Parameters**
> _$label_

**Remarks**

Method setPasswordLabel


**since:** 1.2.2

**access:** public



# Authentication::setPasswordLiveValidation #

**setPasswordLiveValidation(**
**mixed**
_$live\_validation\_object_**);**





**Parameters**
> _$live\_validation\_object_

**Remarks**

Method setPasswordLiveValidation


**since:** 1.2.2

**access:** public



# Authentication::setStyle #

**setStyle(**
[**mixed**
_$style_ = Authentication::STYLE\_2\_LINES]**);**





**Parameters**
> _$style_ [value: Authentication::STYLE\_2\_LINES](default.md)

**Remarks**

Method setStyle


**since:** 1.1.11

**access:** public



# Authentication::setTableStyle #

**setTableStyle(**
**mixed**
_$table\_style_**);**





**Parameters**
> _$table\_style_

**Remarks**

Method setTableStyle


**since:** 1.1.11

**access:** public



# Authentication::setTableWidth #

**setTableWidth(**
**integer**
_$width_**);**





**Parameters**
> _$width_

**Remarks**

Method setTableWidth


**since:** 1.2.0

**access:** public



# Authentication::userIsAuthentificated #

**userIsAuthentificated(**
**mixed**
_$strUserRights_, **mixed**
_$redirect_, **mixed**
_$redirect\_url_**);**





**Parameters**
> _$strUserRights_
> _$redirect_
> _$redirect\_url_

**Remarks**

Method userIsAuthentificated


**since:** 1.1.11

**access:** protected




---


## Variable Detail ##
**`$authentication_msg` = ` true` (line 51)** **Data type:** `mixed`
**access:** protected


**`$color_error` = ` 'red'` (line 53)** **Data type:** `mixed`
**access:** protected


**`$color_ok` = ` '#00FF33'` (line 52)** **Data type:** `mixed`
**access:** protected




---

## Class Constant Detail ##

**`STYLE_1_LINE` = ` 1` (line 33)**


**Remarks**

Authentication style


**access:** public


**`STYLE_1_LINE_NO_TEXT` = ` 2` (line 34)**


**Remarks**

Authentication style


**access:** public


**`STYLE_2_LINES` = ` 3` (line 35)**


**Remarks**

Authentication style


**access:** public


**`STYLE_2_LINES_NO_TEXT` = ` 4` (line 36)**


**Remarks**

Authentication style


**access:** public




---
