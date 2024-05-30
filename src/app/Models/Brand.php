<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\UuidTrait;

class Brand extends Model
{
    use HasFactory, UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'image_url',
        'industry_code',
        'sub_industry_code',
        'slug',
        'created_by',
        'client_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'created_by' => 'integer',
        'client_id' => 'integer',
    ];

    // company staff
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    // created by User // relationship not found in migration file except we are
    // talking of multi-nested relationship
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // a brand can have many campaigns
    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }
}
