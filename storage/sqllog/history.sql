--2017-10-17 tony Breadcrumb
CREATE TABLE `audits` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_id` int(10) UNSIGNED NOT NULL,
  `auditable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_values` text COLLATE utf8mb4_unicode_ci,
  `new_values` text COLLATE utf8mb4_unicode_ci,
  `url` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `audits` ADD PRIMARY KEY (`id`);
ALTER TABLE `audits` MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

--2017-10-17 tony config登入輪播圖片
INSERT INTO `configs` (`id`, `config_key`, `config_value`, `comment`, `created_at`, `updated_at`) VALUES (NULL, 'login_pictures', '', '登入頁輪播圖片', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
--2017-10-06 michael 團隊顏色 欄位加大
ALTER TABLE `teams` CHANGE `color` `color` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文字顏色';

--2017-09-25 eno 天災假欄位
ALTER TABLE `types` CHANGE `exception` `exception` ENUM('normal','job_seek','paid_sick','sick','entertain','annual_leave','lone_stay','birthday','natural_disaster') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'normal' COMMENT '例外規則(normal:一般假別,job_seek:謀職假,paid_sick:有薪病假,sick:無薪病假,entertain:善待假,annaul_leave:特休,lone_stay:久任假,birthday:生日假,natural_disaster:天災假)';
--2017-09-22 tony 修改已離職總特休時數和剩餘時數到float
ALTER TABLE `leaved_users` CHANGE `annual_hours` `annual_hours` FLOAT(10) NOT NULL COMMENT '總特休時數';
ALTER TABLE `leaved_users` CHANGE `remain_annual_hours` `remain_annual_hours` FLOAT(10) NOT NULL COMMENT '剩餘特休';

#2017-09-25 carrie 特休報表計算資料表
CREATE TABLE `annuals_years` (
  `id` int(10) NOT NULL COMMENT '流水編號',
  `user_id` int(10) NOT NULL COMMENT '使用者',
  `annual_this_years` int(10) NOT NULL COMMENT '今年總特休',
  `annual_next_years` int(10) NOT NULL COMMENT '明年總特休',
  `used_annual_hours` int(10) NOT NULL COMMENT '已使用特休',
  `remain_annual_hours` int(10) NOT NULL COMMENT '剩餘特休',
  `create_time` DATE NULL DEFAULT NULL COMMENT '特休計算時間',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '新增時間',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '最後編輯'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `annuals_years` ADD PRIMARY KEY (`id`);
ALTER TABLE `annuals_years` MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;

#2017-09-14 michael 報表 leaves 新增扣薪欄位
ALTER TABLE `leaves` ADD `deductions` INT(7) NULL DEFAULT NULL COMMENT '扣薪' AFTER `end_time`;

#2017-09-12 michael 團隊設定 patent_id 預設為0
ALTER TABLE `teams` CHANGE `parent_id` `parent_id` INT(7) NOT NULL DEFAULT '0' COMMENT '上級團隊';

#2017-09-11 michael 團隊設定 user_id 預設給null
ALTER TABLE `users_teams` CHANGE `user_id` `user_id` INT(7) NULL DEFAULT NULL COMMENT '使用者', CHANGE `team_id` `team_id` INT(11) NULL DEFAULT NULL COMMENT '團隊';

#2017-09-11 michael 團隊 teams 新增開使結束時間欄位
ALTER TABLE `teams` ADD `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增時間';
ALTER TABLE `teams` ADD `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最後編輯';

#2017-09-11 michael 團隊設定 user_teams 新增開使結束時間欄位
ALTER TABLE `users_teams` ADD `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增時間';
ALTER TABLE `users_teams` ADD `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最後編輯';

--2017-09-22 carrie 假別管理新增狀態
ALTER TABLE `types` ADD `deductions` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '扣薪' AFTER `end_time`;
--2017-09-20 tony 新增已離職特休計算資料表
CREATE TABLE `leaved_users` (
  `id` int(10) NOT NULL COMMENT '流水編號',
  `user_id` int(10) NOT NULL COMMENT '使用者',
  `annual_hours` int(10) NOT NULL COMMENT '總特休時數',
  `used_annual_hours` int(10) NOT NULL COMMENT '已使用特休',
  `remain_annual_hours` int(10) NOT NULL COMMENT '剩餘特休',
  `create_time` DATE NULL DEFAULT NULL COMMENT '特休計算時間',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '新增時間',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '最後編輯'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `leaved_users`
  ADD PRIMARY KEY (`id`);
  ALTER TABLE `leaved_users`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;
--2017-09-20 tony 新增特休結算資料表
CREATE TABLE `annuals_hours` (
  `id` int(10) NOT NULL COMMENT '流水編號',
  `user_id` int(10) NOT NULL COMMENT '使用者',
  `annual_hours` int(10) NOT NULL COMMENT '總特休時數',
  `used_annual_hours` int(10) NOT NULL COMMENT '已使用特休',
  `remain_annual_hours` int(10) NOT NULL COMMENT '剩餘特休',
  `create_time` DATE NULL DEFAULT NULL COMMENT '特休計算時間',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '新增時間',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '最後編輯'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `annuals_hours`
  ADD PRIMARY KEY (`id`);
  ALTER TABLE `annuals_hours`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;
--2017-09-20 tony 修改user role將manage刪除
ALTER TABLE `users` CHANGE `role` `role` ENUM('user','hr','admin','director') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'user' COMMENT '權限';
--2017-09-18 tony 修改資料表名稱
RENAME TABLE `leave`.`leaves_respons` TO `leave`.`leaves_responses`;
ALTER TABLE `leaves_responses` CHANGE `created_at` `created_at` TIMESTAMP NULL COMMENT '新增時間';
ALTER TABLE `leaves_responses` ADD `updated_at` TIMESTAMP NULL COMMENT '最後編輯' AFTER `created_at`;
--2017-09-15 tony
ALTER TABLE `leaves` CHANGE `created_at` `created_at` TIMESTAMP NULL COMMENT '新增時間';
ALTER TABLE `leaves` CHANGE `start_time` `start_time` TIMESTAMP NULL COMMENT '開始時間';
ALTER TABLE `leaves` CHANGE `end_time` `end_time` TIMESTAMP NULL COMMENT '結束時間';
ALTER TABLE `leaves` CHANGE `updated_at` `updated_at` TIMESTAMP NULL COMMENT '最後編輯';
ALTER TABLE `leaves_days` CHANGE `created_at` `created_at` TIMESTAMP NULL COMMENT '新增時間';
ALTER TABLE `leaves_days` CHANGE `start_time` `start_time` TIMESTAMP NULL COMMENT '開始時間';
ALTER TABLE `leaves_days` CHANGE `end_time` `end_time` TIMESTAMP NULL COMMENT '結束時間';
ALTER TABLE `leaves_days` CHANGE `updated_at` `updated_at` TIMESTAMP NULL COMMENT '最後編輯';
ALTER TABLE `holidays` CHANGE `created_at` `created_at` TIMESTAMP NULL COMMENT '新增時間';
ALTER TABLE `holidays` CHANGE `updated_at` `updated_at` TIMESTAMP NULL COMMENT '最後編輯';
ALTER TABLE `holidays` CHANGE `date` `date` DATE NULL COMMENT '日期';
--2017-09-12 tony 請假證明欄位大小加長
ALTER TABLE `leaves` CHANGE `prove` `prove` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '證明文件檔名';

--2017-09-11 tony
ALTER TABLE `leaves_notices` ADD `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) AFTER `send_time`;
ALTER TABLE `leaves_notices` ADD `updated_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) AFTER `created_at`;
ALTER TABLE `leaves_notices` CHANGE `send_time` `send_time` TIMESTAMP NULL COMMENT '送出時間';

--2017-09-11 tony 新增假單代理人資料表
CREATE TABLE `leaves_agents` (
 `id` int(7) NOT NULL,
 `leave_id` int(7) NOT NULL COMMENT '請假單',
 `agent_id` int(7) NOT NULL COMMENT '職務代理人',
 `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
 `updated_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `leaves_agents` ADD INDEX( `id`);
ALTER TABLE `leaves_agents` ADD PRIMARY KEY(`id`);
ALTER TABLE `leaves_agents` CHANGE `id` `id` INT(7) NOT NULL AUTO_INCREMENT;

--2017-09-08 tony
ALTER TABLE `leaves_days` CHANGE `start_time` `start_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '開始時間';
ALTER TABLE `users` CHANGE `annual_date` `annual_hours` INT(5) NULL DEFAULT NULL COMMENT '特休時數';

