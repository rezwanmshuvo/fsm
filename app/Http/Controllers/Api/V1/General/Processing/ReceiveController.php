<?php

namespace App\Http\Controllers\Api\V1\General\Processing;

use App\Http\Controllers\Controller;
use App\Model\Account;
use App\Model\ApiKey;
use App\Model\Party;
use App\Model\Deposit;
use App\Model\Item;
use App\Model\Purchase;
use App\Model\PurchaseItem;
use App\Model\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

class ReceiveController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role_or_permission:developer|super admin|master|global|item|party|purchase']);
    }
    //STORE OR EDIT SALE OR DELETE
    function store(Request $request){
        //return $request->all();
        try {
            $party_id = $request->receiving['party_id'];

            if( $party_id != 1){
                $supplierNewBalance = 0;
                for($i=0; $i<count($request->receiving_banks); $i++)
                {
                    if($request->receiving_banks[$i]['payment_type'] == "Store Account")
                    {
                        $supplierNewBalance = $supplierNewBalance+$request->receiving_banks[$i]['payment_amount'];
                    }else{
                        $supplierNewBalance = 0;
                    }
                }

                $supplierTotalNewBalance = $supplierNewBalance;
                $supplierPreviousBalance = $request->supplier['current_balance'] - $supplierTotalNewBalance;
            }
            $getPurchaseData = Purchase::where('pos_receiving_id', $request->receiving['pos_receiving_id'])->first();

            //DELETING RECEIVING DATA IF FOUND
            if(!is_null($getPurchaseData)){
                $deleteReceivingId = $getPurchaseData->id;
                $old_supplier_id = $getPurchaseData->party->pos_supplier_id;



                $getReceivingTotalBalance= Purchase::where('pos_receiving_id', $request->receiving['pos_receiving_id'])
                                        ->first();
                $getStoreAccountMinusBalance = Withdraw::where('pos_receiving_id', $request->receiving['pos_receiving_id'])
                                                ->where('total_amount', '<', '0')
                                                ->selectRaw('sum(total_amount) as total_amount')
                                                ->first();
                if($old_supplier_id != 1)
                {
                    $getReceivingSupplier = Party::where('pos_supplier_id', $old_supplier_id)->first();
                    $supplerDataUpdate['current_balance'] = $getReceivingSupplier->current_balance - ($getReceivingTotalBalance->total_amount+$getStoreAccountMinusBalance->total_amount);
                    $getReceivingSupplier->update($supplerDataUpdate);
                }


                $getReceivingWithdrawDatas = Withdraw::where('purchase_id', $deleteReceivingId)->get(['id']);
                Withdraw::destroy($getReceivingWithdrawDatas->toArray());

                $getReceivingReceiveItemDatas = PurchaseItem::where('purchase_id', $deleteReceivingId)->get(['id']);
                PurchaseItem::destroy($getReceivingReceiveItemDatas->toArray());


                $getPurchaseDatas = Purchase::where('pos_receiving_id', $request->receiving['pos_receiving_id'])->first();

                Purchase::destroy($getPurchaseDatas->toArray());
            }

            $getapikey = ApiKey::where('system_key', $request->header('APIKEY'))->first();

            if(!is_null($getapikey))
            {
                $supplierData['api_key_id']      = $getapikey->id;
                $withdrawData['api_key_id'] = $getapikey->id;
                $receivingData['api_key_id']     = $getapikey->id;
                $APData['api_key_id']            = $getapikey->id;
                $ItemData['api_key_id']          = $getapikey->id;
                $ReceivingItemData['api_key_id'] = $getapikey->id;
                $BanktemData['api_key_id']       = $getapikey->id;
            }else{
                return response()->json(['message' => 'Api key not found!'], 401);
            }

            //SUPPLIER
            if( $party_id != 1)
            {
                $getSupplier = Party::where('pos_supplier_id', $party_id)->first();

                //INSERT PARTY DATA INTO PARTIES IF NOT EXIST
                if(is_null($getSupplier))
                {
                    $supplierData['user_id']            = $request->supplier['user_id'];
                    $supplierData['pos_supplier_id']    = $request->supplier['pos_supplier_id'];
                    $supplierData['name']               = $request->supplier['name'];
                    $supplierData['phone']              = $request->supplier['phone'];
                    $supplierData['email']              = $request->supplier['email'];
                    $supplierData['address']            = $request->supplier['address'];
                    $supplierData['account_number']     = $request->supplier['account_number'];
                    $supplierData['location']           = $request->supplier['location'];
                    $supplierData['current_balance']    = $supplierPreviousBalance;

                    $supplier = new Party();
                    $new_supplier = $supplier->create($supplierData);

                    $receiving_supplier_id = $new_supplier->id;

                    //Withdraw
                    $withdrawData['party_id']        =  $receiving_supplier_id;
                    $withdrawData['withdraw_date']   =  $request->receiving['purchase_date'];
                    $withdrawData['account_id']      = 2;
                    $withdrawData['purpose_id']      = 6;
                    $withdrawData['user_id']         = 1;
                    $withdrawData['location']        = $request->receiving['location'];;
                    $withdrawData['note']            = 'Supplier Store Account Balance Menual Edit';
                    $withdrawData['total_amount']    = $supplierPreviousBalance;
                    $withdrawData['withdraw_type']   = 'purchase';

                    $withdraw =new withdraw();
                    $withdraw_save = $withdraw->create($withdrawData);
                    $withdraw_save_id = $withdraw_save->id;

                    $generated_voucher_number = "withdraw-".$withdraw_save_id;
                    $voucher_number['voucher_number'] = $generated_voucher_number;
                    $withdraw_save->update($voucher_number);
                }

                //INSERT SALE DATA INTO SALES
                if(!is_null($getSupplier)){
                    $receiving_supplier_id = $getSupplier->id;
                }
            }else{
                $receiving_supplier_id = $party_id;
            }

            //RECEIVING
            $receivingData['purchase_date']            = $request->receiving['purchase_date'];
            $receivingData['party_id']                 = $receiving_supplier_id;
            $receivingData['user_id']                  = $request->receiving['user_id'];
            $receivingData['location']                 = $request->receiving['location'];
            $receivingData['pos_receiving_id']         = $request->receiving['pos_receiving_id'];
            $receivingData['total_purchase_quantity']  = $request->receiving['total_purchase_quantity'];
            //$receivingData['total_discount']     = 5; WILL BE UPDATE AFTER SALE ITEM CREATIONS
            $receivingData['sub_total_amount']         = $request->receiving['sub_total_amount'];
            $receivingData['total_amount']             = $request->receiving['total_amount'];

            $receive = new Purchase();

            $receive_save = $receive->create($receivingData);
            $systemReceivingId = $receive_save->id;

            //RECEIVING TOTAL AMOUNT INSERT AS ACCOUNT PAYABLE(AP)
            if($request->receiving['store_account_payment'] == "0")
            {

                $APData['purchase_id'] 			= $systemReceivingId;
                $APData['party_id'] 			= $receiving_supplier_id;
                $APData['account_id'] 			= 2;
                $APData['purpose_id']           = 4;
                $APData['user_id'] 				= 1;
                $APData['note']					= $request->receiving['comment'];
                $APData['total_amount'] 	    = $request->receiving['total_amount'];
                $APData['withdraw_type'] 	    = 'purchase';
                $APData['location'] 	        = $request->receiving['location'];
                $APData['pos_receiving_id'] 	= $request->receiving['pos_receiving_id'];
                $APData['withdraw_date']        = $request->receiving['purchase_date'];


                $withdraw =new Withdraw();
                $withdraw_save = $withdraw->create($APData);
                $withdraw_save_id = $withdraw_save->id;

                $generated_voucher_number = "withdraw-".$withdraw_save_id;
                $voucher_number['voucher_number'] = $generated_voucher_number;
                $withdraw_save->update($voucher_number);
            }


            //ITEMS & RECEIVING ITEMS
            for($i=0; $i<count($request->receiving_items); $i++)
            {
                $get_item = Item::where('pos_item_id', $request->receiving_items[$i]['item_id'])->first();

                //ITEMS
                if(empty($get_item))
                {
                    $ItemData['name']                = $request->receiving_items[$i]['name'];
                    $ItemData['item_category_id']    = 1;
                    $ItemData['user_id']             = 1;
                    $ItemData['pos_item_id']         = $request->receiving_items[$i]['item_id'];
                    $item = new Item();
                    $item->create($ItemData);
                }

                $get_receiving_item = Item::where('pos_item_id', $request->receiving_items[$i]['item_id'])->first();
                $systemItemId = $get_receiving_item->id;

                if(!empty($get_receiving_item))
                {
                    //RECEIVING ITEMS
                    $ReceivingItemData['purchase_id']            = $systemReceivingId;
                    $ReceivingItemData['item_id']                = $systemItemId;
                    $ReceivingItemData['user_id']                = 1;
                    $ReceivingItemData['pos_receiving_item_id']  = $request->receiving_items[$i]['item_id'];
                    $ReceivingItemData['purchase_quantity']      = $request->receiving_items[$i]['quantity_purchased'];
                    $ReceivingItemData['unit_price']             = $request->receiving_items[$i]['item_unit_price'];
                    $ReceivingItemData['discount']               = $request->receiving_items[$i]['discount_percent'];
                    $ReceivingItemData['sub_total']              = $request->receiving_items[$i]['subtotal'];
                    $ReceivingItemData['total']                  = $request->receiving_items[$i]['total'];
                    $receiveitem = new PurchaseItem();
                    $receiveitem->create($ReceivingItemData);
                }
            }

            // BANKS, DEPOSIT &WITHDRAW
            $paymentBalance = 0;
            for($i=0; $i<count($request->receiving_banks); $i++)
            {
                if($request->receiving_banks[$i]['payment_type'] != "Store Account")
                {
                    $paymentBalance = $paymentBalance+$request->receiving_banks[$i]['payment_amount'];
                    $get_bank = Account::where('bank_name', $request->receiving_banks[$i]['payment_type'])->first();

                    //BANKS
                    if(empty($get_bank))
                    {
                        $BanktemData['bank_name']           = $request->receiving_banks[$i]['payment_type'];
                        $BanktemData['opening_balance']     = 0;
                        $BanktemData['user_id']             = 1;
                        $bank = new Account();
                        $bank->create($BanktemData);
                    }

                    //RECEIVING MINUS INVOICE PAYMENT INSERT AS ACCOUNT PAYABLE(AP)

                    $APData['purchase_id'] 			= $systemReceivingId;
                    $APData['party_id'] 			= $receiving_supplier_id;
                    $APData['account_id'] 			= 2;
                    $APData['purpose_id']           = 5;
                    $APData['user_id'] 				= 1;
                    $APData['note']					= $request->receiving['comment'];
                    $APData['total_amount'] 	    = -1 * $request->receiving_banks[$i]['payment_amount'];
                    $APData['withdraw_type'] 	    = 'purchase';
                    $APData['location'] 	        = $request->receiving['location'];
                    $APData['pos_receiving_id'] 	= $request->receiving['pos_receiving_id'];
                    $APData['withdraw_date']        = $request->receiving['purchase_date'];


                    $withdraw =new Withdraw();
                    $withdraw_save = $withdraw->create($APData);
                    $withdraw_save_id = $withdraw_save->id;

                    $generated_voucher_number = "withdraw-".$withdraw_save_id;
                    $voucher_number['voucher_number'] = $generated_voucher_number;
                    $withdraw_save->update($voucher_number);

                    //RECEIVING PLUS INVOICE PAYMENT INSERT AS OWN BANK
                    $get_own_bank = Account::where('bank_name', $request->receiving_banks[$i]['payment_type'])->first();
                    $bank_own_id = $get_own_bank->id;

                    $APData['purchase_id'] 			= $systemReceivingId;
                    $APData['party_id'] 			= $receiving_supplier_id;
                    $APData['account_id'] 			= $bank_own_id;
                    $APData['purpose_id']           = 5;
                    $APData['user_id'] 				= 1;
                    $APData['note']					= $request->receiving['comment'];
                    $APData['total_amount'] 	    = $request->receiving_banks[$i]['payment_amount'];
                    $APData['withdraw_type'] 	    = 'purchase';
                    $APData['location'] 	        = $request->receiving['location'];
                    $APData['pos_receiving_id'] 	= $request->receiving['pos_receiving_id'];
                    $APData['withdraw_date']        = $request->receiving['purchase_date'];

                    $withdraw =new Withdraw();
                    $withdraw_save = $withdraw->create($APData);
                    $withdraw_save_id = $withdraw_save->id;

                    $generated_voucher_number = "withdraw-".$withdraw_save_id;
                    $voucher_number['voucher_number'] = $generated_voucher_number;
                    $withdraw_save->update($voucher_number);
                }else{
                    $getStoreAccountTypeSupplier = Party::where('pos_supplier_id', $party_id)->first();
                    $StoreAccountTypeData['current_balance'] = $getStoreAccountTypeSupplier->current_balance + $request->receiving_banks[$i]['payment_amount'];
                    $getStoreAccountTypeSupplier->update($StoreAccountTypeData);
                }
            }

            $totalPaymentBalance = $paymentBalance;

            if($request->receiving['store_account_payment'] == "1")
            {   $getStoreAccountSupplier = Party::where('pos_supplier_id', $party_id)->first();
                $StoreAccountData['current_balance'] = $getStoreAccountSupplier->current_balance - $totalPaymentBalance;
                $getStoreAccountSupplier->update($StoreAccountData);
            }

            return response()->json(['succcess_message' => 'Purchase successfully created!'], 200);
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
            $getPurchaseData = Purchase::where('pos_receiving_id', $request->pos_receiving_id)->first();


            //DELETING RECEIVING DATA IF FOUND
            if(!is_null($getPurchaseData)){
                $deleteReceivingId = $getPurchaseData->id;
                $deleteSupplierId = $getPurchaseData->party->id;

                $getReceivingTotalBalance= Purchase::where('pos_receiving_id', $request->pos_receiving_id)->first();

                $getStoreAccountMinusBalance = Withdraw::where('pos_receiving_id', $request->pos_receiving_id)
                                            ->where('total_amount', '<', '0')
                                            ->selectRaw('sum(total_amount) as total_amount')
                                            ->first();
                $getReceivingSupplier = Party::where('id', $deleteSupplierId)->first();

                $supplerDataUpdate['current_balance'] = $getReceivingSupplier->current_balance - ($getReceivingTotalBalance->total_amount+$getStoreAccountMinusBalance->total_amount);
                $getReceivingSupplier->update($supplerDataUpdate);

                $getSaleWithdrawDatas = Withdraw::where('purchase_id', $deleteReceivingId)->get();

                foreach($getSaleWithdrawDatas as $getSaleWithdrawData)
                {
                    $getSaleWithdrawData->update($statusData);
                }

                $getPurchaseData = Purchase::where('id', $deleteReceivingId)->first();
                $getPurchaseData->update($statusData);
            }
            return response()->json(['succcess_message' => 'Purchase successfully deleted!'], 200);
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

            $getPurchaseData = Purchase::where('pos_receiving_id', $request->pos_receiving_id)->first();


            //DELETING RECEIVING DATA IF FOUND
            if(!is_null($getPurchaseData)){
                $deleteReceivingId = $getPurchaseData->id;
                $deleteSupplierId = $getPurchaseData->party->id;

                $getReceivingTotalBalance= Purchase::where('pos_receiving_id', $request->pos_receiving_id)->first();

                $getStoreAccountMinusBalance = Withdraw::where('pos_receiving_id', $request->pos_receiving_id)
                                            ->where('total_amount', '<', '0')
                                            ->selectRaw('sum(total_amount) as total_amount')
                                            ->first();
                $getReceivingSupplier = Party::where('id', $deleteSupplierId)->first();

                $supplerDataUpdate['current_balance'] = $getReceivingSupplier->current_balance + ($getReceivingTotalBalance->total_amount+$getStoreAccountMinusBalance->total_amount);
                $getReceivingSupplier->update($supplerDataUpdate);

                $getSaleWithdrawDatas = Withdraw::where('purchase_id', $deleteReceivingId)->get();

                foreach($getSaleWithdrawDatas as $getSaleWithdrawData)
                {
                    $getSaleWithdrawData->update($statusData);
                }

                $getPurchaseData = Purchase::where('id', $deleteReceivingId)->first();
                $getPurchaseData->update($statusData);
            }
            return response()->json(['succcess_message' => 'Purchase successfully restored!'], 200);
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return response()->json(['error_message' => $ex->getMessage()], 401);
        }
    }
}
