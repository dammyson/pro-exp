<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Game extends Model
{
    use HasFactory,  UuidTrait;

    // protected $keyType = 'string';
    
    // public $incrementing = false;

    protected $fillable = [
        'name'
    ];

    public function campaignGame()
    {
        return $this->hasMany(CampaignGame::class);
    }

    // public static function boot() {

    //     static::creating(function ($model) {
    //         $model->id = Str::uuid();
    //     });
    // }
}
