<?php

namespace App\Http\Controllers\General\Product;

use App\Http\Controllers\Controller;
use App\Model\Item;
use App\Model\ItemCategory;
use App\User;
use Illuminate\Http\Request;
use App\DataTables\ItemDataTable;
use Illuminate\Support\Facades\Artisan;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('role_or_permission:developer|super admin|master|global|item');
    }
    public function index(ItemDataTable $dataTable)
    {
        return $dataTable->render('general.product.items.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $itemCategories = ItemCategory::where('delete_status', '0')->get();
        $users = User::get();

        return view('general.product.items.create', compact('itemCategories', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name'                      => 'required|min:3|max:50',
            'item_category_id'          => 'required',
            'location'                  => '',
            'pos_item_id'               => '',
            'costing_price'             => 'required',
            'selling_price'             => 'required',
            'opening_stock'             => 'required'
        ]);

        $validateData['average_costing_price'] = $request->costing_price;
        $validateData['current_stock'] = $request->opening_stock;
        $validateData['user_id'] = auth()->user()->id;
        $item = new Item();

        try {
            $item->create($validateData);
            return redirect()->route('item.index')->with('successMessage', 'Item successfully created!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('item.create')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $itemCategories = ItemCategory::where('delete_status', '0')->get();

        return view('general.product.items.edit', compact('item', 'itemCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $validateData = $request->validate([
            'name'                      => 'required|min:3|max:50',
            'item_category_id'          => 'required',
            'location'                  => '',
            'pos_item_id'               => '',
            'costing_price'             => 'required',
            'selling_price'             => 'required',
            'average_costing_price'     => 'required',
            'opening_stock'             => 'required',
            'current_stock'             => 'required'
        ]);

        $validateData['user_id'] = auth()->user()->id;

        try {
            $item->create($validateData);
            return redirect()->route('item.index')->with('successMessage', 'Item successfully Updated!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('item.edit')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $deleteData = [];
        $deleteData['delete_status'] = '1';

        try {
            $item->update($deleteData);
            return redirect()->route('item.index')->with('successMessage', 'Item successfully deleted!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('item.index')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }
}
