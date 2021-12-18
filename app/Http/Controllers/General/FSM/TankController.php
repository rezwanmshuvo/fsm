<?php

namespace App\Http\Controllers\General\FSM;

use App\Http\Controllers\Controller;
use App\Model\Tank;
use Illuminate\Http\Request;
use App\DataTables\TankDataTable;
use Illuminate\Support\Facades\Artisan;

class TankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('role_or_permission:developer|super admin|master|global|tank');
    }
    public function index(TankDataTable $dataTable)
    {
        return $dataTable->render('general.pumpmaster.tanks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('general.pumpmaster.tanks.create');
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
            'capacity'          => 'required',
            'dip_min'           => 'required',
            'dip_max'           => 'required',
            'dip_in_mm'         => 'required'
        ]);

        $tank = new Tank();

        try {
            $tank->create($validateData);
            return redirect()->route('tank.index')->with('successMessage', 'tank successfully created!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('tank.create')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Tank  $tank
     * @return \Illuminate\Http\Response
     */
    public function show(Tank $tank)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Tank  $tank
     * @return \Illuminate\Http\Response
     */
    public function edit(Tank $tank)
    {
        return view('general.pumpmaster.tanks.edit', compact('tank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Tank  $tank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tank $tank)
    {
        $validateData = $request->validate([
            'name'              => 'required|min:3|max:50',
            'capacity'          => 'required',
            'dip_min'           => 'required',
            'dip_max'           => 'required',
            'dip_in_mm'         => 'required'
        ]);

        try {
            $tank->update($validateData);
            return redirect()->route('tank.index')->with('successMessage', 'Tank successfully updated!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('tank.update', $tank->id)->with('errorMessage', 'An error has occurred please try again later!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Tank  $tank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tank $tank)
    {
        $deleteData = [];
        $deleteData['delete_status'] = '1';

        try {
            $tank->update($deleteData);
            return redirect()->route('tank.index')->with('successMessage', 'tank successfully deleted!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('tank.index')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }
}
