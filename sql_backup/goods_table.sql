-- phpMyAdmin SQL Dump
-- version 4.2.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016 年 7 月 07 日 19:05
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
-- テーブルの構造 `goods_table`
--

CREATE TABLE IF NOT EXISTS `goods_table` (
`goods_id` int(11) NOT NULL,
  `goods_name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- テーブルのデータのダンプ `goods_table`
--

INSERT INTO `goods_table` (`goods_id`, `goods_name`, `price`) VALUES
(1, 'コーラ', 100),
(2, 'USB', 2000),
(3, '傘', 300),
(4, 'お茶', 100),
(5, '寿司', 100);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `goods_table`
--
ALTER TABLE `goods_table`
 ADD PRIMARY KEY (`goods_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `goods_table`
--
ALTER TABLE `goods_table`
MODIFY `goods_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
