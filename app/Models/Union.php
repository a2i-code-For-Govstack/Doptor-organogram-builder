<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Union extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $table='geo_unions';

    protected $fillable = ['union_name_bng','union_name_eng','geo_division_id','id','bbs_code','division_bbs_code','district_bbs_code','upazila_bbs_code','geo_district_id','geo_upazila_id','status','created_by','modified_by'];

    public function bivag()
    {
        return $this->belongsTo(Bivag::class,'geo_division_id','id');
    }

    public function zila()
    {
        return $this->belongsTo(Zila::class,'geo_district_id','id');
    }

    public function upozila()
    {
        return $this->belongsTo(UpoZila::class,'geo_upazila_id','id');
    }
}
