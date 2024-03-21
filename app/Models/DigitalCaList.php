<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DigitalCaList extends Model
{
    protected $table = 'digital_ca_lists';
    protected $fillable = [
        'name',
        'short_name',
        'logo_url',
        'ca_domain_endpoint',
        'access_token_endpoint',
        'get_certificate_endpoint',
        'sign_digest_endpoint',
        'client_id',
        'client_secret',
        'status',
    ];

    public function user_digital_certificate(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(UserDigitalCertificate::class, 'digital_ca_id', 'id');
    }
}
