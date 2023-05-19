<?php

use Illuminate\Support\Facades\DB;

Route::get('/contoh', function () {
	try {
		DB::connection('mysql_erp')->getPdo();
		echo "Connected successfully to: " . DB::connection('mysql_erp')->getDatabaseName();
	} catch (\Exception $e) {
		die("Could not connect to the database. Please check your configuration. error:" . $e);
	}

	return view('contoh');
});
Route::get('/jajal', 'HomeController@jajal')->name('jajal');
Route::get('/tes', 'TesController@tes')->name('tes-query');

Route::get('/', 'HomeController@root');
Route::get('/home/{id}', 'HomeController@home')->name('home');
Route::get('/account', 'HomeController@account_setting')->name('account_setting');
Route::post('/account/editaccount', 'HomeController@editaccount')->name('editaccount');
Route::post('/account/editpassword', 'HomeController@editpassword')->name('editpassword');

Route::get('/item', 'ItemController@cek_harga');
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'HomeController@notfound');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
// Route::post('/apilogin', 'Auth\LoginController@login')->name('apilogin');
Route::post('/apilogin', 'HomeController@apilogin')->name('apilogin');
Route::get('/apilogin', 'HomeController@notfound');

// ccc admin
// Route::get('/admin/ccc','MemberController@page_cccadmin')->name('page_cccadmin'); // page ccc for admin

Route::get('/masterpage', 'HomeController@masterpage')->name('masterpage');
Route::get('/item', 'ItemController@cek_harga')->name('page_item');
Route::post('/item/{id}', 'ItemController@viewdetail');
Route::post('/SearchItem', 'ItemController@show')->name('SearchItem');
Route::get('/stokitem', 'ItemController@item_stok')->name('page_item_stok');
Route::post('/Searchstok', 'ItemController@search_item_stok')->name('search_item_stok');

Route::get('/stok-erp-sales', 'StokERPController@pagesales')->name('pagesales_stok_erp');
Route::get('/stok-erp-allcabang', 'StokERPController@Pageallcabang')->name('pageall_stok_erp');
Route::post('/stok-data', 'StokERPController@data_stok_erp')->name('data_stok_erp');

Route::get('/stok-peritem-erp', 'StokERPController@page_peritems_erp')->name('page_peritems_erp');
Route::get('/selectproduct-erp', 'StokERPController@select2product')->name('selectproduct.erp');
Route::post('/stok-peritem-erp/data', 'StokERPController@stock_peritems')->name('data_stock_peritems');


Route::get('/sales', 'KatoController@sales')->name('DataSales');
Route::post('/sales/editpasswordsales', 'KatoController@editpasswordsales')->name('editpasswordsales');
Route::get('/SearchSales', 'HomeController@notfound');
Route::post('/SearchSales', 'KatoController@SearchSales')->name('SearchSales');
Route::delete('/sales/{id}', 'KatoController@destroy');
Route::put('/sales/{id}', 'KatoController@update');
Route::get('/registersales', 'HomeController@notfound');
Route::post('/registersales', 'KatoController@registersales')->name('registersales');

//pemesanan
Route::get('/pemesanan', 'PemesananController@page_pemesanan')->name('page_pemesanan');
Route::get('/pemesanan/searchstok', 'PemesananController@pesan_stok')->name('data_stok');
Route::post('/Searchpesanstok', 'PemesananController@pesan_stok')->name('search_stok_pesan');
Route::post('/stok-erp', 'PemesananController@stok_erp')->name('stok_erp');

Route::post('/pemesanan/insert', 'PemesananController@saveall')->name('ajax.simpan');
Route::get('/pemesanan/codeinvoice', 'PemesananController@invoice')->name('codeinvoice');

//pemesanan customer
Route::get('/pemesanan-customer', 'PemesananCustomerController@page_pemesanan')->name('page_pemesanan_cust');
Route::get('/pemesanan-customer/searchstok', 'PemesananCustomerController@pesan_stok')->name('data_stok_cust');
Route::post('/Searchpesanstok-customer', 'PemesananCustomerController@pesan_stok')->name('search_stok_pesan_cust');
Route::post('/pemesanan-customer/insert', 'PemesananCustomerController@saveall')->name('ajax.simpan_cust');
Route::post('/pemesanan-customer/codeinvoice', 'PemesananCustomerController@invoice')->name('codeinvoice_cust');


//hostori pemesanan
Route::get('/historypemesanan', 'PemesananController@page_historypesan')->name('page_historypesan');
Route::get('/historypemesanan/master', 'PemesananController@data_historypesan')->name('data_historypesan');
Route::get('/historypemesanan/details/{nota}', 'PemesananController@detail_historypesan')->name('detail_historypesan');
Route::get('/historypemesanan/export', 'PemesananController@export_historypesan')->name('export_historypesan');
//edit
Route::get('/historypemesanan/changestatus', 'PemesananController@changestatus')->name('changestatus');

