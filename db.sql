-- phpMyAdmin SQL Dump
-- version 2.10.0.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Aug 16, 2010 at 02:38 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.4-2ubuntu5.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `ach`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `chat_log`
-- 

CREATE TABLE `chat_log` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL default '0',
  `chat` text NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=238 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `comments`
-- 

CREATE TABLE `comments` (
  `id` int(11) NOT NULL auto_increment,
  `project_id` int(11) NOT NULL,
  `evidence_id` int(11) NOT NULL,
  `hypothesis_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `classification` enum('U','C','S','TS') NOT NULL,
  `caveat` enum('','FOUO','SI','TK','HCS','G') default NULL,
  `reply_to_id` int(11) NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=89 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `credibility`
-- 

CREATE TABLE `credibility` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `evidence_id` int(11) default NULL,
  `value` enum('0','y','n') default '0',
  `added` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `weight` float default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2628 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `evidence`
-- 

CREATE TABLE `evidence` (
  `id` int(11) NOT NULL auto_increment,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `classification` enum('U','C','S','TS','Compartmented') NOT NULL,
  `caveat` enum('','FOUO','SI','TK','HCS','G') default NULL,
  `type` varchar(255) NOT NULL,
  `serial_number` varchar(255) NOT NULL,
  `date_of_source` datetime NOT NULL,
  `code` varchar(255) NOT NULL,
  `flag` varchar(1) NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `deleted` enum('n','y') NOT NULL default 'n',
  `diag` float default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2176 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `hypotheses`
-- 

CREATE TABLE `hypotheses` (
  `id` int(11) NOT NULL auto_increment,
  `label` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `deleted` enum('n','y') NOT NULL default 'n',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=855 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `invitation_notices`
-- 

CREATE TABLE `invitation_notices` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `by_user_id` int(11) default NULL,
  `project_id` int(11) default NULL,
  `type` varchar(31) default NULL,
  `message` varchar(255) default NULL,
  `displayed` varchar(11) default 'n',
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `join_requests`
-- 

CREATE TABLE `join_requests` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `load_times`
-- 

CREATE TABLE `load_times` (
  `id` int(11) NOT NULL auto_increment,
  `url` varchar(255) default NULL,
  `load_time` float default NULL,
  `queries` int(11) default NULL,
  `when` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `flag` varchar(255) default 'BEFORE OPTIMIZATION',
  `user_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23569 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `projects`
-- 

CREATE TABLE `projects` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  `classification` enum('U','C','S','TS') NOT NULL,
  `public` enum('n','y') NOT NULL default 'n',
  `open` varchar(1) NOT NULL default 'y',
  `directory` enum('y','n') default NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=233 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ratings`
-- 

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL auto_increment,
  `hypothesis_id` int(11) NOT NULL,
  `evidence_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17887 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) default NULL,
  `unclassified_phone` varchar(64) NOT NULL,
  `secure_phone` varchar(64) NOT NULL,
  `office` varchar(255) NOT NULL,
  `office_desc` text NOT NULL,
  `classification` varchar(64) NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `users_active`
-- 

CREATE TABLE `users_active` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `last_visited` datetime NOT NULL,
  `last_page` text NOT NULL,
  `color` varchar(16) NOT NULL default '000000',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=72 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `users_in_projects`
-- 

CREATE TABLE `users_in_projects` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=185 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `users_in_projects_view_only`
-- 

CREATE TABLE `users_in_projects_view_only` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;
