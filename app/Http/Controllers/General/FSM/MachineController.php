<?php

namespace App\Http\Controllers\General\FSM;

use App\Http\Controllers\Controller;
use App\Model\Machine;
use App\Model\Tank;
use Illuminate\Http\Request;
use App\DataTables\MachineDataTable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('role_or_permission:developer|super admin|master|global|machine');
    }
    public function index(MachineDataTable $dataTable)
    {
        return $dataTable->render('general.pumpmaster.machines.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tanks = Tank::where('delete_status', '0')->get();

        return view('general.pumpmaster.machines.create', compact('tanks'));
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
            'tank_id'           => 'required',
            'model'             => '',
            'no_of_nozzle'      => '',
            'serial_no'         => ''
        ]);

        $machine = new Machine();

        try {
            $machine->create($validateData);
            return redirect()->route('machine.index')->with('successMessage', 'Machine successfully created!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('machine.create')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Machine  $machine
     * @return \Illuminate\Http\Response
     */
    public function show(Machine $machine)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Machine  $machine
     * @return \Illuminate\Http\Response
     */
    public function edit(Machine $machine)
    {
        $tanks = Tank::where('delete_status', '0')->get();
        return view('general.pumpmaster.machines.edit', compact('machine', 'tanks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Machine  $machine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Machine $machine)
    {
        $validateData = $request->validate([
            'name'              => 'required|min:3|max:50',
            'tank_id'           => 'required',
            'model'             => '',
            'no_of_nozzle'      => '',
            'serial_no'         => ''
        ]);

        try {
            $machine->update($validateData);
            return redirect()->route('machine.index')->with('successMessage', 'Machine successfully updated!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('machine.edit', $machine->id)->with('errorMessage', 'An error has occurred please try again later!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Machine  $machine
     * @return \Illuminate\Http\Response
     */
    public function destroy(Machine $machine)
    {
        $deleteData = [];
        $deleteData['delete_status'] = '1';

        try {
            $machine->update($deleteData);
            return redirect()->route('machine.index')->with('successMessage', 'Machine successfully deleted!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('machine.index')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }
}
