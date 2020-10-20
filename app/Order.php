<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    protected $guarded = ['id'];

    public const STEP_SOFTWINDING = 1;
    public const STEP_PACKING = 5;

    public function users()
    {
        return $this->belongsToMany('App\User')->as('process')->using('App\OrderUser')->withPivot('grade', 'step')->withTimestamps();
    }

//     public function process()
//     {
//         return $this->hasMany('App\OrderUser', '');
//     }

    public function batch()
    {
        return $this->hasMany('App\Batch');
    }

    public function sales()
    {
        return $this->belongsTo('App\Sales');
    }

    public function item()
    {
        return $this->belongsTo('App\Item');
    }

    public function color()
    {
        return $this->belongsTo('App\Color');
    }

    public function scopeMine($query)
    {
        return $query->whereDoesntHave('users', function (Builder $query) {
            $query->where('process.step', '=', 1);
        });
    }

//    public function scopeUnfinished($query)
//    {
//        return $query->whereHas('users', function (Builder $query) {
//            $query->where('process.grade', '=', null);
//        });
//
////        return $query->process->where('grade', '=', null);
//    }

    public function scopeNotFinished($query)
    {
        return $query->users->pivot->where('grade', '=', null);
    }
}
