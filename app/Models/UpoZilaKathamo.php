<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpoZilaKathamo extends Model
{
    use HasFactory;

    protected $table='geo_upazilas';
    protected $appends = ['name_bng', 'name_eng'];

    public static function get_upozila_zila_wise($id)
    {

        return UpoZilaKathamo::where('geo_district_id',$id)->get();
    }

    public function union_kathamo()
    {
        return $this->hasMany(UnionKathamo::class,'geo_upazila_id','id');
    }
    public function post_office_kathamo()
    {
        return $this->hasMany(PostOfficeKathamo::class,'geo_upazila_id','id');
    }
    public function pouroshova_kathamo()
    {
        return $this->hasMany(PouroshovaKathamo::class,'geo_upazila_id','id');
    }

    public function getNameBngAttribute() {
        return $this->upazila_name_bng;
    }
    public function getNameEngAttribute() {
        return $this->upazila_name_eng;
    }
}
