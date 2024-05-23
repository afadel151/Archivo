<?php

namespace App\Http\Controllers;

use App\Models\Battalion;
use App\Models\Company;
use App\Models\Module;
use App\Models\Schoolyear;
use App\Models\Section;
use App\Models\Student;
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
            $schoolyears = Schoolyear::all();
            $battalions = Battalion::all();
            $companies = Company::all();
            $sections = Section::all();
        return Inertia::render('Users',['users' => $users,
                                         'permissions' => $permissions,
                                         'roles' => $roles,
                                         'schoolyears' => $schoolyears,
                                         'battalions' => $battalions,
                                         'companies' => $companies,
                                         'sections' => $sections
                                        ]);
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

     
    public  function create()
    {
        if (Auth::user()->hasRole('super_admin')) {
            $roles = Role::all();
            $permissions = Permission::all();
            
        return Inertia::render('UsersCreate',['roles' => $roles , 
                                            'permissions' => $permissions,
                                            
                                        ]);
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
    public function store_student(Request $request)
    {
        \Log::info('Storing resource : '.$request);
        $student = Student::create([
            'name' => $request->input('name'),
            'matricul' =>  $request->input('matricul'),
            'section_id' => $request->input('section_id'),
            'user_id' => 1,
        ]);
       
        $user = User::create([
            'name' => $request->input('name'),
            'email' => str_replace(' ', '', $request->input('name')).''.$request->input('section_id').'@enpei.dz',
            'password' => Hash::make($request->input('password')),
        ]);
        $student->user_id = $user->id;
        $student->update();
        $user->assignRole('student');
        $user->load('roles');
        return response()->json($user);
    }

    /**
     * Display the specified resource.
     */
    public function studentpage()
    {
        if (Auth::user()->is_student == true) {
            $user = Auth::user();
            $favourits = $user->favourits;
            $modules = $user->modules();
            $Schoolyears = Schoolyear::all();
            return Inertia::render('GetFiles',['student'=>$user,'modules'=>$modules,'schoolyears'=>$Schoolyears,'favourits'=>$favourits]);
        }
        else {
            return view('notsuperuser');
        }
    }
    public function studentfavourits(){
        if (Auth::user()->is_student == true) {
            $user = Auth::user();
            $user->load('section');
            $section = $user->section;
            $company = $section->company;
            $battalion = $company->battalion;
            $favourits = $user->favourits;
            return Inertia::render('MyFavourits',[
                'files' => $favourits,
                'student' => $user,
                'section' => $section,
                'company' => $company,
                'battalion' => $battalion,
            ]);
        }
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
