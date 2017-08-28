-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- 主機: 127.0.0.1
-- 產生時間： 2017-08-15 05:04:11
-- 伺服器版本: 10.1.25-MariaDB
-- PHP 版本： 7.0.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `leave`
--

-- --------------------------------------------------------

--
-- 資料表結構 `configs`
--

DROP TABLE IF EXISTS `configs`;
CREATE TABLE `configs` (
  `id` int(7) NOT NULL,
  `config_key` varchar(20) NOT NULL COMMENT 'config關鍵字',
  `config_value` varchar(100) NOT NULL COMMENT '數值',
  `comment` varchar(50) NOT NULL COMMENT '備註'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `holidays`
--

DROP TABLE IF EXISTS `holidays`;
CREATE TABLE `holidays` (
  `id` int(7) NOT NULL,
  `type` enum('work','holiday') NOT NULL DEFAULT 'holiday' COMMENT '補班/國定假日',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `leaves`
--

DROP TABLE IF EXISTS `leaves`;
CREATE TABLE `leaves` (
  `id` int(7) NOT NULL,
  `user_id` int(7) NOT NULL COMMENT '請假人',
  `type_id` int(7) NOT NULL COMMENT '假別',
  `tag_id` int(7) NOT NULL COMMENT '目前狀態',
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '開始時間',
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '結束時間',
  `hours` int(7) NOT NULL COMMENT '請假總時數',
  `reason` varchar(50) DEFAULT NULL COMMENT '請假原因',
  `prove` varchar(50) DEFAULT NULL COMMENT '證明文件檔名',
  `creat_user_id` int(7) NOT NULL COMMENT '建立者',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '新增時間',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最後編輯'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `leaves_days`
--

DROP TABLE IF EXISTS `leaves_days`;
CREATE TABLE `leaves_days` (
  `id` int(7) NOT NULL,
  `leave_id` int(7) NOT NULL COMMENT '主單',
  `type_id` int(7) NOT NULL COMMENT '假別',
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '開始時間',
  `end_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '結束時間',
  `hours` int(7) NOT NULL COMMENT '請假時數',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '新增時間',
  `creat_user_id` int(7) NOT NULL COMMENT '建立者'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `leaves_notices`
--

DROP TABLE IF EXISTS `leaves_notices`;
CREATE TABLE `leaves_notices` (
  `id` int(7) NOT NULL,
  `leave_id` int(7) NOT NULL COMMENT '假單',
  `user_id` int(7) NOT NULL COMMENT '發送至',
  `send_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '送出時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `leaves_respons`
--

DROP TABLE IF EXISTS `leaves_respons`;
CREATE TABLE `leaves_respons` (
  `id` int(7) NOT NULL,
  `leave_id` int(7) NOT NULL COMMENT '假單',
  `user_id` int(7) NOT NULL COMMENT '紀錄人',
  `tag_id` int(7) NOT NULL COMMENT '假單狀態',
  `memo` varchar(50) NOT NULL COMMENT '備註',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '新增時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `id` int(7) NOT NULL,
  `type` varchar(20) DEFAULT NULL COMMENT '類型',
  `content` text COMMENT '內容',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `notices`
--

DROP TABLE IF EXISTS `notices`;
CREATE TABLE `notices` (
  `id` int(7) NOT NULL,
  `type` varchar(30) NOT NULL COMMENT '寄送類型',
  `send_type` enum('slack','email') NOT NULL DEFAULT 'email' COMMENT '寄送方式(slack,email)',
  `subject` varchar(50) DEFAULT NULL COMMENT '主旨',
  `content` text NOT NULL COMMENT '內文'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(7) NOT NULL,
  `name` varchar(20) DEFAULT NULL COMMENT '全名',
  `shortname` varchar(20) DEFAULT NULL COMMENT '簡稱',
  `sort` int(7) DEFAULT '99' COMMENT '排序'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `teams`
--

DROP TABLE IF EXISTS `teams`;
CREATE TABLE `teams` (
  `id` int(7) NOT NULL,
  `parent_id` int(7) NOT NULL COMMENT '上級團隊',
  `name` varchar(20) NOT NULL COMMENT '團隊名',
  `color` varchar(15) NOT NULL COMMENT '文字顏色'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `types`
--

DROP TABLE IF EXISTS `types`;
CREATE TABLE `types` (
  `id` int(7) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '假別名稱',
  `reset_time` enum('none','week','month','season','year','other') NOT NULL DEFAULT 'none' COMMENT '重置時間(none:不重置,week:每週重置,month:每月重置,season:每季重置,year:每年重置,other:其他)',
  `hours` int(7) NOT NULL COMMENT '時數上限',
  `exception` enum('normal','job_seek','paid_sick','sick','entertain','annaul_leave','lone_stay','birthday') DEFAULT 'normal' COMMENT '例外規則(normal:一般假別,job_seek:謀職假,paid_sick:有薪病假,sick:無薪病假,entertain:善待假,annaul_leave:特休,lone_stay:久任假,birthday:生日假)',
  `strart_time` timestamp NULL DEFAULT NULL COMMENT '可用區間(開始)',
  `end_time` timestamp NULL DEFAULT NULL COMMENT '可用區間(結束)',
  `reason` tinyint(1) NOT NULL DEFAULT '0' COMMENT '理由是否必填',
  `prove` tinyint(1) NOT NULL DEFAULT '0' COMMENT '證明是否必填',
  `available` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否開啟'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(7) NOT NULL,
  `employee_no` int(7) NOT NULL COMMENT '員工編號',
  `email` varchar(30) NOT NULL COMMENT 'Email(登入用)',
  `password` varchar(50) DEFAULT NULL COMMENT '密碼',
  `token` varchar(30) DEFAULT NULL COMMENT '登入用token',
  `name` varchar(20) DEFAULT NULL COMMENT '名字',
  `role` enum('user','hr','admin','director') NOT NULL DEFAULT 'user' COMMENT '權限',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `avatar` varchar(20) DEFAULT NULL COMMENT '頭像檔名',
  `enter_date` datetime NOT NULL COMMENT '到職日',
  `leave_date` datetime DEFAULT NULL COMMENT '離職日',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '可否登入',
  `job_seek` tinyint(1) NOT NULL DEFAULT '0' COMMENT '謀職假可否用',
  `arrive_time` enum('0900','0930') NOT NULL DEFAULT '0900' COMMENT '上班時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `users_agents`
--

DROP TABLE IF EXISTS `users_agents`;
CREATE TABLE `users_agents` (
  `id` int(7) NOT NULL,
  `user_id` int(7) NOT NULL COMMENT '使用者',
  `agent_id` int(7) NOT NULL COMMENT '職務代理人'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `users_teams`
--

DROP TABLE IF EXISTS `users_teams`;
CREATE TABLE `users_teams` (
  `id` int(7) NOT NULL,
  `role` enum('user','manager') CHARACTER SET utf32 NOT NULL COMMENT '角色(user:員工,manager:主管)',
  `user_id` int(7) NOT NULL COMMENT '使用者',
  `team_id` int(11) DEFAULT NULL COMMENT '團隊'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `config_key` (`config_key`);

--
-- 資料表索引 `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `leaves_days`
--
ALTER TABLE `leaves_days`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `leaves_notices`
--
ALTER TABLE `leaves_notices`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `leaves_respons`
--
ALTER TABLE `leaves_respons`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `users_agents`
--
ALTER TABLE `users_agents`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `users_teams`
--
ALTER TABLE `users_teams`
  ADD PRIMARY KEY (`id`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `configs`
--
ALTER TABLE `configs`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `leaves_days`
--
ALTER TABLE `leaves_days`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `leaves_notices`
--
ALTER TABLE `leaves_notices`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `leaves_respons`
--
ALTER TABLE `leaves_respons`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `notices`
--
ALTER TABLE `notices`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `types`
--
ALTER TABLE `types`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `users_agents`
--
ALTER TABLE `users_agents`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `users_teams`
--
ALTER TABLE `users_teams`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
