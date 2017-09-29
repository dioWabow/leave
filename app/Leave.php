<?php

namespace App;

use Schema;

class Leave extends BaseModel
{
    protected $fillable = [
        'user_id',
        'type_id',
        'tag_id',
        'start_time',
        'end_time',
        'hours',
        'reason',
        'prove',
        'create_user_id',
        'order_by',
        'order_way',
        'pagesize',
        'agent',
        'notice_person',
        'timepicker',
        'dayrange',
    ];

    protected $attributes = [
        'order_by' => 'id',
        'order_way' => 'DESC',
        'pagesize' => '25',
        'start_time' => '',
        'end_time' => '',
        'exception' => '',
    ];
            
    /**
    * 搜尋table多個資料 (主管=>等待審核搜尋)
    * 若有多個傳回第一個
    *
    * @param  array   $where     搜尋條件
    * @param  int     $page      頁數(1為開始)
    * @param  int     $pagesize  每頁筆數
    * @return 資料object/false
    */
    public function searchForProveInManager($where = [])
    {
        $query = self::OrderedBy();
        foreach ($where as $key => $value) {

            if (Schema::hasColumn('leaves', $key) && !empty($value)) {

                if ($key == 'tag_id') {
                    

                    if (!is_array($value)){
                        //如果傳近來不是array,先將字串分割再搜尋條件(搜尋全部時)
                        $value = explode(',',$value);

                    }

                    $query->whereIn('tag_id', $value);

                } elseif ($key == 'id') {

                    $query->whereIn('id', $value);

                } elseif ($key == 'user_id') {

                    $query->whereIn('user_id', $value);

                } elseif ($key == 'hours') {

                    $query->where('hours', '>', $value);
                    
                } else {

                    $query->where($key, $value);

                } 
            }
        }

        $result = $query->paginate($this->pagesize);
        return $result;
    }

    /**
    * 搜尋table多個資料 (主管=>即將放假搜尋)
    * 若有多個傳回第一個
    *
    * @param  array   $where     搜尋條件
    * @param  int     $page      頁數(1為開始)
    * @param  int     $pagesize  每頁筆數
    * @return 資料object/false
    */
   public function searchForUpComingInManager($where = [])
   {
       $query = self::OrderedBy();
       foreach ($where as $key => $value) {
           
           if (Schema::hasColumn('leaves', $key) && !empty($value)) {

               if ($key == 'id') {
                   
                   $query->whereIn('id', $value);

               } elseif ($key == 'tag_id') {
                   
                   $query->where('tag_id', $value);

               } elseif ($key == 'start_time') {
                   
                   $query->where('start_time', '>=' ,$value);

               } else {

                   $query->where($key, $value);

               }
           }
       }
       $result = $query->paginate($this->pagesize);
       return $result;
   }


    /**
     * 搜尋table多個資料 (主管歷史紀錄搜尋)
     * 若有多個傳回第一個
     *
     * @param  array   $where     搜尋條件
     * @param  int     $page      頁數(1為開始)
     * @param  int     $pagesize  每頁筆數
     * @return 資料object/false
     */
   
    public function searchForHistoryInManager($where = [])
    {
        $query = self::OrderedBy();
        foreach ($where as $key => $value) {
            
            if (Schema::hasColumn('leaves', $key) && !empty($value)) {

                if ($key == 'id' && !empty($value)) {
                    
                    $query->whereIn('id', $value);
                
                } elseif ($key == 'type_id') {
                    
                    $query->whereIn('type_id', $value);

                } elseif ($key == 'start_time') {

                    $query->where('start_time','<' ,$value);

                } elseif ($key == 'tag_id') {
                        
                    if (!is_array($value)){
                        //如果傳近來不是array,先將字串分割再搜尋條件(搜尋全部時)
                        $value = explode(',', $value);

                    } 
                    
                    $query->whereIn('tag_id', $value);

                } else {

                    $query->where($key, $value);

                }
            }
        }

        $result = $query->paginate($this->pagesize);
        return $result;
    }

