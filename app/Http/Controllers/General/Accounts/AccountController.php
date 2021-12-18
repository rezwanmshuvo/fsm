<?php

namespace App\Http\Controllers\General\Accounts;

use App\Http\Controllers\Controller;
use App\Model\Account;
use Illuminate\Http\Request;
use App\DataTables\AccountDataTable;
use Illuminate\Support\Facades\Artisan;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:developer|super admin|master|global|bank');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AccountDataTable $dataTable)
    {
        return $dataTable->render('general.accounts.banks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('general.accounts.banks.create');
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
            'bank_name'            => 'required|min:3|max:50',
            'bank_branch'          => '',
            'account_name'         => '',
            'account_number'       => '',
            'opening_balance'      => 'required|numeric'
        ]);

        $validateData['user_id'] = auth()->user()->id;
        $account = new Account;

        try {
            $account->create($validateData);
            return redirect()->route('bank.index')->with('successMessage', 'Bank successfully created!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('bank.create')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $bank)
    {
        return view('general.accounts.banks.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $bank)
    {
        $validateData = $request->validate([
            'bank_name'            => 'required|min:3|max:50',
            'bank_branch'          => '',
            'account_name'         => '',
            'account_number'       => '',
            'opening_balance'      => 'required|numeric'
        ]);

        try {
            $bank->update($validateData);
            return redirect()->route('bank.index')->with('successMessage', 'Bank successfully updated!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('bank.edit', $bank->id)->with('errorMessage', 'An error has occurred please try again later!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $bank)
    {
        $deleteData = [];
        $deleteData['delete_status'] = '1';

        try {
            $bank->update($deleteData);
            return redirect()->route('bank.index')->with('successMessage', 'Bank successfully deleted!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('bank.index')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }
}
