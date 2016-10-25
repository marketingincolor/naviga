var delayUnFlip;

// Set up flip function
function flipIt() {
	toFlip = $(this);
	
	if (!toFlip.hasClass('revealed')) {
		toFlip.flip({
			direction:'lr',
			content: $('.flip-content', toFlip),
			speed: 200,
			color: '#F3EFE7'
		});
		delayBind  = setTimeout(function() {
			toFlip.addClass('revealed');
			clearTimeout(delayBind);	
		}, 400);
	}
	else {
		toFlip.revertFlip();
		
		toFlip.removeClass('revealed');
	}
}
	