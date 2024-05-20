<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Schoolyear;
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
    public function get_my_files($id){
        if (Auth::user()->hasRole('admin')) {
            $files =  User::find($id)->files;
            $files->load('module','schoolyear');
            \Log::info($files);
            $user = User::find($id);
            $schoolyears = Schoolyear::all();
            $modules  = Module::all();
            return Inertia::render('MyFiles',['files' => $files, 'user' => $user, 'modules' => $modules, 'schoolyears' => $schoolyears]);
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
        \Log::info('Storing resource : '.$request);
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $user->assignRole(Role::find($request->input('role')));
        $user->load('roles');
        return response()->json($user);
    }

    /**
     * Display the specified resource.
     */
    public function get_files(string $id)
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
