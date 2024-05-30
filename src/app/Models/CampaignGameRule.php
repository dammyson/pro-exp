<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignGameRule extends Model
{
    use HasFactory, UuidTrait;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
   
    protected $fillable = [
        'campaign_id',
        'has_leaderboard',
        'import_opentdb_questions',
        'duration_per_game_play',
        'has_ad_breaker',
        'is_subscription_based',
        'referral_points',
        'has_referral',
        'num_free_game_plays',
        'has_free_game_play',
        'is_data_collection',
        'maximum_win',
        'maximum_game_play',
        'cut_off_mark',
        'leaderboard_num_winners'

    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
