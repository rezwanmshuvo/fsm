<?php

namespace App\Http\Controllers\Api\V1\General\People;

use App\Http\Controllers\Controller;
use App\Model\ApiKey;
use App\Model\Party;
use App\Model\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class PartyController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:developer|super admin|master|global|party');
    }
    //SUPPLIER ADD THROUGH API
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'user_id'           => '',
            'pos_supplier_id'   => '',
            'name'              => '',
            'phone'             => '',
            'email'             => '',
            'address'           => '',
            'account_number'    => '',
            'location'          => ''
        ]);

        $validateData['current_balance'] = $request->transaction_amount;

        $getapikey = ApiKey::where('system_key', $request->header('APIKEY'))->first();

        if(!is_null($getapikey))
        {
            $validateData['api_key_id'] = $getapikey->id;
            $withdrawData['api_key_id'] = $getapikey->id;
        }else{
            return response()->json(['message' => 'Api key not found!'], 401);
        }

        //Withdraw

        $withdrawData['withdraw_date'] = date('Y-m-d H:i:s');
        $withdrawData['account_id']      = $request->account_id;
        $withdrawData['purpose_id']      = $request->purpose_id;
        $withdrawData['user_id']         = $request->user_id;
        $withdrawData['location']        = $request->location;
        $withdrawData['note']            = $request->note;
        $withdrawData['total_amount']    = $request->transaction_amount;
        $withdrawData['withdraw_type']   = $request->withdraw_type;


        DB::beginTransaction();
        try {
            $supplier = new Party;
            $supplier_save = $supplier->create($validateData);

            if($request->transaction_amount != 0){
                $withdrawData['party_id']     = $supplier_save->id;
                $withdraw =new Withdraw();
                $withdraw_save = $withdraw->create($withdrawData);
                $withdraw_save_id = $withdraw_save->id;

                $generated_voucher_number = "withdraw-".$withdraw_save_id;
                $voucher_number['voucher_number'] = $generated_voucher_number;
                $withdraw_save->update($voucher_number);
            }
            DB::commit();
            return response()->json(['succcess_message' => 'Supplier successfully created!'], 200);
        } catch (\Exception $ex) {
            DB::rollback();
            Artisan::call('cache:clear');
            return response()->json(['error_message' => $ex->getMessage()], 401);
        }
    }

    //SUPPLIER UPDATE THROUGH API
    public function update(Request $request)
    {
		$get_supplier = Party::where('pos_supplier_id', $request->pos_supplier_id)->first();

		if(!is_null($get_supplier))
		{
			$validateData = $request->validate([
            'name'              => '',
            'phone'             => '',
            'email'             => '',
            'address'           => '',
            'account_number'    => '',
            'location'          => ''
			]);

			$validateData['current_balance'] = $request->transaction_amount;
			$getapikey = ApiKey::where('system_key', $request->header('APIKEY'))->first();

			if(!is_null($getapikey))
			{
				$withdrawData['api_key_id'] = $getapikey->id;
			}else{
				return response()->json(['message' => 'Api key not found!'], 401);
			}

			//withdraw

			$withdrawData['withdraw_date']   = date('Y-m-d H:i:s');
			$withdrawData['account_id']      = $request->account_id;
			$withdrawData['purpose_id']      = $request->purpose_id;
			$withdrawData['user_id']         = $request->user_id;
			$withdrawData['location']        = $request->location;
			$withdrawData['note']            = $request->note;
			$withdrawData['withdraw_type']   = $request->withdraw_type;


			DB::beginTransaction();
			try {
				$supplier = Party::where('pos_supplier_id', $request->pos_supplier_id)->first();

				if (($request->transaction_amount) && $request->transaction_amount != $supplier->current_balance)
				{
					$updated_transaction_amount = $request->transaction_amount - $supplier->current_balance ;
				}else{
					$updated_transaction_amount = 0;
				}

				$supplier_save = $supplier->update($validateData);

				if($updated_transaction_amount != 0){
					$withdrawData['party_id']     = $supplier->id;
					$withdrawData['total_amount']    = $updated_transaction_amount;

					$withdraw =new Withdraw();
					$withdraw_save = $withdraw->create($withdrawData);
					$withdraw_save_id = $withdraw_save->id;

					$generated_voucher_number = "withdraw-".$withdraw_save_id;
					$voucher_number['voucher_number'] = $generated_voucher_number;
					$withdraw_save->update($voucher_number);
				}
				DB::commit();
				return response()->json(['succcess_message' => 'Withdraw successfully updated!'], 200);
			} catch (\Exception $ex) {
				DB::rollback();
				Artisan::call('cache:clear');
				return response()->json(['error_message' => $ex->getMessage()], 401);
			}
		}else{
			$validateData = $request->validate([
				'user_id'           => '',
				'pos_supplier_id'   => '',
				'name'              => '',
				'phone'             => '',
				'email'             => '',
				'address'           => '',
				'account_number'    => '',
				'location'          => ''
			]);

			$validateData['current_balance'] = $request->transaction_amount;

			$getapikey = ApiKey::where('system_key', $request->header('APIKEY'))->first();

			if(!is_null($getapikey))
			{
				$validateData['api_key_id'] = $getapikey->id;
				$withdrawData['api_key_id'] = $getapikey->id;
			}else{
				return response()->json(['message' => 'Api key not found!'], 401);
			}

			//Withdraw

			$withdrawData['withdraw_date'] = date('Y-m-d H:i:s');
			$withdrawData['account_id']      = $request->account_id;
			$withdrawData['purpose_id']      = $request->purpose_id;
			$withdrawData['user_id']         = $request->user_id;
			$withdrawData['location']        = $request->location;
			$withdrawData['note']            = $request->note;
			$withdrawData['total_amount']    = $request->transaction_amount;
			$withdrawData['withdraw_type']   = $request->withdraw_type;


			DB::beginTransaction();
			try {
				$supplier = new Party;
				$supplier_save = $supplier->create($validateData);

				if($request->transaction_amount != 0){
					$withdrawData['party_id']     = $supplier_save->id;
					$withdraw =new Withdraw();
					$withdraw_save = $withdraw->create($withdrawData);
					$withdraw_save_id = $withdraw_save->id;

					$generated_voucher_number = "withdraw-".$withdraw_save_id;
					$voucher_number['voucher_number'] = $generated_voucher_number;
					$withdraw_save->update($voucher_number);
				}
				DB::commit();
				return response()->json(['succcess_message' => 'Supplier successfully created!'], 200);
			} catch (\Exception $ex) {
				DB::rollback();
				Artisan::call('cache:clear');
				return response()->json(['error_message' => $ex->getMessage()], 401);
			}
		}
    }

    //CUSTOMERS DELETE(ACTUALE STATUS CHANGED TO 1) THROUGH API
    public function distroy(Request $request)
    {
        $statusData['delete_status'] = '1';
        try {
            $suppliers = Party::whereIn('pos_supplier_id', $request->pos_supplier_id)->get();
             foreach($suppliers as $supplier)
             {
                $supplier->update($statusData);
             }
            return response()->json(['succcess_message' => 'Supplier successfully deleted!'], 200);
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return response()->json(['error_message' => $ex->getMessage()], 401);
        }
    }

    //CUSTOMERS UNDELETE(ACTUALE STATUS CHANGED TO 0) THROUGH API
    public function undistroy(Request $request)
    {
        $statusData['delete_status'] = '0';
        try {
            $suppliers = Party::whereIn('pos_supplier_id', $request->pos_supplier_id)->get();
             foreach($suppliers as $supplier)
             {
                $supplier->update($statusData);
             }
            return response()->json(['succcess_message' => 'Supplier successfully restored!'], 200);
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return response()->json(['error_message' => $ex->getMessage()], 401);
        }
    }
}
