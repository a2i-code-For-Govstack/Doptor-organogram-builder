@extends('master')
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-6 subheader-solid bg-light-primary" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-center flex-wrap flex-sm-nowrap">

                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">

                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline flex-wrap mr-5">

                        <!--begin::Page Title-->
                        <h5 class="text-info  my-1 mr-5">কর্মকর্তার তথ্যের তালিকা</h5>

                        <!--end::Page Title-->
                    </div>
                    <!--end::Page Heading-->
                </div>

                <!--end::Info-->
            </div>
        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
            <!--Begin::Dashboard 1-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card rounded-0 shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary mb-3 btn-square create-posasonik" data-dismiss="modal">নতুন কর্মকর্তার তথ্য</button>
                                </div>
                            </div>
                            <form onsubmit="searchData(this, 'search_wating_employeerecord'); return false;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="office_ministry_id">মন্ত্রণালয়</label>
                                            <select id="office_ministry_id" name="office_ministry_id" class="form-control rounded-0 select-select2">
                                                <option value="">--বাছাই করুন--</option>
                                                @foreach($ministries as $ministry)
                                                    <option value="{{$ministry->id}}">{{$ministry->name_bng}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="office_layer_id">মন্ত্রণালয়/বিভাগ</label>
                                            <select id="office_layer_id" name="office_layer_id" class="form-control rounded-0 select-select2">
                                                <option value="0">--বাছাই করুন--</option>


                                            </select>
                                        </div>
                                    </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="office_origin_id">দপ্তর / অধিদপ্তরের ধরন</label>
                                            <select name="office_origin" id="office_origin_id"
                                                    class="form-control rounded-0 select-select2">
                                                <option value="0">--বাছাই করুন--</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="office_id">অফিস</label>
                                            <select id="office_id" name="office_id" class="form-control rounded-0 select-select2">
                                                <option value="0">--বাছাই করুন--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name_bn">নাম (বাংলা)</label>
                                            <input id="name_bn" class="form-control rounded-0" type="text" name="name_bn">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="login_id">লগইন আইডি</label>
                                            <input id="login_id" class="form-control rounded-0" type="text" name="login_id">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="emp_nid">জাতীয় পরিচয়পত্র নাম্বার </label>
                                            <input id="emp_nid" class="form-control rounded-0" type="text" name="emp_nid">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="emp_email">ইমেইল</label>
                                            <input id="emp_email" class="form-control rounded-0" type="text" name="emp_email">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="emp_mobile">মোবাইল</label>
                                            <input id="emp_mobile" class="form-control rounded-0" type="text" name="emp_mobile">
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-flex justify-content-end">
                                        <button class="btn btn-primary btn-square" type="submit">অনুসন্ধান</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div id="list_div" class="load-table-data" data-href="/get_wating_employeerecord_data">

                </div>
            </div>

            <!--End::Dashboard 1-->
        </div>

        <!-- end:: Content -->
    </div>


    <!-- begin::Form Quick Panel -->
    <div id="kt_quick_panel" class="kt-quick-panel py-5 px-3">
        <div class="kt_quick_panel__head">
            <h5 class="kt_quick_panel__title mb-0">
                কর্মকর্তার তথ্য
                <!--<small>5</small>-->
            </h5>
            <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i class="flaticon2-delete"></i></a>
        </div>
        <div class="kt-quick-panel__content">
            <div class="mt-3">
                <form id="employee_record_form" onsubmit="submitData(this, '{{route('employee_record.store')}}'); return false;">

                <div class="col-md-12">
                        <div class="form-group">
                            <label for="name_bng">নাম (বাংলা)</label><span class="text-danger">*</span>
                            <input id="name_bng" class="form-control rounded-0" type="text" name="name_bng" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name_eng">নাম (ইংরেজি)</label><span class="text-danger">*</span>
                            <input id="name_eng" class="form-control rounded-0" type="text" name="name_eng" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="father_name_bng">পিতার নাম (বাংলা)</label>
                            <input id="father_name_bng" class="form-control rounded-0" type="text" name="father_name_bng">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="father_name_eng">পিতার নাম (ইংরেজি)</label>
                            <input id="father_name_eng" class="form-control rounded-0" type="text" name="father_name_eng">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="mother_name_bng">মাতার নাম (বাংলা)</label>
                            <input id="mother_name_bng" class="form-control rounded-0" type="text" name="mother_name_bng">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="mother_name_eng">মাতার নাম নাম (ইংরেজি)</label>
                            <input id="mother_name_eng" class="form-control rounded-0" type="text" name="mother_name_eng">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="date_of_birth">জন্ম তারিখ </label>
                            <input id="kt_datepicker_1" class="form-control rounded-0 date_of_birth" type="text" name="date_of_birth">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nid">জাতীয় পরিচয়পত্র নম্বর </label><span class="text-danger">*</span>
                            <input id="nid" class="form-control rounded-0" type="text" name="nid" required>
                            <span class="text-danger">* জাতীয় পরিচয়পত্র নম্বর ১০ অথবা ১৭ সংখ্যার হতে হবে।</span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="bcn">জন্ম সনদ নম্বর</label>
                            <input id="bcn" class="form-control rounded-0" type="text" name="bcn">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="ppn">পাসপোর্ট নম্বর</label>
                            <input id="ppn" class="form-control rounded-0" type="text" name="ppn">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">

                                <label for="gender">লিঙ্গ</label>

                            <select name="gender" class="form-control" id="gender">
                                <option value="">--বাছাই করুন--</option>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                                <option value="3">Others</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="religion">ধর্ম</label>
                            <select name="religion" class="form-control" id="religion">
                                <option value="" selected="selected">--বাছাই করুন--</option>
                                <option value="Islam">Islam</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Christian">Christian</option>
                                <option value="Buddhist">Buddhist</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="blood_group">রক্তের গ্রুপ</label>
                            <select name="blood_group" class="form-control" id="blood_group">
                                <option value="" selected="selected">--বাছাই করুন--</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="marital_status">বৈবাহিক অবস্থা</label>
                            <select name="marital_status" class="form-control">
                                <option value="" selected="selected">--বাছাই করুন--</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Widowed">Widowed</option>
                                <option value="Separated">Separated</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="personal_email">ব্যক্তিগত ই-মেইল</label>
                            <input id="personal_email" class="form-control rounded-0" type="text" name="personal_email">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="personal_mobile">ব্যক্তিগত মোবাইল নম্বর </label><span class="text-danger">*</span>
                            <input id="personal_mobile" class="form-control rounded-0" type="text" name="personal_mobile" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="alternative_mobile">বিকল্প মোবাইল নম্বর</label>
                            <input id="alternative_mobile" class="form-control rounded-0" type="text" name="alternative_mobile">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                            <div class="btn-group" role="group" aria-label="Button group">
                                <button class="btn  btn-success btn-square"><i class="fas fa-save mr-2"></i> সংরক্ষণ</button>
                                <button class="btn  btn-danger btn-square"><i class="fas fa-sync  mr-2"></i> রিসেট</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="employee_office_id" name="id">
                    <input type="hidden" id="identification_number" name="identification_number">
                    <input type="hidden" id="office_id" name="office_id">
                    <input type="hidden" id="office_unit_id" name="office_unit_id">
                    <input type="hidden" id="office_unit_organogram_id" name="office_unit_organogram_id">
                    <input type="hidden" id="designation" name="designation">
                    <input type="hidden" id="designation_level" name="designation_level">
                    <input type="hidden" id="designation_sequence" name="designation_sequence">
                    <input type="hidden" id="office_head" name="office_head">
                    <input type="hidden" id="is_admin" name="is_admin">
                    <input type="hidden" id="is_cadre" name="is_cadre" value="2">
                    <input type="hidden" id="status" name="status" value="0">
                    <input type="hidden" id="created_by" name="created_by" value="0">
                    <input type="hidden" id="modified_by" name="modified_by" value="0">

                </form>
            </div>
        </div>
    </div>
    <!-- end::Form Quick Panel -->

    <!-- begin::Scrolltop -->
    <div id="kt_scrolltop" class="kt-scrolltop">
        <i class="fa fa-arrow-up"></i>
    </div>

    <script type="text/javascript">
        $("#kt_quick_panel_close_btn").click(function(){
            $("#kt_quick_panel").removeAttr('style');
            $("#kt_quick_panel").css('opacity', 0);
            $("#kt_quick_panel").removeClass('kt-quick-panel--on');
            $("html").removeClass("side-panel-overlay");
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
            if ($(".load-table-data").length > 0) {
                loadData();
            }
        });
        function loadData(url = '') {
            if (url === '') {
                url = $(".load-table-data").data('href');
            }
            var data = {};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $(".mt-3 .load-table-data").html(responseDate);
            });
        }

        // $(document).on('click', "ul.pagination>li>a", function (e) {
        //     e.preventDefault();
        //     loadData($(this).attr('href'));
        // });

        $(".create-posasonik").click(function(){
            clearForm('#employee_record_form');
            $('#name_bng').val('');
            $('#name_eng').val('');
            $('#father_name_bng').val('');
            $('#father_name_eng').val('');
            $('#mother_name_bng').val('');
            $('#mother_name_eng').val('');
            $('.date_of_birth').val('');
            $('#nid').val('');
            $('#bcn').val('');
            $('#ppn').val('');
            $('#personal_email').val('');
            $('#personal_mobile').val('');
            $('#alternative_mobile').val('');
            $('.kt_quick_panel__title').text('নতুন কর্মকর্তার তথ্য');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        })
        $(document).on('click', ".btntableDataEdit", function () {
            $(".kt_quick_panel__title").text('কর্মকর্তার তথ্য সম্পাদন');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");

            var content = $(this).attr('data-content');
            var content_value = JSON.parse(content);

            var id = content_value.id;
            var name_bng = content_value.name_bng;

            var name_eng = content_value.name_eng;
            var identification_number = content_value.identification_number;
            var personal_email = content_value.personal_email;
            var personal_mobile = content_value.personal_mobile;
            var is_cadre = content_value.is_cadre;
            var designation = content_value.designation;
            var unit_name_bn = content_value.unit_name_bn;
            var office_name_bn = content_value.office_name_bn;
            var username = content_value.username;
            var father_name_bng = content_value.father_name_bng;
            var father_name_eng = content_value.father_name_eng;
            var mother_name_bng = content_value.mother_name_bng;
            var mother_name_eng = content_value.mother_name_eng;

            var date_of_birth = content_value.date_of_birth;
            var nid = content_value.nid;
            var bcn = content_value.bcn;
            var ppn = content_value.ppn;
            var gender = content_value.gender;
            var religion = content_value.religion;
            var blood_group = content_value.blood_group;
            var marital_status = content_value.marital_status;
            var alternative_mobile = content_value.alternative_mobile;
            var office_id = content_value.office_id;
            var office_unit_id = content_value.office_unit_id;
            var office_unit_organogram_id = content_value.office_unit_organogram_id;
            var designation_level = content_value.designation_level;
            var designation_sequence = content_value.designation_sequence;
            var office_head = content_value.office_head;
            var is_admin = content_value.is_admin;
            var summary_nothi_post_type = content_value.summary_nothi_post_type;

            $('#name_bng').val(name_bng);
            $('#name_eng').val(name_eng);
            $('#father_name_bng').val(father_name_bng);
            $('#father_name_eng').val(father_name_eng);
            $('#mother_name_bng').val(mother_name_bng);
            $('#mother_name_eng').val(mother_name_eng);
            $('.date_of_birth').val(date_of_birth);
            $('#nid').val(nid);
            $('#bcn').val(bcn);
            $('#ppn').val(ppn);
            $('#personal_email').val(personal_email);
            $('#personal_mobile').val(personal_mobile);
            $('#alternative_mobile').val(alternative_mobile);
            $('#employee_office_id').val(id);
            $('#office_unit_id').val(office_unit_id);
            $('#office_id').val(office_id);
            $('#identification_number').val(identification_number);
            $('#office_unit_organogram_id').val(office_unit_organogram_id);
            $('#designation').val(designation);
            $('#designation_level').val(designation_level);
            $('#designation_sequence').val(designation_sequence);
            $('#office_head').val(office_head);
            $('#is_admin').val(is_admin);
            $('#summary_nothi_post_type').val(summary_nothi_post_type);

            $('#gender option[value=' + gender + ']').prop('selected', true);
            $('#religion option[value=' + religion + ']').prop('selected', true);
            $('#blood_group option[value=' + blood_group + ']').prop('selected', true);
            $('#marital_status option[value=' + marital_status + ']').prop('selected', true);

        });

        function submitData(form, url) {
            var data = $(form).serialize();
            var datatype = 'json';

            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                if (responseDate.status === 'success') {
                    loadData();
                    toastr.success(responseDate.msg);
                    $("#kt_quick_panel_close_btn").trigger('click');
                } else {
                    toastr.error(responseDate.msg);
                }
            });
        }

         $("select#office_ministry_id").change(function () {
            var ministry_id = $(this).children("option:selected").val();
            loadLayer(ministry_id);
        });

        function loadLayer(ministry_id) {
            var url = 'load_layer_ministry_wise';
            var data = {ministry_id};
            var datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#office_layer_id").html(responseDate);
            });
        }

        $("select#office_layer_id").change(function () {
            var office_layer_id = $(this).children("option:selected").val();
            $('#office_layer').val(office_layer_id);
            loadOfficeOrigin(office_layer_id);
        });

        function loadOfficeOrigin(office_layer_id) {
            var url = 'load_office_origin_layer_wise';
            var data = {office_layer_id};
            var datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#office_origin_id").html(responseDate);

            });
        }


        $("select#office_origin_id").change(function () {
            var office_origin_id = $(this).children("option:selected").val();
            loadOffice(office_origin_id);
        });

        function loadOffice(office_origin_id) {
            var url = 'load_office_origin_wise';
            var data = {office_origin_id};
            var datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#office_id").html(responseDate);

            });
        }

        $("select#office_id").change(function () {
            var office_id = $(this).children("option:selected").val();
            // loadOfficeUsers(office_id);

        });

        function searchData(form, url) {
            var data = $(form).serialize();
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function(responseData) {
                $("#list_div").html(responseData);
            });
        }


       // Bangla font / unicode check
        //------------------------------------------
            $('#name_bng').bangla({ enable: true });


       // English font check
        //--------------------------------
            $('#name_eng').on('blur',function (){
                var name_eng = $(this).val();
                // function to check unicode or not
                if (isUnicode(name_eng) == true) {
                    toastr.warning('অনুগ্রহ করে ইংরেজি শব্দ ব্যবহার করুন |');
                    $(this).val('');
                    return false
                }
            });

    </script>
@endsection
