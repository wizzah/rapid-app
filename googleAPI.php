<?php

//google API
//This version will be deprecated in September 2013
//https://developers.google.com/shopping-search/v1/getting_started

function getPrice($key, $game, $price) {

	//every request needs key and country
	// no work $url = "https://www.googleapis.com/shopping/search/v1/public/products?key=".$key."&country=US&q=video+game+software+".$game."&thumbnails=64:64alt=json";
	// https://www.googleapis.com/shopping/search/v1/public/products?country=US&q=video+game+software+tetris&thumnbnails=64:64&key=AIzaSyB8YFulYC9M-CQ2oW-oprS3Lh66pTv-QjY&alt=json
	// works $url = "https://www.googleapis.com/shopping/search/v1/public/products?country=US&q=video+game+software+".$game."&thumbnails=64:*,128:*&key=".$key;
	$url = "https://www.googleapis.com/shopping/search/v1/public/products?country=US&q=video+game+software+".$game."&thumbnails=128:128&key=".$key;
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER, 0);
	//Quick fix because of https
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	$curl_response = curl_exec($ch);
	curl_close($ch);

	$result = json_decode($curl_response, true);

	// var_dump($result);

	//google shopping link
	$link = $result["items"][0]["product"]["link"];
	//get title of first item
	$title = $result["items"][0]["product"]["title"];
	//get image and price
	$thumbnail = $result["items"][0]["product"]["images"][0]["thumbnails"][0]["link"];
	$price = $result["items"][0]["product"]["inventories"][0]["price"];
?>
	<p><a href="<?=$link;?>">View this game at the listed price in its store.</a></p>
	<p class="title"><?=$title;?></p>
	<p><img src="<?=$thumbnail;?>" class="thumbnail" alt="<?=$title;?>" /></p>

<?php

	return $price;
}


?>