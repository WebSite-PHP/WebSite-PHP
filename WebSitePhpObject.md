# Class WebSitePhpObject #




Classes extended from WebSitePhpObject:
> WebSitePhpEventObject
> > |
> > --Abstract Class WebSitePhpObject

> Accordion
> > |
> > --Class Accordion

> AutoComplete
> > |
> > --Class AutoComplete

> AutoCompleteResult
> > |
> > --Class AutoCompleteResult

> Box
> > |
> > --Class Box

> DraggableEvent
> > |
> > --Class DraggableEvent

> ToolTip
> > |
> > --Class ToolTip

> Adsense
> > |
> > --Class Adsense

> Language
> > |
> > --Class Language

> LanguageBox
> > |
> > --Class LanguageBox

> LanguageComboBox
> > |
> > --Class LanguageComboBox

> LiveValidation
> > |
> > --Class LiveValidation

> MapLeafLet
> > |
> > --Class MapLeafLet

> ContextMenu
> > |
> > --Class ContextMenu

> DockMenu
> > |
> > --Class DockMenu

> DockMenuItem
> > |
> > --Class DockMenuItem

> Menu
> > |
> > --Class Menu

> MenuItem
> > |
> > --Class MenuItem

> MenuItems
> > |
> > --Class MenuItems

> RoundBox
> > |
> > --Class RoundBox

> Slider
> > |
> > --Class Slider

> SwfObject
> > |
> > --Class SwfObject

> TreeView
> > |
> > --Class TreeView

> TreeViewItem
> > |
> > --Class TreeViewItem

> TreeViewItems
> > |
> > --Class TreeViewItems

> Anchor
> > |
> > --Class Anchor

> Captcha
> > |
> > --Class Captcha

> DefinedZone
> > |
> > --Class DefinedZone

> DialogBox
> > |
> > --Class DialogBox

> Font
> > |
> > --Class Font

> Form
> > |
> > --Class Form

> JavaScript
> > |
> > --Class JavaScript

> Label
> > |
> > --Class Label

> Link
> > |
> > --Class Link

> LinkPage
> > |
> > --Class LinkPage

> ListItem
> > |
> > --Class ListItem

> PictureMap
> > |
> > --Class PictureMap

> RowTable
> > |
> > --Class RowTable

> Table
> > |
> > --Class Table

> Tabs
> > |
> > --Class Tabs

> Url
> > |
> > --Class Url

> Authentication
> > |
> > --Class Authentication

> ContactForm
> > |
> > --Class ContactForm

> DownloadButton
> > |
> > --Class DownloadButton

> FacebookActivityFeed
> > |
> > --Class FacebookActivityFeed

> FacebookComments
> > |
> > --Class FacebookComments

> FacebookRecommendations
> > |
> > --Class FacebookRecommendations

> GoogleSearchBar
> > |
> > --Class GoogleSearchBar

> GoogleSearchResult
> > |
> > --Class GoogleSearchResult

> Chart
> > |
> > --Class Chart

> PhotoGallery
> > |
> > --Class PhotoGallery

> FacebookLikeButton
> > |
> > --Class FacebookLikeButton

> GoogleLikeButton
> > |
> > --Class GoogleLikeButton

> ShareButton
> > |
> > --Class ShareButton

> ImageRotator
> > |
> > --Class ImageRotator

> NivoSlider
> > |
> > --Class NivoSlider

> VideoFlv
> > |
> > --Class VideoFlv

> VideoHTML5
> > |
> > --Class VideoHTML5



Location: /abstract/WebSitePhpObject.class.php


---



**Remarks**

Abstract Class WebSitePhpObject


WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)  Copyright (c) 2009-2014 WebSite-PHP.com  PHP versions >= 5.2Licensed under The MIT License  Redistributions of files must retain the above copyright notice.


**author:** Emilien MOREL <>

**version:** 1.2.9

**copyright:** WebSite-PHP.com 17/01/2014

**link:**

**abstract:**

**since:** 1.0.17

**access:** public



---

## Class Variable Summary ##
  * `$is_javascript_object` = ` false`


  * `$is_new_object_after_init` = ` false`


  * `$object_change` = ` false`


  * `$tag` = ` ''`




