@extends('master')
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border"
        id="kt_content">
        <!--begin::Subheader-->
        <div class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"
            id="kt_subheader">

            <div class="ml-3"></div>
            <div>
                <h3 class="text-white my-1">Universal message</h3>
            </div>
            <div class="mr-3 d-flex"></div>
        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">

            <!--Begin::Dashboard 1-->

            <!--Begin::Row-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card round-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#create">
                                    Submit a new message
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Sl.</th>
                                            <th class="text-center">Heading</th>
                                            <th class="text-center">Message</th>
                                            <th class="text-center">Recipient</th>
                                            <th class="text-center">Sender</th>
                                            <th class="text-center">Sending Date</th>
                                            <th class="text-center">Activity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($msgs as $key => $msg)
                                            <tr>
                                                <td class="text-center"> {{ enTobn($key + 1) }} </td>
                                                <td class="text-center text-truncate" style="max-width: 150px;">
                                                    {{ $msg->title }} </td>
                                                <td class="text-center"> <button type="button"
                                                        onclick="loadView('{{ route('globalMessages.show', $msg->id) }}')"
                                                        class="btn btn-info"><i class="fas fa-eye"></i></button> </td>
                                                <td class="text-center">
                                                    @php
                                                        if ($msg->message_for == 'all') {
                                                            $for = 'সবাই';
                                                        } elseif ($msg->message_for == 'layer') {
                                                            $for = 'লেয়ার ভিত্তিক';
                                                        } elseif ($msg->message_for == 'office') {
                                                            $for = 'অফিস ভিত্তিক';
                                                        } elseif ($msg->message_for == 'unit') {
                                                            $for = 'শাখা ভিত্তিক';
                                                        } elseif ($msg->message_for == 'organogram') {
                                                            $for = 'পদবি ভিত্তিক';
                                                        } elseif ($msg->message_for == 'office_origin') {
                                                            $for = 'মৌলিক অফিস ভিত্তিক';
                                                        } elseif ($msg->message_for == 'office_layer') {
                                                            $for = 'অফিসের লেয়ার ভিত্তিক';
                                                        } elseif ($msg->message_for == 'office_ministry') {
                                                            $for = 'মন্ত্রনালয় ভিত্তিক';
                                                        }
                                                    @endphp
                                                    {{ $for }}
                                                </td>
                                                <td class="text-center">
                                                    {{ App\Models\Message::userName($msg->message_by) }} </td>
                                                <td class="text-center"> {{ dateEnToBn($msg->created) }} </td>
                                                <td class="text-center">
                                                    <button type="button" data-dismiss="modal"
                                                        onclick="deleted('{{ route('globalMessages.destroy', $msg->id) }}')"
                                                        class="btn btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="ajaxPagination float-right">
                                    {{ $msgs->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel"> New Message</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('globalMessages.store') }}" method="POST">
                        @csrf

                        <div class="kt-portlet" style="box-shadow: 0px 0px 0px 0px rgb(82 63 105 / 5%);">
                            <div class="kt-portlet__head" style="padding: 0 !important; border-bottom: 0px !important;">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title">
                                        Recipient selection
                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body" style="padding: 0 !important;">
                                <ul class="nav nav-tabs  nav-tabs-line nav-tabs-line-2x nav-tabs-line-success"
                                    role="tablist">
                                    @if (Auth::user()->user_role_id != config('menu_role_map.user'))
                                        <li class="nav-item">
                                            <a style="border-top: 0px;" class="nav-link active" data-toggle="tab"
                                                href="#layer_1" role="tab"><b>Layer Wise</b></a>
                                        </li>

                                        <li class="nav-item">
                                            <a style="border-top: 0px;" class="nav-link" data-toggle="tab" href="#layer_2"
                                                role="tab"><b>Ministry/Doptor Wise</b></a>
                                        </li>
                                    @else
                                        <li class="nav-item">
                                            <a style="border-top: 0px;" class="nav-link active" data-toggle="tab"
                                                href="#layer_1" role="tab"><b>All</b></a>
                                        </li>

                                        <li class="nav-item">
                                            <a id="office_selection" style="border-top: 0px;" class="nav-link"
                                                data-toggle="tab" href="#layer_3" role="tab"><b>Doptor Wise</b></a>
                                        </li>
                                    @endif
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="layer_1" role="tabpanel">
                                        <div class="form-group row">
                                            @if (Auth::user()->user_role_id != config('menu_role_map.user'))
                                                <label class="col-form-label col-lg-1 col-sm-12">
                                                    <h5>Layer</h5>
                                                </label>

                                                <div class="col-lg-4">
                                                    <select class="form-control kt-select2 select2" name="layer_level">
                                                        <option value="" selected>--Choose--</option>
                                                        <option value="1">Ministry</option>
                                                        <option value="2">Odhidoptor / Poridoptor</option>
                                                        <option value="3">Doptor/Institution</option>
                                                        <option value="4">Department</option>
                                                        <option value="5">Zila</option>
                                                        <option value="6">Upazila</option>
                                                    </select>
                                                </div>
                                                <label class="col-form-label col-lg-1 col-sm-12">
                                                    <h5>Or</h5>
                                                </label>
                                            @endif
                                            <label class="col-form-label col-lg-3 col-sm-12">
                                                <h5>All users</h5>
                                            </label>
                                            <div class="col-2">
                                                <span
                                                    class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                                    <label>
                                                        <input type="checkbox" value="all" name="message_for">
                                                        <span></span>
                                                    </label>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="layer_2" role="tabpanel">
                                        <x-office-select grid="3" unit="true" only_office="false"
                                            organogram="true"></x-office-select>
                                    </div>
                                    @if (Auth::user()->user_role_id == config('menu_role_map.user'))
                                        <div class="tab-pane" id="layer_3" role="tabpanel">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="office_selected">Office</label>
                                                    <select name="office_selected" id="office_selected"
                                                        class="form-control rounded-0 select-select2" disabled>
                                                        <option id="selected_office_id"
                                                            value="{{ Auth::user()->current_office_id() }}" selected
                                                            disabled>
                                                            {{ Auth::user()->current_designation->office_name_bn }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="office_unit_id">Branch</label>
                                                    <select multiple="multiple" name="unit_select[]" id="unit_select"
                                                        class="form-control rounded-0 select-select2">
                                                        <option value="">--Choose--</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="office_organogram_id">Designation</label>
                                                    <select multiple="multiple" name="office_organogram_id[]"
                                                        id="office_organogram_id"
                                                        class="form-control rounded-0 select-select2">
                                                        <option value="">--Choose--</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>
                                <h5>Heading</h5>
                            </label><span class="text-danger">*</span>
                            <input id="title" type="text" class="form-control" name="title"
                                autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label>
                                <h5>Message</h5>
                            </label><span class="text-danger">*</span>
                            <textarea name="message" class="form-control" id="message" rows="5" onkeyup="stoppedTyping()"></textarea>
                        </div>


                </div>
                <div class="modal-footer">
                    <button id="send_button" type="submit" class="btn btn-primary" disabled>Send Message</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-weight-bold" id="title_data">Message Description</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body" id="msg_data">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>


    <!-- begin::Scrolltop -->
    <div id="kt_scrolltop" class="kt-scrolltop">
        <i class="fa fa-arrow-up"></i>
    </div>

    <!-- end::Scrolltop -->
@endsection
@section('css')
    <style>
        .form-group {
            margin-bottom: 0rem !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $("#office_selection").click(function() {
            var office_id = $("#selected_office_id").val();
            officeUnit(office_id);
        });

        function officeUnit(office_id) {
            var url = 'get_unit_list';
            var data = {
                office_id
            };
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function(responseData) {
                $("#unit_select").html(responseData);
            });
        }

        $("select#unit_select").change(function() {
            var unit_id = $(this).children("option:selected").map(function(i, el) {
                return $(el).val();
            }).get();
            var last_org_id = $("#office_organogram_id").children("option:selected").map(function(i, el) {
                return $(el).val();
            }).get();
            officeOrganogramlist(unit_id, last_org_id);
        });

        function officeOrganogramlist(unit_id, last_org_id) {
            var url = 'get_unit_organogram_list';
            var data = {
                unit_id
            };
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function(responseData) {
                $("#office_organogram_id").html(responseData);
                $.each(last_org_id, function(i,e){
                    $("#office_organogram_id option[value='" + e + "']").prop("selected", true);
                });
            });
        }

        $('.select2').select2({
            width: '100%'
        });

        $(function() {
            if ($(".load-table-data").length > 0) {
                loadData();
            }
        });

        function loadView(url) {
            $('#view').modal('show');
            ajaxCallAsyncCallback(url, 'data', 'json', 'GET', function(responseData) {
                $("#title_data").text(responseData.title);
                $("#msg_data").html(responseData.msg);
            });
        }

        function deleted(url) {
            $.confirm({
                title: 'Are you Sure?',
                content: 'Do you want to delete the message?',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: 'Yes',
                        btnClass: 'btn-red',
                        action: function() {
                            $.ajax({
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    _method: 'DELETE',
                                    _token: '{{ csrf_token() }}'
                                },
                                url: url,
                                success: function(data) {
                                    Swal.fire({
                                        title: 'Message delete successfully!',
                                        text: "",
                                        icon: 'success',
                                        allowOutsideClick: false,
                                        // confirmButtonText: 'বাতিল করুন'
                                        showConfirmButton: false,
                                        timer: 3000
                                    }).then((result) => {
                                        location.reload();
                                    })
                                }
                            });
                        }
                    },
                    close: {
                        text: "No"
                    }
                }
            });
        }

        $('#message_office_ministry_id').on('change', function() {
            ajaxCallAsyncCallback('{{ route('loadLayersByMinistry') }}' + '/' + this.value, '', 'json', 'GET',
                function(responseDate) {
                    var data = responseDate.layers;
                    var options = `<option value="" selected>--Choose--</option>`;

                    for (var i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].id + '">' + data[i].layer_name_bng + '</option>';
                    }

                    $('#message_office_layer_id').html(options);

                });
        });

        $('#message_office_layer_id').on('change', function() {
            var ministry = $("#message_office_ministry_id").val();
            ajaxCallAsyncCallback('{{ route('loadOfficesByMinistryAndLayer') }}' + '/' + ministry + '/' + this
                .value, '', 'json', 'GET',
                function(responseDate) {
                    var data = responseDate.offices;
                    var options = `<option value="" selected>--Choose--</option>`;

                    for (var i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].id + '">' + data[i].name_bng + '</option>';
                    }

                    $('#message_office_origin_id').html(options);

                });
        });

        $('#message_office_origin_id').on('change', function() {

            ajaxCallAsyncCallback('{{ route('loadOriginOffices') }}' + '/' + this.value, '', 'json', 'GET',
                function(responseDate) {
                    var data = responseDate.origin;
                    var options = `<option value="" selected>--Choose--</option>`;

                    for (var i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].id + '">' + data[i].unit_name_bng + '</option>';
                    }

                    $('#message_office_id').html(options);

                });
        });

        $('#message_office_id').on('change', function() {

            ajaxCallAsyncCallback('{{ route('loadOfficeUnits') }}' + '/' + this.value, '', 'json', 'GET', function(
                responseDate) {
                var data = responseDate.unit;
                var options = `<option value="" selected>--Choose--</option>`;

                for (var i = 0; i < data.length; i++) {
                    options += '<option value="' + data[i].id + '">' + data[i].unit_name_bng + '</option>';
                }

                $('#message_office_unit_id').html(options);

            });
        });


        $('#message_office_unit_id').on('change', function() {

            ajaxCallAsyncCallback('{{ route('loadOfficeUnitOrganograms') }}' + '/' + this.value, '', 'json', 'GET',
                function(responseDate) {
                    var data = responseDate.units;
                    var options = `<option value="" selected>--Choose--</option>`;

                    for (var i = 0; i < data.length; i++) {
                        options += '<option title_id="' + data[i].title_id + '" title="' + data[i].title +
                            '" value="' + data[i].id + '">' + data[i].designation + '</option>';
                    }

                    $('#message_office_unit_organogram_id').html(options);

                });
        });

        $('#message_office_unit_organogram_id').on('change', function() {
            $("#officer_id").val($(this).find("option:selected").attr("title_id"));
            $("#officer_name").val($(this).find("option:selected").attr("title"));
        });


        function loadData(url = '') {
            if (url === '') {
                url = $(".load-table-data").data('href');
            }
            var data = {};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function(responseDate) {
                $(".load-table-data").html(responseDate);
            });
        }

        // $(document).on('click', "ul.pagination>li>a", function (e) {
        //     e.preventDefault();
        //     loadData($(this).attr('href'));
        // });

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                text: '',
                showConfirmButton: false,
                timer: 3000 
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: '{{ session('error') }}',
                text: '',
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        @if ($errors->any())
            @php
                $str = '';
            @endphp
            @foreach ($errors->all() as $error)
                @php
                    $str .= $error . "\r\n";
                @endphp
            @endforeach
            Swal.fire({
                icon: 'error',
                title: 'Sorry',
                html: `{{ $str }}`
            });
        @endif

        function stoppedTyping() {
            if (document.getElementById("message").value === "") {
                document.getElementById("send_button").disabled = true;
            } else {
                document.getElementById("send_button").disabled = false;
            }
        }
    </script>
@endsection
