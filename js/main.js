$(document).ready(function() {

	$("form").on("submit", function(e) {
		e.preventDefault();
		var textInput = $("input[name='textInput']").val();
		// / /g is replace all instances of space
		textInput = textInput.replace(/ /g, "+");
		console.log(textInput);

		$.post("scraper.php", {
			textInput : textInput
		}, function(data) {
			//append results
			console.log(data);
		// $(".results").empty().append(result);

		});
	});

});