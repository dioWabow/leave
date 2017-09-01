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

--2017-08-17 laravel登入功能
ALTER TABLE `users` ADD `remember_token` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '登入session記錄用' AFTER `token`;
ALTER TABLE `users` CHANGE `employee_no` `employee_no` INT(7) NULL COMMENT '員工編號';
ALTER TABLE `users` CHANGE `enter_date` `enter_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '到職日';
