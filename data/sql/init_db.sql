CREATE DATABASE IF NOT EXISTS `login_project`;

USE `login_project`;

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL, 
  `password` varchar(32) NOT NULL,
  `email` varchar(128) NOT NULL,
  `birthday` date NOT NULL, 
  `is_admin` TINYINT(1) DEFAULT 0,  
  `age_status` ENUM('underage', 'overage') DEFAULT 'overage',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT uk_username UNIQUE (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user` VALUES 
  (
    null,
    'test',
    md5('test'),
    'test@login.example.com',
    '2000-10-10',
    0,
    null,
    null
  ),
  (
    null,
    'admin',
    md5('admin'),
    'admin@login.example.com',
    '1990-10-10',
    1,
    null,
    null
  )
;
