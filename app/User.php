<?php

namespace App;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // use Notifiable;

    const ROLE_SOFTWINDING = 1;
    const ROLE_DYEING = 2;
    const ROLE_CENTRIFUGAL = 3;
    const ROLE_REWINDING = 4;
    const ROLE_PACKING = 5;
    const ROLE_MANAGER = 6;
    const ROLE_PPIC = 7;

    const SHIFT_PAGI = 0;
    const SHIFT_SIANG = 1;
    const SHIFT_MALAM = 2;
    const TANPA_SHIFT = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password', 'role', 'shift'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function role()
    // {
    //     switch ($this->role) {
    //         case self::ROLE_MANAGER:
    //             return 'Manajer';
    //         case self::ROLE_SOFTWINDING:
    //             return 'Kepala Produksi Softwinding';
    //         case self::ROLE_DYEING:
    //             return 'Kepala Produksi Dyeing';
    //         case self::ROLE_CENTRIFUGAL:
    //             return 'Kepala Produksi Centrifugal';
    //         case self::ROLE_REWINDING:
    //             return 'Kepala Produksi Rewinding';
    //         case self::ROLE_PACKING:
    //             return 'Kepala Produksi Packing';
    //         default:
    //             return 'No Role';
    //     }
    // }

    public function shift()
    {
        switch ($this->shift) {
            case self::SHIFT_PAGI:
                return 'Shift Pagi';
            case self::SHIFT_SIANG:
                return 'Shift Siang';
            case self::SHIFT_MALAM:
                return 'Shift Malam';
            default:
                return 'No Shift';
        }
    }

    public function isManager()
    {
        return $this->category_id == self::ROLE_MANAGER;
    }

    public function isPpic()
    {
        return $this->category_id == self::ROLE_PPIC;
    }

    public function isSoftwinding()
    {
        return $this->category_id == self::ROLE_SOFTWINDING;
    }

    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'category_id');
    }

//    public function orders()
//    {
//        return $this->belongsToMany('App\Order');
//    }

    public function process()
    {
        return $this->hasMany('App\OrderUser');
    }
}
