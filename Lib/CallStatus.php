<?php

/**
 * https://www.twilio.com/help/faq/sms/what-do-the-sms-statuses-mean
 */
class CallStatus {
	// Every Twilio SMS has a Status value which describes the current state of
	// the message. When sending SMS here is the typical sequence of Status values:
	
	// All new messages are created with a status of queued, indicating your
	// request to send a message was successful and the message is queued to be
	// sent out.
	const QUEUED = 'queued';
	
	// A short time later Twilio starts the process of dispatching your message
	// to the nearest upstream carrier in the SMS network.
	const SENDING = 'sending';
	
	// Once the nearest upstream carrier has accepted the message for delivery
	// to the SMS network, the status is updated to sent
	const SENT = 'sent';


	// Although the above represents a common message flow, other Status values
	// are possible:


	// The upstream provider did not accept the message for delivery, likely
	// because the number is not capable of receiving SMS messages
	const FAILED = 'failed';

	// All inbound messages will have this status, indicating the message was
	// received by one of your Twilio numbers.
	const RECEIVED = 'received';
}
