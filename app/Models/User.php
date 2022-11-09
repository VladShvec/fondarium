<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    /**
     * @var int
     * @var string
     * @var string
     */
    public int $role_id;
    public string $name;
    public string $password;

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


}
