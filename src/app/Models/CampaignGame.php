<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignGame extends Model
{
    use HasFactory,  UuidTrait;

    
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'campaign_id', 'game_id'
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
