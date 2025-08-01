<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Tasks;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 * schema="User",
 * required={"id", "name", "email"},
 * @OA\Property(property="id", type="integer", readOnly=true, example=1),
 * @OA\Property(property="name", type="string", example="John Doe"),
 * @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
 * @OA\Property(property="email_verified_at", type="string", format="date-time", readOnly=true, nullable=true),
 * @OA\Property(property="created_at", type="string", format="date-time", readOnly=true)
 * )
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // Eloquent Relationship for Priorities Has Many Tasks
    public function tasks(): HasMany
    {
        return $this->hasMany(Tasks::class);
    }

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
