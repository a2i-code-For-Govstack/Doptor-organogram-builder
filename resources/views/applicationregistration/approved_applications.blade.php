@extends('master')
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border"
         id="kt_content">
        <!--begin::Subheader-->
        <div
            class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"
            id="kt_subheader">

            <div class="ml-3">
                <button id="btn-advance-search" class="d-none">
                    <div>
                        <p class="mb-0 pt-1"></p>
                    </div>
                </button>
            </div>

            <div>
                <h3 class="text-white my-1">নিবন্ধিত তালিকা</h3>
            </div>
            <div class="mr-3 d-flex">

                <button id="btn_excel_generate" class="btn btn-sna-header-button-color py-0  d-flex mr-2">
                    <div>
                        <i class="fa fa-download my-1 ml-2 mr-0"></i>
                    </div>

                </button>
                <button class="btn btn-sna-header-button-color py-0  d-flex ">
                    <div>
                        <i class="fa fa-plus mr-2 my-1"></i>
                    </div>
                    <div>
                        <p class="mb-0 pt-1"><a href="{{url('/add_application')}}">এপ্লিকেশন যোগ করুন</a></p>
                    </div>
                </button>
            </div>


        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card rounded-0 shadow-sm">
                        <div class="card-body">
                            <div class="row mt-3 load-table-data" id="list_div">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End::Dashboard 1-->
        </div>
        <!-- end:: Content -->
    </div>

    <!-- end::Form Quick Panel -->

    <!-- begin::Scrolltop -->
    <div id="kt_scrolltop" class="kt-scrolltop">
        <i class="fa fa-arrow-up"></i>
    </div>
@endsection

@section('js')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();

            if ($(".load-table-data").length > 0) {
                loadData();
            }
        });

        function loadData() {
            var url = '{{url('/application_registration_approved_list')}}'
            var data = {};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $(".load-table-data").html(responseDate);
            });
        }

        $('#btn_excel_generate').on('click',function (){
            var url = 'generate_approved_application_excel_file';
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
            });
        });

        @if(session('success'))
        toastr.success('{{session('success')}}')
        @endif

        @if(session('error'))
        toastr.error('{{session('error')}}')
        @endif

    </script>
@endsection
