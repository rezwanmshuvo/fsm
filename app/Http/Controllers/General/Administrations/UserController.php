<?php

namespace App\Http\Controllers\General\Administrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Artisan;

class UserController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
    */
    public function __construct()
    {
        $this->middleware(['role_or_permission:developer|super admin|master|global|user view'],   ['only' => ['index', 'show']]);
        $this->middleware(['role_or_permission:developer|super admin|master|global|user create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:developer|super admin|master|global|user edit'],   ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:developer|super admin|master|global|user delete'], ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles')
                     ->where('id', '!=', '1')
                     ->get();
        return view('general.administrations.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('name', '!=', 'developer')
                     ->where('name', '!=', 'uncategorized')
                     ->where('name', '!=', 'super admin')
                     ->get();
        return view('general.administrations.users.create', compact('roles'));
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
            'role'                      => 'required',
            'name'                      => 'required|min:3|max:50',
            'username'                  => 'required|unique:users',
            'email'                     => '',
            'phone'                     => '',
            'address'                   => '',
            'password'                  => 'required|min:6|confirmed',
            'password_confirmation'     => 'required'
        ]);

        if($validatedData['role'] == 'developer' || $validatedData['role'] == 'super admin' || $validatedData['role'] == 'uncategorized')
        {
            return redirect()->route('user.create')->with('errorMessage', 'Something went wrong please try again!');
        }

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['image'] = 'default.jpg';

        DB::beginTransaction();
        $user = User::create($validatedData);
        if($user)
        {
            try {
                $user->assignRole($validatedData['role']);
                DB::commit();
                return redirect()->route('user.index')->with('successMessage', 'User successfully created!');
            } catch (\Exception $ex) {
                DB::rollback();
                Artisan::call('cache:clear');
                return redirect()->route('user.create')->with('errorMessage', $ex->getMessage());
            }
        }
        return redirect()->route('user.index')->with('errorMessage', 'An error has occurred please try again later!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        dd($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
