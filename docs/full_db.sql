-- -----------------------------------------------------
-- Table `ci_sessions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ci_sessions` ;

CREATE  TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` VARCHAR(40) NOT NULL DEFAULT '0' ,
  `ip_address` VARCHAR(16) NOT NULL DEFAULT '0' ,
  `user_agent` VARCHAR(120) NOT NULL ,
  `last_activity` INT(10) UNSIGNED NOT NULL DEFAULT '0' ,
  `user_data` TEXT NOT NULL ,
  PRIMARY KEY (`session_id`) ,
  INDEX `last_activity_idx` (`last_activity` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `meta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `meta` ;

CREATE  TABLE IF NOT EXISTS `meta` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `first_name` VARCHAR(50) NOT NULL ,
  `last_name` VARCHAR(50) NOT NULL ,
  `address` TEXT NOT NULL ,
  `city` VARCHAR(45) NOT NULL ,
  `state` VARCHAR(2) NOT NULL ,
  `zip` VARCHAR(9) NOT NULL ,
  `phone` VARCHAR(14) NULL ,
  PRIMARY KEY (`user_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `users` ;

CREATE  TABLE IF NOT EXISTS `users` (
  `user_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(15) NOT NULL ,
  `password` VARCHAR(50) NOT NULL ,
  `email` VARCHAR(255) NOT NULL ,
  `active` TINYINT(1) NOT NULL ,
  `created_on` DATETIME NOT NULL ,
  `last_login` DATETIME NOT NULL ,
  `ip_address` VARCHAR(16) NOT NULL ,
  PRIMARY KEY (`user_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `codes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `codes` ;

CREATE  TABLE IF NOT EXISTS `codes` (
  `code_id` VARCHAR(40) NOT NULL ,
  `code_type` CHAR(1) NOT NULL ,
  `user_id` INT(11) NOT NULL ,
  `expires_on` DATETIME NOT NULL ,
  PRIMARY KEY (`code_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `groups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `groups` ;

CREATE  TABLE IF NOT EXISTS `groups` (
  `group_id` MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(20) NOT NULL ,
  `description` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`group_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `permissions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `permissions` ;

CREATE  TABLE IF NOT EXISTS `permissions` (
  `permission_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `ctrl_id` INT(11) NOT NULL ,
  `group_id` INT(11) NOT NULL ,
  PRIMARY KEY (`permission_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `controller`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `controller` ;

CREATE  TABLE IF NOT EXISTS `controller` (
  `ctrl_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `ctrl_uri` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`ctrl_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `user_groups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `user_groups` ;

CREATE  TABLE IF NOT EXISTS `user_groups` (
  `ug_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `user_id` INT(11) NOT NULL ,
  `group_id` INT(11) NOT NULL ,
  PRIMARY KEY (`ug_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `gallery`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gallery` ;

CREATE  TABLE IF NOT EXISTS `gallery` (
  `gallery_id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `public` TINYINT(1) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`gallery_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `images`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `images` ;

CREATE  TABLE IF NOT EXISTS `images` (
  `image_id` INT NOT NULL AUTO_INCREMENT ,
  `filename` VARCHAR(100) NOT NULL ,
  `caption` VARCHAR(255) NULL ,
  PRIMARY KEY (`image_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `gallery_image`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gallery_image` ;

CREATE  TABLE IF NOT EXISTS `gallery_image` (
  `gi_id` INT NOT NULL AUTO_INCREMENT ,
  `gallery_id` INT NOT NULL ,
  `image_id` INT NOT NULL ,
  PRIMARY KEY (`gi_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;;


-- -----------------------------------------------------
-- Table `page`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `page` ;

CREATE  TABLE IF NOT EXISTS `page` (
  `page_id` INT NOT NULL AUTO_INCREMENT ,
  `page_name` VARCHAR(100) NOT NULL ,
  `stub` VARCHAR(100) NULL ,
  `page` TEXT NOT NULL ,
  PRIMARY KEY (`page_id`) ,
  UNIQUE INDEX `stub_UNIQUE` (`stub` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `tags`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tags` ;

CREATE  TABLE IF NOT EXISTS `tags` (
  `tag_id` INT NOT NULL AUTO_INCREMENT ,
  `tag` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`tag_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `image_tags`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `image_tags` ;

CREATE  TABLE IF NOT EXISTS `image_tags` (
  `it_id` INT NOT NULL AUTO_INCREMENT ,
  `image_id` INT NOT NULL ,
  `tag_id` INT NOT NULL ,
  PRIMARY KEY (`it_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

--
-- Dumping data for table `controller`
--

INSERT INTO `controller` (`ctrl_id`, `ctrl_uri`) VALUES
(1, 'admin'),
(2, 'client'),
(3, 'member');

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'client', 'Client'),
(3, 'member', 'Member');

--
-- Dumping data for table `meta`
--

INSERT INTO `meta` (`user_id`, `first_name`, `last_name`) VALUES
(1, 'Admin', 'Admin');

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permission_id`, `ctrl_id`, `group_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 2, 2),
(5, 3, 2),
(6, 3, 3);

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `active`, `created_on`, `last_login`, `ip_address`) VALUES
(1, 'admin', 'e68093aeea23cb419e8cef806d3df8dfc322dd03bb2f6842fb', 'adminemail@something.com', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '000.000.000.000');


--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`ug_id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 3);

