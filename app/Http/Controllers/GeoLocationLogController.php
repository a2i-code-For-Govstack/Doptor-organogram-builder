<?php

namespace App\Http\Controllers;

use App\Models\Bivag;
use App\Models\GeoLocationLog;
use App\Models\UpoZila;
use App\Models\Zila;
use Illuminate\Http\Request;

class GeoLocationLogController
{
    public function index(Request $request)
    {
        try {
            \Validator::make($request->all(), [
                'geo_id' => 'required',
                'geo_table_name' => 'required',
            ])->validate();
            $geo_id = $request->geo_id;
            $geo_table_name = $request->geo_table_name;

            $all_geo_location_logs = GeoLocationLog::where('geo_id', $geo_id)
                ->where('geo_table_name', $geo_table_name)
                ->orderBy('id', 'DESC')
                ->paginate();

            $geo_location_logs = [];

            foreach ($all_geo_location_logs as $log) {
                $content = json_decode($log->content_change, true);
                $modifier = json_decode($log->modifier_details, true);
                $geo_location_logs[$log->id]['id'] = $log->id;
                $geo_location_logs[$log->id]['created_at'] = $log->created_at->format('d-m-Y h:i:s A');
                $geo_location_logs[$log->id]['modifier_name'] = isset($modifier['officer_name_bn']) ? $modifier['officer_name_bn'] : $modifier['username'];

                foreach ($content as $item => $value) {
                    if ($item == 'geo_division_id') {
                        $geo_location_logs[$log->id]['content']['geo_division_id'] = [
                            'field' => 'Division',
                            'old' => Bivag::where('id', $value['old'])->select('division_name_bng')->first()->division_name_bng,
                            'new' => Bivag::where('id', $value['new'])->select('division_name_bng')->first()->division_name_bng
                        ];
                    }
                    if ($item == 'geo_district_id') {
                        $geo_location_logs[$log->id]['content']['geo_district_id'] = [
                            'field' => 'Zila',
                            'old' => Zila::where('id', $value['old'])->select('district_name_bng')->first()->district_name_bng,
                            'new' => Zila::where('id', $value['new'])->select('district_name_bng')->first()->district_name_bng
                        ];
                    }

                    if ($item == 'geo_upazila_id') {
                        $geo_location_logs[$log->id]['content']['geo_upazila_id'] = [
                            'field' => 'Upazila',
                            'old' => UpoZila::where('id', $value['old'])->select('upazila_name_bng')->first()->upazila_name_bng,
                            'new' => UpoZila::where('id', $value['new'])->select('upazila_name_bng')->first()->upazila_name_bng
                        ];
                    }

                    if ($item == 'division_name_bng') {
                        $geo_location_logs[$log->id]['content']['division_name_bng'] = [
                            'field' => 'Division Name (Other)',
                            'old' => $value['old'],
                            'new' => $value['new']
                        ];
                    }

                    if ($item == 'division_name_eng') {
                        $geo_location_logs[$log->id]['content']['division_name_eng'] = [
                            'field' => 'Division Name (English)',
                            'old' => $value['old'],
                            'new' => $value['new']
                        ];
                    }

                    if ($item == 'district_name_bng') {
                        $geo_location_logs[$log->id]['content']['district_name_bng'] = [
                            'field' => 'Zila Name (Other)',
                            'old' => $value['old'],
                            'new' => $value['new']
                        ];
                    }

                    if ($item == 'district_name_eng') {
                        $geo_location_logs[$log->id]['content']['district_name_eng'] = [
                            'field' => 'Zila Name (English)',
                            'old' => $value['old'],
                            'new' => $value['new']
                        ];
                    }

                    if ($item == 'upazila_name_bng') {
                        $geo_location_logs[$log->id]['content']['upazila_name_bng'] = [
                            'field' => 'Upazila Name (Other)',
                            'old' => $value['old'],
                            'new' => $value['new']
                        ];
                    }

                    if ($item == 'upazila_name_eng') {
                        $geo_location_logs[$log->id]['content']['upazila_name_eng'] = [
                            'field' => 'Upazila Name (English)',
                            'old' => $value['old'],
                            'new' => $value['new']
                        ];
                    }
                    if ($item == 'union_name_bng') {
                        $geo_location_logs[$log->id]['content']['union_name_bng'] = [
                            'field' => 'Union Name (Other)',
                            'old' => $value['old'],
                            'new' => $value['new']
                        ];
                    }

                    if ($item == 'union_name_eng') {
                        $geo_location_logs[$log->id]['content']['union_name_eng'] = [
                            'field' => 'Union Name (English)',
                            'old' => $value['old'],
                            'new' => $value['new']
                        ];
                    }

                    if ($item == 'thana_name_bng') {
                        $geo_location_logs[$log->id]['content']['thana_name_bng'] = [
                            'field' => 'Thana Name (Other)',
                            'old' => $value['old'],
                            'new' => $value['new']
                        ];
                    }

                    if ($item == 'thana_name_eng') {
                        $geo_location_logs[$log->id]['content']['thana_name_eng'] = [
                            'field' => 'Thana Name (English)',
                            'old' => $value['old'],
                            'new' => $value['new']
                        ];
                    }

                    if ($item == 'postoffice_name_bng') {
                        $geo_location_logs[$log->id]['content']['postoffice_name_bng'] = [
                            'field' => 'PostOffice Name (Other)',
                            'old' => $value['old'],
                            'new' => $value['new']
                        ];
                    }

                    if ($item == 'postoffice_name_eng') {
                        $geo_location_logs[$log->id]['content']['postoffice_name_eng'] = [
                            'field' => 'PostOffice Name (English)',
                            'old' => $value['old'],
                            'new' => $value['new']
                        ];
                    }

                    if ($item == 'ward_name_bng') {
                        $geo_location_logs[$log->id]['content']['ward_name_bng'] = [
                            'field' => 'Ward Name (Bangla)',
                            'old' => $value['old'],
                            'new' => $value['new']
                        ];
                    }

                    if ($item == 'ward_name_eng') {
                        $geo_location_logs[$log->id]['content']['ward_name_eng'] = [
                            'field' => 'Ward Name (English)',
                            'old' => $value['old'],
                            'new' => $value['new']
                        ];
                    }

                    if ($item == 'municipality_name_bng') {
                        $geo_location_logs[$log->id]['content']['municipality_name_bng'] = [
                            'field' => 'Municipality Name (Other)',
                            'old' => $value['old'],
                            'new' => $value['new']
                        ];
                    }

                    if ($item == 'municipality_name_eng') {
                        $geo_location_logs[$log->id]['content']['municipality_name_eng'] = [
                            'field' => 'Municipality Name (English)',
                            'old' => $value['old'],
                            'new' => $value['new']
                        ];
                    }

                    if ($item == 'city_corporation_name_bng') {
                        $geo_location_logs[$log->id]['content']['city_corporation_name_bng'] = [
                            'field' => 'City Corporation Name (Bangla)',
                            'old' => $value['old'],
                            'new' => $value['new']
                        ];
                    }

                    if ($item == 'city_corporation_name_eng') {
                        $geo_location_logs[$log->id]['content']['city_corporation_name_eng'] = [
                            'field' => 'City Corporation Name (English)',
                            'old' => $value['old'],
                            'new' => $value['new']
                        ];
                    }

                    if ($item == 'bbs_code') {
                        $geo_location_logs[$log->id]['content']['bbs_code'] = [
                            'field' => 'BBS Code',
                            'old' => enTobn($value['old']),
                            'new' => enTobn($value['new'])
                        ];
                    }

                    if ($item == 'status') {
                        $geo_location_logs[$log->id]['content']['status'] = [
                            'field' => 'Status',
                            'old' => $value['old'] == 1 ? 'Active' : 'Inctive',
                            'new' => $value['new'] == 1 ? 'Active' : 'Inctive'
                        ];
                    }
                }
            }

            return view('geo_location_log.get_geo_location_log', compact('geo_location_logs'));
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
