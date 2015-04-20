# Class FPDF #




Classes extended from FPDF:

> |
> --



Location: /modules/PDF/fpdf.php


---




---

## Class Variable Summary ##
  * `$AliasNbPages` = ``


  * `$author` = ``


  * `$AutoPageBreak` = ``


  * `$bMargin` = ``


  * `$buffer` = ``


  * `$cMargin` = ``


  * `$ColorFlag` = ``


  * `$compress` = ``


  * `$CoreFonts` = ``


  * `$creator` = ``


  * `$CurOrientation` = ``


  * `$CurPageFormat` = ``


  * `$CurrentFont` = ``


  * `$DefOrientation` = ``


  * `$DefPageFormat` = ``


  * `$diffs` = ``


  * `$DrawColor` = ``


  * `$FillColor` = ``


  * `$FontFamily` = ``


  * `$FontFiles` = ``


  * `$fonts` = ``


  * `$FontSize` = ``


  * `$FontSizePt` = ``


  * `$FontStyle` = ``


  * `$h` = ``


  * `$hPt` = ``


  * `$images` = ``


  * `$InFooter` = ``


  * `$InHeader` = ``


  * `$k` = ``


  * `$keywords` = ``


  * `$lasth` = ``


  * `$LayoutMode` = ``


  * `$LineWidth` = ``


  * `$links` = ``


  * `$lMargin` = ``


  * `$n` = ``


  * `$offsets` = ``


  * `$page` = ``


  * `$PageBreakTrigger` = ``


  * `$PageFormats` = ``


  * `$PageLinks` = ``


  * `$pages` = ``


  * `$PageSizes` = ``


  * `$PDFVersion` = ``


  * `$rMargin` = ``


  * `$state` = ``


  * `$subject` = ``


  * `$TextColor` = ``


  * `$title` = ``


  * `$tMargin` = ``


  * `$underline` = ``


  * `$w` = ``


  * `$wPt` = ``


  * `$ws` = ``


  * `$x` = ``


  * `$y` = ``


  * `$ZoomMode` = ``




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



# FPDF::FPDF #

**FPDF(**
[**string**
_$orientation_ = 'P'], [**string**
_$unit_ = 'mm'], [**string**
_$format_ = 'A4']**);**





**Parameters**
> _$orientation_ [value: P](default.md)
> _$unit_ [value: mm](default.md)
> _$format_ [value: A4](default.md)

**Remarks**

Method FPDF


**since:** 1.1.2



# FPDF::AcceptPageBreak #

**AcceptPageBreak(**
**);**






# FPDF::AddFont #

**AddFont(**

_$family_, [
_$style_ = ''], [
_$file_ = '']**);**





**Parameters**
> _$family_
> _$style_
> _$file_


# FPDF::AddLink #

**AddLink(**
**);**






# FPDF::AddPage #

**AddPage(**
[
_$orientation_ = ''], [
_$format_ = '']**);**





**Parameters**
> _$orientation_
> _$format_


# FPDF::AliasNbPages #

**AliasNbPages(**
[
_$alias_ = '{nb}']**);**





**Parameters**
> _$alias_


# FPDF::Cell #

**Cell(**

_$w_, [
_$h_ = 0], [
_$txt_ = ''], [
_$border_ = 0], [
_$ln_ = 0], [
_$align_ = ''], [
_$fill_ = false], [
_$link_ = '']**);**





**Parameters**
> _$w_
> _$h_
> _$txt_
> _$border_
> _$ln_
> _$align_
> _$fill_
> _$link_


# FPDF::Close #

**Close(**
**);**






# FPDF::Error #

**Error(**

_$msg_**);**





**Parameters**
> _$msg_


# FPDF::Footer #

**Footer(**
**);**






# FPDF::GetStringWidth #

**GetStringWidth(**

_$s_**);**





**Parameters**
> _$s_


# FPDF::GetX #

**GetX(**
**);**






# FPDF::GetY #

**GetY(**
**);**






# FPDF::Header #

**Header(**
**);**






# FPDF::Image #

