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
                        <h5 class="text-info  my-1 mr-5">স্থর ভিত্তিক অফিস তালিকা</h5>

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

            <!--Begin::Row-->
            <div class="row">
                <form id="office_admin_form">
                    <div class="col-md-12">
                        <div class="card custom-card round-0 shadow-sm">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select name="office_ministry_id" id="office_ministry_id"
                                                    class="form-control rounded-0 select-select2" required>
                                                <option value="">--বাছাই করুন--</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!--End::Row-->

            <!--Begin::Row-->
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="admin_list">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">অফিসের আইডি</th>
                                    <th class="text-center">অফিসের নাম</th>
                                    <th class="text-center">কার্যক্রম</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">8</td>
                                    <td class="text-center">জনপ্রশাসন মন্ত্রণালয়</td>
                                    <td class="text-center">সম্পাদনা</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

            <!--End::Row-->

            <!--End::Dashboard 1-->
        </div>

        <!-- end:: Content -->
    </div>

    <!-- end::Form Quick Panel -->

    <!-- begin::Scrolltop -->
    <div id="kt_scrolltop" class="kt-scrolltop">
        <i class="fa fa-arrow-up"></i>
    </div>

    <script type="text/javascript">
     $("#office_ministry_id").change(function () {
        let ministry_id = $(':selected').val();
        $.ajax({
            url: '{{url('get_office_layer')}}',
            data: {ministry_id: ministry_id},
            method: 'GET',
            success: function (response) {
             $('#office_layer').html(response);
            }
        });
    });

    $("#office_layer").change(function () {

        let office_layer_id = $('#office_layer').val();
        $.ajax({
            url: '{{url('get_office_origin')}}',
            data: {office_layer_id: office_layer_id},
            method: 'GET',
            success: function (response) {
             $('#office_origin').html(response);
            }
        });
    });

    $("#office_origin").change(function () {

        let office_origin_id = $('#office_origin').val();
        $.ajax({
            url: '{{url('get_office')}}',
            data: {office_origin_id: office_origin_id},
            method: 'GET',
            success: function (response) {
             $('#offices').html(response);
            }
        });
    });

    $("#offices").change(function () {
        let office_id = $('#offices').val();
        $.ajax({
            url: '{{url('get_office_admins')}}',
            data: {office_id: office_id},
            method: 'GET',
            success: function (response) {
             $('#offices').html(response);
            }
        });
    });
    </script>
@endsection
