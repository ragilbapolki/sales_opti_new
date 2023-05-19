<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\ExportAttendancePerFay;
use App\Exports\ExportFilterAttendance;
use Maatwebsite\Excel\Facades\Excel;

class StokERPController extends Controller
{
    //
    public function pagesales()
    {

        if (Auth::user()->kode_cabang === 'CDI') {

            $query =  DB::connection('mysql_erp')->select('SELECT kode_cabang, nama_perusahaan FROM er_md_struktur_organisasi WHERE kode_cabang = "' . Auth::user()->kode_cabang . '"');
            $kodecabang = 'All Cabang';
        } elseif (Auth::user()->kode_cabang !== 'CDI') {
            $query =  DB::connection('mysql_erp')->select('SELECT kode_cabang, nama_perusahaan FROM er_md_struktur_organisasi WHERE kode_cabang = "' . Auth::user()->kode_cabang . '"');
            $kodecabang = $query[0]->kode_cabang;
        }

        $tglnow = date('Y-m-d');
        $tgl = date("d F", strtotime($tglnow));
        return view('stokerp.indexsales', compact('tgl', 'kodecabang'));
    }

    public function page_peritems_erp()
    {
        return view('itemstok_erp.index');
    }
    public function page_listharga_erp()
    {

        $items = DB::connection('mysql_erp')->select('SELECT * FROM er_md_mitra');

        return view('listharga.index', compact('items'));
    }

    public function Pageallcabang()
    {

        $tglnow = date('Y-m-d');
        $tgl = date("d F", strtotime($tglnow));

        if (Auth::user()->kode_cabang === 'CDI') {

            $query =  DB::connection('mysql_erp')->select('SELECT kode_cabang, nama_perusahaan FROM er_md_struktur_organisasi WHERE kode_cabang = "' . Auth::user()->kode_cabang . '"');
            $kodecabang = 'All Cabang';
        } elseif (Auth::user()->kode_cabang !== 'CDI') {
            $query =  DB::connection('mysql_erp')->select('SELECT kode_cabang, nama_perusahaan FROM er_md_struktur_organisasi WHERE kode_cabang = "' . Auth::user()->kode_cabang . '"');
            $kodecabang = $query[0]->kode_cabang;
        }

        return view('stokerp.indexallcabang', compact('tgl', 'kodecabang'));
    }

