<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Section extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'section'
    ];

    public function company() : BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function users() : HasMany
    {
        return $this->hasMany(User::class);
    }

    // public function battalion()
    // {
    //     return $this->hasOneThrough(Battalion::class,Company::class);
    // }

}
