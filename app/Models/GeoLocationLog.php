<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeoLocationLog extends Model
{
    protected $table = 'geo_location_logs';
    protected $fillable = [
        'geo_id',
        'geo_table_name',
        'geo_model_name',
        'content_change',
        'modified_by_id',
        'modifier_details',
        'request_details',
        'created_at',
        'updated_at',
    ];
}
