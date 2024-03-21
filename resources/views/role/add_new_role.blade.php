@extends('master')
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-6 subheader-solid bg-light-primary" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-center flex-wrap flex-sm-nowrap">

                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">

                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline flex-wrap mr-5">

                        <!--begin::Page Title-->
                        <h5 class="text-info  my-1 mr-5"> নতুন রোল </h5>

                        <!--end::Page Title-->
                    </div>
                    <!--end::Page Heading-->
                </div>

                <!--end::Info-->
            </div>
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
                            <form onsubmit="submitData(this, ''); return false;">
                            <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="username">রোল নাম</label>
                                            <input id="username" class="form-control rounded-0" type="text" name="username">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="username">বিবরন </label>
                                            <input id="username" class="form-control rounded-0" type="text" name="username">
                                        </div>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
             <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card rounded-0 shadow-sm">
                        <div class="card-body">

                            <div class="row mt-3">
                                 <table class="table table-bordered">
                                            <thead>
          
                                                <tr>
                                                    <th>মেনু </th>
                                                    <th>অনুমতি</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>অ্যাডমিন </td>
                                                    <td>
                                                       <label class="kt-checkbox kt-checkbox--success">
                                                            <input type="checkbox">
                                                            <span></span>
                                                       </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>অ্যাডমিন </td>
                                                    <td>
                                                       <label class="kt-checkbox kt-checkbox--success">
                                                            <input type="checkbox">
                                                            <span></span>
                                                       </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>অ্যাডমিন </td>
                                                    <td>
                                                       <label class="kt-checkbox kt-checkbox--success">
                                                            <input type="checkbox">
                                                            <span></span>
                                                       </label>
                                                    </td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <button class="btn btn-primary btn-square" type="submit">সংরক্ষণ</button>
                                </div>         
                                <div class="form-group pl-2">
                                    <button class="btn btn-primary btn-danger" type="submit">বাতিল</button>
                                </div>                       
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            <!--End::Row-->

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
