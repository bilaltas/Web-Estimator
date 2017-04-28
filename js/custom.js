$(function () { // Document is ready


	// Tooltips
	$('[data-toggle=tooltip]').tooltip();


	// Checkboxes and Radio buttons
	$('[data-toggle="checkbox"]').radiocheck();
	$('[data-toggle="radio"]').radiocheck();


	// Page scroll to content
	if ( $('body').hasClass('other') && $('#big-title').length )
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


	// Admin Edits
	$('.input-admin > .field > a').click(function() {

		$(this).prev().toggle();

	});


	// Admin Update Time
	$('.input-admin > span.field.update-time > span > input').keydown(function (e){

		var realInput = $(this).parent().parent().parent().parent().children('input');
		var input_to_hide = $(this).parent();
		var inputID = realInput.attr('id');
		var inputTime = $(this).val();

	    if(e.keyCode == 13){

			var data = { ajax_action: "update-time", input_ID: inputID, input_time: inputTime };

		    $.ajax({
				type: "POST",
				url: "/",
				data: data,
				dataType:'json',
				success: function(data) {
					if (data.success) {
						input_to_hide.toggle();
					} else
						console.log(data);
				},
				error : function(request,error) {
			        console.log(JSON.stringify(request));
			    }
			});

			e.preventDefault();
	        return false;
	    }
	});


	// Admin Duplicate Inputs
	$('.input-admin > span.field.duplicate-input > a').click(function (e){

		var realInput = $(this).parent().parent().parent().children('input');
		var inputID = realInput.attr('id');

		var data = { ajax_action: "duplicate-input", input_ID: inputID };

	    $.ajax({
			type: "POST",
			url: "/",
			data: data,
			dataType:'json',
			success: function(data) {
				if (data.success == true) {
					location.reload();
				} else
					console.log(data);
			},
			error : function(request,error) {
		        console.log(JSON.stringify(request));
		    }
		});

		e.preventDefault();
        return false;

	});


	// Admin Delete Inputs
	$('.input-admin > span.field.delete-input > a').click(function (e){

		if ( confirm("Are you sure you want to delete this option?") ) {

			var realInput = $(this).parent().parent().parent().children('input');
			var inputID = realInput.attr('id');

			var data = { ajax_action: "delete-input", input_ID: inputID };

		    $.ajax({
				type: "POST",
				url: "/",
				data: data,
				dataType:'json',
				success: function(data) {
					if (data.success == true) {
						location.reload();
					} else
						console.log(data);
				},
				error : function(request,error) {
			        console.log(JSON.stringify(request));
			    }
			});

		}

		e.preventDefault();
        return false;

	});


}); // Document is ready