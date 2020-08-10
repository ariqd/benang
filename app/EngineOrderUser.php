<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EngineOrderUser extends Model
{
    protected $guarded = ['id'];

    protected $table = 'process_engines';

    public function engine()
    {
        return $this->belongsTo('App\Engine');
    }

    public function order_user()
    {
        return $this->belongsTo('App\OrderUser');
    }

    public function scopeEngineUsage($query)
    {
        return $query->whereHas('engines');
    }
}
