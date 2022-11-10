<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    /**
     * @var int
     * @var string
     */
    public int $role_id;
    public string $name;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string, string>
     */
    protected $fillable = [
        "role_id",
        "name",
        "password",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        "password",
    ];

    /**
     * Get the auto associated with the user.
     *
     * @return HasOne
     */
    public function auto(): HasOne
    {
        return $this->hasOne(Auto::class);
    }

    /**
     * @return mixed
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
