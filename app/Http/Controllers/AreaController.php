<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;//model tabel users
use App\Customer; //model tabel Customers
use App\Log; //model tabel logs
use Session; // untuk session log
use Yajra\Datatables\Datatables; // Datatables
use Illuminate\Support\Facades\Auth; //untuk session auth
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class AreaController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('role:user');
      $this->middleware('role:admin');
    }
  
    public function pindahcabang ()
    {
      $skac = new KoneksiController;
      $koneksi= $skac -> KoneksiDC();
      $kueri= "SELECT kode,alias FROM webapp.cabangs WHERE kode <> 'c000'";
      $result=$koneksi -> query($kueri);
      while ($row=$result->fetch_object()) {
        $collection[] = Array(
          'kode' => $row->kode,
          'alias' => $row->alias,
        );
      }$result->close();
      $cabangs = collect($collection);
      $nameroute = Route::currentRouteName();
      return view ('pindahcabang.index',['cabangs' => $cabangs,'nameroute'=> $nameroute]);
    }

   public function data_customer()
   {
       $data_ccc = Customer::select('id','update_cabang','name','titel','alamat','kota',DB::raw('DATE(last_transaksi) as last_transaksi'));
       // dd($data_ccc);
       return Datatables::of($data_ccc)->make(true);
   }

   public function updatecabang(Request $request)
   {
        $iduser = Auth::user()->id;
        $device= Session::get('device');
        $client_ip= Session::get('client_ip');
        if ($request->tocabang=='kosong') {
          $cabangtujuan=NULL;
        } else {
          $cabangtujuan=$request->tocabang;
        }
        

        $skac = new KoneksiController;
        $koneksi= $skac -> KoneksiDC();
        $kueriupdate ="UPDATE webapp.customers SET update_cabang= '$cabangtujuan' WHERE id='$request->regulerid'";
        $result=$koneksi -> query($kueriupdate);

        $user = Customer::where("id",$request->regulerid)->first();
        $user->update_cabang = $cabangtujuan;
        $user->save();

         $log = new Log;
         $log->user_id = $iduser;
         $log->kode_cabang = Auth::user()->kode_cabang;
         $log->aktivitas = 'Mengedit Customer '.$request->regulerid.' dari cabang '.$request->cabangnow.' ke '.$request->tocabang;
         $log->device = $device;
         $log->ip = $client_ip;
         $log->save();

      
          $response=array(
            'status' => 'success',
          );
          return response()->json($response,200);
   }

   public function page_custrank_area()
   {
     $skac = new KoneksiController;
      $koneksi= $skac -> KoneksiDC();
      $kueri= "SELECT kode,alias FROM webapp.cabangs WHERE kode <> 'c000'";
      $result=$koneksi -> query($kueri);
      while ($row=$result->fetch_object()) {
        $collection[] = Array(
          'kode' => $row->kode,
          'alias' => $row->alias,
        );
      }$result->close();
      $cabangs = collect($collection);
      $nameroute = Route::currentRouteName();
      return view ('custrank.indexarea',['cabangs' => $cabangs,'nameroute'=> $nameroute]);
   }
   public function data_custrank_area(Request $request)
   {
      $cabang = $request->cabang;
      // dd($cabang);
      $tahun = date("Y", strtotime($request->f2tglAwal));
      $tglawal = date("Y-m-d", strtotime($request->f2tglAwal));
      $tglakhir = date("Y-m-d", strtotime("$request->f2tglAkhir +1 day"));
      $skac = new KoneksiController;
      $koneksi= $skac -> KoneksiDC();
      $kueri= "SELECT b.update_cabang,b.name,b.titel,b.ccc_level,b.alamat,b.telp,b.hp,b.kota,SUM(a.total) AS totalbelanja,COUNT(a.nota) AS totalnota 
      FROM webapp.sales_nota_".$tahun." a,webapp.customers b 
      WHERE a.customer_id=b.id AND a.tgl BETWEEN '$tglawal' AND '$tglakhir' AND a.nota LIKE '".$cabang."%' GROUP BY a.customer_id ";
      $result=$koneksi -> query($kueri);
      $count = $result->num_rows;
      if ($count>0) {
        while ($row=$result->fetch_object()) {
          $response[]=(object) array(
            "cabang" => $row->update_cabang,
            "name" => $row->name,
            "titel" => $row->titel,
            "ccc_level" => $row->ccc_level,
            "alamat" => $row->alamat,
            "kota" => $row->kota,
            "telp" => $row->telp,
            "hp" => $row->hp,
            "totalnota" => $row->totalnota,
            "totalbelanja" => $row->totalbelanja,
          );
        }$result->close();
      } else {
        $response = [ ];
      }
      return Datatables::of($response)->make(true);
   }

    public function page_cekstok_area()
    {
      return view('itemstok_perkode.index');
    }


    public function data_cekstok_area(Request $request)
    {

        $kobar = $request->kodebarang;
        $detail = DB::connection('mysql_external')->table('webapp.items')
        ->where('items.id',$kobar)
        ->where('items.hidden',0)
        ->select('id','nama','harga_jawa','harga_luar_jawa','harga_batam','suplier','nomor_ijin_edar')->get();

          if (count($detail) == 0) {
            $item = [
              'id' => 'data tidak ditemukan',
              'nama' => 'data tidak ditemukan',
              'produsen' => 'data tidak ditemukan',
              'nie' => 'data tidak ditemukan',
              'jawa' => 'data tidak ditemukan',
              'luarjawa' => 'data tidak ditemukan',
              'batam' => 'data tidak ditemukan',
            ];
            $data=[];
            $datagudang=[];
            $response = [
              'msg' => 'Success',
              'item' => $item,
              'data' => $data,
              'gudang' => $datagudang,              
            ];
          }else{
                    $ppnjawa=$detail[0]->harga_jawa * 0.10;
                    $hargajawa=$detail[0]->harga_jawa + $ppnjawa;

                    $ppn_luar_jawa=$detail[0]->harga_luar_jawa * 0.10;
                    $harga_luar_jawa=$detail[0]->harga_luar_jawa + $ppn_luar_jawa;

                    $ppnbatam=$detail[0]->harga_batam * 0.10;
                    $hargabatam=$detail[0]->harga_batam + $ppnbatam;
            $item = [
              'id' => $detail[0]->id,
              'nama' => $detail[0]->nama,
              'produsen' => $detail[0]->suplier,
              'nie' => ($detail[0]->nomor_ijin_edar == 1 ? 'YA' : 'Tidak'),
              'jawa' => $hargajawa,
              'luarjawa' => $harga_luar_jawa,
              'batam' => $hargabatam,
            ];

            $skac = new KoneksiController;
            $koneksi= $skac -> KoneksiDC();
            $user_id = Auth::user()->id;
            $randomtoken=uniqid();
            $recid_session=$randomtoken."".$user_id;
            $namatabel="tmp_stok_barang".$recid_session;

            $sql = "CREATE TABLE webapp.".$namatabel." (
                kodecabang VARCHAR(33) NOT NULL,
                stok int(10) DEFAULT 0,
                created_at TIMESTAMP,
                PRIMARY KEY (kodecabang)
            )";
            $koneksi->query($sql);

            $kueri= "SELECT kode FROM cobradental_master_pos.cabang_new WHERE kode not like '%c000%' AND kode like '%c0%' ORDER BY kode";
            $result=$koneksi -> query($kueri);
            while ($row=$result->fetch_object()) {
                $kode=$row->kode;

                $kueritgl= "SELECT tgl FROM ".$kode.".historysaldo ORDER BY tgl DESC LIMIT 1 ";
                $resulttgl=$koneksi -> query($kueritgl);
                $row2 = $resulttgl->fetch_object();
                $tgl = $row2->tgl;

                $kueristok="INSERT INTO webapp.".$namatabel." (kodecabang,stok,created_at)
                SELECT '".$kode."',stok,NOW() FROM ".$kode.".historysaldo WHERE tgl='$tgl' AND kobar='$kobar' ";
                $resultstok=$koneksi->query($kueristok);

                $kueristokgd="INSERT INTO webapp.".$namatabel." (kodecabang,stok,created_at)
                VALUES ('gd6',(SELECT stok FROM gd6.gd_databarang WHERE kode_cabang='$kobar' limit 1),NOW())";
                $resultstokgd=$koneksi->query($kueristokgd);                
            }$result->close();

            $datastok = DB::connection('mysql_external')->table('webapp.'.$namatabel.'')->join('webapp.cabangs', ''.$namatabel.'.kodecabang', '=', 'cabangs.kode')
            ->select('kode','alias','kota','stok')->get();

            // $datastokgudang = DB::connection('mysql_external')->table('gd6.gd_databarang')
            // ->where('kode_cabang', $kobar)
            // ->select('kode_cabang','stok')->get();            

            $data=$datastok;
            // $datagudang=$datastokgudang;
            $response = [
              'msg' => 'Success',
              'item' => $item,
              'data' => $data,
              // 'gudang' => $datagudang,                
            ];

            $drop="DROP TABLE IF EXISTS webapp.".$namatabel;
            $koneksi->query($drop);
          }

          return response()->json($response,200);
    }

    public function page_target()
    {
            // $cabang = Auth::user()->kode_cabang;
            $users = User::select(['id', 'name'])
            ->where('role_id','3')
            // ->where('kode_cabang',$cabang)
            ->where('active','1')->get();
      $now = date("Y-m");
      $judul = date("M Y");
      $sebelumnya = date("Y-m", strtotime("$now -1 month"));
      $berikutnya = date("Y-m", strtotime("$now +1 month"));
      $tahun[]=array(
          "judul" => $judul,
          "now" => $now,
          "pre" => $sebelumnya,
          "next" => $berikutnya,
      );
            return view ('targetsalesarea.index',['tahun' => $tahun,'users' => $users]);
    }


    public function page_target2($id)
    {
        $cabang = Auth::user()->kode_cabang;
        $users = User::select(['id', 'name'])
        ->where('role_id','3')
        // ->where('kode_cabang',$cabang)
        ->where('active','1')->get();
      $judul = date("M Y", strtotime("$id"));
        $sebelumnya = date("Y-m", strtotime("$id -1 month"));
        $berikutnya = date("Y-m", strtotime("$id +1 month"));
      $tahun[]=array(
          "now" => $id,
          "judul" => $judul,
          "pre" => $sebelumnya,
          "next" => $berikutnya,
      );
      return view ('targetsalesarea.index',['tahun' => $tahun,'users' => $users]);
    }

    public function target_show(Request $request)
    {
      $cabang = Auth::user()->kode_cabang;
     if(request()->ajax())
     {
      if(!empty($request->bulanfilter)){ 
          $bulan = $request->bulanfilter."-01";

          $kueri = "SELECT a.user_id,a.target_kunjungan,a.keterangan,b.name,b.kode_cabang
          FROM targets a INNER JOIN users b ON a.user_id=b.id 
          WHERE a.periode='$bulan'";
          $bulan_user= $request->bulanfilter; 
        }
      // else if (!empty($request->bulan)) {
      //     $bulan = $request->bulan."-01";
      //   }
      else{
          $bulan = $request->bulan."-01";        
          $kueri = "SELECT a.user_id,a.target_kunjungan,a.keterangan,b.name,b.kode_cabang
          FROM targets a INNER JOIN users b ON a.user_id=b.id 
          WHERE a.periode='$bulan'"; 
          $bulan_user= $request->bulan;       
        }

      // print    "{\"data\":[] }"; //output json andro
      // 
      $skac = new KoneksiController;
      $koneksi= $skac -> KoneksiDenganDB();
      // $kueri= "SELECT b.kode_cabang,b.name,b.alamat,SUM(a.total) AS totalbelanja,COUNT(a.nota) AS totalnota 
      // FROM webapp.sales_nota_".$tahun." a,webapp.customers b 
      // WHERE a.customer_id=b.id AND a.nota LIKE '".$cabang.".%' GROUP BY a.customer_id ";

      $result=$koneksi -> query($kueri);
      $count = $result->num_rows;
      if ($count>0) {
        while ($row=$result->fetch_object()) {
            $user_id=$row->user_id;
                $kueri2 = "SELECT id FROM plans a 
                WHERE a.user_id='$user_id' 
                AND a.status='3' 
                AND a.tgl LIKE '".$bulan_user."-%' ";

                $result2=$koneksi -> query($kueri2);
                $count2 = $result2->num_rows;
                $prosentase = round(($count2/$row->target_kunjungan)*100) ." %";
                // $prosentase ="sdf%";
                $response[]=(object) array(
                  "name" => $row->name,
                  "kode_cabang" => $row->kode_cabang,
                  "target_kunjungan" => $row->target_kunjungan,
                  "keterangan" => $row->keterangan,
                  "jml_kunjungan" => $count2,
                  "prosentase" => $prosentase,
                );
        }$result->close();
      } else {
        $response = [ ];
      }
  } //ajax

      return Datatables::of($response)->make(true);
    }



}
