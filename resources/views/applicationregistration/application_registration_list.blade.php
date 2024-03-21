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
                        <h5 class="text-info  my-1 mr-5">নিবন্ধিত তালিকা</h5>

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
                                        <label for="username">এপ্লিকেশন নাম</label>
                                        <input id="username" class="form-control rounded-0" type="text" name="username">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                   <div class="form-group">
                                        <label for="username">এপ্লিকেশন নাম (বংলা)</label>
                                        <input id="username" class="form-control rounded-0" type="text" name="username">
                                    </div>
                                </div> 
                                <div class="col-md-4">
                                   <div class="form-group">
                                        <label for="username">ইউআরএল</label>
                                        <input id="username" class="form-control rounded-0" type="text" name="username">
                                    </div>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                   <div class="form-group">
                                        <label for="username">রিডায়রেক্ট ইউআরএল </label>
                                        <input id="username" class="form-control rounded-0" type="text" name="username">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                   <div class="form-group">
                                        <label for="username">ডিফল্ট পেজ</label>
                                        <input id="username" class="form-control rounded-0" type="text" name="username">
                                    </div>
                                </div> 
                                <div class="col-md-4">
                                   <div class="form-group">
                                        <label for="username">লগ-আউট লিঙ্ক</label>
                                        <input id="username" class="form-control rounded-0" type="text" name="username">
                                    </div>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                   <div class="form-group">
                                        <label for="username">মোবাইল</label>
                                        <input id="username" class="form-control rounded-0" type="text" name="username">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                   <div class="form-group">
                                        <label for="username">অনুমোদিত</label>
                                        <input id="username" class="form-control rounded-0" type="text" name="username">
                                    </div>
                                </div> 
                                <div class="col-md-4">
                                   <div class="form-group">
                                        <label for="username">ইমেইল</label>
                                        <input id="username" class="form-control rounded-0" type="text" name="username">
                                    </div>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                   <div class="form-group">
                                        <label for="username">প্রকাশিত</label>
                                        <input id="username" class="form-control rounded-0" type="text" name="username">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                   <div class="form-group">
                                        <label for="username">ডিফল্ট পারমিশন</label>
                                        <input id="username" class="form-control rounded-0" type="text" name="username">
                                    </div>
                                </div> 
                                <div class="col-md-4">
                                   <div class="form-group">
                                        <label for="username">এস ওল ও লিঙ্ক</label>
                                        <input id="username" class="form-control rounded-0" type="text" name="username">
                                    </div>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-end">
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
                                                    <th>এপ্লিকেশন নাম</th>
                                                    <th>এপ্লিকেশন নাম (বংলা) </th>
                                                    <th>ইউআরএল</th>
                                                    <th>মোবাইল </th>
                                                    <th>অনুমোদিত </th>
                                                    <th>ইমেইল </th>
                                                    <th>প্রকাশিত </th>
                                                    <th>ডিফল্ট পারমিশন </th>
                                                    <th>এস ওল ও লিঙ্ক </th>
                                                    <th>সম্পাদনা করুন </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><a href="edit_application" class="btn btn-warning btn-icon btn-square"><i class="fas fa-pencil-alt"></i></a></td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
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
