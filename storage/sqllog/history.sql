--2017-08-31 Eno 系統設定預設欄位
INSERT INTO `configs` (`id`, `config_key`, `config_value`, `comment`, `created_at`, `updated_at`) VALUES
(NULL, 'google_client_id', '', 'google認證用client_id', '2017-08-30 10:32:34', '2017-08-30 02:32:34'),
(NULL, 'google_client_secret', 'Sz1iGw-', 'google認證用client_secret', '2017-08-30 10:32:34', '2017-08-30 02:32:34'),
(NULL, 'google_redirect', '', 'google認證用回傳網址', '2017-08-30 10:32:34', '2017-08-30 02:32:34'),
(NULL, 'company_name', '', '公司名稱', '2017-08-30 07:06:21', '2017-08-29 23:06:21'),
(NULL, 'company_short_name', '', '公司簡稱', '2017-08-30 12:36:23', '2017-08-30 04:36:23'),
(NULL, 'company_website', '', '公司網址', '2017-08-30 12:36:23', '2017-08-30 04:36:23'),
(NULL, 'company_logo', '', '公司logo', '2017-08-30 12:36:23', '2017-08-30 04:36:23'),
(NULL, 'company_rules', '', '人事規章url', '2017-08-30 12:36:23', '2017-08-30 04:36:23'),
(NULL, 'company_mail', '', '異常回報Email', '2017-08-30 12:36:23', '2017-08-30 04:36:23'),
(NULL, 'company_domain', '', '公司網域(Email檢查網域用)', '2017-08-30 12:36:23', '2017-08-30 04:36:23'),
(NULL, 'config_smtp_host', '', 'SMTP HOST', '2017-08-30 09:18:18', '2017-08-30 09:18:18'),
(NULL, 'smtp_port', '', 'SMTP PORT', '2017-08-30 09:18:18', '2017-08-30 09:18:18'),
(NULL, 'smtp_username', '', 'SMTP Username', '2017-08-30 09:18:18', '2017-08-30 09:18:18'),
(NULL, 'smtp_password', '', 'SMTP Password', '2017-08-30 09:18:18', '2017-08-30 09:18:18'),
(NULL, 'smtp_auth', '', 'SMTP AUTH', '2017-08-30 09:20:18', '2017-08-30 09:20:18'),
(NULL, 'smtp_from', '', '送出Email', '2017-08-30 09:20:18', '2017-08-30 09:20:18'),
(NULL, 'smtp_display', '', '送出顯示名稱', '2017-08-30 09:20:18', '2017-08-30 09:20:18'),
(NULL, 'google_status', 'true', 'Google登入開關', '2017-08-30 10:32:34', '2017-08-30 02:32:34'),
(NULL, 'slack_status', '', 'Slack開關', '2017-08-30 09:23:13', '2017-08-30 09:23:13'),
(NULL, 'slack_token', '', 'Slack Token', '2017-08-30 09:23:13', '2017-08-30 09:23:13'),
(NULL, 'slack_public_channel', '', '廣播頻道', '2017-08-30 09:23:13', '2017-08-30 09:23:13'),
(NULL, 'slack_botname', '', 'BOT代號', '2017-08-30 09:23:13', '2017-08-30 09:23:13'),
(NULL, 'boss_days', '', 'N天以上給大BOSS審核', '2017-08-30 10:01:02', '2017-08-30 10:01:02'),
(NULL, 'director_days', '', 'N天以上給董事審核', '2017-08-31 10:01:02', '2017-08-30 10:01:02');
COMMIT;

--#2017-08-21 carrie 系統設定 configs 加入新增時間、編輯時間
ALTER TABLE `configs` ADD `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增時間';
ALTER TABLE `configs` ADD `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最後編輯'
