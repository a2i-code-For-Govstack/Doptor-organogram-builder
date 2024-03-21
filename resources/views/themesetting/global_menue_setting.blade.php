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
                        <h5 class="text-info  my-1 mr-5">গ্লোবাল সেটিংস</h5>

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
                               <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="office_ministry_id">Group ID </label>
                                            <select id="office_ministry_id" class="form-control rounded-0 select-select2"
                                            name="office_ministry_id">
                                            <option value="" selected="selected">----বাছাই করুন----</option>
                                        </select>
                                    </div>
                                </div>   
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <button class="btn btn-primary btn-square" type="submit" style="margin-top: 28px">অনুসন্ধান</button>
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
                                            <thead>
          
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Group</th>
                                                    <th>Value</th>
                                                    <th>Comments </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Captcha Enabled in Login </td>
                                                    <td> 
                                                            <select style="width: 100%" id="group1" class="form-control rounded-0 select-select2"
                                                            name="group1">
                                                            <option value="" selected="selected">----বাছাই করুন----</option>
                                                            </select>
                                                    </td>
                                                    <td>

                                                            <input id="username" class="form-control rounded-0" type="text" name="username">
                                                    </td>
                                                    <td>
                                                            <input id="username" class="form-control rounded-0" type="text" name="username">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Captcha Enabled in Login </td>
                                                    <td> 
                                                            <select style="width: 100%" id="group2" class="form-control rounded-0 select-select2"
                                                            name="group2">
                                                            <option value="" selected="selected">----বাছাই করুন----</option>
                                                            </select>
                                                    </td>
                                                    <td>

                                                            <input id="username" class="form-control rounded-0" type="text" name="username">
                                                    </td>
                                                    <td>
                                                            <input id="username" class="form-control rounded-0" type="text" name="username">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Captcha Enabled in Login </td>
                                                    <td> 
                                                            <select style="width: 100%" id="group3" class="form-control rounded-0 select-select2"
                                                            name="group3">
                                                            <option value="" selected="selected">----বাছাই করুন----</option>
                                                            </select>
                                                    </td>
                                                    <td>

                                                            <input id="username" class="form-control rounded-0" type="text" name="username">
                                                    </td>
                                                    <td>
                                                            <input id="username" class="form-control rounded-0" type="text" name="username">
                                                    </td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <button class="btn btn-primary btn-square" type="submit" style="margin-top: 28px">Update</button>
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