---

## Class Constant Summary ##



---

## Inherited Class Constant Summary ##



---

## Inherited Class Variable Summary ##



---

## Method Summary ##

  * `static mixed getJavascriptTagClose()`

> Method getJavascriptTagClose
    * `static mixed getJavascriptTagOpen()`
> Method getJavascriptTagOpen
    * `static mixed getRegisterObjects()`
> Method getRegisterObjects
    * `mixed getJavascriptTagClose()`
> Method getJavascriptTagClose
    * `mixed getJavascriptTagOpen()`
> Method getJavascriptTagOpen
    * `mixed getRegisterObjects()`
> Method getRegisterObjects

## Inherited Method Summary ##


---

## Method Detail ##


# static WebSitePhpObject::getJavascriptTagClose #

**static getJavascriptTagClose(**
**);**





**Remarks**

Method getJavascriptTagClose


**since:** 1.0.35

**access:** public



# static WebSitePhpObject::getJavascriptTagOpen #

**static getJavascriptTagOpen(**
**);**





**Remarks**

Method getJavascriptTagOpen


**since:** 1.0.35

**access:** public



# static WebSitePhpObject::getRegisterObjects #

**static getRegisterObjects(**
**);**





**Remarks**

Method getRegisterObjects


**since:** 1.0.35

**access:** public




# WebSitePhpObject::construct #

**construct(**
**);**


> Overridden in child classes as:
> > WebSitePhpEventObject::construct()
> > > Constructor WebSitePhpEventObject

> > AutoCompleteEvent::construct()
> > > Constructor AutoCompleteEvent

> > ContextMenuEvent::construct()
> > > Constructor ContextMenuEvent

> > DroppableEvent::construct()
> > > Constructor DroppableEvent

> > SortableEvent::construct()
> > > Constructor SortableEvent

> > Button::construct()
> > > Constructor Button

> > CheckBox::construct()
> > > Constructor CheckBox

> > ComboBox::construct()
> > > Constructor ComboBox

> > Editor::construct()
> > > Constructor Editor

> > Hidden::construct()
> > > Constructor Hidden

> > Object::construct()
> > > Constructor Object

> > Picture::construct()
> > > Constructor Picture

> > RadioButtonGroup::construct()
> > > Constructor RadioButtonGroup

> > TextArea::construct()
> > > Constructor TextArea

> > TextBox::construct()
> > > Constructor TextBox

> > ColorPicker::construct()
> > > Constructor ColorPicker

> > Calendar::construct()
> > > Constructor Calendar

> > Password::construct()
> > > Constructor Password

> > UploadFile::construct()
> > > Constructor UploadFile

> > Raty::construct()
> > > Constructor Raty

> > Accordion::construct()
> > > Constructor Accordion

> > AutoComplete::construct()
> > > Constructor AutoComplete

> > AutoCompleteResult::construct()
> > > Constructor AutoCompleteResult

> > Box::construct()
> > > Constructor Box

> > DraggableEvent::construct()
> > > Constructor DraggableEvent

> > ToolTip::construct()
> > > Constructor ToolTip

> > Adsense::construct()
> > > Constructor Adsense

> > Language::construct()
> > > Constructor Language

> > LanguageBox::construct()
> > > Constructor LanguageBox

> > LanguageComboBox::construct()
> > > Constructor LanguageComboBox

> > LiveValidation::construct()
> > > Constructor LiveValidation

> > MapLeafLet::construct()
> > > Constructor MapLeafLet

> > ContextMenu::construct()
> > > Constructor ContextMenu

> > DockMenu::construct()
> > > Constructor DockMenu

> > DockMenuItem::construct()
> > > Constructor DockMenuItem

> > Menu::construct()
> > > Constructor Menu

> > MenuItem::construct()
> > > Constructor MenuItem

> > MenuItems::construct()
> > > Constructor MenuItems

> > RoundBox::construct()
> > > Constructor RoundBox

> > Slider::construct()
> > > Constructor Slider

> > SwfObject::construct()
> > > Constructor SwfObject

> > TreeView::construct()
> > > Constructor TreeView

> > TreeViewItem::construct()
> > > Constructor TreeViewItem