**Image(**

_$file_, [
_$x_ = null], [
_$y_ = null], [
_$w_ = 0], [
_$h_ = 0], [
_$type_ = ''], [
_$link_ = '']**);**





**Parameters**
> _$file_
> _$x_
> _$y_
> _$w_
> _$h_
> _$type_
> _$link_


# FPDF::Line #

**Line(**

_$x1_, 
_$y1_, 
_$x2_, 
_$y2_**);**





**Parameters**
> _$x1_
> _$y1_
> _$x2_
> _$y2_


# FPDF::Link #

**Link(**

_$x_, 
_$y_, 
_$w_, 
_$h_, 
_$link_**);**





**Parameters**
> _$x_
> _$y_
> _$w_
> _$h_
> _$link_


# FPDF::Ln #

**Ln(**
[
_$h_ = null]**);**





**Parameters**
> _$h_


# FPDF::MultiCell #

**MultiCell(**

_$w_, 
_$h_, 
_$txt_, [
_$border_ = 0], [
_$align_ = 'J'], [
_$fill_ = false]**);**





**Parameters**
> _$w_
> _$h_
> _$txt_
> _$border_
> _$align_
> _$fill_


# FPDF::Open #

**Open(**
**);**






# FPDF::Output #

**Output(**
[
_$name_ = ''], [
_$dest_ = '']**);**





**Parameters**
> _$name_
> _$dest_


# FPDF::PageNo #

**PageNo(**
**);**






# FPDF::Rect #

**Rect(**

_$x_, 
_$y_, 
_$w_, 
_$h_, [
_$style_ = '']**);**





**Parameters**
> _$x_
> _$y_
> _$w_
> _$h_
> _$style_


# FPDF::SetAuthor #

**SetAuthor(**

_$author_, [
_$isUTF8_ = false]**);**





**Parameters**
> _$author_
> _$isUTF8_


# FPDF::SetAutoPageBreak #

**SetAutoPageBreak(**

_$auto_, [
_$margin_ = 0]**);**





**Parameters**
> _$auto_
> _$margin_


# FPDF::SetCompression #

**SetCompression(**

_$compress_**);**





**Parameters**
> _$compress_


# FPDF::SetCreator #

**SetCreator(**

_$creator_, [
_$isUTF8_ = false]**);**





**Parameters**
> _$creator_
> _$isUTF8_


# FPDF::SetDisplayMode #

**SetDisplayMode(**

_$zoom_, [
_$layout_ = 'continuous']**);**





**Parameters**
> _$zoom_
> _$layout_


# FPDF::SetDrawColor #

**SetDrawColor(**

_$r_, [
_$g_ = null], [
_$b_ = null]**);**





**Parameters**
> _$r_
> _$g_
> _$b_


# FPDF::SetFillColor #

**SetFillColor(**

_$r_, [
_$g_ = null], [
_$b_ = null]**);**





**Parameters**
> _$r_
> _$g_
> _$b_


# FPDF::SetFont #

**SetFont(**

_$family_, [
_$style_ = ''], [
_$size_ = 0]**);**





**Parameters**
> _$family_
> _$style_
> _$size_


# FPDF::SetFontSize #

**SetFontSize(**

_$size_**);**





**Parameters**
> _$size_


# FPDF::SetKeywords #

**SetKeywords(**

_$keywords_, [
_$isUTF8_ = false]**);**





**Parameters**
> _$keywords_
> _$isUTF8_


# FPDF::SetLeftMargin #

**SetLeftMargin(**

_$margin_**);**





**Parameters**
> _$margin_


# FPDF::SetLineWidth #

**SetLineWidth(**

_$width_**);**





**Parameters**
> _$width_


# FPDF::SetLink #

**SetLink(**

_$link_, [
_$y_ = 0], [
_$page_ = -1]**);**





**Parameters**
> _$link_
> _$y_
> _$page_


# FPDF::SetMargins #

**SetMargins(**

_$left_, 
_$top_, [
_$right_ = null]**);**





**Parameters**
> _$left_
> _$top_
> _$right_


# FPDF::SetRightMargin #

**SetRightMargin(**

_$margin_**);**





**Parameters**
> _$margin_


# FPDF::SetSubject #

