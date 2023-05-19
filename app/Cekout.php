<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cekout extends Model
{

    public function plan()
    {
    	// return $this->belongsToMany('App\Plan');
    	 return $this->belongsTo('\App\Plan','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer','customer_id');
    }

}
