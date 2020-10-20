<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function color()
    {
        return $this->belongsTo('App\Color');
    }

    public function process()
    {
        return $this->hasMany('App\OrderUser');
    }
}
