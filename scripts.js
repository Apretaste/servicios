$(document).ready(function () {
	$('select').formSelect();
});

function options() {
	$('.drop-down .options').slideDown('fast');
}

function select(element) {
	// get text and value from element
	var text = $(element).find('.text').text();
	var category = $(element).attr('value');

	// show all categories
	if(category == 'all') {
		$('.service').slideDown();
	} 
	// filter by category name
	else {
		$('.service').hide();
		$('.'+category).slideDown();		
	}

	// hide the options bar
	$('.drop-down .options').hide();

	// add text to the input
	$('#filter').val(text);
}

function filter(element) {
	// get text to filter by
	var text = $('#filter').val().toLowerCase();

	$('.service').show().each(function(i, e) {
		// get the caption
		var caption = $(e).attr('data-value').toLowerCase();

		// hide if caption does not match
		if(caption.indexOf(text) < 0) {
			$(e).hide();
		}
	})
}

function clean() {
	$('#filter').val('');
}