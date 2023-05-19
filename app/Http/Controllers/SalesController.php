<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //untuk session auth
use Illuminate\Support\Facades\DB; //untuk raw DB
use App\Plan; //model tabel plans
use App\Cekout; //model tabel cekouts
use App\Customer; //model tabel Customers
use Yajra\Datatables\Datatables; // untuk datatables

class SalesController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function page_visit()
    {
    	 // dd('jajal');
    	 return view('sales_visit.index');
    }

    public function data_visit()
    {
      $user_id = Auth::user()->id;
      // $planapprove = Plan::select('plans.id','plans.user_id','plans.tgl','plans.customer_id','plans.keterangan','plans.status')
      // ->where('plans.user_id',$user_id)
      // ->join('cekouts', 'plans.id', '=', 'cekouts.plan_id')
      // ->where('status','4')
      // // ->whereIn('plans.status',array(4))
      // ->with('customer')
      // // ->with('cekout')
      // ->orderBy('plans.id', 'desc')->get();

      $planapprove = DB::table('plans')->join('cekouts', 'plans.id', '=', 'cekouts.plan_id')
      ->join('customers', 'plans.customer_id', '=', 'customers.id')
      ->select(DB::raw('plans.id,plans.customer_id,plans.tgl,plans.keterangan,plans.status,cekouts.keterangan as hasil,customers.name,customers.alamat'))
      ->where('plans.user_id',$user_id)
      // ->where('plans.status', 0)
      // ->orWhere('plans.status', 6)
      ->whereIn('plans.status',array(3,4))
      // ->whereNull('deleted_at')
      ->get();


      // dd($planapprove);
      // print_r($planapprove);
      // $log = Plan::select('id','tgl','customer_id','keterangan','user_id','cek_in')
      //       ->where('kode_cabang',$kode_cabang)
      //       ->where('approve', 1)->with('customer')->with('user')->with('cekin')->get();
      return Datatables::of($planapprove)->make();
    }

    public function hiscust(Request $request)
    {
      $cekout = Cekout::select('keterangan')
            ->where('customer_id', $request->id)->get()->last();
      if (!$cekout) {
        $collection[] = Array(
         'id' => '',
         'keterangan' => '',
       );
        $cekout = collect($collection);
      } 
      $response=$cekout;
            
      return $response->toJson();
    }

}
