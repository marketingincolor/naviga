/**
 * Global JS
 *
 * @codekit-prepend "jquery.cycle.js"
 * @codekit-prepend "jquery.backstretch.min.js"
 */

// AddThis Configuration
var addthis_config = {
	data_track_clickback: true
};

(function ($) {

	// Menu levels
	$("div.menu > ul > li.current_page_item, div.menu > ul > li.current_page_parent, div.menu > ul > li.current_page_ancestor").addClass("tier-1-active");
	$("div.tier-2 > ul > li.current_page_item, div.tier-2 > ul > li.current_page_parent, div.tier-2 > ul > li.current_page_ancestor").addClass("tier-2-active");
	$("div.tier-3 > ul > li.current_page_item, div.tier-3 > ul > li.current_page_parent, div.tier-3 > ul > li.current_page_ancestor").addClass("tier-3-active");

	// slideshow
	var $slideshow = $("div.splash ul");
	if ($slideshow.length > 0) {

		// cycle handles rotations
		if ($("li", $slideshow).size() > 1) {
			$slideshow.cycle();
		}

		// stretch each background to fit
		$('.slide-background', $slideshow).each(function () {
			var img = $(this).data('background');
			$(this).backstretch(img);
		});
	}

	// Comments
	if ($("#commentform").length > 0) {
		head.js("http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js", function () {
			$("#commentform").validate();
		});
	}

	// Google analytics cross domain tracking
	var external_ga_link = $('a.external-ga-link');
	if (external_ga_link.length > 0) {
		external_ga_link.click(function () {

			// Send pageview to Google Analytics
			var href = $(this).attr('href');
			_gaq.push(['_link', href]);

			// Debugging
			if (window.console && window.console.log)
				console.log('External domain link successfully tracked in Google Analytics.');
		});
	}

	// Automatic pdf icons
	jQuery('table a[href$=pdf]').addClass('pdf').attr('target', '_blank');

	// External links open in new window
	jQuery("table a[href^='http://']").addClass('external');

	// Add class of 'odd' to job listing <li> tags
	$('#job-list ul li:odd').addClass('odd');

	// Add overflow to tables
	if ($('table').length > 0) {
		$('table').wrap('<div style="overflow: auto; margin-top: 20px;" />');
	}

	// Expand/collapse
	$('.collapsible .expand-pane').slideUp(0);
	$('.collapsible .expander').click(function () {
		$(this).parent().parent().find('.expand-pane').stop(true, true).slideToggle(350);
		return false;
	});

	// Blog navigation item
	$('#content .page-item-1534 > a').click(function () {
		$(this).parent().toggleClass('current_page_parent').find('.tier-2').toggle();
		return false;
	});

})(jQuery);