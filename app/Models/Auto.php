<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    use HasFactory;

    /**
     * @var int
     * @var int
     * @var string
     * @var string
     */
    public int $user_id;
    public int $auto_mark;
    public string $auto_number;
    public string $auto_color;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string, string, string, int>
     */
    protected $fillable = [
        "auto_mark",
        "auto_number",
        "auto_color",
        "user_id"
    ];

    /**
     * Get the user number associated with the auto.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
