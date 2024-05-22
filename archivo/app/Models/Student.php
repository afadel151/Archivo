<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'section_id',
        'user_id',
    ];  
    public function section() : BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function company() : HasOneThrough{
        return $this->hasOneThrough(Company::class,Section::class);
    }

    public function modules() 
    {
        $section = $this->section;
        $company = $section->company;
        $battalion = $company->battalion;
        $modules = Module::where('battalion',$battalion->battalion)->where('sector',$company->sector)->get();
        return $modules;
    }

}
