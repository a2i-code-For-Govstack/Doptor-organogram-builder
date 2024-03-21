<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivationSMS extends Model
{
    use HasFactory;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $table = 'user_activation_sms';
    protected $fillable = [
        'username',
        'user_id',
        'activation_code',
        'is_activated',
        'expiry',
        'created_by',
        'modified_by',
    ];

}
