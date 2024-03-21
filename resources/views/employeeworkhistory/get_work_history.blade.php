@if ($employee_info)
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card custom-card rounded-0 shadow-sm">
                <div class="card-header dont-print">
                    <h4 class="mb-0">কর্মকর্তার তথ্য</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>নাম</label>
                                <input disabled class="form-control rounded-0" type="text"
                                       value="{{ @$employee_info->full_name_bng }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>পরিচিতি নাম্বার</label>
                                <input disabled class="form-control rounded-0" type="text"
                                       value="{{ @$employee_info->identity_no }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ইমেইল</label>
                                <input disabled class="form-control rounded-0" type="text"
                                       value="{{ @$employee_info->personal_email }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>মোবাইল নম্বর</label>
                                <input disabled class="form-control rounded-0" type="text"
                                       value="{{ @$employee_info->personal_mobile }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card custom-card rounded-0 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table
                                class="tapp_table table table-striped- table-bordered table-hover table-checkable  custom-table-border">
                                <thead class="table-head-color">
                                <tr class="text-center">
                                    <th width="10%">অফিস নাম (বাংলা)</th>
                                    <th width="10%">অফিস নাম (ইংরেজি)</th>
                                    <th width="10%">শাখা(বাংলা)</th>
                                    <th width="10%">শাখা(ইংরেজি)</th>
                                    <th width="10%">পদবি</th>
                                    <th width="10%">শুরু কার্যদিবস</th>
                                    <th width="10%">শেষ কার্যদিবস</th>
                                    <th width="10%">রিলিজ কারী</th>
                                    <th width="10%">কার্যক্রম</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($current_history as $history)
                                    <tr>
                                        <td>{{ $history->office_name_bn }}</td>
                                        <td>{{ $history->office_name_en }}</td>
                                        <td>{{ $history->unit_name_bn }}</td>
                                        <td>{{ $history->unit_name_en }}</td>
                                        <td>{{ $history->designation }}</td>
                                        <td>{{ $history->joining_date ? enTobn(date('d-m-Y', strtotime($history->joining_date))) : 'তথ্য নাই' }}</td>

                                        <td>{{ $history->last_office_date ? enTobn(date('d-m-Y', strtotime($history->last_office_date))) : 'চলমান' }}</td>
                                        <td>{{ $history->released_by ? ($history->releaser_info->employee ? $history->releaser_info->employee->full_name_bng . '(' . $history->releaser_info->username . ')' : 'সুপার এডমিন') : '' }}
                                        </td>
                                        <td>
                                            {{--                                            <a data-employee-office-id="{{ $history->id }}"--}}
                                            {{--                                               data-custom-layer-id="{{ !empty($history->office_info) ? $history->office_info->custom_layer_id : ''}}"--}}
                                            {{--                                               data-layer-id="{{ !empty($history->office_info) ? $history->office_info->office_layer_id : ''}}"--}}
                                            {{--                                               data-office-id="{{ $history->office_id }}"--}}
                                            {{--                                               data-unit-id="{{ $history->office_unit_id }}"--}}
                                            {{--                                               data-unit-organogram-id="{{ $history->office_unit_organogram_id }}"--}}
                                            {{--                                               data-joining-date="{{ $history->office_unit_organogram_id }}"--}}
                                            {{--                                               data-last-office-date="{{ $history->office_unit_organogram_id }}"--}}
                                            {{--                                               class="btn  btn-icon  btn-outline-brand edit_work_history">--}}
                                            {{--                                                <i class="fas fa-pencil-alt"></i></a>--}}
                                        </td>
                                    </tr>
                                @endforeach
                                @foreach ($work_history as $history)
                                    <tr>
                                        <td>{{ $history->office_name_bn }}</td>
                                        <td>{{ $history->office_name_en }}</td>
                                        <td>{{ $history->unit_name_bn }}</td>
                                        <td>{{ $history->unit_name_en }}</td>
                                        <td>{{ $history->designation }}</td>
                                        <td>{{ $history->joining_date ? enTobn(date('d-m-Y', strtotime($history->joining_date))) : 'তথ্য নাই' }}</td>

                                        <td>{{ $history->last_office_date ? enTobn(date('d-m-Y', strtotime($history->last_office_date))) : 'চলমান' }}</td>
                                        <td>{{ $history->released_by ? ($history->releaser_info->employee ? $history->releaser_info->employee->full_name_bng . '(' . $history->releaser_info->username . ')' : 'সুপার এডমিন') : '' }}
                                        </td>
                                        <td>
{{--                                            <a data-employee-office-id="{{ $history->id }}"--}}
{{--                                               data-custom-layer-id="{{ !empty($history->office_info) ? $history->office_info->custom_layer_id : ''}}"--}}
{{--                                               data-layer-id="{{ !empty($history->office_info) ? $history->office_info->office_layer_id : ''}}"--}}
{{--                                               data-office-id="{{ $history->office_id }}"--}}
{{--                                               data-unit-id="{{ $history->office_unit_id }}"--}}
{{--                                               data-unit-organogram-id="{{ $history->office_unit_organogram_id }}"--}}
{{--                                               data-joining-date="{{ $history->office_unit_organogram_id }}"--}}
{{--                                               data-last-office-date="{{ $history->office_unit_organogram_id }}"--}}
{{--                                               class="btn  btn-icon  btn-outline-brand edit_work_history">--}}
{{--                                                <i class="fas fa-pencil-alt"></i></a>--}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="kt_quick_panel" class="kt-quick-panel py-5 px-3">
        <div class="kt_quick_panel__head">
            <h5 class="kt_quick_panel__title mb-0">
                কর্ম ইতিহাস সম্পাদনা </span></a></li>
                <!--<small>5</small>-->
            </h5>
            <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i
                    class="flaticon2-delete"></i></a>
        </div>
        <div class="kt-quick-panel__content">
            <div class="mt-3">
                <div class="work_history_edit_form"></div>
            </div>
        </div>
    </div>

@else
    <br>
    <div class="row">
        <div class="col-md-12">
            <h4 class="alert alert-outline-danger">তথ্য পাওয়া যায় নাই।</h4>
        </div>
    </div>
@endif

<script type="text/javascript">
    tapp_table_init();
    $('.edit_work_history').click(function () {
        url = 'get_work_history_info';
        employee_office_id = $(this).attr('data-employee-office-id');
        data = {
            employee_office_id
        }
        var datatype = 'html';
        ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseData) {

            $(".work_history_edit_form").html(responseData);
            $(".kt_quick_panel__title").text('কর্ম ইতিহাস সম্পাদনা');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("#kt_quick_panel").css('width', '40%');
            $("html").addClass("side-panel-overlay");

        });
    });
</script>
