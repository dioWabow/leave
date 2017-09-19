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

--#2017-08-21 eno 系統設定 configs 加入新增時間、編輯時間
ALTER TABLE `configs` ADD `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增時間';
ALTER TABLE `configs` ADD `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最後編輯'

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
