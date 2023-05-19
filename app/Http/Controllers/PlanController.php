<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; //model tabel users
use App\Log; //model tabel logs
use App\Plan; //model tabel plans
use App\Cekin; //model tabel cekins
use App\Cekout; //model tabel cekouts
use App\Customer; //model tabel Customers
use App\Target; //model tabel Customers

use App\Http\Controllers\KoneksiController;
use Illuminate\Support\Facades\Auth; //untuk session auth
use Illuminate\Support\Facades\DB; //untuk raw DB
use Illuminate\Support\Collection; //untuk membuat array kosong
use Yajra\Datatables\Datatables; // untuk datatables
use Session; // untuk session log

class PlanController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('role:user', ['only' => ['plan_per_tgl', 'plan_edit', 'plan_pending', 'plan_approved']]);
  }

  public function page_plan()
  {
    return view('plan.index');
  }

  public function data_plan(Request $request)
  {
    $user_id = Auth::user()->id;
    $kode_cabang = Auth::user()->kode_cabang;
    $role_id = Auth::user()->role_id;
    if (!$request->bulan == null) {
      $bulan = date('Y-m', strtotime($request->bulan));
    } else {
      $bulan = date('Y-m');
    }



    if ($role_id == '3') {
      // $plans = plan::where('user_id', $user_id)
      //         ->where('kode_cabang',$kode_cabang)
      //         ->with('user')->get();
      // $plans = Plan::select('tgl')
      // ->where('kode_cabang',$kode_cabang)
      // ->groupBy('tgl')
      // ->get();
      // $data = DB::table('plans')
      // ->select('tgl', DB::raw('count(*) as total'))
      // ->groupBy('tgl')
      // // ->pluck('total','tgl')
      // ->all();

      // $pending = DB::table('plans')
      // ->select(DB::raw('count(*) as pending, tgl'))
      // ->where('user_id',$user_id)
      // ->where('approve',0)
      // ->groupBy('tgl')
      // ->get();

      $skac = new KoneksiController;
      $koneksi = $skac->KoneksiDenganDB();
      $kueri = "SELECT tgl,status,COUNT(*) AS total FROM plans WHERE user_id='$user_id' AND tgl LIKE '%$bulan%' GROUP BY status,tgl ORDER BY tgl";
      $result = $koneksi->query($kueri);
      while ($row = $result->fetch_object()) {
        if ($row->status == 0) {
          $status = 'pending';
          $color = 'red';
        } elseif ($row->status == 1) {
          $status = 'approve';
          $color = 'orange';
        } elseif ($row->status == 2 or $row->status == 5) {
          $status = 'cekin';
          $color = 'green';
        } elseif ($row->status == 3) {
          $status = 'selesai';
          $color = 'black';
        } elseif ($row->status == 6) {
          $status = 'TanpaApprove';
          $color = 'purple';
        } else {
          $status = 'ditolak';
          $color = 'blue';
        }
        $plans[] = (object) array(
          "tgl" => $row->tgl,
          "total" => $status . ':' . $row->total,
          "color" => $color,
        );
      }
      $result->close();
      $url = 'plan-per-tgl/sales2';
    } else {
      $skac = new KoneksiController;
      $koneksi = $skac->KoneksiDenganDB();
      $kueri = "SELECT tgl,status,COUNT(*) AS total FROM plans WHERE kode_cabang='$kode_cabang' AND tgl LIKE '%$bulan%' GROUP BY status,tgl ORDER BY tgl";
      $result = $koneksi->query($kueri);
      while ($row = $result->fetch_object()) {
        if ($row->status == 0) {
          $status = 'pending';
          $color = 'red';
        } elseif ($row->status == 1) {
          $status = 'approve';
          $color = 'orange';
        } elseif ($row->status == 2 or $row->status == 5) {
          $status = 'cekin';
          $color = 'green';
        } elseif ($row->status == 3) {
          $status = 'selesai';
          $color = 'black';
        } elseif ($row->status == 6) {
          $status = 'TanpaApprove';
          $color = 'purple';
        } else {
          $status = 'ditolak';
          $color = 'blue';
        }

        $plans[] = (object) array(
          "tgl" => $row->tgl,
          "total" => $status . ':' . $row->total,
          "color" => $color,
        );
      }
      $result->close();
      $url = 'plan-per-tgl';
    }

    if (!empty($plans[0]->tgl)) {
      foreach ($plans as $plan) {
        $planArray[] = array(
          // 'title' => $plan->user->name,
          'title' => $plan->total,
          'start' => $plan->tgl,
          "url" => $url . '/' . $plan->tgl,
          "color" => $plan->color,
        );
      }
    } else {
      $planArray[] = array(
        'title' => '',
        'start' => '',
        "url" => '',
        "color" => '',
      );
    }

    $jsonPlan = json_encode($planArray);
    return $jsonPlan;
  }

  public function plan_per_tgl_sales($id)
  {
    $date = date_create($id);
    $tglview = date_format($date, "d F Y");
    $data = [
      'tgl' => $id,
      'tglview' => $tglview,
    ];
    return view('page_plan_per_tgl_sales', ['data' => $data]);
  }

  public function plan_per_tgl_sales2($id)
  {
    $tgl = $id;
    $sebelumnya = date("Y-m-d", strtotime("$id -1 day"));
    $berikutnya = date("Y-m-d", strtotime("$id +1 day"));
    $days[] = array(
      "now" => $id,
      "pre" => $sebelumnya,
      "next" => $berikutnya,
    );

    $date = date_create($id);
    $tglview = date_format($date, "d F Y");
    $user_id = Auth::user()->id;
    $datapertgls = DB::table('plans')->join('users', 'plans.user_id', '=', 'users.id')
      ->join('customers', 'plans.customer_id', '=', 'customers.id')
      ->leftjoin('cekouts', 'plans.id', '=', 'cekouts.plan_id')
      ->select(DB::raw('plans.id,plans.customer_id,plans.tgl,plans.keterangan,plans.ket_tolak,plans.status,customers.name,customers.alamat,cekouts.keterangan as hasil'))
      ->where('plans.tgl', $tgl)
      ->where('plans.user_id', $user_id)
      ->orderByRaw(DB::raw("FIELD(plans.status, '4','6','3','0','1','5','2')DESC"))
      ->get();
    if (!empty($datapertgls[0]->id)) {
      foreach ($datapertgls as $datapertgl) {
        if ($datapertgl->status == 0) {
          $status = 'Pending';
          $colorbox = 'box-pending';
          $footer = 'showDIV';
        } elseif ($datapertgl->status == 1) {
          $status = 'Approve';
          $colorbox = 'box-approve';
          $footer = 'showDIV';
        } elseif ($datapertgl->status == 2 or $datapertgl->status == 5) {
          $status = 'CekIn';
          $colorbox = 'box-cekin';
          $footer = 'showDIV';
        } elseif ($datapertgl->status == 3) {
          $status = 'Selesai';
          $colorbox = 'box-selesai';
          $footer = 'none';
        } elseif ($datapertgl->status == 6) {
          $status = 'Selesai TanpaApprove';
          $colorbox = 'box-selesaitanpaapprove';
          $footer = 'none';
        } else {
          $status = 'Ditolak';
          $colorbox = 'box-ditolak';
          $footer = 'none';
        }
        $response[] = (object) array(
          'status' => $status,
          'colorbox' => $colorbox,
          'footer' => $footer,
          'idplan' => $datapertgl->id,
          'name' => $datapertgl->name,
          "alamat" => $datapertgl->alamat,
          "customer_id" => $datapertgl->customer_id,
          // "tujuan" => $datapertgl->keterangan,
          "tujuan" => trim(preg_replace('/\s+/', ' ', $datapertgl->keterangan)),
          "ket_tolak" => $datapertgl->ket_tolak,
          "hasil" => $datapertgl->hasil,
        );
      }
    } else {
      $response = new Collection;
    }
    return view('plansales.indexmobile', ['responses' => $response, 'tanggal' => $tglview, 'days' => $days]);
  }

  public function plan_per_tgl($id)
  {
    // $user_id = Auth::user()->id;
    // $kode_cabang = Auth::user()->kode_cabang;
    // $role_id = Auth::user()->role_id;
    // if ($role_id=='3') {
    //   $plans = Plan::where('tgl',$id)
    //   ->where('kode_cabang',$kode_cabang)->get();
    // } else {
    //   $plans = Plan::where('tgl',$id)
    //   ->where('kode_cabang',$kode_cabang)->get();       
    // }

    // $data = Datatables::of($plans)->make();
    // dd($data);
    $tgl = $id;
    $prevday = date('Y-m-d', strtotime($tgl . "-1 days"));
    $nextday = date('Y-m-d', strtotime($tgl . "+1 days"));
    $date = date_create($id);
    $user_id = Auth::user()->id;
    $kode_cabang = Auth::user()->kode_cabang;
    $role_id = Auth::user()->role_id;
    // dd($prevday);

    $tglview = date_format($date, "d F Y");
    $data = [
      'tgl' => $id,
      'prevday' => $prevday,
      'nextday' => $nextday,
      'tglview' => $tglview,
    ];
    if (request()->ajax()) {
      $datapertgl = DB::table('plans')->join('users', 'plans.user_id', '=', 'users.id')
        ->join('customers', 'plans.customer_id', '=', 'customers.id')
        ->leftjoin('cekouts', 'plans.id', '=', 'cekouts.plan_id')
        ->select(DB::raw('plans.id,plans.user_id,plans.tgl,plans.customer_id,plans.keterangan as tujuan,plans.status,plans.ket_tolak as tolak,
          customers.name,customers.alamat,users.id as user_id,users.name as sales,cekouts.id as idcekout,cekouts.keterangan as hasil,DATE_FORMAT(cekouts.created_at, "%H:%i") as jam,cekouts.created_at,cekouts.updated_at'))
        ->where('plans.tgl', $tgl)
        ->where('plans.kode_cabang', $kode_cabang)
        // ->orderByRaw(DB::raw("FIELD(plans.status, '4','3', '1', '0','2')DESC"))
        ->get();
      // dd($datapertgl);
      return Datatables::of($datapertgl)
        ->editColumn('action', function ($data) {
          if ($data->status == 0)
            return '<a href="' . route("modal_plan_approve", $data->id) . '" class="btn btn-success modal-show" data-sales="' . $data->sales . '" data-btn="Approve"><i class="bi bi-check-circle"></i></a>
            <a href="' . route("modal_plan_tolak", $data->id) . '" class="btn btn-danger modal-show" data-sales="' . $data->sales . '" data-btn="Tolak"><i class="bi bi-x-circle"></i></a>
            <a href="' . route("modal_plan_edit", $data->id) . '" class="btn btn-primary modal-show" data-sales="' . $data->sales . '" data-btn="Simpan"><i class="bi bi-pencil-square"></i></a>';
          if ($data->status == 1) return 'Disetujui';
          if ($data->status == 2 || $data->status == 5) return 'Sedang ChekIn';
          if ($data->status == 6) return '<a href="' . route("modal_plan_approve", $data->id) . '" class="btn btn-success modal-show" data-sales="' . $data->sales . '" data-btn="Approve"><i class="bi bi-check-circle"></i></a> <a href="' . route("modal_plan_tolak", $data->id) . '" class="btn btn-danger modal-show" data-sales="' . $data->sales . '" data-btn="Tolak"><i class="bi bi-x-circle"></i></a>';
          if ($data->status == 4) return 'Ditolak';
          return 'Selesai';
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    return view('planadmin.index', ['data' => $data]);
  }

  public function plan_per_tgl_show(Request $request)
  {
    // dd($id);
    $tgl = $request->tgl;
    $user_id = Auth::user()->id;
    $kode_cabang = Auth::user()->kode_cabang;
    $role_id = Auth::user()->role_id;
    // dd($role_id);
    // $datapertgl = Plan::select('id','user_id','tgl','customer_id','keterangan','status')
    // ->where('tgl', $tgl)
    // ->where('kode_cabang',$kode_cabang)
    // ->with('customer:id,name,alamat')->with('user:id,name')
    // ->with('cekout')->get();

    // $datapertgl = DB::table('plans')
    // ->select('plans.id','plans.user_id','plans.tgl','plans.customer_id','plans.keterangan as tujuan','plans.status',
    //   'customers.name','customers.alamat','users.id as user_id','users.name as sales','cekouts.id as idcekout','cekouts.keterangan as hasil','DATE_FORMAT(cekouts.created_at, "%H:%i") as jam','cekouts.created_at','cekouts.updated_at')
    // ->where('plans.tgl', $tgl)
    // ->where('plans.kode_cabang',$kode_cabang)
    // ->join('customers','plans.customer_id','=','customers.id')
    // ->join('users','plans.user_id','=','users.id')
    // ->leftJoin('cekouts', 'plans.id', '=', 'cekouts.plan_id')
    // ->get();


    // ->select(DB::raw('DATE_FORMAT(cekouts.created_at, "%H:%i") as jam','cekouts.created_at','cekouts.updated_at'))
    $datapertgl = DB::table('plans')->join('users', 'plans.user_id', '=', 'users.id')
      ->join('customers', 'plans.customer_id', '=', 'customers.id')
      ->leftjoin('cekouts', 'plans.id', '=', 'cekouts.plan_id')
      ->select(DB::raw('plans.id,plans.user_id,plans.tgl,plans.customer_id,plans.keterangan as tujuan,plans.status,plans.ket_tolak as tolak,
        customers.name,customers.alamat,users.id as user_id,users.name as sales,cekouts.id as idcekout,cekouts.keterangan as hasil,DATE_FORMAT(cekouts.created_at, "%H:%i") as jam,cekouts.created_at,cekouts.updated_at'))
      ->where('plans.tgl', $tgl)
      ->where('plans.kode_cabang', $kode_cabang)
      // ->orderByRaw(DB::raw("FIELD(plans.status, '4','3', '1', '0','2')DESC"))
      ->get();


    // dd($datapertgl2);

    // if ($role_id=='3') {
    //   // $datapertgl = Plan::select('id','user_id','tgl','customer_id','keterangan','status')
    //   // ->where('tgl', $tgl)
    //   // ->where('user_id',$user_id)
    //   // ->with('customer')->with('user')->get();

    //     $datapertgl = DB::table('plans')->join('users', 'plans.user_id', '=', 'users.id')
    //     ->join('customers', 'plans.customer_id', '=', 'customers.id')
    //     ->leftjoin('cekouts', 'plans.id', '=', 'cekouts.plan_id')
    //     ->select(DB::raw('plans.id,plans.customer_id,plans.tgl,plans.keterangan,plans.ket_tolak,plans.status,customers.name,customers.alamat,cekouts.keterangan as hasil'))
    //     ->where('plans.tgl', $tgl)
    //     ->where('plans.user_id', $user_id)
    //     // ->whereNull('deleted_at')
    //     ->get();
    // } else {
    //       $datapertgl = Plan::select('id','user_id','tgl','customer_id','keterangan','status')
    //       ->where('tgl', $tgl)
    //       ->where('kode_cabang',$kode_cabang)
    //       ->with('customer:id,name,alamat')->with('user:id,name')
    //       ->with('cekout')->get();

    //         // $datapertgl = DB::table('plans')->join('cekouts', 'plans.id', '=', 'cekouts.plan_id')
    //         // ->select(DB::raw('plans.id'))
    //         // ->get();
    //         // $pictures = Picture::leftjoin('likes', 'pictures.id', '=', 'likes.typeId')
    //         //             ->select(DB::raw('pictures.*, COUNT(likes.id) as countLikes'))
    //         //             ->where('likes.type', '=', 'Picture')
    //         //             ->orWhere('likes.typeId')
    //         //             ->orderBy('countLikes', 'DESC')
    //         //             ->groupBy('pictures.id')
    //         //             ->get();
    //         // dd($datapertgl);
    // }
    // dd($datapertgl);
    return Datatables::of($datapertgl)->make();
  }

  public function addplan(Request $request)
  {
    $this->validate($request, [
      'tanggal' => 'required',
      'customer' => 'required',
      'keterangan' => 'required',
    ]);

    $user_id = Auth::user()->id;
    $kode_cabang = Auth::user()->kode_cabang;

    if (!empty(Session::get('platformcdi'))) {
      $platformcdi = Session::get('platformcdi');
    } else {
      $platformcdi = 'cdi';
    }
    $keterangan = trim(preg_replace('/\s+/', ' ', $request->keterangan));
    $dataplan = Plan::where('customer_id', '=', $request->customer)
      ->where('tgl', '=', $request->tanggal)
      ->where('keterangan', '=', $keterangan)
      ->first();
    if ($dataplan !== null) {
      return redirect()->route('home', $platformcdi);
    }
    $plan = new Plan;
    $plan->timestamps = false;
    $plan->user_id = $user_id;
    $plan->kode_cabang = $kode_cabang;
    $plan->title =  'Visit';
    $plan->tgl =  $request->tanggal;
    $plan->customer_id =  $request->customer;
    // $plan->keterangan =  $request->keterangan;
    $plan->keterangan =  $keterangan;
    $plan->created_at = date('Y-m-d H:i:s');
    $plan->save();

    // return $this->page_calender();
    return redirect()->route('page_plan');
  }

  public function plan_pending()
  {
    return view('planadmin.pending');
  }

  public function plan_pendingshow()
  {
    $user_id = Auth::user()->id;
    $kode_cabang = Auth::user()->kode_cabang;
    $datapending = DB::table('plans')->join('users', 'plans.user_id', '=', 'users.id')
      ->join('customers', 'plans.customer_id', '=', 'customers.id')
      ->select(DB::raw('plans.id,plans.customer_id,plans.tgl,plans.keterangan,plans.status,users.name as sales,customers.name,customers.alamat'))
      ->where('plans.kode_cabang', $kode_cabang)
      ->whereIn('plans.status', array(0, 6))
      ->whereNull('deleted_at')
      ->get();

    return Datatables::of($datapending)
      ->editColumn('action', function ($data) {
        if ($data->status == 0)
          return '<a href="' . route("modal_plan_approve", $data->id) . '" class="btn btn-success modal-show" data-sales="' . $data->sales . '" data-btn="Approve"><i class="bi bi-check-circle"></i></a>
          <a href="' . route("modal_plan_tolak", $data->id) . '" class="btn btn-danger modal-show" data-sales="' . $data->sales . '" data-btn="Tolak"><i class="bi bi-x-circle"></i></a>
          <a href="' . route("modal_plan_edit", $data->id) . '" class="btn btn-primary modal-show" data-sales="' . $data->sales . '" data-btn="Simpan"><i class="bi bi-pencil-square"></i></a>';
        if ($data->status == 1) return 'Disetujui';
        if ($data->status == 2 || $data->status == 5) return 'Sedang ChekIn';
        if ($data->status == 6) return '<a href="' . route("modal_plan_approve", $data->id) . '" class="btn btn-success modal-show" data-sales="' . $data->sales . '" data-btn="Approve"><i class="bi bi-check-circle"></i></a> <a href="' . route("modal_plan_tolak", $data->id) . '" class="btn btn-danger modal-show" data-sales="' . $data->sales . '" data-btn="Tolak"><i class="bi bi-x-circle"></i></a>';
        if ($data->status == 4) return 'Ditolak';
        return 'Cancel';
      })
      ->rawColumns(['action'])
      ->make(true);
  }

  public function modal_plan_approve($id)
  {
    $model = Plan::with('customer')->find($id);
    return view('planadmin.partials.approve', compact('model'));
  }

  //// controller untuk mengaprove plan
  public function plan_approve(Request $request)
  {
    $iduser = Auth::user()->id;
    $id = $request->hidden_id;
    $device = Session::get('device');
    $client_ip = Session::get('client_ip');
    $plan = Plan::find($id);

    if ($plan) {
      if ($plan->status == 0) {
        $statusselanjutnya = 1;
        $logAktivitas = 'Approve Plan Pending - ' . $id;
      } elseif ($plan->status == 6) {
        $statusselanjutnya = 3;
        $logAktivitas = 'Approve Plan Selesai - ' . $id;
      } else {
        $statusselanjutnya = $plan->status;
        $logAktivitas = 'Approve Plan Gagal - ' . $id;
      }

      $plan->status = $statusselanjutnya;
      $plan->save();

      $log = new Log;
      $log->user_id = $iduser;
      $log->kode_cabang = Auth::user()->kode_cabang;
      $log->aktivitas = $logAktivitas;
      $log->device = $device;
      $log->ip = $client_ip;
      $log->save();
    } else {
      abort(404);
    }
  }

  public function modal_plan_tolak($id)
  {
    $model = Plan::with('customer')->find($id);
    return view('planadmin.partials.tolak', compact('model'));
  }

  public function plan_tolak(Request $request)
  {
    $this->validate($request, [
      'ketTolak' => 'required',
    ], [
      'ketTolak.required' => 'Alasan harus diisi',
    ]);
    $iduser = Auth::user()->id;
    $device = Session::get('device');
    $client_ip = Session::get('client_ip');
    $keterangan = $request->ketTolak;
    $plan_id = $request->hidden_id;
    $plan = Plan::find($plan_id);
    if ($plan) {
      if ($plan->status == 0) {
        $logAktivitas = 'Tolak Plan Pending - ' . $plan_id;
      } elseif ($plan->status == 6) {
        $logAktivitas = 'Tolak Plan Selesai - ' . $plan_id;
      } else {
        $logAktivitas = 'Tolak Plan Gagal - ' . $plan_id;
      }

      $plan->ket_tolak = $keterangan;
      $plan->status = '4';
      $plan->save();
      $plan->delete();

      $log = new Log;
      $log->user_id = $iduser;
      $log->kode_cabang = Auth::user()->kode_cabang;
      $log->aktivitas = $logAktivitas;
      $log->device = $device;
      $log->ip = $client_ip;
      $log->save();
    } else {
      abort(404);
    }
  }

  public function plan_approved()
  {
    return view('planadmin.approved2'); // memakai serverside tables
  }

  public function plan_approvedshow()
  {
    $user_id = Auth::user()->id;
    $kode_cabang = Auth::user()->kode_cabang;

    $planapprove = Plan::select('id', 'user_id', 'tgl', 'customer_id', 'keterangan', 'status')
      ->where('kode_cabang', $kode_cabang)
      ->where('status', '<>', '0')
      ->Where('status', '<>', '6')
      ->Where('status', '<>', '4')
      ->with('customer')->with('user')
      ->with('cekout')
      ->orderBy('id', 'desc')->get();
    // print_r($planapprove);
    // $log = Plan::select('id','tgl','customer_id','keterangan','user_id','cek_in')
    //       ->where('kode_cabang',$kode_cabang)
    //       ->where('approve', 1)->with('customer')->with('user')->with('cekin')->get();
    return Datatables::of($planapprove)->make();
  }

  public function modal_plan_edit($id)
  {
    $model = Plan::with('customer')->find($id);
    return view('planadmin.partials.edit', compact('model'));
  }

  public function plan_edit(Request $request)
  {
    $this->validate($request, [
      'ketPlan' => 'required|string|min:3',
    ], [
      'ketPlan.required' => 'Keperluan harus diisi',
      'ketPlan.min' => 'Keterangan terlalu singkat',
    ]);
    $iduser = Auth::user()->id;
    $device = Session::get('device');
    $client_ip = Session::get('client_ip');

    $keterangan = trim(preg_replace('/\s+/', ' ', $request->ketPlan));
    $plan_id = $request->hidden_id;
    $plan = Plan::find($plan_id);
    if ($plan) {
      $plan->keterangan = $keterangan;
      $plan->save();

      $log = new Log;
      $log->user_id = $iduser;
      $log->kode_cabang = Auth::user()->kode_cabang;
      $log->aktivitas = 'Edit ID Plan ' . $plan_id;
      $log->device = $device;
      $log->ip = $client_ip;
      $log->save();
    } else {
      abort(404);
    }
  }

  public function page_plan_cekin($id)
  {
    $plan = Plan::with('customer')->find($id);
    return view('plansales.actions.cekin', ['idplan' => $id, 'tgl' => $plan->tgl, 'nama' => $plan->customer->name, 'alamat' => $plan->customer->alamat, 'keperluan' => $plan->keterangan]);
  }

  public function plan_cekin(Request $request)
  {
    $iduser = Auth::user()->id;
    $usercekin = Plan::where('user_id', $iduser)
      ->whereIn('status', array(2, 5))
      // ->where('status',2)
      // ->orWhere('status',5)
      ->first();
    if ($usercekin) {
      // return Response::json(['error' => 'Error msg']);
      // return response()->json(['error' => 'Anda Masih mempunyai Status CekIn'], 404);
      return redirect()->route('plan_per_tgl_sales2', [$request->tgl])->with('danger modal-show', 'Anda Masih mempunyai Status CekIn');
    }

    if ($request->long == '') {
      // return Response::json(['error' => 'Error msg']);
      // return response()->json(['error' => 'Lokasi Anda Tidak terdeteksi.silahkan restart GPS dan refresh Browser'], 404);
      return redirect()->route('plan_per_tgl_sales2', [$request->tgl])->with('danger modal-show', 'Lokasi Anda Tidak terdeteksi.silahkan restart GPS dan Refresh Browser');
    }

    $id = $request->id;
    // $plan = Plan::with('customer')->get()->find($id);
    $plan = Plan::with('customer')->find($id);
    // dd($plan->status);
    if ($plan) {
      if ($plan->status == 1) {
        $statusselanjutnya = 2;
      } elseif ($plan->status == 0) {
        $statusselanjutnya = 5;
      } else {
        $statusselanjutnya = $plan->status;
      }
      // dd($statusselanjutnya);
      $tgl = $plan->tgl;
      $plan->status = $statusselanjutnya;
      $plan->timestamps = false;
      $plan->save();

      $customer = Customer::find($plan->customer_id);
      $customer->last_visited = date('Y-m-d H:i:s');
      $customer->updated_at = date('Y-m-d H:i:s');
      $customer->save();

      $iduser = Auth::user()->id;
      $device = Session::get('device');
      $client_ip = Session::get('client_ip');

      $new_cekin = DB::table('cekins')->insertGetId(
        array(
          'tgl' => date('Y-m-d H:i:s'),
          'user_id' => $iduser,
          'customer_id' => $plan->customer_id,
          'plan_id' => $id,
          // 'keterangan' => $request->keterangan,
          // 'keterangan' => 'versilama',
          'latitude' => $request->lat,
          'longitude' => $request->long,
          'created_at' => date('Y-m-d H:i:s')
        )
      );

      $cekout = new Cekout;
      $cekout->timestamps = false;
      $cekout->user_id = $iduser;
      $cekout->customer_id = $plan->customer_id;
      $cekout->plan_id = $id;
      $cekout->cekin_id = $new_cekin;
      $cekout->created_at = date('Y-m-d H:i:s');
      $cekout->save();

      $log = new Log;
      $log->user_id = $iduser;
      $log->kode_cabang = Auth::user()->kode_cabang;
      $log->aktivitas = 'salesCekIn ' . $plan->user_id . ' ID Plan: ' . $id . ' ID Cek In: ' . $new_cekin;
      $log->device = $device;
      $log->ip = $client_ip;
      $log->save();
      return redirect()->route('plan_per_tgl_sales2', [$request->tgl]);
    } else {
      // abort(404);
      return redirect()->route('plan_per_tgl_sales2', [$request->tgl])->with('danger modal-show', 'Harap Hubungi IT,ID Plan Tidak ditemukan');
    }

    // return redirect()->route('page_plan');
  }

  public function plan_cancel_cekin(Request $request)
  {
    $user_id = Auth::user()->id;
    $device = Session::get('device');
    $client_ip = Session::get('client_ip');
    $plan_id = $request->id;
    $plan = Plan::find($plan_id);
    if ($plan->status == 2) {
      $statusselanjutnya = 1;
    } elseif ($plan->status == 5) {
      $statusselanjutnya = 0;
    } else {
      $statusselanjutnya = $plan->status;
    }
    $plan->status = $statusselanjutnya;
    $plan->timestamps = false;
    $plan->save();

    $getIdCekIn = Cekin::where('plan_id', $plan_id)->first();
    // dd($getIdCekIn);
    $idcekin = $getIdCekIn->id;
    // dd($idcekin);
    $cekin = Cekin::where('plan_id', $plan_id)->delete();
    // $cekin->delete();
    $cekout = Cekout::where('plan_id', $plan_id)->delete();
    $log = new Log;
    $log->user_id = $user_id;
    $log->kode_cabang = Auth::user()->kode_cabang;
    $log->aktivitas = 'salesCancelCekIn ' . $user_id . ' ID Plan: ' . $plan_id . ' ID Cek In: ' . $idcekin;
    $log->device = $device;
    $log->ip = $client_ip;
    $log->save();
    print 'sukses';
  }

  public function page_plan_cekout($id)
  {
    $plan = Plan::with('customer')->find($id);
    return view('plansales.actions.cekout', ['idplan' => $id, 'tgl' => $plan->tgl, 'nama' => $plan->customer->name, 'alamat' => $plan->customer->alamat, 'keperluan' => $plan->keterangan]);
  }

  public function plan_cekout(Request $request)
  {
    $id = $request->idplan;
    $this->validate(
      $request,
      [
        'hasil' => 'required|min:3',
      ],
      [
        'hasil.required' => 'Keterangan harus diisi',
        'hasil.min' => 'keterangan terlalu singkat',
      ]
    );


    $hasil = $request->hasil;

    $plan = Plan::with('customer')->find($id);
    if ($plan) {
      if ($plan->status == 2) {
        $statusselanjutnya = 3;
      } elseif ($plan->status == 5) {
        $statusselanjutnya = 6;
      } else {
        $statusselanjutnya = $plan->status;
      }
      $tgl = $plan->tgl;
      $plan->status = $statusselanjutnya;
      $plan->timestamps = false;
      $plan->save();

      $customer = Customer::find($plan->customer_id);
      $customer->last_visited = date('Y-m-d H:i:s');
      $customer->updated_at = date('Y-m-d H:i:s');
      $customer->save();

      $iduser = Auth::user()->id;
      $device = Session::get('device');
      $client_ip = Session::get('client_ip');

      $cekout = Cekout::where('plan_id', $id)->first();
      $cekout->timestamps = false;
      $cekout->tgl = date('Y-m-d H:i:s');
      $cekout->keterangan = $request->hasil;
      $cekout->latitude = $request->lat;
      $cekout->longitude = $request->long;
      $cekout->updated_at = date('Y-m-d H:i:s');
      $cekout->save();
      // print"sukses";
      return redirect()->route('plan_per_tgl_sales2', [$request->tgl]);
    } else {
      // abort(404);
      return redirect()->route('plan_per_tgl_sales2', [$request->tgl])->with('danger modal-show', 'Harap Hubungi IT,ID Plan Tidak ditemukan');
    }
    // return redirect()->route('page_plan');
  }


  public function page_plan_pesan($id)
  {
    $plan = Plan::join('customers', 'customers.id', '=', 'plans.customer_id')->find($id);

    $datacust[] = (object) array(
      'customer_id' => $plan->customer_id,
      'name' => $plan->name
    );

    return view('planpesan.index', ['datacustomers' => $datacust]);
  }


  public function page_presensi()
  {
    $now = date("Y-m");
    $user_id = Auth::user()->id;
    $model = Target::select('kode_cabang')->where('user_id', $user_id)
      ->where('periode', 'like', '%' . $now . '%')->first();
    $cabang = ($model == null ? '' : $model->kode_cabang);

    $judul = $cabang . " " . date("M Y");
    $sebelumnya = date("Y-m", strtotime("$now -1 month"));
    $berikutnya = date("Y-m", strtotime("$now +1 month"));
    $tahun[] = array(
      "judul" => $judul,
      "now" => $now,
      "pre" => $sebelumnya,
      "next" => $berikutnya,
    );
    return view('presensi.index', ['tahun' => $tahun]);
  }

  public function page_presensi2($id)
  {
    $user_id = Auth::user()->id;
    $model = Target::select('kode_cabang')->where('user_id', $user_id)
      ->where('periode', 'like', '%' . $id . '%')->first();

    $cabang = ($model == null ? '' : $model->kode_cabang);

    $judul = $cabang . " " . date("M Y", strtotime("$id"));
    $sebelumnya = date("Y-m", strtotime("$id -1 month"));
    $berikutnya = date("Y-m", strtotime("$id +1 month"));
    $tahun[] = array(
      "now" => $id,
      "judul" => $judul,
      "pre" => $sebelumnya,
      "next" => $berikutnya,
    );
    return view('presensi.index', ['tahun' => $tahun]);
  }

  public function presensi_show(Request $request)
  {
    // $cabang = Auth::user()->kode_cabang;
    $user_id = Auth::user()->id;
    $bulan = $request->bulan . "-01";
    // print    "{\"data\":[] }"; //output json andro
    // 
    $skac = new KoneksiController;
    $koneksi = $skac->KoneksiDenganDB();
    // $kueri= "SELECT b.kode_cabang,b.name,b.alamat,SUM(a.total) AS totalbelanja,COUNT(a.nota) AS totalnota 
    // FROM webapp.sales_nota_".$tahun." a,webapp.customers b 
    // WHERE a.customer_id=b.id AND a.nota LIKE '".$cabang.".%' GROUP BY a.customer_id ";
    $kueri = "SELECT a.user_id,a.target_kunjungan,a.kode_cabang
      FROM targets a INNER JOIN users b ON a.user_id=b.id 
      WHERE a.user_id='$user_id' AND a.periode='$bulan' ";
    $result = $koneksi->query($kueri);
    $count = $result->num_rows;
    if ($count > 0) {
      while ($row = $result->fetch_object()) {
        $user_id = $row->user_id;
        $cabang = $row->kode_cabang;
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
          "target_kunjungan" => $row->target_kunjungan,
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
}