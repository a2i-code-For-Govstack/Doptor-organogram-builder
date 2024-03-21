<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationEvent extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $table = 'n_doptor_notification_events';
    protected $fillable = ['id', 'event_name_bng', 'event_name_eng', 'notification_type', 'template_id'];

    public function available_notification_setting($employee_id)
    {
        return $this->notification_settings()->where('employee_id', '=', $employee_id)->first();
    }

    public function notification_settings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(NotificationSetting::class, 'event_id');
    }

}
