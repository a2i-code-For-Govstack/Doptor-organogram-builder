<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    public $timestamps = false;
    protected $table = 'n_doptor_notification_settings';
    protected $fillable = ['id', 'event_id', 'employee_id', 'office_id', 'system', 'email', 'sms', 'mobile_app', 'is_notified', 'last_request'];

    public function notification_event(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(NotificationEvent::class, 'event_id', 'id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }
}
