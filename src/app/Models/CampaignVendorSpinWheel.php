<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;

class CampaignVendorSpinWheel extends Model
{
    use HasFactory, UuidTrait;

    protected $table = "campaign_vendor_spinwheel";

    protected $fillable = ['name', 'email', 'phone', 'status'];
}
