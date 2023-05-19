<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;//model tabel users
use App\Item; //model tabel items
use App\Log; //model tabel logs
use App\Plan; //model tabel logs
use App\Cekin; //model tabel logs
use App\Customer; //model tabel customer
use App\Versi; //model tabel customer

// use Session; // untuk session log

use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables; // untuk datatables

class MobileController1 extends Controller
{

    public function __construct()
    {
        $this->middleware('mobile', ['except' => ['signin','NotFound','selectcust','databarang']]);
    }

    public function signin (Request $request)
    {
    	$username = $request->input('username');
    	$password = $request->input('password');

    	if ( Auth::attempt(['username' => $username, 'password' => $password,'active' => 1])) {
    		$user = User::where('username', $username)->first();
        $versi = Versi::all() -> last();
    		$response = [
                'msg' => 'Sukses',
                'id' =>  $user->id,
                'name' =>  $user->name,
                'role' =>  $user->role_id,
                'jabatan' =>  $user->jabatan,
                'kodecabang' =>  $user->kode_cabang,
                'versi' =>  $versi->versi
    		];
    	}else{
    		$response = [
    			'msg' => 'Gagal'
    		];
    	}
		return response()->json($response,200);
    }

    public function suplier()
    {
        $items = Item:: where('suplier', '<>', ' ')
        -> whereNotNull('suplier')
        -> groupBy('suplier')
        ->get(['suplier']);
        // die($items);
        // foreach ($items as $x) {
        //     $response[]=array(
        //         "nama" => $x->suplier
        //     );
        // }
        return response()->json($items,200);
    }

    public function item(Request $request)
    {
            $kdbarang=$request->kdbarang;
            $namabarang=$request->namabarang;
            $produsen=$request->produsen;

            $iduser = $request->user_id;
            $device= $request->device;
            $client_ip= $request->ip_client;

            if (!empty($kdbarang)) {
                $items = Item::where('id', "$kdbarang")
                ->get(['id','nama','harga_jawa','harga_luar_jawa','harga_batam','suplier']);

                $log = new Log;
                $log->user_id = $iduser;
                $log->aktivitas = 'Cari KoBar: '.$kdbarang;
                $log->device = $device;
                $log->ip = $client_ip;
                $log->save();
            } elseif (!empty($namabarang)) {
                $suplier=$request->suplier;
                if (empty($suplier)) {
                    $items = Item::where('nama','like','%'.$namabarang.'%')
                    ->get(['id','nama','harga_jawa','harga_luar_jawa','harga_batam','suplier']);

                    $log = new Log;
                    $log->user_id = $iduser;
                    $log->aktivitas = 'Cari Nabar: '.$namabarang;
                    $log->device = $device;
                    $log->ip = $client_ip;
                    $log->save();

                } else {
                    $items = Item::where('nama','like','%'.$namabarang.'%')
                    ->where('suplier',"$suplier")
                    ->get(['id','nama','harga_jawa','harga_luar_jawa','harga_batam','suplier']);

                    $log = new Log;
                    $log->user_id = $iduser;
                    $log->aktivitas = 'Cari Nabar: '.$namabarang.' & Suplier: '.$suplier;
                    $log->device = $device;
                    $log->ip = $client_ip;
                    $log->save();

                }
            } else{
                $items = Item::where('suplier',"$produsen")
                ->get(['id','nama','harga_jawa','harga_luar_jawa','harga_batam','suplier']);

                $log = new Log;
                $log->user_id = $iduser;
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
            } else {
                return Datatables::of(Item::where('kode','djancuk'))->make(true);
            }
    }

    // json untuk select2 nama customer
    public function selectcust (Request $request)
    {
        $custs = Customer::select('id','name','alamat')->where('name','like', "%{$request->search}%")->get(); 
                                if (!empty($custs[0]->id)) {
                                        foreach ($custs as $cust) {
                                            $custArray[]=array(
                                                "id" => $cust->id,
                                                "text" => $cust->name." - ".$cust->alamat,
                                            );
                                        }
                                } else {
                                            $custArray[]=array(
                                                "id" => '',
                                                "text" => '',
                                            );
                                }
        $cust=json_encode($custArray);
        print $cust;
    }

