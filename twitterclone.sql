-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 30, 2021 at 10:08 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `twitterclone`
--

-- --------------------------------------------------------

--
-- Table structure for table `tweets`
--

CREATE TABLE `tweets` (
  `tw_id` int(200) NOT NULL,
  `tw_uid_created` int(200) NOT NULL,
  `tw_message` varchar(600) NOT NULL,
  `tw_created_date` datetime NOT NULL,
  `tw_no_of_likes` int(200) NOT NULL DEFAULT 0,
  `tw_no_of_retweets` int(200) NOT NULL DEFAULT 0,
  `tw_updated_date` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `tw_status` int(200) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tweets`
--

INSERT INTO `tweets` (`tw_id`, `tw_uid_created`, `tw_message`, `tw_created_date`, `tw_no_of_likes`, `tw_no_of_retweets`, `tw_updated_date`, `tw_status`) VALUES
(8, 9, '   I\'m in love with this weather... Made Indian snacks.. who all are visiting my place today?\r\n          ', '2021-05-25 00:00:00', 0, 0, '2021-05-26 01:33:00.989724', 1),
(9, 9, 'When the travel restrictions are gonna be eased out? \r\nDisclaimer: Asking for an emergency situation to handle with! ', '2021-05-25 00:00:00', 0, 0, '2021-05-26 01:35:35.488744', 1),
(10, 9, 'Be aware of Black fungus that is badly hitting covid recovered people!! \r\nStay super cautious!! ', '2021-05-25 00:00:00', 0, 0, '2021-05-26 01:36:50.802768', 1),
(15, 10, 'The official website for the Tata group, India\'s only value-based corporation. A visionary, a pioneer, a leader, since 1868.', '2021-05-25 00:00:00', 1, 1, '2021-05-26 03:11:59.715551', 1),
(16, 10, 'The Ontario Immigrant Nominee Program ( OINP ) is the province\'s economic immigration program. It works in partnership with the Government of Canada through', '2021-05-25 00:00:00', 0, 0, '2021-05-26 03:12:21.753252', 1),
(18, 11, 'Testing the REST API from postman.', '2021-05-27 00:00:00', 1, 0, '2021-05-28 01:42:06.547886', 1),
(24, 10, 'testestset', '2021-05-29 04:46:46', 1, 0, '2021-05-29 20:46:46.415807', 0),
(25, 10, 'Testing the tweet post from phpunit', '2021-05-29 05:12:29', 1, 0, '2021-05-29 21:12:29.376356', 0),
(26, 10, 'Testing the tweet post from phpunit', '2021-05-29 05:14:21', 2, 0, '2021-05-29 21:14:21.171223', 1),
(27, 10, 'Testing the tweet post from phpunit', '2021-05-29 05:14:53', 1, 0, '2021-05-29 21:14:53.369536', 1),
(28, 10, 'Testing the tweet post from phpunit', '2021-05-29 05:40:26', 3, 0, '2021-05-29 21:40:26.338088', 0),
(29, 10, 'Testing the tweet post from phpunit', '2021-05-29 05:49:16', 0, 0, '2021-05-29 21:49:16.882759', 0),
(30, 10, 'Testing the update tweet functionality from phpunit. Note: Only format acceptable currently is plain text.', '2021-05-29 05:58:48', 1, 1, '2021-05-29 21:58:48.369360', 1),
(31, 10, 'Testing the tweet post from phpunit', '2021-05-29 06:13:23', 0, 0, '2021-05-29 22:13:23.941489', 1),
(32, 10, 'Testing the tweet post from phpunit', '2021-05-29 06:15:13', 0, 0, '2021-05-29 22:15:13.901646', 1),
(33, 10, 'Testing the tweet post from phpunit', '2021-05-29 06:21:25', 1, 0, '2021-05-29 22:21:25.405134', 1),
(34, 10, 'Testing the tweet post from phpunit', '2021-05-29 06:21:47', 1, 0, '2021-05-29 22:21:47.118089', 1),
(35, 10, 'Testing the tweet post from phpunit', '2021-05-29 06:22:18', 2, 0, '2021-05-29 22:22:18.956463', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tweets_retweets_info`
--

CREATE TABLE `tweets_retweets_info` (
  `tr_id` int(200) NOT NULL,
  `tr_tweet_id` int(200) NOT NULL,
  `tr_retweeted_by` int(200) NOT NULL,
  `tr_created_time` datetime NOT NULL,
  `tr_status` int(200) NOT NULL DEFAULT 1,
  `tr_last_action` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tweets_retweets_info`
--

INSERT INTO `tweets_retweets_info` (`tr_id`, `tr_tweet_id`, `tr_retweeted_by`, `tr_created_time`, `tr_status`, `tr_last_action`) VALUES
(1, 15, 10, '2021-05-30 03:00:46', 1, '2021-05-30 07:00:46'),
(2, 30, 10, '2021-05-30 04:03:54', 1, '2021-05-30 08:03:54');

-- --------------------------------------------------------

--
-- Table structure for table `tweet_comments_info`
--

CREATE TABLE `tweet_comments_info` (
  `tc_comment_id` int(200) NOT NULL,
  `tc_tweet_id` int(200) NOT NULL,
  `tc_commented_by` int(200) NOT NULL,
  `tc_comment_date` datetime NOT NULL,
  `tc_comment` varchar(2000) NOT NULL,
  `tc_hasreply` int(200) NOT NULL DEFAULT 0,
  `tc_status` int(11) NOT NULL DEFAULT 1,
  `tc_last_action` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tweet_comments_info`
--

INSERT INTO `tweet_comments_info` (`tc_comment_id`, `tc_tweet_id`, `tc_commented_by`, `tc_comment_date`, `tc_comment`, `tc_hasreply`, `tc_status`, `tc_last_action`) VALUES
(1, 16, 10, '2021-05-30 03:19:49', 'This is a test comment from phpunit', 0, 1, '2021-05-30 07:19:49'),
(2, 8, 10, '2021-05-30 04:03:54', 'This is a test comment from phpunit', 0, 1, '2021-05-30 08:03:54');

-- --------------------------------------------------------

--
-- Table structure for table `tweet_comment_replies`
--

CREATE TABLE `tweet_comment_replies` (
  `tcr_id` int(200) NOT NULL,
  `tcr_tweet_id` int(200) NOT NULL,
  `tcr_parent_comment_id` int(200) NOT NULL,
  `tcr_replied_by` int(200) NOT NULL,
  `tcr_reply_msg` varchar(2000) NOT NULL,
  `tcr_reply_time` datetime NOT NULL,
  `tcr_status` int(200) NOT NULL DEFAULT 1,
  `tcr_last_action` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tweet_comment_replies`
--

INSERT INTO `tweet_comment_replies` (`tcr_id`, `tcr_tweet_id`, `tcr_parent_comment_id`, `tcr_replied_by`, `tcr_reply_msg`, `tcr_reply_time`, `tcr_status`, `tcr_last_action`) VALUES
(1, 16, 1, 10, 'This is a test reply to a comment of a tweet from phpunit', '2021-05-30 03:53:56', 1, '2021-05-30 07:53:56');

-- --------------------------------------------------------

--
-- Table structure for table `tweet_likes_info`
--

CREATE TABLE `tweet_likes_info` (
  `tl_id` int(200) NOT NULL,
  `tl_tweet_id` int(200) NOT NULL,
  `tl_liked_by` int(200) NOT NULL,
  `tl_status` int(200) NOT NULL DEFAULT 1,
  `tl_last_action_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tweet_likes_info`
--

INSERT INTO `tweet_likes_info` (`tl_id`, `tl_tweet_id`, `tl_liked_by`, `tl_status`, `tl_last_action_date`) VALUES
(8, 15, 10, 1, '2021-05-30 08:00:22'),
(9, 18, 10, 1, '2021-05-30 08:00:37'),
(10, 24, 10, 1, '2021-05-30 08:00:46'),
(11, 25, 10, 1, '2021-05-30 08:00:51'),
(12, 33, 10, 1, '2021-05-30 08:01:07'),
(13, 34, 10, 1, '2021-05-30 08:01:12'),
(14, 35, 10, 1, '2021-05-30 08:01:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(200) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_pwd` varchar(200) NOT NULL,
  `user_status` int(200) NOT NULL DEFAULT 1,
  `last_activity` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_pwd`, `user_status`, `last_activity`) VALUES
(9, 'qaz', 'qaz@xyz.com', '8c9231a9282a9760bffc189b4744ddedaa5c2c1c', 1, '2021-05-25 08:19:25.950985'),
(10, 'testuser', 'testuser@xyz.com', '4030575450e474cd809feb4df068a239e2c109fa', 1, '2021-05-26 01:38:58.245679'),
(11, 'apitestuser', 'apitestuser@xyz.com', '20feb9c7b3f75603d6bc0cd5e7447ab375e2606e', 1, '2021-05-28 00:18:01.563597'),
(12, 'abc', 'abc@xyz.com', 'bec75d2e4e2acf4f4ab038144c0d862505e52d07', 1, '2021-05-28 00:28:04.656779'),
(34, 'testuser10', 'testuser10@xyz.com', '4030575450e474cd809feb4df068a239e2c109fa', 1, '2021-05-29 18:13:51.677914'),
(35, 'testuser3', 'testuser3@xyz.com', '4030575450e474cd809feb4df068a239e2c109fa', 1, '2021-05-29 19:41:48.553537'),
(36, 'testuser4', 'testuser4@xyz.com', '4030575450e474cd809feb4df068a239e2c109fa', 1, '2021-05-29 19:44:07.890607');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tweets`
--
ALTER TABLE `tweets`
  ADD PRIMARY KEY (`tw_id`),
  ADD KEY `tw_uid_created` (`tw_uid_created`);

--
-- Indexes for table `tweets_retweets_info`
--
ALTER TABLE `tweets_retweets_info`
  ADD PRIMARY KEY (`tr_id`);

--
-- Indexes for table `tweet_comments_info`
--
ALTER TABLE `tweet_comments_info`
  ADD PRIMARY KEY (`tc_comment_id`),
  ADD KEY `tc_commented_by` (`tc_commented_by`),
  ADD KEY `tc_tweet_id` (`tc_tweet_id`);

--
-- Indexes for table `tweet_comment_replies`
--
ALTER TABLE `tweet_comment_replies`
  ADD PRIMARY KEY (`tcr_id`),
  ADD KEY `tweet_comment_replies_ibfk_1` (`tcr_tweet_id`),
  ADD KEY `tcr_replied_by` (`tcr_replied_by`),
  ADD KEY `tcr_comment_id` (`tcr_parent_comment_id`);

--
-- Indexes for table `tweet_likes_info`
--
ALTER TABLE `tweet_likes_info`
  ADD PRIMARY KEY (`tl_id`),
  ADD KEY `tl_tweet_id` (`tl_tweet_id`),
  ADD KEY `tl_user_id` (`tl_liked_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tweets`
--
ALTER TABLE `tweets`
  MODIFY `tw_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tweets_retweets_info`
--
ALTER TABLE `tweets_retweets_info`
  MODIFY `tr_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tweet_comments_info`
--
ALTER TABLE `tweet_comments_info`
  MODIFY `tc_comment_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tweet_comment_replies`
--
ALTER TABLE `tweet_comment_replies`
  MODIFY `tcr_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tweet_likes_info`
--
ALTER TABLE `tweet_likes_info`
  MODIFY `tl_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tweets`
--
ALTER TABLE `tweets`
  ADD CONSTRAINT `tweets_ibfk_1` FOREIGN KEY (`tw_uid_created`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `tweet_comments_info`
--
ALTER TABLE `tweet_comments_info`
  ADD CONSTRAINT `tweet_comments_info_ibfk_1` FOREIGN KEY (`tc_commented_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `tweet_comments_info_ibfk_2` FOREIGN KEY (`tc_tweet_id`) REFERENCES `tweets` (`tw_id`);

--
-- Constraints for table `tweet_comment_replies`
--
ALTER TABLE `tweet_comment_replies`
  ADD CONSTRAINT `tweet_comment_replies_ibfk_1` FOREIGN KEY (`tcr_tweet_id`) REFERENCES `tweets` (`tw_id`),
  ADD CONSTRAINT `tweet_comment_replies_ibfk_2` FOREIGN KEY (`tcr_replied_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `tweet_comment_replies_ibfk_3` FOREIGN KEY (`tcr_parent_comment_id`) REFERENCES `tweet_comments_info` (`tc_comment_id`);

--
-- Constraints for table `tweet_likes_info`
--
ALTER TABLE `tweet_likes_info`
  ADD CONSTRAINT `tweet_likes_info_ibfk_1` FOREIGN KEY (`tl_tweet_id`) REFERENCES `tweets` (`tw_id`),
  ADD CONSTRAINT `tweet_likes_info_ibfk_2` FOREIGN KEY (`tl_liked_by`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
