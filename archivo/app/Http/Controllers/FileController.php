<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Module;
use App\Models\Schoolyear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
     public function store(Request $request)
     {
         if (Auth::user()->hasRole('admin')) {
              if ($request->hasFile('file')) {
                 \Log::info('file: '.$request);
                 $request_file = $request->file('file');
                 $fileName = $request->input('file_name');
                 $OriginalName = $request_file->getClientOriginalName();
                 $path = '/public/'.$request->input('schoolyear_id') .'/'.$request->input('module_id') .'/'.$request->input('file_category').'/'.$request->input('user_id') .'/'.$fileName;
                 $File = new File();
                 $File->name = $fileName;
                 $File->module_id = $request->input('module_id');
                 $File->user_id = $request->input('user_id');
                 $File->schoolyear_id = $request->input('schoolyear_id');
                 $File->category = $request->input('file_category');
                 $NewPath = Storage::disk('local')->putFile($path, $request_file);
                 $File->path = $NewPath;
                 $File->type = $request_file->getClientOriginalExtension();
                 $File->save();
                 $File->load('module','schoolyear');
                 return response()->json($File);
 
              }
              else {
                \Log::info('file not uploaded');
              }
 
         }else {
             return view('notsuperuser');
         }
     }
 
  
    public function index()
    {
        //
    }
    public function upload(Request $request)
    {
        $file = Storage::putFile('photos',$request->file('file'));
        return $file;
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasRole('admin')) {
            $modules = Module::all();
            $schoolyars = Schoolyear::all();
        }else {
            return view('notsuperuser');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
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
