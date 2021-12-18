<?php

namespace App\Http\Controllers\General\FSM;

use App\Http\Controllers\Controller;
use App\Model\Nozzle;
use Illuminate\Http\Request;
use App\DataTables\NozzleDataTable;
use App\Model\Item;
use App\Model\Machine;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class NozzleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('role_or_permission:developer|super admin|master|global|nozzle');
    }
    public function index(NozzleDataTable $dataTable)
    {
        return $dataTable->render('general.pumpmaster.nozzles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $machines = Machine::where('delete_status', '0')->get();
        $items = Item::where('delete_status', '0')->get();

        return view('general.pumpmaster.nozzles.create', compact('machines', 'items'));
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
            'machine_id'        => 'required',
            'item_id'           => 'required',
            'start_reading'     => 'required',
            'current_reading'   => 'required'
        ]);

        $nozzle = new Nozzle();

        try {
            $nozzle->create($validateData);
            return redirect()->route('nozzle.index')->with('successMessage', 'Nozzle successfully created!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('nozzle.create')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Nozzle  $nozzle
     * @return \Illuminate\Http\Response
     */
    public function show(Nozzle $nozzle)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Nozzle  $nozzle
     * @return \Illuminate\Http\Response
     */
    public function edit(Nozzle $nozzle)
    {
        $machines = Machine::where('delete_status', '0')->get();
        $items = Item::where('delete_status', '0')->get();

        return view('general.pumpmaster.nozzles.edit', compact('nozzle', 'machines', 'items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Nozzle  $nozzle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nozzle $nozzle)
    {
        $validateData = $request->validate([
            'name'              => 'required|min:3|max:50',
            'machine_id'        => 'required',
            'item_id'           => 'required',
            'start_reading'     => '',
            'current_reading'   => ''
        ]);

        try {
            $nozzle->update($validateData);
            return redirect()->route('nozzle.index')->with('successMessage', 'Nozzle successfully updated!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('nozzle.edit', $nozzle->id)->with('errorMessage', 'An error has occurred please try again later!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Nozzle  $nozzle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nozzle $nozzle)
    {
        $deleteData = [];
        $deleteData['delete_status'] = '1';

        try {
            $nozzle->update($deleteData);
            return redirect()->route('nozzle.index')->with('successMessage', 'Nozzle successfully deleted!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('nozzle.index')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }
}
