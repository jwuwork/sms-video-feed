<?php

/**
 * Send an SMS using Twilio.
 */
class TwilioApi {
	// Set our account sid and auth token from www.twilio.com/user/account
	const ACCOUNT_SID = "ACXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
	const AUTH_TOKEN = "YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY";
	const TWILIO_NUMBER = "YYY-YYY-YYYY";
	
	/**
	 * @var Services_Twilio
	 */
	protected $client;
	
	/**
	 * @todo Refactor this to use constructor injection.
	 */
	public function __construct() {
		// Instantiate a new Twilio Rest Client
		$this->client = new Services_Twilio(self::ACCOUNT_SID, self::AUTH_TOKEN);
	}

	/**
	 * Send a SMS message to the phone number provided.
	 * 
	 * @param string $number Format: +12345678900
	 * @param string $message
	 * @return CallStatus
	 */
	public function sendSms($number, $message = "") {

		try {
			$this->client->account->messages->sendMessage(

				// Change the 'From' number below to be a valid Twilio number
				// that you've purchased, or the (deprecated) Sandbox number
				self::TWILIO_NUMBER,

				// The number we are sending to - Any phone number
				$number,

				// The sms body
				$message
			);
		} catch (Services_Twilio_RestException $e) {
			return CallStatus::FAILED;
		}

		return CallStatus::QUEUED;
	}
}
