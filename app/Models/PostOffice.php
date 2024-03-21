<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostOffice extends Model
{
    use HasFactory;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $table = 'geo_post_offices';

    protected $fillable = ['geo_division_id','geo_district_id','geo_upazila_id','geo_thana_id','postoffice_name_bng','postoffice_name_eng','bbs_code','division_bbs_code','district_bbs_code','status','id','created_by','modified_by'];

    public function zila()
    {
        return $this->belongsTo(Zila::class,'geo_district_id','id');
    }

    public function bivag()
    {
        return $this->belongsTo(Bivag::class,'geo_division_id','id');
    }
    public function upozila()
    {
        return $this->belongsTo(UpoZila::class,'geo_upazila_id','id');
    }
    public function thana()
    {
        return $this->belongsTo(Thana::class,'geo_thana_id','id');
    }
}
