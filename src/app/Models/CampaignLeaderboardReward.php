<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;


class CampaignLeaderboardReward extends Model
{
    use HasFactory, UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'campaign_id', 'type', 'player_position', 'reward', 'description', 'frequency',
        'specific_days', 'icon_url', 'cash_reward_to_wallet', 'cash_reward_to_bank',
        'voucher_redemption_mode', 'voucher_redemption_url', 'voucher_redemption_expiry',
        'top_players_revenue_share_percent', 'top_players_start', 'top_players_end'
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function campaignLeaderboardRewardRedemption()
    {
        return $this->hasMany(CampaignLeaderboardRewardRedemption::class);
    }
}
