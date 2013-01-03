-- phpMyAdmin SQL Dump
-- version 3.4.10.2deb1.lucid~ppa.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июл 22 2012 г., 09:27
-- Версия сервера: 5.5.25
-- Версия PHP: 5.2.10-2ubuntu6.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `dayz`
--

-- --------------------------------------------------------

--
-- Структура таблицы `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(255) DEFAULT NULL,
  `user` varchar(255) NOT NULL DEFAULT '',
  `timestamp` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=221 ;

-- --------------------------------------------------------

--
-- Структура таблицы `object_classes`
--

CREATE TABLE IF NOT EXISTS `object_classes` (
  `Classname` varchar(128) NOT NULL DEFAULT '',
  `Type` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`Classname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `object_classes`
--

-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.22 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2013-01-03 12:22:55
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping data for table hivemind.object_classes: 54 rows
/*!40000 ALTER TABLE `object_classes` DISABLE KEYS */;
INSERT INTO `object_classes` (`Classname`, `Type`) VALUES
        ('ATV_CZ_EP1', 'atv'),
        ('car_hatchback', 'car'),
        ('datsun1_civil_3_open', 'car'),
        ('Fishing_Boat', 'largeboat'),
        ('S1203_TK_CIV_EP1', 'bus'),
        ('Tractor', 'farmvehicle'),
        ('BAF_Offroad_D', 'car'),
        ('UAZ_Unarmed_TK_EP1', 'car'),
        ('UH1H_DZ', 'helicopter'),
        ('UralCivil2', 'truck'),
        ('V3S_Civ', 'truck'),
        ('Volha_2_TK_CIV_EP1', 'car'),
        ('Ikarus', 'bus'),
        ('ATV_US_EP1', 'atv'),
        ('BAF_Offroad_W', 'car'),
        ('car_sedan', 'car'),
        ('hilux1_civil_1_open', 'car'),
        ('hilux1_civil_2_covered', 'car'),
        ('hilux1_civil_3_open', 'car'),
        ('Ikarus_TK_CIV_EP1', 'bus'),
        ('LandRover_TK_CIV_EP1', 'car'),
        ('MH6J_EP1', 'helicopter'),
        ('Old_bike_TK_CIV_EP1', 'bike'),
        ('Old_bike_TK_INS_EP1', 'bike'),
        ('PBX', 'smallboat'),
        ('Skoda', 'car'),
        ('SkodaBlue', 'car'),
        ('SkodaGreen', 'car'),
        ('Smallboat_1', 'mediumboat'),
        ('Smallboat_2', 'mediumboat'),
        ('SUV_TK_CIV_EP1', 'car'),
        ('TentStorage', 'tent'),
        ('TT650_Ins', 'motorcycle'),
        ('TT650_TK_CIV_EP1', 'motorcycle'),
        ('TT650_TK_EP1', 'motorcycle'),
        ('UAZ_INS', 'car'),
        ('UAZ_RU', 'car'),
        ('UAZ_Unarmed_TK_CIV_EP1', 'car'),
        ('UAZ_Unarmed_UN_EP1', 'car'),
        ('UralCivil', 'truck'),
        ('Mi17_DZ', 'helicopter'),
        ('AN2_DZ', 'plane'),
        ('Hedgehog_DZ', 'hedgehog'),
        ('Wire_cat1', 'wire'),
        ('Sandbag1_DZ', 'sandbag'),
        ('AH6X_DZ', 'helicopter'),
        ('datsun1_civil_1_open', 'car'),
        ('Lada1_TK_CIV_EP1', 'car'),
        ('M1030', 'motorcycle'),
        ('SUV_TK_EP1', 'car'),
        ('VolhaLimo_TK_CIV_EP1', 'car'),
        ('Lada2', 'car'),
        ('hilux1_civil_3_open_EP1', 'car'),
        ('LandRover_CZ_EP1', 'car');
	
/*!40000 ALTER TABLE `object_classes` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;


-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` smallint(8) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `salt` char(3) NOT NULL DEFAULT '',
  `lastlogin` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `salt`, `lastlogin`) VALUES
(1, 'admin', 'e818f0d38a7dadb1ec1d839d46e0b5ca', '5yu', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
