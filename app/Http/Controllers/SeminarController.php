<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //untuk session auth
use App\Seminar;
use Session; // untuk session log
use DataTables;
use Illuminate\Support\Facades\DB;

class SeminarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('role:User');
    }

    public function index()
    {
        return view('seminar.index');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'customer_id' => 'required',
        	'seminar' => 'required',
        ],[
            'customer.required' => '',
        ]);

        $seminar = Seminar::where("customer_id",$request->customer_id)->first();
        if($seminar){
        	$error = \Illuminate\Validation\ValidationException::withMessages([
        		'ccc' => ['sudah daftar'],
        	]);
        	throw $error;
        }

        try {

		        $new_seminar = DB::table('seminars')->insertGetId(
		        array(
		            'tgl' => $request->tgl,
		            'name' => $request->seminar,
		            'customer_id' => $request->customer_id,
		            'ccc_level' => $request->level,
		            'user_id' => Auth::user()->id,
		            'created_at' => date('Y-m-d H:i:s')
		            )
		        ); 
        } catch(\Exception $exception) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'ccc' => ['Server Error'],
                ]);
                throw $error;
        }
        return redirect()->back();
    }

    public function dataTable()
    {
        $model = Seminar::query()->with('user:id,name,kode_cabang')->with('customer:id,ccc,name,alamat,telp');
        // $model = User::withTrashed()->select('id','name','username','tgl_lahir','mulai_kerja','hp','alamat','level')
        // ->where('id','>',7);
        // $model = Seminar::select('id','name','tgl_lahir','alamat','hp','last_transaksi');
        return DataTables::of($model)
            // ->addColumn('action', function ($model) {
            //     return view('layouts._actionEdit', [
            //         'model' => $model,
            //         // 'url_edit' => route('member.edit', $model->id),
            //     ]);
            // })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }


}
