# Class AuthenticationLDAP #

WebSitePhpObject
> |
> --Authentication
> > |
> > --AuthenticationLDAP



Location: /modules/Authentication/AuthenticationLDAP.class.php


---



**Remarks**

Class AuthenticationLDAP


WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)  Copyright (c) 2009-2014 WebSite-PHP.com  PHP versions >= 5.2Licensed under The MIT License  Redistributions of files must retain the above copyright notice.


**author:** Emilien MOREL <>

**version:** 1.2.7

**copyright:** WebSite-PHP.com 17/01/2014

**link:**

**since:** 1.1.11

**access:** public



---

## Class Variable Summary ##


---

## Class Constant Summary ##



---

## Inherited Class Constant Summary ##

### Inherited From Class Authentication ###

  * `Authentication::STYLE_1_LINE` = ` 1`


> Authentication style
    * `Authentication::STYLE_1_LINE_NO_TEXT` = ` 2`

> Authentication style
    * `Authentication::STYLE_2_LINES` = ` 3`

> Authentication style
    * `Authentication::STYLE_2_LINES_NO_TEXT` = ` 4`

> Authentication style




---

## Inherited Class Variable Summary ##

### Inherited From Class Authentication ###

  * `Authentication::$authentication_msg` = ` true`


  * `Authentication::$color_error` = ` 'red'`


  * `Authentication::$color_ok` = ` '#00FF33'`




### Inherited From Class WebSitePhpObject ###

  * `WebSitePhpObject::$is_javascript_object` = ` false`


  * `WebSitePhpObject::$is_new_object_after_init` = ` false`


  * `WebSitePhpObject::$object_change` = ` false`


  * `WebSitePhpObject::$tag` = ` ''`






---

## Method Summary ##


## Inherited Method Summary ##

### Inherited From Class Authentication ###

  * `Authentication::__construct()`
> Constructor Authentication
    * `Authentication::addCustomField()`
> Method addCustomField
    * `Authentication::connect()`
> Method connect
    * `Authentication::disableAjaxEvent()`
> Method disableAjaxEvent
    * `Authentication::disableAjaxWaitMessage()`
> Method disableAjaxWaitMessage
    * `Authentication::disablePrefillLoginPassword()`
> Method disablePrefillLoginPassword
    * `Authentication::getForm()`
> Method getForm
    * `Authentication::getLogin()`
> Method getLogin
    * `Authentication::getPassword()`
> Method getPassword
    * `Authentication::getReferer()`
> Method getReferer
    * `Authentication::render()`
> Method render
    * `Authentication::setAjaxWaitMessage()`
> Method setAjaxWaitMessage
    * `Authentication::setAuthentificationMessage()`
> Method setAuthentificationMessage
    * `Authentication::setButtonClass()`
> Method setButtonClass
    * `Authentication::setButtonLabel()`
> Method setButtonLabel
    * `Authentication::setEncrypt()`
> Method setEncrypt
    * `Authentication::setInputWidth()`
> Method setInputWidth
    * `Authentication::setLoginLabel()`
> Method setLoginLabel
    * `Authentication::setLoginLiveValidation()`
> Method setLoginLiveValidation
    * `Authentication::setPasswordLabel()`
> Method setPasswordLabel
    * `Authentication::setPasswordLiveValidation()`
> Method setPasswordLiveValidation
    * `Authentication::setStyle()`
> Method setStyle
    * `Authentication::setTableStyle()`
> Method setTableStyle
    * `Authentication::setTableWidth()`
> Method setTableWidth
    * `Authentication::userIsAuthentificated()`
> Method userIsAuthentificated

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



# AuthenticationLDAP::construct #

**construct(**
**mixed**
_$page\_object_, **mixed**
_$connect\_method_, [**string**
_$ldap\_user\_domain_ = ''], [**string**
_$ldap\_dn_ = ''], [**string**
_$ldap\_host_ = 'localhost'], [**double**
_$ldap\_port_ = 389], [**mixed**
_$style_ = Authentication::STYLE\_2\_LINES], [**boolean**
_$encrypt_ = true], [**string**
_$button\_class_ = ''], [**string**
_$table\_style_ = '']**);**


Overrides Authentication::construct() (Constructor Authentication)



**Parameters**
> _$page\_object_
> _$connect\_method_
> _$ldap\_user\_domain_
> _$ldap\_dn_
> _$ldap\_host_ [value: localhost](default.md)
> _$ldap\_port_ [value: 389](default.md)
> _$style_ [value: Authentication::STYLE\_2\_LINES](default.md)
> _$encrypt_ [value: true](default.md)
> _$button\_class_
> _$table\_style_

**Remarks**

Constructor AuthenticationLDAP




# AuthenticationLDAP::connect #

**connect(**
[**boolean**
_$redirect_ = true], [**string**
_$redirect\_url_ = 'REFERER']**);**


Overrides Authentication::connect() (Method connect)



**Parameters**
> _$redirect_ [value: true](default.md)
> _$redirect\_url_ [value: REFERER](default.md)

**Remarks**

Method connect


**since:** 1.1.11

**access:** public



# AuthenticationLDAP::enableSubtreeSearch #

**enableSubtreeSearch(**
**);**





**Remarks**

Method enableSubtreeSearch


**since:** 1.2.3

**access:** public



# AuthenticationLDAP::getLDAPUserInfo #

**getLDAPUserInfo(**
**);**





**Remarks**

Method getLDAPUserInfo


**since:** 1.1.11

**access:** public



# AuthenticationLDAP::setDefaultUserRights #

**setDefaultUserRights(**
**mixed**
_$rights_**);**





**Parameters**
> _$rights_

**Remarks**

Method setDefaultUserRights


**since:** 1.1.11

**access:** public



# AuthenticationLDAP::setLDAPDN #

**setLDAPDN(**
**mixed**
_$ldap\_dn_**);**





**Parameters**
> _$ldap\_dn_

**Remarks**

Method setLDAPDN


**since:** 1.2.2

**access:** public



# AuthenticationLDAP::setLDAPHost #

**setLDAPHost(**
**mixed**
_$ldap\_host_, [**double**
_$ldap\_port_ = 389]**);**





**Parameters**
> _$ldap\_host_
> _$ldap\_port_ [value: 389](default.md)

**Remarks**

Method setLDAPHost


**since:** 1.1.11

**access:** public



# AuthenticationLDAP::setLDAPUserDomain #

**setLDAPUserDomain(**
**mixed**
_$ldap\_user\_domain_**);**





**Parameters**
> _$ldap\_user\_domain_

**Remarks**

Method setLDAPUserDomain


**since:** 1.1.11

**access:** public



# AuthenticationLDAP::setRightsMapping #

**setRightsMapping(**
[**string**
_$rights\_mapping_ = array(&quot;Administrator&quot; =&gt; Page::RIGHTS\_ADMINISTRATOR)]**);**





**Parameters**
> _$rights\_mapping_ [value: Administrator](default.md)

**Remarks**

Method setRightsMapping


**since:** 1.1.11

**access:** public




---


## Variable Detail ##


---

## Class Constant Detail ##



---
