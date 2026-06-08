<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
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
        'role',
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

    /**
     * Relationship: Analysis Histories
     */
    public function analysisHistories()
    {
        return $this->hasMany(RiwayatAnalisis::class, 'user_id');
    }

    /**
     * Relationship: Quiz Histories
     */
    public function quizHistories()
    {
        return $this->hasMany(RiwayatKuis::class, 'user_id');
    }

    /**
     * Relationship: User Progress
     */
    public function userProgress()
    {
        return $this->hasMany(ProgresPengguna::class, 'user_id');
    }

    /**
     * Relationship: Achievements
     */
    public function pencapaian()
    {
        return $this->belongsToMany(Pencapaian::class, 'pencapaian_user', 'user_id', 'pencapaian_id')
            ->withPivot('terbuka_pada')
            ->withTimestamps();
    }

    /**
     * Scope: Admin users
     */
    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope: Santri users
     */
    public function scopeSantri($query)
    {
        return $query->where('role', 'santri');
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Send password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
