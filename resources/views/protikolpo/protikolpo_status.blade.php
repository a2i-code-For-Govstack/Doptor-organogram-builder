@extends('master')
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border"
         id="kt_content">
        <!--begin::Subheader-->
        <div
            class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"
            id="kt_subheader">

            <div class="ml-3"></div>
            <div>
                <h3 class="text-white my-1">প্রতিকল্প অবস্থা তালিকা</h3>
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
                        <div class="card-body">
                            <div class="row mt-3">
                                <table
                                    class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border tapp_table">
                                    <thead class="table-head-color">
                                    <tr class="text-center">
                                        <th width="20%">পদবি</th>
                                        <th width="20%">প্রতিকল্পকৃত পদবি</th>
                                        <th width="10%">প্রতিকল্পকারি ব্যক্তি</th>
                                        <th width="10%">প্রতিকল্পকৃত ব্যক্তি</th>
                                        <th width="10%">ছুটি শুরু</th>
                                        <th width="10%">ছুটি শেষ</th>
                                        <th width="10%" class="no-sort">কার্যক্রম</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($protikolpo_obosta as $protikolpo)
                                        <tr>
                                            <input type="hidden"
                                                   id="office_unit_organogram_id_{{$protikolpo['protikolpo_id']}}"
                                                   name="" value="{{$protikolpo['office_unit_organogram_id']}}">

                                            <input type="hidden" id="active_status_{{$protikolpo['protikolpo_id']}}"
                                                   name="" value="{{$protikolpo['active_status']}}">

                                            <td>{{$protikolpo['designation']}}, {{$protikolpo['unit_name_bn']}}
                                                ,{{$protikolpo['office_name_bn']}}</td>
                                            <td>@if($protikolpo['protikolpo_name'])
                                                    {{$protikolpo['protikolpo_name']}}
                                                    ,{{$protikolpo['protikolpo_office_unit']}}
                                                @endif</td>
                                            <td>{{$protikolpo['employee_office_id_from_name']}}</td>
                                            <td>{{$protikolpo['employee_office_id_to_name']}}</td>
                                            <td>
                                                @if($protikolpo['protikolpo_name'])
                                                    @if($protikolpo['active_status'] == 1)
                                                        {{date('d-m-Y',strtotime($protikolpo['protikolpo_start_date']))}}
                                                    @else
                                                        <input id="start_date_{{$protikolpo['protikolpo_id']}}"
                                                               class="form-control protikolpo_start_date date"
                                                               type="text" name="" autocomplete="off"
                                                               value="@if($protikolpo['protikolpo_start_date']) {{date('d-m-Y',strtotime($protikolpo['protikolpo_start_date']))}} @endif">
                                                    @endif
                                                @endif

                                            </td>
                                            <td>
                                                @if($protikolpo['protikolpo_name'])
                                                    <input id="end_date_{{$protikolpo['protikolpo_id']}}"
                                                           class="form-control protikolpo_start_date date" type="text"
                                                           name="" autocomplete="off"
                                                           value="{{$protikolpo['protikolpo_end_date'] ? date('d-m-Y',strtotime($protikolpo['protikolpo_end_date'])):''}}">
                                                @endif
                                            </td>
                                            <td>
                                                @if($protikolpo['protikolpo_name'])
                                                    <div class="btn-group">
                                                        <button style="height: 30px;width: 30px;" type="button"
                                                                data-id="{{$protikolpo['protikolpo_id']}}"
                                                                class="btn  btn-icon  btn-outline-brand edit_protikolpo">
                                                            <i class="fas fa-save"></i></button>
                                                        @if($protikolpo['active_status'] != 1)
                                                            <button style="height: 30px;width: 30px;" type="button"
                                                                    title="প্রয়োগ করুন"
                                                                    data-id="{{$protikolpo['protikolpo_id']}}"
                                                                    class="btn  btn-icon  btn-outline-warning active_protikolpo">
                                                                <i class="fas fa-random"></i></button>
                                                        @endif
                                                        <button style="height: 30px;width: 30px;" type="button"
                                                                data-id="{{$protikolpo['protikolpo_id']}}"
                                                                class="btn  btn-icon  btn-outline-danger cancel_protikolpo">
                                                            <i class="fas fa-trash-alt"></i></button>
                                                    </div>
                                                @else
                                                    <a href="{{ url('protikolpo_management') }}"
                                                       style="height: 30px;width: 30px;" type="button"
                                                       data-id="{{$protikolpo['protikolpo_id']}}"
                                                       class="btn  btn-icon  btn-outline-brand"><i
                                                            class="fas fa-save"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="kt_scrolltop" class="kt-scrolltop">
        <i class="fa fa-arrow-up"></i>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            tapp_table_init()
        });

        $(".edit_protikolpo").click(function () {
            var protikolpo_id = $(this).data('id');
            swal.fire({
                title: 'আপনি কি তথ্যটি সম্পাদনা করতে চান?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'হ্যাঁ',
                cancelButtonText: 'না'
            }).then(function (result) {
                if (result.value) {
                    var start_date = $('#start_date_' + protikolpo_id).val();
                    var end_date = $('#end_date_' + protikolpo_id).val();
                    var office_unit_organogram_id = $('#office_unit_organogram_id_' + protikolpo_id).val();

                    var data = {
                        protikolpo_id: protikolpo_id,
                        start_date: start_date,
                        end_date: end_date,
                        office_unit_organogram_id: office_unit_organogram_id
                    };
                    var datatype = 'json';
                    var url = '{{url('update_protikolpo')}}'

                    ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseData) {
                        if (responseData.status === 'success') {
                            toastr.success(responseData.msg);
                        } else {
                            toastr.error(responseData.msg);
                        }
                    });
                }
            });
        });

        $(".cancel_protikolpo").click(function () {
            var protikolpo_id = $(this).data('id');
            swal.fire({
                title: 'আপনি কি প্রতিকল্প বাতিল করতে চান?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'হ্যাঁ',
                cancelButtonText: 'না'
            }).then(function (result) {
                if (result.value) {
                    var data = {protikolpo_id: protikolpo_id};
                    var datatype = 'json';
                    var url = '{{url('cancel_protikolpo')}}'

                    ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseData) {
                        if (responseData.status === 'success') {
                            toastr.success(responseData.msg);
                            setTimeout(function () {
                                location.reload();
                            }, 500);
                        } else {
                            toastr.error(responseData.msg);
                        }
                    });
                }
            });
        });

        $(".active_protikolpo").click(function () {
            protikolpo_id = $(this).data('id');
            swal.fire({
                title: 'আপনি কি প্রতিকল্প প্রয়োগ করতে চান?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'হ্যাঁ',
                cancelButtonText: 'না'
            }).then(function (result) {
                if (result.value) {
                    var strat_date = $('#start_date_' + protikolpo_id).val();
                    var end_date = $('#end_date_' + protikolpo_id).val();
                    var data = {protikolpo_id: protikolpo_id, date: strat_date};
                    var datatype = 'json';
                    var url = '{{url('active_protikolpo')}}'

                    ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseData) {
                        if (responseData.status === 'success') {
                            toastr.success(responseData.msg);
                            if (responseData.need_to_logout == true) {
                                document.getElementById('logout-form').submit();
                            } else {
                                window.location.reload();
                            }
                        } else {
                            toastr.error(responseData.msg);
                        }
                    });
                }
            });
        });

        $('.protikolpo_start_date').datepicker(
            {
                format: 'dd-mm-yyyy',
                startDate: '{{date('d-m-Y')}}',
                autoClose: true,
            }
        )
        $('.protikolpo_end_date').datepicker(
            {
                format: 'dd-mm-yyyy',
                startDate: '{{date('d-m-Y')}}',
                autoClose: true,
            }
        )
    </script>
@endsection
