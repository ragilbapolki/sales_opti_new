<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
	{
	protected $connection = 'mysql';
	public $incrementing = false;
    protected $table = 'pemesanan';
    protected $primaryKey = 'auto_id';
    public $timestamps = false;

	protected $fillable = ['nota','tgl','totalpenjualan','terbayar','kembali','kekurangan','keterangan','type','sales','customer','type_cust','status'];
	}
