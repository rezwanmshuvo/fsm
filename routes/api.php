<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('save', function(){
//     return 'OK';
// })->middleware('APIKEY');

Route::group(['prefix' => 'v1'], function(){
    Route::middleware('APIKEY')->group(function(){
        //CUSTOMER API
        Route::post('customers/save', 'Api\V1\General\People\CustomerController@store');
        Route::post('customers/update', 'Api\V1\General\People\CustomerController@update');
        Route::post('customers/delete', 'Api\V1\General\People\CustomerController@distroy');
        Route::post('customers/undelete', 'Api\V1\General\People\CustomerController@undistroy');

        //SUPPLIER API
        Route::post('suppliers/save', 'Api\V1\General\People\PartyController@store');
        Route::post('suppliers/update', 'Api\V1\General\People\PartyController@update');
        Route::post('suppliers/delete', 'Api\V1\General\People\PartyController@distroy');
        Route::post('suppliers/undelete', 'Api\V1\General\People\PartyController@undistroy');

        //ITEM API
        Route::post('items/save', 'Api\V1\General\Product\ItemController@store');
        Route::post('items/update', 'Api\V1\General\Product\ItemController@update');
        Route::post('items/delete', 'Api\V1\General\Product\ItemController@distroy');
        Route::post('items/undelete', 'Api\V1\General\Product\ItemController@undistroy');

		//SALE
		Route::post('sales/save', 'Api\V1\General\Processing\SaleController@store');
        Route::post('sales/delete', 'Api\V1\General\Processing\SaleController@distroy');
        Route::post('sales/undelete', 'Api\V1\General\Processing\SaleController@undistroy');

        //RECEIVING
		Route::post('receivings/save', 'Api\V1\General\Processing\ReceiveController@store');
        Route::post('receivings/delete', 'Api\V1\General\Processing\ReceiveController@distroy');
        Route::post('receivings/undelete', 'Api\V1\General\Processing\ReceiveController@undistroy');

        //PURPOSE API
        Route::post('purposes/save', 'Api\V1\General\Accounts\PurposeController@store');
        Route::post('purposes/update', 'Api\V1\General\Accounts\PurposeController@update');
        Route::post('purposes/delete', 'Api\V1\General\Accounts\PurposeController@destroy');

        //EXPENSE API
        Route::post('expenses/save', 'Api\V1\General\Accounts\ExpenseController@store');
        Route::post('expenses/delete', 'Api\V1\General\Accounts\ExpenseController@distroy');
        Route::post('expenses/undelete', 'Api\V1\General\Accounts\ExpenseController@undistroy');
    });
});
