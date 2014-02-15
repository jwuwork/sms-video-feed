Grab the most popular video feed of the hour from YouTube and send that via sms to all subscribers.

Makes use of YouTube API and Twilio API.
Built on CakePHP framework.

Install
-------
* Use composer to restore packages
* Setup the database (sql script: db.sql)
* Setup an hourly cron (cron file: cron)

Available Tasks
---------------
sudo Console/cake feeds

OR

sudo Console/cake feeds update
sudo Console/cake feeds notify

Manage Subscriptions
--------------------
http://localhost/sms-video-feed/subscriptions
