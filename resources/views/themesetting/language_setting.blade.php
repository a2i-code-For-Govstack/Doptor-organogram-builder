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
                        <h5 class="text-info  my-1 mr-5">ভাষা সেটিংস</h5>

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
                                            <label for="office_ministry_id">Menu</label>
                                            <select id="office_ministry_id" class="form-control rounded-0 select-select2"
                                            name="office_ministry_id">
                                            <option value="" selected="selected">----বাছাই করুন----</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label for="username">English Text</label>
                                        <input id="username" class="form-control rounded-0" type="text" name="username">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label for="username">Bangla Text </label>
                                        <input id="username" class="form-control rounded-0" type="text" name="username">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label for="username">Constant Prefix</label>
                                        <input id="username" class="form-control rounded-0" type="text" name="username">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label for="username">Constant</label>
                                        <input id="username" class="form-control rounded-0" type="text" name="username">
                                    </div>
                                </div>
                                <div class="col-md-6" style="margin-top: 25px">
                                    <button class="btn btn-primary btn-square" type="submit">অনুসন্ধান</button>
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
                                                    <th>Menu Name</th>
                                                    <th>English Text </th>
                                                    <th>Bangla Text</th>
                                                    <th>ConstantPrefix </th>
                                                    <th>Constant </th>
                                                    <th>Delete </th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Global Invisible</td>
                                                    <td><input id="username" class="form-control rounded-0" type="text" name="username"></td>
                                                    <td><input id="username" class="form-control rounded-0" type="text" name="username"></td>
                                                    <td><input id="username" class="form-control rounded-0" type="text" name="username"></td>
                                                    <td><input id="username" class="form-control rounded-0" type="text" name="username"></td>
                                                    <td><input id="username" class="form-control rounded-0" type="checkbox" name="username"></td>
                                                </tr>

                                            </tbody>
                                        </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                    <div class="form-group">
                        <button class="btn btn-primary btn-square" type="submit" style="margin-top: 28px">Update</button>
                    </div>
                    <div class="form-group pl-2">
                        <button class="btn btn-danger btn-square" type="submit" style="margin-top: 28px">cancel</button>
                    </div>
            </div>

             <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card custom-card rounded-0 shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0">New Text</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                   <div class="form-group">
                                            <label for="office_ministry_id">Menu</label>
                                            <select id="office_ministry_id" class="form-control rounded-0 select-select2"
                                            name="office_ministry_id">
                                            <option value="" selected="selected">----বাছাই করুন----</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label for="username">English Text</label>
                                        <input id="username" class="form-control rounded-0" type="text" name="username">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label for="username">Bangla Text </label>
                                        <input id="username" class="form-control rounded-0" type="text" name="username">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label for="username">Constant Prefix</label>
                                        <input id="username" class="form-control rounded-0" type="text" name="username">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label for="username">Constant</label>
                                        <input id="username" class="form-control rounded-0" type="text" name="username">
                                    </div>
                                </div>
                                <div class="col-md-6" style="margin-top: 25px">
                                    <button class="btn btn-primary btn-square" type="submit">সংরক্ষণ</button>
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
