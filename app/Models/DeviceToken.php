<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    protected $table = 'device_tokens';

    protected $fillable = [
        'user_id',
        'device_token',
    ];

    // relation with User Model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
