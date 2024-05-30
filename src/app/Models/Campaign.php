<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory,  UuidTrait;

   // protected $with = ['rules', 'subscriptionPlans', 'adBreakers', 'games', 'leaderboardRewards'];

    protected $fillable = ['type', 'title', 'created_by', 'client_id', 'brand_id', 'company_id',
    'start_date', 'end_date', 'status', 'daily_ads_budget', 'total_ads_budget',
    'total_rewards_budget', 'overall_campaign_budget', 'daily_start', 'daily_stop', 'vendor_id'];

    public function games()
    {
        return $this->hasMany(CampaignGame::class);
    }
}
