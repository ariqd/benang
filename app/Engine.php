<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Engine extends Model
{
    protected $fillable = [
        'name', 'capacity'
    ];

    public function usage()
    {
        return $this->hasMany('App\EngineOrderUser');
    }

    public function getCurrentCapacityAttribute()
    {
        // $used = $this->usage->whereHas('order_user', function (Builder $query) {
        // $query->where([
        //     '' => ''
        // ]);
        // });

        // if ($this->has('usage', '>', 5)) {

        // }

        // $used = 0;

        // foreach ($this->usage->whereHas('')) {

        // }

        // return $this->capacity;
    }
}