//hostori pemesanan customer
Route::get('/historypemesanan-customer', 'PemesananCustomerController@page_historypesan')->name('page_historypesan_cust');
Route::get('/historypemesanan-customer/master', 'PemesananCustomerController@data_historypesan')->name('data_historypesan_cust');
Route::get('/historypemesanan-customer/details/{nota}', 'PemesananCustomerController@detail_historypesan')->name('detail_historypesan_cust');
Route::get('/historypemesanan-customer/export', 'PemesananCustomerController@export_historypesan')->name('export_historypesan_cust');
//edit
Route::get('/historypemesanan-customer/changestatus', 'PemesananCustomerController@changestatus')->name('changestatus_cust');



Route::get('/targetsales', 'KatoController@page_target')->name('page_target');
Route::get('/targetsales/{id}', 'KatoController@page_target2')->name('page_target2');
Route::post('/targetsales', 'KatoController@target_show')->name('target_show');
Route::post('/addtarget', 'KatoController@addtarget')->name('addtarget');
Route::post('/targetsales/edit', 'KatoController@edittarget')->name('edittarget');

Route::get('/presensi', 'PlanController@page_presensi')->name('page_presensi');
Route::get('/presensi/{id}', 'PlanController@page_presensi2')->name('page_presensi2');
Route::post('/presensi', 'PlanController@presensi_show')->name('presensi_show');

// Route::get('/calender','CalenderController@page_calender')->name('page_calender');
// Route::post('/calender','CalenderController@data_calender')->name('data_calender'); //json calender
// Route::post('/addplan','CalenderController@addplan')->name('addplan'); //json calender

Route::get('/plan', 'PlanController@page_plan')->name('page_plan');
Route::post('/plan', 'PlanController@data_plan')->name('data_plan'); //json calender
Route::post('/addplan', 'PlanController@addplan')->name('addplan'); //json calender
Route::get('/pending', 'PlanController@plan_pending')->name('plan_pending'); //json calender
Route::post('/pending', 'PlanController@plan_pendingshow')->name('plan_pendingshow'); //json calender
Route::get('/approved', 'PlanController@plan_approved')->name('plan_approved'); //json calender
Route::post('/approved', 'PlanController@plan_approvedshow')->name('plan_approvedshow'); //json calender

Route::get('/plan-per-tgl/sales/{id}', 'PlanController@plan_per_tgl_sales')->name('plan_per_tgl_sales');
Route::get('/plan-per-tgl/sales2/{id}', 'PlanController@plan_per_tgl_sales2')->name('plan_per_tgl_sales2');
Route::get('/plan-per-tgl/{id}', 'PlanController@plan_per_tgl')->name('plan_per_tgl');
Route::post('/plan-per-tgl', 'PlanController@plan_per_tgl_show')->name('plan_per_tgl_show');

Route::get('/plan/cekin/{id}', 'PlanController@page_plan_cekin')->name('page_plan_cekin');
Route::post('/plan/cekin', 'PlanController@plan_cekin')->name('plan_cekin');
Route::get('/plan/cekout/{id}', 'PlanController@page_plan_cekout')->name('page_plan_cekout');
Route::post('/plan/cekout', 'PlanController@plan_cekout')->name('plan_cekout');
Route::post('/plan/cancelcekin', 'PlanController@plan_cancel_cekin')->name('plan_cancel_cekin');

//pesan dalam plan
Route::get('/plan/pesan/{id}', 'PlanController@page_plan_pesan')->name('page_plan_pesan');


Route::get('/plan/{id}', 'PlanController@plan_show')->name('plan_show');
//Route::get('/plan/{id}/cekin','PlanController@plan_edit')->name('plan_edit');

Route::get('/plan/approve/{id}', 'PlanController@modal_plan_approve')->name('modal_plan_approve');
Route::post('/plan/approve', 'PlanController@plan_approve')->name('plan_approve');
Route::get('/plan/tolak/{id}', 'PlanController@modal_plan_tolak')->name('modal_plan_tolak');
Route::post('/plan/tolak', 'PlanController@plan_tolak')->name('plan_tolak');
Route::get('/plan/edit/{id}', 'PlanController@modal_plan_edit')->name('modal_plan_edit');
Route::post('/plan/edit', 'PlanController@plan_edit')->name('plan_edit');

