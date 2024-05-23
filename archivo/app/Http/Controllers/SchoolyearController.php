<?php

namespace App\Http\Controllers;

use App\Models\Battalion;
use App\Models\Schoolyear;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SchoolyearController extends Controller
{
    public function view($id){
        $battalions = Battalion::where('schoolyear_id',$id)->get();
        $schoolyears = Schoolyear::all();
        return Inertia::render('Schoolyear',[
            'schoolyears'=> $schoolyears,
            'battalions' => $battalions
        ]);
    }
}
