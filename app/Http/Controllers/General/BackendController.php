<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Model\Account;
use App\Model\Deposit;
use App\Model\Withdraw;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BackendController extends Controller
{
    public function index()
    {
        //DEPOSIT
        $deposit_today = Deposit::whereDate('deposit_date', Carbon::today())
                                ->where('deposit_type', '!=', 'transfer')
                                ->get();
        $today_total_deposit =$deposit_today->sum('total_amount');

        $deposit_last_seven_days = Deposit::
                                        select(
                                            DB::raw("(SUM(total_amount)) as total, DATE_FORMAT(deposit_date, '%D %M, %Y') as date")
                                            )
                                    ->where('deposit_date','>=', Carbon::today()->subDays(7))
                                    ->where('deposit_type', '!=', 'transfer')
                                    ->groupBy('date')
                                    ->orderBy('date', 'ASC')
                                    ->get();


        $DepositChartDate = [];
        $DepositChartAmount = [];
        foreach($deposit_last_seven_days as $getDateData)
        {
            $date = $getDateData->date;
            $amount = $getDateData->total;
            if(!in_array($date, $DepositChartDate))
            {
                array_push($DepositChartDate, $date);
            }

            if(!in_array($amount, $DepositChartAmount))
            {
                array_push($DepositChartAmount, $amount);
            }
        }

        //DEPOSIT TOTAL SALES INVOICE

        $deposit_total_SI = Deposit::whereDate('deposit_date', Carbon::today())
                                ->where('deposit_type', '!=', 'transfer')
                                ->where('purpose_id', 1)
                                ->where('account_id', 1)
                                ->get();
        $today_deposit_total_SI =$deposit_total_SI->sum('total_amount');

        $deposit_last_seven_days_SI = Deposit::
                                        select(
                                            DB::raw("(SUM(total_amount)) as total, DATE_FORMAT(deposit_date, '%D %M, %Y') as date")
                                            )
                                    ->where('deposit_date','>=', Carbon::today()->subDays(7))
                                    ->where('deposit_type', '!=', 'transfer')
                                    ->where('purpose_id', 1)
                                    ->where('account_id', 1)
                                    ->groupBy('date')
                                    ->orderBy('date', 'ASC')
                                    ->get();


        $DepositChartDate_SI = [];
        $DepositChartAmount_SI = [];
        foreach($deposit_last_seven_days_SI as $getDateData_SI)
        {
            $date_SI = $getDateData_SI->date;
            $amount_SI = $getDateData_SI->total;
            if(!in_array($date_SI, $DepositChartDate_SI))
            {
                array_push($DepositChartDate_SI, $date_SI);
            }

            if(!in_array($amount_SI, $DepositChartAmount_SI))
            {
                array_push($DepositChartAmount_SI, $amount_SI);
            }
        }

        //DEPOSIT TOTAL PAYMENT INVOICE

        $deposit_total_SP = Deposit::whereDate('deposit_date', Carbon::today())
                                ->where('deposit_type', '!=', 'transfer')
                                ->where('purpose_id', 2)
                                ->where('account_id', 1)
                                ->get();
        $today_deposit_total_SP =$deposit_total_SP->sum('total_amount');

        $deposit_last_seven_days_SP = Deposit::
                                        select(
                                            DB::raw("(SUM(total_amount)) as total, DATE_FORMAT(deposit_date, '%D %M, %Y') as date")
                                            )
                                    ->where('deposit_date','>=', Carbon::today()->subDays(7))
                                    ->where('deposit_type', '!=', 'transfer')
                                    ->where('purpose_id', 2)
                                    ->where('account_id', 1)
                                    ->groupBy('date')
                                    ->orderBy('date', 'ASC')
                                    ->get();


        $DepositChartDate_SP = [];
        $DepositChartAmount_SP = [];
        foreach($deposit_last_seven_days_SP as $getDateData_SP)
        {
            $date_SP = $getDateData_SP->date;
            $amount_SP = $getDateData_SP->total;
            if(!in_array($date_SP, $DepositChartDate_SP))
            {
                array_push($DepositChartDate_SP, $date_SP);
            }

            if(!in_array($amount_SP, $DepositChartAmount_SP))
            {
                array_push($DepositChartAmount_SP, $amount_SP);
            }
        }

        //WITHDRAW
        $withdraw_today = Withdraw::whereDate('withdraw_date', Carbon::today())
                                ->where('withdraw_type', '!=', 'transfer')
                                ->get();
        $today_total_withdraw =$withdraw_today->sum('total_amount');

        $withdraw_last_seven_days = Withdraw::
                                        select(
                                            DB::raw("(SUM(total_amount)) as total, DATE_FORMAT(withdraw_date, '%D %M, %Y') as date")
                                            )
                                    ->where('withdraw_date','>=', Carbon::today()->subDays(7))
                                    ->where('withdraw_type', '!=', 'transfer')
                                    ->groupBy('date')
                                    ->orderBy('date', 'ASC')
                                    ->get();


        $WithdrawChartDate = [];
        $WithdrawChartAmount = [];
        foreach($withdraw_last_seven_days as $getDateData)
        {
            $date = $getDateData->date;
            $amount = $getDateData->total;
            if(!in_array($date, $WithdrawChartDate))
            {
                array_push($WithdrawChartDate, $date);
            }

            if(!in_array($amount, $WithdrawChartAmount))
            {
                array_push($WithdrawChartAmount, $amount);
            }
        }

        //WITHDRAW TOTAL PURCHASE AMOUNT

        $withdraw_total_PA = Withdraw::whereDate('withdraw_date', Carbon::today())
                                ->where('withdraw_type', '!=', 'transfer')
                                ->where('purpose_id', 4)
                                ->where('account_id', 2)
                                ->get();
        $today_withdraw_total_PA =$withdraw_total_PA->sum('total_amount');

        $withdraw_last_seven_days_PA = Withdraw::
                                        select(
                                            DB::raw("(SUM(total_amount)) as total, DATE_FORMAT(withdraw_date, '%D %M, %Y') as date")
                                            )
                                    ->where('withdraw_date','>=', Carbon::today()->subDays(7))
                                    ->where('withdraw_type', '!=', 'transfer')
                                    ->where('purpose_id', 4)
                                    ->where('account_id', 2)
                                    ->groupBy('date')
                                    ->orderBy('date', 'ASC')
                                    ->get();


        $WithdrawChartDate_PA = [];
        $WithdrawChartAmount_PA = [];
        foreach($withdraw_last_seven_days_PA as $getDateData_PA)
        {
            $date_PA = $getDateData_PA->date;
            $amount_PA = $getDateData_PA->total;
            if(!in_array($date_PA, $WithdrawChartDate_PA))
            {
                array_push($WithdrawChartDate_PA, $date_PA);
            }

            if(!in_array($amount_PA, $WithdrawChartAmount_PA))
            {
                array_push($WithdrawChartAmount_PA, $amount_PA);
            }
        }

        //WITHDRAW TOTAL PURCHASE PAYMENT

        $withdraw_total_PP = Withdraw::whereDate('withdraw_date', Carbon::today())
                                ->where('withdraw_type', '!=', 'transfer')
                                ->where('purpose_id', 5)
                                ->where('account_id', 2)
                                ->get();
        $today_withdraw_total_PP =$withdraw_total_PP->sum('total_amount');

        $withdraw_last_seven_days_PP = Withdraw::
                                        select(
                                            DB::raw("(SUM(total_amount)) as total, DATE_FORMAT(withdraw_date, '%D %M, %Y') as date")
                                            )
                                    ->where('withdraw_date','>=', Carbon::today()->subDays(7))
                                    ->where('withdraw_type', '!=', 'transfer')
                                    ->where('purpose_id', 5)
                                    ->where('account_id', 2)
                                    ->groupBy('date')
                                    ->orderBy('date', 'ASC')
                                    ->get();


        $WithdrawChartDate_PP = [];
        $WithdrawChartAmount_PP = [];
        foreach($withdraw_last_seven_days_PP as $getDateData_PP)
        {
            $date_PP = $getDateData_PP->date;
            $amount_PP = $getDateData_PP->total;
            if(!in_array($date_PP, $WithdrawChartDate_PP))
            {
                array_push($WithdrawChartDate_PP, $date_PP);
            }

            if(!in_array($amount_PP, $WithdrawChartAmount_PP))
            {
                array_push($WithdrawChartAmount_PP, $amount_PP);
            }
        }

        //BANKS DATA

        $banks = Account::whereNotIn('id', [1,2])->get();

        $getTotalBankDepositData = 0;
        $getTotalBankWithdrawData = 0;

        $depositWithdrawArray = [];
        foreach($banks as $bank)
        {
            $getBankDepositDatas = Deposit::where('account_id',$bank->id)
                                    ->get();
            $getTotalBankDepositData = $getBankDepositDatas->sum('total_amount');

            $getBankWithdrawDatas = Withdraw::where('account_id',$bank->id)
                                    ->get();
            $getTotalBankWithdrawData = $getBankWithdrawDatas->sum('total_amount');

            $depositWithdrawObject = array(
                "name" => $bank->bank_name,
                "total_balance"=> ($getTotalBankDepositData - $getTotalBankWithdrawData)+$bank->opening_balance
            );

            array_push($depositWithdrawArray, $depositWithdrawObject);
        }

        //AR DATA
        $ARbank = Account::where('id', 1)->first();
        $ARDeposit = Deposit::where('account_id', 1)->get();
        $ARbankSum = $ARDeposit->sum('total_amount') +  $ARbank->opening_balance;

        //AP DATA
        $APbank = Account::where('id', 2)->first();
        $APWithdraw = Withdraw::where('account_id', 2)->get();
        $APbankSum = $APWithdraw->sum('total_amount') +  $APbank->opening_balance;

        return view('general.dashboard' , compact(
            'today_total_deposit',
            'DepositChartDate',
            'DepositChartAmount',
            'today_deposit_total_SI',
            'DepositChartDate_SI',
            'DepositChartAmount_SI',
            'today_deposit_total_SP',
            'DepositChartDate_SP',
            'DepositChartAmount_SP',
            'today_total_withdraw',
            'WithdrawChartDate',
            'WithdrawChartAmount',
            'today_withdraw_total_PA',
            'WithdrawChartDate_PA',
            'WithdrawChartAmount_PA',
            'today_withdraw_total_PP',
            'WithdrawChartDate_PP',
            'WithdrawChartAmount_PP',
            'depositWithdrawArray',
            'ARbankSum',
            'APbankSum'
        ));
    }
}
