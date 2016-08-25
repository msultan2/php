-- --------------------------------------------------------
-- Host:                         CNPVAS04
-- Server version:               5.6.21-enterprise-commercial-advanced-log - MySQL Enterprise Server - Advanced Edition (Commercial)
-- Server OS:                    solaris11
-- HeidiSQL Version:             8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for NotesTool
CREATE DATABASE IF NOT EXISTS `NotesTool` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `NotesTool`;


-- Dumping structure for table NotesTool.meetings
CREATE TABLE IF NOT EXISTS `meetings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `person_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=152 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table NotesTool.meetings: 13 rows
/*!40000 ALTER TABLE `meetings` DISABLE KEYS */;
INSERT INTO `meetings` (`id`, `name`, `date`, `person_ID`) VALUES
	(151, 'meet', '2015-12-13 00:00:00', NULL),
	(150, 'expansion', '2015-11-25 00:00:00', NULL),
	(149, 'michel', '2015-11-25 00:00:00', NULL),
	(148, 'netcool  system integration ', '2015-11-24 00:00:00', NULL),
	(147, 'backbone', '2015-11-23 00:00:00', NULL),
	(146, 'access and back hall', '2015-11-22 00:00:00', NULL),
	(145, 'discovery', '2015-11-22 00:00:00', NULL),
	(144, 'discovery sameer ', '2015-11-22 00:00:00', NULL),
	(142, 'hiossam', '2015-11-19 00:00:00', NULL),
	(141, 'fady is eating ', '2015-11-18 00:00:00', NULL),
	(138, 'Mokatam followup ', '2015-11-17 00:00:00', NULL),
	(143, 'mokatam follow up ', '2015-11-22 00:00:00', NULL),
	(140, 'integration and modelling ', '2015-11-18 00:00:00', NULL);
/*!40000 ALTER TABLE `meetings` ENABLE KEYS */;


