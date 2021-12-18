<?php

namespace App\Http\Controllers\Api\V1\General\Product;

use App\Http\Controllers\Controller;
use App\Model\ApiKey;
use App\Model\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:item');
    }
    //ITEM ADD THROUGH API
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name'                => '',
            'item_category_id'    => '',
            'user_id'             => '',
            'api_key_id'          => '',
            'pos_item_id'         => ''
        ]);

        $getapikey = ApiKey::where('system_key', $request->header('APIKEY'))->first();

        if(!is_null($getapikey))
        {
            $validateData['api_key_id'] = $getapikey->id;
        }else{
            return response()->json(['message' => 'Api key not found!'], 401);
        }

        try {
            $item = new Item();

            $item->create($validateData);
            return response()->json(['succcess_message' => 'Item successfully created!'], 200);
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return response()->json(['error_message' => $ex->getMessage()], 401);
        }
    }

    //ITEM UPDATE THROUGH API
    public function update(Request $request)
    {
        $validateData = $request->validate([
            'name'                => '',
            'pos_item_id'         => ''
        ]);

        try {
            $item = Item::where('pos_item_id', $request->pos_item_id)->first();
            $item->update($validateData);
            return response()->json(['succcess_message' => 'Item successfully updated!'], 200);
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return response()->json(['error_message' => $ex->getMessage()], 401);
        }
    }

    //ITEMS DELETE(ACTUALE STATUS CHANGED TO 1) THROUGH API
    public function distroy(Request $request)
    {
        $statusData['delete_status'] = '1';
        try {
            $items = Item::whereIn('pos_item_id', $request->pos_item_id)->get();
             foreach($items as $item)
             {
                $item->update($statusData);
             }
            return response()->json(['succcess_message' => 'Item successfully deleted!'], 200);
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return response()->json(['error_message' => $ex->getMessage()], 401);
        }
    }

    //ITEMS UNDELETE(ACTUALE STATUS CHANGED TO 0) THROUGH API
    public function undistroy(Request $request)
    {
        $statusData['delete_status'] = '0';
        try {
            $items = Item::whereIn('pos_item_id', $request->pos_item_id)->get();
             foreach($items as $item)
             {
                $item->update($statusData);
             }
            return response()->json(['succcess_message' => 'Item successfully restored!'], 200);
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return response()->json(['error_message' => $ex->getMessage()], 401);
        }
    }
}
