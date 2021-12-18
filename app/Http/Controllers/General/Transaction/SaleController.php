<?php

namespace App\Http\Controllers\General\Transaction;

use App\DataTables\SaleDataTable;
use App\Http\Controllers\Controller;
use App\Model\Account;
use App\Model\Sale;
use App\Model\Customer;
use Illuminate\Http\Request;
use App\Model\Item;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('role_or_permission:developer|super admin|master|global|sales');
    }
    public function index(SaleDataTable $dataTable)
    {

        return $dataTable->render('general.transaction.sales.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items   = Item::where('delete_status', '0')->get();
        $banks   = Account::where('delete_status', '0')->get();
        $customers  = Customer::where('delete_status', '0')->get();

        return view('general.transaction.sales.create', compact('items', 'banks', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $sale_data = [];
        $sale_details_data = [];


        // sale data
        $sale_data = [
            "sale_date" => date("Y-m-d", strtotime($request->sale_date)),
            "customer_id" => $request->customer_id,
            "user_id" => Auth::user()->id,
            "total_sale_quantity" => array_sum($request->quantity),
            "total_discount" => array_sum($request->discount),
            "sub_total_amount" => (array_sum($request->total) + array_sum($request->discount)),
            "total_amount" => array_sum($request->total)
        ];

        // dd($sale_data);

        DB::beginTransaction();

        try{

            // insert main sale table
            DB::table("sales")->insert($sale_data);

            $sale_id = DB::getPdo()->lastInsertId();

            foreach($request->item_id as $key => $item){
                $sale_details_data[] = [
                    "sale_id" => $sale_id,
                    "item_id" => $item,
                    "user_id" => Auth::user()->id,
                    "sale_quantity" => $request->quantity[$key],
                    "unit_price" => $request->unit_price[$key],
                    "discount" => $request->discount[$key],
                    "sub_total" => ($request->quantity[$key] * $request->unit_price[$key]),
                    "total" => $request->total[$key]
                ];
            }

            // insert sale details
            DB::table("sale_items")->insert($sale_details_data);

            DB::commit();

            return redirect()->route('sale.index')->with('successMessage', 'Sale successfully deleted!');

        } catch(Exception $e){

            DB::rollback();

            dd($e);
            return redirect()->route('sale.index')->with('errorMessage', 'An error has occurred please try again later!');
        }
//        dd("Successfully data inserted");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        return view('general.transaction.sales.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $deleteData = [];
        $deleteData['delete_status'] = '1';

        try {
            $sale->update($deleteData);
            return redirect()->route('sale.index')->with('successMessage', 'Sale successfully deleted!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('sale.index')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }

    public function getItemPrice(Request $request)
    {
        $data = DB::table("items")->where("id", $request->item_id)->get()->first();

        return response()->json(['status' => 'success', 'message' => 'Success', 'data' => $data]);
    }
}
