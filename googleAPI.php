<?php

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

	//google shopping link
	$link = $result["items"][0]["product"]["link"];
	echo "<a href='".$link."'>".$link."</a><br />";

	//get title and price of first item
	echo $result["items"][0]["product"]["title"];
	echo $result["items"][0]["product"]["inventories"][0]["price"];

	echo "<br />";
	return $result;
}


?>