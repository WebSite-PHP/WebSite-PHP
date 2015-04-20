# Class TreeViewFolder #

WebSitePhpObject
> |
> --TreeViewItem
> > |
> > --TreeViewFolder



Location: /display/advanced\_object/treeview/TreeViewFolder.class.php


---



**Remarks**

Class TreeViewItem


WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)  Copyright (c) 2009-2014 WebSite-PHP.com  PHP versions >= 5.2Licensed under The MIT License  Redistributions of files must retain the above copyright notice.


**author:** Emilien MOREL <>

**version:** 1.2.7

**copyright:** WebSite-PHP.com 17/01/2014



---

## Class Variable Summary ##


---

## Class Constant Summary ##



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

### Inherited From Class TreeViewItem ###

  * `TreeViewItem::__construct()`

> Constructor TreeViewItem
    * `TreeViewItem::addItem()`
> Method addItem
    * `TreeViewItem::collapse()`
> Method collapse
    * `TreeViewItem::expand()`
> Method expand
    * `TreeViewItem::getAjaxRender()`
> Method getAjaxRender
    * `TreeViewItem::getChildsTreeViewItemArray()`
> Method getChildsTreeViewItemArray
    * `TreeViewItem::getId()`
> Method getId
    * `TreeViewItem::getParentTreeViewItem()`
> Method getParentTreeViewItem
    * `TreeViewItem::getPath()`
> Method getPath
    * `TreeViewItem::getTreeViewItemsObject()`
> Method getTreeViewItemsObject
    * `TreeViewItem::getTreeViewObject()`
> Method getTreeViewObject
    * `TreeViewItem::getValue()`
> Method getValue
    * `TreeViewItem::isCollapse()`
> Method isCollapse
    * `TreeViewItem::isExpand()`
> Method isExpand
    * `TreeViewItem::nodeValueAlreadyExists()`
> Method nodeValueAlreadyExists
    * `TreeViewItem::removeItem()`
> Method removeItem
    * `TreeViewItem::render()`
> Method render
    * `TreeViewItem::setPath()`
> Method setPath
    * `TreeViewItem::setPrefixId()`
> Method setPrefixId
    * `TreeViewItem::setTreeViewItemParent()`
> Method setTreeViewItemParent
    * `TreeViewItem::setTreeViewItems()`
> Method setTreeViewItems
    * `TreeViewItem::setValue()`
> Method setValue
    * `TreeViewItem::tooltip()`
> Method tooltip

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



# TreeViewFolder::construct #

**construct(**
**string**
_$value_, **string**
_$path\_folder_**);**


Overrides TreeViewItem::construct() (Constructor TreeViewItem)



**Parameters**
> _$value_ folder node text
> _$path\_folder_ path to the folder

**Remarks**

Constructor TreeViewFolder




# TreeViewFolder::addFile #

**addFile(**
[**string**
_$value_ = &quot;New File&quot;], [**string**
_$data_ = ''], [**string**
_$link_ = ''], [**ContextMenu**
_$context\_menu\_object_ = null]**);**





**Parameters**
> _$value_ new file name [value: New File](default.md)
> _$data_ data to set in the file if TreeView synchronized with directory
> _$link_ node link
> _$context\_menu\_object_ [value: null](default.md)

**Remarks**

Method addFile


**since:** 1.0.35

**access:** public



# TreeViewFolder::addFolder #

**addFolder(**
[**string**
_$value_ = &quot;New Folder&quot;], [**ContextMenu**
_$context\_menu\_object_ = null], [**boolean**
_$collapse_ = true]**);**





**Parameters**
> _$value_ new folder node text [value: New Folder](default.md)
> _$context\_menu\_object_ [value: null](default.md)
> _$collapse_ [value: true](default.md)

**Remarks**

Method addFolder


**since:** 1.0.35

**access:** public



# TreeViewFolder::getLocalPath #

**getLocalPath(**
**);**





**Remarks**

Method getLocalPath


**since:** 1.0.35

**access:** public



# TreeViewFolder::remove #

**remove(**
**);**





**Remarks**

Method remove


**since:** 1.0.59

**access:** public



# TreeViewFolder::rename #

**rename(**
**string**
_$value_**);**





**Parameters**
> _$value_ new folder name (rename real folder if synchronized)

**Remarks**

Method rename


**since:** 1.0.59

**access:** public




---


## Variable Detail ##


---

## Class Constant Detail ##



---