> > TreeViewFile::construct()
> > > Constructor TreeViewFile

> > TreeViewFolder::construct()
> > > Constructor TreeViewFolder

> > TreeViewItems::construct()
> > > Constructor TreeViewItems

> > Anchor::construct()
> > > Constructor Anchor

> > Captcha::construct()
> > > Constructor Captcha

> > DefinedZone::construct()
> > > Constructor DefinedZone

> > DialogBox::construct()
> > > Constructor DialogBox

> > Font::construct()
> > > Constructor Font

> > Form::construct()
> > > Constructor Form

> > JavaScript::construct()
> > > Constructor JavaScript

> > IOSNotifications::construct()
> > > Constructor IOSNotifications

> > Logger::construct()
> > > Constructor Logger

> > Label::construct()
> > > Constructor Label

> > Link::construct()
> > > Constructor Link

> > LinkPage::construct()
> > > Constructor LinkPage

> > ListItem::construct()
> > > Constructor ListItem

> > PictureMap::construct()
> > > Constructor PictureMap

> > RowTable::construct()
> > > Constructor RowTable

> > Table::construct()
> > > Constructor Table

> > Tabs::construct()
> > > Constructor Tabs

> > Url::construct()
> > > Constructor Url

> > Authentication::construct()
> > > Constructor Authentication

> > AuthenticationLDAP::construct()
> > > Constructor AuthenticationLDAP

> > ContactForm::construct()
> > > Constructor ContactForm

> > DownloadButton::construct()
> > > Constructor DownloadButton

> > FacebookActivityFeed::construct()
> > > Constructor FacebookActivityFeed

> > FacebookComments::construct()
> > > Constructor FacebookComments

> > FacebookRecommendations::construct()
> > > Constructor FacebookRecommendations

> > GoogleSearchBar::construct()
> > > Constructor GoogleSearchBar

> > GoogleSearchResult::construct()
> > > Constructor GoogleSearchResult

> > Chart::construct()
> > > Constructor Chart

> > PhotoGallery::construct()
> > > Constructor PhotoGallery

> > FacebookLikeButton::construct()
> > > Constructor FacebookLikeButton

> > GoogleLikeButton::construct()
> > > Constructor GoogleLikeButton

> > ShareButton::construct()
> > > Constructor ShareButton

> > ImageRotator::construct()
> > > Constructor ImageRotator

> > NivoSlider::construct()
> > > Constructor NivoSlider

> > VideoFlv::construct()
> > > Constructor VideoFlv

> > VideoHTML5::construct()
> > > Constructor VideoHTML5



**Remarks**

Constructor WebSitePhpObject




# WebSitePhpObject::addCss #

**addCss(**
**mixed**
_$css\_url_, [**string**
_$conditional\_comment_ = ''], [**boolean**
_$conbine_ = false]**);**





**Parameters**

> _$css\_url_
> _$conditional\_comment_
> _$conbine_ [value: false](default.md)

**Remarks**

Method addCss


**since:** 1.0.59

**access:** protected



# WebSitePhpObject::addJavaScript #

**addJavaScript(**
**mixed**
_$js\_url_, [**string**
_$conditional\_comment_ = ''], [**boolean**
_$conbine_ = false]**);**





**Parameters**
> _$js\_url_
> _$conditional\_comment_
> _$conbine_ [value: false](default.md)

**Remarks**

Method addJavaScript


**since:** 1.0.59

**access:** protected



# WebSitePhpObject::displayJavascriptTag #

**displayJavascriptTag(**
**);**





**Remarks**

Method displayJavascriptTag


**since:** 1.0.35

**access:** public



# WebSitePhpObject::forceAjaxRender #

**forceAjaxRender(**
**);**




  * ccess:**public**



# WebSitePhpObject::getAjaxRender #

**getAjaxRender(**
**);**


> Overridden in child classes as:
> > SortableEvent::getAjaxRender()
> > > Method getAjaxRender

> > Button::getAjaxRender()
> > > Method getAjaxRender

> > CheckBox::getAjaxRender()
> > > Method getAjaxRender

> > ComboBox::getAjaxRender()
> > > Method getAjaxRender

> > Editor::getAjaxRender()
> > > Method getAjaxRender