    public function plan(Request $request)
    {
      $user_id = $request->iduser;
      $user = User::where('id', $user_id)->first();
      $kode_cabang = $user->kode_cabang;
      $role_id = $user->role_id;
      if ($role_id=='3') {
          $plans = plan::where('user_id', $user_id)
                  ->where('kode_cabang',$kode_cabang)
                  ->with('user')->get();
      } else {
          $plans = plan::where('kode_cabang',$kode_cabang)
                   ->with('user')->get();
      }

      if (!empty($plans[0]->title)) {
       foreach($plans as $plan){
         if (empty($plan->approve) ) {
             $color ='#ff0909';
         } else {
            if (empty($plan->cek_in) ) {
                $color ='#378006';
            } else {
                $color ='#0e2f44';
            }
         }
         // $url   = (!empty($plan->cek_in) OR empty($plan->approve)) ? '' : 'plan/'.$plan->id.'/cekin';
         $url   = (!empty($plan->cek_in) OR empty($plan->approve)) ? '' : 'cekin.html?plan='.$plan->id;
         $planArray[]=array(
             'title' => $plan->user->name,
             'start' => $plan->tgl,
             "url" => $url,
             "color" => $color,
         );
       }
      }else{
        $planArray[]=array(
            'title' => '',
            'start' => '',
            "url" => '',
            "color" => '',
        );
      }

      $jsonPlan=json_encode($planArray);
      return $jsonPlan ;
    }

    public function pendingshow(Request $request)
    {
        $kode_cabang = $request->kodecabang;
        $datapending = Plan::select('id','tgl','customer_id','keterangan','user_id')->where('approve', 0)
        ->where('kode_cabang', $kode_cabang)
        ->with('customer')->with('user')->get();
        return Datatables::of($datapending)->make();
    }

    public function approveshow(Request $request)
    {
        $kode_cabang = $request->kodecabang;
        $dataapprove = Plan::select('id','tgl','customer_id','keterangan','user_id','cek_in')
            ->where('approve', 1)
            ->where('kode_cabang', $kode_cabang)->with('customer')->with('user')->with('cekin')->get();
        return Datatables::of($dataapprove)->make();
    }

    public function toapprove($id)
    {
      $plan = Plan::find($id);
      if ($plan) {
          $plan->approve = '1';
          $plan->save();
      } else {
          abort(404);
      }
    }

    public function toreject($id)
    {
        $plan = Plan::find($id);
        if ($plan) {
            $plan->delete();
        } else {
            abort(404);
        }
    }

    public function addplan(Request $request)
    {
      $user_id = $request->user_id;
      $user = User::where('id', $user_id)->first();
      $kode_cabang = $user->kode_cabang;
      $plan = new Plan;
      $plan->timestamps = false;
      $plan->user_id = $user_id;
      $plan->kode_cabang = $kode_cabang;
      $plan->title =  'Visit';
      $plan->tgl =  $request->tglplan;
      $plan->customer_id =  $request->customer;
      $plan->keterangan =  $request->keterangan;
      $plan->created_at = date('Y-m-d H:i:s');
      $plan->save();
      // print 'sukses';
      // return $this->page_calender();
      // return redirect()->route('page_plan');
    }

    public function datacekin(Request $request)
    {
        $id = $request->id;
        $plan = Plan::where('id', $id)->with('customer')->get();
      return response()->json($plan,200);
      // return $jsonPlan ;
    }

    public function tocekin(Request $request)
    {
        $id = $request->idplan;
        $plan = Plan::with('customer')->get()->find($id);;
        $plan->cek_in = '1';
        $plan->timestamps = false;
        $plan->save();
        if ($plan) {
            $iduser = $request->user_id;
            $device= 'Androidcontroller';
            $client_ip= 'IPcontroller';

            $new_cekin = DB::table('cekins')->insertGetId(
            array(
                'tgl' => date('Y-m-d H:i:s'),
                'plan_id' => $id,
                'keterangan' => $request->keterangan,
                'latitude' => $request->lat,
                'longitude' => $request->long,
                'created_at' => date('Y-m-d H:i:s')
                )
            ); 

            $log = new Log;
            $log->user_id = $iduser;
            $log->aktivitas = 'Sales '.$plan->user_id.' ID Cek In: '.$new_cekin;
            $log->device = $device;
            $log->ip = $client_ip;
            $log->save();
        } else {
        abort(404);
        }
    }

    public function datalokasi(Request $request)
    {
      $id= $request->id;
      $lokasi = Cekin::where('plan_id', $id)->first();
      return response()->json($lokasi,200);
    }

    public function notfound()
    {
        return abort(404);
    }

    public function databarang()
    {
          $items = Item::where('hidden',0)
          ->get(['id as kode','nama','suplier as produsen','nama_dagang','kode_produk_katalog']);

          // $jajal[]=(object) array(
          //   "Kode_barang" => $items->id,
          //   "nama_barang" => $items->nama,
          //   // "nama_dagang" => $row->nama_dagang,
          //   // "nomor_ijin_edar" => $row->nomor_ijin_edar,
          //   // "kode_produk_katalog" => $items->kode_produk_katalog,
          //   "produsen" => $items->suplier
          //   );

          return response()->json($items,200);
    }

}
