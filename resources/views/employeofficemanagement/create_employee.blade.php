@extends('master')
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border"
        id="kt_content">
        <!--begin::Subheader-->
        <div class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"
            id="kt_subheader">

            <div class="ml-3"></div>
            <div>
                <h3 class="text-white my-1">Add Employee</h3>
            </div>
            <div class="mr-3 d-flex"></div>
        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h4 class="kt-portlet__head-title">
                            Add Employee Records
                        </h4>
                    </div>
                </div>

                <!--begin::Form-->
                <form id="add_employee"
                    onsubmit="submitData(this, '{{ url('store_employee_by_office_admin') }}'); return false;"
                    class="kt-form kt-form--label-right">
                    @csrf
                    <div class="kt-portlet__body">
                        <div class="form-group row">
                            <input type="hidden" id="id" name="id">
                            <div class="col-lg-6">
                                <label>Birth of Date</label><span class="text-danger">*</span>
                                <input name="date_of_birth" id="date_of_birth" type="text" class="form-control date"
                                    placeholder="Birth of Date" autocomplete="off">
                            </div>
                            <div class="col-lg-6">
                                <label class="">NId Nummber</label><span class="text-danger">*</span>
                                <input name="nid" type="text" class="form-control integer_type_positive"
                                    placeholder="NId Nummber">
                                <span class="text-danger">* National ID number should be 10, 13 or 17 digits.</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-2">
                                <label>First Name SurName (Others) </label>
                                <div class="kt-input-icon">
                                    <input name="prefix_name_bng" id="prefix_name_bng" type="text" class="form-control bangla"
                                        placeholder="First Name SurName (Others)" onkeyup="generate_full_name('#prefix_name_bng', '#name_bng', '#surname_bng', '#full_name_bng')">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label>Name (Others) </label><span class="text-danger">*</span>
                                <div class="kt-input-icon">
                                    <input name="name_bng" id="name_bng" type="text" class="form-control bangla"
                                        placeholder="Name (Others)" onkeyup="generate_full_name('#prefix_name_bng', '#name_bng', '#surname_bng', '#full_name_bng')">
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <label class="">First Name Surname (English)</label>
                                <div class="kt-input-icon">
                                    <input name="prefix_name_eng" id="prefix_name_eng" type="text" class="form-control"
                                        placeholder="First Name Surname (English)" onkeyup="generate_full_name('#prefix_name_eng', '#name_eng', '#surname_eng', '#full_name_eng')">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label class="">Name (English)</label><span class="text-danger">*</span>
                                <div class="kt-input-icon">
                                    <input name="name_eng" id="name_eng" type="text" class="form-control"
                                        placeholder="Name (English)" onkeyup="generate_full_name('#prefix_name_eng', '#name_eng', '#surname_eng', '#full_name_eng')">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>SurName (Others)</label>
                                <div class="kt-input-icon">
                                    <input name="surname_bng" id="surname_bng" type="text" class="form-control bangla"
                                        placeholder="SurName (Others)" onkeyup="generate_full_name('#prefix_name_bng', '#name_bng', '#surname_bng', '#full_name_bng')">
                                </div>
                                <p class="mb-0">Full Name (Others) : <span class="text-success" id="full_name_bng"></span></p>
                            </div>
                            <div class="col-lg-6">
                                <label class="">Surname (English)</label>
                                <div class="kt-input-icon">
                                    <input name="surname_eng" id="surname_eng" type="text" class="form-control"
                                        placeholder="Surname (English)" onkeyup="generate_full_name('#prefix_name_eng', '#name_eng', '#surname_eng', '#full_name_eng')">
                                </div>
                                <p class="mb-0">Full Name (English) : <span class="text-success" id="full_name_eng"></span></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Father's Name (Others) </label>
                                <div class="kt-input-icon">
                                    <input id="father_name_bng" name="father_name_bng" type="text"
                                        class="form-control bangla" placeholder="Father's Name (Others)">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="">Father's Name (English)</label>
                                <div class="kt-input-icon">
                                    <input id="father_name_eng" name="father_name_eng" type="text"
                                        class="form-control english" placeholder="Father's Name (English)">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Mother's Name (Others) </label>
                                <div class="kt-input-icon">
                                    <input id="mother_name_bng" name="mother_name_bng" type="text"
                                        class="form-control bangla" placeholder="Mother's Name (Others)">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="">Mother's Name (English)</label>
                                <div class="kt-input-icon">
                                    <input id="mother_name_eng" name="mother_name_eng" type="text"
                                        class="form-control english" placeholder="Mother's Name (English)">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="gender">Gender</label><span class="text-danger">*</span>
                                <select id="gender" name="gender" class="form-control select-select2">
                                    <option value="" selected="selected">--Choose--</option>
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                    <option value="3">Other</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="religion">Religion</label>
                                <select name="religion" id="religion" class="form-control select-select2">
                                    <option value="" selected="selected">--Choose--</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Christian">Christan</option>
                                    <option value="Buddhist">buddha</option>
                                    <option value="Shik">Shikh</option>
                                    <option value="Others">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="blood_group">Blood Group </label>
                                <select name="blood_group" id="blood_group" class="form-control select-select2">
                                    <option value="" selected="selected">--Choose--</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O−</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A−</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B−</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-"> AB-</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="marital_status"> Marital Status </label>
                                <select id="marital_status" name="marital_status" class="form-control select-select2">
                                    <option value="" selected="selected">--Choose--</option>
                                    <option value="Married">Married</option>
                                    <option value="Single">Single</option>
                                    <option value="Widowed">widow</option>
                                    <option value="Separated">widower</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label>Personal email</label><span class="text-danger">*</span>
                                <div class="kt-input-icon">
                                    <input name="personal_email" id="personal_email" type="text" class="form-control"
                                        placeholder="Personal email">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label>Personal Mobile </label><span class="text-danger">*</span>
                                <div class="kt-input-icon">
                                    <input name="personal_mobile" id="personal_mobile" type="text"
                                        class="form-control integer_type_positive" placeholder="Personal Mobile"
                                        maxlength="11">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label>Date of joining service </label>
                                <input id="joining_date" name="joining_date" type="text" class="form-control date"
                                    placeholder="Date of joining service" value="{{ date('d-m-Y') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Employee type</label>
                                <div class="kt-radio-inline">
                                    <label class="kt-radio kt-radio--solid">
                                        <input id="is_cadre" type="radio" name="is_cadre" value="1">
                                        Cadre
                                        <span></span>
                                    </label>
                                    <label class="kt-radio kt-radio--solid">
                                        <input type="radio" name="is_cadre" value="2"> Non Cadre
                                        <span></span>
                                    </label>
                                    <label class="kt-radio kt-radio--solid">
                                        <input type="radio" name="is_cadre" value="3">People's representatives
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="cadre_info">
                            <div class="form-group row">
                                <div id="employee_cadre_div" class="col-lg-3">
                                    <label for="employee_cadre_id">Cadre Type </label>
                                    <select id="employee_cadre_id" name="employee_cadre_id"
                                        class="form-control select-select2">
                                        <option value="" selected="selected">--Choose--</option>
                                        @foreach ($cadres as $cadre)
                                            <option value="{{ $cadre->id }}">{{ $cadre->cadre_name_bng }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="employee_batch_div" class="col-lg-3">
                                    <label for="employee_batch_id">Batch Number </label>
                                    <select id="employee_batch_id" name="employee_batch_id"
                                        class="form-control select-select2">
                                        <option value="" selected="selected">--Choose--</option>
                                        @foreach ($batches as $batch)
                                            <option value="{{ $batch->id }}">{{ $batch->batch_no }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="employee_grade_div" class="col-lg-3">
                                    <label for="employee_grade">Grade </label><span class="text-danger">*</span>
                                    <select id="employee_grade" name="employee_grade"
                                        class="form-control select-select2">
                                        <option value="" selected="selected">--Choose--</option>
                                        @for ($i = 1; $i <= 20; $i++)
                                            <option value="{{ $i }}">{{ enTobn($i) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div id="identity_no_div" class="col-lg-3">
                                    <label>Identity Number </label>
                                    <input id="identity_no" name="identity_no" type="text" class="form-control integer_type_positive"
                                        placeholder="Identity Number">
                                </div>

                                <div id="appointment_memo_no_div" class="col-lg-6">
                                    <label>Appointment letter Sarok Number </label>
                                    <input id="appointment_memo_no" name="appointment_memo_no" type="text"
                                        class="form-control" placeholder="Appointment letter Sarok Number">
                                </div>


                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label> Officer Management </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <x-office-select unit="true" only_office="true" own_unit="true" grid="3" />
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="designation_id"> Designation </label>
                                    <select name="designation_id" id="designation_id"
                                        class="form-control rounded-0 select-select2">
                                        <option value="">--Choose--</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label>Date of joining the designation </label>
                                {{--                                <span class="text-danger">*</span> --}}
                                <input id="designation_joining_date" name="designation_joining_date" type="text"
                                    class="form-control date" placeholder="Date of joining the designation"
                                    value="{{ date('d-m-Y') }}" autocomplete="off">
                            </div>
                            <div class="col-lg-4">
                                <label for="incharge_label"> Responsibility </label>
                                {{--                                <select id="incharge_label" name="incharge_label" class="js-example-tags form-control"> --}}
                                {{--                                    <option value="" selected="selected">--বাছাই করুন--</option> --}}
                                {{--                                    @foreach ($office_incharges as $incharge) --}}
                                {{--                                        <option value="{{$incharge->name_bng}}">{{$incharge->name_bng}}</option> --}}
                                {{--                                    @endforeach --}}
                                {{--                                </select> --}}

                                <select id="user-options" id="incharge_label" name="incharge_label"
                                    class="form-control">
                                    <option value="" selected="selected">--Choose--</option>
                                    @foreach ($office_incharges as $incharge)
                                        <option value="{{ $incharge->name_bng }}">{{ $incharge->name_bng }}</option>
                                    @endforeach
                                    <option id="other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button class="btn  btn-success btn-square"><i class="fas fa-save mr-2"></i> Save
                                    </button>
                                    <button type="reset" class="btn  btn-danger btn-square reset"><i
                                            class="fas fa-sync  mr-2"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!--end::Form-->
            </div>
        </div>

        <!-- end:: Content -->
    </div>

    <!-- begin::Scrolltop -->
    <div id="kt_scrolltop" class="kt-scrolltop">
        <i class="fa fa-arrow-up"></i>
    </div>

    <script type="text/javascript">
        $('#date_of_birth').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            endDate: '{{ date('d-m-Y', strtotime('-18 years')) }}',
        })


        $(document).ready(function() {
            @if (Auth::user()->user_role_id == config('menu_role_map.user') &&
                Auth::user()->current_organogram_role_id() == config('menu_role_map.office_admin'))
                officeOriginByCurrentOfficeID('{{ Auth::user()->current_office_id() }}');
                loadOfficeTree('{{ Auth::user()->current_office_id() }}');
            @elseif (Auth::user()->current_organogram_role_id() == config('menu_role_map.unit_admin'))
                officeUnitSelected();
            @endif
        });

        $("input[name$='is_cadre']").click(function() {
            var cadre = $(this).val();
            if (cadre == 1) {
                $('#appointment_memo_no').val('');
                $('#employee_cadre_div').show();
                $('#employee_grade_div').show();
                $('#employee_batch_div').show();
                $('#identity_no_div').show();
                $('#appointment_memo_no_div').hide();
            } else if (cadre == 2) {
                $('#employee_cadre_div').hide();
                $('#employee_grade_div').show();
                $('#employee_batch_div').hide();
                $('#identity_no_div').hide();
                $('#appointment_memo_no_div').show();
                $('#appointment_memo_no').val('');
                $('#employee_cadre_id').val('');
                $('#employee_batch_id').val('');
                $('#identity_no').val('');
            } else if (cadre == 3) {
                $('#appointment_memo_no').val('');
                $('#employee_cadre_id').val('');
                $('#employee_batch_id').val('');
                $('#identity_no').val('');
                $('#employee_cadre_div').hide();
                $('#employee_grade_div').hide();
                $('#employee_batch_div').hide();
                $('#appointment_memo_no_div').show();
                $('#identity_no_div').hide();
            }
        });

        function officeUnitSelected() {
            $('#office_unit_id').val('{{ Auth::user()->current_office_unit_id() }}').attr("disabled", "disabled").trigger(
                'change');
        }

        function submitData(form, url) {
            $('#office_id').removeAttr('disabled');
            var data = $(form).serialize();
            $('#office_id').attr('disabled');
            var datatype = 'json';

            ajaxCallAsyncCallback(url, data, datatype, 'POST', function(responseData) {
                if (responseData.status === 'success') {
                    // swal.fire(`নাম: ${responseData.name}`, `আইডি: ${responseData.userid.toString()}`);

                    swal.fire({
                        title: "Name: " + responseData.name,
                        text: "Id: " + responseData.userid.toString(),
                        confirmButtonText: 'Copy',
                        preConfirm: () => {
                            navigator.clipboard.writeText(responseData.userid.toString());
                            toastr.success('Id Copy Successsfully!');
                        }
                    });
                    $('.reset').click();
                    let emptyVal = '';
                    $('#full_name_bng').text(emptyVal);
                    $('#full_name_eng').text(emptyVal);
                } else {

                    if (responseData.statusCode === '422') {
                        var errors = responseData.msg;
                        $.each(errors, function(k, v) {
                            if (v !== '') {
                                toastr.error(v);
                            }
                        });
                    } else {
                        toastr.error(responseData.msg);
                        console.log(responseData)
                    }
                }

                // else {
                //      console.log(responseData);
                //     toastr.error(responseData.msg);
                // }
            });
        }

        $('#nid').on('blur', function() {
            var nid = $(this).val();
            var dob = $('#date_of_birth').val();
            if (nid.length == 10 || nid.length == 17 || nid.length == 13) {

                var url = '{{ url('nid_validation') }}'
                var data = {
                    dob: dob,
                    nid: nid
                };
                var datatype = 'json';

                ajaxCallAsyncCallback(url, data, datatype, 'GET', function(responseData) {
                    if (responseData.status === 'success') {
                        $('#name_bng').val(responseData.msg.name);
                        $('#name_eng').val(responseData.msg.nameEn);
                        $('#mother_name_bng').val(responseData.msg.mother);
                        $('#father_name_bng').val(responseData.msg.father);

                        // toastr.success(responseData.msg);
                    } else {
                        toastr.error('Your ID or date of birth is incorrect!');
                    }
                });
            } else {
                $(this).val('');
                toastr.error('Your ID or date of birth is incorrect');
            }
        });

        $("select#office_unit_id").change(function() {
            var office_unit_id = $(this).children("option:selected").val();
            var office_id = $('#office_id').val();
            loadDesignation(office_id, office_unit_id);
        });

        function loadDesignation(office_id, office_unit_id) {
            var url = 'load_designation_for_assignemployee';
            var data = {
                office_id,
                office_unit_id
            };
            var datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function(responseDate) {
                $("#designation_id").html(responseDate);
                $('#loader').hide();
            });
        }

        $('#prefix_name_bng').on('keyup', function() {
            var prefix_name_bng = $(this).val();
            if (isUnicode(prefix_name_bng) == false) {
                $(this).val('');
                return false
            }
        });

        $('#name_bng').on('keyup', function() {
            var name_bng = $(this).val();
            if (isUnicode(name_bng) == false) {
                $(this).val('');
                return false
            }
        });

        $('#surname_bng').on('keyup', function() {
            var surname_bng = $(this).val();
            if (isUnicode(surname_bng) == false) {
                $(this).val('');
                return false
            }
        });

        $('#prefix_name_eng').on('keyup', function() {
            var prefix_name_eng = $(this).val();
            if (isUnicode(prefix_name_eng) == true) {
                $(this).val('');
                return false
            }
        });

        $('#name_eng').on('keyup', function() {
            var name_eng = $(this).val();
            if (isUnicode(name_eng) == true) {
                $(this).val('');
                return false
            }
        });

        $('#surname_eng').on('keyup', function() {
            var surname_eng = $(this).val();
            if (isUnicode(surname_eng) == true) {
                $(this).val('');
                return false
            }
        });


        $(".js-example-tags").select2({
            tags: true
        });

        $(function() {

            var sel_user_options = $("select#user-options"),
                opts = sel_user_options.find('option');


            sel_user_options.bind('change', function(e) {

                e.preventDefault();

                var optselected = $(this).find("option:selected");

                if (optselected.attr('id') == 'other') {

                    sel_user_options.after(
                        "<div class='additional'><input class='form-control' id=other name='other' placeholder='Typing ...'/></div>"
                        );

                    var oth = $("input#other");

                    oth.keyup(function(e) {
                        optselected.html($(this).val());
                    });

                } else {
                    $('.additional').hide();
                }

            });
        });
    </script>
@endsection
