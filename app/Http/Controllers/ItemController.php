<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;//model tabel users
use App\Item; //model tabel items
use App\Log; //model tabel logs
use Session; // untuk session log

use Illuminate\Support\Facades\Auth; //untuk session auth
use Yajra\Datatables\Datatables; // untuk datatables

class ItemController extends Controller
{

				public function __construct()
				{
						$this->middleware('auth');
				}
	
    public function cek_harga()
    {
					$items = Item:: where('suplier', '<>', ' ')
					-> whereNotNull('suplier')
					-> groupBy('suplier')
					->get(['suplier']);
					// die($items);
					return view ('item.index',['items' => $items ]);
    }

    public function show(Request $request)
    {
						if ($request->ajax()) {
							$kdbarang=$request->kdbarang;
							$namabarang=$request->namabarang;
							$produsen=$request->produsen;
							$iduser = Auth::user()->id;
							$platformcdi= Session::get('platformcdi');
							// dd($platformcdi);
							if (!empty($platformcdi) AND $platformcdi !='cdi' ) {
								$device= $platformcdi;
							} else {
								$device= Session::get('device');
							}
							
							
							$client_ip= Session::get('client_ip');

							if (!empty($kdbarang)) {
								$items = Item::where('id', "$kdbarang")
								->where('hidden',0)
								->get(['id','nama','harga_jawa','harga_luar_jawa','harga_batam','suplier']);

								$log = new Log;
								$log->user_id = $iduser;
								$log->kode_cabang = Auth::user()->kode_cabang;
								$log->aktivitas = 'Cari KoBar: '.$kdbarang;
								$log->device = $device;
								$log->ip = $client_ip;
								$log->save();
							} elseif (!empty($namabarang)) {
								$suplier=$request->suplier;
								if (empty($suplier)) {
									$items = Item::where('nama','like','%'.$namabarang.'%')
									->where('hidden',0)
									->get(['id','nama','harga_jawa','harga_luar_jawa','harga_batam','suplier']);

									$log = new Log;
									$log->user_id = $iduser;
									$log->kode_cabang = Auth::user()->kode_cabang;
									$log->aktivitas = 'Cari Nabar: '.$namabarang;
									$log->device = $device;
									$log->ip = $client_ip;
									$log->save();

								} else {
									$items = Item::where('nama','like','%'.$namabarang.'%')
									->where('hidden',0)
									->where('suplier',"$suplier")
									->get(['id','nama','harga_jawa','harga_luar_jawa','harga_batam','suplier']);

									$log = new Log;
									$log->user_id = $iduser;
									$log->kode_cabang = Auth::user()->kode_cabang;
									$log->aktivitas = 'Cari Nabar: '.$namabarang.' & Suplier: '.$suplier;
									$log->device = $device;
									$log->ip = $client_ip;
									$log->save();

								}
							} else{
								$items = Item::where('suplier',"$produsen")
								->where('hidden',0)
								->get(['id','nama','harga_jawa','harga_luar_jawa','harga_batam','suplier']);

								$log = new Log;
								$log->user_id = $iduser;
								$log->kode_cabang = Auth::user()->kode_cabang;
								$log->aktivitas = 'Cari Suplier: '.$produsen;
								$log->device = $device;
								$log->ip = $client_ip;
								$log->save();
							} 

							if ($items->isNotEmpty()) {
									foreach ($items as $item) {
										$ppnjawa=$item->harga_jawa * 0.10;
										$hargajawa=$item->harga_jawa + $ppnjawa;
										$ppn_luar_jawa=$item->harga_luar_jawa * 0.10;
										$harga_luar_jawa=$item->harga_luar_jawa + $ppn_luar_jawa;
										$ppnbatam=$item->harga_batam * 0.10;
										$hargabatam=$item->harga_batam + $ppnbatam;
										$BarangPPN[]=array(
											"id" => $item->id,
											"nama" => $item->nama,
											"harga_jawa" => $hargajawa,
											"harga_luar_jawa" => $harga_luar_jawa,
											"harga_batam" => $hargabatam,
											"suplier" => $item->suplier,
										);
									}

									return Datatables::of($BarangPPN)->make(true);
									// print_r($BarangPPN);
							} else {
									return Datatables::of(Item::where('kode','djancuk'))->make(true);
							}
						}
    }

