jQuery.fn.clearable = function() {
 
  $('.morelink').live('click', function() {
    var $this = $(this);
    if ($this.hasClass('less')) {
      $this.removeClass('less');
      $this.html(config.moreText);
    } else {
      $this.addClass('less');
      $this.html(config.lessText);
    }
    $this.parent().prev().toggle();
    $this.prev().toggle();
    return false;
  });
 
  return this.each(function() {
	
	
    	
	$(this).css({'border-width': '0px', 'outline': 'none'})
		.wrap('<div id="sq" class="divclearable"></div>')
		.parent()
		.attr('class', $(this).attr('class') + ' divclearable')
		.append('<a class="clearlink" href="javascript:"></a>');

	$('.clearlink')
		.attr('title', 'Click to clear this textbox')
		.click(function() {
			
			$(this).prev().val('').focus();

	});
  });
}