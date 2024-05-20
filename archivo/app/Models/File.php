<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'type',
        'user_id',
        'module_id',
        'schoolyear_id',
        'category'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function module(){
        return $this->belongsTo(Module::class);
    }
    public function schoolyear(){
        return $this->belongsTo(Schoolyear::class);
    }
}
