<?php

namespace App\Http\Controllers;

use App\User; //model tabel users
use App\jabatan; //model tabel users
use App\Item; //model tabel items
use App\Target; //model tabel targets
use App\Log; //model tabel logs
use Session; // untuk session log
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator; // validator

use Illuminate\Support\Facades\Auth; //untuk session auth
use Yajra\Datatables\Datatables; // untuk datatables

class KatoController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('role:user');
	}

	public function sales()
	{
		$jabatans = Jabatan::select(['id', 'name'])
			->whereNotIn('id', [1, 2, 3])
			->get();
		// dd($jabatans->toArray());
		// return view ('datasales.index');
		return view('datasales.index', ['jabatans' => $jabatans]);
	}

	public function SearchSales()
	{
		$cabang = Auth::user()->kode_cabang;
		$users2 = DB::table('users')
			->select('users.id', 'users.name', 'users.username', 'users.hp', 'users.password', 'users.kode_cabang', 'jabatan_id', 'jabatans.name as jabatan')
			->where('role_id', '3')
			->where('kode_cabang', $cabang)
			->where('active', '1')
			->leftjoin('jabatans', 'users.jabatan_id', '=', 'jabatans.id')
			->get();

		// $users = User::select(['id', 'name','username','hp', 'password', 'kode_cabang','jabatan_id'])
		// ->where('role_id','3')
		// ->where('kode_cabang',$cabang)
		// ->where('active','1')
		// ->with('jabatan:id,name');

		return Datatables::of($users2)
			->removeColumn('password')
			->make(true);
	}

	public function destroy($id)
	{
		$user = User::find($id);

		$name = $user->username;
		$iduser = Auth::user()->id;
		$device = Session::get('device');
		$client_ip = Session::get('client_ip');

		if ($user) {
			$user->delete();
			$log = new Log;
			$log->user_id = $iduser;
			$log->kode_cabang = Auth::user()->kode_cabang;
			$log->aktivitas = 'Delete Sales ' . $id . ' - ' . $name;
			$log->device = $device;
			$log->ip = $client_ip;
			$log->save();
		} else {
			abort(404);
		}

		return redirect('sales');
	}
	//untuk menghapus sales
	public function update($id)
	{
		$user = User::find($id);
		$name = $user->username;
		$iduser = Auth::user()->id;
		$device = Session::get('device');
		$client_ip = Session::get('client_ip');

		if ($user) {
			$user->username = 'del ' . $id . ' By ' . $iduser;
			$user->google_contact = '0';
			$user->active = '0';
			$user->save();
			$log = new Log;
			$log->user_id = $iduser;
			$log->kode_cabang = Auth::user()->kode_cabang;
			$log->aktivitas = 'Delete Sales ' . $id . ' - ' . $name;
			$log->device = $device;
			$log->ip = $client_ip;
			$log->save();
		} else {
			abort(404);
		}
	}
	public function editpasswordsales(Request $request)
	{
		$this->validate($request, [
			'password' => 'nullable|string|min:5|confirmed',
			'jabatan' => 'required',
		]);
		if ($request->password == null) {
			$username = $request->username;
			$user = User::where('username', $username)->first();
			$user->jabatan_id = $request->jabatan;
			$user->hp = $request->hp;
			$user->google_contact = 0;
			$user->save();

			$iduser = Auth::user()->id;
			$device = Session::get('device');
			$client_ip = Session::get('client_ip');
			$log = new Log;
			$log->user_id = $iduser;
			$log->kode_cabang = Auth::user()->kode_cabang;
			$log->aktivitas = 'Update hp ' . $user->name . ' - ' . $user->id;
			$log->device = $device;
			$log->ip = $client_ip;
			$log->save();

			print    "{\"status\": \"jabatan\" }";
		} else {
			$password = bcrypt($request->password);
			$username = $request->username;
			$user = User::where('username', $username)->first();
			$user->jabatan_id = $request->jabatan;
			$user->hp = $request->hp;
			$user->google_contact = 0;
			$user->password = $password;
			$user->jabatan_id = $request->jabatan;
			$user->save();

			$iduser = Auth::user()->id;
			$device = Session::get('device');
			$client_ip = Session::get('client_ip');
			$log = new Log;
			$log->user_id = $iduser;
			$log->kode_cabang = Auth::user()->kode_cabang;
			$log->aktivitas = 'Update password ' . $user->name . ' - ' . $user->id;
			$log->device = $device;
			$log->ip = $client_ip;
			$log->save();
			print    "{\"status\": \"success\" }";
		}
	}
	public function registersales(Request $request)
	{
		$this->validate(
			$request,
			[
				'username' => 'required|string|unique:users|min:5',
				'password' => 'required|string|min:5|confirmed',
				'jabatan' => 'required',
			],
			[
				'username.unique' => 'username sudah dipakai',
				'username.min' => 'minimal 5 karakter',
				'password.min' => 'minimal 5 karakter'
			]
		);


		$cabang = Auth::user()->kode_cabang;
		$password = bcrypt($request->password);
		$username = str_replace(' ', '', $request->username);
		// $username = $request->username;
		$name = ucwords($request->name);

		$new_user = DB::table('users')->insertGetId(
			array(
				'name' => $name,
				'username' => $username,
				'password' => $password,
				'role_id' => 4,
				'jabatan' => 'Manager Area',
				'jabatan_id' => $request->jabatan,
				'kode_cabang' => $cabang,
				'hp' => $request->hp,
				'created_at' => date('Y-m-d H:i:s')
			)
		);


		$iduser = Auth::user()->id;
		$device = Session::get('device');
		$client_ip = Session::get('client_ip');
		$log = new Log;
		$log->user_id = $iduser;
		$log->kode_cabang = Auth::user()->kode_cabang;
		$log->aktivitas = 'Create Sales - ' . $name . ' - ' . $new_user;
		$log->device = $device;
		$log->ip = $client_ip;
		$log->save();

		// $id = DB::table('logs')->insertGetId(
		//  array('iduser' => $iduser, 'aktivitas' => 'Create Sales '.$username,
		//      'device' => $device)
		// ); 
		// dd($id);

		// Log::create([
		//  'aksi' => ucwords($request->name),
		// ]);

		// return redirect()->route('DataSales');
		return redirect()->back();
	}
	public function page_target()
	{
		$cabang = Auth::user()->kode_cabang;
		$users = User::select(['id', 'name'])
			->where('role_id', '3')
			->where('kode_cabang', $cabang)
			->where('active', '1')->get();
		$now = date("Y-m");
		$judul = date("M Y");
		$sebelumnya = date("Y-m", strtotime("$now -1 month"));
		$berikutnya = date("Y-m", strtotime("$now +1 month"));
		$tahun[] = array(
			"judul" => $judul,
			"now" => $now,
			"pre" => $sebelumnya,
			"next" => $berikutnya,
		);
		return view('targetsales.index', ['tahun' => $tahun, 'users' => $users]);
	}
	public function page_target2($id)
	{
		$cabang = Auth::user()->kode_cabang;
		$users = User::select(['id', 'name'])
			->where('role_id', '3')
			->where('kode_cabang', $cabang)
			->where('active', '1')->get();
		$judul = date("M Y", strtotime("$id"));
		$sebelumnya = date("Y-m", strtotime("$id -1 month"));
		$berikutnya = date("Y-m", strtotime("$id +1 month"));
		$tahun[] = array(
			"now" => $id,
			"judul" => $judul,
			"pre" => $sebelumnya,
			"next" => $berikutnya,
		);
		return view('targetsales.index', ['tahun' => $tahun, 'users' => $users]);
	}
	public function target_show(Request $request)
	{
		$cabang = Auth::user()->kode_cabang;
		$bulan = $request->bulan . "-01";
		// print    "{\"data\":[] }"; //output json andro
		// 
		$skac = new KoneksiController;
		$koneksi = $skac->KoneksiDenganDB();
		// $kueri= "SELECT b.kode_cabang,b.name,b.alamat,SUM(a.total) AS totalbelanja,COUNT(a.nota) AS totalnota 
		// FROM webapp.sales_nota_".$tahun." a,webapp.customers b 
		// WHERE a.customer_id=b.id AND a.nota LIKE '".$cabang.".%' GROUP BY a.customer_id ";
		$kueri = "SELECT a.id as id, a.user_id,a.target_kunjungan,a.keterangan,b.name
		  FROM targets a INNER JOIN users b ON a.user_id=b.id 
		  WHERE a.kode_cabang='$cabang' AND a.periode='$bulan'";
		$result = $koneksi->query($kueri);
		$count = $result->num_rows;
		if ($count > 0) {
			while ($row = $result->fetch_object()) {
				$user_id = $row->user_id;
				$kueri2 = "SELECT id FROM plans a 
								WHERE a.user_id='$user_id' 
								AND a.status='3' 
								AND a.kode_cabang='$cabang'
								AND a.tgl LIKE '" . $request->bulan . "-%' ";

				$result2 = $koneksi->query($kueri2);
				$count2 = $result2->num_rows;
				$prosentase = round(($count2 / $row->target_kunjungan) * 100) . " %";
				// $prosentase ="sdf%";
				$response[] = (object) array(
					"id" => $row->id,
					"name" => $row->name,
					"target_kunjungan" => $row->target_kunjungan,
					"keterangan" => $row->keterangan,
					"jml_kunjungan" => $count2,
					"prosentase" => $prosentase,
				);
			}
			$result->close();
		} else {
			$response = [];
		}
		return Datatables::of($response)->make(true);
	}
	public function addtarget(Request $request)
	{
		$this->validate($request, [
			'sales' => 'required',
			'kunjungan' => 'required',
		]);

		$cabang = Auth::user()->kode_cabang;
		$idsales = $request->sales;
		$kunjungan = $request->kunjungan;
		$bulan = $request->periode;
		$periode = $request->periode . "-1";

		$targetsales = Target::where('user_id', $idsales)
			->where('kode_cabang', $cabang)
			->where('periode', $periode)
			->first();
		// dd($targetsales);

		if ($targetsales) {
			// return redirect()->back()->with('message', 'Sudah Cekin');
			// return Response::json(['error' => 'Error msg']);
			return redirect()->route('page_target2', [$bulan])->with('danger', 'Input gagal,sales sudah diinput');
			// return response()->json(['error' => 'Anda Masih mempunyai Status CekIn'], 404);
		}


		$new_user = DB::table('targets')->insertGetId(
			array(
				'user_id' => $idsales,
				'kode_cabang' => $cabang,
				'periode' => $periode,
				'target_kunjungan' => $kunjungan,
				'keterangan' => $request->keterangan,
				'created_at' => date('Y-m-d H:i:s')
			)
		);


		$iduser = Auth::user()->id;
		$device = Session::get('device');
		$client_ip = Session::get('client_ip');
		$log = new Log;
		$log->user_id = $iduser;
		$log->kode_cabang = Auth::user()->kode_cabang;
		$log->aktivitas = 'Create target kunjungan ' . $idsales . ' - ' . $bulan . ' - ' . $kunjungan;
		$log->device = $device;
		$log->ip = $client_ip;
		$log->save();

		return redirect()->route('page_target2', [$bulan]);
	}

	public function edittarget(Request $request)
	{

		$rules = array(
			'editid'  =>  'required',
			'edittarget' => 'required'
		);

		$error = Validator::make($request->all(), $rules);

		if ($error->fails()) {
			return response()->json(['error' => $error->errors()->all()]);
		} else {
			Target::whereId($request->editid)->update([
				'target_kunjungan' => $request->edittarget
			]);
			return response()->json(['success' => 'Data berhasil diubah']);
		}
	}

	public function page_cekstok_kato()
	{
		return view('itemstok_kato.index');
	}


	public function data_cekstok_kato(Request $request)
	{

		$kobar = $request->kodebarang;
		$detail = DB::connection('mysql_external')->table('webapp.items')
			->where('items.id', $kobar)
			->where('items.hidden', 0)
			->select('id', 'nama', 'harga_jawa', 'harga_luar_jawa', 'harga_batam', 'suplier', 'nomor_ijin_edar')->get();

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
			$data = [];
			$datagudang = [];
			$response = [
				'msg' => 'Success',
				'item' => $item,
				'data' => $data,
				'gudang' => $datagudang,
			];
		} else {
			$ppnjawa = $detail[0]->harga_jawa * 0.10;
			$hargajawa = $detail[0]->harga_jawa + $ppnjawa;

			$ppn_luar_jawa = $detail[0]->harga_luar_jawa * 0.10;
			$harga_luar_jawa = $detail[0]->harga_luar_jawa + $ppn_luar_jawa;

			$ppnbatam = $detail[0]->harga_batam * 0.10;
			$hargabatam = $detail[0]->harga_batam + $ppnbatam;
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
			$koneksi = $skac->KoneksiDC();
			$user_id = Auth::user()->id;
			$randomtoken = uniqid();
			$recid_session = $randomtoken . "" . $user_id;
			$namatabel = "tmp_stok_barang" . $recid_session;

			$sql = "CREATE TABLE webapp." . $namatabel . " (
                kodecabang VARCHAR(33) NOT NULL,
                stok int(10) DEFAULT 0,
                created_at TIMESTAMP,
                PRIMARY KEY (kodecabang)
            )";
			$koneksi->query($sql);

			$kueri = "SELECT kode FROM cobradental_master_pos.cabang_new WHERE kode not like '%c000%' AND kode like '%c0%' ORDER BY kode";
			$result = $koneksi->query($kueri);
			while ($row = $result->fetch_object()) {
				$kode = $row->kode;

				$kueritgl = "SELECT tgl FROM " . $kode . ".historysaldo ORDER BY tgl DESC LIMIT 1 ";
				$resulttgl = $koneksi->query($kueritgl);
				$row2 = $resulttgl->fetch_object();
				$tgl = $row2->tgl;

				$kueristok = "INSERT INTO webapp." . $namatabel . " (kodecabang,stok,created_at)
                SELECT '" . $kode . "',stok,NOW() FROM " . $kode . ".historysaldo WHERE tgl='$tgl' AND kobar='$kobar' ";
				$resultstok = $koneksi->query($kueristok);

				$kueristokgd = "INSERT INTO webapp." . $namatabel . " (kodecabang,stok,created_at)
                VALUES ('gd6',(SELECT stok FROM gd6.gd_databarang WHERE kode_cabang='$kobar' limit 1),NOW())";
				$resultstokgd = $koneksi->query($kueristokgd);
			}
			$result->close();

			$datastok = DB::connection('mysql_external')->table('webapp.' . $namatabel . '')->join('webapp.cabangs', '' . $namatabel . '.kodecabang', '=', 'cabangs.kode')
				->select('kode', 'alias', 'kota', 'stok')->get();

			// $datastokgudang = DB::connection('mysql_external')->table('gd6.gd_databarang')
			// ->where('kode_cabang', $kobar)
			// ->select('kode_cabang','stok')->get();            

			$data = $datastok;
			// $datagudang=$datastokgudang;
			$response = [
				'msg' => 'Success',
				'item' => $item,
				'data' => $data,
				// 'gudang' => $datagudang,                
			];

			$drop = "DROP TABLE IF EXISTS webapp." . $namatabel;
			$koneksi->query($drop);
		}

		return response()->json($response, 200);
	}
}