<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderUser extends Pivot
{
    protected $guarded = ['id'];

    protected $table = 'process';

    protected $casts = [
        'error' => 'integer',
    ];

    const ROLE_MANAGER = 0;
    const ROLE_SOFTWINDING = 1;
    const ROLE_DYEING = 2;
    const ROLE_CENTRIFUGAL = 3;
    const ROLE_REWINDING = 4;
    const ROLE_PACKING = 5;

    public function batch()
    {
        return $this->belongsTo('App\Batch');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function usage()
    {
        return $this->hasMany('App\EngineOrderUser', 'process_id');
    }

    public static function step($step)
    {
        switch ($step) {
            case self::ROLE_MANAGER:
                return 'Manajer';
            case self::ROLE_SOFTWINDING:
                return 'Softwinding';
            case self::ROLE_DYEING:
                return 'Dyeing';
            case self::ROLE_CENTRIFUGAL:
                return 'Centrifugal';
            case self::ROLE_REWINDING:
                return 'Rewinding';
            case self::ROLE_PACKING:
                return 'Packing';
            default:
                return 'No Role';
        }

        // public function scopeFinished($query) 
        // {
        //     return $query->
        // }

    }

    // public function getTotalProcessedInThisStepAttribute()
    // {
    //     return $this->where([
    //         ['batch_id', $this->batch_id],
    //         ['step', $this->step],
    //     ])->sum('processed');
    // }

    public function getCurrentStepProcessedAttribute()
    {
        return $this->where([
            ['batch_id', $this->batch_id],
            ['step', $this->step],
        ])->sum('processed');
    }

    public function getCurrentStepErrorsAttribute()
    {
        return $this->where([
            ['batch_id', $this->batch_id],
            ['step', $this->step],
        ])->sum('error');
    }

    public function getCurrentStepQtyAttribute()
    {
        return $this->batch->qty - $this->current_step_processed - $this->current_step_errors;
    }

    public function getTotalErrorsAttribute()
    {
        return $this->where([
            ['batch_id', $this->batch_id],
            // ['step', $this->step],
        ])->sum('error');
    }

    public function getTotalErrorsBeforeThisStepAttribute()
    {
        return $this->where([
            ['batch_id', $this->batch_id],
            ['step', '<', $this->step],
        ])->sum('error');
    }

    public function getQtyAfterErrorsAttribute()
    {
        return $this->batch->qty - $this->total_errors;
    }

    public function getQtyBeforeThisStepAttribute()
    {
        return $this->batch->qty - $this->total_errors_before_this_step;
    }

    // public function scopeTotalProcessed($query, $batch_id)
    // {
    //     return $query->where('batch_id', $batch_id)->sum('processed');
    // }
}
