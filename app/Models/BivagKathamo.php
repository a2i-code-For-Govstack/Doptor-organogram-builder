<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BivagKathamo extends Model
{
    use HasFactory;

    protected $table='geo_divisions';
    protected $appends = ['name_bng', 'name_eng'];
    public function zila_kathamo()
    {
        return $this->hasMany(ZilaKathamo::class,'geo_division_id','id');
    }

    public function get_all_bivags()
    {
        return BivagKathamo::get();
    }

    public function getNameBngAttribute() {
        return $this->division_name_bng;
    }
    public function getNameEngAttribute() {
        return $this->division_name_eng;
    }
}
