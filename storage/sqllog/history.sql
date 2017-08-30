--2017-08-30 tony 增加特休時數欄位
ALTER TABLE `users` ADD `annual_date` INT(5) NULL COMMENT '特休時數' AFTER `arrive_time`;