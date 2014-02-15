CREATE DATABASE sms_video_feed;
USE sms_video_feed;

/* First, create our subscriptions table: */
CREATE TABLE subscriptions (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	phone_number CHAR(10) NOT NULL
);

/* Then insert some phones for testing: */
-- INSERT INTO subscriptions (phone_number)
-- 	VALUES ('4155551234');

CREATE TABLE videos (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	video_url VARCHAR(2000) NOT NULL
);

CREATE TABLE popular_videos (
	time DATETIME NOT NULL,
	video_id INT UNSIGNED NOT NULL,
	PRIMARY KEY (time, video_id)
);

CREATE VIEW aggregate_popular_videos AS
SELECT
	video_id,
	COUNT(*) as times_most_popular
FROM
	popular_videos
GROUP BY
	video_id;

CREATE TABLE calls (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	subscription_id INT UNSIGNED NOT NULL,
	time_called DATETIME NOT NULL,
	call_status ENUM('received', 'queued', 'sending', 'sent', 'failed') NOT NULL
);
