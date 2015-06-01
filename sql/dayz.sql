SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(255) DEFAULT NULL,
  `user` varchar(255) NOT NULL DEFAULT '',
  `timestamp` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `users` (
  `id` smallint(8) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `accesslvl` varchar(16) NULL DEFAULT '', 
  `salt` char(3) NOT NULL DEFAULT '',
  `lastlogin` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `users` (`id`, `login`, `password`, `accesslvl`, `salt`, `lastlogin`) VALUES
(1, 'admin', 'e818f0d38a7dadb1ec1d839d46e0b5ca', 'full','5yu', NULL);

CREATE TABLE IF NOT EXISTS `accesslvl` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `access` varchar(128) NOT NULL DEFAULT '[]',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `accesslvl` (`id`, `name`, `access`) VALUES
	(1, 'full', '["true", "true", "true", "true", "true", "true", "true"]'),
	(2, 'semi', '["false", "false", "true", "false", "true", "true", "false"]');

CREATE TABLE IF NOT EXISTS `Object_CLASSES` (
  `Classname` varchar(32) NOT NULL DEFAULT '',
  `Chance` varchar(4) NOT NULL DEFAULT '0',
  `MaxNum` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `Damage` varchar(20) NOT NULL DEFAULT '0',
  `Type` text NOT NULL,
  PRIMARY KEY (`Classname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Object_CLASSES` VALUES
('ATV_CZ_EP1', '0.70', 6, '0.05000', 'atv'),
('car_hatchback', '0.73', 3, '0.05000', 'car'),
('datsun1_civil_3_open', '0.75', 3, '0.05000', 'car'),
('Fishing_Boat', '0.61', 1, '0.05000', 'largeboat'),
('S1203_TK_CIV_EP1', '0.69', 1, '0.05000', 'bus'),
('tractor', '0.7', 1, '0.05000', 'farmvehicle'),
('BAF_Offroad_D', '0.54', 1, '0.05000', 'car'),
('UAZ_Unarmed_TK_EP1', '0.7', 2, '0.05000', 'car'),
('UH1H_DZ', '0.59', 1, '0.05000', 'helicopter'),
('UralCivil2', '0.67', 1, '0.05000', 'truck'),
('V3S_Civ', '0.66', 1, '0.05000', 'truck'),
('Volha_2_TK_CIV_EP1', '0.71', 2, '0.05000', 'car'),
('Ikarus', '0.59', 1, '0.05000', 'bus'),
('ATV_US_EP1', '0.70', 5, '0.05000', 'atv'),
('BAF_Offroad_W', '0.54', 1, '0.05000', 'car'),
('car_sedan', '0.59', 1, '0.05000', 'car'),
('hilux1_civil_1_open', '0.59', 1, '0.05000', 'car'),
('hilux1_civil_2_covered', '0.59', 1, '0.05000', 'car'),
('hilux1_civil_3_open', '0.59', 1, '0.05000', 'car'),
('Ikarus_TK_CIV_EP1', '0.59', 1, '0.05000', 'bus'),
('LandRover_TK_CIV_EP1', '0.59', 1, '0.05000', 'car'),
('MH6J_EP1', '0.32', 1, '0.05000', 'helicopter'),
('Old_bike_TK_CIV_EP1', '0.64', 4, '0.05000', 'bike'),
('Old_bike_TK_INS_EP1', '0.64', 4, '0.05000', 'bike'),
('PBX', '0.59', 1, '0.05000', 'smallboat'),
('Skoda', '0.68', 4, '0.05000', 'car'),
('SkodaBlue', '0.68', 2, '0.05000', 'car'),
('SkodaGreen', '0.68', 1, '0.05000', 'car'),
('Smallboat_1', '0.59', 2, '0.05000', 'mediumboat'),
('Smallboat_2', '0.59', 2, '0.05000', 'mediumboat'),
('SUV_DZ', '0.59', 1, '0.05000', 'car'),
('TentStorage', '0', 0, '0', 'tent'),
('TentStorage1', '0', 0, '0', 'tent'),
('TentStorage2', '0', 0, '0', 'tent'),
('TentStorage3', '0', 0, '0', 'tent'),
('TentStorage4', '0', 0, '0', 'tent'),
('TentStorage5', '0', 0, '0', 'tent'),
('TT650_Ins', '0.72', 2, '0.05000', 'motorcycle'),
('TT650_TK_CIV_EP1', '0.72', 1, '0.05000', 'motorcycle'),
('TT650_TK_EP1', '0.72', 1, '0.05000', 'motorcycle'),
('UAZ_INS', '0.59', 2, '0.05000', 'car'),
('UAZ_RU', '0.59', 1, '0.05000', 'car'),
('UAZ_Unarmed_TK_CIV_EP1', '0.59', 3, '0.05000', 'car'),
('UAZ_Unarmed_UN_EP1', '0.59', 1, '0.05000', 'car'),
('UralCivil', '0.59', 1, '0.05000', 'truck'),
('Mi17_DZ', '0.49', 1, '0.05000', 'helicopter'),
('AN2_DZ', '1', 2, '0.05000', 'plane'),
('Hedgehog_DZ', '0', 0, '0', 'Hedgehog'),
('Wire_cat1', '0', 0, '0', 'wire'),
('Sandbag1_DZ', '0', 0, '0', 'Sandbag'),
('AH6X_DZ', '0.48', 1, '0.05000', 'helicopter'),
('datsun1_civil_1_open', '0.59', 2, '0.05000', 'car'),
('Lada1_TK_CIV_EP1', '0.59', 3, '0.05000', 'car'),
('M1030', '0.58', 2, '0.05000', 'motorcycle'),
('SUV_TK_EP1', '0.39', 1, '0.05000', 'car'),
('VolhaLimo_TK_CIV_EP1', '0.49', 1, '0.05000', 'car'),
('Lada2', '0.59', 2, '0', 'car'),
('hilux1_civil_3_open_EP1', '0.59', 3, '0', 'car'),
('LandRover_CZ_EP1', '0.59', 3, '0', 'car'),
('HMMWV_DZ', '0.21', 2, '0', 'car'),
('MH6J_DZ', '0.48', 1, '0.05000', 'helicopter'),
('StashSmall', '0', 0, '0', 'StashSmall'),
('StashSmall1', '0', 0, '0', 'StashSmall'),
('StashSmall2', '0', 0, '0', 'StashSmall'),
('StashSmall3', '0', 0, '0', 'StashSmall'),
('StashSmall4', '0', 0, '0', 'StashSmall'),
('StashSmall5', '0', 0, '0', 'StashSmall'),
('StashMedium', '0', 0, '0', 'StashMedium'),
('StashMedium1', '0', 0, '0', 'StashMedium'),
('StashMedium2', '0', 0, '0', 'StashMedium'),
('StashMedium3', '0', 0, '0', 'StashMedium'),
('StashMedium4', '0', 0, '0', 'StashMedium'),
('StashMedium5', '0', 0, '0', 'StashMedium'),
('Pickup_PK_INS', '0.10', 1, '0.42500', 'car'),
('WoodenFence_1','0',0,'0','fence'),
('WoodenFence_1_foundation','0',0,'0','fence'),
('WoodenFence_1_frame','0',0,'0','fence'),
('WoodenFence_2','0',0,'0','fence'),
('WoodenFence_3','0',0,'0','fence'),
('WoodenFence_4','0',0,'0','fence'),
('WoodenFence_5','0',0,'0','fence'),
('WoodenFence_6','0',0,'0','fence'),
('WoodenFence_7','0',0,'0','fence'),
('WoodenFence_halfpanel','0',0,'0','fence'),
('WoodenFence_quarterpanel','0',0,'0','fence'),
('WoodenFence_thirdpanel','0',0,'0','fence'),
('WoodenGate_1','0',0,'0','gate'),
('WoodenGate_2','0',0,'0','gate'),
('WoodenGate_3','0',0,'0','gate'),
('WoodenGate_4','0',0,'0','gate'),
('WoodenGate_foundation','0',0,'0','gate');