Route::get('/selectcust', 'HomeController@selectcust')->name('selectcust'); //route untuk select2 nama customer
Route::get('/selectcustnama', 'HomeController@selectcustnama')->name('selectcustnama'); //route untuk select2 nama aja customer
Route::get('/selectcustccc', 'HomeController@selectcustccc')->name('selectcustccc'); //route untuk select2 nama customer
Route::get('/selectitem', 'HomeController@selectitem')->name('selectitem'); //route untuk select2 nama Barang


Route::get('/lokasi/{id}', 'HomeController@lokasi')->name('lokasi');

Route::get('/customer', 'CustomerController@page_cust_aktivitas')->name('page_cust_aktivitas');
Route::post('/custaktivitas', 'CustomerController@search_cust_aktivitas')->name('search_cust_aktivitas'); //json calender
Route::post('/tabelcustaktivitas', 'CustomerController@tabel_show_aktivitas')->name('tabel_show_aktivitas'); //json calender

Route::get('/customerccc', 'CustomerController@page_cust_ccc')->name('page_cust_ccc');
Route::post('/customerccc', 'CustomerController@data_cust_ccc')->name('data_cust_ccc');

Route::get('/customerrank', 'CustomerController@page_cust_rank')->name('page_cust_rank');
Route::get('/customerrank/{id}', 'CustomerController@page_cust_rank2')->name('page_cust_rank2');
Route::post('/tabelcustrank', 'CustomerController@tabel_show_custrank')->name('tabel_show_custrank'); //json calender

Route::get('/materiproduk', 'HomeController@page_materiproduk')->name('page_materiproduk');
Route::post('/materiproduk', 'HomeController@data_materiproduk')->name('data_materiproduk'); //json calender

Route::get('kato/cekstok', 'KatoController@page_cekstok_kato')->name('page_cekstok_kato');
Route::post('kato/cekstok', 'KatoController@data_cekstok_kato')->name('data_cekstok_kato'); // page untuk 

Route::get('/report', 'ReportController@page_report')->name('report');
Route::post('/report', 'ReportController@data_report')->name('datareport');
Route::get('/report/{id}', 'ReportController@page_reportsales')->name('reportsales');


Route::group(['prefix' => 'sales'], function () {
	Route::get('/visit', 'SalesController@page_visit')->name('sales_page_visit');
	Route::post('/visit', 'SalesController@data_visit')->name('sales_data_visit');

	Route::post('/hiscust', 'SalesController@hiscust')->name('hiscust');
});


Route::group(['prefix' => 'area'], function () {
	Route::get('/pindahcabang', 'AreaController@pindahcabang')->name('pindahcabang');
	Route::post('/pindahcabang', 'AreaController@data_customer')->name('data_customer'); //datatables member ccc
	Route::post('/updatecabang', 'AreaController@updatecabang')->name('updatecabang'); //route untuk stokbonus

	Route::get('/custrank', 'AreaController@page_custrank_area')->name('page_custrank_area'); // page untuk melihat rank cust
	Route::post('/custrank', 'AreaController@data_custrank_area')->name('data_custrank_area'); // page untuk bonusonline Admin

	Route::get('/cekstok', 'AreaController@page_cekstok_area')->name('page_cekstok_area'); // page untuk melihat rank cust
	Route::post('/cekstok', 'AreaController@data_cekstok_area')->name('data_cekstok_area'); // page untuk bonusonline Admin
	Route::get('/targetsalesarea', 'AreaController@page_target')->name('page_targetarea');
	Route::get('/targetsalesarea/{id}', 'AreaController@page_target2')->name('page_target2area');
	Route::post('/targetsalesarea', 'AreaController@target_show')->name('target_showarea');
});

Route::group(['prefix' => 'super'], function () {
	Route::get('/logs', 'SuperController@page_logs')->name('super_page_logs');
	Route::post('/logs', 'SuperController@data_logs')->name('super_data_logs'); //datatables member ccc
	Route::post('/editcabang', 'SuperController@editcabang')->name('super_editcabang'); //datatables member ccc

	Route::get('/users', 'SuperController@page_usersapp')->name('super_page_users');
});


Route::group(['prefix' => 'seminar'], function () {
	Route::get('/', 'SeminarController@index')->name('seminar.index'); // hal crew ataz
	Route::post('table/seminar', 'SeminarController@dataTable')->name('seminar.table'); // hal crew ataz
	Route::post('/', 'SeminarController@store')->name('seminar.store'); // hal biaya ataz			
	// Route::post('/absen','PresensiController@absen')->name('presensi.absen'); // hal crew ataz			
	// Route::post('/durasi','PresensiController@durasi')->name('presensi.durasi'); // hal crew ataz
	// Route::get('table/log','PresensiController@dataTable')->name('log.table'); // get datatabel pada hal crew
	// Route::get('/crew/create','CrewController@create')->name('crew.create'); // form untuk							
});
