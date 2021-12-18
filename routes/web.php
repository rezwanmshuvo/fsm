<?php

use App\Model\Deposit;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('clear', function () {
    Artisan::call('optimize:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    dd("Done");
});

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    })->name('homepage');
    Route::get('form', function () {
        return view('form');
    })->name('form');
    Route::get('table', function () {
        return view('table');
    })->name('table');
    Route::get('report-table', function () {
        return view('report-table');
    })->name('report-table');

    /* MAIN ROUTES*/
    Route::get('dashboard', 'General\BackendController@index')->name('dashboard');
    // product routes
    Route::resource('item', 'General\Product\ItemController');
    Route::resource('item-category', 'General\Product\ItemCategoryController');

    // people routes
    Route::resource('customer', 'General\People\CustomerController');
    Route::post('customer/sale/ajax-store', 'General\People\CustomerController@ajaxStore')->name('customer.ajax-store');

    Route::resource('supplier', 'General\People\PartyController');
    Route::post('supplier/purchase/ajax-store', 'General\People\PartyController@ajaxStore')->name('supplier.ajax-store');

    //Shifts Routes
    Route::resource('shift', 'General\FSM\ShiftController');

    //Tanks Routes
    Route::resource('tank', 'General\FSM\TankController');

    //Machine Routes
    Route::resource('machine', 'General\FSM\MachineController');

    //Nozzle Routes
    Route::resource('nozzle', 'General\FSM\NozzleController');

    //Transaction Routes
    Route::resource('purchase', 'General\Transaction\PurchaseController');
    Route::get('/get_item_price', 'General\Transaction\PurchaseController@getItemPrice');

    Route::resource('sale', 'General\Transaction\SaleController');
    Route::get('/get_item_price', 'General\Transaction\SaleController@getItemPrice');

    // account routes
    Route::resource('bank', 'General\Accounts\AccountController');
    Route::resource('purpose', 'General\Accounts\PurposeController');
    Route::resource('deposit', 'General\Accounts\DepositController');
    Route::resource('withdraw', 'General\Accounts\WithdrawController');

    Route::get('transfer', 'General\Accounts\TransferController@index')->name('transfer.index');
    Route::post('transfer', 'General\Accounts\TransferController@store')->name('transfer.store');

    // settings routs
    Route::resource('permission', 'General\Administrations\PermissionController',
            [
                'only' => ['index', 'create', 'store']
            ]
        );

    Route::resource('role', 'General\Administrations\RoleController');
    Route::resource('user', 'General\Administrations\UserController')->parameters([
        'user' => 'user:username',
    ]);

    // reports
    Route::get('reports/bank-statement', 'General\Reports\ReportController@bankStatement')->name('reports.bank-statement');
    Route::post('reports/bank-statement', 'General\Reports\ReportController@getBankStatement')->name('reports.bank-statement.post');

    Route::get('reports/deposit', 'General\Reports\ReportController@deposit')->name('reports.deposit');
    Route::get('reports/withdraw', 'General\Reports\ReportController@withdraw')->name('reports.withdraw');

    Route::get('reports/customer-ledger', 'General\Reports\ReportController@customerLedger')->name('reports.customer-ledger');
    Route::post('reports/customer-ledger', 'General\Reports\ReportController@getCustomerLedger')->name('reports.customer-ledger.post');

    // Route::get('builder', function(){
    //     return QueryBuilder::for(Deposit::class)
    //     ->allowedFilters(['customer_id', 'account_id', 'purpose_id'])
    //     ->get();
    // });
});
