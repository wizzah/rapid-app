<?php

// include_once 'key.php';

//google API
//This version will be deprecated in September 2013

// $url = "https://www.googleapis.com/shopping/search/v1/public/products?key=".$key."&country=US&q="."digital+camera&alt=json";

function getPrice($key, $game) {

	//every request needs key and country
	$url = "https://www.googleapis.com/shopping/search/v1/public/products?key=".$key."&country=US&q=".$game."&alt=json";

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
	echo "<a href='".$url."'>".$url."</a><br />";

	// echo $result->startIndex;
	// echo $result[0]->startIndex;
	// echo $result[0]->startIndex[0];
	// print_r($result["items"][0]["inventories"][0]["price"]);
	echo $result["items"][0]["product"]["title"];
	echo $result["items"][0]["product"]["inventories"][0]["price"];
	// ["product"][0]["inventories"][0]["price"][0];

	//get first item
	// var_dump($result);
	// echo $result->$items[0]->$product[0]->$inventories->$price;
	echo "<br />";
	// echo $result->$items[0]->$product[0];
	//not sure if the above works
	//get title and plug into scrapey(); for that name

	// scrapey($game);

	return $result;
}

// getPrice($key, $game);

?>