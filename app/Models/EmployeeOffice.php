<?php

namespace App\Models;

use App\Traits\SendNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeOffice extends Model
{
    use SendNotification;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $table = 'employee_offices';
    protected $fillable = ['employee_record_id', 'identification_number', 'office_id', 'office_unit_id', 'office_unit_organogram_id', 'designation', 'designation_level', 'designation_sequence', 'is_default_role', 'office_head', 'is_admin', 'summary_nothi_post_type', 'incharge_label', 'main_role_id', 'joining_date', 'last_office_date', 'status', 'status_change_date', 'show_unit', 'designation_en', 'unit_name_bn', 'protikolpo_status', 'office_name_bn', 'unit_name_en', 'office_name_en', 'released_by', 'created_by', 'modified_by'];

    public function employee_record()
    {
        return $this->belongsTo(EmployeeRecord::class, 'employee_record_id', 'id');
    }

    public function designation_user()
    {
        return $this->hasOne(User::class, 'employee_record_id', 'employee_record_id');
    }

    public function office_unit()
    {
        return $this->belongsTo(OfficeUnit::class, 'office_unit_id', 'id');
    }

    public function office_unit_organogram()
    {
        return $this->belongsTo(OfficeUnitOrganogram::class, 'office_unit_organogram_id', 'id');
    }

    public function office_info()
    {
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }

    public function releaser_info()
    {
        return $this->belongsTo(User::class, 'released_by', 'id');
    }

    public static function unAssignDesignation($employee_office_id, $data = [], $request_from_message = ''): bool
    {
        $entity = EmployeeOffice::find($employee_office_id);

        if ($entity->status == 0) {
            return false;
        }


        $last_office_date = isset($data['last_office_date']) ? date('Y-m-d', strtotime($data['last_office_date'])) : date('Y-m-d');

        $modified_by = $data['modified_by'] ?? \Auth::user()->id;
        $entity->status = 0;
        $entity->released_by = $data['released_by'] ?? \Auth::user()->id;
        $entity->status_change_date = date('Y-m-d H:i:s');
        $entity->last_office_date = $last_office_date;
        $entity->modified_by = $modified_by;
        $real_record_id = $entity->employee_record_id;

        if ($entity->save()) {
            $employee_info = EmployeeRecord::where('id', $real_record_id)->first();;

            if (!empty($employee_info->personal_email)) {
                $message = 'প্রিয় ব্যবহারকারী,<br> আপনাকে নিম্নোক্ত পদবি হতে অব্যাহতি প্রদান করা হয়েছে।<br><b>';
                if (!empty($entity->designation)) {
                    $message .= "পদবিঃ {$entity->designation}";
                }
                if (!empty($entity->unit_name_bn)) {
                    $message .= "<br>শাখাঃ {$entity->unit_name_bn}";
                }
                if (!empty($entity->office_name_bn)) {
                    $message .= "<br>অফিসঃ {$entity->office_name_bn}";
                }
                $message .= "<br>অব্যাহতি প্রদান করেছেনঃ ";
                if (\Auth::check() && \Auth::user()->user_role_id == 3 && \Auth::user()->employee->name_eng) {
                    $message .= "{" . \Auth::user()->employee->name_eng . "} ";
                } else {
                    $message .= "সিস্টেম ";
                }
                if (!empty($request_from_message)) {
                    $message .= " [উৎসঃ {$request_from_message}]";
                }
                $message .= '</b>';

                if (!empty($message)) {
                    (new static)->sendMailNotification('common_notification_template', $employee_info->personal_email, 'কর্মকর্তা অব্যাহতিকরণ বার্তা', ['description' => $message]);
                }
            }

            return true;
        }

        return false;
    }

    public static function assignDesignation($employee_office_data, $options = [], $request_from_message = ''): bool
    {
        $employee_details = EmployeeOffice::where('office_unit_organogram_id', $employee_office_data['office_unit_organogram_id'])->latest()->first();

        if ($employee_details && $employee_details->status == 1) {
            //someone is assigned
            return false;
        }

        $organogram = OfficeUnitOrganogram::where('id', $employee_office_data['office_unit_organogram_id'])->first()->toArray();

        $created_by = $options['created_by'] ?? \Auth::user()->id;

        $entity = new EmployeeOffice();

        $entity->employee_record_id = $employee_office_data['employee_record_id'];
        $entity->identification_number = $employee_office_data['identification_number'];
        $entity->office_id = $employee_office_data['office_id'];
        $entity->office_name_en = $employee_office_data['office_name_en'];
        $entity->office_name_bn = $employee_office_data['office_name_bn'];
        $entity->is_default_role = 0;
        $entity->office_unit_id = $employee_office_data['office_unit_id'];
        $entity->unit_name_en = $employee_office_data['unit_name_en'];
        $entity->unit_name_bn = $employee_office_data['unit_name_bn'];
        $entity->office_unit_organogram_id = $employee_office_data['office_unit_organogram_id'];
        $entity->designation = $organogram['designation_bng'];
        $entity->designation_en = $organogram['designation_eng'];
        $entity->incharge_label = $employee_office_data['incharge_label'];
        $entity->joining_date = date("Y-m-d H:i:s", strtotime($employee_office_data['joining_date']));
        $entity->protikolpo_status = !empty($employee_office_data['protikolpo_status']) ? $employee_office_data['protikolpo_status'] : 0;
        $entity->status = 1;
        $entity->designation_level = $employee_details->designation_level ?? 0;
        $entity->designation_sequence = $employee_details->designation_sequence ?? 0;
        $entity->office_head = $employee_details->office_head ?? 0;
        $entity->summary_nothi_post_type = $employee_details->summary_nothi_post_type ?? 0;
        $entity->status_change_date = date('Y-m-d H:i:s');
        $entity->created_by = $created_by;
        if ($entity->save()) {
            if (!empty($options) && isset($options['exist_employee']) && $options['exist_employee'] == null) {
                $data['is_admin'] = 1;
                $data['is_unit_admin'] = 1;
                OfficeUnitOrganogram::where('id', $employee_office_data['office_unit_organogram_id'])->update($data);
            }

            // time to notify user
            $update_employee_info = EmployeeRecord::find($entity->employee_record_id);
            if (!empty($update_employee_info->personal_email)) {
                $message = 'প্রিয় ব্যবহারকারী,<br> আপনাকে নতুন পদবিতে নিযুক্ত করা হয়েছে।<br><b>';
                if (!empty($entity->designation)) {
                    $message .= "পদবিঃ {$entity->designation}";
                }
                if (!empty($entity->unit_name_bng)) {
                    $message .= "<br>শাখাঃ {$entity->unit_name_bng}";
                }
                if (!empty($entity->office_name_bng)) {
                    $message .= "<br>অফিসঃ {$entity->office_name_bng}";
                }
                $message .= "<br>নিযুক্ত করেছেনঃ ";

                if (\Auth::check() && \Auth::user()->user_role_id == 3 && \Auth::user()->employee->name_eng) {
                    $message .= "{" . \Auth::user()->employee->name_eng . "} ";
                } else {
                    $message .= "সিস্টেম ";
                }

                if (!empty($request_from_message)) {
                    $message .= " [উৎসঃ {$request_from_message}]";
                }
                $message .= '</b>';

                if (!empty($message) && !empty($update_employee_info['personal_email'])) {
                    (new static)->sendMailNotification('common_notification_template', $update_employee_info['personal_email'], 'কর্মকর্তা নিযুক্তকরণ বার্তা', ['description' => $message]);

                }
            }
            return true;
        }

        return false;
    }

    public function user()
    {
        return $this->hasOne(User::class, 'employee_record_id', 'employee_record_id');
    }

    public function employee_record_id()
    {
        return $this->hasOne(EmployeeRecord::class, 'id', 'employee_record_id');
    }

    public function protikolpo()
    {
        return $this->hasOne(ProtikolpoManagement::class, 'designation_id', 'office_unit_organogram_id');
    }

}
