<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsalesTmpTransaksi extends Model
{
	protected $connection = 'mysql_external';
				// public $incrementing = false;
    protected $table = 'websales_tmp_transaksi';
    // protected $primaryKey = 'cust_autonumber';
    public $timestamps = false;

    // public function barang()
    // {
    //     return $this->belongsToMany('App\DataBarang','databarang')->select(array('kode_gudang', 'nama_gudang'));
    //     // return $this->belongsTo('App\DataBarang','kobar');
    // }
    public function barang()
    {
    	return $this->belongsTo('App\DataBarang', 'kobar','kode_gudang')->select(array('kode_gudang', 'nama_gudang'));
    }

    public function item()
    {
        return $this->belongsTo('App\Item','kobar');
    }
}
