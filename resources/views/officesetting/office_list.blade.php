@extends('master')
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border"
        id="kt_content">
        <!--begin::Subheader-->
        <div class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"
            id="kt_subheader">
            <div class="ml-3">
                <button id="btn-advance-search" class="btn btn-sna-header-button-color py-0  d-flex">
                    <div>
                        <i class="fa fa-search mr-2 my-1"></i>
                    </div>
                    <div>
                        <p id="advanceSearch" class="mb-0 pt-1">অনুসন্ধান</p>

                    </div>
                </button>
            </div>
            <div>
                <h3 class="text-white my-1">সকল অফিসের তালিকা</h3>
            </div>
            <div class="ml-3">
            </div>
        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div>
            <!--Begin::Dashboard 1-->
            <div class="kt-portlet kt-portlet--mobile">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card custom-card rounded-0 shadow-sm advance_search" style="display: none;">
                            <div class="card-body">
                                <div class="col-md-12 py-0">
                                    <form action="/officeList" method="GET">
                                        {{-- <div class="form-group">
                                            <x-office-select grid="4" unit="false" only_office="true">
                                            </x-office-select>
                                        </div> --}}
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="ministry_search">মন্ত্রণালয় দিয়ে খুজুন</label>
                                                    <select name="ministry_search" id="ministry_search"
                                                        class="form-control select-select2 rounded-0">
                                                        <option value="" selected="selected">--বাছাই করুন--</option>
                                                        @foreach ($ministries as $ministrie)
                                                        <option value="{{$ministrie->id}}">{{$ministrie->name_bng}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="origin_search">দপ্তর/অধিদপ্তর দিয়ে খুজুন</label>
                                                    <select name="origin_search" id="origin_search"
                                                        class="form-control select-select2 rounded-0">
                                                        <option value="" selected="selected">--বাছাই করুন--</option>
                                                        @foreach ($officeOrigins as $officeOrigin)
                                                        <option value="{{$officeOrigin->id}}">{{$officeOrigin->office_name_bng}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="office_search">সক্রিয়/নিষ্ক্রিয় অফিস খুজুন</label>
                                                    <select name="office_search" id="office_search"
                                                        class="form-control select-select2 rounded-0">
                                                        <option value="" selected="selected">--বাছাই করুন--</option>
                                                        <option value="active_office">সক্রিয় অফিস</option>
                                                        <option value="inactive_office">নিষ্ক্রিয় অফিস</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="custom_layer">সক্রিয়/নিষ্ক্রিয় ম্যাপিং খুজুন</label>
                                                    <select name="custom_layer" id="custom_layer"
                                                        class="form-control select-select2 rounded-0">
                                                        <option value="" selected="selected">--বাছাই করুন--</option>
                                                        <option value="active_custom_layer">সক্রিয় লেয়ার</option>
                                                        <option value="inactive_custom_layer">নিষ্ক্রিয় লেয়ার</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="unit_and_org">শুন্য শাখা/পদবি দিয়ে খুজুন</label>
                                                    <select name="unit_and_org" id="unit_and_org"
                                                        class="form-control select-select2 rounded-0">
                                                        <option value="" selected="selected">--বাছাই করুন--</option>
                                                        <option value="unit_search">শুন্য শাখা</option>
                                                        <option value="org_search">শুন্য পদবি</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 d-flex justify-content-start">
                                                <span style="color: red;">*&nbsp;</span>অনুগ্রহকরে যেকোনো একটি মডিউল সিলেক্ট করে অফিস খুজুন।
                                            </div>
                                            <div class="col-md-6 d-flex justify-content-end">
                                                <button type="submit"
                                                    class="btn btn-outline-success my-2 my-sm-0 rounded-0" type="button">
                                                    অনুসন্ধান
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- begin:: Content -->
        <div>
            <!--Begin::Dashboard 1-->
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__body" style="margin-top: -25px">
                    <div class="row mb-1">
                        <div class="col-md-12 py-0" id="officeSearchHide">
                            <form class="form-inline" style="float: right;" action="/officeList" method="GET">
                                <input style="width: 320px !important; height: 40px;" class="form-control rounded-0"
                                    type="search" name="office_ids" id="office_ids"
                                    placeholder="অফিস আইডি/একাধিক আইডির জন্য কমা দিয়ে অনুসন্ধান করুন"
                                    aria-label="Search">
                                <input style="width: 320px !important; height: 40px;" class="form-control rounded-0"
                                    type="search" name="office_name" id="office_name"
                                    placeholder="অফিসের নাম দিয়ে অনুসন্ধান করুন" aria-label="Search">
                                <button style="height: 40px;" class="btn btn-outline-success my-2 my-sm-0 rounded-0"
                                    type="submit">অনুসন্ধান</button>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 py-0">
                            <table id="employee_table"
                                class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border tapp_table">
                                <thead class="table-head-color">
                                    <tr class="text-center">
                                        <th>ক্রম</th>
                                        <th>মন্ত্রণালয়</th>
                                        <th>লেয়ার</th>
                                        <th>কাষ্টম লেয়ার স্তর</th>
                                        <th>দপ্তর/অধিদপ্তরের ধরন</th>
                                        <th>অফিস</th>
                                        <th>ডোমেইন</th>
                                        <th>ম্যাপিং</th>
                                        <th>শাখা</th>
                                        <th>পদবি</th>
                                        <th>সক্রিয় কর্মকর্তা</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($officeInformations as $key => $officeInformation)
                                        <tr>
                                            <td>{{ enTobn($officeInformations->firstItem() + $key) }}</td>
                                            <td>{{ $officeInformation->office_ministry->name_bng ?? '' }}</td>
                                            <td>{{ $officeInformation->office_layer->name_bng ?? '' }}</td>

                                            <?php $name = '';
                                            if (!empty($officeInformation->custom_layer)) {
                                                foreach ($customLayers as $key => $layer) {
                                                    if ($officeInformation->custom_layer->layer_level == $layer->layer_level) {
                                                        if ($officeInformation->custom_layer->layer_level == 3) {
                                                            $name = 'অন্যান্য দপ্তর/সংস্থা';
                                                        } else {
                                                            $name .= $layer->name . '/';
                                                        }
                                                    }
                                                }
                                                $custom_layers = trim($name, '/');
                                            }
                                            ?>
                                            <td>{{ $custom_layers ?? '' }}
                                                {!! !empty($officeInformation->custom_layer->layer_level) && $officeInformation->custom_layer->layer_level == 3
                                                    ? ' <i class="fa fa-chevron-right"></i> ' . $officeInformation->custom_layer->name
                                                    : '' !!}
                                            </td>
                                            <td>{{ $officeInformation->office_origin_list->office_name_bng ?? '' }}</td>
                                            <td>{{ $officeInformation->office_name_bng ?? '' }}
                                                ({{ $officeInformation->id }})
                                                {!! $officeInformation->active_status == 1
                                                    ? '<span style="font-size: 13px; color: white;" class="badge badge-success font-weight-light">সক্রিয়</span>'
                                                    : '<span style="font-size: 13px; color: white;" class="badge badge-danger font-weight-light">নিষ্ক্রিয়</span>' !!}
                                            </td>
                                            <td>
                                                {{$officeInformation->office_domain->domain_url ?? ''}}
                                            </td>
                                            <td> <?php
                                            if ($officeInformation->office_domain_count == 1) { ?>
                                                <button type="button" class="btn btn-info rounded-0 showMapping"
                                                    data-id="{{ $officeInformation->id }}" data-toggle="modal"
                                                    data-target="#domainMappingModal">দেখুন</button>
                                                <?php } ?>
                                            </td>
                                            <td>{{ enTobn($officeInformation->office_units_count) }}</td>
                                            <td>{{ enTobn($officeInformation->office_unit_organograms_count) }}</td>
                                            <td> {{ enTobn($officeInformation->office_units_count == 0 && $officeInformation->office_unit_organograms_count == 0 ? 0 : $officeInformation->assigned_employees_count) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <span
                                style="float: left;">{{ enTobn($officeInformations->total()) . ' টা তথ্যের মধ্যে ' . enTobn($officeInformations->firstItem()) . ' থেকে ' . enTobn($officeInformations->lastItem()) . ' পর্যন্ত দেখানো হচ্ছে' }}</span>
                            <span style="float: right;">
                                {{ $officeInformations->withQueryString()->links() }}
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade bd-example-modal-xl" id="domainMappingModal" tabindex="-1" role="dialog"
        aria-labelledby="domainMappingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="officeName"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table
                        class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border text-center">
                        <thead class="table-head-color">
                            <tr>
                                <th>ডোমেইন</th>
                                <th>ডোমেইন প্রিফিক্স</th>
                                <th>ডাটাবেস হোস্ট</th>
                                <th>অফিস ডাটাবেজ</th>
                                <th>অবস্থা</th>
                                <th>ভার্সন</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="domain"></td>
                                <td id="domain_prefix"></td>
                                <td id="db_host"></td>
                                <td id="office_db"></td>
                                <td id="status"></td>
                                <td id="version"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">বন্ধ করুন</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        // $(document).ready(function() {
        //     $("body").addClass('kt-aside--minimize');
        // });

        $(".showMapping").click(function() {
            let office_id = $(this).data("id");
            var url = 'get_office_mapping_info';
            var data = {
                office_id
            };
            var datatype = 'JSON';
            ajaxCallUnsyncCallback(url, data, datatype, 'GET', function(responseData) {
                var data = responseData.data;
                $('#officeName').text(responseData.office_name);
                if (data) {
                    $('#domain').text(data.domain_url);
                    $('#domain_prefix').text(data.domain_prefix);
                    $('#db_host').text(data.domain_host);
                    $('#office_db').text(data.office_db);
                    $('#status').text(data.status == 1 ? 'সক্রিয়' : 'নিষ্ক্রিয়');
                    $('#version').text(data.version == 2 ? 'ভার্সন-২' : 'ভার্সন-১');
                }
            });
        });

        $('#advanceSearch').click(function() {
            $('#officeSearchHide').toggle();
        });
    </script>
@endsection
