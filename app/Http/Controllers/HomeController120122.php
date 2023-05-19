<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer; //model tabel Customers
use App\User; //model tabel users
use App\Plan; //model tabel users
use App\Cekin; //model tabel users
use App\Cekout; //model tabel users
use App\WebsalesTmpTransaksi; //model tabel logs
use App\Databarang; //model tabel logs
use App\Log;
use App\Versi;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth; //untuk session auth
use Illuminate\Support\Collection;
use Yajra\Datatables\Datatables; // untuk datatables
use Session;

class HomeController extends Controller
{
    public function __construct()
    {
    		$this->middleware('auth',['except' => 'apilogin']);
    }
    public function root()
    {
      return view('page_home');
    }
    public function home ($id)
    {
      $active = Auth::user()->active;
      $skac = new DeviceController;
      $device= $skac -> device();
      Session::put('platformcdi', $id);
      // dd($device);
      if ($active==0) {
        return redirect('login')->with(Auth::logout());
      }
      return view('page_home');
    }

    public function account_setting ()
    {
      return view('account.index');
    }

    public function editaccount (Request $request)
    {
      $this->validate($request,[
        'name' => 'required|string',
        'hp' => 'required|numeric|min:9',
      ]);
      $iduser = Auth::user()->id;
      $user = User::where('id', $iduser)->first();
      $user->name = ucwords($request->name);
      $user->hp = $request->hp;
      $user->google_contact = 0;
      $user->timestamps = false;
      $user->save();
      return redirect()->back()->with('message', 'Update Data Berhasil');
      // return redirect('login')->with('alert-success','Kamu berhasil Register');
    }

    public function editpassword (Request $request)
    {
      $this->validate($request,[
        'password' => 'required|string|min:5|confirmed',
      ]);
      if ($request->password == 'katocdi') {
        return redirect()->back()->with('message', 'jangan memakai password default');
      }
      $iduser = Auth::user()->id;
      $password = bcrypt($request->password);
      $user = User::where('id', $iduser)->first();
      $user->password = $password;
      $user->save();
      return redirect()->back()->with('message', 'Password Berhasil Diubah');
      // return redirect('login')->with('alert-success','Kamu berhasil Register');
    }

    public function apilogin (Request $request)
    {
      $username = $request->input('username');
      $password = $request->input('password');
      if ( Auth::attempt(['username' => $username, 'password' => $password,'active' => 1])) {
        $skac = new KoneksiController;
        $koneksilocalhost= $skac -> KoneksiTanpaDB();
        $koneksi= $skac -> KoneksiDC();

        $copy_items = "INSERT INTO cdi_sales2.items (id,nama,harga_jawa,harga_luar_jawa,harga_batam,suplier,hidden)
         SELECT a.kode_cabang,a.nama_cabang,a.harga_jawa,a.harga_luarjawa,a.harga_batam,a.produsen,IF( ndelik = 'N' , 0, 1 ) AS ndelik
         FROM cobradental_master_pos.databarang a
         WHERE a.kode_cabang <> '' AND a.kode_cabang IS NOT NULL 
         ON DUPLICATE KEY UPDATE nama=a.nama_cabang,harga_jawa=a.harga_jawa,harga_luar_jawa=a.harga_luarjawa,harga_batam=a.harga_batam,suplier=a.produsen,hidden=IF(ndelik = 'N' , 0, 1 )";
        $result = $koneksilocalhost->query($copy_items);

        $copy_items2 = "INSERT INTO webapp.items (id,nama,harga_jawa,harga_luar_jawa,harga_batam,suplier,hidden)
         SELECT a.kode_cabang,a.nama_cabang,a.harga_jawa,a.harga_luarjawa,a.harga_batam,a.produsen,IF( ndelik = 'N' , 0, 1 ) AS ndelik
         FROM cobradental_master_pos.databarang a
         WHERE a.kode_cabang <> '' AND a.kode_cabang IS NOT NULL 
         ON DUPLICATE KEY UPDATE nama=a.nama_cabang,harga_jawa=a.harga_jawa,harga_luar_jawa=a.harga_luarjawa,harga_batam=a.harga_batam,suplier=a.produsen,hidden=IF(ndelik = 'N' , 0, 1 )";
        $result2 = $koneksi->query($copy_items2);

        $kuericron = "INSERT INTO cdi_kranggan.cronjobs (file,execute,status,created_at)
        VALUES ('Master To Sales','cdiSALES','Sukses',NOW())";
        $result3=$koneksilocalhost  -> query($kuericron);

        $iduser = Auth::user()->id;
        $skacdevice = new DeviceController;
        $device= 'App Android';
        $client_ip= '127.0.0.1';

        $log = new Log;
        $log->user_id = $iduser;
        $log->kode_cabang = Auth::user()->kode_cabang;
        $log->aktivitas = 'login';
        $log->device = $device;
        $log->ip = $client_ip;
        $log->save();
        Session::put('device', $device);
        Session::put('client_ip', $client_ip);
        return redirect()->route('page_item');
      }
      return'gagal';
    }

