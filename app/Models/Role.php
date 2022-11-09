<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    public string $role_name;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "role_name",
    ];

    /**
     * @return HasMany
     */
    public function user(): HasMany
    {
        return $this->hasMany(User::class, "role_id");
    }
}
