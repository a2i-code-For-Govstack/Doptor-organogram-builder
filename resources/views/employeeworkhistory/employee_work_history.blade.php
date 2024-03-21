@if ($work_history)
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
                                       value="{{ @$work_history->full_name_bng }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>পরিচিতি নাম্বার</label>
                                <input disabled class="form-control rounded-0" type="text"
                                       value="{{ @$work_history->identity_no }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ইমেইল</label>
                                <input disabled class="form-control rounded-0" type="text"
                                       value="{{ @$work_history->personal_email }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>মোবাইল নম্বর</label>
                                <input disabled class="form-control rounded-0" type="text"
                                       value="{{ @$work_history->personal_mobile }}">
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
                {{-- <div class="card-header dont-print"> --}}
                {{-- <h4 class="mb-0">কর্মকর্তার লগইন আইডি/জাতীয় পরিচয়পত্র দিয়ে কর্মকর্তা অনুসন্ধান</h4> --}}
                {{-- </div> --}}
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
                                    {{-- <th width="10%">কার্যক্রম</th> --}}
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($work_history->all_employee_office as $employee_info)
                                    <tr>
                                        <td>{{ $employee_info->office_name_bn }}</td>
                                        <td>{{ $employee_info->office_name_en }}</td>
                                        <td>{{ $employee_info->unit_name_bn }}</td>
                                        <td>{{ $employee_info->unit_name_en }}</td>
                                        <td>{{ $employee_info->designation }}</td>
                                        <td>{{ $employee_info->joining_date ? enTobn(date('d-m-Y', strtotime($employee_info->joining_date))) : 'তথ্য নাই' }}</td>

                                        <td>{{ $employee_info->last_office_date ? enTobn(date('d-m-Y', strtotime($employee_info->last_office_date))) : 'চলমান' }}</td>
                                        <td>{{ $employee_info->released_by ? ($employee_info->releaser_info->employee ? $employee_info->releaser_info->employee->full_name_bng . '(' . $employee_info->releaser_info->username . ')' : 'সুপার এডমিন') : '' }}
                                        </td>
                                        {{-- <td>
                                            <a data-employee-office-id="{{ $employee_info->id }}"
                                               data-custom-layer-id="{{ !empty($employee_info->office_info) ? $employee_info->office_info->custom_layer_id : ''}}"
                                               data-layer-id="{{ !empty($employee_info->office_info) ? $employee_info->office_info->office_layer_id : ''}}"
                                               data-office-id="{{ $employee_info->office_id }}"
                                               data-unit-id="{{ $employee_info->office_unit_id }}"
                                               data-unit-organogram-id="{{ $employee_info->office_unit_organogram_id }}"
                                               data-joining-date="{{ $employee_info->office_unit_organogram_id }}"
                                               data-last-office-date="{{ $employee_info->office_unit_organogram_id }}"
                                               class="btn  btn-icon  btn-outline-brand edit_work_history">
                                                <i class="fas fa-pencil-alt"></i></a>
                                        </td> --}}
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
@else
    <br>
    <div class="row">
        <div class="col-md-12">
            <h4 class="alert alert-outline-danger">তথ্য পাওয়া যায় নাই।</h4>
        </div>
    </div>
@endif

<!-- begin::Form Quick Panel -->
{{-- <div id="kt_quick_panel" class="kt-quick-panel py-5 px-3">
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
</div> --}}
<!-- end::Form Quick Panel -->

<script type="text/javascript">
    tapp_table_init('tapp_table', 6, 'asc');

    // $("#kt_quick_panel_close_btn").click(function () {
    //     $("#kt_quick_panel").removeAttr('style');
    //     $("#kt_quick_panel").css('opacity', 0);
    //     $("#kt_quick_panel").removeClass('kt-quick-panel--on');
    //     $("html").removeClass("side-panel-overlay");
    // });

    // $('.edit_work_history').click(function () {
    //     url = 'get_work_history_info';
    //     employee_office_id = $(this).attr('data-employee-office-id');
    //     data = {
    //         employee_office_id
    //     }
    //     var datatype = 'html';
    //     ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseData) {

    //         $(".work_history_edit_form").html(responseData);
    //         $(".kt_quick_panel__title").text('কর্ম ইতিহাস সম্পাদনা');
    //         $("#kt_quick_panel").addClass('kt-quick-panel--on');
    //         $("#kt_quick_panel").css('opacity', 1);
    //         $("#kt_quick_panel").css('width', '40%');
    //         $("html").addClass("side-panel-overlay");

    //     });
    // });
</script>
