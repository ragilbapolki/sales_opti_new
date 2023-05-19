<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataBarang extends Model
{
	   protected $connection = 'mysql_external';
				public $incrementing = false;
    protected $table = 'databarang';
    protected $primaryKey = 'kode_gudang';
    // protected $hidden = ['nomor_ijin_edar','nama_dagang'];
    public $timestamps = false;

}
