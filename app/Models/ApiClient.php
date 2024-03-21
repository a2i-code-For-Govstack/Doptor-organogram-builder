<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiClient extends Model
{
    use HasFactory;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $fillable = [
        'name',
        'application_registration_id',
        'client_id',
        'password',
    ];

    public function application()
    {
        return $this->hasOne(ApplicationRegistration::class, 'id', 'application_registration_id');
    }
}
