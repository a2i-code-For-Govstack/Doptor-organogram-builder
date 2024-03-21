<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtikolpoManagement extends Model
{
    use HasFactory;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $table = 'protikolpo_settings';

    protected $fillable = ['office_id','unit_id','designation_id','employee_record_id','employee_name','protikolpos','selected_protikolpo','start_date', 'end_date','is_show_acting','acting_level','active_status','created_by','modified_by'];

    public static function getProtikolpo($id)
    {
        $protikolpos = ProtikolpoManagement::select('protikolpos')->where('designation_id', $id)->first();
        if ($protikolpos) {
            return $protikolpos['protikolpos'];
        } else {
            return $protikolpos['protikolpos'] = null;
        }

    }
}
