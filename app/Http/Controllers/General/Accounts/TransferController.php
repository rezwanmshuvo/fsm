<?php

namespace App\Http\Controllers\General\Accounts;

use App\Http\Controllers\Controller;
use App\Model\Account;
use Illuminate\Http\Request;
use App\Model\Deposit;
use App\Model\Withdraw;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class TransferController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:developer|super admin|master|global|bank')->only('index');
        $this->middleware(['role_or_permission:developer|super admin|master|global|deposite|withdraw'])->only('store');
    }
    public function index()
    {
        $banks = Account::where('delete_status', '0')->get();
        return view('general.accounts.transfers.create', compact('banks'));
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'transfer_date'         => 'required',
            'bank_from'             => 'required',
            'bank_to'               => 'required',
            'money_receipt'         => '',
            'total_amount'          => 'required|numeric',
            'note'                  => ''
        ]);

        if($request->bank_from == $request->bank_to)
        {
            return redirect()->route('transfer.index')->with('errorMessage', 'Can not transfer within same bank!');
        }

        $random = str_shuffle(date('YmdHis'));
        $voucher_number= str_shuffle($random);

        //deposit
        $deposit = new Deposit();
        $deposit_data['user_id'] = auth()->user()->id;
        $deposit_data['deposit_date']    =  date('Y-m-d H:i:s', strtotime($validateData['transfer_date']));
        $deposit_data['account_id']      = $validateData['bank_to'];
        $deposit_data['money_receipt']   = $validateData['money_receipt'];
        $deposit_data['total_amount']    = $validateData['total_amount'];
        $deposit_data['note']            = $validateData['note'];
        $deposit_data['voucher_number']  = 'TR-'.$voucher_number;
        $deposit_data['purpose_id']      = 8;
        $deposit_data['deposit_type']    = 'transfer';


         //withdraw
         $withdraw = new Withdraw();
         $withdraw_data['user_id'] = auth()->user()->id;
         $withdraw_data['withdraw_date']    =  date('Y-m-d H:i:s', strtotime($validateData['transfer_date']));
         $withdraw_data['account_id']      = $validateData['bank_from'];
         $withdraw_data['money_receipt']   = $validateData['money_receipt'];
         $withdraw_data['total_amount']    = $validateData['total_amount'];
         $withdraw_data['note']            = $validateData['note'];
         $withdraw_data['voucher_number']  = 'TR-'.$voucher_number;
         $withdraw_data['purpose_id']      = 9;
         $withdraw_data['withdraw_type']   = 'transfer';

        DB::beginTransaction();
        try {
            $deposit->create($deposit_data);
            $withdraw->create($withdraw_data);
            DB::commit();
            return redirect()->route('transfer.index')->with('successMessage', 'Transfer success!');

        }catch (\Exception $ex) {
            DB::rollback();
            Artisan::call('cache:clear');
            return redirect()->route('transfer.index')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }
}
