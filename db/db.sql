/* Database structure of jetbird_new generated by Jetbird's database_handler class on 2009-06-19T13:17:26+02:00 */

CREATE DATABASE `jetbird` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `jetbird`;

CREATE TABLE IF NOT EXISTS `attachment_list` (
  `attachment_id` bigint(20) unsigned NOT NULL auto_increment,
  `attachment_owner` int(11) unsigned NOT NULL,
  `attachment_file` varchar(40) NOT NULL,
  `attachment_original_name` varchar(256) NOT NULL,
  `attachment_type` varchar(32) NOT NULL,
  `attachment_size` int(32) NOT NULL default '0',
  `attachment_date` int(11) NOT NULL default '0',
  PRIMARY KEY  (`attachment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` bigint(20) unsigned NOT NULL auto_increment,
  `comment_parent_post_id` bigint(20) unsigned NOT NULL,
  `comment_author` varchar(32) NOT NULL,
  `comment_author_email` varchar(64) NOT NULL,
  `comment_author_url` varchar(64) NOT NULL,
  `comment_author_ip` varchar(15) NOT NULL,
  `comment_date` int(11) unsigned NOT NULL,
  `comment_content` text NOT NULL,
  `comment_session_id` varchar(32) NOT NULL,
  PRIMARY KEY  (`comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `post` (
  `post_id` bigint(20) unsigned NOT NULL auto_increment,
  `post_author` int(11) unsigned NOT NULL,
  `post_date` int(11) unsigned NOT NULL,
  `post_title` text character set utf8 NOT NULL,
  `post_content` longtext character set utf8 NOT NULL,
  `comment_status` enum('open','closed') character set utf8 NOT NULL,
  PRIMARY KEY  (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `search_cache` (
  `search_key` text character set utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `search_index` (
  `id` int(11) NOT NULL auto_increment,
  `word` text character set utf8 NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `search_word` (
  `word_id` text NOT NULL,
  `post_id` text NOT NULL,
  `weight` int(11) NOT NULL default '0',
  `group_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` bigint(20) unsigned NOT NULL auto_increment,
  `user_name` varchar(32) NOT NULL,
  `user_pass` varchar(32) NOT NULL,
  `user_mail` varchar(32) NOT NULL,
  `user_level` tinyint(1) NOT NULL,
  `user_reg_key` varchar(32) NOT NULL,
  `user_last_login` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `user_session` (
  `user_session_id` bigint(20) unsigned NOT NULL auto_increment,
  `user_session_key` varchar(13) NOT NULL,
  `user_session_uid` bigint(20) unsigned NOT NULL,
  `user_session_age` int(11) NOT NULL,
  PRIMARY KEY  (`user_session_id`),
  UNIQUE KEY `user_session_key` (`user_session_key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

