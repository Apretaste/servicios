$(document).ready(function () {
	$('select').formSelect();
});

function filter(category) {
	if(category == '') $('.service').slideDown();
	else {
		$('.service').hide();
		$('.'+category).slideDown();		
	}
}