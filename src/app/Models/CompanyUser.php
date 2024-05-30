<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;

class CompanyUser extends Model
{
    use UuidTrait, HasFactory;

    // protected $keyType = 'string';
    
    // public $incrementing = false;

    protected $fillable = [
        'company_id',
        'user_id',
    ];

    public function company() {
       return $this->belongsTo(Company::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
