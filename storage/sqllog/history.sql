#2017-08-29 carrie 假別管理 types 修改開始時間欄位名稱
ALTER TABLE `types` CHANGE `strart_time` `start_time` TIMESTAMP NULL DEFAULT NULL COMMENT '可用區間(開始)';
#2017-08-29 carrie 假別管理 types 加入新增時間、編輯時間
ALTER TABLE `types` ADD `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增時間';
ALTER TABLE `types` ADD `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最後編輯';
