<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str; // Import Str facade

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
        'email',
        'password',
        'dob',
        'phone',
        'village',
        'post',
        'police_station',
        'district',
        'profile_image_path', // <-- Add this
    ];

    /**
     * Define the one-to-many relationship with the Post model.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the user's initials.
     *
     * @return string
     */
    public function getInitialsAttribute(): string
    {
        $nameParts = explode(' ', trim($this->name));
        $firstName = array_shift($nameParts);
        $lastName = array_pop($nameParts);

        $initials = (isset($firstName[0]) ? strtoupper($firstName[0]) : '') .
                    (isset($lastName[0]) ? strtoupper($lastName[0]) : '');

        return $initials ?: strtoupper(substr($this->email, 0, 1)); // Fallback to email initial
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
            'dob' => 'date', // Cast dob to date object
        ];
    }
}