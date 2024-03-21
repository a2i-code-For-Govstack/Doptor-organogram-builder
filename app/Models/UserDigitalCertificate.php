<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDigitalCertificate extends Model
{
    protected $table = 'user_digital_certificates';
    protected $fillable = [
        'user_id',
        'employee_record_id',
        'signer_id',
        'digital_ca_id',
        'certificate',
        'base64_certificate',
        'cert_type',
        'issue_date',
        'expiry_date',
        'status',
    ];

    public function digital_ca(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DigitalCaList::class, 'digital_ca_id', 'id');
    }
}
