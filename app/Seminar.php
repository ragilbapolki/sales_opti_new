<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    public function user()
    {
    	return $this->belongsTo('\App\User','user_id');
    }

    public function customer()
    {
    	return $this->belongsTo('\App\Customer','customer_id');
    }

}
