$(document).ready(function() {

	$(".textInput").on("click", function() {
		$(this).attr("placeholder", "");
	});

	$("form").on("submit", function(e) {
		e.preventDefault();
		//append results once
		if ($(".results").length == 0) {
			$("<article class='results'>").appendTo(".content");
		}

		var textInput = $("input[name='textInput']").val();

		if (textInput == "") {
			$(".results").html("You gotta search for somethin'!");
		} else {

			// / /g replaces all instances of space
			textInput = textInput.replace(/ /g, "+");
			console.log(textInput);
			$(".results").html("<div class='wait'><img src='img/wait_gif.gif' alt='loading' class='waiting' /><p>loading...</p></div>");
			$.post("scraper.php", {
				textInput : textInput
			}, function(data) {
				//append results
				$(".results").html(data);

				//style breaks when howlongtobeat has no results, this is a quick fix.
				if($(".problem").length > 0) {
					$(".results img").css("float", "none");
				}
			});
		}



	});

});