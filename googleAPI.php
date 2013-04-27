<?php

include_once 'key.php';

//google API
//This version will be deprecated in September 2013

//every request needs key and country
$url = "https://www.googleapis.com/shopping/search/v1/public/products?key=".$key."&country=US&q="."digital+camera&alt=json";
echo "<a href='".$url."'>".$url."</a>";
echo "<br />";

$ch = curl_init();
curl_setopt($ch, CURLOPT_HEADER, 0);
//Quick fix because of https
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $url);
$curl_response = curl_exec($ch);
curl_close($ch);


$result = json_decode($curl_response);
var_dump($result);
?>