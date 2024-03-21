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
                        <h5 class="text-info  my-1 mr-5">যোগ করুন </h5>

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
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card custom-card rounded-0 shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                   <div class="form-group">
                                        <label for="username"> থিম নাম </label>
                                        <input id="username" class="form-control rounded-0" type="text" name="username">
                                    </div>
                                </div>                           
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                   <div class="form-group">
                                        <label for="username">ডিরেক্টরী </label>
                                        <input id="username" class="form-control rounded-0" type="text" name="username">
                                    </div>
                                </div>                                
                            </div>
                            <div class="row"> 
                                <div class="col-md-2">
                                   <div class="form-group">
                                    <div class="kt-checkbox-list">
                                        
                                        <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                            <input id="status" name="status" type="checkbox" value="0"> অজানা 
                                            <span></span>
                                        </label>
                                    </div>
                                    </div>
                                </div> 
                                                               
                            </div>
                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary btn-square" type="submit">সংরক্ষণ</button>
                                </div>
                                <div class="d-flex justify-content-end pl-2">
                                    <button class="btn btn-danger btn-square" type="submit">বাতিল
                                    </button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- end:: Content -->
    </div>


    <!-- end::Form Quick Panel -->

    <!-- begin::Scrolltop -->
    <div id="kt_scrolltop" class="kt-scrolltop">
        <i class="fa fa-arrow-up"></i>
    </div>
@endsection
