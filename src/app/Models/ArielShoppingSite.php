<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArielShoppingSite extends Model
{
    use HasFactory, UuidTrait;
    /**
     * The attributest that are mass assignable.
     * 
     * @var array
     */

    protected $fillable = [
        'name', 'icon', 'url'
    ];

    public function influencerActivities() 
    {
        return $this->hasMany(ArielInfluencerActivity::class);
    }
}
