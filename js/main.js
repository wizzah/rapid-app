$(document).ready(function() {

	$(".textInput").on("click", function() {
		$(this).attr("placeholder", "");
	});

	$("form").on("submit", function(e) {
		e.preventDefault();
		//append results once
		if ($(".results").length == 0) {
			$("<div class='results'>").appendTo(".content");
		}

		var textInput = $("input[name='textInput']").val();

		if (textInput == "") {
			$(".results").html("You gotta search for somethin'!");
		} else {

			// / /g replaces all instances of space
			textInput = textInput.replace(/ /g, "+");
			console.log(textInput);

			$.post("scraper.php", {
				textInput : textInput
			}, function(data) {
				//append results
				$(".results").html(data);
			});
		}



	});

});