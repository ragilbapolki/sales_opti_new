<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'id';

    public function cekout()
    {
        // return $this->hasMany('App\Cekout','customer_id');
        return $this->hasMany('App\cekout');
    }

}
