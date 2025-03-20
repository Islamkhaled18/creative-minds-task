<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
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
        'username',
        'mobile_number',
        'is_verified',
        'verification_code',
        'verification_code_expires_at',
        'latitude',
        'longitude',
        'location_name',
        'profile_image',
        'thumbnail',
        'user_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_code',
        'verification_code_expires_at',
    ];

    protected $casts = [
        'password'                     => 'hashed',
        'is_verified'                  => 'boolean',
        'verification_code_expires_at' => 'datetime',
        'latitude'                     => 'float',
        'longitude'                    => 'float',
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
            'password'          => 'hashed',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function scopeDeliveryReps($query)
    {
        return $query->where('user_type', 'delivery');
    }

    // relation with DeviceToken Model
    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class);
    }
}
