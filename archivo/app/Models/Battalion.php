<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Battalion extends Model
{
    use HasFactory;

    public function companies() : HasMany{
        return $this->hasMany(Company::class);
    }

    public function sections(): HasManyThrough 
    {
        return $this->hasManyThrough(Section::class, Company::class);
    }
    public function schoolyear():BelongsTo {
        return $this->belongsTo(Schoolyear::class);
    }
}
