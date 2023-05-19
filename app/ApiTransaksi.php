<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiTransaksi extends Model
{
	   protected $connection = 'mysql_external';
				// public $incrementing = false;
    protected $table = 'api_transaksi';
    // protected $primaryKey = 'cust_autonumber';
    public $timestamps = false;






// protected $dates = ['ccc_register_date'];
				// protected $dates = ['last_transaction','birthdate'];
				// protected $dates = ['birthdate'];
    // protected $dateFormat = 'd-m-Y';
}