    // json untuk select2 nama customer
    public function selectcust (Request $request)
    {
    	$cabang = Auth::user()->kode_cabang;
      $custs = Customer::select('id','name','alamat')
      ->where('update_cabang',$cabang)
      ->where('name','like', "%{$request->search}%")->get(); 
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

    public function selectcustnama (Request $request)
    {
      $cabang2 = Auth::user()->kode_cabang;
      $custs2 = Customer::select('id','name','alamat')
      ->where('update_cabang',$cabang2)
      ->where('name','like', "%{$request->search}%")->get(); 
      if (!empty($custs2[0]->id)) {
              foreach ($custs2 as $cust2) {
                  $custArray2[]=array(
                      "id" => $cust2->id,
                      "text" => $cust2->id." - ".$cust2->name,
                  );
              }
      } else {
                  $custArray2[]=array(
                      "id" => '',
                      "text" => '',
                  );
      }
          $cust2=json_encode($custArray2);
          print $cust2;
    }  

    public function selectcustccc (Request $request)
    {
      $cabang = Auth::user()->kode_cabang;
      $custs = Customer::select('id','name','alamat','ccc','ccc_level')
      ->where('ccc','<>','')
      ->where('name','like', "%{$request->search}%")->get(); 
      if (!empty($custs[0]->id)) {
              foreach ($custs as $cust) {
                  $custArray[]=array(
                      "id" => $cust->id,
                      "text" => $cust->name." - ".$cust->alamat,
                      "ccc" => $cust->ccc,
                      "level" => $cust->ccc_level,
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

    // json untuk select2 nama barang
    public function selectitem (Request $request)
    {
      $custs = DB::connection('mysql_external')->table('webapp.items')
      ->where('items.nama','like','%'.$request->search.'%')
      ->where('items.hidden',0)
      ->select('id','nama','harga_jawa','harga_luar_jawa','harga_batam','suplier','nomor_ijin_edar')->get();

      if (!empty($custs[0]->id)) {
              foreach ($custs as $cust) {
                  $custArray[]=array(
                      "id" => $cust->id,
                      "text" => $cust->nama." - ".$cust->suplier,
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




    public function lokasi($id)
    {
      $lokasi = Cekin::where('plan_id', $id)->first();
      // dd($lokasi);
      return view('lokasi.index',['lokasi' => $lokasi]);
    }

    public function page_materiproduk()
    {
      return view('materiproduk.index');
    }

    public function data_materiproduk(Request $request)
    {
      $skac = new KoneksiController;
      $koneksi= $skac -> KoneksiCobraMasterPos();
      $kueri= "SELECT * FROM cobradental_master_pos.LinkMateri";
      $result=$koneksi -> query($kueri);
      $count = $result->num_rows;
      if ($count>0) {
        while ($row=$result->fetch_object()) {
          $response[]=(object) array(
            "id" => $row->recid,
            "brand" => $row->Brand,
            "judul" => $row->Judul,
            "linkurl" => $row->LinkURL,
            );
        }$result->close();
      } else {
        $response = [ ];
      }
      return Datatables::of($response)->make(true);
    }

    public function notfound()
    {
        return abort(404);
    }

    public function jajal()
    {

        return view('page_jajal');
        
    }
}
