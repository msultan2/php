-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 19, 2011 at 08:36 
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tests`
--

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE IF NOT EXISTS `sites` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `site` varchar(15) NOT NULL,
  `menu` varchar(15) NOT NULL,
  `categ` varchar(20) NOT NULL,
  `links` varchar(80) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`id`, `site`, `menu`, `categ`, `links`) VALUES
(1, 'MarPlo.net', 'Courses', 'Ajax', 'www.marplo.net/ajax/obiectul_xmlhttprequest.html'),
(2, 'MarPlo.net', 'Courses', 'Ajax', 'www.marplo.net/ajax/ajax_get_php.html'),
(3, 'MarPlo.net', 'Courses', 'Ajax', 'www.marplo.net/ajax/tutoriale_ajax_json.html'),
(4, 'MarPlo.net', 'Courses', 'JavaScript', 'www.marplo.net/javascript/sintaxajs.html'),
(5, 'MarPlo.net', 'Courses', 'JavaScript', 'www.marplo.net/javascript/notiuni_de_baza.html'),
(6, 'MarPlo.net', 'Courses', 'JavaScript', 'www.marplo.net/javascript/getelementbyid.html'),
(7, 'MarPlo.net', 'Courses', 'English', 'www.marplo.net/engleza/gramatica'),
(8, 'MarPlo.net', 'Courses', 'English', 'www.marplo.net/engleza/exercitii'),
(9, 'MarPlo.net', 'Courses', 'English', 'www.marplo.net/engleza/download_carti-programe-audio'),
(10, 'MarPlo.net', 'Anime', 'Aspecte de viata', 'www.marplo.net/anime/h2o_footprints_sand-a'),
(11, 'MarPlo.net', 'Anime', 'Aspecte de viata', 'www.marplo.net/anime/chobits-a'),
(12, 'MarPlo.net', 'Anime', 'Aspecte de viata', 'www.marplo.net/anime/hayate_no_gotoku-a'),
(13, 'MarPlo.net', 'Anime', 'Comedie', 'www.marplo.net/anime/angel_tales-a'),
(14, 'MarPlo.net', 'Anime', 'Comedie', 'www.marplo.net/anime/my_bride_is_a_mermaid-a'),
(15, 'MarPlo.net', 'Anime', 'Comedie', 'www.marplo.net/anime/nodame_cantabile-a'),
(16, 'MarPlo.net', 'Anime', 'Romantic', 'www.marplo.net/anime/clannad-a'),
(17, 'MarPlo.net', 'Anime', 'Romantic', 'www.marplo.net/anime/bokura_ga_ita-a'),
(18, 'MarPlo.net', 'Anime', 'Romantic', 'www.marplo.net/anime/peach_girl-a'),
(19, 'MarPlo.net', 'Games', 'Aventura-Mistere', 'www.marplo.net/jocuri/misson_to_mars-j'),
(20, 'MarPlo.net', 'Games', 'Aventura-Mistere', 'www.marplo.net/jocuri/prince_of_persia-j'),
(21, 'MarPlo.net', 'Games', 'Aventura-Mistere', 'www.marplo.net/jocuri/river_rapid_rampage-j'),
(22, 'MarPlo.net', 'Games', 'Logica si Intuitie', 'www.marplo.net/jocuri/bloxorz-j'),
(23, 'MarPlo.net', 'Games', 'Logica si Intuitie', 'www.marplo.net/jocuri/flash_chess_3-j'),
(24, 'MarPlo.net', 'Games', 'Logica si Intuitie', 'www.marplo.net/jocuri/red_remover-j'),
(25, 'CoursesWeb.net', 'PHP-MySQL', 'Lessons', 'http://coursesweb.net/php-mysql/writing-php-scripts'),
(26, 'CoursesWeb.net', 'PHP-MySQL', 'Lessons', 'http://coursesweb.net/php-mysql/arrays'),
(27, 'CoursesWeb.net', 'PHP-MySQL', 'Lessons', 'http://coursesweb.net/php-mysql/php-mysql-using-mysqli'),
(28, 'CoursesWeb.net', 'PHP-MySQL', 'Tutorials', 'http://coursesweb.net/php-mysql/file_put_contents-file_get_contents-readfile-file_t'),
(29, 'CoursesWeb.net', 'PHP-MySQL', 'Tutorials', 'http://coursesweb.net/php-mysql/uploading-multiple-files_t'),
(30, 'CoursesWeb.net', 'PHP-MySQL', 'Tutorials', 'http://coursesweb.net/php-mysql/count-number-downloads-accesses_t'),
(31, 'CoursesWeb.net', 'JavaScript', 'Lessons', 'http://coursesweb.net/javascript/variables-operators'),
(32, 'CoursesWeb.net', 'JavaScript', 'Lessons', 'http://coursesweb.net/javascript/document-object-dom'),
(33, 'CoursesWeb.net', 'JavaScript', 'Lessons', 'http://coursesweb.net/javascript/javascript-code-php'),
(34, 'CoursesWeb.net', 'JavaScript', 'Tutorials', 'http://coursesweb.net/javascript/align-make-same-height_t'),
(35, 'CoursesWeb.net', 'JavaScript', 'Tutorials', 'http://coursesweb.net/javascript/check-file-type-before-upload_t'),
(36, 'CoursesWeb.net', 'JavaScript', 'Tutorials', 'http://coursesweb.net/javascript/display-simulate-loading-progress-bar_t'),
(37, 'CoursesWeb.net', 'JavaScript', 'jQuery', 'http://coursesweb.net/jquery/jquery-basics'),
(38, 'CoursesWeb.net', 'JavaScript', 'jQuery', 'http://coursesweb.net/jquery/animating-css-properties'),
(39, 'CoursesWeb.net', 'JavaScript', 'jQuery', 'http://coursesweb.net/jquery/drag-drop'),
(40, 'CoursesWeb.net', 'Flash-AS3', 'Flash Lessons', 'http://coursesweb.net/flash/simple-flash-animation-save-export'),
(41, 'CoursesWeb.net', 'Flash-AS3', 'Flash Lessons', 'http://coursesweb.net/flash/deco-tool'),
(42, 'CoursesWeb.net', 'Flash-AS3', 'Flash Lessons', 'http://coursesweb.net/flash/motion-tween-flash-animation'),
(43, 'CoursesWeb.net', 'Flash-AS3', 'ActionScript Lessons', 'http://coursesweb.net/actionscript/introduction-actionscript-3'),
(44, 'CoursesWeb.net', 'Flash-AS3', 'ActionScript Lessons', 'http://coursesweb.net/actionscript/simple-script-actionscript'),
(45, 'CoursesWeb.net', 'Flash-AS3', 'ActionScript Lessons', 'http://coursesweb.net/actionscript/oop-object-oriented-programming'),
(46, 'CoursesWeb.net', 'Flash-AS3', 'Tutorials', 'http://coursesweb.net/flash/xml-actionscript-php-script_t'),
(47, 'CoursesWeb.net', 'Flash-AS3', 'Tutorials', 'http://coursesweb.net/flash/access-objects-different-timeline_t'),
(48, 'CoursesWeb.net', 'Flash-AS3', 'Tutorials', 'http://coursesweb.net/flash/actionscript-change-movieclip-color_t');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
