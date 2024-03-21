@extends('master')
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!--begin::Subheader-->
        <div class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"
            id="kt_subheader">

            <div class="ml-3"></div>
            <div>
                <h3 class="text-white my-1">Details of Officer's Responsibility</h3>
            </div>
            <div class="mr-3 d-flex"></div>
        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
            <!--Begin::Dashboard 1-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card rounded-0 shadow-sm">
                        <div class="card-header dont-print">
                            <h4 class="mb-0">Search Officer with Employee Login 
                                ID/National Identity Card </h4>
                        </div>
                        <div class="card-body">
                            <div class="row dont-print">
                                <div class="col-md-4">
                                    <form
                                        onsubmit="submitData(this, '{{ route('employee_record.search_employee') }}'); return false;">

                                        <div class="input-group">
                                            <input id="username" class="form-control rounded-0" type="text" name="keyword" required>
                                            <div class="input-group-append">
                                                <button type="submit"
                                                    class="btn btn-primary btn-square btn-icon search_employee"><i
                                                        class="fas fa-search"></i></button>
                                                <button type="button" class="btn btn-success btn-square btn-icon"
                                                    onclick="window.print();"><i class="fas fa-print"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="work_history"></div>
            <!--End::Dashboard 1-->
        </div>

        <!-- end:: Content -->
    </div>

    <script !src="">
        function submitData(form, url) {
            KTApp.block('#kt_content')
            var data = $(form).serialize();
            var datatype = 'html';

            ajaxCallAsyncCallback(url, data, datatype, 'POST', function(responseDate) {
                $("#work_history").html(responseDate);
                KTApp.unblock('#kt_content');
            });
        }

        $(document).on('blur', "input[name=keyword]", function() {
            if ($.isNumeric($(this).val())) {
                $(this).val(getUsername($(this).val()));
            }
        })
    </script>
@endsection
