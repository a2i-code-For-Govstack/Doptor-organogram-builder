@if($employee_info)
    <div class="col-md-3">
        <div class="kt-grid__item kt-app__toggle kt-app__aside shadow-sm bg-white">
            <div class="kt-portlet kt-portlet--height-fluid-  pt-5">
                <div class="kt-portlet__body kt-portlet__body--fit-y">
                    <div class="kt-widget kt-widget--user-profile-1 pb-5">
                        <div class="kt-widget__head">
                            <div class="kt-widget__media">
                                <img src="{{ $userProfileImage ? $userProfileImage : asset('images/no.png') }}" alt="image">
                            </div>
                            <div class="kt-widget__content">
                                <div class="kt-widget__section">
                                    <input type="hidden" id="emp_id" value="{{$employee_info->id}}">
                                    <input type="hidden" id="userName" value="{{$employee_info->user->username}}">
                                    <a href="#" class="kt-widget__username">
                                        {{$employee_info->full_name_bng}}
                                        <i class="flaticon2-correct kt-font-success"></i>
                                    </a>
                                    @foreach($employee_info->employee_office as $employee_office_info)
                                        <span class="kt-widget__subtitle">
                                    {{$employee_office_info->designation}}
                                </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="kt-widget__body">
                            <div class="kt-widget__content">
                                <div class="kt-widget__info">
                                    <span class="kt-widget__label">ইমেল:</span>
                                    <a href="#" class="kt-widget__data">{{$employee_info->personal_email}}</a>
                                </div>
                                <div class="kt-widget__info">
                                    <span class="kt-widget__label">ফোন:</span>
                                    <a href="#" class="kt-widget__data">{{$employee_info->personal_mobile}}</a>
                                </div>
                                <div class="kt-widget__info">
                                    <span class="kt-widget__label">ইউজার আইডি:</span>
                                    <a href="#" class="kt-widget__data">{{@$employee_info->user->username}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card custom-card round-0 shadow-sm">
            <div class="card-header">
                <h4>বর্তমান পদবি</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered custom-table-border">
                        <thead class="table-head-color">
                        <tr>
                            <th>অফিস</th>
                            <th>শাখা</th>
                            <th>পদবি</th>
                            @if (!$tracking)
                                <th>শেষ কার্যদিবস</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($employee_info->employee_office as $employee_office_info)
                            <tr>
                                <td>{{$employee_office_info->office_name_bn}}</td>
                                <td>{{ $employee_office_info->office_unit ? $employee_office_info->office_unit->unit_name_bng : ''}}</td>
                                <td>
                                    @if (!empty($employee_office_info->incharge_label))
                                    {{$employee_office_info->designation .' ('.$employee_office_info->incharge_label.')'}}
                                    @else
                                    {{$employee_office_info->designation}}
                                    @endif
                                </td>
                                @if (!$tracking)
                                    <td>
                                        @if(Auth::user()->user_role_id == config('menu_role_map.super_admin'))
                                            <div class="input-group">
                                                <input class="form-control rounded-0 date" type="text"
                                                       name="last_office_date"
                                                       placeholder="দিন-মাস-বছর" aria-label="Recipient's"
                                                       id="last_office_date_{{$employee_office_info->id}}" autocomplete="off">
                                                <div class="input-group-append rounded-0">
                                                    <button id="disable_designation"
                                                            data-employee_record_id="{{$employee_info->id}}"
                                                            data-office_id="{{$employee_office_info->id}}" type="button"
                                                            class="btn btn-danger btn-outline-brand btn-icon disable_designation">
                                                        <i
                                                            class="fas fa-trash-alt"></i></button>

                                                </div>
                                            </div>
                                        @else
                                            @if(Auth::user()->current_office_id() == $employee_office_info->office_id)
                                                <div class="input-group">
                                                    <input class="form-control rounded-0 date" type="text"
                                                           name="last_office_date"
                                                           placeholder="দিন-মাস-বছর" aria-label="Recipient's"
                                                           id="last_office_date_{{$employee_office_info->id}}">
                                                    <div class="input-group-append rounded-0">
                                                        <button id="disable_designation"
                                                                data-employee_record_id="{{$employee_info->id}}"
                                                                data-office_id="{{$employee_office_info->id}}"
                                                                data-org_id="{{$employee_office_info->office_unit_organogram_id}}"
                                                                type="button"
                                                                class="btn  btn-outline-danger btn-icon disable_designation">
                                                            <i
                                                                class="fas fa-trash-alt" style="color: red"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="col-md-12">
        <div class="card custom-card round-0 shadow-sm">

            <div class="card-body">
                <h2>কোন তথ্য পাওয়া যায়নি</h2>
            </div>
        </div>
    </div>

@endif
<script>
    $('.date').datepicker(
        {
            autoclose: true,
            format: 'dd-mm-yyyy',
            endDate: '{{date('d-m-Y')}}',
        }
    );
</script>
