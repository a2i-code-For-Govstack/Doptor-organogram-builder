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
                        <h3 class="text-info  my-1 mr-5">শাখার নাম দৃশ্যমান সেটিং</h3>

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
                    <div class="card custom-card rounded-0 shadow-sm">
                        <div class="card-body">
                            <div class="alert alert-secondary  fade show" role="alert">
                                <div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
                                <div class="alert-text"> <h4>নিম্নোক্ত ব্যবহারকারীগণকে পত্রজারিতে নির্বাচন করলে অথবা লগইন অবস্থায় টপবারে শাখা দেখাবে কি দেখাবে না সেই সিদ্ধান্ত নিতে পারেন নিম্নের তালিকার সাহায্যে <b>(অফিস প্রধানের জন্য শাখা দেখাবে না)</b>।</h4> </div>
                            </div>
                            <div class="row mt-3">
                             <div class="table-responsive">
                             <form>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">পদবি</th>
                                            <th class="text-center">কার্যক্রম</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($organograms as $organogram)
                                        @if(@$organogram->assigned_user)
                                        <tr>
                                            <td>{{@$organogram->assigned_user->employee_record->name_bng}},{{@$organogram->designation_bng}},{{@$organogram->office_unit->unit_name_bng}}</td>
                                            <td>
                                                <span class="kt-switch kt-switch--icon">
                                                    <label>
                                                        <input class="show_unit" type="checkbox" data-id="{{@$organogram->assigned_user->id}}" value="{{@$organogram->assigned_user->show_unit}}" <?php if(@$organogram->office_unit->show_unit == '1'){echo 'checked';} ?>  name="show_unit[]">
                                                        <span></span>
                                                    </label>
                                                </span>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
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
    <!-- begin::Scrolltop -->
    <div id="kt_scrolltop" class="kt-scrolltop">
        <i class="fa fa-arrow-up"></i>
    </div>

    <script type="text/javascript">

        $(".show_unit").click(function(){

         var employee_office_id = $(this).attr('data-id');
         var show_unit = $(this).val();
         // alert(show_unit);
            if (show_unit == 1) {
                $(this).val(0);
            }else if(show_unit == 0){
             $(this).val(1);
         }

        $.ajax({
            method: 'POST',
            url: "office_section_visibility_update",
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {employee_office_id:employee_office_id,show_unit:show_unit}, // pass in json format
            success: function(data) {
                if (data.status === 'success') {
                    toastr.success(data.msg);
                }
                location.reload();
            },
            error : function(data){
                var errors = data.responseJSON;
                $.each(errors.errors,function (k,v) {
                    toastr.error(v);
                });
            }
        });
    });


        $(".edit_button").click(function () {
            var data = new FormData($('#edit_form')[0]);
            var id = $('[name=id]').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "office_employee_designation_update",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data, textStatus, jqXHR) {
                }
            }).done(function () {
                toastr.success('সফলভাবে হালনাগাদ হয়েছে।');
                location.reload();
            }).fail(function (data, textStatus, jqXHR) {
                toastr.error('Enternal Server Error');
            });
        });
    </script>
@endsection
