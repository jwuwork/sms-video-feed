<?php

class PopularVideo extends AppModel {
	public $validate = array(
		'time' => array(
			'rule' => 'notEmpty'
		)
	);
}
