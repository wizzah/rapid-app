<?php
// General purpose class for retrieving game data.
class GameFetcher {

	public function __construct($properties) {
		$site_data = self::get_site_data($properties['url']);
		$jdata = json_decode($site_data, true);

		$this->title = $jdata["items"][0]["product"]["title"];
		$this->link = $jdata["items"][0]["product"]["link"];
		$this->thumbnail = $jdata["items"][0]["product"]["images"][0]["thumbnails"][0]["link"];
		$this->price = $jdata["items"][0]["product"]["inventories"][0]["price"];

        if (array_key_exists('time', $properties)) {
            $time = preg_split("/[\shm]+/", $properties['time']);
            $time[0] = 60*(intval($time[0]));
            $time[1] = intval($time[1]);
            $time = $time[0] + $time[1];

			$this->total_mins = $time;
			$this->total_hours = round($time/60, 3);
        }
	}

	public static function parse_element($url, $selector) {
		$site_data = self::get_site_data($url);
		$doc = new DOMDocument();
		$doc->loadHTML($site_data);
		$xpath = new DOMXpath($doc);

		$node = $xpath->query($selector);

		return $node->item(0)->nodeValue;
	}

	public static function get_site_data($url) {
		$c = curl_init();
		curl_setopt($c, CURLOPT_HEADER, 0);

		//Quick fix because of https
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_URL, $url);

		$response = curl_exec($c);
		curl_close($c);

		return $response;
	}
}	
?>
