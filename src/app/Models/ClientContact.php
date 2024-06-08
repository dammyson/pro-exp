<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\UuidTrait;

class ClientContact extends Model
{
    use HasFactory, UuidTrait;
    // protected $keyType = 'string';
    
    // public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'is_primary',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'id' => 'integer',
    //     'client_id' => 'integer',
    //     'is_primary' => 'boolean',
    // ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
