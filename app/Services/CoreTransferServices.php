<?php

namespace App\Services;

use App\Models\EmployeeOffice;
use App\Models\EmployeeRecord;
use App\Models\Office;
use App\Models\OfficeOriginUnitOrganogram;
use App\Models\OfficeUnit;
use App\Models\OfficeUnitOrganogram;
use App\Models\ProtikolpoManagement;

class CoreTransferServices
{
    public function transferDesignations($designation_ids, $office_unit_id, $office_id): array
    {
        try {
            $office = Office::find($office_id);
            $nominated_office_unit = OfficeUnit::find($office_unit_id);
            $selected_designations = OfficeUnitOrganogram::whereIn('id', $designation_ids)->get();
            \DB::beginTransaction();
            foreach ($selected_designations as $key => $selected_designation) {
                if ($selected_designation->office_unit_id == $office_unit_id) {
                    //cannot move to same unit
                    continue;
                }
                $create_origin_unit_organogram = $this->createOriginOrganogram($selected_designation, $nominated_office_unit, $office);
                if (!$create_origin_unit_organogram) {
                    throw new \Exception('দুঃখিত! অফিস কাঠামো ট্রান্সফার সম্পন্ন করা সম্ভব হচ্ছে না');
                }
            }
            \DB::commit();
            return ['status' => 'success', 'msg' => 'Success'];
        } catch (\Exception $exception) {
            \DB::rollBack();
            return ['status' => 'error', 'msg' => $exception->getMessage()];
        }
    }

    private function createOriginOrganogram($selected_designation, $nominated_office_unit, $office): bool
    {

        $new_origin_designation = OfficeOriginUnitOrganogram::where('office_origin_unit_id', $nominated_office_unit->office_origin_unit_id)->where('designation_bng', $selected_designation->designation_bng)->latest()->first();
        if (empty($new_origin_designation)) {
            $new_origin_designation = new OfficeOriginUnitOrganogram();
            $new_origin_designation->office_origin_unit_id = $nominated_office_unit->office_origin_unit_id;
            $new_origin_designation->superior_unit_id = 0;
            $new_origin_designation->superior_designation_id = 0;
            $new_origin_designation->designation_bng = $selected_designation->designation_bng;
            $new_origin_designation->short_name_bng = $selected_designation->designation_bng;
            $new_origin_designation->designation_eng = $selected_designation->designation_eng;
            $new_origin_designation->short_name_eng = $selected_designation->designation_eng;
            $new_origin_designation->designation_level = !empty($selected_designation->designation_level) ? $selected_designation->designation_level : 0;
            $new_origin_designation->designation_sequence = !empty($selected_designation->designation_sequence) ? $selected_designation->designation_sequence : 0;
            $new_origin_designation->status = 1;
            $new_origin_designation->created_by = \Auth::user()->id;
            $new_origin_designation->modified_by = \Auth::user()->id;
            $new_origin_designation->created = date("Y-m-d H:i:s");
            $new_origin_designation->modified = date("Y-m-d H:i:s");
            $new_origin_designation->save();
        } else {
            OfficeOriginUnitOrganogram::where('id', $new_origin_designation->id)->update(['status' => 1]);
            $new_origin_designation->status = 1;
        }

        return $this->createOrganogram($new_origin_designation, $selected_designation, $nominated_office_unit, $office);

    }

    private function createOrganogram($originDesignations, $selected_designation, $nominated_unit, $office): bool
    {

        $new_designation = new OfficeUnitOrganogram();
        $new_designation->office_id = $office->id;
        $new_designation->office_unit_id = $nominated_unit->id;
        $new_designation->ref_origin_unit_org_id = $originDesignations->id;
        $new_designation->superior_unit_id = $nominated_unit->parent_unit_id;
        $new_designation->superior_designation_id = 0;
        $new_designation->ref_sup_origin_unit_id = 0;
        $new_designation->ref_sup_origin_unit_desig_id = 0;
        $new_designation->designation_bng = $originDesignations->designation_bng;
        $new_designation->short_name_bng = $originDesignations->designation_bng;
        $new_designation->designation_eng = $originDesignations->designation_eng;
        $new_designation->short_name_eng = $originDesignations->designation_eng;
        $new_designation->designation_sequence = $originDesignations->designation_sequence;
        $new_designation->designation_level = $originDesignations->designation_level;
        $new_designation->status = 1;
        $new_designation->is_admin = $selected_designation->is_admin;
        $new_designation->created_by = \Auth::user()->id;
        $new_designation->modified_by = \Auth::user()->id;
        $new_designation->created = date("Y-m-d H:i:s");
        $new_designation->modified = date("Y-m-d H:i:s");

        $new_designation->save();

        OfficeUnitOrganogram::where('id', $selected_designation->id)->update(['status' => 0]);
        return $this->assignEmployeeToNewDesignation($new_designation, $selected_designation, $nominated_unit, $office);
    }

    private function assignEmployeeToNewDesignation($new_designation, $selected_designation, $nominated_unit, $office): bool
    {
        $employee_office = EmployeeOffice::where('status', 1)->where('office_unit_organogram_id', $selected_designation->id)->first();

        if ($employee_office) {
            $employee_office->office_id = $new_designation->office_id;
            $employee_office->office_unit_id = $new_designation->office_unit_id;
            $employee_office->office_unit_organogram_id = $new_designation->id;
            $employee_office->joining_date = date("Y-m-d H:i:s");
            EmployeeOffice::unAssignDesignation($employee_office->id, [], 'পদবি স্থানান্তর');
            $employee_office = $employee_office->toArray();
            EmployeeOffice::assignDesignation($employee_office, [], 'পদবি স্থানান্তর');
        }
        $this->moveProtikolpos($selected_designation, $new_designation);
        return true;
    }

    private function moveProtikolpos($old_organogram, $new_organogram): bool //moveProtikolposNew
    {
        ProtikolpoManagement::where('designation_id', $old_organogram->id)->where('office_id', $old_organogram->office_id)
            ->update(
                ['designation_id' => $new_organogram->id, 'unit_id' => $new_organogram->office_unit_id, 'office_id' => $new_organogram->office_id]
            );

        $allProtikolpos = ProtikolpoManagement::where('office_id', $old_organogram->office_id)->get();

        if (!empty($allProtikolpos)) {
            foreach ($allProtikolpos as $key => $value) {
                $protikolpos = json_decode($value['protikolpos'], true);

                if (isset($protikolpos['protikolpo_1']['designation_id']) && $protikolpos['protikolpo_1']['designation_id'] == $old_organogram->id) {
                    $protikolpos['protikolpo_1']['office_unit_id'] = $new_organogram->office_unit_id;
                    $protikolpos['protikolpo_1']['designation_id'] = $new_organogram->id;
                }
                if (isset($protikolpos['protikolpo_2']['designation_id']) && $protikolpos['protikolpo_2']['designation_id'] == $old_organogram->id) {
                    $protikolpos['protikolpo_2']['office_unit_id'] = $new_organogram->office_unit_id;
                    $protikolpos['protikolpo_2']['designation_id'] = $new_organogram->id;
                }
                ProtikolpoManagement::where('id', $value['id'])->update(['protikolpos' => json_encode($protikolpos)]);
            }
        }
        return true;
    }
}
