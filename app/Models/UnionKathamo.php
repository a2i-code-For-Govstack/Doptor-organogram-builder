<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnionKathamo extends Model
{
    use HasFactory;

    protected $table= 'geo_unions';
    protected $appends = ['name_bng', 'name_eng'];

    public function thana_kathamo()
    {
        return $this->belongsTo(ThanaKathamo::class);
    }



    public static function get_union_upozila_wise($id)
    {
        return UnionKathamo::where('geo_upazila_id',$id)->get();
    }

    public function getNameBngAttribute() {
        return $this->union_name_bng;
    }
    public function getNameEngAttribute() {
        return $this->union_name_eng;
    }
}