-- Dumping structure for table NotesTool.notes
CREATE TABLE IF NOT EXISTS `notes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `text` varchar(2000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `color` enum('yellow','blue','green') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yellow',
  `xyz` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `insertionDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dragged` bit(1) NOT NULL DEFAULT b'0',
  `person_ID` int(10) unsigned DEFAULT NULL,
  `meeting_ID` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=527 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table NotesTool.notes: 69 rows
/*!40000 ALTER TABLE `notes` DISABLE KEYS */;
INSERT INTO `notes` (`id`, `text`, `name`, `color`, `xyz`, `insertionDate`, `dragged`, `person_ID`, `meeting_ID`) VALUES
	(199, 'site parameter  : site name -unique ,option  -nominal - ,location  points  ', 'mahmoudauthor', 'blue', '0x192x14', '2015-11-17 11:51:17', b'1', 118, 138),
	(180, 'meeting is mahmoud darwish  and sameer and 2 indian guys  ', 'mahmoudauthor', 'blue', '0x0x1', '2015-11-17 10:20:32', b'0', NULL, 138),
	(181, '\nmahmoud darwish : cell name is unique in network ans celll id is unique in vendor domain ', 'mahmoudauthor', 'blue', '0x0x4', '2015-11-17 10:21:15', b'0', NULL, 138),
	(182, 'mahmoud Darwish :i genetarte sf1 3 6 - > i recieve 2 (rollout)and 4(legal) ', 'mahmoudauthor', 'blue', '0x0x5', '2015-11-17 10:32:46', b'0', NULL, 138),
	(183, 'mahmoud Darwish :sf2 is choosing between different sites  ', 'mahmoudauthor', 'blue', '0x0x6', '2015-11-17 10:33:04', b'0', NULL, 138),
	(184, '\nsf3 site contain sector number orientation and long latit ', 'mahmoudauthor', 'blue', '0x0x7', '2015-11-17 10:39:01', b'0', NULL, 138),
	(185, '\nsf1 site and location > sf2 approve  ', 'mahmoudauthor', 'blue', '0x0x8', '2015-11-17 10:45:09', b'0', NULL, 138),
	(186, 'sf6  -> base band radio unit antenna type and num cabinet type and num ', 'mahmoudauthor', 'blue', '0x0x9', '2015-11-17 10:46:57', b'0', 118, 138),
	(187, 'data warehouse is dependes on sf6 count ant type ', 'mahmoudauthor', 'blue', '0x0x10', '2015-11-17 10:49:38', b'0', 118, 138),
	(188, 'sf1 is document  we need asite ', 'mahmoudauthor', 'blue', '0x0x11', '2015-11-17 11:12:14', b'0', 118, 138),
	(189, '\nsf3 is the status  of the option (reject or accept )', 'mahmoudauthor', 'blue', '0x0x12', '2015-11-17 11:28:48', b'0', 118, 138),
	(190, '\nsf4 is how it will be connected to transmission  ', 'mahmoudauthor', 'blue', '0x0x13', '2015-11-17 11:29:14', b'0', 118, 138),
	(191, '\nsf5 is legal -> if falied bac to sf2 with new option  ', 'mahmoudauthor', 'blue', '0x0x14', '2015-11-17 11:30:13', b'0', 118, 138),
	(192, '\nsf1  -> is just adream ', 'mahmoudauthor', 'blue', '0x0x15', '2015-11-17 11:30:21', b'0', 118, 138),
	(193, 'sf2 is create for each option  coming from roll out  ', 'mahmoudauthor', 'blue', '0x0x16', '2015-11-17 11:31:06', b'0', 118, 138),
	(194, 'there is aproblem relate to where the data will be exist in remedy or nim so they will go to change it there  ', 'mahmoudauthor', 'blue', '0x117x16', '2015-11-17 11:31:52', b'0', NULL, 138),
	(195, 'they will decide which data will be moved to nim  \n\n', 'mahmoudauthor', 'blue', '0x0x11', '2015-11-17 11:34:38', b'0', NULL, 138),
	(196, '\nmahmoud Darwish : we need site status ( planned status under-integration - accepted -life )', 'mahmoudauthor', 'blue', '0x0x12', '2015-11-17 11:37:40', b'0', NULL, 138),
	(197, 'under integaration -> rx tx and roll out done  and needed to be activated  ', 'mahmoudauthor', 'blue', '0x307x15', '2015-11-17 11:42:11', b'0', NULL, 138),
	(200, 'sf6 can be changed across  differenr teams but they tring to close the gab between radion and implementation team  ', 'mahmoudauthor', 'blue', '0x103x13', '2015-11-17 11:52:24', b'1', 118, 138),
	(216, 'mahmoud ibrahim ,khazbak ,disscusss triggers when adding new site ', 'mahmoudauthor', 'blue', '0x0x29', '2015-11-18 10:40:10', b'0', NULL, 140),
	(221, 'nts usage triggers - Access part Triggers -> roolout new site -los -reengineering-offload-expansion radio -enterprise  -utilization ', 'mahmoudauthor', 'blue', '0x188x25', '2015-11-18 12:35:16', b'0', NULL, 140),
	(222, 'rullout -> sf1 evolved if tx active repeater (MW Site for signal regeneration ) or new hub(sf1 owner transmission hub )                                             sf3 received to give matrix ', 'mahmoudauthor', 'blue', '0x235x24', '2015-11-18 12:40:22', b'0', NULL, 140),
	(218, 'for bts -> ip1 2gT&M BSC ,ip2 3gT RNC ,ip3 3g M RNC oss ', 'mahmoudauthor', 'blue', '0x187x27', '2015-11-18 11:20:50', b'0', NULL, 140),
	(219, 'oss in zahraa and nms in HQ (Head quarter )\n', 'mahmoudauthor', 'blue', '0x423x23', '2015-11-18 11:22:35', b'0', NULL, 140),
	(220, 'D2D Tasks  between transmission and radio                                             1 -new site activation 2g 3g 2- radio expansion fpr existing site ipran conversion(managment 2 3 g ips) 3-LOS we require to chanaange the hub site 4 utilization traffic increase 5-ran cutovers - transport assignning the ips\n', 'mahmoudauthor', 'blue', '0x176x26', '2015-11-18 11:27:52', b'0', NULL, 140),
	(224, 'sf3 is responsable to choose site location based on some calculations related to the nerby sites and hub and choose one according to the capacity availability in sites  ', 'mahmoudauthor', 'blue', '0x0x11', '2015-11-18 13:03:55', b'1', NULL, 138),
	(239, 'vlaan is unique per hub not network ', 'mahmoudauthor', 'blue', '0x0x2', '2015-11-22 14:47:16', b'0', NULL, 143),
	(238, 'ibrahim mahmoud siad he has full design documentation for backhall', 'mahmoudauthor', 'blue', '0x0x1', '2015-11-22 14:07:17', b'0', NULL, 143),
	(279, 'RO implemetation -> rf imp - tx imp civil } upgrade \n', 'mahmoudauthor', 'blue', '0x0x4', '2015-11-25 13:33:20', b'0', 0, 150),
	(280, '\nrollout is new site forn scratch upgrade is to add to exastance site  ', 'mahmoudauthor', 'blue', '0x0x5', '2015-11-25 13:33:41', b'0', 0, 150),
	(232, '\n3ui4yri4ytiy5t6y', 'mahmoudauthor', 'blue', '0x0x4', '2015-11-18 15:07:54', b'0', 118, 141),
	(240, 'they still working on access and will go to back halll ', 'mahmoudauthor', 'blue', '0x0x1', '2015-11-23 10:04:12', b'0', NULL, 146),
	(241, 'transmission trigers  they finished rollout re engineering expansion los offloa \n', 'mahmoudauthor', 'blue', '0x211x21', '2015-11-23 10:10:01', b'0', NULL, 146),
	(242, '\nreduce cascaded site in some sites re build the topology based on bas performance and expansion needed  ', 'mahmoudauthor', 'blue', '74x52x20', '2015-11-23 10:10:54', b'0', NULL, 146),
	(243, '\nreengineering-> triggers complex topology ans cascading - LTE tech - spectrum high capacity -los ', 'mahmoudauthor', 'blue', '220x354x18', '2015-11-23 10:14:54', b'0', NULL, 146),
	(244, '\noffload site we need to load it\'s sites to other cascading sites ', 'mahmoudauthor', 'blue', '420x338x17', '2015-11-23 10:15:15', b'0', NULL, 146),
	(245, '\nthey have no limits for hubs so in high way they have more hubs but usually they have 4 or 5 hubs  ', 'mahmoudauthor', 'blue', '752x353x16', '2015-11-23 10:17:36', b'0', NULL, 146),
	(246, '\nfor new technology the have limits for delay ', 'mahmoudauthor', 'blue', '535x161x13', '2015-11-23 10:20:30', b'0', NULL, 146),
	(247, 'spectrum -> trigeer when he has now band to cover anew link ', 'mahmoudauthor', 'blue', '260x129x10', '2015-11-23 10:46:29', b'0', NULL, 146),
	(248, 'system interaction between netcool -> and other systems  ', 'mahmoudauthor', 'blue', '984x366x15', '2015-11-24 10:05:52', b'0', NULL, 148),
	(249, '\nhow much it handle and database  ', 'mahmoudauthor', 'blue', '0x370x18', '2015-11-24 10:06:16', b'1', NULL, 148),
	(250, '\nand events received from network ', 'mahmoudauthor', 'blue', '273x63x16', '2015-11-24 10:07:10', b'1', NULL, 148),
	(251, 'define events and parameters they use corba integration and some smnp and gatways and remeedy ', 'mahmoudauthor', 'blue', '426x54x19', '2015-11-24 10:08:57', b'0', NULL, 147),
	(252, 'define events and parameters they use corba integration and some smnp and gatways and remeedy', 'mahmoudauthor', 'blue', '994x0x10', '2015-11-24 10:10:10', b'0', NULL, 148),
	(271, 'uyiuyiu', 'mahmoudauthor', 'blue', '0x0x1', '2015-11-25 09:27:06', b'0', 0, 149),
	(256, 'erferetre', 'mahmoudauthor', 'blue', '0x0x14', '2015-11-24 14:25:58', b'0', NULL, NULL),
	(255, 'fdghytdytdyt', 'mahmoudauthor', 'blue', '1057x21x16', '2015-11-24 14:24:19', b'0', NULL, NULL),
	(273, '\niuyiy', 'mahmoudauthor', 'blue', '0x0x3', '2015-11-25 09:27:08', b'0', 0, 149),
	(277, '\nwhat are u doing ?', 'mahmoudauthor', 'blue', '0x0x2', '2015-11-25 13:26:35', b'0', 0, 150),
	(276, 'process and scopt of implametation and data format and input and output data  ', 'mahmoudauthor', 'blue', '0x0x1', '2015-11-25 13:26:19', b'0', 0, 150),
	(281, 'implemetation  is ow to impl link with yteam insite you must have core network back hall tx is available in that site  \nrf imp> ipran -', 'mahmoudauthor', 'blue', '0x0x6', '2015-11-25 13:34:47', b'0', 0, 150),
	(272, '\niuiti', 'mahmoudauthor', 'blue', '0x0x2', '2015-11-25 09:27:07', b'0', 0, 149),
	(278, '\nepansion and upgraed civil work ', 'mahmoudauthor', 'blue', '0x0x3', '2015-11-25 13:27:55', b'0', 0, 150),
	(282, '\ntriher points  -> work owder from radio by mail and they exexute with remedy ', 'mahmoudauthor', 'blue', '0x0x7', '2015-11-25 13:36:14', b'0', 0, 150),
	(283, '\nprq -> planneing request radio->remedy- (num of site and action needed )', 'mahmoudauthor', 'blue', '0x0x8', '2015-11-25 13:37:33', b'0', 0, 150),
	(284, '\nradio is the customer - ipran project  -> 2 teams  1- back hall -tx planning -> for high level sssisment from tx point of view  ', 'mahmoudauthor', 'blue', '0x0x9', '2015-11-25 13:39:15', b'0', 0, 150),
	(285, 'tx planning  -> issue crq  -> backhall -> crq  -> for confirm that site is ready  \n', 'mahmoudauthor', 'blue', '0x0x10', '2015-11-25 13:40:15', b'0', 0, 150),
	(286, '\nsite is ready by email  -> 2nd procedd to create circuit for site to insure capacity -> back to - RO -> ', 'mahmoudauthor', 'blue', '0x0x11', '2015-11-25 13:51:55', b'0', 0, 150),
	(287, '\nthey iniate crq for halting to make  site is down - > change mang team to approve crq  -> radio team  ', 'mahmoudauthor', 'blue', '0x0x12', '2015-11-25 13:57:40', b'0', 0, 150),
	(288, '\nipran -> to make 2g not working in tdm working in ip ???/', 'mahmoudauthor', 'blue', '0x0x13', '2015-11-25 13:58:11', b'0', 0, 150),
	(289, 'the finish their work with integration  -> \n', 'mahmoudauthor', 'blue', '0x0x14', '2015-11-25 14:27:58', b'0', 0, 150),
	(290, 'operation support  \nnew site rollout  -> recieve cell task on remedy crq is comming and assigned to team  ->a ctivate blew cells  ', 'mahmoudauthor', 'blue', '0x0x15', '2015-11-25 14:52:38', b'0', 0, 150),
	(291, '\nheck cells and confirm and reject if aproblem in any celll ', 'mahmoudauthor', 'blue', '0x0x16', '2015-11-25 14:53:28', b'0', 0, 150),
	(378, 'grt\nrtrtr\n', 'mahmoudauthor', 'blue', '0x0x1', '2015-12-13 09:56:20', b'0', 0, 151),
	(526, '\n', 'mahmoudauthor', 'yellow', '0x0x1037', '2015-12-16 09:18:30', b'0', 0, 0),
	(525, '\n', 'mahmoudauthor', 'yellow', '0x0x1036', '2015-12-16 09:18:30', b'0', 0, 0),
	(521, 'fdsfsfsdfsdfsf\n', 'mahmoudauthor', 'yellow', '998x257x1038', '2015-12-16 09:17:09', b'1', 0, 0),
	(524, '\n', 'mahmoudauthor', 'yellow', '0x0x1034', '2015-12-16 09:17:50', b'0', 0, 0);
/*!40000 ALTER TABLE `notes` ENABLE KEYS */;


-- Dumping structure for table NotesTool.profiles
CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `desc` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=119 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table NotesTool.profiles: 2 rows
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` (`id`, `name`, `date`, `desc`) VALUES
	(118, 'mahmoud darwish ', '2015-11-17 10:44:51', 'radio planning '),
	(117, 'mamoud', '2015-11-15 15:00:05', 'prog');
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
