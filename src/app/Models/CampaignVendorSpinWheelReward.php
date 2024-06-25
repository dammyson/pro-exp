<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;

class CampaignVendorSpinWheelReward extends Model
{
    use HasFactory, UuidTrait;

    protected $table = "campaign_vendor_spinwheel_reward";

    protected $fillable = ['vendor_id', 'audience_id', 'type', 'value', 'status', 'is_redeem'];

}
