@extends('master')
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <div class="subheader py-2 py-lg-6 subheader-solid bg-light-primary" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-center flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <h3 class="text-info  my-1 mr-5">কর্মকর্তার তথ্য পরিবর্তন </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            কর্মকর্তার রেকর্ড যোগ করুন
                        </h3>
                    </div>
                </div>

                <!--begin::Form-->
                <form autocomplete="off" id="add_employee"
                      onsubmit="submitData(this, '{{route('employee_record.store')}}'); return false;"
                      class="kt-form kt-form--label-right">
                    <div class="kt-portlet__body">
                        <input type="hidden" id="id" name="id" value="{{$employee_info->id}}">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>জন্ম তারিখ</label><span class="text-danger">*</span>
                                <input name="date_of_birth" id="date_of_birth"
                                       value="{{date('d-m-Y',strtotime($employee_info->date_of_birth))}}" type="text"
                                       class="form-control form-control-solid" placeholder="জন্ম তারিখ"
                                       readonly>
                            </div>
                            <div class="col-lg-6">
                                <label class="">জাতীয় পরিচয়পত্র নম্বর</label><span class="text-danger">*</span>
                                <input name="nid" id="nid" type="text" value="{{enTobn($employee_info->nid)}}"
                                       class="form-control form-control-solid bijoy-bangla integer_type_positive mobile_no_input_box"
                                       placeholder="জাতীয় পরিচয়পত্র নম্বর" maxlength="17">
                                <span
                                    class="text-danger">* জাতীয় পরিচয়পত্র নম্বর ১০ , ১৩ অথবা ১৭ সংখ্যার হতে হবে।</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>নাম (বাংলা) </label><span class="text-danger">*</span>
                                <div class="kt-input-icon">
                                    <input name="name_bng" id="name_bng" value="{{$employee_info->name_bng}}"
                                           type="text" class="form-control form-control-solid bangla"
                                           placeholder="নাম (বাংলা)"
                                           onkeyup="generate_full_name('#prefix_name_bng', '#name_bng', '#surname_bng', '#full_name_bng')">
                                    <p class="mb-0">সম্পূর্ণ নাম (বাংলা): <span class="text-success"
                                                                                id="full_name_bng">{{ $employee_info->full_name_bng }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label class="">নাম (ইংরেজি)</label><span class="text-danger">*</span>
                                <div class="kt-input-icon">
                                    <input value="{{$employee_info->name_eng}}" name="name_eng" id="name_eng"
                                           type="text" class="form-control form-control-solid"
                                           placeholder="নাম (ইংরেজি)"
                                           onkeyup="generate_full_name('#prefix_name_eng', '#name_eng', '#surname_eng', '#full_name_eng')">
                                    <p class="mb-0">সম্পূর্ণ নাম (ইংরেজি): <span class="text-success"
                                                                                 id="full_name_eng">{{ $employee_info->full_name_eng }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label>নামের শুরুর উপাধি (বাংলা) </label>
                                <div class="kt-input-icon">
                                    <input name="prefix_name_bng" id="prefix_name_bng"
                                           value="{{$employee_info->prefix_name_bng}}"
                                           type="text" class="form-control form-control-solid"
                                           placeholder="নামের শুরুর উপাধি (বাংলা)"
                                           onkeyup="generate_full_name('#prefix_name_bng', '#name_bng', '#surname_bng', '#full_name_bng')">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <label>নামের শেষের উপাধি (বাংলা) </label>
                                <div class="kt-input-icon">
                                    <input name="surname_bng" id="surname_bng" value="{{$employee_info->surname_bng}}"
                                           type="text" class="form-control form-control-solid"
                                           placeholder="নামের শেষের উপাধি (বাংলা)"
                                           onkeyup="generate_full_name('#prefix_name_bng', '#name_bng', '#surname_bng', '#full_name_bng')">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <label class="">নামের শুরুর উপাধি (ইংরেজি)</label>
                                <div class="kt-input-icon">
                                    <input value="{{$employee_info->prefix_name_eng}}" name="prefix_name_eng"
                                           id="prefix_name_eng"
                                           type="text" class="form-control form-control-solid"
                                           placeholder="নামের শুরুর উপাধি (ইংরেজি)"
                                           onkeyup="generate_full_name('#prefix_name_eng', '#name_eng', '#surname_eng', '#full_name_eng')">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <label class="">নামের শেষের উপাধি (ইংরেজি)</label>
                                <div class="kt-input-icon">
                                    <input value="{{$employee_info->surname_eng}}" name="surname_eng" id="surname_eng"
                                           type="text" class="form-control form-control-solid"
                                           placeholder="নামের শেষের উপাধি (ইংরেজি)"
                                           onkeyup="generate_full_name('#prefix_name_eng', '#name_eng', '#surname_eng', '#full_name_eng')">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>পিতার নাম (বাংলা) </label>
                                <div class="kt-input-icon">
                                    <input id="father_name_bng" name="father_name_bng" type="text"
                                           value="{{$employee_info->father_name_bng}}" class="form-control bangla"
                                           placeholder="পিতার নাম (বাংলা)">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="">পিতার নাম (ইংরেজি)</label>
                                <div class="kt-input-icon">
                                    <input value="{{$employee_info->father_name_eng}}" id="father_name_eng"
                                           name="father_name_eng" type="text" class="form-control english"
                                           placeholder="পিতার নাম (ইংরেজি)">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>মাতার নাম (বাংলা) </label>
                                <div class="kt-input-icon">
                                    <input id="mother_name_bng" name="mother_name_bng" type="text"
                                           value="{{$employee_info->mother_name_bng}}" class="form-control bangla"
                                           placeholder="মাতার নাম (বাংলা)">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="">মাতার নাম (ইংরেজি)</label>
                                <div class="kt-input-icon">
                                    <input id="mother_name_eng" name="mother_name_eng" type="text"
                                           value="{{$employee_info->mother_name_eng}}" class="form-control english"
                                           placeholder="মাতার নাম (ইংরেজি)">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>লিঙ্গ</label><span class="text-danger">*</span>
                                <select id="gender" name="gender" class="form-control">
                                    <option value="" selected="selected">--বাছাই করুন--</option>
                                    <option @if($employee_info->gender == 1) selected @endif value="1">পুরুষ</option>
                                    <option @if($employee_info->gender == 2) selected @endif  value="2">নারী</option>
                                    <option @if($employee_info->gender == 3) selected @endif  value="3">অন্যান্য
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label>ধর্ম</label>
                                <select name="religion" id="religion" class="form-control">
                                    <option value="" selected="selected">--বাছাই করুন--</option>
                                    <option @if($employee_info->religion == 'Islam') selected @endif  value="Islam">
                                        ইসলাম
                                    </option>
                                    <option @if($employee_info->religion == 'Hindu') selected @endif value="Hindu">
                                        হিন্দু
                                    </option>
                                    <option @if($employee_info->religion == 'Christian') selected
                                            @endif value="Christian">খ্রিস্টান
                                    </option>
                                    <option @if($employee_info->religion == 'Buddhist') selected
                                            @endif value="Buddhist">বৌদ্ধ
                                    </option>
                                    <option @if($employee_info->religion == 'Shik') selected @endif value="Shik">শিখ
                                    </option>
                                    <option @if($employee_info->religion == 'Others') selected @endif value="Others">
                                        অন্যান্য
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>রক্তের গ্রুপ </label>
                                <select name="blood_group" id="blood_group" class="form-control">
                                    <option value="" selected="selected">--বাছাই করুন--</option>
                                    <option @if($employee_info->blood_group == 'O+') selected @endif value="O+">ও+
                                    </option>
                                    <option @if($employee_info->blood_group == 'O-') selected @endif value="O-">ও−
                                    </option>
                                    <option @if($employee_info->blood_group == 'A+') selected @endif value="A+">এ+
                                    </option>
                                    <option @if($employee_info->blood_group == 'A-') selected @endif value="A-">এ−
                                    </option>
                                    <option @if($employee_info->blood_group == 'B+') selected @endif value="B+">বি+
                                    </option>
                                    <option @if($employee_info->blood_group == 'B-') selected @endif value="B-">বি−
                                    </option>
                                    <option @if($employee_info->blood_group == 'AB+') selected @endif value="AB+">এবি+
                                    </option>
                                    <option @if($employee_info->blood_group == 'AB-') selected @endif value="AB-">
                                        এবি-
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label> বৈবাহিক অবস্থা </label>
                                <select id="marital_status" name="marital_status" class="form-control">
                                    <option value="" selected="selected">--বাছাই করুন--</option>
                                    <option @if($employee_info->marital_status == 'Married') selected
                                            @endif value="Married">বিবাহিত
                                    </option>
                                    <option @if($employee_info->marital_status == 'Single') selected
                                            @endif value="Single">অবিবাহিত
                                    </option>
                                    <option @if($employee_info->marital_status == 'Widowed') selected
                                            @endif value="Widowed">বিধবা
                                    </option>
                                    <option @if($employee_info->marital_status == 'Separated') selected
                                            @endif value="Separated">বিপত্নীক
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label>ব্যক্তিগত ইমেইল</label><span class="text-danger">*</span>
                                <div class="kt-input-icon">
                                    <input name="personal_email" id="personal_email" type="email"
                                           value="{{$employee_info->personal_email}}"
                                           class="form-control form-control-solid {{Auth::user()->user_role_id == 1 ? '': 'no-drop'}}"
                                           placeholder="ব্যক্তিগত ইমেইল" {{Auth::user()->user_role_id == 1 ? '': 'disabled'}}>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label class="">ব্যক্তিগত মোবাইল নম্বর </label><span class="text-danger">*</span>
                                <div class="kt-input-icon">
                                    <input name="personal_mobile" id="personal_mobile" type="text" maxlength="11"
                                           value="{{$employee_info->personal_mobile}}"
                                           class="bijoy-bangla integer_type_positive mobile_no_input_box form-control form-control-solid {{Auth::user()->user_role_id == 1 ? '': 'no-drop'}}"
                                           placeholder="ব্যক্তিগত মোবাইল" {{Auth::user()->user_role_id == 1 ? '': 'disabled'}}>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label>যোগদানের তারিখ </label><span class="text-danger">*</span>
                                <input id="joining_date" name="joining_date" type="text"
                                       value="{{date('d-m-Y', strtotime($employee_info->joining_date))}}"
                                       class="form-control date"
                                       placeholder="যোগদানের তারিখ">
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button class="btn  btn-success btn-square"><i class="fas fa-save mr-2"></i> সংরক্ষণ
                                    </button>
                                    <a type="button" id="resetInformation" value="Clear"
                                       class="btn  btn-danger btn-square text-white"><i class="fas fa-sync  mr-2"></i>
                                        রিসেট
                                    </a>
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
            autoclose: true,
            format: 'dd-mm-yyyy'
        });

        $(document).ready(function () {
            $("input[name$='is_cadre']").click(function () {
                var cadre = $(this).val();
                if (cadre == 1) {
                    $('#appointment_memo_no').val('');
                    $('#cadre_info').show();
                    $('#non_cadre_info').hide();
                } else if (cadre == 2 || cadre == 3) {
                    $('#appointment_memo_no').val('');
                    $('#employee_cadre_id').val('');
                    $('#employee_batch_id').val('');
                    $('#identity_no').val('');
                    $('#cadre_info').hide();
                    $('#non_cadre_info').show();
                }
            });
        });

        function submitData(form, url) {

            if ($("#nid").val() && ($("#nid").val().length === 10 || $("#nid").val().length === 13 || $("#nid").val().length === 17)) {
                data = $(form).serialize();
                datatype = 'json';
                ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseDate) {
                    if (responseDate.status === 'success') {
                        toastr.success(responseDate.msg);
                    } else {
                        toastr.error(responseDate.msg);
                    }
                });
            } else {
                toastr.error('জাতীয় পরিচয়পত্র নম্বর সঠিক নয়');
            }
        }

        $(document).on('click', '#resetInformation', function () {
            $("#father_name_bng").val('{{$employee_info->father_name_bng}}');
            $("#father_name_eng").val('{{$employee_info->father_name_eng}}');
            $("#mother_name_bng").val('{{$employee_info->mother_name_bng}}');
            $("#mother_name_eng").val('{{$employee_info->mother_name_eng}}');

            // gender
            @if ($employee_info->gender == 1)
            $("select#gender").val("1").change();
            @elseif ($employee_info->gender == 2)
            $("select#gender").val("2").change();
            @elseif ($employee_info->gender == 3)
            $("select#gender").val("3").change();
            @else
            $("select#gender").val("").change();
            @endif

            // religion
            @if ($employee_info->religion == 'Islam')
            $("select#religion").val("Islam").change();
            @elseif ($employee_info->religion == 'Hindu')
            $("select#religion").val("Hindu").change();
            @elseif ($employee_info->religion == 'Christian')
            $("select#religion").val("Christian").change();
            @elseif ($employee_info->religion == 'Buddhist')
            $("select#religion").val("Buddhist").change();
            @elseif ($employee_info->religion == 'Shik')
            $("select#religion").val("Shik").change();
            @elseif ($employee_info->religion == 'Others')
            $("select#religion").val("Others").change();
            @else
            $("select#religion").val("").change();
            @endif

            // blood_group
            @if ($employee_info->blood_group == 'O+')
            $("select#blood_group").val("O+").change();
            @elseif ($employee_info->blood_group == 'O-')
            $("select#blood_group").val("O-").change();
            @elseif ($employee_info->blood_group == 'A+')
            $("select#blood_group").val("A+").change();
            @elseif ($employee_info->blood_group == 'A-')
            $("select#blood_group").val("A-").change();
            @elseif ($employee_info->blood_group == 'B+')
            $("select#blood_group").val("B+").change();
            @elseif ($employee_info->blood_group == 'B-')
            $("select#blood_group").val("B-").change();
            @elseif ($employee_info->blood_group == 'AB+')
            $("select#blood_group").val("AB+").change();
            @elseif ($employee_info->blood_group == 'AB-')
            $("select#blood_group").val("AB-").change();
            @else
            $("select#blood_group").val("").change();
            @endif

            // marital_status
            @if ($employee_info->marital_status == 'Married')
            $("select#marital_status").val("Married").change();
            @elseif ($employee_info->marital_status == 'Single')
            $("select#marital_status").val("Single").change();
            @elseif ($employee_info->marital_status == 'Widowed')
            $("select#marital_status").val("Widowed").change();
            @else
            $("select#marital_status").val("").change();
            @endif

            $("#personal_email").val('{{$employee_info->personal_email}}');
            $("#personal_mobile").val('{{$employee_info->personal_mobile}}');
            $("#joining_date").val('{{date('d-m-Y', strtotime($employee_info->joining_date))}}');
        });

        $('#prefix_name_bng').bangla({ enable: true });

        $('#prefix_name_eng').on('keyup', function () {
            var prefix_name_eng = $(this).val();
            if (isUnicode(prefix_name_eng) == true) {
                $(this).val('');
                return false
            }
        });

        $('#surname_bng').bangla({ enable: true });

        $('#surname_eng').on('keyup', function () {
            var surname_eng = $(this).val();
            if (isUnicode(surname_eng) == true) {
                $(this).val('');
                return false
            }
        });

    </script>

@endsection
