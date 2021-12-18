<?php

namespace App\Http\Controllers\Api\V1\General\Accounts;

use App\Http\Controllers\Controller;
use App\Model\Account;
use App\Model\ApiKey;
use App\Model\Purpose;
use App\Model\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role_or_permission:developer|super admin|master|global|purpose|withdraw']);
    }
    //STORE OR EDIT SALE OR DELETE
    function store(Request $request){
        //return $request->all();
        try {

            $get_old_expense = Withdraw::where('pos_expense_id', $request->expense['pos_expense_id'])->first();

            if(!is_null($get_old_expense))
            {
                $getapikey = ApiKey::where('system_key', $request->header('APIKEY'))->first();

                if(!is_null($getapikey))
                {
                    $BankData['api_key_id']      = $getapikey->id;
                    $PurposeData['api_key_id']   = $getapikey->id;
                }else{
                    return response()->json(['message' => 'Api key not found!'], 401);
                }

                if($request->expense['account_id'] != "Store Account")
                {
                    $get_bank = Account::where('bank_name', $request->expense['account_id'])->first();
                    //BANK CREATE IF NOT EXIST
                    if(empty($get_bank))
                    {
                        $BankData['bank_name']           = $request->expense['account_id'];
                        $BankData['opening_balance']     = 0;
                        $BankData['user_id']             = 1;
                        $bank = new Account();
                        $create_bank = $bank->create($BankData);
                        $account_id = $create_bank->id;
                    }else{
                        $account_id = $get_bank->id;
                    }
                }

                $get_purpose = Purpose::where('pos_purpose_id', $request->expense_category['pos_purpose_id'])->first();

                //PURPOSE CREATE IF NOT EXIST
                if(empty( $get_purpose))
                {
                    if($request->expense_category['purpose_id'] == "0")
                    {
                        $PurposeData['name']              = $request->expense_category['name'];
                        $PurposeData['pos_purpose_id']    = $request->expense_category['pos_purpose_id'];
                        $PurposeData['purpose_id']        = NULL;
                        $PurposeData['purpose_type']      = $request->expense_category['purpose_type'];
                        $PurposeData['user_id']           = $request->expense_category['user_id'];
                    }else{
                        $PurposeData['name']              = $request->expense_category['name'];
                        $PurposeData['pos_purpose_id']    = $request->expense_category['pos_purpose_id'];
                        $PurposeData['purpose_id']        = $request->expense_category['purpose_id'];
                        $PurposeData['purpose_type']      = $request->expense_category['purpose_type'];
                        $PurposeData['user_id']           = $request->expense_category['user_id'];
                    }

                    $purpose = new Purpose();
                    $create_purpose = $purpose->create($PurposeData);
                    $purpose_id = $create_purpose->id;

                }else{
                    $purpose_id = $get_purpose->id;
                }

                if($request->expense['account_id'] != "Store Account")
                {
                    try{
                        //UPDATE EXPENSE DATA TO WITHDRAW
                        $WithdrawData['account_id'] 	    = $account_id;
                        $WithdrawData['purpose_id']         = $purpose_id;
                        $WithdrawData['user_id'] 		    = $request->expense['user_id'];
                        $WithdrawData['note']			    = $request->expense['note'];
                        $WithdrawData['total_amount'] 	    = $request->expense['total_amount'];
                        $WithdrawData['withdraw_type'] 	    = $request->expense['withdraw_type'];
                        $WithdrawData['location'] 	        = $request->expense['location'];
                        $WithdrawData['pos_expense_id'] 	= $request->expense['pos_expense_id'];
                        $WithdrawData['withdraw_date']      = $request->expense['withdraw_date'];


                        $old_withdraw = Withdraw::where('pos_expense_id', $request->expense['pos_expense_id'])->first();
                        $old_withdraw->update($WithdrawData);
                    }catch (\Exception $ex) {
                        Artisan::call('cache:clear');
                        return response()->json(['error_message' => $ex->getMessage()], 401);
                    }
                }else{
                    $old_withdraw_store_account = Withdraw::where('pos_expense_id', $request->expense['pos_expense_id'])->first();
                    $old_withdraw_store_account->delete();
                }

                return response()->json(['succcess_message' => 'Expense successfully edited!'], 200);
            }else{
                $getapikey = ApiKey::where('system_key', $request->header('APIKEY'))->first();

                if(!is_null($getapikey))
                {
                    $BankData['api_key_id']      = $getapikey->id;
                    $PurposeData['api_key_id']   = $getapikey->id;
                    $WithdrawData['api_key_id']  = $getapikey->id;
                }else{
                    return response()->json(['message' => 'Api key not found!'], 401);
                }

                if($request->expense['account_id'] != "Store Account")
                {
                    $get_bank = Account::where('bank_name', $request->expense['account_id'])->first();

                    //BANK CREATE IF NOT EXIST
                    if(empty($get_bank))
                    {
                        $BankData['bank_name']           = $request->expense['account_id'];
                        $BankData['opening_balance']     = 0;
                        $BankData['user_id']             = 1;
                        $bank = new Account();
                        $create_bank = $bank->create($BankData);
                        $account_id = $create_bank->id;
                    }else{
                        $account_id = $get_bank->id;
                    }
                }

                $get_purpose = Purpose::where('pos_purpose_id', $request->expense_category['pos_purpose_id'])->first();

                //PURPOSE CREATE IF NOT EXIST
                if(empty( $get_purpose))
                {
                    if($request->expense_category['purpose_id'] == "0")
                    {
                        $PurposeData['name']              = $request->expense_category['name'];
                        $PurposeData['pos_purpose_id']    = $request->expense_category['pos_purpose_id'];
                        $PurposeData['purpose_id']        = NULL;
                        $PurposeData['purpose_type']      = $request->expense_category['purpose_type'];
                        $PurposeData['user_id']           = $request->expense_category['user_id'];
                    }else{
                        $PurposeData['name']              = $request->expense_category['name'];
                        $PurposeData['pos_purpose_id']    = $request->expense_category['pos_purpose_id'];
                        $PurposeData['purpose_id']        = $request->expense_category['purpose_id'];
                        $PurposeData['purpose_type']      = $request->expense_category['purpose_type'];
                        $PurposeData['user_id']           = $request->expense_category['user_id'];
                    }

                    $purpose = new Purpose();
                    $create_purpose = $purpose->create($PurposeData);
                    $purpose_id = $create_purpose->id;

                }else{
                    $purpose_id = $get_purpose->id;
                }

                if($request->expense['account_id'] != "Store Account")
                {
                    //INSERT EXPENSE DATA TO WITHDRAW
                    $WithdrawData['account_id'] 	    = $account_id;
                    $WithdrawData['purpose_id']         = $purpose_id;
                    $WithdrawData['user_id'] 		    = $request->expense['user_id'];
                    $WithdrawData['note']			    = $request->expense['note'];
                    $WithdrawData['total_amount'] 	    = $request->expense['total_amount'];
                    $WithdrawData['withdraw_type'] 	    = $request->expense['withdraw_type'];
                    $WithdrawData['location'] 	        = $request->expense['location'];
                    $WithdrawData['pos_expense_id'] 	= $request->expense['pos_expense_id'];
                    $WithdrawData['withdraw_date']      = $request->expense['withdraw_date'];


                    $withdraw =new Withdraw();
                    $withdraw_save = $withdraw->create($WithdrawData);
                    $withdraw_save_id = $withdraw_save->id;

                    $generated_voucher_number = "withdraw-".$withdraw_save_id;
                    $voucher_number['voucher_number'] = $generated_voucher_number;
                    $withdraw_save->update($voucher_number);
                }

                return response()->json(['succcess_message' => 'Expense successfully created!'], 200);
            }
        }catch (\Exception $ex) {
            //DB::rollback();
            Artisan::call('cache:clear');
            return response()->json(['error_message' => $ex->getMessage()], 401);
        }
    }

    //EXPENSES DELETE(ACTUALE STATUS CHANGED TO 1) THROUGH API
    public function distroy(Request $request)
    {
        $statusData['delete_status'] = '1';
        try {
            $expenses = Withdraw::whereIn('pos_expense_id', $request->pos_expense_id)->get();
             foreach($expenses as $expense)
             {
                $expense->update($statusData);
             }
            return response()->json(['succcess_message' => 'Expense successfully deleted!'], 200);
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return response()->json(['error_message' => $ex->getMessage()], 401);
        }
    }

   //SALE UNDELETE(ACTUALE STATUS CHANGED TO 0) THROUGH API
    public function undistroy(Request $request)
    {
        $statusData['delete_status'] = '0';
        try {
            $expenses = Withdraw::whereIn('pos_expense_id', $request->pos_expense_id)->get();
             foreach($expenses as $expense)
             {
                $expense->update($statusData);
             }
            return response()->json(['succcess_message' => 'Expense successfully restored!'], 200);
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return response()->json(['error_message' => $ex->getMessage()], 401);
        }
    }
}
