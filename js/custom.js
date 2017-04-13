$(function () {

	// Tooltips
	$('[data-toggle=tooltip]').tooltip();


	// Disable link clicks to prevent page scrolling
	$(document).on('click', 'a[href="#"]', function (e) {
	  e.preventDefault();
	});


	// Checkboxes and Radio buttons
	$('[data-toggle="checkbox"]').radiocheck();
	$('[data-toggle="radio"]').radiocheck();


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