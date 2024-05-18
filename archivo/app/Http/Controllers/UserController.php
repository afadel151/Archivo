<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        if (Auth::user()->hasRole('super_admin')) {
            $users = User::with('roles')->get();
            $roles = Role::all();
            $permissions = Permission::all();
        return Inertia::render('Users',['users' => $users, 'permissions' => $permissions, 'roles' => $roles]);
        }
        else {
            return view('notsuperuser');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasRole('super_admin')) {
            $roles = Role::all();
            $permissions = Permission::all();
        return Inertia::render('UsersCreate',['roles' => $roles , 'permissions' => $permissions]);
        }
        else {
            return view('notsuperuser');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->username,
            'email' => 'Hayawsayi@gmail.com',
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole(Role::find($request->userrole));
        $user->load('roles');
        return response()->json($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
