<?php

namespace App\Http\Controllers\General\Administrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Page;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class PermissionController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
    */
    public function __construct()
    {
        $this->middleware(['role_or_permission:developer'],   ['only' => ['index']]);
        $this->middleware(['role_or_permission:developer'], ['only' => ['create', 'store']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::all();
        return view('general.administrations.permissions.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('general.administrations.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'          => 'required|unique:pages'
        ]);

        $validatedData['title'] = strtolower($validatedData['title']);

        DB::beginTransaction();
        if(Page::create($validatedData))
        {
            try {
                $view    = Permission::create(['name' => $validatedData['title']." view"]);
                $add     = Permission::create(['name' => $validatedData['title']." create"]);
                $edit    = Permission::create(['name' => $validatedData['title']." edit"]);
                $delete  = Permission::create(['name' => $validatedData['title']." delete"]);
                DB::commit();
                return redirect()->route('permission.index')->with('successMessage', 'Permissions successfully created!');
            } catch (\Exception $ex) {
                DB::rollback();
                Artisan::call('cache:clear');
                return redirect()->route('permission.create')->with('errorMessage', $ex->getMessage());
            }
        }
        return redirect()->route('permissions.index')->with('errorMessage', 'An error has occurred please try again later!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        //
    }
}
