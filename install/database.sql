DROP TABLE IF EXISTS `tbl_bookmark`;
CREATE TABLE IF NOT EXISTS `tbl_bookmark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipe_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_bookmark_recipe_id` (`recipe_id`),
  KEY `tbl_bookmark_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_carousel`
--

DROP TABLE IF EXISTS `tbl_carousel`;
CREATE TABLE IF NOT EXISTS `tbl_carousel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `sub_title` varchar(255) NOT NULL,
  `image` varchar(255) CHARACTER SET latin1 NOT NULL,
  `status` enum('A','I') CHARACTER SET latin1 NOT NULL DEFAULT 'A' COMMENT '"A=active,I=inactive"',
  `created_on` datetime DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

DROP TABLE IF EXISTS `tbl_category`;
CREATE TABLE IF NOT EXISTS `tbl_category` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  `category_image` text NOT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'A' COMMENT '"A=active ,I=inactive"',
  `created_on` datetime DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment`
--

DROP TABLE IF EXISTS `tbl_comment`;
CREATE TABLE IF NOT EXISTS `tbl_comment` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `recipe_id` int(11) NOT NULL,
 `user_id` int(11) NOT NULL,
 `status` enum('A','I') NOT NULL DEFAULT 'A' COMMENT '"A=active ,I=inactive"',
 `comment` text NOT NULL,
 `comment_type` enum('C','R') NOT NULL DEFAULT 'C' COMMENT '"C=comment,R=reply comment"',
 `comment_reply_id` int(11) NOT NULL,
 `created_on` datetime DEFAULT NULL,
 `updated_on` datetime DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `tbl_comment_user_id` (`user_id`),
 KEY `tbl_comment_recipe_id` (`recipe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact`
--

DROP TABLE IF EXISTS `tbl_contact`;
CREATE TABLE IF NOT EXISTS `tbl_contact` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(100) NOT NULL,
 `email` varchar(100) NOT NULL,
 `message` text NOT NULL,
 `subject` varchar(255) NOT NULL,
 `website` varchar(255) DEFAULT NULL,
 `created_on` datetime DEFAULT NULL,
 `updated_on` datetime DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_email_setting`
--

DROP TABLE IF EXISTS `tbl_email_setting`;
CREATE TABLE IF NOT EXISTS `tbl_email_setting` (
       `id` int(11) NOT NULL AUTO_INCREMENT,
       `smtp_username` varchar(255) NOT NULL,
       `smtp_password` varchar(255) NOT NULL,
       `smtp_host` varchar(255) NOT NULL,
       `smtp_port` varchar(255) NOT NULL,
       `smtp_secure` varchar(255) NOT NULL,
       `email_from_name` varchar(255) NOT NULL,
       `updated_on` datetime DEFAULT NULL,
       PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ingredients`
--

DROP TABLE IF EXISTS `tbl_ingredients`;
CREATE TABLE IF NOT EXISTS `tbl_ingredients` (
     `id` int(11) NOT NULL AUTO_INCREMENT,
     `rid` int(11) NOT NULL,
     `ingredient_name` varchar(100) NOT NULL,
     `qty` float NOT NULL,
     `weight` varchar(100) NOT NULL,
     `created_on` datetime DEFAULT NULL,
     `updated_on` datetime DEFAULT NULL,
     PRIMARY KEY (`id`),
     KEY `tbl_ingredients_recipe_id` (`rid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rating`
--

DROP TABLE IF EXISTS `tbl_rating`;
CREATE TABLE IF NOT EXISTS `tbl_rating` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`recipe_id` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`rating` float NOT NULL,
`created_on` datetime DEFAULT NULL,
`updated_on` datetime DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `tbl_rating_recipe_id` (`recipe_id`),
KEY `tbl_rating_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_recipes`
--

DROP TABLE IF EXISTS `tbl_recipes`;
CREATE TABLE IF NOT EXISTS `tbl_recipes` (
 `rid` int(11) NOT NULL AUTO_INCREMENT,
 `recipes_heading` varchar(255) NOT NULL,
 `cat_id` int(11) NOT NULL,
 `created_by` int(11) NOT NULL,
 `status` enum('A','I') NOT NULL DEFAULT 'A' COMMENT '"A=active ,I=inactive"',
 `recipes_time` int(11) NOT NULL,
 `recipes_image` text NOT NULL,
 `serving_person` int(11) NOT NULL,
 `calories` float NOT NULL,
 `direction` text NOT NULL,
 `summary` text CHARACTER SET utf16 NOT NULL,
 `created_on` datetime DEFAULT NULL,
 `updated_on` datetime DEFAULT NULL,
 PRIMARY KEY (`rid`),
 KEY `tbl_recipes_cat_id` (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_site_config`
--

DROP TABLE IF EXISTS `tbl_site_config`;
CREATE TABLE IF NOT EXISTS `tbl_site_config` (
     `id` int(11) NOT NULL AUTO_INCREMENT,
     `site_name` varchar(255) NOT NULL,
     `site_logo` varchar(100) NOT NULL,
     `site_favicon` varchar(100) DEFAULT NULL,
     `site_phone` varchar(20) DEFAULT NULL,
     `site_email` varchar(100) NOT NULL,
     `time_zone` varchar(255) DEFAULT NULL,
     `head_script` text DEFAULT NULL,
     `header_color` varchar(100) DEFAULT NULL,
     `facebook_url` varchar(255) DEFAULT NULL,
     `google_url` varchar(255) DEFAULT NULL,
     `twitter_url` varchar(255) DEFAULT NULL,
     `instagram_url` varchar(255) DEFAULT NULL,
     `is_facebook_login` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'Y=Yes, N=No',
     `is_google_login` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'Y=Yes, N=No',
     `apikey` text,
     `authdomain` text,
     `databaseurl` text,
     `storagebucket` text,
     PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE IF NOT EXISTS `tbl_user` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_type` enum('A','C') NOT NULL DEFAULT 'C' COMMENT '"A =admin,C=customer"',
`register_type` enum('GENERAL','SSO') NOT NULL DEFAULT 'GENERAL' COMMENT '"GENERAL = General,SSO=single-sign-on"',
`firstname` varchar(100) NOT NULL,
`lastname` varchar(100) NOT NULL,
`status` enum('A','I','EP') NOT NULL DEFAULT 'A' COMMENT '"A=active ,I=inactive,EP=email pending"',
`profile_image` text,
`phone` varchar(15) DEFAULT NULL,
`password` text NOT NULL,
`email` varchar(100) NOT NULL,
`forgot_password_code` varchar(255) DEFAULT NULL,
`forgot_password_time` datetime DEFAULT NULL,
`created_on` datetime DEFAULT NULL,
`updated_on` datetime DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_bookmark`
--
ALTER TABLE `tbl_bookmark`
ADD CONSTRAINT `tbl_bookmark_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `tbl_recipes` (`rid`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `tbl_bookmark_user_id` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
ADD CONSTRAINT `tbl_comment_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `tbl_recipes` (`rid`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `tbl_comment_user_id` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_ingredients`
--
ALTER TABLE `tbl_ingredients`
ADD CONSTRAINT `tbl_ingredients_recipe_id` FOREIGN KEY (`rid`) REFERENCES `tbl_recipes` (`rid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_rating`
--
ALTER TABLE `tbl_rating`
ADD CONSTRAINT `tbl_rating_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `tbl_recipes` (`rid`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `tbl_rating_user_id` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_recipes`
--
ALTER TABLE `tbl_recipes`
ADD CONSTRAINT `tbl_recipes_cat_id` FOREIGN KEY (`cat_id`) REFERENCES `tbl_category` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `tbl_user` (`id`,`user_type`,`firstname`, `lastname`, `email`, `password`,`status`, `created_on`)
VALUES (NULL,'A','admin_first_name','admin_last_name', 'admin_email', 'admin_password','A',NULL);

INSERT INTO `tbl_email_setting` (`id`,`email_from_name`,`smtp_host`, `smtp_username`, `smtp_password`, `smtp_port`, `smtp_secure`)
VALUES (NULL,'email_email_from','email_smtp_host', 'email_smtp_username', 'email_smtp_password', 'email_smtp_port', 'email_smtp_secure');

INSERT INTO `tbl_site_config` (`id`,`site_logo`, `site_name`, `site_email`, `time_zone`)
VALUES (NULL,'site_setting_company_logo','site_setting_company_name', 'site_setting_company_email','Asia/Kolkata');
COMMIT;

