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
                        <h5 class="text-info  my-1 mr-5"> Role Management </h5>

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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="office_ministry_id">অফিস মন্ত্রণালয়</label>
                                        <select id="office_ministry_id" class="form-control rounded-0 select-select2"
                                                name="office_ministry_id">
                                            <option value="" selected="selected">----বাছাই করুন----</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="office_layer_id">মন্ত্রণালয়/বিভাগ</label>
                                        <select name="office_layer" id="office_layer_id"
                                                class="form-control rounded-0 select-select2">
                                            <option value="0">--বাছাই করুন--</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="office_origin_id">দপ্তর / অধিদপ্তরের ধরন</label>
                                        <select name="office_origin" id="office_origin_id"
                                                class="form-control rounded-0 select-select2">
                                            <option value="0">--বাছাই করুন--</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="office_id">অফিস</label>
                                        <select id="office_id" class="form-control rounded-0 select-select2"
                                                name="office_id">
                                            <option value="0">--বাছাই করুন--</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            
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
                                            <tbody>
                                                <tr>
                                                    <td>মহামান্য রাষ্ট্রপতি</td>
                                                    <td>
                                                        <div class="kt-checkbox-list">

                                                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                <input id="status" name="status" type="checkbox" value="0"> TestT 
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="kt-checkbox-list">

                                                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                <input id="status" name="status" type="checkbox" value="0"> TestT 
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="kt-checkbox-list">

                                                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                <input id="status" name="status" type="checkbox" value="0"> TestT 
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="kt-checkbox-list">

                                                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                <input id="status" name="status" type="checkbox" value="0"> TestT 
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="kt-checkbox-list">

                                                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                <input id="status" name="status" type="checkbox" value="0"> TestT 
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="kt-checkbox-list">

                                                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                <input id="status" name="status" type="checkbox" value="0"> TestT 
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="kt-checkbox-list">

                                                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                <input id="status" name="status" type="checkbox" value="0"> TestT 
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="kt-checkbox-list">

                                                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                <input id="status" name="status" type="checkbox" value="0"> TestT 
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>মহামান্য রাষ্ট্রপতি</td>
                                                    <td>
                                                        <div class="kt-checkbox-list">

                                                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                <input id="status" name="status" type="checkbox" value="0"> TestT 
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="kt-checkbox-list">

                                                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                <input id="status" name="status" type="checkbox" value="0"> TestT 
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="kt-checkbox-list">

                                                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                <input id="status" name="status" type="checkbox" value="0"> TestT 
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="kt-checkbox-list">

                                                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                <input id="status" name="status" type="checkbox" value="0"> TestT 
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="kt-checkbox-list">

                                                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                <input id="status" name="status" type="checkbox" value="0"> TestT 
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="kt-checkbox-list">

                                                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                <input id="status" name="status" type="checkbox" value="0"> TestT 
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="kt-checkbox-list">

                                                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                <input id="status" name="status" type="checkbox" value="0"> TestT 
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="kt-checkbox-list">

                                                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                <input id="status" name="status" type="checkbox" value="0"> TestT 
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>মহামান্য রাষ্ট্রপতি</td>
                                                    <td>
                                                        <div class="kt-checkbox-list">

                                                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                <input id="status" name="status" type="checkbox" value="0"> TestT 
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="kt-checkbox-list">

                                                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                <input id="status" name="status" type="checkbox" value="0"> TestT 
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="kt-checkbox-list">

                                                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                <input id="status" name="status" type="checkbox" value="0"> TestT 
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="kt-checkbox-list">

                                                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                <input id="status" name="status" type="checkbox" value="0"> TestT 
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="kt-checkbox-list">

                                                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                <input id="status" name="status" type="checkbox" value="0"> TestT 
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="kt-checkbox-list">

                                                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                <input id="status" name="status" type="checkbox" value="0"> TestT 
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="kt-checkbox-list">

                                                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                <input id="status" name="status" type="checkbox" value="0"> TestT 
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="kt-checkbox-list">

                                                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                                <input id="status" name="status" type="checkbox" value="0"> TestT 
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-square" type="submit">সংরক্ষণ</button>
                                    <button class="btn btn-danger btn-square" type="submit">বাতিল</button>
                                </div>
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
