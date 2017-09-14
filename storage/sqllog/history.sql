--2017-09-07 carrie 我的假單新增 假單的代理人table
CREATE TABLE `leaves_agents` (
  `id` int(7) NOT NULL,
  `leave_id` int(7) NOT NULL COMMENT '請假單',
  `agent_id` int(7) NOT NULL COMMENT '職務代理人',
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `updated_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--2017-09-10 carrie 各狀態名稱
INSERT INTO `tags` (`id`, `name`, `shortname`, `sort`) VALUES
(1, '送出', '送出', 1),
(2, '代理人待核', '職代', 2),
(3, '小主管待核', '小主管', 3),
(4, '主管待核', '主管', 4),
(5, '大BOSS待核', 'BOSS', 5),
(6, '董事待核', '董事', 6),
(7, '已取消', '取消', 7),
(8, '不准假', '不准假', 8),
(9, '已準假', '已準假', 9);