--2017-09-07 tony 修正錯字、拆單假單新增請假人
ALTER TABLE `leaves_days` ADD `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最後編輯';
ALTER TABLE `leaves_days` CHANGE `creat_user_id` `create_user_id` INT(7) NOT NULL COMMENT '建立者';
ALTER TABLE `leaves_days` ADD `user_id` INT(7) NOT NULL COMMENT '請假人' AFTER `leave_id`;

--2017-09-05 tony 開始時間不應該on update
ALTER TABLE `leaves` CHANGE `start_time` `start_time` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '開始時間';

--2017-09-05 tony 修正寫錯字
ALTER TABLE `leaves` CHANGE `creat_user_id` `create_user_id` INT(7) NOT NULL COMMENT '建立者';
ALTER TABLE `types` CHANGE `exception` `exception` ENUM('normal','job_seek','paid_sick','sick','entertain','annual_leave','lone_stay','birthday') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'normal' COMMENT '例外規則(normal:一般假別,job_seek:謀職假,paid_sick:有薪病假,sick:無薪病假,entertain:善待假,annaul_leave:特休,lone_stay:久任假,birthday:生日假)';

--2017-08-31 eno 系統設定預設欄位
INSERT INTO `configs` (`id`, `config_key`, `config_value`, `comment`, `created_at`, `updated_at`) VALUES
(NULL, 'company_name', '', '公司名稱', '2017-08-30 07:06:21', '2017-08-29 23:06:21'),
(NULL, 'company_short_name', '', '公司簡稱', '2017-08-30 12:36:23', '2017-08-30 04:36:23'),
(NULL, 'company_website', '', '公司網址', '2017-08-30 12:36:23', '2017-08-30 04:36:23'),
(NULL, 'company_logo', '', '公司logo', '2017-08-30 12:36:23', '2017-08-30 04:36:23'),
(NULL, 'company_rules', '', '人事規章url', '2017-08-30 12:36:23', '2017-08-30 04:36:23'),
(NULL, 'company_mail', '', '異常回報Email', '2017-08-30 12:36:23', '2017-08-30 04:36:23'),
(NULL, 'company_domain', '', '公司網域(Email檢查網域用)', '2017-08-30 12:36:23', '2017-08-30 04:36:23'),
(NULL, 'smtp_host', '', 'SMTP HOST', '2017-08-30 09:18:18', '2017-08-30 09:18:18'),
(NULL, 'smtp_port', '', 'SMTP PORT', '2017-08-30 09:18:18', '2017-08-30 09:18:18'),
(NULL, 'smtp_username', '', 'SMTP Username', '2017-08-30 09:18:18', '2017-08-30 09:18:18'),
(NULL, 'smtp_password', '', 'SMTP Password', '2017-08-30 09:18:18', '2017-08-30 09:18:18'),
(NULL, 'smtp_auth', '', 'SMTP AUTH', '2017-08-30 09:20:18', '2017-08-30 09:20:18'),
(NULL, 'smtp_from', '', '送出Email', '2017-08-30 09:20:18', '2017-08-30 09:20:18'),
(NULL, 'smtp_display', '', '送出顯示名稱', '2017-08-30 09:20:18', '2017-08-30 09:20:18'),
(NULL, 'google_status', 'true', 'Google登入開關', '2017-08-30 10:32:34', '2017-08-30 02:32:34'),
(NULL, 'google_client_id', '', 'google認證用client_id', '2017-08-30 10:32:34', '2017-08-30 02:32:34'),
(NULL, 'google_client_secret', 'Sz1iGw-', 'google認證用client_secret', '2017-08-30 10:32:34', '2017-08-30 02:32:34'),
(NULL, 'google_redirect', '', 'google認證用回傳網址', '2017-08-30 10:32:34', '2017-08-30 02:32:34'),
(NULL, 'slack_status', '', 'Slack開關', '2017-08-30 09:23:13', '2017-08-30 09:23:13'),
(NULL, 'slack_token', '', 'Slack Token', '2017-08-30 09:23:13', '2017-08-30 09:23:13'),
(NULL, 'slack_public_channel', '', '廣播頻道', '2017-08-30 09:23:13', '2017-08-30 09:23:13'),
(NULL, 'slack_botname', '', 'BOT代號', '2017-08-30 09:23:13', '2017-08-30 09:23:13'),
(NULL, 'boss_days', '', 'N天以上給大BOSS審核', '2017-08-30 10:01:02', '2017-08-30 10:01:02'),
(NULL, 'director_days', '', 'N天以上給董事審核', '2017-08-31 10:01:02', '2017-08-30 10:01:02');

--2017-08-30 tony 增加特休時數欄位
ALTER TABLE `users` ADD `annual_date` INT(5) NULL COMMENT '特休時數' AFTER `arrive_time`;

--#2017-08-21 eno 系統設定 configs 加入新增時間、編輯時間
ALTER TABLE `configs` ADD `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增時間';
ALTER TABLE `configs` ADD `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最後編輯'

#2017-09-24 carrie 假單記錄 修改memo可以為空
ALTER TABLE `leaves_responses` CHANGE `memo` `memo` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '備註';
#2017-08-29 carrie 假別管理 types 修改開始時間欄位名稱
ALTER TABLE `types` CHANGE `strart_time` `start_time` TIMESTAMP NULL DEFAULT NULL COMMENT '可用區間(開始)';

#2017-08-29 carrie 假別管理 types 加入新增時間、編輯時間
ALTER TABLE `types` ADD `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增時間';
ALTER TABLE `types` ADD `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最後編輯';

--2017-08-22 laravel登入功能
ALTER TABLE `users` ADD `updated_at` TIMESTAMP NOT NULL AFTER `arrive_time`, ADD `created_at` TIMESTAMP NOT NULL AFTER `updated_at`;


--2017-08-22 laravel登入功能
INSERT INTO `configs` (`id`, `config_key`, `config_value`, `comment`) VALUES
(NULL, 'google_client_id', '', 'google認證用client_id'),
(NULL, 'google_client_secret', '', 'google認證用client_secret'),
(NULL, 'google_redirect', '', 'google認證用回傳網址');

--2017-08-22 tony uses_agents、users_teams增加修改及新增時間
ALTER TABLE `users_agents` ADD `created_at` TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) AFTER `agent_id`, ADD `updated_at` TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) AFTER `created_at`;
ALTER TABLE `users_teams` ADD `created_at` TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) AFTER `team_id`, ADD `updated_at` TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) AFTER `created_at`;

--2017-08-21 tony users增加修改及新增時間
ALTER TABLE `users` ADD `created_at` TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) AFTER `arrive_time`, ADD `updated_at` TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) AFTER `created_at`;

--2017-08-18 tony 增加性別欄位
ALTER TABLE `users` ADD `sex` TINYINT(1) NULL COMMENT '1:男 0:女' AFTER `nickname`;

-- 2017-08-17
ALTER TABLE `holidays` ADD `name` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '假日名稱' AFTER `id`;
ALTER TABLE `holidays` ADD `created_at` TIMESTAMP on update CURRENT_TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增時間' AFTER `date`;
ALTER TABLE `holidays` ADD `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '修改時間' AFTER `created_at`;

--2017-08-17 tony user資料表增加 稱呼欄位、將enter_date與leave_date型態改為 date
ALTER TABLE `users` ADD `nickname` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '稱呼' AFTER `name`;
ALTER TABLE `users` CHANGE `enter_date` `enter_date` DATE NOT NULL COMMENT '到職日';
ALTER TABLE `users` CHANGE `leave_date` `leave_date` DATE NULL DEFAULT NULL COMMENT '離職日';

--2017-08-17 laravel登入功能
ALTER TABLE `users` ADD `remember_token` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '登入session記錄用' AFTER `token`;
ALTER TABLE `users` CHANGE `employee_no` `employee_no` INT(7) NULL COMMENT '員工編號';
ALTER TABLE `users` CHANGE `enter_date` `enter_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '到職日';
