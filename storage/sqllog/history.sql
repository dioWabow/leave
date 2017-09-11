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
--2017-08-30 tony 增加特休時數欄位
ALTER TABLE `users` ADD `annual_date` INT(5) NULL COMMENT '特休時數' AFTER `arrive_time`;