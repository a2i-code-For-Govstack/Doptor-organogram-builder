@extends('master')
@section('content')
     <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!--begin::Subheader-->
        <div class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap" id="kt_subheader">

            <div class="ml-3"></div>
            <div>
                <h3 class="text-white my-1">Transfer of office Unit</h3>
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="office_ministry_id">Office Ministry</label>
                                        <select id="office_ministry_id" class="form-control rounded-0 select-select2"
                                                name="office_ministry_id">
                                            <option value="" selected="selected">----Choose----</option>
                                            @foreach($ministries as $ministry)
                                                <option value="{{$ministry->id}}">{{$ministry->name_bng}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="office_layer_id">Ministry/Department</label>
                                        <select name="office_layer" id="office_layer_id"
                                                class="form-control rounded-0 select-select2">
                                            <option value="0">--Choose--</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="office_origin_id">Doptor / Odhidoptor Type</label>
                                        <select name="office_origin" id="office_origin_id"
                                                class="form-control rounded-0 select-select2">
                                            <option value="0">--Choose--</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="office_id">Office</label>
                                        <select id="office_id" class="form-control rounded-0 select-select2"
                                                name="office_id">
                                            <option value="0">--Choose--</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <!--End::Row-->

            <!--Begin::Row-->
            <div class="row">
                <div class="kt-portlet">
                                        <div class="kt-portlet__head">
                                            <div class="kt-portlet__head-label">
                                                <h3 class="kt-portlet__head-title">
                                                    Adjusted Pills
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="kt-portlet__body">
                                            <ul class="nav nav-pills nav-fill" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#kt_tabs_5_1">Select Unit</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#kt_tabs_5_2">Units</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="kt_tabs_5_1" role="tabpanel">

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h4>Select Unit </h4>
                                                        </div>
                                                         <div class="col-md-6">
                                                            <h4>Unit to be transferred</h4>
                                                        </div>
                                                    </div>

                                                    <div class="row">

                                                        <div class="col-md-4">

                                                          <div class="">
                                                            <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th class="">Units</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                 <tr>
                                                                    <td>
                                                                        <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                        <input id="status" type="checkbox" name="status" value="0"> Office of the Director General
                                                                        <span></span>
                                                                    </label>
                                                                    </td>
                                                                </tr>
                                                                 <tr>
                                                                    <td>
                                                                        <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                        <input id="status" type="checkbox" name="status" value="0"> Office of the Director General
                                                                        <span></span>
                                                                    </label>
                                                                    </td>
                                                                </tr>
                                                                 <tr>
                                                                    <td>
                                                                        <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                        <input id="status" type="checkbox" name="status" value="0"> Office of the Director General
                                                                        <span></span>
                                                                    </label>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">

                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="office_ministry_id">Office Ministry</label>
                                                            <select id="office_ministry_id" class="form-control rounded-0 select-select2"
                                                            name="office_ministry_id">
                                                            <option value="" selected="selected">----Choose----</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group float-right">
                                                            <button class="btn btn-primary">Next Step</button>
                                                        </div>
                                                    </div>
                                                    </div>

                                                </div>
                                                <div class="tab-pane" id="kt_tabs_5_2" role="tabpanel">
                                                    <div class="row">

                                                        <div class="col-md-12">

                                                          <div class="">
                                                            <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th class="">#</th>
                                                                    <th class="">User Name</th>
                                                                    <th class="">Designation Name</th>
                                                                    <th class="">Unit Name</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td>Md. Fociullah</td>
                                                                    <td>Director General</td>
                                                                    <td>Office of the Director General</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2</td>
                                                                    <td>Md. Fociullah</td>
                                                                    <td>Director General</td>
                                                                    <td>Office of the Director General</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>3</td>
                                                                    <td>Md. Fociullah</td>
                                                                    <td>Director General</td>
                                                                    <td>Office of the Director General</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>4</td>
                                                                    <td>Md. Fociullah</td>
                                                                    <td>Director General</td>
                                                                    <td>Office of the Director General</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>5</td>
                                                                    <td>Md. Fociullah</td>
                                                                    <td>Director General</td>
                                                                    <td>Office of the Director General</td>
                                                                </tr>

                                                            </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
            </div>

            <!--End::Row-->

            <!--End::Dashboard 1-->
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
            loadOfficeUsers(office_id);

        });

        function loadOfficeUsers(office_id) {
            var url = 'load_office_wise_users';
            var data = {office_id};
            var datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#employee_list_div").html(responseDate);

            });
        }

        $(document).on('click', '#assignOfficeAdmin', function () {
            var office_unit_organogram_id = $("input[name='office_admin']:checked").data("office_unit_organogram_id");
            var url = 'assign_office_admin';
            var data = {office_unit_organogram_id};
            var datatype = 'json';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                if (responseDate.status === 'success') {
                    toastr.success(responseDate.msg);
                } else {
                    toastr.error(responseDate.msg);
                }
            });
        });


    </script>
@endsection
