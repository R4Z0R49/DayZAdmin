CREATE TABLE IF NOT EXISTS `accesslvl` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `access` varchar(128) NOT NULL DEFAULT '[]',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `accesslvl` (`id`, `name`, `access`) VALUES
	(1, 'full', '["true", "true", "true", "true", "true", "true", "true"]'),
	(2, 'semi', '["false", "false", "true", "false", "true", "true", "false"]');