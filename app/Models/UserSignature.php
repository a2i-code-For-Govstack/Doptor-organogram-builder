<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSignature extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $fillable = [
        'username',
        'signature_file',
        'encode_sign',
        'previous_signature',
        'created_by',
        'modified_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }
}
