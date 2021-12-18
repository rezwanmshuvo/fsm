<?php

namespace App\Http\Controllers\General\Reports;

use App\DataTables\ReportDataTable;
use App\Http\Controllers\Controller;
use App\Model\Account;
use App\Model\Customer;
use App\Model\Deposit;
use App\Model\Party;
use App\Model\Purpose;
use App\Model\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\QueryBuilder;

class ReportController extends Controller
{
    public function bankStatement()
    {
        $banks = Account::whereNotIn('id', [1,2])->get();
        return view('general.reports.bank-statement', compact('banks'));
    }

    public function getBankStatement(Request $request)
    {
        $validatedData = $request->validate([
            'date_filter' => 'required',
            'start_date'   => '',
            'end_date'     => '',
            'bank'        => 'required'
        ]);

        $banks = implode(', ', $validatedData['bank']);
        $tabular_data = array();

        $startDate = date('Y-m-d H:i:s', strtotime($validatedData['start_date']));
        $endDate = date('Y-m-d H:i:s', strtotime($validatedData['end_date']));

        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        if($startDate <= $endDate) {
            $total = 0;
            $i = 0;
            $reportInfo = array();
            $crVal = array();
            $dbVal = array();

            //OPENING BALANCE
            $openingBaance = 0;
            $bankI = 0;
            foreach($validatedData['bank'] as $bank)
            {
                $getBankDataForBalance = Account::where('id', $bank)->first();
                $openingBaance = $openingBaance+$getBankDataForBalance->opening_balance;
            }

            $totalOpeningBalance = $openingBaance;

            //PREVIOUS BALANCE
            $dbRslt = DB::select("SELECT SUM(total_amount) as debit_amount
                            FROM deposits
                            WHERE (
                                UNIX_TIMESTAMP(deposit_date) < $startDate
                                AND account_id IN($banks)
                                )
                        ");

            $crRslt = DB::select("SELECT SUM(total_amount) as credit_amount
                        FROM withdraws
                        WHERE (
                            UNIX_TIMESTAMP(withdraw_date) < $startDate
                            AND account_id IN($banks)
                            )
                        ");

            $previousBalance = ($dbRslt[0]->debit_amount - $crRslt[0]->credit_amount) + $totalOpeningBalance;

            //TRANSACTIONS BETWEEN DATES
            $dbRslt = DB::select("SELECT *, total_amount as debit_amount, UNIX_TIMESTAMP(deposit_date) as date,
                                    deposit_type as type
                                    FROM deposits
                                    LEFT JOIN accounts ON deposits.account_id = accounts.id
                                    WHERE UNIX_TIMESTAMP(deposit_date) BETWEEN $startDate AND $endDate
                                    AND account_id IN($banks)
                                ");

            $crRslt = DB::select("SELECT *, total_amount as credit_amount, UNIX_TIMESTAMP(withdraw_date) as date,
                                    withdraw_type as type
                                    FROM withdraws
                                    LEFT JOIN accounts ON withdraws.account_id = accounts.id
                                    WHERE UNIX_TIMESTAMP(withdraw_date) BETWEEN $startDate AND $endDate
                                    AND account_id IN($banks)
                                ");
            $reportInfo = array_merge($dbRslt, $crRslt);

            if (!empty($reportInfo)) {
                usort($reportInfo, function($x, $y) {
                    if (($x->date) == ($y->date)) {
                        return 0;
                    } else if (($x->date) == '') {
                        return 1;
                    } else if (($y->date) == '') {
                        return -1;
                    }

                    return ($x->date) < ($y->date) ? -1 : 1;
                });
            }
        }

        $i = 0;
        $totalCr = 0;
        $totalDb = 0;
        $finalTotal = 0;
        $balance_amnt = 0;

        foreach ($reportInfo as $row) {
            if (isset($row->credit_amount)) {
                $crAmnt = $row->credit_amount;
            } else {
                $crAmnt = 0;
            }
            if (isset($row->debit_amount)) {
                $dbAmnt = $row->debit_amount;
            } else {
                $dbAmnt = 0;
            }
            if ($i == 0) {
                $balance_amnt = $previousBalance + $crAmnt - $dbAmnt;
            } else {
                $balance_amnt = $crAmnt - $dbAmnt + $balance_amnt;
            }
            $totalCr += $crAmnt;
            $finalTotal += $balance_amnt;
            $totalDb += $dbAmnt;

            $balDate = date('d/m/Y', $row->date);


            $userInfo = [];
            $userInfo['date'] = $balDate;
            $userInfo['type'] = $row->type;
            $userInfo['note'] = $row->note;
            $userInfo['voucher_number'] = $row->voucher_number;
            $userInfo['bank_name'] = $row->bank_name;
            $userInfo['debit'] = $dbAmnt;
            $userInfo['credit'] = $crAmnt;
            $userInfo['balance'] = $balance_amnt;

            $tabular_data[] = $userInfo;
            $i++;
        }

        $start_Date = date('Y-m-d H:i:s', strtotime($validatedData['start_date']));
        $end_Date = date('Y-m-d H:i:s', strtotime($validatedData['end_date']));
        $totalDb = $totalDb;
        $totalCr = $totalCr;
        $banks = Account::whereNotIn('id', [1,2])->get();
        $implodeBanks = implode(', ', $validatedData['bank']);

        $tableBanks = Account::whereIn('id', $validatedData['bank'])->get();
        return view('general.reports.bank-statement', compact([
            'start_Date',
            'end_Date',
            'banks',
            'tabular_data',
            'previousBalance',
            'balance_amnt',
            'totalDb',
            'totalCr',
            'tableBanks'
        ]));
    }

    public function deposit(Request $request)
    {
        if ($request->has('filter')) {
            $startDate = date('Y-m-d H:i:s', strtotime($request->filter['start_date']));
            $endDate = date('Y-m-d H:i:s', strtotime($request->filter['end_date']));

            $query = Deposit::with(['customer', 'account', 'purpose', 'sale'])
                             ->whereBetween('deposit_date',  array($startDate,  $endDate));

            $deposits =  QueryBuilder::for($query)
            ->allowedFilters(['customer_id', 'deposit_type', 'purpose_id', 'account_id'])
            ->orderBy('deposit_date', 'ASC')
            ->get();

            $deposit_amount = 0;
            foreach($deposits as $deposit)
            {
                $deposit_amount = $deposit_amount + $deposit->total_amount;
            }

            $totalDeposit = $deposit_amount;

            $customers = Customer::where('delete_status', '0')->get();
            $purposes = Purpose::where('purpose_type', 'income')
                                ->where('delete_status', '0')->get();
            $banks = Account::whereNotIn('id', [1,2])->get();

            $explodeBanks = explode (',', $request->filter['account_id']);
            $tableBanks = Account::whereIn('id', $explodeBanks)->get();
            return view('general.reports.deposit', compact('banks','customers','purposes','deposits', 'startDate', 'endDate', 'tableBanks', 'totalDeposit'));
        }else{
            $customers = Customer::where('delete_status', '0')->get();
            $purposes = Purpose::where('purpose_type', 'income')
                                ->where('delete_status', '0')->get();
            $banks = Account::whereNotIn('id', [1,2])->get();
            return view('general.reports.deposit', compact('banks','customers','purposes'));
        }
    }

    public function withdraw(Request $request)
    {
        if ($request->has('filter')) {
            $startDate = date('Y-m-d H:i:s', strtotime($request->filter['start_date']));
            $endDate = date('Y-m-d H:i:s', strtotime($request->filter['end_date']));

            $query = Withdraw::with(['party', 'account', 'purpose', 'purchase'])
                             ->whereBetween('withdraw_date',  array($startDate,  $endDate));

            $withdraws =  QueryBuilder::for($query)
            ->allowedFilters(['party_id', 'dwithdraw_type', 'purpose_id', 'account_id'])
            ->orderBy('withdraw_date', 'ASC')
            ->get();

            $withdraw_amount = 0;
            foreach($withdraws as $withdraw)
            {
                $withdraw_amount = $withdraw_amount + $withdraw->total_amount;
            }

            $totalWithdraw = $withdraw_amount;

            $parties = Party::where('delete_status', '0')->get();
            $purposes = Purpose::where('purpose_type', 'expanse')
                        ->where('delete_status', '0')->get();
            $banks = Account::whereNotIn('id', [1,2])->get();

            $explodeBanks = explode (',', $request->filter['account_id']);
            $tableBanks = Account::whereIn('id', $explodeBanks)->get();
            return view('general.reports.withdraw', compact('banks','parties','purposes','withdraws', 'startDate', 'endDate', 'tableBanks', 'totalWithdraw'));
        }else{
            $parties = Party::where('delete_status', '0')->get();
            $purposes = Purpose::where('purpose_type', 'expanse')
                                ->where('delete_status', '0')->get();
            $banks = Account::whereNotIn('id', [1,2])->get();
            return view('general.reports.withdraw', compact('banks','parties','purposes'));
        }
    }

    // public function getDeposit(Request $request)
    // {
    //     $data =  QueryBuilder::for(Deposit::class)
    //     ->allowedFilters(['start_date','end_date','customer_id', 'deposit_type', 'purpose_id', 'account_id'])
    //     ->get();

    //     $customers = Customer::where('delete_status', '0')->get();
    //     $purposes = Purpose::where('delete_status', '0')->get();
    //     $banks = Account::whereNotIn('id', [1,2])->get();
    //     return view('general.reports.deposit', compact('banks','customers','purposes', 'data'));
    // }
}
