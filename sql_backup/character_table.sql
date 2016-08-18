-- phpMyAdmin SQL Dump
-- version 4.2.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016 年 7 月 08 日 15:12
-- サーバのバージョン： 5.6.20-log
-- PHP Version: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `codecamp10334`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `character_table`
--

CREATE TABLE IF NOT EXISTS `character_table` (
`character_id` int(11) NOT NULL,
  `character_name` varchar(100) NOT NULL,
  `pref` varchar(100) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- テーブルのデータのダンプ `character_table`
--

INSERT INTO `character_table` (`character_id`, `character_name`, `pref`) VALUES
(1, 'ふなっしー', '千葉県'),
(2, 'ひこにゃん', '滋賀県'),
(3, 'まりもっこり', '北海道');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `character_table`
--
ALTER TABLE `character_table`
 ADD PRIMARY KEY (`character_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `character_table`
--
ALTER TABLE `character_table`
MODIFY `character_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
