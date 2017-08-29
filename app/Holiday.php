<?php

namespace App;

use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $fillable = [
        'type',
        'name',
        'date',
        'pagesize',
        'order_by',
        'order_way',
        'startTime',
        'endTime',
        'daterange',
    ];

    protected $attributes = [
        'order_by' => "id",
        'order_way' => "DESC",
        'pagesize' => '2',
    ];

    public $startTime = "";
    public $endTime = "";
    public $daterange =  "";
    public $keywords = "";

    /**
     * 與Model關聯的table
     *
     * @var string
     */

    public function search( $where=[] )
    {
        //type daterange keywords
        // 排序
        $query = self::OrderedBy();

        foreach ($where as $key => $value) {
            if(Schema::hasColumn('holidays', $key) && !empty($value)){
                if ($key == 'name') {
                    $query->where("name", 'LIKE', '%'.$value.'%');
                } else {
                    $query->where($key, $value);
                }
            }
        }

        if (!empty($where['startTime']) && !empty($where['endTime'])) {
            $query->whereBetween('date', [$where['startTime'], $where['endTime']]);
        }

        $result = $query->paginate($this->pagesize);

        return $result;
    }

    public function scopeOrderedBy($query)
    {
        return $query->orderBy($this->order_by, $this->order_way);
    }

    public function saveOriginalOnly()
    {
        $dirty = $this->getDirty();

        foreach ($this->getAttributes() as $key => $value) {
            if(in_array($key, array_keys($this->getOriginal()))) unset($this->$key);
        }

        $isSaved = $this->save();
        foreach($dirty as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $isSaved;
    }
}
