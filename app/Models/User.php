<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'nickname',
        'email',
        'password',
        'rank_type',
        'department_id',
        'department',
        'joined_at',
        'last_login_at',
    ];

    /**
     * Get the department associated with the user.
     */
    public function departmentRel(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * 표시용 이름 (닉네임이 있으면 닉네임, 없으면 이름)
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->nickname ?? $this->name;
    }

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
            'joined_at' => 'date',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Get the posts written by the user.
     */
    public function posts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the notices written by the user.
     */
    public function notices(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Notice::class);
    }
}
