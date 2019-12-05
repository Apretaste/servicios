$(document).ready(function () {
	$('select').formSelect();
});

function filter(selectedFilter) {
	if(selectedFilter == 'todo') selectedFilter = false;
	$('#services').html(filteredServices(selectedFilter))
}

function serviceCard(service) {
	service.name = service.name.charAt(0).toUpperCase() + service.name.slice(1);
	return "<div class=\"col s4 m2\" title=\"" + service.description + "\">" +
				"<div class=\"card\" style=\"padding: 1rem\">" +
					"<a href=\"#\" class=\"green-text apretaste\"" +
						"onclick=\"apretaste.send({command : '" + service.name + "'})\">" +
						"<img src=\"" + appImgPath + "/" + service.image + "\" alt=\"" + service.name + "\" width=\"100%\">" +
						service.name +
					"</a>" +
				"</div>" +
			"</div>"
}

function filteredServices(filter = false) {
	var html = "";
	for (var category in services) {
		if (filter && category != filter) continue;
		var name = category.charAt(0).toUpperCase() + category.slice(1);

		html += "<h5 class=\"green-text\"><b>" + name + "</b></h5>" +
				"<div class=\"row\">";

		services[category].forEach(function (service) {
			html += serviceCard(service)
		});

		html += "</div><div class=\"divider\"></div>"
	}

	return html;
}