**SetSubject(**

_$subject_, [
_$isUTF8_ = false]**);**





**Parameters**
> _$subject_
> _$isUTF8_


# FPDF::SetTextColor #

**SetTextColor(**

_$r_, [
_$g_ = null], [
_$b_ = null]**);**





**Parameters**
> _$r_
> _$g_
> _$b_


# FPDF::SetTitle #

**SetTitle(**

_$title_, [
_$isUTF8_ = false]**);**





**Parameters**
> _$title_
> _$isUTF8_


# FPDF::SetTopMargin #

**SetTopMargin(**

_$margin_**);**





**Parameters**
> _$margin_


# FPDF::SetX #

**SetX(**

_$x_**);**





**Parameters**
> _$x_


# FPDF::SetXY #

**SetXY(**

_$x_, 
_$y_**);**





**Parameters**
> _$x_
> _$y_


# FPDF::SetY #

**SetY(**

_$y_**);**





**Parameters**
> _$y_


# FPDF::Text #

**Text(**

_$x_, 
_$y_, 
_$txt_**);**





**Parameters**
> _$x_
> _$y_
> _$txt_


# FPDF::Write #

**Write(**

_$h_, 
_$txt_, [
_$link_ = '']**);**





**Parameters**
> _$h_
> _$txt_
> _$link_


# FPDF::_beginpage #_

_**beginpage(**_$orientation_,_$format_**);**_





**Parameters**
> _$orientation_
> _$format_


# FPDF::_dochecks #_

_**dochecks(**
**);**_





**Remarks**




**Protected methods**                                                                               




# FPDF::_dounderline #_

_**dounderline(**_$x_,_$y_,_$txt_**);**_





**Parameters**
> _$x_
> _$y_
> _$txt_


# FPDF::_enddoc #_

_**enddoc(**
**);**_






# FPDF::_endpage #_

_**endpage(**
**);**_






# FPDF::_escape #_

_**escape(**_$s_**);**_





**Parameters**
> _$s_


# FPDF::_getfontpath #_

_**getfontpath(**
**);**_






# FPDF::_getpageformat #_

_**getpageformat(**_$format_**);**_





**Parameters**
> _$format_


# FPDF::_newobj #_

_**newobj(**
**);**_






# FPDF::_out #_

_**out(**_$s_**);**_





**Parameters**
> _$s_


# FPDF::_parsegif #_

_**parsegif(**_$file_**);**_





**Parameters**
> _$file_


# FPDF::_parsejpg #_

_**parsejpg(**_$file_**);**_





**Parameters**
> _$file_


# FPDF::_parsepng #_

_**parsepng(**_$file_**);**_





**Parameters**
> _$file_


# FPDF::_putcatalog #_

_**putcatalog(**
**);**_






# FPDF::_putfonts #_

_**putfonts(**
**);**_






# FPDF::_putheader #_

_**putheader(**
**);**_






# FPDF::_putimages #_

_**putimages(**
**);**_






# FPDF::_putinfo #_

_**putinfo(**
**);**_






# FPDF::_putpages #_

_**putpages(**
**);**_






# FPDF::_putresourcedict #_

_**putresourcedict(**
**);**_






# FPDF::_putresources #_

_**putresources(**
**);**_






# FPDF::_putstream #_

_**putstream(**_$s_**);**_





**Parameters**
> _$s_


# FPDF::_puttrailer #_

_**puttrailer(**
**);**_






# FPDF::_putxobjectdict #_

_**putxobjectdict(**
**);**_






# FPDF::_readint #_

_**readint(**_$f_**);**_





**Parameters**
> _$f_


# FPDF::_readstream #_

_**readstream(**_$f_,_$n_**);**_





**Parameters**
> _$f_
> _$n_


# FPDF::_textstring #_

_**textstring(**_$s_**);**_





**Parameters**
> _$s_


# FPDF::_UTF8toUTF16 #_

_**UTF8toUTF16(**_$s_**);**_





**Parameters**
> _$s_



---


## Variable Detail ##
**`$AliasNbPages` = `` (line 92)** **Data type:** `mixed`

**`$author` = `` (line 89)** **Data type:** `mixed`