> > Hidden::getAjaxRender()
> > > Method getAjaxRender

> > Object::getAjaxRender()
> > > Method getAjaxRender

> > Picture::getAjaxRender()
> > > Method getAjaxRender

> > RadioButtonGroup::getAjaxRender()
> > > Method getAjaxRender

> > TextArea::getAjaxRender()
> > > Method getAjaxRender

> > TextBox::getAjaxRender()
> > > Method getAjaxRender

> > Box::getAjaxRender()
> > > Method getAjaxRender

> > RoundBox::getAjaxRender()
> > > Method getAjaxRender

> > TreeView::getAjaxRender()
> > > Method getAjaxRender

> > TreeViewItem::getAjaxRender()
> > > Method getAjaxRender

> > TreeViewItems::getAjaxRender()
> > > Method getAjaxRender

> > Captcha::getAjaxRender()
> > > Method getAjaxRender

> > DialogBox::getAjaxRender()
> > > Method getAjaxRender

> > Font::getAjaxRender()
> > > Method getAjaxRender

> > JavaScript::getAjaxRender()
> > > Method getAjaxRender

> > Label::getAjaxRender()
> > > Method getAjaxRender

> > Link::getAjaxRender()
> > > Method getAjaxRender

> > RowTable::getAjaxRender()
> > > Method getAjaxRender

> > Table::getAjaxRender()
> > > Method getAjaxRender

> > Tabs::getAjaxRender()
> > > Method getAjaxRender



**Returns**

> javascript code to update initial html with ajax call

**Remarks**

Method getAjaxRender


**since:** 1.0.35

**access:** public



# WebSitePhpObject::getClass #

**getClass(**
**);**


> Overridden in child classes as:
> > TextArea::getClass()
> > > Method getClass

> > TextBox::getClass()
> > > Method getClass

> > RowTable::getClass()
> > > Method getClass


  * ccess:**public**



# WebSitePhpObject::getCssArray #

**getCssArray(**
**);**





**Remarks**

Method getCssArray


**since:** 1.0.35

**access:** public



# WebSitePhpObject::getJavaScriptArray #

**getJavaScriptArray(**
**);**





**Remarks**

Method getJavaScriptArray


**since:** 1.0.35

**access:** public



# WebSitePhpObject::getName #

**getName(**
**);**



> Overridden in child classes as:
> > WebSitePhpEventObject::getName()
> > > Method getName

> > DroppableEvent::getName()
> > > Method getName

> > SortableEvent::getName()
> > > Method getName

> > CheckBox::getName()
> > > Method getName

> > Editor::getName()
> > > Method getName

> > Hidden::getName()
> > > Method getName

> > RadioButtonGroup::getName()
> > > Method getName

> > UploadFile::getName()
> > > Method getName

> > Captcha::getName()
> > > Method getName

> > Form::getName()
> > > Method getName



**Remarks**

Method getName


**since:** 1.0.35

**access:** public



# WebSitePhpObject::getPage #

**getPage(**
**);**



> Overridden in child classes as:
> > DefinedZone::getPage()
> > > Method getPage



**Remarks**

Method getPage


**since:** 1.0.92

**access:** public



# WebSitePhpObject::getTag #

**getTag(**
**);**





**Remarks**

Method getTag


**since:** 1.0.35

**access:** public



# WebSitePhpObject::getType #

**getType(**
**);**




  * ccess:**public**



# WebSitePhpObject::isEventObject #

**isEventObject(**
**);**



> Overridden in child classes as:
> > WebSitePhpEventObject::isEventObject()
> > > Method isEventObject



**Remarks**

Method isEventObject


**since:** 1.0.35

**access:** public



# WebSitePhpObject::isJavascriptObject #

**isJavascriptObject(**
**);**





**Remarks**

Method isJavascriptObject


**since:** 1.0.35

**access:** public



# WebSitePhpObject::isObjectChange #

**isObjectChange(**
**);**





**Remarks**

Method isObjectChange


**since:** 1.0.35

**access:** public



# WebSitePhpObject::render #

**render(**
[**boolean**
_$ajax\_render_ = false]**);**



> Overridden in child classes as:
> > AutoCompleteEvent::render()
> > > Method render