    public function data_stok_erp(Request $request)
    {

        if (Auth::user()->kode_cabang === 'CDI') {
            $log = DB::connection('mysql_erp')->select('SELECT id_stock, er_md_product.code, er_md_product.deskripsi, nama_perusahaan, SUM(qty) AS qty, harga_per_satuan_jual, (harga_per_satuan_jual*1.11) AS hrgppn, (harga_per_satuan_jual_non_jawa*1.11) AS hrgluarjawappn, price_category,
            IF(price_category="jawa",(harga_per_satuan_jual*1.11),(harga_per_satuan_jual_non_jawa*1.11)) AS fix_harga FROM er_wr_product_stock 
            JOIN er_md_struktur_organisasi ON er_wr_product_stock.id_organisasi = er_md_struktur_organisasi.id_organisasi
            JOIN er_md_product ON er_wr_product_stock.id_product = er_md_product.id_product GROUP BY er_md_product.code,kode_cabang');
        } elseif (Auth::user()->kode_cabang !== 'CDI') {
            $log = DB::connection('mysql_erp')->select('SELECT id_stock, er_md_product.code, er_md_product.deskripsi, nama_perusahaan, SUM(qty) AS qty, harga_per_satuan_jual, (harga_per_satuan_jual*1.11) AS hrgppn,(harga_per_satuan_jual_non_jawa*1.11) AS hrgluarjawappn, price_category,
            IF(price_category="jawa",(harga_per_satuan_jual*1.11),(harga_per_satuan_jual_non_jawa*1.11)) AS fix_harga FROM er_wr_product_stock 
            JOIN er_md_struktur_organisasi ON er_wr_product_stock.id_organisasi = er_md_struktur_organisasi.id_organisasi
            JOIN er_md_product ON er_wr_product_stock.id_product = er_md_product.id_product
            WHERE kode_cabang = "' . Auth::user()->kode_cabang . '" GROUP BY er_md_product.code,kode_cabang');
        }

        return Datatables::of($log)
            ->addColumn('aksi', function ($data) {
                $button = '<a href="javascript:;" class="detaillog" data-id="' . $data->id_stock . '" data-toggle="modal" data-target="#detaillog" data-rel="tooltip" title="Log Detail">Detail</a>';
                return $button;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }


    public function select2product(Request $request)
    {
        $product = DB::connection('mysql_erp')->select('SELECT id_product, er_md_product.code, er_md_product.deskripsi FROM er_md_product WHERE deskripsi LIKE "%' . $request->search . '%" ');

        if (!empty($product[0]->id_product)) {
            foreach ($product as $namaproduct) {
                $productArray[] = array(
                    "id" => $namaproduct->id_product,
                    "text" => $namaproduct->deskripsi
                );
            }
        } else {
            $productArray[] = array(
                "id" => '',
                "text" => '',
            );
        }
        return response()->json(['data' => $productArray]);
    }


    public function select2product_bycode(Request $request)
    {
        $product = DB::connection('mysql_erp')->select('SELECT id_product, er_md_product.code, er_md_product.deskripsi FROM er_md_product WHERE er_md_product.code LIKE "%' . $request->search . '%" ');

        if (!empty($product[0]->id_product)) {
            foreach ($product as $namaproduct) {
                $productArray[] = array(
                    "id" => $namaproduct->id_product,
                    "text" => $namaproduct->code
                );
            }
        } else {
            $productArray[] = array(
                "id" => '',
                "text" => '',
            );
        }
        return response()->json(['data' => $productArray]);
    }

    public function stock_peritems(Request $request)
    {
        $kobar = $request->kodebarang;

        $items =  collect(DB::connection('mysql_erp')->select('SELECT id_product, er_md_product.code as id, er_md_product.deskripsi as nama, nie, harga_per_satuan_jual, (harga_per_satuan_jual*1.11) AS hrgppn, (harga_per_satuan_jual_non_jawa*1.11) AS hrgluarjawappn, nama_perusahaan as produsen  FROM er_md_product 
        LEFT JOIN er_md_mitra ON er_md_mitra.id_mitra = er_md_product.nama_supplier
        WHERE id_product = "' . $kobar . '"'))->first();

        $data = DB::connection('mysql_erp')->select('SELECT id_stock, er_md_product.code, kode_cabang AS kode, er_md_product.deskripsi, nama_perusahaan AS alias, kota, SUM(qty) AS stok, harga_per_satuan_jual FROM er_wr_product_stock 
        JOIN er_md_struktur_organisasi ON er_wr_product_stock.id_organisasi = er_md_struktur_organisasi.id_organisasi
        JOIN er_md_product ON er_wr_product_stock.id_product = er_md_product.id_product
        WHERE er_md_product.id_product = "' . $kobar . '" GROUP BY kode_cabang');

        $respons = [
            'item' => $items,
            'data' => $data
        ];

        return response()->json($respons);
    }

    public function data_list_harga(Request $request)
    {

        $kdbarang = $request->kdbarang;
        $namabarang = $request->namabarang;
        $produsen = $request->produsen;
        $suplier = $request->suplier;

        if ($request->filled('kdbarang')) {
            $data = DB::connection('mysql_erp')->select('SELECT er_md_product.code, id_product, er_md_struktur_organisasi.kode_cabang AS kode, er_md_product.deskripsi, 
            er_md_mitra.nama_perusahaan AS supplier, er_md_struktur_organisasi.nama_perusahaan AS alias, er_md_struktur_organisasi.kota,
            (harga_per_satuan_jual*1.11) AS hrgppn, harga_per_satuan_jual, (harga_per_satuan_jual_non_jawa*1.11) AS hrgluarjawappn 
            FROM er_md_product 
                    JOIN er_md_mitra ON er_md_mitra.id_mitra = er_md_product.nama_supplier
                    JOIN er_md_struktur_organisasi ON er_md_product.id_organisasi = er_md_struktur_organisasi.id_organisasi
                    WHERE id_product = "' . $kdbarang . '"');
        } elseif ($request->filled('namabarang')) {
            if ($request->filled('suplier')) {
                $data = DB::connection('mysql_erp')->select('SELECT er_md_product.code, id_product, er_md_struktur_organisasi.kode_cabang AS kode, er_md_product.deskripsi, 
                er_md_mitra.nama_perusahaan AS supplier, er_md_struktur_organisasi.nama_perusahaan AS alias, er_md_struktur_organisasi.kota,
                (harga_per_satuan_jual*1.11) AS hrgppn, harga_per_satuan_jual, (harga_per_satuan_jual_non_jawa*1.11) AS hrgluarjawappn
                FROM er_md_product 
                        JOIN er_md_mitra ON er_md_mitra.id_mitra = er_md_product.nama_supplier
                        JOIN er_md_struktur_organisasi ON er_md_product.id_organisasi = er_md_struktur_organisasi.id_organisasi
                        WHERE id_product =  "' . $namabarang . '" AND er_md_product.nama_supplier ="' . $suplier . '" ');
            } else {
                $data = DB::connection('mysql_erp')->select('SELECT er_md_product.code, id_product, er_md_struktur_organisasi.kode_cabang AS kode, er_md_product.deskripsi, 
                er_md_mitra.nama_perusahaan AS supplier, er_md_struktur_organisasi.nama_perusahaan AS alias, er_md_struktur_organisasi.kota,
                (harga_per_satuan_jual*1.11) AS hrgppn, harga_per_satuan_jual, (harga_per_satuan_jual_non_jawa*1.11) AS hrgluarjawappn
                FROM er_md_product 
                        JOIN er_md_mitra ON er_md_mitra.id_mitra = er_md_product.nama_supplier
                        JOIN er_md_struktur_organisasi ON er_md_product.id_organisasi = er_md_struktur_organisasi.id_organisasi
                        WHERE id_product =  "' . $namabarang . '"');
            }
        } elseif ($request->filled('produsen')) {
            $data = DB::connection('mysql_erp')->select('SELECT er_md_product.code, id_product, er_md_struktur_organisasi.kode_cabang AS kode, er_md_product.deskripsi, 
            er_md_mitra.nama_perusahaan AS supplier, er_md_struktur_organisasi.nama_perusahaan AS alias, er_md_struktur_organisasi.kota,
            (harga_per_satuan_jual*1.11) AS hrgppn, harga_per_satuan_jual, (harga_per_satuan_jual_non_jawa*1.11) AS hrgluarjawappn 
            FROM er_md_product 
                    JOIN er_md_mitra ON er_md_mitra.id_mitra = er_md_product.nama_supplier
                    JOIN er_md_struktur_organisasi ON er_md_product.id_organisasi = er_md_struktur_organisasi.id_organisasi
                    WHERE er_md_product.nama_supplier ="' . $produsen . '" GROUP BY er_md_product.code');
        }

        return Datatables::of($data)->make(true);
    }


    public function viewdetail(Request $request)
    {
        $kobar = $request->id;
        $cabang = Auth::user()->kode_cabang;
        // $cabang = $request->kode_cabang;
        $idorg =  collect(DB::connection('mysql_erp')->select('SELECT id_organisasi
        FROM er_md_struktur_organisasi
                    WHERE kode_cabang = "' . $cabang . '"'))->first();
        $getidorg = $idorg->id_organisasi;
        $data =  collect(DB::connection('mysql_erp')->select('SELECT SUM(qty) AS stok
        FROM er_wr_product_stock
                    WHERE id_product = "' . $kobar . '" AND id_organisasi = "' . $getidorg . '"'))->first();

        return response()->json($data);
    }
}
