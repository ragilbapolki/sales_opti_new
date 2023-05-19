<?php

namespace App\Http\Controllers;

use App\User;//model tabel users
use App\Plan; //model tabel plans
use App\Cekin; //model tabel cekins
use App\Cekout; //model tabel cekouts
use App\Customer; //model tabel Customers

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //untuk session auth
use Yajra\Datatables\Datatables; // untuk datatables

class ReportController extends Controller
{
			public function __construct()
			{
						$this->middleware('auth');
	      // $this->middleware('role:user',['only' => ['plan_per_tgl','plan_edit','plan_pending','plan_approved']]);
			}

   public function page_report()
   {
					$cabang = Auth::user()->kode_cabang;
			  // $users = User::select('id', 'name','username','hp', 'kode_cabang')
			  // ->where('role_id','3')
			  // ->where('kode_cabang',$cabang)
			  // ->where('active','1')->get();
      $planapprove = Plan::select('user_id')
      ->where('kode_cabang',$cabang)
      ->where('status','<>','0')
      ->with('user')
      ->groupBy('user_id')->get();

			  return view ('report.index',['responses' => $planapprove]);
      // return view('report.index');
   }
   public function data_report(Request $request)
   {
   	$month=$request->month;

   	return response()->json(['pesan' => 'success','bulan' => $month,'data' => $month]);
   }
}
