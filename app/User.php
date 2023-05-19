<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    // use SoftDeletes;
    // protected $dates = ['delete_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','username','password' ,'role_id','jabatan','jabatan_id','kode_cabang','email','hp'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function jabatan()
    {
        return $this->belongsTo('App\jabatan');
    }


    public function log()
    {
        return $this->hasMany('App\Log','user_id');
    }

    public function plan()
    {
        return $this->hasMany('App\Plan','user_id');
    }

    public function level($levelRole)
    {
        // dd($levelRole);
        // dd($this->role->name == $namaRole);
        if($this->role->level == $levelRole)
        {
            return true;
        }
            return false;
    }

    public $incrementing = false;
}
