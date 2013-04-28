<?php

	//scraper? But I barely even know'er!
	include_once 'key.php';
	include_once 'googleAPI.php';

	//howlongtobeat.com doesn't have an API and you can't get game IDs normally
	//to proceed, we need to scrape google for howlongtobeat's game pages

	function scrape($key, $game) {
	
		$game = $_POST['textInput'];

		$url = "https://www.google.com/search?q=howlongtobeat%20".$game;

		// curling google
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		//Quick fix because of https
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		$google_response = curl_exec($ch);
		curl_close($ch);

		//you can do DOM things in PHP!
		//xpath is the step before selectors
		
		$doc = new DOMDocument();
		$doc->loadHTML($google_response);
		$xpath = new DOMXpath($doc);

		//google puts howlongtobeat's URL in a cite tag
		$node = $xpath->query('//cite');

		$site_url = $node->item(0)->nodeValue;

		// curling howlongtobeat
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		//Quick fix because of https
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $site_url);
		$howlongtobeat_response = curl_exec($ch);
		curl_close($ch);

		$doc2 = new DOMDocument();
		$doc2->loadHTML($howlongtobeat_response);

		$xpath2 = new DOMXpath($doc2);
		//howlongtobeat puts average gameplay length data in two unnamed, nested divs,
		// which are in a div with a class name of gamepage_estimates
		$node2 = $xpath2->query('//div[@class="gamepage_estimates"]/div/div');

		//plug into google shopping API
		$price = getPrice($key, $game);

		$averageTime = $node2->item(0)->nodeValue;

		//convert to just minutes
		//howlongtobeat format is '55h 5m'
		$averageTime = preg_split("/[\shm]+/", $averageTime);
		$averageTime[0] = (60*(intval($averageTime[0])));
		$averageTime[1] = (intval($averageTime[1]));
		$averageTimeMins = ($averageTime[0] + $averageTime[1]);
		$totalMins = $averageTimeMins;
		$averageTimeMins = ($price/$averageTimeMins);
?>
	<p>Average time in minutes: <?=$totalMins;?></p>
	<p>Cost of game per minute: <?=$averageTimeMins;?></p>
	<p class="averageTime">Price: <?=$price;?></p>
	<p class ="original"><a href="http://<?=$site_url;?>">View the original page</a></p>
<?php

	}

	scrape($key, $game);
	
?>