    /**
    * 搜尋table多個資料 (我的假單等待審核 + 即將放假)
    * 若有多個傳回第一個
    *
    * @param  array   $where     搜尋條件
    * @param  int     $page      頁數(1為開始)
    * @param  int     $pagesize  每頁筆數
    * @return 資料object/false
    */
    public function searchForProveAndUpComInMy($where = [])
    {
        $query = self::OrderedBy();

        foreach ($where as $key => $value) {
            
            if (Schema::hasColumn('leaves', $key) && !empty($value)) {

                if ($key == 'tag_id') {
                    
                    $query->whereIn('tag_id', $value);

                 } elseif ($key == 'id') {
                
                    $query->whereIn('id', $value);

                 } elseif ($key == 'start_time') {
                    
                    $query->where('start_time', '>=' ,$value);

                } else {

                    $query->where($key, $value);

                } 
            }
        }

        $result = $query->paginate($this->pagesize);
        return $result;
    }

    /**
     * 搜尋table多個資料 (我的假單歷史紀錄)
     * 若有多個傳回第一個
     *
     * @param  array   $where     搜尋條件
     * @param  int     $page      頁數(1為開始)
     * @param  int     $pagesize  每頁筆數
     * @return 資料object/false
     */
     public function searchForHistoryInMy($where = [])
     {
         $query = self::OrderedBy();
         foreach ($where as $key => $value) {
             
             if (Schema::hasColumn('leaves', $key) && !empty($value)) {
 
                 if ($key == 'id' && !empty($value)) {
                     
                     $query->whereIn('id', $value);
                 
                 } elseif ($key == 'type_id') {
                     
                     $query->whereIn('type_id', $value);
 
                 } elseif ($key == 'start_time') {
 
                     $query->where('start_time','<' ,$value);
 
                 } elseif ($key == 'tag_id') {
                         
                     if (!is_array($value)){
                         //如果傳近來不是array,先將字串分割再搜尋條件(搜尋全部時)
                         $value = explode(',', $value);
 
                     } 
                     
                     $query->whereIn('tag_id', $value);
 
                 } else {
 
                     $query->where($key, $value);
 
                 }
             }
         }
 
         $result = $query->paginate($this->pagesize);
         return $result;
     }

    /**
     * 搜尋table多個資料 (HR團隊假單 等待審核 + 即將放假)
     * 若有多個傳回第一個
     *
     * @param  array   $where     搜尋條件
     * @param  int     $page      頁數(1為開始)
     * @param  int     $pagesize  每頁筆數
     * @return 資料object/false
     */
     public function searchForProveAndUpComInHr($where = [])
     {
         $query = self::OrderedBy();
         
         foreach ($where as $key => $value) {
             
             if (Schema::hasColumn('leaves', $key) && !empty($value)) {
 
                 if ($key == 'tag_id') {
 
                     $query->whereIn('tag_id', $value);
 
                 } elseif ($key == 'start_time') {
 
                     $query->where('start_time', '>=' , $value);
                     
                 } else {
 
                     $query->where($key, $value);
 
                 } 
             }
         }
 
         $result = $query->paginate($this->pagesize);
         return $result;
     }
 
     /**
      * 搜尋table多個資料 (HR團隊假單 歷史紀錄)
      * 若有多個傳回第一個
      *
      * @param  array   $where     搜尋條件
      * @param  int     $page      頁數(1為開始)
      * @param  int     $pagesize  每頁筆數
      * @return 資料object/false
      */
     public function searchForHistoryInHr($where = [])
     {
         $query = self::OrderedBy();
         
         foreach ($where as $key => $value) {
             
             if (Schema::hasColumn('leaves', $key) && !empty($value)) {
 
             if ($key == 'tag_id') {
                 
                 if (!is_array($value)){
                     //如果傳近來不是array,先將字串分割再搜尋條件(搜尋全部時)
                     $value = explode(',', $value);
 
                 } 
                     $query->whereIn('tag_id', $value);
 
                 } elseif ($key == 'id' && !empty($value)) {
                     
                     $query->whereIn('id', $value);
 
                 } elseif ($key == 'start_time') {
 
                     $query->where('start_time', '<' , $value);
                     
                 } else {
 
                     $query->where($key, $value);
 
                 } 
             }
         }
 
         $result = $query->paginate($this->pagesize);
         return $result;
     }

