--2017-08-22 tony uses_agents、users_teams增加修改及新增時間
ALTER TABLE `users_agents` ADD `created_at` TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) AFTER `agent_id`, ADD `updated_at` TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) AFTER `created_at`;
ALTER TABLE `users_teams` ADD `created_at` TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) AFTER `team_id`, ADD `updated_at` TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) AFTER `created_at`;
--2017-08-21 tony users增加修改及新增時間
ALTER TABLE `users` ADD `created_at` TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) AFTER `arrive_time`, ADD `updated_at` TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) AFTER `created_at`;
--2017-08-18 tony 增加性別欄位
ALTER TABLE `users` ADD `sex` TINYINT(1) NULL COMMENT '1:男 0:女' AFTER `nickname`;
--2017-08-17 tony user資料表增加 稱呼欄位、將enter_date與leave_date型態改為 date
ALTER TABLE `users` ADD `nickname` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '稱呼' AFTER `name`;
ALTER TABLE `users` CHANGE `enter_date` `enter_date` DATE NOT NULL COMMENT '到職日';
ALTER TABLE `users` CHANGE `leave_date` `leave_date` DATE NULL DEFAULT NULL COMMENT '離職日';
