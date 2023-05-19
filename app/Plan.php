<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{

    use SoftDeletes;
    protected $dates = ['delete_at'];
    
    public function user()
    {
    	return $this->belongsTo('\App\User','user_id');
    }

    public function customer()
    {
    	return $this->belongsTo('\App\Customer','customer_id');
    }

    public function cekin()
    {
        return $this->hasMany('App\Cekin');
    }

    public function cekout()
    {
        return $this->hasOne('App\Cekout');
    }

}
