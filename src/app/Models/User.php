<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Company;
use App\Traits\UuidTrait;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable, UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'pin',
        'status',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pin'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

    public function assignRole($roles, string $guard = null)
    {
        $roles = \is_string($roles) ? [$roles] : $roles;
        $guard = $guard ? : $this->getDefaultGuardName();

        $roles = collect($roles)
            ->flatten()
            ->map(function ($role) use ($guard) {
                return $this->getStoredRole($role, $guard);
            })
            ->each(function ($role) {
                $this->ensureModelSharesGuard($role);
            })
            ->all();

        $this->roles()->saveMany($roles);

        $this->forgetCachedPermissions();

        return $this;
    }
    protected function getStoredRole($role, string $guard): Role
    {
        if (\is_string($role)) {
            return app(Role::class)->findByName($role, $guard);
        }else{
            return app(Role::class)->findById($role, $guard);
        }

        return $role;
    }

    public function syncRoles($roles, $guard)
    {
        $this->roles()->detach();

        return $this->assignRole($roles, $guard);
    }
}
