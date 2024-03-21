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
                <h3 class="text-white my-1">Office Unit Management</h3>
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
                            <x-office-select grid="3" unit="false" only_office="true"></x-office-select>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="card custom-card round-0 border">
                                        <div class="card-header">
                                            <h5>Basic Unit List</h5>
                                        </div>

                                        <div class="card-body" id="moulik_unit_tree">
                                        </div>
                                    </div>
                                </div>

                                @if(Auth::user()->user_role_id == config('menu_role_map.super_admin') || Auth::user()->user_role_id == config('menu_role_map.admin'))
                                    <div class="col-md-2">
                                        <div class="card custom-card round-0 ">
                                            <div class="card-header text-center d-block">
                                                <h5 class="mb-0">Activities</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="text-center">

                                                    <button
                                                        class="btn btn-sm btn-icon btn-success btn-square d-block ml-auto mr-auto mb-2"
                                                        onclick="unitTransferFromOrigin(this)"><i
                                                            class="fas fa-chevron-right"></i></button>
                                                    <button
                                                        class="btn btn-sm btn-icon btn-primary btn-square d-block m-auto"
                                                        onclick="unitTransferToOrigin(this)"><i
                                                            class="fas fa-chevron-left"></i></button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-5">
                                    <div class="card custom-card round-0 border">
                                        <div class="card-header">
                                            <h5>Office Unit List</h5>
                                        </div>
                                        <div class="card-body" id="office_unit_tree">
                                            {{--                                            <div id="kt_tree_7" class="tree-demo"></div>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--End::Row-->

            <!--Begin::Row-->
            <div class="row">
            </div>

            <!--End::Row-->

            <!--End::Dashboard 1-->
        </div>

        <!-- end:: Content -->
    </div>

    <script>
        $(document).ready(function () {
            @if(Auth::user()->user_role_id == config('menu_role_map.user') && Auth::user()->current_organogram_role_id() == config('menu_role_map.office_admin'))
            officeOriginByCurrentOfficeID('{{Auth::user()->current_office_id()}}');
            // loadOfficeTree('{{Auth::user()->current_office_id()}}');
            @endif
        });

        $("select#office_id").change(function () {
            $("#moulik_unit_tree").html(' ');
            $("#office_unit_tree").html(' ');
            var office_id = $(this).children("option:selected").val();
            officeOriginByCurrentOfficeID(office_id);
            // loadOfficeTree(office_id);
        });

        $("select#layer_id").change(function () {
            $("#moulik_unit_tree").html(' ');
            $("#office_unit_tree").html(' ');
        });

        $("select#office_layer_id").change(function () {
            $("#moulik_unit_tree").html(' ');
            $("#office_unit_tree").html(' ');
        });

        $("select#custom_layer_id").change(function () {
            $("#moulik_unit_tree").html(' ');
            $("#office_unit_tree").html(' ');
        });

        $("select#office_origin_id").change(function () {
            $("#moulik_unit_tree").html(' ');
            $("#office_unit_tree").html(' ');
        });

        function officeOriginByCurrentOfficeID(office_id) {
            var url = 'load_office_origin_by_current_office_id';
            var datatype = 'json';
            var data = {office_id}
            ajaxCallAsyncCallback(url, data, datatype, 'POST', function (resp) {
                loadOriginTree(resp.data, office_id)
            });
        }

        function loadOriginTree(office_origin_id, office_id) {
            blockUi('#moulik_unit_tree');
            url = 'load_office_origin_unit_tree';
            data = {office_origin_id, office_id};
            datatype = 'html';

            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#moulik_unit_tree").html(responseDate);
                KTTreeview.init();
                $(".kt_tree_22").jstree("open_all");
                KTApp.unblock('#moulik_unit_tree');
                loadOfficeTree(office_id);
            });
        }

        function loadOfficeTree(office_id) {
            blockUi('#office_unit_tree');
            var url = 'load_office_unit_tree';
            var data = {office_id};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#office_unit_tree").html(responseDate);
                KTTreeview.init();
                $(".kt_tree_22").jstree("open_all");
                KTApp.unblock('#office_unit_tree');
            });
        }

        function generateOriginTreeData(office_ministry_id, office_layer_id, office_origin_id, office_id, checked_id) {
            var url = 'generate_origin_tree_data';
            var data = {office_ministry_id, office_layer_id, office_origin_id, office_id, checked_id};
            var datatype = 'json';
            ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseData) {
                if (responseData.status == 'success') {
                    if (responseData.not_send) {
                        toastr.error(responseData.not_send + 'As the Unit pre-existed, crossing over was not possible.');
                    }
                    if (responseData.send) {
                        toastr.success(responseData.send + ' Unit crossing over successfully!');
                        $(".kt_tree_22").jstree().uncheck_all();
                    }
                    // loadOfficeTree(office_id);
                    officeOriginByCurrentOfficeID(office_id);
                }
            });
        }


        function unitTransferFromOrigin(element) {

            var office_ministry_id = $('#office_ministry_id').children("option:selected").val();
            var office_layer_id = $('#office_layer_id').children("option:selected").val();
            var office_origin_id = $('#office_origin_id').children("option:selected").val();
            var office_id = $('#office_id').children("option:selected").val();

            var selected_node = $("#office_origin_unit_tree").jstree("get_selected", true);
            var checked_id = [];
            $.each(selected_node, function (k, node) {
                checked_id.push(node.a_attr['data-id']);
            });
            generateOriginTreeData(office_ministry_id, office_layer_id, office_origin_id, office_id, checked_id);
            // $(element).html('<i class="fas fa-pulse fa-spinner"></i>');
            // $(element).prop('disabled', true);
            // var url = '';
            // var data = {};
            // var datatype = 'json';
            // ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
            //
            //     $(element).prop('disabled', false);
            // });
        }

        function unitTransferToOrigin(element) {
            var office_ministry_id = $('#office_ministry_id').children("option:selected").val();
            var office_layer_id = $('#office_layer_id').children("option:selected").val();
            var office_origin_id = $('#office_origin_id').children("option:selected").val();
            var office_id = $('#office_id').children("option:selected").val();

            var checked_id = [];
            $('#office_unit_tree .jstree-clicked').each(function () {
                checked_id.push($(this).data('id'));
            });

            generateOfficeTreeData(office_ministry_id, office_layer_id, office_origin_id, office_id, checked_id);
        }

        function generateOfficeTreeData(office_ministry_id, office_layer_id, office_origin_id, office_id, checked_id) {
            var url = 'generate_office_tree_data';
            var data = {office_ministry_id, office_layer_id, office_origin_id, office_id, checked_id};
            var datatype = 'json';
            ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseData) {
                if (responseData.status == 'success') {
                    if (responseData.delete) {
                        toastr.success(responseData.delete + ' Delete successfully!');
                        // loadOfficeTree(office_id);
                        officeOriginByCurrentOfficeID(office_id);
                        $(".kt_tree_22").jstree().uncheck_all();
                    }
                    if (responseData.not_delete) {
                        toastr.error(responseData.not_delete + ' Officers in designation.');
                    }
                    if (responseData.delete == '' && responseData.not_delete == '') {
                        toastr.error('As the designation is active, it is not possible to bring it back.');
                    }
                }
                return false;
            });
        }
    </script>
@endsection
