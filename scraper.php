<?php
	
	//scraper? But I barely even know'er!

	//howlongtobeat.com doesn't have a proper API and you can't post to their form.
	//to proceed, we need to scrape google for howlongtobeat's item URL

	$game = $_POST['textInput'];

	// curling google
	$url = "https://www.google.com/search?q=howlongtobeat%20".$game;

	echo $url."<br />";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER, 0);
	//Quick fix because of https
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	$google_response = curl_exec($ch);
	curl_close($ch);

	//you can do DOM things in PHP
	//xpath is the step before selectors
	
	$doc = new DOMDocument();
	$doc->loadHTML($google_response);

	$xpath = new DOMXpath($doc);
	//google puts the URL in a cite tag
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

	// print_r($node2);
	echo "<div class='averageTime'>".$node2->item(0)->nodeValue."</div>";

?>