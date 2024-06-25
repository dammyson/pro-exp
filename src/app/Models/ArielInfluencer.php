<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArielInfluencer extends Model
{
    use HasFactory, UuidTrait;

    /**
     * the attributes taht are mass assignable
     * 
     * @var array
    */
    protected $fillable = [
        'full_name', 'code'
    ];

    /**
     * influencerActivities
     * 
     * @return void
    */
    public function influencerActivities()
    {
        return $this->hasMany(ArielInfluencerActivity::class);
    }
}
