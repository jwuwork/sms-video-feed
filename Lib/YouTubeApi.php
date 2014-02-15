<?php

class YouTubeApi {
	
	/**
	 * Returns the url of the most popular video at this time.
	 */
	public function getMostPopularVideo() {
		$xml = Xml::build('http://gdata.youtube.com/feeds/api/standardfeeds/most_popular');
		
		// The assumptions here, for simplicity purpose, are there will always
		// be a most popular entry and the link will always contain a href.
		return $xml->entry[0]->link[0]['href'];
	}
}
