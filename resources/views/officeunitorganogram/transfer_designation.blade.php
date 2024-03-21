@extends('master')
@section('content')
    <div class="kt-content kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border"
         id="kt_content">
        <div
            class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"
            id="kt_subheader">
            <div class="ml-3"></div>
            <div>
                <h3 class="text-white my-1">Transfer office structure</h3>
            </div>
            <div class="mr-3 d-flex"></div>
        </div>
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
            <div class="kt-portlet__body">
                <x-office-select unit="false" grid="3"/>
            </div>
            <div class="row">
                <div class="portlet light col-md-5">
                    <div class="portlet-title">
                        <div class="caption">
                            Office Unit Designation
                        </div>
                    </div>
                    <div class="portlet-window-body">
                        <div class="unit_designation_tree"></div>
                    </div>
                </div>
                <div class="portlet light col-md-1 text-center">
                    <div class="portlet-title">
                        <div class="caption">
                            Activities
                        </div>
                    </div>
                    <div class="portlet-window-body">
                        <button type="button" id="officeUnitDesignationsTransfer" class="btn btn-success">
                            <i class="fa fa-hand-point-right"></i>
                        </button>
                    </div>
                </div>
                <div class="portlet light col-md-5">
                    <div class="portlet-title">
                        <div class="caption">
                            Office Unit
                        </div>
                    </div>
                    <div class="portlet-window-body">
                        <div id="office-unit-id">
                            <select name="office_unit" class="form-control select-select2" id="office_unit">
                                <option value="0">--Choose--</option>
                            </select>
                        </div>
                        <div class="portlet-window-body">
                            <div class="selected_unit_designation_tree"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();

            if ({{ Auth::user()->user_role_id }} == {{ config('menu_role_map.user') }}) {
                $("select#office_id").val("{{auth()->user()->current_office_id()}}").trigger('change');
            }

        });

        $("select#office_id").change(function () {
            loadOfficeWiseUnitWithOrganogramTree($('#office_id').val());
            loadOfficeUnit($('#office_id').val());
        });

        $("select#office_unit").change(function () {
            loadOfficeUnitWiseDesignationTree($('#office_unit').val());
        });

        $("#officeUnitDesignationsTransfer").click(function () {
            transferUnitDesignations();
        });

        function transferUnitDesignations() {
            selected_elements = $("#office_unit_organogram_tree").jstree("get_selected", true)
            selected_designation_ids = [];
            selected_designations_unit_ids = [];
            selected_elements.map(element => {
                if (element.a_attr.data_type === 'designation') {
                    selected_designation_ids.push(element.a_attr.data_designation_id);
                    selected_designations_unit_ids.push(element.a_attr.data_unit_id);
                }
            });

            if (selected_designation_ids.length < 1) {
                toastr.error('Select Designation')
                return;
            }

            office_id = $('#office_id').val();
            office_unit_id = $('#office_unit').val();

            if (office_unit_id && office_unit_id !== '0') {
                var url = 'fire_designation_transfer_action';
                var data = {designation_ids: selected_designation_ids, office_unit_id, office_id};
                var datatype = 'json';
                ajaxCallAsyncCallback(url, data, datatype, 'POST', function (response) {
                    if (response.status == 'success') {
                        toastr.success(response.msg);
                        loadOfficeWiseUnitWithOrganogramTree(office_id, selected_designations_unit_ids);
                        loadOfficeUnitWiseDesignationTree(office_unit_id);
                    } else
                        toastr.error(response.msg)
                });
            } else {
                toastr.warning('Select Office Unit');
            }
        }

        function loadOfficeUnit(office_id) {
            var url = 'load_unit_office_wise';
            var data = {office_id};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#office_unit").html(responseDate);
            });
        }

        function loadOfficeUnitWiseDesignationTree(office_unit_id) {
            url = 'load_office_wise_unit_with_organogram_tree';
            data = {office_unit_id};
            datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseDate) {
                $(".selected_unit_designation_tree").html(responseDate);

                $('#office_unit_organogram_tree_office_unit').jstree({
                    "plugins": ["wholerow", "checkbox", "types"],
                })
                $('#office_unit_organogram_tree_office_unit').jstree("open_node", $('#office_unit_organogram_tree_office_unit [data_unit_id="' + office_unit_id + '"]'));
            });
        }

        function loadOfficeWiseUnitWithOrganogramTree(office_id, office_unit_ids = null) {
            url = 'load_office_wise_unit_with_organogram_tree';
            data = {office_id};
            datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseDate) {
                $(".unit_designation_tree").html(responseDate);
                $('#office_unit_organogram_tree').jstree({
                    "plugins": ["wholerow", "checkbox", "types"],
                })
                if (office_unit_ids) {
                    office_unit_ids.map(office_unit_id => {
                        $('#office_unit_organogram_tree').jstree("open_node", $('[data_unit_id="' + office_unit_id + '"]'));
                    });
                }
            });
        }
    </script>

@endsection
