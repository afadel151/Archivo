<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function files()
    {
        return $this->hasMany(File::class, 'user_id');
    }

 
    public function section() : BelongsTo
    {
        return $this->belongsTo(Section::class,'section_id');
    }
    public function modules() 
    {
        $section = $this->section;
        $company = $section->company;
        $battalion = $company->battalion;
        $modules = Module::where('battalion',$battalion->battalion)->where('sector',$company->sector)->get();
        return $modules;
    }
    public function favourits() : BelongsToMany
    {
        return $this->belongsToMany(File::class,'favourits');
    }

}
