$(document).ready(function() {

	$("form").on("submit", function(e) {
		e.preventDefault();
		var textInput = $("input[name='textInput']").val();
		// / /g replaces all instances of space
		textInput = textInput.replace(/ /g, "+");
		console.log(textInput);

		$.post("scraper.php", {
			textInput : textInput
		}, function(data) {
			//append results
			// $(".results").empty().append(data);
			// $("form").after().append($("div"));
			// $(".content").append($("div.results"));
			$("<div class='results'>").appendTo(".content");
			$(".results").html(data);
		});
	});

});