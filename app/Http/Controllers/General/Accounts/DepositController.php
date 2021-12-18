<?php

namespace App\Http\Controllers\General\Accounts;

use App\Http\Controllers\Controller;
use App\Model\Deposit;
use Illuminate\Http\Request;
use App\DataTables\DepositDataTable;
use App\Model\Account;
use App\Model\Customer;
use App\Model\Purpose;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use PDF;
use Illuminate\Support\Facades\Artisan;

class DepositController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:developer|super admin|master|global|deposite');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DepositDataTable $dataTable)
    {
        return $dataTable->render('general.accounts.deposits.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::where('delete_status', '0')->get();
        $banks = Account::where('delete_status', '0')->get();
        $purposes = Purpose::where('delete_status', '0')
                    ->where('purpose_type', 'income')
                    ->get();

        return view('general.accounts.deposits.create', compact('customers', 'banks', 'purposes'));
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
            'deposit_date'      => 'required',
            'customer_id'       => '',
            'account_id'        => 'required',
            'purpose_id'        => 'required',
            'money_receipt'     => '',
            'total_amount'      => 'required|numeric',
            'note'              => ''
        ]);

        $save_or_print = $request->save_print;
        $validateData['deposit_date'] = date('Y-m-d H:i:s', strtotime($validateData['deposit_date']));
        $validateData['user_id'] = auth()->user()->id;
        $deposit = new Deposit;

        DB::beginTransaction();
        try {
            $deposit_save = $deposit->create($validateData);
            $deposit_save_id = $deposit_save->id;
            $generated_voucher_number = "deposit-".$deposit_save_id;

            $voucher_number['voucher_number'] = $generated_voucher_number;

            $deposit_save->update($voucher_number);
            DB::commit();

            if($save_or_print == "save_only"){
                return redirect()->route('deposit.index')->with('successMessage', 'Deposit successfully created!');
            }

            if($save_or_print == "save_and_print"){
                return redirect()->route('deposit.show', $deposit_save_id);
            }

        } catch (\Exception $ex) {
            DB::rollback();
            Artisan::call('cache:clear');
            return redirect()->route('deposit.create')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function show(Deposit $deposit)
    {
        $totalAmountToWord = NumberToWord($deposit->total_amount);
        return view('general.accounts.deposits.show', compact('deposit', 'totalAmountToWord'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function edit(Deposit $deposit)
    {
        $customers = Customer::where('delete_status', '0')->get();
        $banks = Account::where('delete_status', '0')->get();
        $purposes = Purpose::where('delete_status', '0')
                    ->where('purpose_type', 'income')
                    ->get();

        return view('general.accounts.deposits.edit', compact('customers', 'banks', 'purposes', 'deposit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deposit $deposit)
    {
        $validateData = $request->validate([
            'deposit_date'      => 'required',
            'customer_id'       => '',
            'account_id'        => 'required',
            'purpose_id'        => 'required',
            'money_receipt'     => '',
            'total_amount'      => 'required|numeric',
            'note'              => ''
        ]);

        $validateData['deposit_date'] = date('Y-m-d H:i:s', strtotime($validateData['deposit_date']));

        try {
            $deposit->update($validateData);
            return redirect()->route('deposit.index')->with('successMessage', 'Deposit successfully updated!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('deposit.edit', $deposit->id)->with('errorMessage', 'An error has occurred please try again later!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deposit $deposit)
    {
        $deleteData = [];
        $deleteData['delete_status'] = '1';

        try {
            $deposit->update($deleteData);
            return redirect()->route('deposit.index')->with('successMessage', 'Deposit successfully deleted!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('deposit.index')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }
}
