<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostOfficeKathamo extends Model
{
    use HasFactory;

    protected $table='geo_post_offices';
    protected $appends = ['name_bng', 'name_eng'];
    public static function get_post_office_upozila_wise($id)
    {
        return UnionKathamo::where('geo_upazila_id',$id)->get();
    }

    public function getNameBngAttribute() {
        return $this->postoffice_name_bng;
    }
    public function getNameEngAttribute() {
        return $this->postoffice_name_eng;
    }
}
