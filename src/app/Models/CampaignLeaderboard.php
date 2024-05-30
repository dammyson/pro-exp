<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;


class CampaignLeaderboard extends Model
{
    use HasFactory, UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'campaign_id', 'audience_id', 'play_durations', 'play_points',
        'referral_points', 'total_points'
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function audience() 
    {
        return $this->belongsTo(Audience::class);
    }


}
