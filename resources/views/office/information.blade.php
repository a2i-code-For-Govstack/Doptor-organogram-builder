@if(Auth::check())
    @if ($userHasRole)
        @php
            $layout = 'master';
        @endphp
    @else
        @php
            $layout = 'layouts.no-role';
        @endphp
    @endif
@else
    @php
        $layout = 'layouts.guest-user';
    @endphp
@endif

@extends($layout)

@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border"
         id="kt_content">
        <!--begin::Subheader-->
        <div
            class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"
            id="kt_subheader">

            <div class="ml-3"></div>
            <div>
                <h3 class="text-white my-1">অফিসের সংক্ষিপ্ত তথ্য</h3>
            </div>
            <div class="mr-3 d-flex"></div>
        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
            <!--Begin::Dashboard 1-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card shadow-sm w-100">
                        <div class="card-header">
                            <h5 class="mb-0"></h5>
                        </div>
                        <div class="card-body">
                            <form onsubmit="submitData(this, 'office-information'); return false;">
                                @csrf
                                <div class="row">
                                    @if(auth()->check())
                                        <div class="col-md-9">
                                            <x-office-select grid="3" unit="false"/>
                                        </div>
                                    @endif
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="single_office_id">অফিস আইডি</label>
                                            <input id="single_office_id" class="form-control rounded-0" type="text"
                                                   name="single_office_id">
                                        </div>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-end">
                                        <div class="form-group">
                                            <button id="search" class="btn btn-primary">অনুসন্ধান</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3" id="office_info"></div>

            <!--End::Dashboard 1-->
        </div>

        <!-- end:: Content -->
    </div>
    <!-- begin::Scrolltop -->
    <div id="kt_scrolltop" class="kt-scrolltop">
        <i class="fa fa-arrow-up"></i>
    </div>

    <script type="text/javascript">
        function submitData(form, url) {
            var data = $(form).serialize();
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseDate) {
                $('#office_info').html(responseDate);
            });
        }
    </script>
@endsection
