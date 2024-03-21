<?php

namespace App\Services;

use App\Models\GeoLocationLog;
use App\Models\Office;
use App\Models\OfficeUnit;
use App\Models\OfficeUnitOrganogram;
use Illuminate\Support\Facades\Auth;

class GeoLocationLogServices
{
    public function saveGeloLocationLog($old, $new, $options)
    {
        $changes = array();
        foreach ($new->getChanges() as $key => $value) {
            $original = $old[$key];
            $changes[$key] = [
                'old' => $original,
                'new' => $value,
            ];
        }

        if (count($changes) > 0) {
            $change_data['geo_id'] = $new->id;
            $change_data['geo_table_name'] = $options['geo_table_name'];
            $change_data['geo_model_name'] = $options['geo_model_name'];
            $change_data['modified_by_id'] = Auth::user()->id;
            $change_data['content_change'] = json_encode($changes);
            $details = [
                'username' => auth()->user()->username,
            ];

            if (auth()->user()->employee) {
                $details['officer_name_en'] = auth()->user()->employee->full_name_eng;
                $details['officer_name_bn'] = auth()->user()->employee->full_name_eng;
                $office = Office::find(auth()->user()->current_office_id());
                $office_unit = OfficeUnit::find(auth()->user()->current_office_unit_id());
                $designation = OfficeUnitOrganogram::find(auth()->user()->current_designation_id());
                $details['officer']['office_id'] = $office->id;
                $details['officer']['office_name_en'] = $office->office_name_en;
                $details['officer']['office_name_bn'] = $office->office_name_bn;
                $details['officer']['unit_id'] = $office_unit->id;
                $details['officer']['unit_name_en'] = $office_unit->unit_name_en;
                $details['officer']['unit_name_bn'] = $office_unit->unit_name_bn;
                $details['officer']['designation_id'] = $designation->id;
                $details['officer']['designation_name_en'] = $designation->designation_name_en;
                $details['officer']['designation_name_bn'] = $designation->designation_name_bn;
            }

            $change_data['modifier_details'] = json_encode($details);

            $browser_info = getBrowser();
            $loginip = getIP();
            $change_data['request_details'] = json_encode([
                'ip' => $loginip,
                'browser' => $browser_info['name'] . ' ' . $browser_info['version'],
                'platform' => $browser_info['platform'],
                'loginip' => $loginip,
            ]);

            GeoLocationLog::create($change_data);
        }
    }
}
