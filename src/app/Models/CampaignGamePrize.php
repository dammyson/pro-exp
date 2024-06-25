<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;

class CampaignGamePrize extends Model
{
    use HasFactory;
    //use UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected  $table = "campaign_game_prizes";
    protected $fillable = [
        'name', 'amount'
    ];
}
