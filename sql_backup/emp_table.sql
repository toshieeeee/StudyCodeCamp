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
-- テーブルの構造 `emp_table`
--

CREATE TABLE IF NOT EXISTS `emp_table` (
`emp_id` int(11) NOT NULL,
  `emp_name` varchar(100) NOT NULL,
  `job` varchar(100) NOT NULL,
  `age` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- テーブルのデータのダンプ `emp_table`
--

INSERT INTO `emp_table` (`emp_id`, `emp_name`, `job`, `age`) VALUES
(1, '山田太郎', ' manager', 50),
(2, '伊藤静香', ' manager', 45),
(3, '鈴木三郎', 'analyst', 30),
(4, '山田花子', 'clerk', 24);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emp_table`
--
ALTER TABLE `emp_table`
 ADD PRIMARY KEY (`emp_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emp_table`
--
ALTER TABLE `emp_table`
MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
