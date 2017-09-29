<?php

namespace App\Classes;

use Session;

class WebHelper
{
    /**
     * 取得 status (狀態) 名稱
     *
     * @return []
     */
    public static function getStatusValueByKey($data)
    {
        $arr = self::getStatusOptionsAsKeys();
        
        return (!empty($arr[$data])) ? $arr[$data] : null;
    }

    /**
     * 取得 status (狀態) 的所有項目種類，用於 on & off
     *
     * @return []
     */
    public static function getStatusOptionsAsKeys()
    {
        return [
            'on' => '1',
            'off' => '0',
        ];
    }

    /**
     * 取得 holiday 中 type 的名稱
     *
     * @return []
     */
    public static function getHolidiesTypeLabel($data)
    {
        $arr = self::getHolidiesTypeOptions();

        return (!empty($arr[$data])) ? $arr[$data] : null;
    }
    
    /**
     * 取得 holiday 中 type 的所有項目種類
     *
     * @return []
     */
    public static function getHolidiesTypeOptions()
    {
        return [
            'work' => '工作日',
            'holiday' => '國定假日',
        ];
    }

    /**
     * 取得 notices 中 send_type 的名稱
     *
     * @return []
     */
    public static function getNoticesSendTypeLabel($data)
    {
        $arr = self::getNoticesSendTypeOptions();

        return (!empty($arr[$data])) ? $arr[$data] : null;
    }

    /**
     * 取得 notices 中 send_type 的所有項目種類
     *
     * @return []
     */
    public static function getNoticesSendTypeOptions()
    {
        return [
            'slack' => 'Slack',
            'email' => 'Email',
        ];
    }
    
    /**
     * 取得 types 中 reset_time 的名稱
     *
     * @return []
     */
    public static function getTypesResetTimeLabel($data)
    {
        $arr = self::getTypesResetTimeOptions();

        return (!empty($arr[$data])) ? $arr[$data] : null;
    }

    /**
     * 取得 types 中 reset_time (重置形式) 的所有項目種類
     *
     * @return []
     */
    public static function getTypesResetTimeOptions()
    {
        return [
            'none' => '不重置',
            'week' => '每週重置',
            'month' => '每月重置',
            'season' => '每季重置',
            'year' => '每年重置',
            'other' => '其他',
        ];
    }

    /**
     * 取得 types 中 exception 的名稱
     *
     * @return []
     */
    public static function getTypesExceptionLabel($data)
    {
        $arr = self::getTypesExceptionOptions();

        return (!empty($arr[$data])) ? $arr[$data] : null;
    }

    /**
     * 取得 types 中 exception (類型) 的所有項目種類
     *
     * @return []
     */
    public static function getTypesExceptionOptions()
    {
        return [
            'normal' => '一般',
            'job_seek' => '謀職假',
            'paid_sick' => '有薪病假',
            'sick' => '無薪病假',
            'entertain' => '善待假',
            'annual_leave' => '特休',
            'lone_stay' => '久任假',
            'birthday' => '生日假',
            'natural_disaster' => '天災假',
        ];
    }
    
    /**
     * 取得 users 中 role 的名稱
     *
     * @return []
     */
    public static function getUsersRoleLabel($data)
    {
        $arr = self::getUsersRoleOptions();

        return (!empty($arr[$data])) ? $arr[$data] : null;
    }
    
    /**
     * 取得 users 中 role (權限角色) 的所有項目種類
     *
     * @return []
     */
    public static function getUsersRoleOptions()
    {
        return [
            'admin' => '最高權限',
            'hr' => 'HR',
            'manage' => '主管',
            'user' => '員工',
        ];
    }

    /**
     * 取得 users 中 arrive_time 的名稱
     *
     * @return []
     */
    public static function getUsersArriveTimeLabel($data)
    {
        $arr = self::getUsersArriveTimeOptions();

        return (!empty($arr[$data])) ? $arr[$data] : null;
    }

    /**
     * 取得 users 中 arrive_time (上班時間) 的所有項目種類
     *
     * @return []
     */
    public static function getUsersArriveTimeOptions()
    {
        return [
            '0900' => '09:00 ~ 18:00',
            '0930' => '09:30 ~ 18:30',
        ];
    }

    /**
     * 取得 users 中 sex 的名稱
     *
     * @return []
     */
    public static function getUsersSexLabel($data)
    {
        $arr = self::getUsersSexOptions();

        return (!empty($arr[$data])) ? $arr[$data] : null;
    }

    /**
     * 取得 users 中 sex (性別) 的所有項目種類
     *
     * @return []
     */
    public static function getUsersSexOptions()
    {
        return [
            '1' => '男孩',
            '0' => '女孩',
        ];
    }

    /**
     * 取得 users 中 status 的名稱
     *
     * @return []
     */
    public static function getUsersStatusLabelForSearch($data)
    {
        $arr = self::getUsersStatusOptionsForSearch();

        return (!empty($arr[$data])) ? $arr[$data] : null;
    }

    /**
     * 取得 users 中 status (狀態) 的所有項目種類
     *
     * @return []
     */
    public static function getUsersStatusOptionsForSearch()
    {
        return [
            '1' => '在職員工',
            '0' => '離職員工',
        ];
    }

    /**
     * 取得 users 中 status 的名稱
     *
     * @return []
     */
    public static function getUsersStatusLabel($data)
    {
        $arr = self::getUsersStatusOptions();

        return (!empty($arr[$data])) ? $arr[$data] : null;
    }

    /**
     * 取得 users 中 status (狀態) 的所有項目種類，新增&顯示用
     *
     * @return []
     */
    public static function getUsersStatusOptions()
    {
        return [
            '1' => '在職中',
            '2' => '將離職',
            '0' => '已離職',
        ];
    }

    /**
     * 取得 leave 中 標籤 的名稱
     *
     * @return []
     */
    public static function getLeaveTabLabel($data)
    {
        $arr = self::getLeaveTabOptions();
        
        return (!empty($arr[$data])) ? $arr[$data] : null;
    }

    /**
     * 取得 leave 中 標籤 的所有項目種類
     *
     * @return []
     */
    public static function getLeaveTabOptions()
    {
        return [
            'prove' => '等待審核',
            'upcoming' => '即將放假',
            'history' => '歷史紀錄',
            'calc' => '行事曆',
        ];
    }

    /**
     * 取得 leave 中 tag 的名稱 (歷史清單頁面)
     *
     * @return []
     */
     public static function getLeaveTagsLabelForHistory($data)
     {
         $arr = self::getLeaveTagsOptionsForHistory();
         
         return (!empty($arr[$data])) ? $arr[$data] : null;
     }

    /**
     * 取得 leave 中 tag 的所有項目種類 (歷史清單頁面)
     *
     * @return []
     */
    public static function getLeaveTagsOptionsForHistory()
    {
        return [
            '7' => '已取消',
            '9' => '已准假',
            '8' => '不准假',
        ];
    }
    /**
     * 取得 leave 中 tag 的名稱 (等待審核頁面)
     *
     * @return []
     */
     public static function getLeaveTagsLabelForProve($data)
     {
         $arr = self::getLeaveTagsOptionsForProve();
         
         return (!empty($arr[$data])) ? $arr[$data] : null;
     }

    /**
     * 取得 leave 中 tag 的所有項目種類 (等待審核頁面)
     *
     * @return []
     */
    public static function getLeaveTagsOptionsForProve()
    {
        return [
            '1' => '代理人待核',
            '2' => '小主管待核',
            '3' => '主管待核',
            '4' => '大BOSS待核',
        ];
    }
}