<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CampaignReferralActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CampaignReferral extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'referrer_id', 'campaign_id', 'code'
    ];
    
    /**
     * referents
     *
     * @return void
     */
    public function referents()
    {
        return $this->hasMany(CampaignReferralActivity::class);
    }
}
