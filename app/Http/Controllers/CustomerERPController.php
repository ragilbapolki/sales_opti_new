<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer; //model tabel Customers
use App\User; //model tabel users
use App\Plan; //model tabel users
use App\Cekout; //model tabel users
use App\WebsalesTmpTransaksi; //model tabel logs

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; //untuk session auth
use Yajra\Datatables\Datatables; // untuk datatables

class CustomerERPController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function page_cust_aktivitas()
  {
    return view('custaktivitasERP.index');
  }

  public function page_cust_ccc()
  {
    return view('custcccERP.index');
  }
  public function data_cust_ccc()
  {
    // $data_ccc = Customer::select('id','ccc','ccc_reg','ccc_aktif','ccc_level','ccc_balance','ccc_poin','last_transaksi','name','tgl_lahir' ,'titel','alamat','kota','telp','hp','email')->where('ccc', '<>', '');

    // $data_ccc = DB::connection('mysql_external')->table('customers')
    // ->select('id','ccc','ccc_reg','ccc_aktif','ccc_level','ccc_balance','ccc_poin','last_transaksi','name','tgl_lahir' ,'titel','alamat','kota','telp','hp','email')
    // ->where('ccc','<>','')
    // ->where('ccc_reg','<>','c000');
    // $data_ccc = DB::connection('mysql_external_two')->table('online_cust')
    //   ->select('cust_autonumber', 'cust_reward_id', 'cabang_reg_ccc', 'ccc_aktif', 'cust_reward_level', 'tgldaftar', 'ccc_poin_balance', 'ccc_poin', 'last_transaction', 'nama', 'birthdate', 'titel', 'alamat', 'kota', 'telp', 'hp', 'kodepos', 'email', 'voucher')
    //   ->where([['cust_reward_id', '<>', ''], ['cust_reward_level', '<>', ''], ['cabang_reg_ccc', '<>', 'c000']]);
    $data_ccc = DB::connection('mysql_erp')->select("SELECT no_cust,no_ccc,nama_member,tempat_lahir,tgl_lahir,alamat,alamat_detail,nik,
    no_npwp,jns_kelamin,er_md_member.id_list_title,no_kontak,email,er_md_member.status,tgl_register,
    id_user,er_md_member.id_jenis_member,id_jns_faktur, jenis_member, title
    FROM er_md_member
    LEFT JOIN er_md_jenis_member ON er_md_jenis_member.id_jenis_member = er_md_member.id_jenis_member
    LEFT JOIN er_md_list_title ON er_md_list_title.id_list_title = er_md_member.id_list_title
    WHERE no_ccc IS NOT NULL OR no_ccc != 0");

    // var_dump($data_ccc);
    // die();

    // dd($data_ccc);

    return Datatables::of($data_ccc)->make(true);
  }

  public function search_cust_aktivitas(Request $request)
  {
    $this->validate($request, [
      'customer' => 'required',
    ]);
    $id =  $request->customer;

    // $customer = Customer::select('id', 'name', 'alamat', DB::raw('DATE_FORMAT(tgl_lahir,"%d %M") as tgl_lahir'))->find($id);

    $customer = collect(DB::connection('mysql_erp')->select('SELECT id_member, no_cust, nama_member, DATE_FORMAT(tgl_lahir,"%d %M") as tgl_lahir, alamat_detail FROM er_md_member WHERE id_member=' . $id . ''))->first();

    $cekout = DB::connection('mysql')->table('cekouts_erp')->select('user_id', 'name', 'customer_id', 'cekouts_erp.created_at', 'keterangan', DB::raw('DATE_FORMAT(tgl,"%d-%m-%Y") as tgl'))
      ->where('customer_id', $id)
      ->join('users', 'cekouts_erp.user_id', '=', 'users.id')
      ->orderBy('cekouts_erp.id', 'desc')->take(5)->get();

    if ($cekout == NULL) {
      $cekout = [];
    }
    $data = [
      'customer' => $customer,
      'plan' => $cekout,
    ];

    $response = [
      'msg' => 'Success',
      'data' => $data
    ];
    return response()->json($response, 200);
  }

  public function tabel_show_aktivitas(Request $request)
  {
    $user_id = Auth::user()->id;
    $customer_id = $request->idcust;
    $skac = new KoneksiController;
    $koneksi = $skac->KoneksiDC();
    $koneksierp = $skac->KoneksiERP();
    $customerArray = Customer::find($customer_id);

    // if (empty ($customerArray->ccc)) { //bukan member ccc
    // $DelTmpTransk = $koneksi->query("DELETE FROM webapp.sales_penjualan WHERE user_id='$user_id'");
    // $DelTmpTranskdetil = $koneksi->query("DELETE FROM webapp.sales_penjualan_detil WHERE user_id='$user_id'");

    $kueri = 'SELECT id_penjualan,no_nota,tgl_tansaksi,totalbayar,id_customer FROM er_str_penjualan WHERE id_customer=' . $customer_id . ' AND id_penjualan NOT IN (SELECT id_penjualan FROM er_str_retur_penjualan) ORDER BY tgl_tansaksi DESC';
    // $kueri = DB::connection('mysql_erp')->select('SELECT id_penjualan,no_nota,tgl_tansaksi,totalbayar,id_customer FROM er_str_penjualan WHERE id_customer=' . $customer_id . ' AND id_penjualan NOT IN (SELECT id_penjualan FROM er_str_retur_penjualan) ORDER BY tgl_tansaksi DESC');


    $result = $koneksierp->query($kueri);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_object()) {
        $nota = $row->id_penjualan;
        $tgl = $row->tgl_tansaksi;
        $pisah = explode(".", $row->no_nota);
        $cabang = $pisah[0];

        $detail = DB::connection('mysql_erp')->select("SELECT er_str_penjualan_detail.id_penjualan,id_penjualan_detail,er_str_penjualan_detail.id_product AS id_product,
        product_price,er_str_penjualan_detail.qty AS qty_product, diskon, harga_per_satuan_beli,
                er_md_product.deskripsi AS nama_product,
                ROUND(((subtotal/1.1)+((diskon/1.1)*qty))/qty) AS hargasatuan,
                ROUND((subtotal/1.1)+((diskon/1.1)*qty)) AS subtotal,
                ROUND((diskon/1.1)*qty) AS diskon,
                (0.1 *(((((subtotal/1.1)+((diskon/1.1)*qty))/qty)*qty)-((diskon/1.1)*qty))) AS ppn,
                (SELECT COUNT(id_penjualan) FROM er_str_retur_penjualan WHERE id_penjualan = er_str_penjualan_detail.id_penjualan ) AS retur
                FROM er_str_penjualan_detail
                LEFT JOIN er_md_product ON er_md_product.id_product = er_str_penjualan_detail.id_product
        WHERE er_str_penjualan_detail.id_penjualan = " . $nota . "
        GROUP BY er_str_penjualan_detail.id_penjualan_detail");

        $plans[] = (object) array(
          "tgl" => $row->tgl_tansaksi,
          // "cabang" => $cabang,
          "nota" => $row->no_nota,
          "total" => $row->totalbayar,
          "detail" => $detail,
        );
      }
      $result->close();
      return Datatables::of($plans)->make(true);
    } else {
      print    "{\"data\":[] }"; //output json andro
    }
  }

  public function page_cust_rank()
  {
    $now = date("Y");
    $sebelumnya = date("Y", strtotime("$now -1 year"));
    $berikutnya = date("Y", strtotime("$now +1 year"));
    $tahun[] = array(
      "now" => $now,
      "pre" => $sebelumnya,
      "next" => $berikutnya,
    );
    // dd($tahun);
    return view('custrank.index', ['tahun' => $tahun]);
  }

  public function page_cust_rank2($id)
  {
    $skrang = $id;
    $date = $id . '-01-01';
    $sebelumnya = date('Y', strtotime("$date -1 year"));
    $berikutnya = date("Y", strtotime("$date +1 year"));
    $tahun[] = array(
      "now" => $skrang,
      "pre" => $sebelumnya,
      "next" => $berikutnya,
    );
    return view('custrank.index', ['tahun' => $tahun]);
  }

  public function tabel_show_custrank(Request $request)
  {
    $cabang = Auth::user()->kode_cabang;
    $tahun = $request->tahun;
    // print    "{\"data\":[] }"; //output json andro
    // 
    $skac = new KoneksiController;
    $koneksi = $skac->KoneksiDC();
    $kueri = "SELECT b.update_cabang,b.ccc_level,b.titel,b.name,b.alamat,SUM(a.total) AS totalbelanja,COUNT(a.nota) AS totalnota 
      FROM webapp.sales_nota_" . $tahun . " a,webapp.customers b 
      WHERE a.customer_id=b.id AND a.nota LIKE '" . $cabang . ".%' GROUP BY a.customer_id ";
    $result = $koneksi->query($kueri);
    $count = $result->num_rows;
    if ($count > 0) {
      while ($row = $result->fetch_object()) {
        $response[] = (object) array(
          "cabang" => $row->update_cabang,
          "ccc_level" => $row->ccc_level,
          "titel" => $row->titel,
          "name" => $row->name,
          "alamat" => $row->alamat,
          "totalnota" => $row->totalnota,
          "totalbelanja" => $row->totalbelanja,
        );
      }
      $result->close();
    } else {
      $response = [];
    }
    return Datatables::of($response)->make(true);
  }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         