$(function () { // Document is ready


	// Tooltips
	$('[data-toggle=tooltip]').tooltip();


	// Checkboxes and Radio buttons
	$('[data-toggle="checkbox"]').radiocheck();
	$('[data-toggle="radio"]').radiocheck();


	// Page scroll to content
	if ( $('body').hasClass('other') )
		$(window).scrollTop($('#big-title').offset().top);


	// Disable link clicks to prevent page scrolling
	$(document).on('click', 'a[href="#"]', function (e) {
	  e.preventDefault();
	  return false;
	});


	// Check to Show feature
	$('.checktoshow input').click(function() {

		var hiddenElement = $(this).parent().next();

		hiddenElement.toggle(0, function() {

			if ( $(this).is(':visible') )
				$(this).children('input').prop('disabled', false);
			else
				$(this).children('input').prop('disabled', true);

		});

	});


});