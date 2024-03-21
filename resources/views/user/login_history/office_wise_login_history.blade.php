@if(Auth::check())
    @if ($userHasRole)
        @php
            $layout = 'master';
        @endphp
    @else
        @php
            $layout = 'layouts.no-role';
        @endphp
    @endif
@else
    @php
        $layout = 'layouts.guest-user';
    @endphp
@endif

@extends($layout)

@section('content')
    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js"></script>

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor sna-common-content-border"
         id="kt_content">
        <!--begin::Subheader-->
        <div
            class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"
            id="kt_subheader">

            <div class="ml-3"></div>
            <div>
                <h3 class="text-white my-1">লগইন ইতিহাস</h3>
            </div>
            <div class="mr-3 d-flex"></div>
        </div>
        <!--end::Subheader-->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
            <!--Begin::Dashboard 1-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card shadow-sm w-100">
                        <div class="card-header">
                            <h5 class="mb-0"></h5>
                        </div>
                        <div class="card-body">
                            @if($first_login_time && $first_login_time != '0000-00-00 00:00:00')
                                <p>* {{enTobn(date('d/m/Y', strtotime($first_login_time)))}} তারিখ থেকে পরবর্তী ইতিহাস দেখানো হচ্ছে। </p>
                            @endif
                            <form onsubmit="submitData(this, 'office-active-users'); return false;">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date_range"><i class="fa fa-calendar-alt mr-2"></i>তারিখ বাছাই
                                                করুন</label>
                                            <input id="date_range" class="form-control rounded-0" type="text"
                                                   name="date_range">
                                        </div>
                                    </div>
                                    <div class="col-md-8 d-flex align-items-end">
                                        <div class="form-group">
                                            <button type="submit" id="search" class="btn btn-primary"><i
                                                    class="fa fa-search"></i>অনুসন্ধান
                                            </button>
                                            <button type="button" onclick="generateHistoryExcel()"
                                                    class="excelGenerateBtn btn btn-warning" style="display: none"><i
                                                    class="fa fa-download my-1 ml-2 mr-0"></i>ডাউনলোড
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3" id="login_history_area"></div>

            <!--End::Dashboard 1-->
        </div>

        <!-- end:: Content -->
    </div>
    <!-- begin::Scrolltop -->
    <div id="kt_scrolltop" class="kt-scrolltop">
        <i class="fa fa-arrow-up"></i>
    </div>

    <script type="text/javascript">

        $('#date_range').daterangepicker({
            buttonClasses: ' btn',
            applyClass: 'btn-primary',
            cancelClass: 'btn-secondary',
            locale: {
                format: 'DD/MM/YYYY'
            },
            "autoApply": true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            "alwaysShowCalendars": true
        }, function (start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });

        function submitData(form, url) {
            data = $(form).serialize();
            ajaxCallAsyncCallback(url, data, 'html', 'POST', function (responseDate) {
                $('#login_history_area').html(responseDate);
                if (document.getElementById("history_table")) {
                    $('.excelGenerateBtn').show();
                } else {
                    $('.excelGenerateBtn').hide();
                }
            });
        }

        function generateHistoryExcel() {
            let tbl1 = document.getElementById('summary_table')
            let tbl2 = document.getElementById('history_table')

            let worksheet_tmp1 = XLSX.utils.table_to_sheet(tbl1);
            let worksheet_tmp2 = XLSX.utils.table_to_sheet(tbl2);

            let a = XLSX.utils.sheet_to_json(worksheet_tmp1, {header: 1})
            let b = XLSX.utils.sheet_to_json(worksheet_tmp2, {header: 1})

            a = a.concat(['']).concat(b)

            let worksheet = XLSX.utils.json_to_sheet(a, {skipHeader: true})

            const new_workbook = XLSX.utils.book_new()
            XLSX.utils.book_append_sheet(new_workbook, worksheet, "worksheet")
            XLSX.writeFile(new_workbook, 'লগইন ইতিহাস' + enTobn($('#date_range').val()) + '.xls')

        }

    </script>
@endsection
