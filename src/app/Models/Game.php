<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory,  UuidTrait;

    protected $fillable = [
        'name'
    ];

    public function campaignGame()
    {
        return $this->hasMany(CampaignGame::class);
    }
}
