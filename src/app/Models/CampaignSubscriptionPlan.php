<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CampaignSubscriptionPlan extends Model
{
    use HasFactory, UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['campaign_id', 'title', 'price', 'game_plays'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    // Emeka
    public function campaignSubcription() {
        return $this->hasMany(CampaignSubscription::class);
    }
}