> > ContextMenuEvent::render()
> > > Method render

> > DroppableEvent::render()
> > > Method render

> > SortableEvent::render()
> > > Method render

> > Button::render()
> > > Method render

> > CheckBox::render()
> > > Method render

> > ComboBox::render()
> > > Method render

> > Editor::render()
> > > Method render

> > Hidden::render()
> > > Method render

> > Object::render()
> > > Method render

> > Picture::render()
> > > Method render

> > RadioButtonGroup::render()
> > > Method render

> > TextArea::render()
> > > Method render

> > TextBox::render()
> > > Method render

> > Calendar::render()
> > > Method render

> > UploadFile::render()
> > > Method render

> > Raty::render()
> > > Method render

> > Accordion::render()
> > > Method render

> > AutoComplete::render()
> > > Method render

> > AutoCompleteResult::render()
> > > Method render

> > Box::render()
> > > Method render

> > DraggableEvent::render()
> > > Method render

> > ToolTip::render()
> > > Method render

> > Adsense::render()
> > > Method render

> > Language::render()
> > > Method render

> > LanguageBox::render()
> > > Method render

> > LanguageComboBox::render()
> > > Method render

> > LiveValidation::render()
> > > Method render

> > MapLeafLet::render()
> > > Method render

> > ContextMenu::render()
> > > Method render

> > DockMenu::render()
> > > Method render

> > DockMenuItem::render()
> > > Method render

> > Menu::render()
> > > Method render

> > MenuItem::render()
> > > Method render

> > MenuItems::render()
> > > Method render

> > RoundBox::render()
> > > Method render

> > Slider::render()
> > > Method render

> > SwfObject::render()
> > > Method render

> > TreeView::render()
> > > Method render

> > TreeViewItem::render()
> > > Method render

> > TreeViewItems::render()
> > > Method render

> > Anchor::render()
> > > Method render

> > Captcha::render()
> > > Method render

> > DefinedZone::render()
> > > Method render

> > DialogBox::render()
> > > Method render

> > Font::render()
> > > Method render

> > Form::render()
> > > Method render

> > JavaScript::render()
> > > Method render

> > Label::render()
> > > Method render

> > Link::render()
> > > Method render

> > LinkPage::render()
> > > Method render

> > ListItem::render()
> > > Method render

> > PictureMap::render()
> > > Method render

> > RowTable::render()
> > > Method render

> > Table::render()
> > > Method render

> > Tabs::render()
> > > Method render

> > Url::render()
> > > Method render

> > Authentication::render()
> > > Method render

> > ContactForm::render()
> > > Method render

> > DownloadButton::render()
> > > Method render

> > FacebookActivityFeed::render()
> > > Method render

> > FacebookComments::render()
> > > Method render

> > FacebookRecommendations::render()
> > > Method render

> > GoogleSearchBar::render()
> > > Method render

> > GoogleSearchResult::render()
> > > Method render

> > Chart::render()
> > > Method render

> > PhotoGallery::render()
> > > Method render

> > FacebookLikeButton::render()
> > > Method render

> > GoogleLikeButton::render()
> > > Method render

> > ShareButton::render()
> > > Method render

> > ImageRotator::render()
> > > Method render

> > NivoSlider::render()
> > > Method render

> > VideoFlv::render()
> > > Method render

> > VideoHTML5::render()
> > > Method render



**Parameters**

> _$ajax\_render_ [value: false](default.md)

**Returns**
> html code from object

**Remarks**

Method render


**since:** 1.0.35

**access:** public



# WebSitePhpObject::setTag #

**setTag(**
**mixed**
_$value_**);**





**Parameters**
> _$value_

**Remarks**

Method setTag


**since:** 1.0.35

**access:** public




---


## Variable Detail ##
**`$is_javascript_object` = ` false` (line 30)** **Data type:** `mixed`
**access:** protected


**`$is_new_object_after_init` = ` false` (line 31)** **Data type:** `mixed`
**access:** protected


**`$object_change` = ` false` (line 29)** **Data type:** `mixed`
**access:** protected


**`$tag` = ` ''` (line 32)** **Data type:** `mixed`
**access:** protected




---

## Class Constant Detail ##



---
