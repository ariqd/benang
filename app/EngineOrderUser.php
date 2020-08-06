<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EngineOrderUser extends Model
{
    protected $guarded = ['id'];

    protected $table = 'process_engines';
}
