<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignQuestionActivity extends Model
{
    use HasFactory, UuidTrait;
    /**
     * The attributes that are mass assignable
     * @var array
     */
    protected $fillable = [
        'campaign_id', 'audience_id', 'campaign_question_id', 'point',
        'duration', 'game_play_used', 'campaign_game_play_id', 'choice_id'
    ];

    public function question()
    {
        return $this->belongsTo(CampaignQuestion::class, 'campaign_question_id');
    }

}
