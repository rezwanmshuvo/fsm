<?php
namespace App\Http\Controllers\Api\V1\General\Accounts;

use App\Http\Controllers\Controller;
use App\Model\ApiKey;
use App\Model\Purpose;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class PurposeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('role_or_permission:developer|super admin|master|global|purpose');
    }
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name'            => '',
            'pos_purpose_id'  => '',
            'purpose_id'      => '',
            'purpose_type'    => '',
            'user_id'         => ''
        ]);

        $getapikey = ApiKey::where('system_key', $request->header('APIKEY'))->first();

        if(!is_null($getapikey))
        {
            $validateData['api_key_id'] = $getapikey->id;
        }else{
            return response()->json(['message' => 'Api key not found!'], 401);
        }

        if($request->purpose_id == '0')
        {
            $validateData['purpose_id'] = NULL;
        }else{
            $getParentPurpose = Purpose::where('pos_purpose_id', $request->purpose_id)->first();

            $validateData['purpose_id'] = $getParentPurpose->id;
        }

        try {
            $getParentOldPurpose = Purpose::where('pos_purpose_id', $request->pos_purpose_id)->first();

            if(!is_null($getParentOldPurpose))
            {
                //PURPOSE UPDATE
                $getParentOldPurpose->update($validateData);
                return response()->json(['message' => 'Purpose successfully edited!'], 200);
            }else{

                //PURPOSE CREATE
                $purpose = new Purpose;
                $purpose->create($validateData);
                return response()->json(['message' => 'Purpose successfully created!'], 200);
            }
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return response()->json(['error_message' => $ex->getMessage()], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Purpose  $purpose
     * @return \Illuminate\Http\Response
     */

    //EXPENSE DELETE(ACTUALE STATUS CHANGED TO 1) THROUGH API
    public function destroy(Request $request)
    {
        $deleteData['delete_status'] = '1';
        try {
            $getParentOldPurpose = Purpose::where('pos_purpose_id', $request->pos_purpose_id)->first();

            if(!is_null($getParentOldPurpose))
            {
                //PURPOSE UPDATE
                $getParentOldPurpose->update($deleteData);
                return response()->json(['message' => 'Purpose successfully deleted!'], 200);
            }
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return response()->json(['error_message' => $ex->getMessage()], 401);
        }
    }
}
