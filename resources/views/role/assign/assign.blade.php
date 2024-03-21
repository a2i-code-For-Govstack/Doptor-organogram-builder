@extends('master')
@section('css')
    <style>
        .checkbox-list {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
        }
    </style>
@endsection
@section('content')
     <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border" id="kt_content">
        <!--begin::Subheader-->
        <div class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap" id="kt_subheader">

            <div class="ml-3"></div>
            <div>
                <h3 class="text-white my-1">Head of Role Menu Responsibility</h3>
            </div>
            <div class="mr-3 d-flex"></div>
        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card round-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="role_id">Roles</label>
                                        <select id="role_id" class="form-control rounded-0 select-select2"
                                                name="role_id">
                                            <option value="" selected="selected">----Choose----</option>
                                            @foreach($roles as $role)
                                                <option value="{{$role->id}}">{{$role->description}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card custom-card round-0">
                                        <div class="card-body" id="menu_lists">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End::Dashboard 1-->
        </div>

        <!-- end:: Content -->
    </div>

    <script !src="">

        $("#all").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });

        $("select#role_id").change(function () {
            var role_id = $(this).children("option:selected").val();
            loadMenu(role_id);
        });

        function loadMenu(role_id) {
            var url = "{{url('role/get_menu_for_role_assign')}}"
            var data = {role_id};
            var datatype = 'html';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#menu_lists").html(responseDate);
            });
        }

        function makeParentChecked(e) {
            var parentData = e.target.getAttribute('data-parent');
            $('#' + parentData).prop('checked', true);
        }

        $(document).on('click', '#assignMenuInRole', function () {
            var menus = $("#menuassignform input:checkbox:checked").map(function () {
                return $(this).val();
            }).get();
            var role_id = $('#role_id').val();

            var url = '{{url('role/assign_map')}}';
            var data = {menus, role_id};
            var datatype = 'json';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                if (responseDate.status === 'success') {
                    toastr.success(responseDate.msg);
                } else {
                    toastr.error(responseDate.msg);
                }
            });
        });

        function editLoad(roleMenuMap) {
            $("#menuassignform input:checkbox").map(function () {
                if (roleMenuMap.includes(parseInt($(this).val()))) {
                    // console.log($(this).val())
                    $(this).prop('checked', true);
                }
            })
        }

    </script>
@endsection
