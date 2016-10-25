(function($){$(function(){
	
	$('#cft .slideshowtoggle select').live('change', function(){
		
		var selection = $(this).val();
		
		switch(selection){
			
			case 'default':
				$('#cft .customheader, #cft .slideshowsetting').hide();
				break;
				
			case 'custom_image':
				$('#cft .slideshowsetting').hide();
				$('#cft .customheader').show();
				break;
			
			case 'ss_small':
				$('#cft .slideshowsetting').show();
				$('#cft .customheader').hide();
				break;
				
			case 'ss_large':
				$('#cft .slideshowsetting').show();
				$('#cft .customheader').hide();
				break;
		}
	});
	$('#cft .slideshowtoggle select').trigger('change');

});})(jQuery);