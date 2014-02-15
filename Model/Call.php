<?php

class Call extends AppModel {
	public $validate = array(
		'time_called' => array(
			'rule' => 'notEmpty'
		),
		'call_status' => array(
			'rule' => 'notEmpty'
		)
	);
}
