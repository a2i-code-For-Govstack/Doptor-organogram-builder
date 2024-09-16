<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <base href="">
    <meta charset="utf-8"/>
    <title>Organogram Builder</title>
    <meta name="description" content="Updates and statistics">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <!--begin::Layout Skins(used by all pages) -->
    <link href="{{ asset('assets/css/skins/header/base/light.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/skins/header/menu/light.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/skins/brand/dark.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/skins/aside/dark.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/scss/global.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/custom/jstree/jstree.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/dtable/DataTables-1.10.24/css/dataTables.bootstrap4.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="shortcut icon" href="{{ asset('assets/img/bd.png') }}"/>
    @yield('css')
    <!--begin::Global Theme Bundle(used by all pages) -->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/jquery.bangla.js') }}" type="text/javascript"></script>
    <link href="{{ URL::asset('assets/css/jquery-ui.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('assets/js/custom.js?='.time()) }}" type="text/javascript"></script>

    @include('partials.google_analytics')
</head>

<body
    class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

<!-- begin:: Page -->

<!-- begin:: Header Mobile -->
<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
<div class="kt-header-mobile__toolbar">
        <button class="kt-header-mobile__toggler kt-header-mobile__toggler--left"
                id="kt_aside_mobile_toggler"><span></span></button>
        <!--<button class="kt-header-mobile__toggler" id="kt_header_mobile_toggler"><span></span></button>
        <button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i
                class="flaticon-more"></i></button>-->
    </div>
    
    <div class="kt-header-mobile__logo">
        <a href="{{ url('dashboard') }}">
            <img alt="Logo" src="{{ asset('assets/img/ndoptor.svg') }}" style="width:50px;"/>
            <span style="font-size:15px!important;font-weight: bold;color: #5477ea;">N-Doptor</span>
        </a>
    </div>
    @if (Auth::user()->user_role_id == config('menu_role_map.user'))
                        @include('partials.topbar.notification')
                    @endif
                    @include('partials.profile.quick_profile')
</div>

<!-- end:: Header Mobile -->
<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        <div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop"
             id="kt_aside">
            <div class="kt-aside__brand kt-grid__item " id="kt_aside_brand">
                <div style="margin-left: -10px !important;" class="brand-logo m-auto master-brand-logo">
                    <a href="{{ url('dashboard') }}">
                        <img alt="Logo" src="{{ asset('https://mir-s3-cdn-cf.behance.net/projects/404/33a10f193868951.6624bdaeda569.png') }}" style="width:50px;"/>
                        <!--<span style="font-size:20px!important;font-weight: bold;color: #5477ea;">Organogram</span>-->
                    </a>
                </div>
                <div class="kt-aside__brand-tools">
                    <button class="kt-aside__brand-aside-toggler" id="kt_aside_toggler">
                            <span><svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                       viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path
                                            d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z"
                                            fill="#000000" fill-rule="nonzero"
                                            transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) "/>
                                        <path
                                            d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z"
                                            fill="#000000" fill-rule="nonzero" opacity="0.3"
                                            transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) "/>
                                    </g>
                                </svg>
                            </span>
                        <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                     viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path
                                            d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                            fill="#000000" fill-rule="nonzero"/>
                                        <path
                                            d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                            fill="#000000" fill-rule="nonzero" opacity="0.3"
                                            transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
                                    </g>
                                </svg>
                            </span>
                    </button>
                </div>
            </div>
            <div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
                @if (Auth::user()->user_role_id == config('menu_role_map.super_admin'))
                    @include('partials.menu_aside')
                @else
                    @include('partials.menu_aside')
                @endif

            </div>
        </div>

        <!-- end:: Aside -->
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

            <!-- begin:: Header -->
            <div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed " style="align-items: center; justify-content: end;">

                <!--@include('partials.topbar.welcome')-->
                <div class="kt-header__topbar">

                    <!--begin: Notification -->
                    @if (Auth::user()->user_role_id == config('menu_role_map.user'))
                        @include('partials.topbar.notification')
                    @endif
                    @include('partials.profile.quick_profile')
                    
                </div>
            </div>
            <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor p-3" id="kt_content"
                 style="background: #eef0f8">
                @include('partials.topbar.notification_bar')
                @yield('content')
            </div>
            @include('partials.footer.footer')
        </div>
    </div>
</div>

<!-- end:: Page -->

<!-- begin::Quick Panel -->
{{-- @include('partials.topbar.quick_panel') --}}
<!-- end::Quick Panel -->

<!-- begin::Scrolltop -->
<div id="kt_scrolltop" class="kt-scrolltop">
    <i class="fa fa-arrow-up"></i>
</div>

<!-- end::Scrolltop -->

<!--Begin:: Chat-->
{{-- @include('partials.topbar.chat') --}}
<!--ENd:: Chat-->

<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "dark": "#282a3c",
                "light": "#ffffff",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": [
                    "#c5cbe3",
                    "#a1a8c3",
                    "#3d4465",
                    "#3e4466"
                ],
                "shape": [
                    "#f0f3ff",
                    "#d9dffa",
                    "#afb4d4",
                    "#646c9a"
                ]
            }
        }
    };
