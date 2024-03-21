@extends('master')
@section('content')
     <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border" id="kt_content">
        <!--begin::Subheader-->
        <div class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap" id="kt_subheader">

            <div class="ml-3"></div>
            <div>
                <h3 class="text-white my-1">Office wise branch and designation correction setting</h3>
            </div>
            <div class="mr-3 d-flex"></div>
        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">

            <!--Begin::Dashboard 1-->

            <!--Begin::Row-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card round-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="office_ministry_id">Office Ministry</label>
                                        <select autocomplete="off" id="office_ministry_id" class="form-control rounded-0 select-select2"
                                                name="office_ministry_id">
                                            <option value="" selected="selected">----Choose----</option>
                                            @foreach($ministries as $ministry)
                                                <option value="{{$ministry->id}}">{{$ministry->name_bng}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="office_layer_id">Ministry/Department</label>
                                        <select name="office_layer" id="office_layer_id"
                                                class="form-control rounded-0 select-select2">
                                            <option value="0">--Choose--</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card custom-card round-0">
                                        <form id="notificationForm">
                                            <div class="card-body" id="office_list_div">

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- end:: Content -->
    </div>

    <script !src="">

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
            var office_ministry_id = $('#office_ministry_id').val();
            var office_layer_id = $(this).children("option:selected").val();
            var url = 'get_office_by_ministry_and_layer';
            var data = {office_ministry_id,office_layer_id};
            var datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#office_list_div").html(responseDate);

            });
        });

        function loadOfficeNotification(office_id) {
            var url = 'get_office_notification_list';
            var data = {office_id};
            var datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#notification_list_div").html(responseDate);

            });
        }
    </script>
@endsection
