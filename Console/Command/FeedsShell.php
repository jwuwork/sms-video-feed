<?php
App::uses('HttpSocket', 'Network/Http');

class FeedsShell extends AppShell {
	public $uses = array('Subscription', 'Video', 'PopularVideo', 'Call');

	public function main() {
		$this->update();
		$this->notify();
	}
	
	/**
	 * Update the data store with the most popular video feed.
	 */
	public function update() {
		// Fetch the most popular video of the hour
		// 
		// Note: on production, we should probably use an IoC container
		// to resolve this to reduce the coupling.
		$api = new YouTubeApi();
		$video_url = $api->getMostPopularVideo();
		
		$video = $this->Video->findByVideoUrl($video_url);
		if (!$video) {
			// Save video_url to videos table
			$video = $this->Video->save(array('video_url' => $video_url));
		}
		
		// Save time and video_id to popular_videos table
		$this_hour = date('Y-m-d H:00:00');
		$popular_video = $this->PopularVideo->find('first', array(
			'conditions' => array('time' => $this_hour, 'video_id' => $video['Video']['id'])
		));
		if (!$popular_video) {
			$popular_video = $this->PopularVideo->save(array(
				'time' => $this_hour,
				'video_id' => $video['Video']['id']
			));
		}
	}
	
	/**
	 * Sends a SMS message with the current hour's most popular video to all subscribers.
	 */
	public function notify() {
		// Get the most popular video of hour from the data store
		$this_hour = date('Y-m-d H:00:00');
		$options['conditions'] = array('time' => $this_hour);
		$options['joins'] = array(
			array(
				'table' => 'videos',
				'alias' => 'Video',
				'type' => 'INNER',
				'conditions' => array('Video.id = PopularVideo.video_id')
			)
		);
		$options['fields'] = array('Video.video_url');
		$popular_video = $this->PopularVideo->find('first', $options);

		if ($popular_video) {
			// popular_video can be empty if we have not updated the data store
			// for this hour.
			
			// Get all subscription phone numbers that we have not already sent
			// the SMS to for this hour.
			//
			// SELECT
			//		s.phone_number
			// FROM
			//		subscriptions s
			//		LEFT JOIN calls c ON (s.id = c.subscription_id)
			// WHERE
			//		c.subscription_id IS NULL;
			//	
			// TODO: include those calls that have failed in the list.
			$options['joins'] = array(
				array(
					'table' => 'calls',
					'alias' => 'Call',
					'type' => 'LEFT',
					'conditions' => array('Subscription.id = Call.subscription_id')
				)
			);
			$options['conditions'] = array('Call.subscription_id' => NULL);
			$options['fields'] = array('Subscription.id', 'Subscription.phone_number');
			$subscriptions = $this->Subscription->find('all', $options);

			// Create and send the SMS message
			// 
			// Note: on production, we should probably use an IoC container
			// to resolve this to reduce the coupling.
			$api = new TwilioApi();
			foreach ($subscriptions as $subscription) {
				$call_status = $api->sendSms("+1" . $subscription['Subscription']['phone_number'], $popular_video['Video']['video_url']);
				
				// Record the response
				$this->Call->save(array(
					'subscription_id' => $subscription['Subscription']['id'],
					'time_called' => $this_hour,
					'call_status' => $call_status
				));
			}
		}
	}
}
