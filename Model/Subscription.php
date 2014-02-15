<?php

class Subscription extends AppModel {
	public $validate = array(
		'phone_number' => array(
			'rule' => array('phone', null, 'us')
		)
	);
}
