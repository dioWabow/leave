<?php

namespace App;

use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;

class Holiday extends BaseModel
{
    protected $fillable = [
        'type',
        'name',
        'date',
        'pagesize',
        'order_by',
        'order_way',
        'start_time',
        'end_time',
        'start_date',
        'end_date',
    ];

    protected $attributes = [
        'order_by' => "date",
        'order_way' => "DESC",
        'pagesize' => '25',
        'start_date' => "",
        'end_date' => "",
    ];

    /**
     * 與Model關聯的table
     *
     * @var string
     */

    public function search($where=[])
    {
        $query = self::OrderedBy();

        $columns = array_map('strtolower', Schema::getColumnListing('holidays'));

        foreach ($where as $key => $value) {

            if (in_array($key, $columns) && !empty($value)) {

                if ($key == 'name') {

                    $query->where("name", 'LIKE', '%'.$value.'%');

                } else {

                    $query->where($key, $value);

                }
            }
        }

        if (!empty($where['start_time']) && !empty($where['end_time'])) {

            $query->whereBetween('date', [$where['start_time'], $where['end_time']]);

        }

        $result = $query->paginate($this->pagesize);
        return $result;
    }

    public function scopeOrderedBy($query)
    {
        $result = $query->orderBy($this->order_by, $this->order_way);
        return $result;
    }

    public static function checkHolidayByDateAndType($date,$type)
    {
        $query = self::where('date' , 'like' , $date.'%');
        $result = $query->where('type' , $type)->count();
        return $result;
    }
}
