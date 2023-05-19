<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPemesanan extends Model
{
	protected $connection = 'mysql';
	public $incrementing = false;
    protected $table = 'pemesanan_detil';
    protected $primaryKey = 'auto_id';
    public $timestamps = false;
    protected $fillable = ['nota','kobar','namabarang','diskon','harga','qty']; 
}