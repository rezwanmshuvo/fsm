<?php

namespace App\Http\Controllers\General\FSM;

use App\Http\Controllers\Controller;
use App\Model\Shift;
use Illuminate\Http\Request;
use App\DataTables\ShiftDataTable;
use Illuminate\Support\Facades\Artisan;

use function GuzzleHttp\Promise\all;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('role_or_permission:developer|super admin|master|global|shift');
    }
    public function index(ShiftDataTable $dataTable)
    {
        return $dataTable->render('general.pumpmaster.shifts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('general.pumpmaster.shifts.create');
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
            'start_time'        => '',
            'end_time'          => ''
        ]);

        $shift = new Shift();

        try {
            $shift->create($validateData);
            return redirect()->route('shift.index')->with('successMessage', 'shift successfully created!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('shift.create')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function show(Shift $shift)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function edit(Shift $shift)
    {
        return view('general.pumpmaster.shifts.edit', compact('shift'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shift $shift)
    {
        $validateData = $request->validate([
            'name'              => 'required|min:3|max:50',
            'start_time'        => '',
            'end_time'          => ''
        ]);

        try {
            $shift->update($validateData);
            return redirect()->route('shift.index')->with('successMessage', 'Shift successfully updated!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('shift.edit', $shift->id)->with('errorMessage', 'An error has occurred please try again later!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shift $shift)
    {
        $deleteData = [];
        $deleteData['delete_status'] = '1';

        try {
            $shift->update($deleteData);
            return redirect()->route('shift.index')->with('successMessage', 'Shift successfully deleted!');
        } catch (\Exception $ex) {
            Artisan::call('cache:clear');
            return redirect()->route('shift.index')->with('errorMessage', 'An error has occurred please try again later!');
        }
    }
}
