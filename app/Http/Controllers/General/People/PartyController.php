<?php

namespace App\Http\Controllers\General\People;

use App\Http\Controllers\Controller;
use App\Model\Party;
use Illuminate\Http\Request;
use App\DataTables\SupplierDataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('role_or_permission:developer|super admin|master|global|party');
    }
    public function index(SupplierDataTable $dataTable)
    {
        return $dataTable->render('general.people.suppliers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('general.people.suppliers.create');
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
            'name'              => 'required|min:3|max:50',
            'phone'             => 'required|digits:11',
            'email'             => '',
            'address'           => '',
            'bank_name'         => '',
            'bank_branch'       => '',
            'account_name'      => '',
            'account_number'    => ''
        ]);

        $validateData['user_id'] = auth()->user()->id;

        $party = new Party;

        try {
            $party->create($validateData);
            return redirect()->route('supplier.index')->with('successMessage', 'Supplier successfully created!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('supplier.create')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function show(Party $supplier)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function edit(Party $supplier)
    {
        return view('general.people.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Party $supplier)
    {
        $validateData = $request->validate([
            'name'              => 'required|min:3|max:50',
            'phone'             => 'required|digits:11',
            'email'             => '',
            'address'           => '',
            'bank_name'         => '',
            'bank_branch'       => '',
            'account_name'      => '',
            'account_number'    => ''
        ]);

        try {
            $supplier->update($validateData);
            return redirect()->route('supplier.index')->with('successMessage', 'Supplier successfully updated!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('supplier.edit', $supplier->id)->with('errorMessage', 'An error has occurred please try again later!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function destroy(Party $supplier)
    {
        $deleteData = [];
        $deleteData['delete_status'] = '1';

        try {
            $supplier->update($deleteData);
            return redirect()->route('supplier.index')->with('successMessage', 'Supplier successfully deleted!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('supplier.index')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxStore(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'              => 'required|min:3|max:50',
            'phone'             => 'required|digits:11',
            'email'             => '',
            'address'           => '',
            'bank_name'         => '',
            'bank_branch'       => '',
            'account_name'      => '',
            'account_number'    => ''
        ]);

        if($validator->fails()){
            return response()->json(
                [
                'status' =>0,
                'error'   =>$validator->errors()->toArray()
            ]);
        }else{
            $values = [
                'user_id'           => Auth::user()->id,
                'name'              => $request->name,
                'phone'             => $request->phone,
                'email'             => $request->email,
                'address'           => $request->address,
                'bank_name'         => $request->bank_name,
                'bank_branch'       => $request->bank_branch,
                'account_name'      => $request->account_name,
                'account_number'    => $request->account_number
            ];

            try {
                $query = DB::table('parties')->insertGetId($values);
                return response()->json([
                    'status'        =>1,
                    'supplier_name' => $request->name,
                    'supplier_id'   => $query,
                    'message'       => ''
                ]);
            } catch (\Exception $ex) {
                return response()->json([
                    'status'        =>1,
                    'message'       => 'An error has occurred please try again later!',
                ]);
            }
        }
    }
}
