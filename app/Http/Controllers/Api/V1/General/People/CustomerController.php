<?php

namespace App\Http\Controllers\Api\V1\General\People;

use App\Http\Controllers\Controller;
use App\Model\ApiKey;
use App\Model\Customer;
use App\Model\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:developer|super admin|master|global|customer');
    }
    //CUSTOMER ADD THROUGH API
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'user_id'           => '',
            'pos_customer_id'   => '',
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
            $depositData['api_key_id'] = $getapikey->id;
        }else{
            return response()->json(['message' => 'Api key not found!'], 401);
        }

        //Deposit

        $depositData['deposit_date'] = date('Y-m-d H:i:s');
        $depositData['account_id']      = $request->account_id;
        $depositData['purpose_id']      = $request->purpose_id;
        $depositData['user_id']         = $request->user_id;
        $depositData['location']        = $request->location;
        $depositData['note']            = $request->note;
        $depositData['total_amount']    = $request->transaction_amount;
        $depositData['deposit_type']    = $request->deposit_type;


        DB::beginTransaction();
        try {
            $customer = new Customer;
            $customer_save = $customer->create($validateData);

            if($request->transaction_amount != 0){
                $depositData['customer_id']     = $customer_save->id;
                $deposit =new Deposit();
                $deposit_save = $deposit->create($depositData);
                $deposit_save_id = $deposit_save->id;

                $generated_voucher_number = "deposit-".$deposit_save_id;
                $voucher_number['voucher_number'] = $generated_voucher_number;
                $deposit_save->update($voucher_number);
            }
            DB::commit();
            return response()->json(['succcess_message' => 'Customer successfully created!'], 200);
        } catch (\Exception $ex) {
            DB::rollback();
            Artisan::call('cache:clear');
            return response()->json(['error_message' => $ex->getMessage()], 401);
        }
    }

    //CUSTOMER UPDATE THROUGH API
    public function update(Request $request)
    {
		$get_customer = Customer::where('pos_customer_id', $request->pos_customer_id)->first();

		if(!is_null($get_customer))
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
				$depositData['api_key_id'] = $getapikey->id;
			}else{
				return response()->json(['message' => 'Api key not found!'], 401);
			}

			//Deposit

			$depositData['deposit_date'] = date('Y-m-d H:i:s');
			$depositData['account_id']      = $request->account_id;
			$depositData['purpose_id']      = $request->purpose_id;
			$depositData['user_id']         = $request->user_id;
			$depositData['location']        = $request->location;
			$depositData['note']            = $request->note;
			$depositData['deposit_type']    = $request->deposit_type;


			DB::beginTransaction();
			try {
				$customer = Customer::where('pos_customer_id', $request->pos_customer_id)->first();

				if (($request->transaction_amount) && $request->transaction_amount != $customer->current_balance)
				{
					$updated_transaction_amount = $request->transaction_amount - $customer->current_balance ;
				}else{
					$updated_transaction_amount = 0;
				}

				$customer_save = $customer->update($validateData);

				if($updated_transaction_amount != 0){
					$depositData['customer_id']     = $customer->id;
					$depositData['total_amount']    = $updated_transaction_amount;
					$deposit =new Deposit();
					$deposit_save = $deposit->create($depositData);
					$deposit_save_id = $deposit_save->id;

					$generated_voucher_number = "deposit-".$deposit_save_id;
					$voucher_number['voucher_number'] = $generated_voucher_number;
					$deposit_save->update($voucher_number);
				}
				DB::commit();
				return response()->json(['succcess_message' => 'Customer successfully updated!'], 200);
			} catch (\Exception $ex) {
				DB::rollback();
				Artisan::call('cache:clear');
				return response()->json(['error_message' => $ex->getMessage()], 401);
			}
		}else{
			$validateData = $request->validate([
            'user_id'           => '',
            'pos_customer_id'   => '',
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
				$depositData['api_key_id'] = $getapikey->id;
			}else{
				return response()->json(['message' => 'Api key not found!'], 401);
			}

			//Deposit

			$depositData['deposit_date'] = date('Y-m-d H:i:s');
			$depositData['account_id']      = $request->account_id;
			$depositData['purpose_id']      = $request->purpose_id;
			$depositData['user_id']         = $request->user_id;
			$depositData['location']        = $request->location;
			$depositData['note']            = $request->note;
			$depositData['total_amount']    = $request->transaction_amount;
			$depositData['deposit_type']    = $request->deposit_type;


			DB::beginTransaction();
			try {
				$customer = new Customer;
				$customer_save = $customer->create($validateData);

				if($request->transaction_amount != 0){
					$depositData['customer_id']     = $customer_save->id;
					$deposit =new Deposit();
					$deposit_save = $deposit->create($depositData);
					$deposit_save_id = $deposit_save->id;

					$generated_voucher_number = "deposit-".$deposit_save_id;
					$voucher_number['voucher_number'] = $generated_voucher_number;
					$deposit_save->update($voucher_number);
				}
				DB::commit();
				return response()->json(['succcess_message' => 'Customer successfully created!'], 200);
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
            $customers = Customer::whereIn('pos_customer_id', $request->pos_customer_id)->get();
             foreach($customers as $customer)
             {
                $customer->update($statusData);
             }
            return response()->json(['succcess_message' => 'Customer successfully deleted!'], 200);
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
            $customers = Customer::whereIn('pos_customer_id', $request->pos_customer_id)->get();
             foreach($customers as $customer)
             {
                $customer->update($statusData);
             }
            return response()->json(['succcess_message' => 'Customer successfully restored!'], 200);
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return response()->json(['error_message' => $ex->getMessage()], 401);
        }
    }
}
