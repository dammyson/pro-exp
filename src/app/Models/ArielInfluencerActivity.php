<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArielInfluencerActivity extends Model
{
    use HasFactory, UuidTrait;

    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'ariel_influencer_id', 'ariel_shopping_site_id'
    ];

    public function influencer()
    {
        return $this->hasMany(ArielShoppingSite::class);
    }

    // public function arielInfluencer()
    // {
    //     return $this->belongsTo(ArielInfluencer::class);
    // }

    // public function arielShoppingSite()
    // {
    //     return $this->belongsTo(ArielShoppingSite::class);
    // }

}
