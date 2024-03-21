@extends('master')
@section('content')
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
                <h3 class="text-white my-1">Search Office Layer</h3>
            </div>
            <div class="mr-3 d-flex">

                <button id="btn_excel_generate" class="btn btn-sna-header-button-color py-0  d-flex mr-2" >
                    <div>
                        <i class="fa fa-download my-1 ml-2 mr-0"></i>
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
                            <form onsubmit="searchData(this, 'office_layer_search_by_name'); return false;">
                            <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="name_bng">Layer Name (Others)</label>
                                            <input id="name_bng" class="form-control rounded-0" type="text" name="name_bng">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="name_eng">Layer Name (English)</label>
                                            <input id="name_eng" class="form-control rounded-0" type="text" name="name_eng">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="layer">Layer </label>
                                            <input id="layer" class="form-control rounded-0" type="text" name="layer">
                                        </div>
                                    </div>
                                     <div class="col-md-3 d-flex align-items-end">
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

            <div class="kt-portlet__body">
                <div id="list_div" class="load-table-data" data-href="/get_office_layer_list"></div>
            </div>

            <!--End::Dashboard 1-->
        </div>

        <!-- end:: Content -->
    </div>

    <div id="kt_quick_panel" class="kt-quick-panel py-5 px-3">
        <div class="kt_quick_panel__head">
            <h5 class="kt_quick_panel__title mb-0">
                Edit Administrative Section </span></a></li>
                <!--<small>5</small>-->
            </h5>
            <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i class="flaticon2-delete"></i></a>
        </div>
        <div class="kt-quick-panel__content">
            <div class="mt-5">
                <form id="bivag_form" onsubmit="submitData(this, '{{route('bivag.store')}}'); return false;">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="my-input">Administrative Section Name (Others)</label> <span class="text-danger">*</span>
                            <input id="division_name_bng" class="form-control rounded-0" type="text" name="division_name_bng" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="my-input">Administrative Section Name (English)</label><span class="text-danger">*</span>
                            <input id="division_name_eng" class="form-control rounded-0" type="text" name="division_name_eng" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="my-input">Department Code</label><span class="text-danger">*</span>
                            <input id="bbs_code" class="form-control rounded-0" type="text" name="bbs_code" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="kt-checkbox-list">
                                <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                    <input id="status" name="status" type="checkbox" value="0"> Status
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="bivag_id" name="id">
                    <input type="hidden" id="created_by" name="created_by" value="0">
                    <input type="hidden" id="modified_by" name="modified_by" value="0">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                            <div class="btn-group" role="group" aria-label="Button group">
                                <button class="btn  btn-success btn-square"><i class="fas fa-save mr-2"></i> Save
                                </button>
                                <button class="btn  btn-danger btn-square"><i class="fas fa-sync  mr-2"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>
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
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function(responseDate) {
                $(".load-table-data").html(responseDate);
            });
        }
        // $(document).on('click', "ul.pagination>li>a", function(e) {
        //     e.preventDefault();
        //     loadData($(this).attr('href'));
        // });

        function submitData(form, url) {
            var data = $(form).serialize();
            var datatype = 'json';

            ajaxCallAsyncCallback(url, data, datatype, 'GET', function(responseDate) {
                if (responseDate.status === 'success') {
                    loadData();
                    toastr.success(responseDate.msg);
                    $("#kt_quick_panel_close_btn").trigger('click');
                } else {
                    toastr.error(responseDate.msg);
                }
            });
        }

        $(".create-posasonik").click(function () {
            clearForm('#bivag_form');
            $('#division_name_bng').val('');
            $('#division_name_eng').val('');
            $('#bbs_code').val('');
            $('#bivag_id').val('');
            $('.kt_quick_panel__title').text('Administrative Section');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        })
        $(document).on('click', ".btntableDataEdit", function () {
            var content = $(this).attr('data-content');
            var content_value = content.split(',')
            var bivag_id = content_value[0];
            var bbs_code = content_value[1];
            var division_name_bng = content_value[2];
            var division_name_eng = content_value[3];
            var status = content_value[4];

            $('#division_name_bng').val(division_name_bng);
            $('#division_name_eng').val(division_name_eng);
            $('#bbs_code').val(bbs_code);
            $('#bivag_id').val(bivag_id);
            if(status==1){
                $('#status').prop('checked', true);
                $('#status').val(1);
            }

            $(".kt_quick_panel__title").text('Edit Administrative Section');
            $("#kt_quick_panel").addClass('kt-quick-panel--on');
            $("#kt_quick_panel").css('opacity', 1);
            $("html").addClass("side-panel-overlay");
        });

        $('#btn_excel_generate').on('click',function (){
            var url = 'generate_layer_search_excel_file';
            var data = {};
            var datatype = 'json';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (response) {
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

        $('#division_name_bng').bangla({ enable: true });

        $(function() {
            $('#btn_pdf_generate').click(function(event){
                event.preventDefault();
                var pageSource = '<html>' + $('html').html() +'</html>';
                var url = 'generate_bivag_pdf_file';
                var data = {pageSource};
                var datatype = 'html';
                ajaxCallUnsyncCallback(url, data, datatype, 'POST', function (responseDate) {
                    console.log(responseDate);
                    return false;
                    window.open(responseDate.full_path,'_blank' );
                });
            });
        });

        function searchData(form, url) {
            var data = $(form).serialize();
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function(responseData) {
                $("#list_div").html(responseData);
            });
        }

        $('#name_bng').bangla({ enable: true });

    </script>
@endsection
