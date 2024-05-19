<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'semester',
        'is_annual',
        'is_semesterial',
        'sector',
        'battalion'
    ];

    public function battalion(){
        return $this->belongsTo(Battalion::class);
    }
    public function files(){
        return $this->hasMany(File::class);
    }
}
