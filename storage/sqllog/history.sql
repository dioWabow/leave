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
