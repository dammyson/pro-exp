<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignQuestion extends Model
{
    use HasFactory, UuidTrait;
    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = ['campaign_id', 'question_id', 'is_data_collection'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);

    }

    public function questionActivities() 
    {
        return $this->hasMany(CampaignQuestionActivity::class);
    }
}