**`$AutoPageBreak` = `` (line 81)** **Data type:** `mixed`

**`$bMargin` = `` (line 58)** **Data type:** `mixed`

**`$buffer` = `` (line 42)** **Data type:** `mixed`

**`$cMargin` = `` (line 59)** **Data type:** `mixed`

**`$ColorFlag` = `` (line 76)** **Data type:** `mixed`

**`$compress` = `` (line 45)** **Data type:** `mixed`

**`$CoreFonts` = `` (line 63)** **Data type:** `mixed`

**`$creator` = `` (line 91)** **Data type:** `mixed`

**`$CurOrientation` = `` (line 48)** **Data type:** `mixed`

**`$CurPageFormat` = `` (line 51)** **Data type:** `mixed`

**`$CurrentFont` = `` (line 70)** **Data type:** `mixed`

**`$DefOrientation` = `` (line 47)** **Data type:** `mixed`

**`$DefPageFormat` = `` (line 50)** **Data type:** `mixed`

**`$diffs` = `` (line 66)** **Data type:** `mixed`

**`$DrawColor` = `` (line 73)** **Data type:** `mixed`

**`$FillColor` = `` (line 74)** **Data type:** `mixed`

**`$FontFamily` = `` (line 67)** **Data type:** `mixed`

**`$FontFiles` = `` (line 65)** **Data type:** `mixed`

**`$fonts` = `` (line 64)** **Data type:** `mixed`

**`$FontSize` = `` (line 72)** **Data type:** `mixed`

**`$FontSizePt` = `` (line 71)** **Data type:** `mixed`

**`$FontStyle` = `` (line 68)** **Data type:** `mixed`

**`$h` = `` (line 54)** **Data type:** `mixed`

**`$hPt` = `` (line 53)** **Data type:** `mixed`

**`$images` = `` (line 78)** **Data type:** `mixed`

**`$InFooter` = `` (line 84)** **Data type:** `mixed`

**`$InHeader` = `` (line 83)** **Data type:** `mixed`

**`$k` = `` (line 46)** **Data type:** `mixed`

**`$keywords` = `` (line 90)** **Data type:** `mixed`

**`$lasth` = `` (line 61)** **Data type:** `mixed`

**`$LayoutMode` = `` (line 86)** **Data type:** `mixed`

**`$LineWidth` = `` (line 62)** **Data type:** `mixed`

**`$links` = `` (line 80)** **Data type:** `mixed`

**`$lMargin` = `` (line 55)** **Data type:** `mixed`

**`$n` = `` (line 40)** **Data type:** `mixed`

**`$offsets` = `` (line 41)** **Data type:** `mixed`

**`$page` = `` (line 39)** **Data type:** `mixed`

**`$PageBreakTrigger` = `` (line 82)** **Data type:** `mixed`

**`$PageFormats` = `` (line 49)** **Data type:** `mixed`

**`$PageLinks` = `` (line 79)** **Data type:** `mixed`

**`$pages` = `` (line 43)** **Data type:** `mixed`

**`$PageSizes` = `` (line 52)** **Data type:** `mixed`

**`$PDFVersion` = `` (line 93)** **Data type:** `mixed`

**`$rMargin` = `` (line 57)** **Data type:** `mixed`

**`$state` = `` (line 44)** **Data type:** `mixed`

**`$subject` = `` (line 88)** **Data type:** `mixed`

**`$TextColor` = `` (line 75)** **Data type:** `mixed`

**`$title` = `` (line 87)** **Data type:** `mixed`

**`$tMargin` = `` (line 56)** **Data type:** `mixed`

**`$underline` = `` (line 69)** **Data type:** `mixed`

**`$w` = `` (line 54)** **Data type:** `mixed`

**`$wPt` = `` (line 53)** **Data type:** `mixed`

**`$ws` = `` (line 77)** **Data type:** `mixed`

**`$x` = `` (line 60)** **Data type:** `mixed`

**`$y` = `` (line 60)** **Data type:** `mixed`

**`$ZoomMode` = `` (line 85)** **Data type:** `mixed`



---

## Class Constant Detail ##



---
