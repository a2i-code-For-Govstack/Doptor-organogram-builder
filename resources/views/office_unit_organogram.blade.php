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
                <h3 class="text-white my-1">Office Unit of Organizational Structure Management</h3>
            </div>
            <div class="mr-3 d-flex"></div>


        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
            <div class="kt-portlet kt-portlet--mobile">

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
                                                {{--                                            <div id="kt_tree_3" class="tree-demo"></div>--}}
                                            </div>
                                        </div>
                                    </div>
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
                                    <div class="col-md-5">
                                        <div class="card custom-card round-0 border">
                                            <div class="card-header">
                                                <h5>Office Unit Designation</h5>
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
        </div>

        <script !src="">
            let opeded_origin_node = [];
            let opeded_unit_node = [];
            let jstree_options = {
                "open_all": true,
                "core": {
                    "themes": {
                        "responsive": false
                    }
                },
                "types": {
                    "default": {
                        "icon": "fas fa-home"
                    },
                    "file": {
                        "icon": "fas fa-map-marker-alt"
                    }
                },
                "plugins": ["types", "checkbox"]
            };

            $(document).ready(function () {
                @if(Auth::user()->user_role_id == config('menu_role_map.user') && Auth::user()->current_organogram_role_id() == config('menu_role_map.office_admin'))
                loadOriginTree('{{Auth::user()->current_office_id()}}');
                loadOfficeTree('{{Auth::user()->current_office_id()}}');
                @endif
            });

            $("select#office_id").change(function () {
                $("#moulik_unit_tree").html(' ');
                $("#office_unit_tree").html(' ');
                var office_id = $(this).children("option:selected").val();
                opeded_origin_node = [];
                opeded_unit_node = [];
                loadOriginTree(office_id);
                loadOfficeTree(office_id);
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

            function loadOriginTree(office_id) {
                blockUi('#moulik_unit_tree');
                var url = 'load_origin_unit_organogram_tree';
                var data = {office_id, opeded_origin_node};
                var datatype = 'html';
                ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                    $("#moulik_unit_tree").html(responseDate);
                    $("#office_origin_unit_organogram_tree").jstree(jstree_options)
                        .bind('open_node.jstree', function (event, data) {
                            opeded_origin_node.push(data.node.a_attr['data-rel']);
                        })
                        .bind('close_node.jstree', function (event, data) {
                            let index = opeded_origin_node.indexOf(data.node.a_attr['data-rel']);
                            if (index > -1) {
                                opeded_origin_node.splice(index, 1);
                            }
                        });
                    $("#office_origin_unit_organogram_tree").jstree("open_all");
                    KTApp.unblock('#moulik_unit_tree')
                });
            }

            function loadOfficeTree(office_id) {
                blockUi('#office_unit_tree');
                var url = 'load_unit_organogram_tree';
                var data = {office_id, opeded_unit_node};
                var datatype = 'html';
                ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                    $("#office_unit_tree").html(responseDate);
                    $("#office_unit_organogram_tree").jstree(jstree_options)
                        .bind('open_node.jstree', function (event, data) {
                            opeded_unit_node.push(data.node.a_attr['data-rel']);
                        })
                        .bind('close_node.jstree', function (event, data) {
                            let index = opeded_unit_node.indexOf(data.node.a_attr['data-rel']);
                            if (index > -1) {
                                opeded_unit_node.splice(index, 1);
                            }
                        });
                    $("#office_unit_organogram_tree").jstree("open_all");
                    KTApp.unblock('#office_unit_tree')
                });
            }

            function unitTransferFromOrigin(element) {

                var office_ministry_id = $('#office_ministry_id').children("option:selected").val();
                var office_layer_id = $('#office_layer_id').children("option:selected").val();
                var office_origin_id = $('#office_origin_id').children("option:selected").val();
                var office_id = $('#office_id').children("option:selected").val();

                var selected_node = $("#office_origin_unit_organogram_tree").jstree("get_selected", true);
                var checked_id = [];
                $.each(selected_node, function (k, node) {
                    if (node.a_attr['data-type'] == 'title') {
                        checked_id.push(node.a_attr['data-parent-child']);
                    }
                });

                // console.log(selected_node);
                generateOriginTreeData(office_ministry_id, office_layer_id, office_origin_id, office_id, checked_id);
            }

            function generateOriginTreeData(office_ministry_id, office_layer_id, office_origin_id, office_id, checked_id) {
                var url = 'generate_origin_organogram_tree_data';
                var data = {office_ministry_id, office_layer_id, office_origin_id, office_id, checked_id};
                var datatype = 'json';
                ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseDate) {
                    if (responseDate.status === 'success') {
                        toastr.success(responseDate.msg);
                        let unit_origin_id = [];
                        var parents = [];
                        $.each(checked_id, function (k, v) {
                            let org_unit = v.split('|');
                            unit_origin_id.push(org_unit[1]);
                            parents.push({
                                id: $("#office_unit_organogram_tree .jstree-anchor[data-origin-id=" + org_unit[1] + "]").parent('li').attr('id'),
                                text: $("#office_unit_organogram_tree .jstree-anchor[data-origin-id=" + org_unit[1] + "]").text()
                            });
                        });

                        loadOriginTree(office_id);
                        loadOfficeTree(office_id);
                        // let jstreeId = $("#office_unit_organogram_tree").attr('class').match(/(?:^|\s+)jstree-(\d+)(?:\s+|$)/g)[0].trim(' ').split('jstree-')[1];
                        // expandedNodeId = '#j' + jstreeId + '_' + v.id.split('_')[1];
                        // jsTreeExpandNode('#office_unit_organogram_tree', expandedNodeId);
                        $.each(unit_origin_id, function (k, v) {
                            let jstreeId = $("#office_unit_organogram_tree").attr('class').match(/(?:^|\s+)jstree-(\d+)(?:\s+|$)/g)[0].trim(' ').split('jstree-')[1];
                            let expandedNodeId = $("#office_origin_unit_organogram_tree [data-origin-id=" + v + "]").closest('li.jstree-node').attr('id');
                            expandedNodeId = expandedNodeId.split('_');
                            expandedNodeId = expandedNodeId[1];
                            expandedNodeId = "#j" + jstreeId + "_" + expandedNodeId;
                            jsTreeExpandNode('#office_unit_organogram_tree', expandedNodeId);
                        })
                        // $.each(parents, function(k,v) {
                        // let jstreeId = $("#office_unit_organogram_tree").attr('class').match(/(?:^|\s+)jstree-(\d+)(?:\s+|$)/g)[0].trim(' ').split('jstree-')[1];
                        // expandedNodeId = '#j' + jstreeId + '_' + v.id.split('_')[1];
                        // console.log(expandedNodeId);
                        // jsTreeExpandNode('#office_unit_organogram_tree', expandedNodeId);
                        // $("#office_unit_organogram_tree").jstree('select_node', '#j' + jstreeId + '_' + v.id.split('_')[1]);
                        // $("#office_unit_organogram_tree").jstree('deselect_node', '#j' + jstreeId + '_' + v.id.split('_')[1]);
                        // $("#office_unit_organogram_tree").jstree('open_node', '#j' + jstreeId + '_' + v.id.split('_')[1]);
                        // $("#office_unit_organogram_tree").jstree('open_node', '#j' + jstreeId + '_' + v.id.split('_')[1] + ' ul>li:first-child')
                        // })
                    } else {
                        toastr.error(responseDate.msg);
                    }
                });
            }

            function unitTransferToOrigin(element) {
                var office_ministry_id = $('#office_ministry_id').children("option:selected").val();
                var office_layer_id = $('#office_layer_id').children("option:selected").val();
                var office_origin_id = $('#office_origin_id').children("option:selected").val();
                var office_id = $('#office_id').children("option:selected").val();

                var selected_node = $("#office_unit_organogram_tree").jstree("get_selected", true);

                var checked_id = [];

                $.each(selected_node, function (k, node) {
                    var node_class = node.li_attr['class'];
                    if (node_class == 'podobi') {
                        checked_id.push(node.a_attr['data-id']);
                    }
                });

                generateOfficeTreeData(office_ministry_id, office_layer_id, office_origin_id, office_id, checked_id);

            }

            function generateOfficeTreeData(office_ministry_id, office_layer_id, office_origin_id, office_id, checked_id) {
                var url = 'generate_office_organogram_tree_data';
                var data = {office_ministry_id, office_layer_id, office_origin_id, office_id, checked_id};
                var datatype = 'json';
                ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseDate) {
                    // console.log(responseDate);
                    if (responseDate.status == 'success') {
                        if (responseDate.delete) {
                            loadOriginTree(office_id);
                            loadOfficeTree(office_id);
                            toastr.success(responseDate.delete + 'Delete Successfully!');
                        }
                        if (responseDate.not_delete) {
                            toastr.error(responseDate.not_delete + ' There are officers in the designation');
                        }
                    }
                    return false;
                });
            }

            $('#btn_excel_generate').on('click', function () {
                var url = 'generate_rename_office_designation_excel_file';
                var data = {};
                var datatype = 'json';
                ajaxCallAsyncCallback(url, data, datatype, 'GET', function (response) {
                    a = document.createElement('a');
                    a.href = response.full_path;
                    a.download = response.file_name;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(a.href);
                    // deleteFile(responseDate.file_name);
                });
            });

        </script>
@endsection