</script>

<!-- end::Global Config -->

<!--end::Global Theme Bundle -->

<!--begin::Page Vendors(used by this page) -->
<script src="{{ asset('assets/plugins/dtable/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/dtable/DataTables-1.10.24/js/dataTables.bootstrap4.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/plugins/custom/datatables/unchanged/colResizable-1.5.min.js') }}"
        type="text/javascript"></script>

<!--end::Page Vendors -->
<link href="{{ asset('assets/plugins/custom/sweetalert2/dist/sweetalert2.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('assets/plugins/custom/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/sweetalert2.init.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/pages/components/extended/sweetalert2.js') }}" type="text/javascript"></script>
<!--begin::Page Scripts(used by this page) -->
<script src="{{ asset('assets/js/pages/dashboard.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/plugins/custom/jstree/jstree.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/pages/components/extended/treeview.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/js/tapp.js') }}?timestamp={{now()->timestamp}}" type="text/javascript"></script>
<script type="text/javascript">
    $("#kt_quick_panel_close_btn").click(function () {
        $("#kt_quick_panel").removeAttr('style');
        $("#kt_quick_panel").css('opacity', 0);
        $("#kt_quick_panel").removeClass('kt-quick-panel--on');
        $("html").removeClass("side-panel-overlay");
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        if ($("#kt_quick_panel").length > 0) {
            // makeAreaResizable('#kt_quick_panel');
        }
    })

    //change checkbox value "on" to "1"

    function tapp_table_init(table_class = 'tapp_table', order_by = 0, order_direction = 'DESC') {
        $('.' + table_class).DataTable({
            "autoWidth": false,
            // "scrollX": true,
            language: {
                processing: "Please Wait...",
                lengthMenu: '<select class="custom-select custom-select-sm form-control form-control-sm">' +
                    '<option value="10">10</option>' +
                    '<option value="20">20</option>' +
                    '<option value="30">30</option>' +
                    '<option value="40">40</option>' +
                    '<option value="50">50</option>' +
                    '<option value="-1">All</option>' +
                    '</select> Data',
                zeroRecords: "Sorry! No Information Found.",
                info: "Showing _START_ to _END_ of _TOTAL_.",
                infoEmpty: "No Information Found.",
                sInfoFiltered: "Total searched from _MAX_)",
                paginate: {
                    previous: "Previous",
                    next: "Next",
                },
                sSearch: "",
                searchPlaceholder: "Search"
            },
            columnDefs: [{
                targets: 'no-sort',
                orderable: false
            },],
            order: [
                [order_by, order_direction]
            ],
            drawCallback: function (settings) {
                $('.' + table_class).colResizable({
                    liveDrag: true
                });

                $(".dataTables_paginate li a").each(function (k, v) {
                    // $(this).text(enTobn($(this).text()));
                    $(this).text();

                })
                $(".dataTables_info").each(function (k, v) {
                    // $(this).text(enTobn($(this).text()));
                    $(this).text();

                })

                $('.' + table_class).removeClass('JColResizer')
            }
        });
    }

    function no_order_tapp_table_init(table_class = 'tapp_table') {
        $('.' + table_class).DataTable({
            "autoWidth": false,
            // "scrollX": true,
            language: {
                processing: "Please Wait...",
                lengthMenu: '<select class="custom-select custom-select-sm form-control form-control-sm">' +
                    '<option value="10">10</option>' +
                    '<option value="20">20</option>' +
                    '<option value="30">30</option>' +
                    '<option value="40">40</option>' +
                    '<option value="50">50</option>' +
                    '<option value="-1">All</option>' +
                    '</select> Data',
                    zeroRecords: "Sorry! No Information Found.",
                info: "Showing _START_ to _END_ of _TOTAL_.",
                infoEmpty: "No Information Found.",
                sInfoFiltered: "Total searched from _MAX_)",
                paginate: {
                    previous: "Previous",
                    next: "Next",
                },
                sSearch: "",
                searchPlaceholder: "Search"
            },
            columnDefs: [{
                targets: 'no-sort',
                orderable: false
            },],
            "order": [],
            drawCallback: function (settings) {
                $('.' + table_class).colResizable({
                    liveDrag: true
                });

                $(".dataTables_paginate li a").each(function (k, v) {
                    // $(this).text(enTobn($(this).text()));
                    $(this).text();
                })
                $(".dataTables_info").each(function (k, v) {
                    // $(this).text(enTobn($(this).text()));
                    $(this).text();

                })

                $('.' + table_class).removeClass('JColResizer')
            }
        });
    }


    $(document).ready(function () {
        $('.advance_search').hide();
        $('input[type="checkbox"]').on('change', function () {
            this.value ^= 1;
        });

        $('.date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
        });
    });

    $(document).ajaxStop(function () {
        $('.date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        });
    });
    $("#btn-advance-search").click(function () {
        $(".advance_search").toggle();
    });

    $(document).on("input", ".integer_type_positive", function (event) {
        this.value = this.value.replace(/[^0-9০-৯]/g, '');
    });

    if ($(".notification-menu").length > 0) {
        loadNotification();
    }
</script>
@yield('js')
</body>
</html>
