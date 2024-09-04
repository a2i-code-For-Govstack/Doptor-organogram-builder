@extends('master')
@section('content')
<style>
    /* Base Styles */
.kt-portlet__body {
    padding: 15px;
    overflow: hidden;
}

.card.custom-card {
    margin-bottom: 20px;
}

.table-responsive {
    overflow-x: auto;
}

/* Responsive Styles for Mobile Devices */
@media (max-width: 575.98px) {
    .sna-subheader {
        flex-direction: column;
        align-items: flex-start;
    }

    .sna-subheader .btn, .sna-subheader h3 {
        margin-bottom: 10px;
    }

    .kt-portlet__body {
        padding: 10px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .btn-group {
        width: 100%;
        text-align: center;
    }

    .kt-quick-panel__content {
        padding: 15px;
    }

    .kt-scrolltop {
        display: block;
        position: fixed;
        bottom: 10px;
        right: 10px;
    }
}

/* Responsive Styles for Tablets and Larger Devices */
@media (min-width: 576px) and (max-width: 767.98px) {
    .sna-subheader {
        flex-direction: row;
        flex-wrap: wrap;
    }

    .sna-subheader .btn {
        margin-right: 10px;
    }

    .kt-portlet__body {
        padding: 15px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .btn-group {
        text-align: right;
    }

    .kt-scrolltop {
        display: block;
        position: fixed;
        bottom: 15px;
        right: 15px;
    }
}

/* Responsive Styles for Desktops */
@media (min-width: 768px) {
    .sna-subheader {
        flex-direction: row;
    }

    .kt-portlet__body {
        padding: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .btn-group {
        text-align: right;
    }

    .kt-scrolltop {
        display: block;
        position: fixed;
        bottom: 20px;
        right: 20px;
    }
}
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch; /* Smooth scrolling on touch devices */
}
.dataTables_length,.ml-3 {
    display: none;
}

.table {
    min-width: 600px; /* Adjust based on your table width */
}
</style>
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border" id="kt_content">
        <!--begin::Subheader-->
        <div class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap" id="kt_subheader">

            <div class="ml-3">
                <button id="btn-advance-search" class="btn btn-sna-header-button-color py-0  d-flex" >
                    <div>
                        <i class="fa fa-search mr-2 my-1"></i>
                    </div>
                    <div>
                        <p class="mb-0 pt-1">Search</p>

                    </div>
                    </button>
            </div>
            <div>
                <h3 class="text-white my-1">Basic Office List</h3>
            </div>
            <div class="mr-3 d-flex">

{{--                <button id="btn_excel_generate" class="btn btn-sna-header-button-color py-0  d-flex mr-2" >--}}
{{--                    <div>--}}
{{--                        <i class="fa fa-download my-1 ml-2 mr-0"></i>--}}
{{--                    </div>--}}

{{--                    </button>--}}
                <button  class="btn btn-sna-header-button-color py-0  d-flex create-posasonik" >
                    <div>
                        <i class="fa fa-plus mr-2 my-1"></i>
                    </div>
                    <div>
                        <p class="mb-0 pt-1">Create New Basic Office</p>

                    </div>
                    </button>
            </div>


        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">

            <!--Begin::Dashboard 1-->
            <div class="kt-portlet kt-portlet--mobile">

                <div class="row mb-2">
                    <div class="col-md-12">
                        <div style="display:none" class="card custom-card shadow-sm w-100 advance_search">
                            <div class="card-header">
                                <h5 class="mb-0"></h5>
                            </div>
                            <div class="card-body">
                                <form onsubmit="searchData(this, 'search_office_origins'); return false;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <select id="ministry_id" class="form-control rounded-0 select-select2"
                                                        name="ministry_id">
                                                    <option value="" selected="selected">----Choose Basic Office List----
                                                    </option>
                                                    @foreach($office_ministries as $ministry)
                                                        <option
                                                            value="{{$ministry->id}}">{{$ministry->name_bng}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <select id="layer_id" class="form-control rounded-0 select-select2"
                                                        name="layer_id">
                                                    <option value="" selected="selected">----Choose Basic Office Layer----
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input placeholder="Office Name (Others)" id="name_bn"
                                                       class="form-control rounded-0 bangla" type="text" name="name_bn">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input placeholder="Office Name (English)" id="name_en"
                                                       class="form-control rounded-0 english" type="text" name="name_en">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 d-flex align-items-end">
                                            <div class="form-group">
                                                <button class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Begin::Row-->
                <div class="kt-portlet__body">
                    <div id="list_div" class="load-table-data" data-href="/getOfficeOrigin"></div>
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
                    Edit Basic Office </span></a></li>
                    <!--<small>5</small>-->
                </h5>
                <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i class="flaticon2-delete"></i></a>
            </div>
            <div class="kt-quick-panel__content">
                <div class="mt-3">
                    <form id="office_origin_form"
                          onsubmit="submitData(this, '{{route('office_origin.store')}}'); return false;">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="office_ministry_id"> Basic Office Ministry </label><span class="text-danger">*</span>
                                <select id="office_ministry_id" class="form-control rounded-0 select-select2"
                                        name="office_ministry_id">
                                    <option value="" selected="selected">----Choose----</option>
                                    @foreach($office_ministries as $ministry)
                                        <option value="{{$ministry->id}}">{{$ministry->name_bng}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="office_layer_id">Office Layer</label><span class="text-danger">*</span>
                                <select name="office_layer_id" id="office_layer_id" class="form-control rounded-0 select-select2">
                                    <option value="">--Choose--</option>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Higher Office</label>
                                <select name="parent_office_id" id="parent_office_id" class="form-control rounded-0 select-select2">
                                    <option value="0">--Choose--</option>


                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="office_name_bng">Name (Others)</label><span class="text-danger">*</span>
                                <input id="office_name_bng" class="form-control rounded-0 bangla" type="text"
                                       name="office_name_bng">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="office_name_eng">Name (English)</label><span class="text-danger">*</span>
                                <input id="office_name_eng" class="form-control rounded-0 english" type="text"
                                       name="office_name_eng">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="office_level">Layer</label><span class="text-danger">*</span>
                                <input id="office_level" class="form-control rounded-0" type="text" >
                                <input id="office_level_hidden" class="form-control rounded-0" type="hidden" name="office_level">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="office_sequence">Sl.</label><span class="text-danger">*</span>
                                <input id="office_sequence" class="form-control rounded-0" type="text" >
                                <input id="office_sequence_hidden" class="form-control rounded-0" type="hidden" name="office_sequence">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end">
                                <div class="btn-group" role="group" aria-label="Button group">
                                    <button class="btn  btn-success btn-square"><i class="fas fa-save mr-2"></i> Save
                                    </button>
                                    <a id="reset_btn" class="btn  btn-danger text-white"><i class="fas fa-sync  mr-2"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="origin_id" name="id">
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
            var office_id = 0;
            $("#kt_quick_panel_close_btn").click(function () {
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
                    $(".load-table-data").html(responseDate);
                });
            }

            // $(document).on('click', "ul.pagination>li>a", function (e) {
            //     e.preventDefault();
            //     loadData($(this).attr('href'));
            // });

            $(".create-posasonik").click(function () {
                office_id = 0;
                clearForm('#office_origin_form');
                $('#office_name_bng').val('');
                $('#office_name_eng').val('');
                $('#origin_id').val('');
                $('#office_sequence').val('');
                $('#office_sequence_hidden').val('');
                $('#office_level').val('');
                $('#office_level_hidden').val('');
                getParentOrigin('');

                $('.kt_quick_panel__title').text('Basic Office');
                $("#kt_quick_panel").addClass('kt-quick-panel--on');
                $("#kt_quick_panel").css('opacity', 1);
                $("html").addClass("side-panel-overlay");
            })
            $(document).on('click', ".btntableDataEdit", function () {

                $(".kt_quick_panel__title").text('Edit Basic Office');
                $("#kt_quick_panel").addClass('kt-quick-panel--on');
                $("#kt_quick_panel").css('opacity', 1);
                $("html").addClass("side-panel-overlay");
                var content = $(this).attr('data-content');
                var content_value = content.split(',')
                var id = content_value[0];
                var office_ministry_id = content_value[1];
                var office_layer_id = content_value[2];
                var parent_office_id = content_value[3];
                var office_level = content_value[4];
                var office_sequence = content_value[5];
                var active_status = content_value[6];
                var office_name_eng = content_value[7];
                var office_name_bng = content_value[8];

                office_id = id;

                $('#office_name_bng').val(office_name_bng);
                $('#office_name_eng').val(office_name_eng);
                $('#origin_id').val(id);
                $('#office_sequence').val(BnFromEng(office_sequence));
                $('#office_sequence_hidden').val(office_sequence);
                $('#office_level').val(BnFromEng(office_level));
                $('#office_level_hidden').val(office_level);

                if (active_status == 1) {
                    $('#status').prop('checked', true);
                    $('#status').val(1);
                }
                $('#office_ministry_id option[value=' + office_ministry_id + ']').prop('selected', true).trigger('change');
                $('#office_layer_id option[value=' + office_layer_id + ']').prop('selected', true);
                $('#parent_office_id option[value=' + parent_office_id + ']').prop('selected', true);

            });

            function submitData(form, url) {
                if ($('#office_ministry_id').val()) {
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
                } else {
                    toastr.error('Choose Basic Office Ministry');
                }

            }

            function deleteItem(id) {
                var confirmation = confirm("Are you sure you want to delete?");
                if (confirmation) {
                    var data = {id};
                    var datatype = 'json';

                    ajaxCallAsyncCallback('office_origin_delete', data, datatype, 'GET', function (responseDate) {
                        if (responseDate.status === 'success') {
                            loadData();
                            toastr.success(responseDate.msg);
                            $("#kt_quick_panel_close_btn").trigger('click');
                        } else {
                            toastr.error(responseDate.msg);
                        }
                    });
                } else
                    toastr.error(responseDate.msg);
                return false;
            }

            $("select#office_ministry_id").change(function () {
                var ministry_id = $(this).children("option:selected").val();
                loadOfficeLayer(ministry_id);
                getParentOrigin(ministry_id);
            });

            function loadOfficeLayer(ministry_id) {
                var url = 'load_office_layer_ministry_wise';
                var data = {ministry_id};
                var datatype = 'html';
                ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                    $("#office_layer_id").html(responseDate);
                });
            }

            function getParentOrigin(ministry_id) {
                var url = 'load_ministry_parent_origin';
                var data = {ministry_id,office_id};
                var datatype = 'html';
                ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                    $("#parent_office_id").html(responseDate);
                });
            }

            $("select#parent_office_id").change(function () {
                var parent_office_id = $(this).children("option:selected").val();
                var ministry_id = $('#office_ministry_id').val();
                if (parent_office_id == ministry_id) {
                    $('#parent_office_id').val('');
                    toastr.error('Higher Office & Basic office must be different!');
                }
            });

            $('#btn_excel_generate').on('click', function () {
                var url = 'generate_office_origin_excel_file';
                var data = {};
                var datatype = 'json';
                ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                    window.open(responseDate.full_path, '_blank');
                    // deleteFile(responseDate.file_name);
                });
            });


            //for search

            $("select#ministry_id").change(function () {
                var ministry_id = $(this).children("option:selected").val();
                loadSearchOfficeLayer(ministry_id);
                // getParentOrigin(ministry_id);
            });

            function loadSearchOfficeLayer(ministry_id) {
                var url = 'load_office_layer_ministry_wise';
                var data = {ministry_id};
                var datatype = 'html';
                ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                    $("#layer_id").html(responseDate);
                });
            }

            function searchData(form, url) {
                var data = $(form).serialize();
                var datatype = 'html';
                ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseData) {
                    $("#list_div").html(responseData);
                });
            }

            $("#reset_btn").click(function(){
                var origin_id = $('#origin_id').val();
                if(origin_id){
                    $('#origin_id'+origin_id).click();
                }else{
                    $('.create-posasonik').click();
                }
            });

            $('#office_level').on('blur',function (){
            var number = $(this).val();
            var is_uni = isUnicode(number);
            if (is_uni) {
               var converted =  convertBanglaToEnglishNumber(number);
               $('#office_level_hidden').val(converted);
            }else{
                $('#office_level_hidden').val(number);
            }
        });

        $('#office_sequence').on('blur',function (){
            var number = $(this).val();
            var is_uni = isUnicode(number);
            if (is_uni) {
               var converted =  convertBanglaToEnglishNumber(number);
               $('#office_sequence_hidden').val(converted);
            }else{
                $('#office_sequence_hidden').val(number);
            }
        });

        </script>
@endsection
