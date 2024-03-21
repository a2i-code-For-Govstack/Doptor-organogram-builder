@extends('master')
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border"
         id="kt_content">
        <!--begin::Subheader-->
        <div
            class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"
            id="kt_subheader">

            <div class="ml-3"></div>
            <div>
                <h3 class="text-white my-1">কর্মচারী যোগ</h3>
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
                            কর্মচারী রেকর্ড যোগ করুন
                        </h4>
                    </div>
                </div>

                <!--begin::Form-->
                <form id="add_employee"
                      onsubmit="submitData(this, '{{url('store_employee_by_office_admin')}}'); return false;"
                      class="kt-form kt-form--label-right">
                    @csrf
                    <div class="kt-portlet__body">
                        <div class="form-group row">
                            <input type="hidden" id="id" name="id">
                            <div class="col-lg-6">
                                <label>জন্ম তারিখ</label><span class="text-danger">*</span>
                                <input name="date_of_birth" id="date_of_birth" type="text" class="form-control date"
                                       placeholder="জন্ম তারিখ">
                            </div>
                            <div class="col-lg-6">
                                <label class="">জাতীয় পরিচয়পত্র নম্বর</label><span class="text-danger">*</span>
                                <input name="nid" type="text" class="form-control integer_type_positive"
                                       placeholder="জাতীয় পরিচয়পত্র নম্বর">
                                <span
                                    class="text-danger">* জাতীয় পরিচয়পত্র নম্বর ১০ , ১৩ অথবা ১৭ সংখ্যার হতে হবে।</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-2">
                                <label>নামের শুরুর উপাধি (বাংলা) </label>
                                <div class="kt-input-icon">
                                    <input name="prefix_name_bng" id="prefix_name_bng" type="text" class="form-control"
                                           placeholder="নামের শুরুর উপাধি (বাংলা)" onkeyup="generate_full_name('#prefix_name_bng', '#name_bng', '#surname_bng', '#full_name_bng')">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label>নাম (বাংলা) </label><span class="text-danger">*</span>
                                <div class="kt-input-icon">
                                    <input name="name_bng" id="name_bng" type="text" class="form-control"
                                           placeholder="নাম (বাংলা)" onkeyup="generate_full_name('#prefix_name_bng', '#name_bng', '#surname_bng', '#full_name_bng')">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <label>নামের শুরুর উপাধি (ইংরেজি)</label>
                                <div class="kt-input-icon">
                                    <input name="prefix_name_eng" id="prefix_name_eng" type="text" class="form-control"
                                           placeholder="নামের শুরুর উপাধি (ইংরেজি)" onkeyup="generate_full_name('#prefix_name_eng', '#name_eng', '#surname_eng', '#full_name_eng')">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label class="">নাম (ইংরেজি)</label><span class="text-danger">*</span>
                                <div class="kt-input-icon">
                                    <input name="name_eng" id="name_eng" type="text" class="form-control"
                                           placeholder="নাম (ইংরেজি)" onkeyup="generate_full_name('#prefix_name_eng', '#name_eng', '#surname_eng', '#full_name_eng')">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>নামের শেষের উপাধি (বাংলা) </label>
                                <div class="kt-input-icon">
                                    <input name="surname_bng" id="surname_bng" type="text" class="form-control"
                                           placeholder="নামের শেষের উপাধি (বাংলা)" onkeyup="generate_full_name('#prefix_name_bng', '#name_bng', '#surname_bng', '#full_name_bng')">
                                </div>
                                <p class="mb-0">সম্পূর্ণ নাম (বাংলা): <span class="text-success" id="full_name_bng"></span></p>
                            </div>
                            <div class="col-lg-6">
                                <label>নামের শেষের উপাধি (ইংরেজি)</label>
                                <div class="kt-input-icon">
                                    <input name="surname_eng" id="surname_eng" type="text" class="form-control"
                                           placeholder="নামের শেষের (ইংরেজি)" onkeyup="generate_full_name('#prefix_name_eng', '#name_eng', '#surname_eng', '#full_name_eng')">
                                </div>
                                <p class="mb-0">সম্পূর্ণ নাম (ইংরেজি): <span class="text-success" id="full_name_eng"></span></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>পিতার নাম (বাংলা) </label>
                                <div class="kt-input-icon">
                                    <input id="father_name_bng" name="father_name_bng" type="text" class="form-control"
                                           placeholder="পিতার নাম (বাংলা)">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="">পিতার নাম (ইংরেজি)</label>
                                <div class="kt-input-icon">
                                    <input id="father_name_eng" name="father_name_eng" type="text" class="form-control"
                                           placeholder="পিতার নাম (ইংরেজি)">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>মাতার নাম (বাংলা) </label>
                                <div class="kt-input-icon">
                                    <input id="mother_name_bng" name="mother_name_bng" type="text" class="form-control"
                                           placeholder="নাম (বাংলা)">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="">মাতার নাম (ইংরেজি)</label>
                                <div class="kt-input-icon">
                                    <input id="mother_name_eng" name="mother_name_eng" type="text" class="form-control"
                                           placeholder="মাতার নাম (ইংরেজি)">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="gender">লিঙ্গ</label><span class="text-danger">*</span>
                                <select id="gender" name="gender" class="form-control select-select2">
                                    <option value="" selected="selected">--বাছাই করুন--</option>
                                    <option value="1">পুরুষ</option>
                                    <option value="2">নারী</option>
                                    <option value="3">অন্যান্য</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="religion">ধর্ম</label>
                                <select name="religion" id="religion" class="form-control select-select2">
                                    <option value="" selected="selected">--বাছাই করুন--</option>
                                    <option value="Islam">ইসলাম</option>
                                    <option value="Hindu">হিন্দু</option>
                                    <option value="Christian">খ্রিস্টান</option>
                                    <option value="Buddhist">বৌদ্ধ</option>
                                    <option value="Shik">শিখ</option>
                                    <option value="Others">অন্যান্য</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="blood_group">রক্তের গ্রুপ </label>
                                <select name="blood_group" id="blood_group" class="form-control select-select2">
                                    <option value="" selected="selected">--বাছাই করুন--</option>
                                    <option value="O+">ও+</option>
                                    <option value="O-">ও−</option>
                                    <option value="A+">এ+</option>
                                    <option value="A-">এ−</option>
                                    <option value="B+">বি+</option>
                                    <option value="B-">বি−</option>
                                    <option value="AB+">এবি+</option>
                                    <option value="AB-"> এবি-</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="marital_status"> বৈবাহিক অবস্থা </label>
                                <select id="marital_status" name="marital_status" class="form-control select-select2">
                                    <option value="" selected="selected">--বাছাই করুন--</option>
                                    <option value="Married">বিবাহিত</option>
                                    <option value="Single">অবিবাহিত</option>
                                    <option value="Widowed">বিধবা</option>
                                    <option value="Separated">বিপত্নীক</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label>ব্যক্তিগত ইমেইল</label><span class="text-danger">*</span>
                                <div class="kt-input-icon">
                                    <input name="personal_email" id="personal_email" type="text" class="form-control"
                                           placeholder="ব্যক্তিগত ইমেইল">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label>ব্যক্তিগত মোবাইল নম্বর </label><span class="text-danger">*</span>
                                <div class="kt-input-icon">
                                    <input name="personal_mobile" id="personal_mobile" type="text"
                                           class="form-control integer_type_positive" placeholder="ব্যক্তিগত মোবাইল" maxlength="11">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label>চাকুরীতে যোগদানের তারিখ </label>
                                <input id="joining_date" name="joining_date" type="text" class="form-control date"
                                       placeholder="যোগদানের তারিখ" value="{{date('d-m-Y')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>কর্মচারী ধরন</label>
                                <div class="kt-radio-inline">
                                    <label class="kt-radio kt-radio--solid">
                                        <input id="is_cadre" type="radio" name="is_cadre" value="1">
                                        ক্যাডার
                                        <span></span>
                                    </label>
                                    <label class="kt-radio kt-radio--solid">
                                        <input type="radio" name="is_cadre" value="2"> নন ক্যাডার
                                        <span></span>
                                    </label>
                                    <label class="kt-radio kt-radio--solid">
                                        <input type="radio" name="is_cadre" value="3">জনপ্রতিনিধি
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="cadre_info">
                            <div class="form-group row">
                                <div id="employee_cadre_div" class="col-lg-3">
                                    <label for="employee_cadre_id">ক্যাডার টাইপ </label>
                                    <select id="employee_cadre_id" name="employee_cadre_id"
                                            class="form-control select-select2">
                                        <option value="" selected="selected">--বাছাই করুন--</option>
                                        @foreach($cadres as $cadre)
                                            <option value="{{$cadre->id}}">{{$cadre->cadre_name_bng}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="employee_batch_div" class="col-lg-3">
                                    <label for="employee_batch_id">ব্যাচ নম্বর </label>
                                    <select id="employee_batch_id" name="employee_batch_id"
                                            class="form-control select-select2">
                                        <option value="" selected="selected">--বাছাই করুন--</option>
                                        @foreach($batches as $batch)
                                            <option value="{{$batch->id}}">{{$batch->batch_no}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="employee_grade_div" class="col-lg-3">
                                    <label for="employee_grade">গ্রেড </label>
                                    <select id="employee_grade" name="employee_grade"
                                            class="form-control select-select2">
                                        <option value="" selected="selected">--বাছাই করুন--</option>
                                        @for($i=1; $i<=22; $i++)
                                            <option value="{{$i}}">{{enTobn($i)}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div id="identity_no_div" class="col-lg-3">
                                    <label>পরিচিতি নম্বর </label>
                                    <input id="identity_no" name="identity_no" type="text" class="form-control integer_type_positive"
                                           placeholder="পরিচিতি নম্বর ">
                                </div>

                                <div id="appointment_memo_no_div" class="col-lg-6">
                                    <label>নিয়োগ পত্রের স্মারক নম্বর </label>
                                    <input id="appointment_memo_no" name="appointment_memo_no" type="text"
                                           class="form-control" placeholder="নিয়োগ পত্রের স্মারক নম্বর">
                                </div>


                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label> কর্মকর্তা ব্যবস্থাপনা </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <x-office-select unit="true" only_office="true" own_unit="true" grid="3"/>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="designation_id"> পদ </label>
                                    <select name="designation_id" id="designation_id"
                                            class="form-control rounded-0 select-select2">
                                        <option value="">--বাছাই করুন--</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label>পদে যোগদানের তারিখ </label>
{{--                                <span class="text-danger">*</span>--}}
                                <input id="designation_joining_date" name="designation_joining_date" type="text" class="form-control date" placeholder="পদে যোগদানের তারিখ" value="{{date('d-m-Y')}}">
                            </div>
                            <div class="col-lg-4">
                                <label for="incharge_label"> দায়িত্ব </label>
                                {{--                                <select id="incharge_label" name="incharge_label" class="js-example-tags form-control">--}}
                                {{--                                    <option value="" selected="selected">--বাছাই করুন--</option>--}}
                                {{--                                    @foreach($office_incharges as $incharge)--}}
                                {{--                                        <option value="{{$incharge->name_bng}}">{{$incharge->name_bng}}</option>--}}
                                {{--                                    @endforeach--}}
                                {{--                                </select>--}}

                                <select id="user-options" id="incharge_label" name="incharge_label"
                                        class="form-control">
                                    <option value="" selected="selected">--বাছাই করুন--</option>
                                    @foreach($office_incharges as $incharge)
                                        <option value="{{$incharge->name_bng}}">{{$incharge->name_bng}}</option>
                                    @endforeach
                                    <option id="other">অন্যান্য</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button class="btn  btn-success btn-square"><i class="fas fa-save mr-2"></i> সংরক্ষণ
                                    </button>
                                    <button type="reset" class="btn  btn-danger btn-square reset"><i
                                            class="fas fa-sync  mr-2"></i> রিসেট
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

        $('#date_of_birth').datepicker(
            {
                format: 'dd-mm-yyyy',
                autoclose: true,
                endDate: '{{date('d-m-Y', strtotime('-18 years'))}}',
            }
        )


        $(document).ready(function () {
            @if(Auth::user()->user_role_id == config('menu_role_map.user') && Auth::user()->current_organogram_role_id() == config('menu_role_map.office_admin'))
            officeOriginByCurrentOfficeID('{{Auth::user()->current_office_id()}}');
            loadOfficeTree('{{Auth::user()->current_office_id()}}');
            @elseif(Auth::user()->current_organogram_role_id() == config('menu_role_map.unit_admin'))
            officeUnitSelected();
            @endif
        });

        $("input[name$='is_cadre']").click(function () {
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
            $('#office_unit_id').val('{{Auth::user()->current_office_unit_id()}}').attr("disabled", "disabled").trigger('change');
        }

        function submitData(form, url) {
            $('#office_id').removeAttr('disabled');
            var data = $(form).serialize();
            $('#office_id').attr('disabled');
            var datatype = 'json';

            ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseData) {
                if (responseData.status === 'success') {
                    swal.fire(`নাম: ${responseData.name}`, `আইডি: ${responseData.userid.toString()}`);
                    $('.reset').click();
                    let emptyVal = '';
                    $('#full_name_bng').text(emptyVal);
                    $('#full_name_eng').text(emptyVal);
                } else {

                    if (responseData.statusCode === '422') {
                        var errors = responseData.msg;
                        $.each(errors, function (k, v) {
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

        $('#nid').on('blur', function () {
            var nid = $(this).val();
            var dob = $('#date_of_birth').val();
            if (nid.length == 10 || nid.length == 17 || nid.length == 13) {

                var url = '{{url('nid_validation')}}'
                var data = {dob: dob, nid: nid};
                var datatype = 'json';

                ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseData) {
                    if (responseData.status === 'success') {
                        $('#name_bng').val(responseData.msg.name);
                        $('#name_eng').val(responseData.msg.nameEn);
                        $('#mother_name_bng').val(responseData.msg.mother);
                        $('#father_name_bng').val(responseData.msg.father);

                        // toastr.success(responseData.msg);
                    } else {
                        toastr.error('আপনার আইডি অথবা জন্ম তারিখ ঠিক নয়');
                    }
                });
            } else {
                $(this).val('');
                toastr.error('আপনার আইডি অথবা জন্ম তারিখ ঠিক নয়');
            }
        });

        $("select#office_unit_id").change(function () {
            var office_unit_id = $(this).children("option:selected").val();
            var office_id = $('#office_id').val();
            loadDesignation(office_id, office_unit_id);
        });

        function loadDesignation(office_id, office_unit_id) {
            var url = 'load_designation_for_assignemployee';
            var data = {office_id, office_unit_id};
            var datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#designation_id").html(responseDate);
                $('#loader').hide();
            });
        }

        $('#name_bng').on('keyup', function () {
            var name_bng = $(this).val();
            if (isUnicode(name_bng) == false) {
                $(this).val('');
                return false
            }

        });

        $('#name_eng').on('keyup', function () {
            var name_eng = $(this).val();
            if (isUnicode(name_eng) == true) {
                $(this).val('');
                return false
            }
        });

        $('#prefix_name_bng').on('keyup', function() {
            var prefix_name_bng = $(this).val();
            if (isUnicode(prefix_name_bng) == false) {
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
        $('#surname_eng').on('keyup', function() {
            var surname_eng = $(this).val();
            if (isUnicode(surname_eng) == true) {
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

        $('#father_name_bng').on('keyup', function () {
            var father_name_bng = $(this).val();
            if (isUnicode(father_name_bng) == false) {
                $(this).val('');
                return false
            }

        });

        $('#father_name_eng').on('keyup', function () {
            var father_name_eng = $(this).val();
            if (isUnicode(father_name_eng) == true) {
                $(this).val('');
                return false
            }
        });

        $(".js-example-tags").select2({
            tags: true
        });

        $(function () {

            var sel_user_options = $("select#user-options"),
                opts = sel_user_options.find('option');


            sel_user_options.bind('change', function (e) {

                e.preventDefault();

                var optselected = $(this).find("option:selected");

                if (optselected.attr('id') == 'other') {

                    sel_user_options.after("<div class='additional'><input class='form-control' id=other name='other' placeholder='টাইপ করুন'/></div>");

                    var oth = $("input#other");

                    oth.keyup(function (e) {
                        optselected.html($(this).val());
                    });

                } else {
                    $('.additional').hide();
                }

            });
        });
    </script>

@endsection
