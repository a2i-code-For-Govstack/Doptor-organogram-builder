<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationRegistration extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $table = 'application_registration';

    protected $guarded = [];

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ApiClient::class, 'application_registration_id', 'id');
    }
}
