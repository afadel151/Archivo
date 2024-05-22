<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Company extends Model
{
    use HasFactory;
    protected $fillable =[
        'battalion_id',
        'sector',
        'company'
    ];


    public function sections() : HasMany
    {
        return $this->hasMany(Section::class);
    }
    public function battalion() : BelongsTo
    {
        return $this->belongsTo(Battalion::class);
    }

    public function students() : HasManyThrough {
        return $this->hasManyThrough(Student::class, Section::class);
    }
}
