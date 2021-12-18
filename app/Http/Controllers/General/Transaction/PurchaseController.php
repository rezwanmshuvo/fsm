<?php

namespace App\Http\Controllers\General\Transaction;

use App\DataTables\PurchaseDataTable;
use App\Http\Controllers\Controller;
use App\Model\Account;
use App\Model\Item;
use App\Model\Party;
use App\Model\Purchase;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('role_or_permission:developer|super admin|master|global|purchase');
    }
    public function index(PurchaseDataTable $dataTable)
    {
        return $dataTable->render('general.transaction.purchases.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parties = Party::where('delete_status', '0')->get();
        $banks   = Account::where('delete_status', '0')->get();
        $items   = Item::where('delete_status', '0')->get();

        return view('general.transaction.purchases.create', compact('parties', 'banks', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $purchase_data = [];
        $purchase_details_data = [];


        // purchase data
        $purchase_data = [
            "purchase_date" => date("Y-m-d", strtotime($request->purchase_date)),
            "party_id" => $request->party_id,
            "vehicle_number" => $request->vehicle_number,
            "user_id" => Auth::user()->id,
            "total_purchase_quantity" => array_sum($request->quantity),
            "total_discount" => array_sum($request->discount),
            "sub_total_amount" => (array_sum($request->total) + array_sum($request->discount)),
            "total_amount" => array_sum($request->total)
        ];

        // dd($purchase_data);

        DB::beginTransaction();

        try{

            // insert main purchase table
            DB::table("purchases")->insert($purchase_data);

            $purchase_id = DB::getPdo()->lastInsertId();

            foreach($request->item_id as $key => $item){
                $purchase_details_data[] = [
                    "purchase_id" => $purchase_id,
                    "item_id" => $item,
                    "user_id" => Auth::user()->id,
                    "purchase_quantity" => $request->quantity[$key],
                    "unit_price" => $request->unit_price[$key],
                    "discount" => $request->discount[$key],
                    "sub_total" => ($request->quantity[$key] * $request->unit_price[$key]),
                    "total" => $request->total[$key]
                ];
            }

            // insert purchase details
            DB::table("purchase_items")->insert($purchase_details_data);

            DB::commit();

            return redirect()->route('purchase.index')->with('successMessage', 'Purchase successfully created!');
        } catch(Exception $e){

            DB::rollback();

            dd($e);

                return redirect()->route('purchase.create')->with('errorMessage', 'An error has occurred please try again later!');
            }




//        dd("Successfully data inserted");
//        Artisan::call('cache:clear');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show($purchase)
    {
        return view('general.transaction.purchases.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        $deleteData = [];
        $deleteData['delete_status'] = '1';

        try {
            $purchase->update($deleteData);
            return redirect()->route('purchase.index')->with('successMessage', 'Purchase successfully deleted!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('purchase.index')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }

    public function getItemPrice(Request $request)
    {
        $data = DB::table("items")->where("id", $request->item_id)->get()->first();

        return response()->json(['status' => 'success', 'message' => 'Success', 'data' => $data]);
    }
}
