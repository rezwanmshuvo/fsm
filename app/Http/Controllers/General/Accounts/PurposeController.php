<?php

namespace App\Http\Controllers\General\Accounts;

use App\Http\Controllers\Controller;
use App\Model\Purpose;
use Illuminate\Http\Request;
use App\DataTables\PurposeDataTable;
use Illuminate\Support\Facades\Artisan;

class PurposeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('role_or_permission:developer|super admin|master|global|purposes');
    }
    public function index(PurposeDataTable $dataTable)
    {
        return $dataTable->render('general.accounts.purposes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $purposes = Purpose::where('delete_status', '0')->get();
        return view('general.accounts.purposes.create', compact('purposes'));
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
            'purpose_id'            => '',
            'name'                  => 'required|min:3|max:50',
            'purpose_type'          => 'required'
        ]);

        $validateData['user_id'] = auth()->user()->id;
        $purpose = new Purpose;

        try {
            $purpose->create($validateData);
            return redirect()->route('purpose.index')->with('successMessage', 'Purpose successfully created!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('purpose.create')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Purpose  $purpose
     * @return \Illuminate\Http\Response
     */
    public function show(Purpose $purpose)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Purpose  $purpose
     * @return \Illuminate\Http\Response
     */
    public function edit(Purpose $purpose)
    {
        $purposes = Purpose::where('delete_status', '0')
                    ->where('id', '!=', $purpose->id)->get();
        return view('general.accounts.purposes.edit', compact('purposes', 'purpose'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Purpose  $purpose
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purpose $purpose)
    {
        $validateData = $request->validate([
            'purpose_id'            => '',
            'name'                  => 'required|min:3|max:50',
            'purpose_type'          => 'required'
        ]);

        try {
            $purpose->update($validateData);
            return redirect()->route('purpose.index')->with('successMessage', 'Purpose successfully updated!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('purpose.edit', $purpose->id)->with('errorMessage', 'An error has occurred please try again later!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Purpose  $purpose
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purpose $purpose)
    {
        $deleteData = [];
        $deleteData['delete_status'] = '1';

        try {
            $purpose->update($deleteData);
            return redirect()->route('purpose.index')->with('successMessage', 'Purpose successfully deleted!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('purpose.index')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }
}
