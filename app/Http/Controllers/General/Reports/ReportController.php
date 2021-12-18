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
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\QueryBuilder;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role_or_permission:developer|super admin|master|global|bank_statement|bank'])->only('bankStatement','getBankStatement');
        $this->middleware(['role_or_permission:developer|super admin|master|global|bank|purpose|withdraw|deposite',])->only('deposite','withdraw');
        $this->middleware(['role_or_permission:developer|super admin|master|global|purpose|customer|customer_ledger'])->only('customerLedger','getCustomerLedger');
    }
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
        $endDate = date('Y-m-d', strtotime($validatedData['end_date']));

        $endDate = $endDate." 23:59:59";
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
            $crRslt = DB::select("SELECT SUM(total_amount) as credit_amount
                            FROM deposits
                            WHERE (
                                UNIX_TIMESTAMP(deposit_date) < $startDate
                                AND account_id IN($banks)
                                )
                        ");

            $dbRslt = DB::select("SELECT SUM(total_amount) as debit_amount
                        FROM withdraws
                        WHERE (
                            UNIX_TIMESTAMP(withdraw_date) < $startDate
                            AND account_id IN($banks)
                            )
                        ");

            $previousBalance = ($crRslt[0]->credit_amount - $dbRslt[0]->debit_amount) + $totalOpeningBalance;

            //TRANSACTIONS BETWEEN DATES
            $crRslt = DB::select("SELECT *, total_amount as debit_amount, UNIX_TIMESTAMP(deposit_date) as date,
                                    deposit_type as type
                                    FROM deposits
                                    LEFT JOIN accounts ON deposits.account_id = accounts.id
                                    WHERE UNIX_TIMESTAMP(deposit_date) BETWEEN $startDate AND $endDate
                                    AND account_id IN($banks)
                                ");

            $dbRslt = DB::select("SELECT *, total_amount as credit_amount, UNIX_TIMESTAMP(withdraw_date) as date,
                                    withdraw_type as type
                                    FROM withdraws
                                    LEFT JOIN accounts ON withdraws.account_id = accounts.id
                                    WHERE UNIX_TIMESTAMP(withdraw_date) BETWEEN $startDate AND $endDate
                                    AND account_id IN($banks)
                                ");
            $reportInfo = array_merge($crRslt,$dbRslt);

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
                $balance_amnt = $previousBalance + $dbAmnt - $crAmnt;
            } else {
                $balance_amnt = $dbAmnt - $crAmnt + $balance_amnt;
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
            $endDate = date('Y-m-d', strtotime($request->filter['end_date']));

            $endDate = $endDate." 23:59:59";

            $query = Deposit::with(['customer', 'account', 'purpose', 'sale'])
                             ->where('deposit_date',  '>=', $startDate)
                             ->where('deposit_date',  '<=', $endDate);

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

            $endDate = $endDate." 23:59:59";

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

    public function customerLedger()
    {
        $customers = Customer::where('delete_status', '0')->get();
        $purposes = Purpose::where('delete_status', '0')->get();
        $employes = User::all();

        return view('general.reports.customer-ledger', compact('customers', 'purposes', 'employes'));
    }

    public function getCustomerLedger(Request $request)
    {
        $validatedData = $request->validate([
            'date_filter' => 'required',
            'start_date'  => '',
            'end_date'    => '',
            'customer'    => 'required',
            'employee'    => ''
        ]);

        $customer_id = $validatedData['customer'];

        // if($validatedData['employee'] != NULL)
        // {
        //     $user_id = $validatedData['employee'];
        // }else{
        //     $get_users = User::where('id', '!=', 1)->get();

        //     $user_array = [];
        //     foreach($get_users as $user)
        //     {
        //         if(!in_array($user->id, $user_array))
        //         {
        //             array_push($user_array, $user->id);
        //         }
        //     }
        //     $user_id = implode(', ', $user_array);
        // }


        $startDate = date('Y-m-d H:i:s', strtotime($validatedData['start_date']));
        $endDate = date('Y-m-d', strtotime($validatedData['end_date']));

        $endDate = $endDate." 23:59:59";

        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        if($startDate <= $endDate) {
            $total = 0;
            $i = 0;
            $reportInfo = array();
            $crVal = array();
            $dbVal = array();

            $dbRslt = DB::select("SELECT SUM(total_amount) as debit_amount
                                FROM `deposits`
                                WHERE (
                                    ( UNIX_TIMESTAMP(deposit_date) < '$startDate'
                                    AND customer_id= '$customer_id'
                                    AND account_id IN(1)
                                    AND total_amount > 0))
                                    ");

            $crRslt = DB::select("SELECT SUM(total_amount) as credit_amount
                        FROM `deposits`
                        WHERE (
                            ( UNIX_TIMESTAMP(deposit_date) < '$startDate'
                            AND customer_id= '$customer_id'
                            AND account_id IN(1)
                            AND total_amount < 0))
                            ");

            $previousBalance = $dbRslt[0]->debit_amount+$crRslt[0]->credit_amount;


            $dbRslt = DB::select("SELECT *, total_amount as debit_amount,UNIX_TIMESTAMP(deposit_date) as date
                          FROM deposits left join accounts ON deposits.account_id = accounts.id
                          left join customers ON deposits.customer_id=customers.id
                          WHERE (UNIX_TIMESTAMP(deposit_date) BETWEEN $startDate AND $endDate
                          AND customer_id= '$customer_id'
                          AND account_id IN(1) AND total_amount > 0)");

            $crRslt = DB::select("SELECT *, total_amount as credit_amount,UNIX_TIMESTAMP(deposit_date) as date
                          FROM deposits left join accounts ON deposits.account_id = accounts.id
                          left join customers ON deposits.customer_id=customers.id
                          WHERE (UNIX_TIMESTAMP(deposit_date) BETWEEN $startDate AND $endDate
                          AND customer_id= '$customer_id'
                          AND account_id IN(1) AND total_amount < 0)");


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
                $balance_amnt = $previousBalance + $dbAmnt + $crAmnt;
            } else {
                $balance_amnt = $dbAmnt + $crAmnt + $balance_amnt;
            }
            $totalCr += $crAmnt;
            $finalTotal += $balance_amnt;
            $totalDb += $dbAmnt;


            $balDate = date('d/m/Y', $row->date);


            $userInfo = [];
            $userInfo['date'] = $balDate;
            $userInfo['customer'] = $row->name;
            $userInfo['voucher_number'] = $row->voucher_number;
            $userInfo['bank_name'] = $row->bank_name;
            $userInfo['debit'] = sprintf("%.2f", $dbAmnt);
            $userInfo['credit'] = sprintf("%.2f", $crAmnt);
            $userInfo['balance'] = sprintf("%.2f", $balance_amnt);

            $tabular_data[] = $userInfo;
            $i++;
        }

        $customers = Customer::where('delete_status', '0')->get();
        $purposes = Purpose::where('delete_status', '0')->get();
        $employes = User::all();

        $start_Date = date('Y-m-d H:i:s', strtotime($validatedData['start_date']));
        $end_Date = date('Y-m-d H:i:s', strtotime($validatedData['end_date']));
        $totalDb = $totalDb;
        $totalCr = $totalCr;

        return view('general.reports.customer-ledger', compact([
            'start_Date',
            'end_Date',
            'tabular_data',
            'customers',
            'purposes',
            'employes',
            'previousBalance',
            'balance_amnt',
            'totalDb',
            'totalCr'
        ]));
    }
}
