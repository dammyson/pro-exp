<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\UuidTrait;

class Company extends Model
{
    use HasFactory, UuidTrait;
    
    // protected $keyType = 'string';
    
    // public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'logo',
        'company_rc',
        'email',
        'phone_number',
        'website',
        'city',
        'state',
        'country',
    ];


    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function CompanyUser() {
        return $this->hasMany(CompanyUser::class);
    }
}
