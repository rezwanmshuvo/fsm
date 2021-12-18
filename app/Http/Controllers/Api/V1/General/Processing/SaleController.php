<?php

namespace App\Http\Controllers\Api\V1\General\Processing;

use App\Http\Controllers\Controller;
use App\Model\Account;
use App\Model\ApiKey;
use App\Model\Customer;
use App\Model\Deposit;
use App\Model\Item;
use App\Model\Sale;
use App\Model\SaleItem;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role_or_permission:developer|super admin|master|global|customer|deposite|item|sale|user|']);
    }
    //STORE OR EDIT SALE OR DELETE
    function store(Request $request){
        try {
            $getapikey = ApiKey::where('system_key', $request->header('APIKEY'))->first();

            if(!is_null($getapikey))
            {
                $customerData['api_key_id'] = $getapikey->id;
                $employeeData['api_key_id'] = $getapikey->id;
                $depositData['api_key_id']  = $getapikey->id;
                $saleData['api_key_id']     = $getapikey->id;
                $ARData['api_key_id']       = $getapikey->id;
                $ItemData['api_key_id']     = $getapikey->id;
                $SaleItemData['api_key_id'] = $getapikey->id;
                $BanktemData['api_key_id']  = $getapikey->id;
            }else{
                return response()->json(['message' => 'Api key not found!'], 401);
            }

            $employee_id = $request->employee['pos_employee_id'];

            $get_emolpyee = User::where('pos_employee_id', $employee_id)->first();

            if(is_null($get_emolpyee))
            {
                    $employeeData['pos_employee_id']    = $request->employee['pos_employee_id'];
                    $employeeData['name']               = $request->employee['name'];
                    $employeeData['username']           = $request->employee['username'];
                    $employeeData['phone']              = $request->employee['phone'];
                    $employeeData['email']              = $request->employee['email'];
                    $employeeData['address']            = $request->employee['address'];
                    $employeeData['location']           = $request->employee['location'];
                    $employeeData['password']           = Hash::make('password');

                    $user = new User();
                    $new_user = $user->create($employeeData);

                    $saleData['user_id']        = $new_user->id;
                    $ARData['user_id'] 	        = $new_user->id;
                    $SaleItemData['user_id']    = $new_user->id;
                    $ARData['user_id'] 		    = $new_user->id;
            }else{
                $saleData['user_id']        = $get_emolpyee->id;
                $ARData['user_id'] 	        = $get_emolpyee->id;
                $SaleItemData['user_id']    = $get_emolpyee->id;
            }

            $customer_id = $request->sale['customer_id'];

            if( $customer_id != 1)
            {
                $customerNewBalance = 0;
                for($i=0; $i<count($request->sale_banks); $i++)
                {
                    if($request->sale_banks[$i]['payment_type'] == "Store Account")
                    {
                        $customerNewBalance = $customerNewBalance+$request->sale_banks[$i]['payment_amount'];
                    }else{
                        $customerNewBalance = 0;
                    }
                }

                $customerTotalNewBalance = $customerNewBalance;
                $customerPreviousBalance = $request->customer['current_balance'] - $customerTotalNewBalance;
            }
            $getSaleData = Sale::where('pos_sale_id', $request->sale['pos_sale_id'])->first();

            //DELETING SALE DATA IF FOUND
            if(!is_null($getSaleData)){
                $deleteSaleId = $getSaleData->id;
                $old_customer_id = $getSaleData->customer->pos_customer_id;

                $getSaleTotalBalance= Sale::where('pos_sale_id', $request->sale['pos_sale_id'])
                                        ->first();
                $getStoreAccountMinusBalance = Deposit::where('pos_sale_id', $request->sale['pos_sale_id'])
                                                ->where('total_amount', '<', '0')
                                                ->selectRaw('sum(total_amount) as total_amount')
                                                ->first();

                if($old_customer_id != 1)
                {
                    $getSaleCustomer = Customer::where('pos_customer_id', $old_customer_id)->first();
                    $customerDataUpdate['current_balance'] = $getSaleCustomer->current_balance - ($getSaleTotalBalance->total_amount+$getStoreAccountMinusBalance->total_amount);
                    $getSaleCustomer->update($customerDataUpdate);
                }


                $getSaleDepositDatas = Deposit::where('sale_id', $deleteSaleId)->get(['id']);
                Deposit::destroy($getSaleDepositDatas->toArray());

                $getSaleSaleItemDatas = SaleItem::where('sale_id', $deleteSaleId)->get(['id']);
                SaleItem::destroy($getSaleSaleItemDatas->toArray());

                $getSaleDatas = Sale::where('pos_sale_id', $request->sale['pos_sale_id'])->get(['id']);
                Sale::destroy($getSaleDatas->toArray());
            }

            //CUSTOMER

            if( $customer_id != 1)
            {
                $getCustomer = Customer::where('pos_customer_id', $customer_id)->first();
                //INSERT CUSTOMER DATA INTO CUSTOMERS IF NOT EXIST
                if(is_null($getCustomer))
                {
                    $customerData['user_id']            = $request->customer['user_id'];
                    $customerData['pos_customer_id']    = $request->customer['pos_customer_id'];
                    $customerData['name']               = $request->customer['name'];
                    $customerData['phone']              = $request->customer['phone'];
                    $customerData['email']              = $request->customer['email'];
                    $customerData['address']            = $request->customer['address'];
                    $customerData['account_number']     = $request->customer['account_number'];
                    $customerData['location']           = $request->customer['location'];
                    $customerData['current_balance']    = $customerPreviousBalance;
                    $customer = new Customer();
                    $new_customer = $customer->create($customerData);
                    $sale_customer_id = $new_customer->id;

                    $depositData['customer_id']     = $sale_customer_id;
                    $depositData['deposit_date']    = $request->sale['sale_date'];
                    $depositData['account_id']      = 1;
                    $depositData['purpose_id']      = 3;
                    $depositData['user_id']         = 1;
                    $depositData['location']        = $request->sale['location'];
                    $depositData['note']            = 'Customer Store Account Balance Menual Edit';
                    $depositData['total_amount']    = $customerPreviousBalance;
                    $depositData['deposit_type']    = 'sales';

                    $deposit =new Deposit();
                    $deposit_save = $deposit->create($depositData);
                    $deposit_save_id = $deposit_save->id;

                    $generated_voucher_number = "deposit-".$deposit_save_id;
                    $voucher_number['voucher_number'] = $generated_voucher_number;
                    $deposit_save->update($voucher_number);
                }

                //INSERT SALE DATA INTO SALES
                if(!is_null($getCustomer)){
                    $sale_customer_id = $getCustomer->id;
                }
            }else{
                $sale_customer_id = $customer_id;
            }

            //SALE
            $saleData['sale_date']            = $request->sale['sale_date'];
            $saleData['customer_id']          = $sale_customer_id;
            $saleData['location']             = $request->sale['location'];
            $saleData['pos_sale_id']          = $request->sale['pos_sale_id'];
            $saleData['total_sale_quantity']  = $request->sale['total_sale_quantity'];
            //$saleData['total_discount']       = 5; WILL BE UPDATE AFTER SALE ITEM CREATIONS
            $saleData['sub_total_amount']     = $request->sale['sub_total_amount'];
            $saleData['total_amount']         = $request->sale['total_amount'];
            $saleData['hold_status']          = $request->sale['hold_status'];

            $sale = new Sale();
            $sale_save = $sale->create($saleData);
            $systemSaleId = $sale_save->id;

            //SALES TOTAL AMOUNT INSERT AS ACCOUNT RECEIVABLE(AR)
            if($request->sale['store_account_payment'] == "0")
            {
                $ARData['customer_id'] 			= $sale_customer_id;
                $ARData['sale_id'] 			    = $systemSaleId;
                $ARData['account_id'] 			= 1;
                $ARData['purpose_id']           = 1;
                $ARData['note']					= $request->sale['comment'];
                $ARData['total_amount'] 	    = $request->sale['total_amount'];
                $ARData['deposit_type'] 	    = 'sales';
                $ARData['location'] 	        = $request->sale['location'];
                $ARData['pos_sale_id'] 	        = $request->sale['pos_sale_id'];
                $ARData['deposit_date']         = $request->sale['sale_date'];


                $deposit =new Deposit();
                $deposit_save = $deposit->create($ARData);
                $deposit_save_id = $deposit_save->id;

                $generated_voucher_number = "deposit-".$deposit_save_id;
                $voucher_number['voucher_number'] = $generated_voucher_number;
                $deposit_save->update($voucher_number);
            }

            //ITEMS & SALE ITEMS
            for($i=0; $i<count($request->sale_items); $i++)
            {
                $get_item = Item::where('pos_item_id', $request->sale_items[$i]['item_id'])->first();

                //ITEMS
                if(empty($get_item))
                {
                    $ItemData['name']                = $request->sale_items[$i]['name'];
                    $ItemData['item_category_id']    = 1;
                    $ItemData['user_id']             = 1;
                    $ItemData['pos_item_id']         = $request->sale_items[$i]['item_id'];
                    $item = new Item();
                    $item->create($ItemData);
                }

                $get_sale_item = Item::where('pos_item_id', $request->sale_items[$i]['item_id'])->first();
                $systemItemId = $get_sale_item->id;

                if(!empty($get_sale_item))
                {
                    //SALE ITEMS
                    $SaleItemData['sale_id']             = $systemSaleId;
                    $SaleItemData['item_id']             = $systemItemId;
                    $SaleItemData['pos_sale_item_id']    = $request->sale_items[$i]['item_id'];
                    $SaleItemData['sale_quantity']       = $request->sale_items[$i]['quantity_purchased'];
                    $SaleItemData['unit_price']          = $request->sale_items[$i]['item_unit_price'];
                    $SaleItemData['discount']            = $request->sale_items[$i]['discount_percent'];
                    $SaleItemData['sub_total']           = $request->sale_items[$i]['subtotal'];
                    $SaleItemData['total']               = $request->sale_items[$i]['total'];
                    $saleitem = new SaleItem();
                    $saleitem->create($SaleItemData);

                }
            }

            // BANKS, DEPOSIT &WITHDRAW
            $paymentBalance = 0;
            for($i=0; $i<count($request->sale_banks); $i++)
            {
                if($request->sale_banks[$i]['payment_type'] != "Store Account")
                {
                    $paymentBalance = $paymentBalance+$request->sale_banks[$i]['payment_amount'];
                    $get_bank = Account::where('bank_name', $request->sale_banks[$i]['payment_type'])->first();

                    //BANKS
                    if(empty($get_bank))
                    {
                        $BanktemData['bank_name']           = $request->sale_banks[$i]['payment_type'];
                        $BanktemData['opening_balance']     = 0;
                        $BanktemData['user_id']             = 1;
                        $bank = new Account();
                        $bank->create($BanktemData);
                    }

                    //SALES MINUS INVOICE PAYMENT INSERT AS ACCOUNT RECEIVABLE(AR)
                    $ARData['customer_id'] 			= $sale_customer_id;
                    $ARData['sale_id'] 			    = $systemSaleId;
                    $ARData['account_id'] 			= 1;
                    $ARData['purpose_id']           = 2;
                    $ARData['note']					= $request->sale['comment'];
                    $ARData['total_amount'] 	    = -1 * $request->sale_banks[$i]['payment_amount'];
                    $ARData['deposit_type'] 	    = 'sales';
                    $ARData['location'] 	        = $request->sale['location'];
                    $ARData['pos_sale_id'] 	        = $request->sale['pos_sale_id'];
                    $ARData['deposit_date']         = $request->sale['sale_date'];

                    $deposit =new Deposit();
                    $deposit_save = $deposit->create($ARData);
                    $deposit_save_id = $deposit_save->id;

                    $generated_voucher_number = "deposit-".$deposit_save_id;
                    $voucher_number['voucher_number'] = $generated_voucher_number;
                    $deposit_save->update($voucher_number);

                    //SALES PLUS INVOICE PAYMENT INSERT AS OWN BANK
                    $get_own_bank = Account::where('bank_name', $request->sale_banks[$i]['payment_type'])->first();
                    $bank_own_id = $get_own_bank->id;

                    $ARData['customer_id'] 			= $sale_customer_id;
                    $ARData['sale_id'] 			    = $systemSaleId;
                    $ARData['account_id'] 			= $bank_own_id;
                    $ARData['purpose_id']           = 2;
                    $ARData['note']					= $request->sale['comment'];
                    $ARData['total_amount'] 	    = $request->sale_banks[$i]['payment_amount'];
                    $ARData['deposit_type'] 	    = 'sales';
                    $ARData['location'] 	        = $request->sale['location'];
                    $ARData['pos_sale_id'] 	        = $request->sale['pos_sale_id'];
                    $ARData['deposit_date']         = $request->sale['sale_date'];

                    $deposit =new Deposit();
                    $deposit_save = $deposit->create($ARData);
                    $deposit_save_id = $deposit_save->id;

                    $generated_voucher_number = "deposit-".$deposit_save_id;
                    $voucher_number['voucher_number'] = $generated_voucher_number;
                    $deposit_save->update($voucher_number);
                }else{
                    $getStoreAccountTypeCustomer = Customer::where('pos_customer_id', $customer_id)->first();
                    $StoreAccountTypeData['current_balance'] = $getStoreAccountTypeCustomer->current_balance + $request->sale_banks[$i]['payment_amount'];
                    $getStoreAccountTypeCustomer->update($StoreAccountTypeData);
                }
            }

            $totalPaymentBalance = $paymentBalance;

            if($request->sale['store_account_payment'] == "1")
            {   $getStoreAccountCustomer = Customer::where('pos_customer_id', $customer_id)->first();
                $StoreAccountData['current_balance'] = $getStoreAccountCustomer->current_balance - $totalPaymentBalance;
                $getStoreAccountCustomer->update($StoreAccountData);
            }

            return response()->json(['succcess_message' => 'Sale successfully created!'], 200);
            //DB::commit();
        }catch (\Exception $ex) {
            //DB::rollback();
            Artisan::call('cache:clear');
            return response()->json(['error_message' => $ex->getMessage()], 401);
        }
    }

    //SALE DELETE(ACTUALE STATUS CHANGED TO 1) THROUGH API
    public function distroy(Request $request)
    {
        $statusData['delete_status'] = '1';
        try {

            $getSaleData = Sale::where('pos_sale_id', $request->pos_sale_id)->first();
            //DELETING SALE DATA IF FOUND
            if(!is_null($getSaleData)){
                $deleteSaleId = $getSaleData->id;
                $deleteCustomerId = $getSaleData->customer->id;

                $getSaleTotalBalance= Sale::where('pos_sale_id', $request->pos_sale_id)
                                        ->first();
                $getStoreAccountMinusBalance = Deposit::where('pos_sale_id', $request->pos_sale_id)
                                                ->where('total_amount', '<', '0')
                                                ->selectRaw('sum(total_amount) as total_amount')
                                                ->first();



                $getSaleCustomer = Customer::where('id', $deleteCustomerId)->first();
                $customerDataUpdate['current_balance'] = $getSaleCustomer->current_balance - ($getSaleTotalBalance->total_amount+$getStoreAccountMinusBalance->total_amount);
                $getSaleCustomer->update($customerDataUpdate);

                $getSaleDepositDatas = Deposit::where('sale_id', $deleteSaleId)->get();

                foreach($getSaleDepositDatas as $getSaleDepositData)
                {
                    $getSaleDepositData->update($statusData);
                }

                $getSaleData = Sale::where('id', $deleteSaleId)->first();
                $getSaleData->update($statusData);
            }
            return response()->json(['succcess_message' => 'Sale successfully deleted!'], 200);
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

            $getSaleData = Sale::where('pos_sale_id', $request->pos_sale_id)->first();
            //DELETING SALE DATA IF FOUND
            if(!is_null($getSaleData)){
                $deleteSaleId = $getSaleData->id;
                $deleteCustomerId = $getSaleData->customer->id;

                $getSaleTotalBalance= Sale::where('pos_sale_id', $request->pos_sale_id)
                                        ->first();
                $getStoreAccountMinusBalance = Deposit::where('pos_sale_id', $request->pos_sale_id)
                                                ->where('total_amount', '<', '0')
                                                ->selectRaw('sum(total_amount) as total_amount')
                                                ->first();



                $getSaleCustomer = Customer::where('id', $deleteCustomerId)->first();
                $customerDataUpdate['current_balance'] = $getSaleCustomer->current_balance + ($getSaleTotalBalance->total_amount+$getStoreAccountMinusBalance->total_amount);
                $getSaleCustomer->update($customerDataUpdate);

                $getSaleDepositDatas = Deposit::where('sale_id', $deleteSaleId)->get();

                foreach($getSaleDepositDatas as $getSaleDepositData)
                {
                    $getSaleDepositData->update($statusData);
                }

                $getSaleData = Sale::where('id', $deleteSaleId)->first();
                $getSaleData->update($statusData);
            }
            return response()->json(['succcess_message' => 'Sale successfully restored!'], 200);
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return response()->json(['error_message' => $ex->getMessage()], 401);
        }
    }
}
