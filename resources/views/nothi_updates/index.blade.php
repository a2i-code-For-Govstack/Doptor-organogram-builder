@extends('master')
@section('content')
     <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border" id="kt_content">
        <!--begin::Subheader-->
        <div class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap" id="kt_subheader">

            <div class="ml-3"></div>
            <div>
                <h3 class="text-white my-1">Nothi new update/release note list</h3>
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
                                    New update/release note
                                </button>
                            </div>
                            <div class="alert alert-secondary  fade show" role="alert">
                                <div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
                                <div class="alert-text"><b>"The release notes can be show on the page"</b> Only those details that are marked in the option will be visible in the release notes page. Each description will be ordered on the release notes page based on release date and version (with the most recent release date and version at the top).</div>
                            </div>
                            <div class="load-table-data" data-href="{{ route('getNothiList') }}">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Add nothi new update/release notes</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('nothiUpdateList.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label><h5>Version Number :</h5></label>
                            <input type="text" class="form-control" placeholder="১ বা ১.১" name="version">
                            <span class="h6 text-danger">* Usually integer or decimal number</span>
                        </div>

                        <div class="form-group">
                            <label><h5>Release Date :</h5></label>
                            <input type="text" class="form-control date" name="release_date" autocomplete="off">
                            <span class="h6 text-danger">* Update release date</span>
                        </div>

                        <div class="form-group">
                            <textarea name="body" class="content"></textarea>
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Edit nothi new update/release notes</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('nothiUpdateList.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="eid">
                        <div class="form-group">
                            <label><h5>Version Number :</h5></label>
                            <input type="text" class="form-control" id="version" placeholder="১ বা ১.১" name="version">
                            <span class="h6 text-danger">* Usually integer or decimal number</span>
                        </div>

                        <div class="form-group">
                            <label><h5>Release Date :</h5></label>
                            <input type="text" class="form-control date" id="release_date" name="release_date" autocomplete="off">
                            <span class="h6 text-danger">* Update release date</span>
                        </div>

                        <div class="form-group">
                            <textarea name="body" id="body" class="content"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Nothi New update/release notes details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body" id="Nothi_data">

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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}" type="text/javascript"></script>
    <script type="text/javascript">

        $(function () {
            if ($(".load-table-data").length > 0) {
                loadData();
            }
        });

        function loadData(url = '') {
            if (url === '') {
                url = $(".load-table-data").data('href');
            }
            var data = {};
            var datatype = 'html';
            ajaxCallAsyncCallback(url, data, datatype, 'GET', function (responseDate) {
                $(".load-table-data").html(responseDate);
            });
        }

        function loadView(url) {
            $('#view').modal('show');
            ajaxCallUnsyncCallback(url, 'data', 'html', 'GET', function (responseDate) {
                $("#Nothi_data").html(responseDate);
            });
        }

        function loadEdit(url) {
            $('#edit').modal('show');
            ajaxCallUnsyncCallback(url, 'data', 'json', 'GET', function (responseDate) {
                $("#eid").val(responseDate.id);
                $("#version").val(responseDate.version);
                $("#release_date").val(responseDate.release_date);
                appEditor.setData(responseDate.body)
            });
        }

        function deleted(url)
        {
            $.confirm({
                title: 'Are You sure?',
                content: ' ',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: 'Cancel',
                        btnClass: 'btn-red',
                        action: function(){
                            window.location.href = url
                        }
                    },
                    close: {
                        text: "no"
                    }
                }
            });
        }

        function changeStatus(url)
        {
            $.confirm({
                title: 'Are You sure?',
                content: ' ',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: '"The release notes can be show on the page"',
                        btnClass: 'btn-green',
                        action: function(){
                            window.location.href = url
                        }
                    },
                    close: {
                        text: "No"
                    }
                }
            });
        }


        // $(document).on('click', "ul.pagination>li>a", function (e) {
        //     e.preventDefault();
        //     loadData($(this).attr('href'));
        // });

        $('.date').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
        let appEditor;
        var allEditors = document.querySelectorAll('.content');
        for (var i = 0; i < allEditors.length; ++i) {
            ClassicEditor.create(allEditors[i])
            .then( editor => {
                 appEditor = editor;
            } )
            .catch( error => {
                console.error( error );
            } );
        }

        @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: '{{ session('success') }}',
            text: ''
        });
        @endif

        @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: '{{ session('error') }}',
            text: ''
        });
        @endif

        @if ($errors->any())
        @php
        $str = "";
        @endphp
        @foreach ($errors->all() as $error)
            @php
            $str .= $error. "\r\n";
            @endphp
        @endforeach
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: `{{ $str }}`
        });
        @endif
    </script>
@endsection