      /**
     * 搜尋table多個資料 - 我是代理人條件搜尋
     * 若有多個傳回第一個
     *
     * @param  array   $where     搜尋條件
     * @param  int     $page      頁數(1為開始)
     * @param  int     $pagesize  每頁筆數
     * @return 資料object/false
     */
     public function searchForLeaveAgent($where = [])
     {
         $query = self::OrderedBy();
         foreach ($where as $key => $value) {
 
             if (Schema::hasColumn('leaves', $key) && !empty($value)) {
 
                 if ($key == 'id') {
                     
                     $query->whereIn('id', $value);
 
                 } elseif ($key == 'start_time') {
                     
                     $query->where('start_time', '>=', $value);
 
                 } else {
 
                     $query->where($key, $value);
 
                 } 
             }
         }
 
         $result = $query->paginate($this->pagesize);
         return $result;
     }
 

    public function scopeOrderedBy($query)
    {
        $result = $query->orderBy($this->order_by, $this->order_way);
        return $result;
    }

    /**
     * 搜尋table多個資料 (同意代理嗎 條件搜尋)
     * 若有多個傳回第一個
     *
     * @param  array   $where     搜尋條件
     * @param  int     $page      頁數(1為開始)
     * @param  int     $pagesize  每頁筆數
     * @return 資料object/false
     */
    public function searchForAgentApprove($where = [])
    {
        $query = self::OrderedBy();
        foreach ($where as $key => $value) {

            if (Schema::hasColumn('leaves', $key) && !empty($value)) {

                if ($key == 'tag_id') {

                    $query->whereIn('tag_id', $value);

                } elseif ($key == 'id') {
                    
                    $query->whereIn('id', $value);
                    
                } else {

                    $query->where($key, $value);

                } 
            }
        }

        $result = $query->paginate($this->pagesize);
        return $result;
    }


    public static function getTypeIdByLeaves($id)
    {
        $result = self::where('type_id', $id)->get();
        return $result;
    }

    public function leaveDataRange($first_day, $last_day)
    {
        $result = $this->whereBetween('start_time', [$first_day, $last_day])
            ->where('tag_id', '9')
            ->get();
    	return $result;
    }

    public function userVacationList($user_id, $type_id, $year, $month, $order_by, $order_way)
    {
        $query = $this->where('user_id', $user_id)
            ->where('type_id', $type_id)
            ->where('tag_id', '9')
            ->whereYear('start_time', $year);

            if ($month != 'year') {
                $query->whereMonth('start_time', $month);
            }

            if (!empty($order_by) && !empty($order_way)) {
                $query->orderBy($order_by, $order_way);
            }

        $result = $query->paginate(25);
        return $result;
    }


    //取得送出之後3 4 7天與之後未審核的假單
    public static function getWaitProveLeave()
    {
        $three_date = date(("Y-m-d"),strtotime("-3 days"));
        $four_date = date(("Y-m-d"),strtotime("-4 days"));;
        $seven_datetime = date(("Y-m-d H:i:s"),strtotime("-7 days"));;
        $result = self::whereIn('tag_id', ['1','2','3','4','5'])
            ->where(function ($query) use ($three_date,$four_date,$seven_datetime) {
                $query->whereDate('created_at', $three_date)
                ->orWhereDate('created_at', '=' , $four_date)
                ->orWhere('created_at', '<' , $seven_datetime);
            })
            ->get();
        return $result;
    }

    public function fetchUser()
    {
        $result = $this->hasOne('App\User', 'id' , 'user_id');
        return $result;
    }

    public function fetchType()
    {
        $result = $this->hasOne('App\Type', 'id', 'type_id');
        return $result;
    }

    public function fetchTag()
    {
        $result = $this->hasOne('App\Tag', 'id', 'tag_id');
        return $result;
    }

    public function fetchUserTeam()
    {
        $result = $this->hasOne('App\UserTeam', 'user_id', 'user_id');
        return $result;
    }

    public static function getLeaveByIdArr($id)
    {
        $result = self::whereIn('id', $id)->get();
        return $result;
    }
}
