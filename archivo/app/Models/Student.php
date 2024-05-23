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
        'name',
        'matricul',
        'section_id',
    ];  
   
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function company() : HasOneThrough{
        return $this->hasOneThrough(Company::class,Section::class);
    }
}
