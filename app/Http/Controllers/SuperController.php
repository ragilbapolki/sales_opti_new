<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //untuk session auth
use App\Log; //model tabel logs
use App\User; //model tabel users
use Yajra\Datatables\Datatables; // Datatables

class SuperController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('role:user');
      $this->middleware('role:admin');
    }
  
    public function page_logs()
    {
    	 return view('logs.index');
    }
    public function data_logs ()
    {
      $log = Log::select('logs.id','user_id','logs.kode_cabang','aktivitas','device','ip','logs.created_at')
      ->where('user_id','<>','1')->with('user:id,name');
      return Datatables::of($log)->make(true);
    }

    public function page_usersapp()
    {
      if (request()->ajax()) {
        return $this->data_users();
      }

      return view('user.index');
    }
    public function data_users ()
    {
      $log = User::select('users.id','name','kode_cabang','hp','google_contact','jabatan_id')
      ->where('active',1)->with('jabatan:id,name')->get();
      return Datatables::of($log)->make(true);
    }


    public function editcabang (Request $request)
    {
      $this->validate($request,[
        'cabang' => 'required|string|min:3',
      ]);
      $iduser = Auth::user()->id;
      $user = User::where('id', $iduser)->first();
      $user->kode_cabang = $request->cabang;
      $user->save();
      return redirect()->back()->with('message', 'Cabang Berhasil Diubah');
    }
}
