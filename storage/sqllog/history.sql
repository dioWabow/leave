--2017-08-22 laravel登入功能
ALTER TABLE `users` ADD `updated_at` TIMESTAMP NOT NULL AFTER `arrive_time`, ADD `created_at` TIMESTAMP NOT NULL AFTER `updated_at`;


--2017-08-22 laravel登入功能
INSERT INTO `configs` (`id`, `config_key`, `config_value`, `comment`) VALUES
(NULL, 'google_client_id', '', 'google認證用client_id'),
(NULL, 'google_client_secret', '', 'google認證用client_secret'),
(NULL, 'google_redirect', '', 'google認證用回傳網址');

--2017-08-17 laravel登入功能
ALTER TABLE `users` ADD `remember_token` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '登入session記錄用' AFTER `token`;
ALTER TABLE `users` CHANGE `employee_no` `employee_no` INT(7) NULL COMMENT '員工編號';
ALTER TABLE `users` CHANGE `enter_date` `enter_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '到職日';
