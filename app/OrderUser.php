<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderUser extends Pivot
{
    protected $guarded = ['id'];

    protected $table = 'order_user';

    public function batch()
    {
        return $this->belongsTo('App\Batch');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
