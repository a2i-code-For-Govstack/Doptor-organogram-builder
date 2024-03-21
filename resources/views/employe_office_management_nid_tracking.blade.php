@extends('master')
@section('content')
    <style>
        #ajaxForm {
            width: 100%;
            position: relative;
        }

        .loader-overly {
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: #eceaea;
            background-image: url({{asset('assets/plugins/global/images/owl.carousel/ajax-loader.gif')}});
            background-size: 50px;
            background-repeat: no-repeat;
            background-position: center;
            z-index: 10000000;
            opacity: 0.4;
            filter: alpha(opacity=40);
            /*display: none;*/
        }
    </style>
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!--begin::Subheader-->
        <div
            class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"
            id="kt_subheader">

            <div class="ml-3"></div>
            <div>
                <h3 class="text-white my-1">প্রয়োজনাতিরিক্ত এনআইডি ট্র্যাকিং</h3>
            </div>
            <div class="mr-3 d-flex"></div>
        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
            <!--Begin::Dashboard 1-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card shadow-sm w-100">
                        <div class="card-header">
                            <h4 class="mb-0">কর্মকর্তার জাতীয় পরিচয়পত্র অনুসন্ধান</h4>
                        </div>
                        <div class="card-body">
                            <form onsubmit="submitData(this, '{{route('get_employee_info')}}'); return false;">
                                <input type="hidden" name="tracking" value="1">
                                <div class="row">

                                    {{-- <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="username">লগইন আইডি</label>
                                            <input id="username" class="form-control rounded-0" type="text"
                                                   name="username">
                                        </div>
                                    </div> --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nid">জাতীয় পরিচয়পত্র</label>
                                            <input id="nid" class="form-control rounded-0" type="text" name="nid">
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="phone">মোবাইল</label>
                                            <input id="phone" class="form-control rounded-0" type="text" name="phone">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="email">ইমেইল</label>
                                            <input id="email" class="form-control rounded-0" type="text" name="email">
                                        </div>
                                    </div> --}}
                                    <div class="col-md-2 d-flex align-items-end">
                                        <div class="form-group">
                                            <button id="searchButton" class="btn btn-primary">অনুসন্ধান
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3" id="employee_info"></div>
            {{-- <div id="search_office" class="row mt-3" style="display: none">
                <div id="ajaxForm" class="col-md-12">
                    <div id="loader-overly" class=""></div>
                    <div class="card custom-card rounded-0 shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <x-office-select unit="false" grid="3" only_office="true"/>
                            </div>
                            <div class="row mt-3" id="office_unit_div_list">

                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!--End::Dashboard 1-->
        </div>

        <!-- end:: Content -->
    </div>
    <!-- end::Form Quick Panel -->
    <div class="row">
        <div class="col-md-2 offset-4">
            <img class="float-right" width="50px" id="loader"
                 src="{{asset('assets/plugins/global/images/owl.carousel/ajax-loader.gif')}}" alt="">
        </div>
    </div>

    <!-- begin::Scrolltop -->
    <div id="kt_scrolltop" class="kt-scrolltop">
        <i class="fa fa-arrow-up"></i>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            @if(Auth::user()->user_role_id == config('menu_role_map.user') && Auth::user()->current_organogram_role_id() == config('menu_role_map.office_admin'))
            loadOfficeUnits('{{Auth::user()->current_office_id()}}');
            @endif
        });
        $('#loader').hide();
        $("#kt_quick_panel_close_btn").click(function () {
            $("#kt_quick_panel").removeAttr('style');
            $("#kt_quick_panel").css('opacity', 0);
            $("#kt_quick_panel").removeClass('kt-quick-panel--on');
            $("html").removeClass("side-panel-overlay");
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        $(".create-posasonik").click(function () {
            $('.kt_quick_panel__title').text('নতুন ব্যাচ তৈরি');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        })
        $(".btntableDataEdit").click(function () {
            $(".kt_quick_panel__title").text('ব্যাচ সম্পাদন');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        });

        function submitData(form, url) {
            var data = $(form).serialize();
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $('#employee_info').html(responseDate);
                document.getElementById("search_office").style.display = "block";
            });
        }

        $("select#office_id").change(function () {
            $('#loader-overly').addClass('loader-overly');
            var office_id = $("#office_id").val();
            loadOfficeUnits(office_id);
        });

        function loadOfficeUnits(office_id) {
            var url = 'load_office_wise_units';
            var data = {office_id};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#office_unit_div_list").html(responseDate);
                $('#loader-overly').removeClass('loader-overly');
            });
        }

        $(document).on('click', '.disable_designation', function () {
            $('.disable_designation').prop('disabled',true);
            var office_id = $(this).attr('data-office_id');
            var employee_record_id = $(this).attr('data-employee_record_id');

            var date = $('#last_office_date_' + office_id).val();
            var url = 'disable_designation';
            var data = {office_id, employee_record_id, date};
            var datatype = 'json';

            $.ajax({
                async: false,
                type: 'GET',
                url: url,
                dataType: datatype,
                data: data,
                cache: false,
                error: function (data) {
                    $('.disable_designation').prop('disabled',false);
                    var errors = data.responseJSON;
                    $.each(errors.errors, function (k, v) {
                        if (v !== '') {
                            toastr.error(v);
                        }
                    });

                },
                success: function (responseData, textStatus) {
                    if (responseData.status === 'success') {
                        $('.disable_designation').prop('disabled',false);
                        toastr.success(responseData.msg);
                        $('#searchButton').trigger('click');
                        var office = $('#office_id').val();
                        if (office) {
                            $('select[name="office_id"]').val(office).trigger('change');
                        }
                    } else {
                        toastr.error(responseData.msg);
                    }
                }
            });
        })

        $(document).on('click', '.addOfficeEmployee', function () {
            $('#loader-overly').addClass('loader-overly');
            var org_id = $(this).data('id');
            var office_unit_id = $('#office_unit_id' + org_id).val();
            var office_id = $('#office_id' + org_id).val();
            var designation_bng = $('#designation_bng' + org_id).val();
            var designation_eng = $('#designation_eng' + org_id).val();
            var designation_level = $('#designation_level' + org_id).val();
            var designation_sequence = $('#designation_sequence' + org_id).val();
            var unit_name_bn = $('#unit_name_bn' + org_id).val();
            var unit_name_en = $('#unit_name_en' + org_id).val();
            var office_name_bng = $('#office_name_bng' + org_id).val();
            var office_name_eng = $('#office_name_eng' + org_id).val();
            var employee_record_id = $('#emp_id').val();
            var identification_number = $('#userName').val();
            var incharge_label = $('#incharge_label' + org_id).val();
            var joining_date = $('#joining_date' + org_id).val();

            var url = 'assing_office_employee';

            var data = {
                org_id,
                office_unit_id,
                office_id,
                designation_bng,
                designation_eng,
                designation_level,
                designation_sequence,
                unit_name_bn,
                unit_name_en,
                office_name_bng,
                office_name_eng,
                employee_record_id,
                identification_number,
                incharge_label,
                joining_date
            };
            var datatype = 'json';
            $.ajax({
                async: false,
                type: 'POST',
                url: url,
                dataType: datatype,
                data: data,
                cache: false,
                error: function (data) {
                    $('#loader-overly').removeClass('loader-overly');
                    var errors = data.responseJSON;
                    $.each(errors.errors, function (k, v) {
                        if (v !== '') {
                            toastr.error(v);
                        }
                    });

                },
                success: function (responseData, textStatus) {
                    if (responseData.status === 'success') {
                        $('#loader-overly').removeClass('loader-overly');
                        toastr.success(responseData.msg);
                        $('#searchButton').trigger('click');
                        var office = $('#office_id').val();
                        $('select[name="office_id"]').val(office).trigger('change');
                    }else{
                        $('#loader-overly').removeClass('loader-overly');
                        toastr.error(responseData.msg);
                    }
                }
            });
        });
    </script>
@endsection
