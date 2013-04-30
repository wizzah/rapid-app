<?php
	error_reporting(E_ERROR);
	include_once "lib/GameFetcher.php";

	$config = parse_ini_file("config.ini");

	$game_title = $_POST['textInput'];

	$howlongtobeat_url = GameFetcher::parse_element($config['google.search.url'].$game_title, "//cite");
	$average_time_to_beat = GameFetcher::parse_element($howlongtobeat_url, "//div[@class='gamepage_estimates']/div/div");

	$properties = array(
		"url" => sprintf($config['google.api.url'], $game_title, $config['google.api.key']),
		"time" => $average_time_to_beat,
	);

	$game = new GameFetcher($properties);
?>

<p><a href="<?= $game->link; ?>">View this game at the listed price in its store.</a></p>
<p class="title"><?= $game->title; ?></p>
<p><img src="<?= $game->thumbnail; ?>" class="thumbnail" alt="<?= $game->title; ?>" /></p>
<aside class="averages">
	<p class="top">Completing the main story</p>
	<p class="min">Average time, minutes: <strong><?= $game->total_mins; ?></strong></p>
	<p class="min">Cost of game per minute: <strong>$<?= round($game->price/$game->total_mins, 3); ?></strong></p>
	<p class="hrs">Average time, hours: <strong><?= $game->total_hours; ?></strong></p>
	<p class="hrs">Cost of game per hour: <strong>$<?= round($game->price/$game->total_hours, 3); ?></strong></p>
</aside>
<p class="price">$<?= $game->price; ?></p>
<p><a href="http://<?= $howlongtobeat_url; ?>">View this game's page at Howlongtobeat</a></p>