    public function viewdetail (Request $request)
    {
    	 $kobar=$request->id;
      $cabang = Auth::user()->kode_cabang;
      $skac = new KoneksiController;
      $koneksi= $skac -> KoneksiDC();
      $kueritgl= "SELECT tgl FROM ".$cabang.".historysaldo ORDER BY tgl DESC LIMIT 1 ";
      $resulttgl=$koneksi -> query($kueritgl);
      $count = $resulttgl->num_rows;
						$row = $resulttgl->fetch_object();
						$tgl = $row->tgl;
						$tglshow = date("d M", strtotime($tgl));

      $kueri= "SELECT stok FROM ".$cabang.".historysaldo a WHERE a.tgl='$tgl' AND a.kobar='$kobar'";
      $result=$koneksi -> query($kueri);
      $count = $result->num_rows;
      if ($count>0) {
								$row = $result->fetch_object();
								$stok = $row->stok;
      } else {
        $stok = 0;
      }
						$response = [
							"tanggal" => $tglshow,
							"stok" => $stok
						];
						return $response;
    }

    public function item_stok()
    {
      $cabang = Auth::user()->kode_cabang;
      $skac = new KoneksiController;
      $koneksi= $skac -> KoneksiDC();
      $kueritgl= "SELECT tgl FROM ".$cabang.".historysaldo ORDER BY tgl DESC LIMIT 1 ";
      $resulttgl=$koneksi -> query($kueritgl);
      $count = $resulttgl->num_rows;
						$row = $resulttgl->fetch_object();
						$tgl = $row->tgl;
						$tglshow = date("d F", strtotime($tgl));
						return view('itemstok.index',['tgl' => $tglshow ]);
    }

    public function search_item_stok(Request $request)
    {
						$cabang = Auth::user()->kode_cabang;
						$skac = new KoneksiController;
						$koneksi= $skac -> KoneksiDC();
						$kueritgl= "SELECT tgl FROM ".$cabang.".historysaldo ORDER BY tgl DESC LIMIT 1 ";
						$resulttgl=$koneksi -> query($kueritgl);
						$row = $resulttgl->fetch_object();
						$tgl = $row->tgl;

						$kuerihargacabang= "SELECT harga FROM cobradental_master_pos.cabang_new WHERE kode='$cabang'";
						$resulharga=$koneksi -> query($kuerihargacabang);
						$rowharga = $resulharga->fetch_object();
						$harga = $rowharga->harga;
						if ($harga == 'J') {
							$kueri= "SELECT a.*,b.nama_cabang,b.harga_jawa as harga_barang FROM ".$cabang.".historysaldo a INNER JOIN cobradental_master_pos.databarang b ON a.kobar=b.kode_gudang  WHERE a.tgl='$tgl'";
						} elseif ($harga == 'L') {
							$kueri= "SELECT a.*,b.nama_cabang,b.harga_luarjawa as harga_barang FROM ".$cabang.".historysaldo a INNER JOIN cobradental_master_pos.databarang b ON a.kobar=b.kode_gudang  WHERE a.tgl='$tgl'";
						} else {
							$kueri= "SELECT a.*,b.nama_cabang,b.harga_batam as harga_barang FROM ".$cabang.".historysaldo a INNER JOIN cobradental_master_pos.databarang b ON a.kobar=b.kode_gudang  WHERE a.tgl='$tgl'";
						}
      $result=$koneksi -> query($kueri);
      $count = $result->num_rows;
      if ($count>0) {
        while ($row=$result->fetch_object()) {
										$ppn = $row->harga_barang * 0.10;
										$harga_barang = $row->harga_barang + $ppn;
          $response[]=(object) array(
            "kobar" => $row->kobar,
            "nama" => $row->nama_cabang,
            "stok" => $row->stok,
            "harga" => $harga_barang,
            );
        }$result->close();
      } else {
        $response = [ ];
      }
      return Datatables::of($response)->make(true);
    }



}
