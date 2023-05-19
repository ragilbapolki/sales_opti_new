<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['prefix' => 'v1'], function(){
	Route::get('signin','API\MobileController1@notfound');
	Route::post('signin','API\MobileController1@signin')->name('api.signin');
	Route::get('suplier','API\MobileController1@suplier');
	Route::post('item','API\MobileController1@item');
	Route::post('plan','API\MobileController1@plan');
	Route::get('selectcust','API\MobileController1@selectcust');
	Route::post('datapending','API\MobileController1@pendingshow');
	Route::post('dataapprove','API\MobileController1@approveshow');
	Route::put('toapprove/{id}','API\MobileController1@toapprove');
	Route::put('toreject/{id}','API\MobileController1@toreject');
	Route::post('tocekin','API\MobileController1@tocekin');


	Route::post('addplan','API\MobileController1@addplan');
	Route::post('datacekin','API\MobileController1@datacekin');
	Route::post('datalokasi','API\MobileController1@datalokasi');


		Route::get('databarang','API\MobileController1@databarang');



} );