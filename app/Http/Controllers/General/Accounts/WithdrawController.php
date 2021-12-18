<?php

namespace App\Http\Controllers\General\Accounts;

use App\Http\Controllers\Controller;
use App\Model\Withdraw;
use Illuminate\Http\Request;
use App\DataTables\WithdrawDataTable;
use App\Model\Account;
use App\Model\Party;
use App\Model\Purpose;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use PDF;
use Illuminate\Support\Facades\Artisan;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('role_or_permission:developer|super admin|master|global|withdraw|purpose|party');
    }
    public function index(WithdrawDataTable $dataTable)
    {
        return $dataTable->render('general.accounts.withdraws.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Party::where('delete_status', '0')->get();
        $banks = Account::where('delete_status', '0')->get();
        $purposes = Purpose::where('delete_status', '0')
                    ->where('purpose_type', 'expanse')
                    ->get();

        return view('general.accounts.withdraws.create', compact('suppliers', 'banks', 'purposes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'withdraw_date'     => 'required',
            'party_id'          => '',
            'account_id'        => 'required',
            'purpose_id'        => 'required',
            'money_receipt'     => '',
            'total_amount'      => 'required|numeric',
            'note'              => ''
        ]);

        $save_or_print = $request->save_print;
        $validateData['withdraw_date'] = date('Y-m-d H:i:s', strtotime($validateData['withdraw_date']));
        $validateData['user_id'] = auth()->user()->id;
        $withdraw = new Withdraw();

        DB::beginTransaction();
        try {
            $withdraw_save = $withdraw->create($validateData);
            $withdraw_save_id = $withdraw_save->id;
            $generated_voucher_number = "withdraw-".$withdraw_save_id;

            $voucher_number['voucher_number'] = $generated_voucher_number;

            $withdraw_save->update($voucher_number);
            DB::commit();

            if($save_or_print == "save_only"){
                return redirect()->route('withdraw.index')->with('successMessage', 'Withdraw successfully created!');
            }

            if($save_or_print == "save_and_print"){
                return redirect()->route('withdraw.show', $withdraw_save_id);
            }

        }catch (\Exception $ex) {
            DB::rollback();
            Artisan::call('cache:clear');
            return redirect()->route('withdraw.create')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function show(Withdraw $withdraw)
    {
        $totalAmountToWord = NumberToWord($withdraw->total_amount);
        return view('general.accounts.withdraws.show', compact('withdraw', 'totalAmountToWord'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function edit(Withdraw $withdraw)
    {
        $suppliers = Party::where('delete_status', '0')->get();
        $banks = Account::where('delete_status', '0')->get();
        $purposes = Purpose::where('delete_status', '0')
                    ->where('purpose_type', 'expanse')
                    ->get();

        return view('general.accounts.withdraws.edit', compact('suppliers', 'banks', 'purposes', 'withdraw'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Withdraw $withdraw)
    {
        $validateData = $request->validate([
            'withdraw_date'     => 'required',
            'customer_id'       => '',
            'account_id'        => 'required',
            'purpose_id'        => 'required',
            'money_receipt'     => '',
            'total_amount'      => 'required|numeric',
            'note'              => ''
        ]);

        $validateData['withdraw_date'] = date('Y-m-d H:i:s', strtotime($validateData['withdraw_date']));

        try {
            $withdraw->update($validateData);
            return redirect()->route('withdraw.index')->with('successMessage', 'Withdraw successfully updated!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('withdraw.edit', $withdraw->id)->with('errorMessage', 'An error has occurred please try again later!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function destroy(Withdraw $withdraw)
    {
        $deleteData = [];
        $deleteData['delete_status'] = '1';

        try {
            $withdraw->update($deleteData);
            return redirect()->route('withdraw.index')->with('successMessage', 'Withdraw successfully deleted!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('withdraw.index')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }
}
