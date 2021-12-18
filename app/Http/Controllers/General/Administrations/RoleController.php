<?php

namespace App\Http\Controllers\General\Administrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Page;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Artisan;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
    */
    public function __construct()
    {
        $this->middleware(['role_or_permission:developer|super admin|master|global|role view'],   ['only' => ['index', 'show']]);
        $this->middleware(['role_or_permission:developer|super admin|master|global|role create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:developer|super admin|master|global|role edit'],   ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:developer|super admin|master|global|role delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::with('permissions')
                     ->where('name', '!=', 'developer')
                     ->get();
        return view('general.administrations.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages = Page::All();
        return view('general.administrations.roles.create', compact('pages'));
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
            'name'                 => 'required|min:3|max:100|unique:roles',
            'permissions'           =>  'required'
        ]);

        DB::beginTransaction();
        try {
            $role = Role::create(['name' => strtolower($validatedData['name'])]);
            $role->givePermissionTo($validatedData['permissions']);
            DB::commit();
            return redirect()->route('role.index')->with('successMessage', 'Role successfully created!');
        } catch (\Exception $ex) {
            DB::rollback();
            Artisan::call('cache:clear');
            return redirect()->route('role.create')->with('errorMessage', $ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $pages = Page::All();
        if($role->name == 'developer' || $role->name == 'super admin' || $role->name == 'uncategorized')
        {
            return redirect()->route('role.index')->with('errorMessage', 'Modification restricted for selected user!');
        }
        return view('general.administrations.roles.edit', compact('pages','role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        if($role->name == 'developer' || $role->name == 'super admin' || $role->name == 'uncategorized')
        {
            return redirect()->route('role.index')->with('errorMessage', 'Modification restricted for selected user!');
        }

        $validatedData = $request->validate([
            'name'                 => 'required|min:3|max:100|unique:roles,name,'.$role->id,
            'permissions'           =>  'required'
        ]);

        DB::beginTransaction();
        try {
            $updated_role = $role->update(['name' => strtolower($validatedData['name'])]);
            $role->syncPermissions($validatedData['permissions']);
            DB::commit();
            return redirect()->route('role.edit', $role->id)->with('successMessage', 'Role successfully edited!');
        } catch (\Exception $ex) {
            DB::rollback();
            Artisan::call('cache:clear');
            return redirect()->route('role.edit', $role->id)->with('errorMessage', $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if($role->name == 'developer' || $role->name == 'super admin' || $role->name == 'uncategorized')
        {
            return redirect()->route('role.index')->with('errorMessage', 'Modification restricted for selected user!');
        }

        if($role->delete()){
            return redirect()->route('role.index')->with('successMessage', 'Role deleted successfully!');
        }
    }
}
