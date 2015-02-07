/*
Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

	config.toolbar_none = [];
	
	config.toolbar_simple =
		[
		   ['Bold','Italic','Underline'],
		   ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		   ['Cut','Copy','Paste','PasteFromWord'],
		   ['Link','Unlink'],['Smiley'], ['TextColor','BGColor']
		];
	
	config.toolbar_medium =
		[
		   ['Source'],
		   ['Cut','Copy','Paste','PasteText','PasteFromWord', 'SpellChecker', 'Scayt'],
		   ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
		   ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
		   ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
		   ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		   ['Link','Unlink','Anchor'],
		   ['Image','Table','HorizontalRule','Smiley','SpecialChar','PageBreak']
		];
	
    CKEDITOR.config.toolbar = 
    	[
    		['Source','-','Save','NewPage','Preview','-','Templates'], 
    		['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker','Scayt'], 
    		['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
    		['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
    		'/', ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'], 
    		['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'], 
    		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'], 
    		['Link','Unlink','Anchor'], 
    		['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'], '/', 
    		['Styles','Format','Font','FontSize'], ['TextColor','BGColor'], 
    		['Maximize','ShowBlocks','-','About']
    	];
};
