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
                <h3 class="text-white my-1">Basic Office Branch Organizational Structure</h3>
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
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="office_ministry_id">Ministry</label>
                                        <select name="office_ministry" id="office_ministry_id"
                                                class="form-control rounded-0 select-select2">
                                            <option value="">--Choose--</option>
                                            @foreach ($ministries as $ministry)
                                                <option value="{{ $ministry->id }}">{{ $ministry->name_bng }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="office_layer_id">Ministry / Department</label>
                                        <select name="office_layer" id="office_layer_id"
                                                class="form-control rounded-0 select-select2">
                                            <option value="0">--Choose--</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="office_origin_id">Doptor / Odhidoptor</label>
                                        <select name="office_origin" id="office_origin_id"
                                                class="form-control rounded-0 select-select2">
                                            <option value="0">--Choose--</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="card card-custom border-0">
                                        <div class="card-header pl-0">
                                            <h5>Basic Office Branch Organizational Structure</h5>
                                        </div>
                                        <div class="card-body tree_div">
                                            {{--                                            <i class="fa fa-spinner"></i>--}}
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
    <!-- begin::Form Quick Panel -->
    <div id="kt_quick_panel" class="kt-quick-panel py-5 px-3">
        <div class="kt_quick_panel__head">
            <h5 class="kt_quick_panel__title mb-0 col-md-12">
                Basic Office Branch Organizational Structure
            </h5>
            <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i
                    class="flaticon2-delete"></i></a>
        </div>
        <div class="kt-quick-panel__content">
            <div class="mt-3">
                <form id="designation_form"
                      onsubmit="submitData(this, '{{ route('office_origin_unit_organogram.store') }}'); return false;">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="office_origin_unit_id">Branch</label>
                            <select name="office_origin_unit_id" id="office_origin_unit_id"
                                    class="form-control select-select2">
                                <option value="0">--Choose--</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="superior_designation_id">Superior Post</label>
                            <select name="superior_designation_id" id="superior_designation_id"
                                    class="form-control select-select2">
                                <option value="0">--Choose--</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="designation_bng">Name (Others)</label><span class="text-danger">*</span>
                            <input id="designation_bng" class="form-control rounded-0 bangla" type="text"
                                   name="designation_bng">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="designation_eng">Name (English)</label><span class="text-danger">*</span>
                            <input id="designation_eng" class="form-control rounded-0 english" type="text"
                                   name="designation_eng">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="designation_level">Layer</label> <span class="text-danger">*</span>
                            <input id="designation_level" class="form-control rounded-0 bijoy-bangla" type="text"
                                   name="designation_level" maxlength="3">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="designation_sequence">Sl.</label> <span class="text-danger">*</span>
                            <input id="designation_sequence" class="form-control rounded-0 bijoy-bangla" type="text"
                                   name="designation_sequence" maxlength="3">
                        </div>
                    </div>
                    <div class="col-md-12 d-none" id="total_insert_group">
                        <div class="form-group">
                            <label for="total_insert">How many want to add?</label>
                            <input id="total_insert" class="form-control rounded-0 bijoy-bangla" type="text"
                                   name="total_insert"
                                   value="1">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                            <div class="btn-group" role="group" aria-label="Button group">
                                <button id="save_btn" class="btn  btn-success btn-square"><i
                                        class="fas fa-save mr-2"></i> Save
                                </button>
                                <!-- <button class="btn  btn-danger btn-square"><i class="fas fa-sync  mr-2"></i> রিসেট</button> -->
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="superior_unit_id" name="superior_unit_id">
                    {{-- <input type="hidden" id="office_origin_unit_id" name="office_origin_unit_id"> --}}
                    <input type="hidden" id="office_ministry" name="office_ministry_id">
                    <input type="hidden" id="office_origin" name="office_origin_id">
                    <input type="hidden" id="office_layer" name="office_layer_id">
                    <input type="hidden" id="status" name="status" value="1">
                    <input type="hidden" id="created_by" name="created_by" value="0">
                    <input type="hidden" id="modified_by" name="modified_by" value="0">
                    <input type="hidden" id="short_name_eng" name="short_name_eng">
                    <input type="hidden" id="short_name_bng" name="short_name_bng">

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
        var origin_unit_organogram_tree_nodes = [];

        $(document).ready(function () {
            origin_unit_organogram_tree_nodes = [];
        });

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
            $('.kt_quick_panel__title').text('Basic Office');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        })
        $(".btntableDataEdit").click(function () {
            $(".kt_quick_panel__title").text('Edit Organizational Structure');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        });

        $("select#office_ministry_id").change(function () {
            var ministry_id = $(this).children("option:selected").val();

            $('#office_ministry').val(ministry_id);
            loadLayer(ministry_id);
        });

        function loadLayer(ministry_id) {
            var url = 'load_layer_ministry_wise';
            var data = {
                ministry_id
            };
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
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
            var data = {
                office_layer_id
            };
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $("#office_origin_id").html(responseDate);
            });
        }


        $("select#office_origin_id").change(function () {
            origin_unit_organogram_tree_nodes = [];
            var office_ministry_id = $('#office_ministry_id').children("option:selected").val();
            var office_layer_id = $('#office_layer_id').children("option:selected").val();
            var office_origin_id = $(this).children("option:selected").val();
            loadTree(office_ministry_id, office_layer_id, office_origin_id);
            $('#office_origin').val(office_origin_id);
        });

        function loadTree(office_ministry_id, office_layer_id, office_origin_id, expand = false) {
            KTApp.block('#kt_content');
            url = 'load_office_origin_unit_organogram_tree';
            data = {
                office_ministry_id,
                office_layer_id,
                office_origin_id
            };

            Server_Async(url, data, 'get').done(function (data) {
                KTApp.unblock('#kt_content');
                $(".tree_div").html(data);
                $("#treeTask").jstree({
                    "core": {
                        "themes": {
                            "responsive": false
                        }
                    },
                    "types": {
                        "default": {
                            "icon": "fas fa-map-marker-alt"
                        },
                        "file": {
                            "icon": "fas fa-map-marker-alt"
                        }
                    },
                    'search': {
                        'case_insensitive': true,
                        'show_only_matches': true
                    },
                    "plugins": ["types", 'search']
                }).on('search.jstree', function (nodes, str, res) {
                    if (str.nodes.length === 0) {
                        $(this).jstree(true).hide_all();
                    }
                }).on('clear_search.jstree', function (nodes, str, res) {
                    $(this).jstree(true).show_all();
                }).on('open_node.jstree', function (e, data) {
                    parent_node = data.node.id;
                    origin_unit_organogram_tree_nodes.push(parent_node);
                }).on('close_node.jstree', function (e, data) {
                    parent_node = data.node.id;
                    origin_unit_organogram_tree_nodes = origin_unit_organogram_tree_nodes.filter(function (item) {
                        return item !== parent_node;
                    });
                });

                if (origin_unit_organogram_tree_nodes.length === 0) {
                    $('#treeTask').jstree('open_all')
                    $('.kt_tree_21').find('li[id^=podobi_node]').each(function () {
                        $('.kt_tree_21').jstree().close_node({"id": $(this).attr('id')});
                    });
                }

                if (expand) {
                    $.each(origin_unit_organogram_tree_nodes, function (index, value) {
                        $("#treeTask").jstree('select_node', value);
                        $("#treeTask").jstree('open_node', value, function (e, d) {
                            for (var i = 0; i < e.parents.length; i++) {
                                $("#treeTask").jstree('open_node', e.parents[i]);
                            }
                        });
                    });
                    $('.jstree-clicked').each(function () {
                        $(this).removeClass('jstree-clicked');
                    });
                }

                $('.jstree-clicked').each(function () {
                    $(this).removeClass('jstree-clicked');
                });

            });

            // $.ajax({
            //     type: 'GET',
            //     url: url,
            //     data: data,
            //     async: false,
            //     beforeSend: function () {
            //         KTApp.block('#kt_content');
            //     },
            //     success: function (responseDate) {
            //         $(".tree_div").html(responseDate);
            //         $("#treeTask").jstree({
            //             "core": {
            //                 "themes": {
            //                     "responsive": false
            //                 }
            //             },
            //             "types": {
            //                 "default": {
            //                     "icon": "fas fa-map-marker-alt"
            //                 },
            //                 "file": {
            //                     "icon": "fas fa-map-marker-alt"
            //                 }
            //             },
            //             'search': {
            //                 'case_insensitive': true,
            //                 'show_only_matches': true
            //             },
            //             "plugins": ["types", 'search']
            //         }).on('search.jstree', function (nodes, str, res) {
            //             if (str.nodes.length === 0) {
            //                 $(this).jstree(true).hide_all();
            //             }
            //         }).on('clear_search.jstree', function (nodes, str, res) {
            //             $(this).jstree(true).show_all();
            //         }).on('open_node.jstree', function (e, data) {
            //             parent_node = data.node.id;
            //             origin_unit_organogram_tree_nodes.push(parent_node);
            //         }).on('close_node.jstree', function (e, data) {
            //             parent_node = data.node.id;
            //             origin_unit_organogram_tree_nodes = origin_unit_organogram_tree_nodes.filter(function (item) {
            //                 return item !== parent_node;
            //             });
            //         });
            //
            //         if (origin_unit_organogram_tree_nodes.length === 0) {
            //             $('#treeTask').jstree('open_all')
            //             $('.kt_tree_21').find('li[id^=podobi_node]').each(function () {
            //                 $('.kt_tree_21').jstree().close_node({"id": $(this).attr('id')});
            //             });
            //         }
            //
            //         $('.jstree-clicked').each(function () {
            //             $(this).removeClass('jstree-clicked');
            //         });
            //
            //     },
            //     error: function (responseDate) {
            //         KTApp.unblock('#kt_content');
            //     },
            //     complete: function (responseDate) {
            //         KTApp.unblock('#kt_content');
            //     },
            // });

            $('.tree_search21').keyup(function () {
                $('.kt_tree_21').jstree(true).show_all();
                $('.kt_tree_21').jstree('search', $(this).val());
            });
        }

        function submitData(form, url) {
            var data = $(form).serialize();
            var datatype = 'json';

            document.getElementById("save_btn").disabled = true;
            ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseDate) {
                let requestedData = Object.fromEntries(new URLSearchParams(data))
                if (responseDate.status === 'success') {
                    toastr.success(responseDate.msg);
                    $("#kt_quick_panel_close_btn").trigger('click');
                    var office_ministry_id = $('#office_ministry_id').children("option:selected").val();
                    var office_layer_id = $('#office_layer_id').children("option:selected").val();
                    var office_origin_id = $("#office_origin_id").children("option:selected").val();
                    let expandedNodeId = $(".tree-demo [data-id=" + requestedData['office_origin_unit_id'] + "]").parent().find('ul:eq(0)>li[role="none"]:first-child').attr('id');

                    loadTree(office_ministry_id, office_layer_id, office_origin_id, true)

                    // setTimeout(function () {
                    //     $.each(origin_unit_organogram_tree_nodes, function (index, value) {
                    //         $("#treeTask").jstree('select_node', value);
                    //         $("#treeTask").jstree('open_node', value, function (e, d) {
                    //             for (var i = 0; i < e.parents.length; i++) {
                    //                 $("#treeTask").jstree('open_node', e.parents[i]);
                    //             }
                    //         });
                    //     });
                    //     $('.jstree-clicked').each(function () {
                    //         $(this).removeClass('jstree-clicked');
                    //     });
                    // }, 1200);

                } else {
                    toastr.error(responseDate.msg);
                }
            });
            document.getElementById("save_btn").disabled = false;
        }

        $(document).on('click', ".jstree-anchor", function (e, data) {
            var link = $(this); //.find('a');
            var type = link.data('type');

            if (type == 'title') {
                document.getElementById("designation_form").reset();
                $("#id").val('');
                $("#superior_unit_id").val('');
                $("#office_origin_unit_id").val('');
                $("#office_ministry").val('');
                $("#office_origin").val('');
                $("#office_layer").val('');
                $("#short_name_eng").val('');
                $("#short_name_eng").val('');

                $("#kt_quick_panel").addClass('kt-quick-panel--on');
                $("#kt_quick_panel").css('opacity', 1);
                $("html").addClass("side-panel-overlay");

                var id = link.data('id'); //clicked node data-id
                var unit_id = link.data('unit-id');
                // alert(id);

                var html_id = link.attr('id');
                var superior_html_li_id = $('#' + html_id).parent().parent().parent().parent().parent().attr('id');
                var superior_unit_id = $('#' + superior_html_li_id + ' a').attr('data-id');
                var superior_unit_text = $('#' + superior_html_li_id + '>a').text();
                loadUnitWiseOrganogram(superior_unit_id, id);
                loadUnit(superior_unit_id, id);

                if (id === undefined) {
                    $('#total_insert_group').removeClass('d-none')
                    $('#office_origin_unit_id').val(unit_id);
                } else {
                    $('#id').val(id);
                    editUnitOrganogram(id);
                }
                $('#superior_unit_text').val(superior_unit_text);
            }

        });

        function editUnitOrganogram(id) {
            var url = 'edit_office_origin_unit_organogram';
            var data = {
                id
            };
            var datatype = 'json';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $('#superior_designation_id').val(responseDate.superior_designation_id);
                $('#designation_bng').val(responseDate.designation_bng);
                $('#designation_eng').val(responseDate.designation_eng);
                $('#designation_level').val(responseDate.designation_level);
                $('#designation_sequence').val(responseDate.designation_sequence);
                $('#office_origin_unit_id').val(responseDate.office_origin_unit_id);
            });
        }

        function loadUnitWiseOrganogram(office_origin_unit_id, id) {
            var url = 'load_unit_wise_organogram';
            var data = {
                office_origin_unit_id,
                id
            };
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $('#superior_designation_id').html(responseDate);
            });
        }

        function loadUnit(office_origin_unit_id, id) {
            var url = 'load_origin_wise_units';
            var data = {
                office_origin_unit_id,
                id
            };
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $('#office_origin_unit_id').html(responseDate);
            });
        }
    </script>
@endsection
