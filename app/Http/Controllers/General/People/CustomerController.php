<?php

namespace App\Http\Controllers\General\People;

use App\Http\Controllers\Controller;
use App\Model\Customer;
use Illuminate\Http\Request;
use App\DataTables\CustomerDataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('role_or_permission:developer|super admin|master|global|customer');
    }
    public function index(CustomerDataTable $dataTable)
    {
        return $dataTable->render('general.people.customers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('general.people.customers.create');
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


        $customer = new Customer;

        try {
            $customer->create($validateData);
            return redirect()->route('customer.index')->with('successMessage', 'Customer successfully created!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('customer.create')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('general.people.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
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
            $customer->update($validateData);
            return redirect()->route('customer.index')->with('successMessage', 'Customer successfully updated!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('customer.edit', $customer->id)->with('errorMessage', 'An error has occurred please try again later!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $deleteData = [];
        $deleteData['delete_status'] = '1';

        try {
            $customer->update($deleteData);
            return redirect()->route('customer.index')->with('successMessage', 'Customer successfully deleted!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('customer.index')->with('errorMessage', 'An error has occurred please try again later!');
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
                $query = DB::table('customers')->insertGetId($values);
                return response()->json([
                    'status'        =>1,
                    'customer_name' => $request->name,
                    'customer_id'   => $query,
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
