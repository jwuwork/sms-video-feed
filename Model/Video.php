<?php

class Video extends AppModel {
	public $validate = array(
		'video_url' => array(
			'rule' => 'url'
		)
	);
}
