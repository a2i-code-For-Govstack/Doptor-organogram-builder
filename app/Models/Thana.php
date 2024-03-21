<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thana extends Model
{
    use HasFactory;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $table = 'geo_thanas';

    protected $fillable= ['geo_division_id','geo_district_id','thana_name_bng','thana_name_eng','bbs_code','division_bbs_code','district_bbs_code','status','id','created_by','modified_by'];

    public function zila()
    {
        return $this->belongsTo(Zila::class,'geo_district_id','id');
    }

    public function bivag()
    {
        return $this->belongsTo(Bivag::class,'geo_division_id','id');
    }

}
