<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cekin extends Model
{
    public function plan()
    {
        return $this->belongsTo('\App\Plan','plan_id');
    }
}
