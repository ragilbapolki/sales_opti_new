<?php

namespace App\Http\Controllers;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; //untuk session auth
use Illuminate\Support\Facades\DB; //untuk raw DB
use Illuminate\Support\Str;//untuk substring
use Yajra\Datatables\Datatables; // untuk datatables
use App\Pemesanan; //model tabel pemesanan
use App\DetailPemesanan; //model tabel pemesanan_detil


class PemesananCustomerController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function page_pemesanan()
    {
       return view('pemesanancustomer.index');
    }     
    
    public function invoice(){
      $cabang = Auth::user()->kode_cabang;      
      $kd="";
      $query = DB::connection('mysql')->table('pemesanan')
      ->select('auto_id');
      // ->select(DB::raw('MAX(RIGHT(nota,4)) as nota'));
      // if ($query->count()>0) {
       foreach ($query->get() as $key ) {
       // $tmp = ((int)$key->nota)+1;
       // $kd = sprintf("%04s", $tmp);
        $kd = ((int)$key->auto_id)+1;
       }
      // }else {
      //   $kd = "0001";
      //       }
        $notasales = 'PSN-'.$cabang.date('ymdhis').$kd;
        // echo json_encode($notasales);
        return response()->json(['invoice'=>$notasales]);
    }


    public function pesan_stok(Request $request)
    {
          $cabang = Auth::user()->kode_cabang;
          $skac = new KoneksiController;
          $koneksi= $skac -> KoneksiCobraMasterPos();
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


      public function saveall(Request $request){
              $validation = Validator::make($request->all(), [
                  'sales' => 'required',
                  'nota'  => 'required',
                  'ajxkobar'  => 'required',
                  'ajxqty'  => 'required',                                    
              ]);
      
              $error_array = array();
              $success_output = '';
              if ($validation->fails())
              {
                  foreach($validation->messages()->getMessages() as $field_name => $messages)
                  {
                      $error_array[] = $messages;
                  }
              }
              else
              {
                  if($request->get('button_action') == "insert")
                  {

                    $namacustomer = $request->get('namacustmember');  
                                        
                    if($request->get('chbtunai')=="1"){
                        $tipebayar = $request->get('tipe1');
                        $keterangan = $request->get('ket1');
                        $terbayar = $request->get('bayar');
                    }else{
                        $tipebayar =$request->get('tipe2');
                        $keterangan = $request->get('ket2');
                        $terbayar = $request->get('credit');                                              
                    }                    

                      $pemesanan = new Pemesanan([
                          'nota'    =>  $request->get('nota'),
                          'tgl'    =>  $request->get('tgl'),
                          'totalpenjualan'=>  $request->get('nominal'),
                          'terbayar'    =>  $terbayar,
                          'kembali'    =>  $request->get('kembali'),
                          'kekurangan'    =>  $request->get('kekurangan'),                          
                          'keterangan'    =>  $keterangan,
                          'type'    =>  $tipebayar,
                          'sales'    =>  $request->get('sales'),
                          'customer'     =>  $namacustomer,
                          'type_cust'     =>  $request->get('tipecust'),
                          'status'     =>  '0'
                      ]);
                      $pemesanan->save();
                      $lastid = $pemesanan->nota;                      
                      if(count($request->ajxnama)>0)
                      {        
                        foreach($request->ajxnama as $item =>$v){
                          $data=array(
                            'nota' => $lastid,
                            'kobar' => $request->ajxkobar[$item],
                            'namabarang' => $request->ajxnama[$item],
                            'harga' => $request->ajxgrandharga[$item],
                            'qty' => $request->ajxqty[$item]
                          );
                          DetailPemesanan::insert($data);
                          $success_output = 'Data berhasil ditambahkan !';
                        }
                      }                   
                  }
              }
              $output = array(
                  'error'     =>  $error_array,
                  'success'   =>  $success_output
              );
              return response()->json($output);
      }

      public function page_historypesan(){

        return view('historypemesanancustomer.index');
      }


      public function data_historypesan(){
            $username = Auth::user()->username;
            $jabatan = Auth::user()->jabatan;  
            $cabang = Auth::user()->kode_cabang;             

                $datamaster = Pemesanan::leftJoin('customers','customers.id','=','pemesanan.customer')
                  ->select('auto_id','nota','tgl','totalpenjualan','terbayar','kembali','kekurangan','type','sales','customer',DB::raw('IFNULL(customers.name,"-") as name'),'type_cust','status')
                  ->where('customer', '=', $username)
                  // ->where(DB::raw('substr(nota, 5, 4)'), '=' , $cabang)
                  ->orderBy('tgl', 'DESC');

            return Datatables::of($datamaster)
                ->addColumn('details_url', function($pemesanan) {
                    return url('/historypemesanan-customer/details/' . $pemesanan->nota);
                })
                ->make(true);
      }

      public function detail_historypesan($nota)
      {
        $datadetail = DetailPemesanan::select('auto_id','nota','kobar','namabarang','diskon','harga','qty')->where('nota','=',$nota)->orderBy('nota', 'DESC')
                    ->get();
                    
          return Datatables::of($datadetail)->make(true);
      }      

      public function changestatus(Request $request)
      {
          $pesan = Pemesanan::find($request->id);
          $pesan->status = $request->status;
          $pesan->save();

          if ($request->status== 0) {
            $output = 'Data dicancel kembali !';
          }elseif ($request->status== 1) {
            $output = 'Data telah dikonfirm !';
          }

          return response()->json(['konfirm'=>$output]);
      }

      public function export_historypesan(Request $request){
            $kode_cabang = Auth::user()->kode_cabang; 
        if(request()->ajax())
          {
          if(!empty($request->dateawal && $request->dateakhir))
          {
                  $exportmaster = Pemesanan::join('pemesanan_detil','pemesanan_detil.nota','=','pemesanan.nota')
                    ->leftJoin('customers','customers.id','=','pemesanan.customer')
                    ->select('pemesanan.nota','tgl','sales','customer',DB::raw('IFNULL(customers.name,"-") as name'),'type_cust','kobar','namabarang','diskon','harga','qty','keterangan','pemesanan.status')
                    ->where(DB::raw('substr(pemesanan.nota, 5, 4)'), '=' , $kode_cabang)
                    ->whereBetween('tgl', [$request->dateawal, $request->dateakhir])
                    ->orderBy('tgl', 'DESC');
          }
        else
          {
                  $exportmaster = Pemesanan::join('pemesanan_detil','pemesanan_detil.nota','=','pemesanan.nota')
                    ->leftJoin('customers','customers.id','=','pemesanan.customer')                  
                    ->select('pemesanan.nota','tgl','sales','customer',DB::raw('IFNULL(customers.name,"-") as name'),'type_cust','kobar','namabarang','diskon','harga','qty','keterangan','pemesanan.status')
                    ->where(DB::raw('substr(pemesanan.nota, 5, 4)'), '=' , $kode_cabang)
                    ->orderBy('tgl', 'DESC');            
          }
        }


        return Datatables::of($exportmaster)
                          ->addIndexColumn()               
                          ->make(true);
        
      }
        
}