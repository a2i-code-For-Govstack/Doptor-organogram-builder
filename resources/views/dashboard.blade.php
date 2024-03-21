@extends('master')
@section('content')
	<style>
		.count-view {
			font-size: 22px;
			font-weight: bold;
			display: block;
			margin-top: -10px;
		}
	</style>
    @if (Auth::user()->user_role_id != config('menu_role_map.user'))
        <div class="container-fluid">
            <section>
                <div class="row">
                    <div class="col-xl-6 col-sm-6 col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between px-md-1">
                                    <div class="text-center">
                                        <i class="fas fa-building text-info fa-3x pt-3"></i>
                                        <h2 class="mb-0 font-weight-bold">Office</h2>
                                        <div class="text-left pt-2">
                                            <label for="total_offices"> Total Office : </label>
                                            <span class="count-view" id="total_offices"></span>
                                            <label for="active_offices">Active Office : </label>
                                            <span class="count-view" id="active_offices"></span>
                                            <label for="inactive_offices">Inactie Office : </label>
                                            <span class="count-view" id="inactive_offices"></span>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div style="width: 300px; height: 300px;"><canvas id="office_pie_chart"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-md-1">
                                    <div class="progress mt-3 mb-1 rounded" style="height: 7px;">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%;"
                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-sm-6 col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between px-md-1">
                                    <div class="text-center">
                                        <i class="fas fa-users text-warning fa-3x pt-3"></i>
                                        <h2 class="mb-0 font-weight-bold">Branch</h2>
                                        <div class="text-left pt-2">
                                            <label for="total_units">Total Branch :</label>
                                            <span class="count-view" id="total_units"></span>
                                            <label for="active_units">Active Branch :</label>
                                            <span class="count-view" id="active_units"></span>
                                            <label for="inactive_units">Inactive Branch :</label>
                                            <span class="count-view" id="inactive_units"></span>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div style="width: 300px; height: 300px;"><canvas id="unit_pie_chart"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-md-1">
                                    <div class="progress mt-3 mb-1 rounded" style="height: 7px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;"
                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-sm-6 col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between px-md-1">
                                    <div class="text-center">
                                        <i class="fas fa-user text-danger fa-3x pt-3"></i>
                                        <h2 class="mb-0 font-weight-bold">Designation</h2>
                                        <div class="text-left pt-2">
                                            <label for="total_organograms">Total Designation :</label>
                                            <span class="count-view" id="total_organograms"></span>
                                            <label for="active_organograms">Active Designation</label>
                                            <span class="count-view" id="active_organograms"></span>
                                            <label for="inactive_organograms">Inactive Designation : </label>
                                            <span class="count-view" id="inactive_organograms"></span>
                                            <label for="assign_organograms">Assign Designation :</label>
                                            <span class="count-view" id="assign_organograms"></span>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div style="width: 300px; height: 300px;"><canvas
                                                id="organogram_pie_chart"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-md-1">
                                    <div class="progress mt-3 mb-1 rounded" style="height: 7px;">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 100%;"
                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-sm-6 col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between px-md-1">
                                    <div class="text-center">
                                        <i class="fas fa-user-check text-success fa-3x pt-3"></i>
                                        <h2 class="mb-0 font-weight-bold">User</h2>
                                        <div class="text-left pt-2">
                                            <label for="total_users">Total User : </label>
                                            <span class="count-view" id="total_users"></span>
                                            <label for="active_users">Active User : </label>
                                            <span class="count-view" id="active_users"></span>
                                            <label for="inactive_users">Inactive User :</label>
                                            <span class="count-view" id="inactive_users"></span>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="text-end">
                                            <div style="width: 300px; height: 300px;"><canvas id="user_pie_chart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-md-1">
                                    <div class="progress mt-3 mb-1 rounded" style="height: 7px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%;"
                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        {{-- <script src="{{ asset('assets/js/charts/chart.min.js') }}" type="text/javascript"></script> --}}
        {{-- <script src="//cdn.jsdelivr.net/jquery.flot/0.8.3/jquery.flot.min.js"></script> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.0.1/chart.min.js"
            integrity="sha512-tQYZBKe34uzoeOjY9jr3MX7R/mo7n25vnqbnrkskGr4D6YOoPYSpyafUAzQVjV6xAozAqUFIEFsCO4z8mnVBXA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.0.1/chart.umd.js"
            integrity="sha512-gQhCDsnnnUfaRzD8k1L5llCCV6O9HN09zClIzzeJ8OJ9MpGmIlCxm+pdCkqTwqJ4JcjbojFr79rl2F1mzcoLMQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="text/javascript">
            // loadPieChart('office_pie_chart', labels, data)
            function loadPieChart(element_id, labels, data) {
                var pie_chart = document.getElementById(element_id);

                var data = {
                    labels: labels,
                    datasets: [{
                        label: 'Total',
                        data: data,
                        hoverOffset: 4
                    }]
                };
                var config = {
                    type: 'pie',
                    cutout: 0,
                    data: data,
                };
                var myChart = new Chart(pie_chart, config);
            }

            $(function() {
                $('[data-toggle="tooltip"]').tooltip();
                loadOfficeStatistics();
            });

            function loadOfficeStatistics() {
                var url = 'load_active_offices';
                var data = {};
                var datatype = 'JSON';
                ajaxCallUnsyncCallback(url, data, datatype, 'GET', function(responseData) {
                    if (responseData.status == 200) {
                        $('#total_offices').text(enTobn(responseData.total_offices));
                        $('#active_offices').text(enTobn(responseData.active_offices));
                        $('#inactive_offices').text(enTobn(responseData.inactive_offices));

                        loadPieChart('office_pie_chart', ['Total Office', 'Active Office', 'Inactive Office'], [
                            responseData.total_offices, responseData.active_offices, responseData
                            .inactive_offices
                        ]);
                    }
                    setTimeout(function() {
                        loadUnitStatistics();
                    }, 1);
                })
            }

            function loadUnitStatistics() {
                var url = 'load_active_units';
                var data = {};
                var datatype = 'JSON';
                ajaxCallUnsyncCallback(url, data, datatype, 'GET', function(responseData) {
                    if (responseData.status == 200) {
                        $('#total_units').text(enTobn(responseData.total_units));
                        $('#active_units').text(enTobn(responseData.active_units));
                        $('#inactive_units').text(enTobn(responseData.inactive_units));

                        loadPieChart('unit_pie_chart', ['Total Branch', 'Active Branch', 'Inactive Branch'], [responseData
                            .total_units, responseData.active_units, responseData.inactive_units
                        ]);
                    }
                    setTimeout(function() {
                        loadOrganogramStatistics();
                    }, 1);
                })
            }

            function loadOrganogramStatistics() {
                var url = 'load_active_organograms';
                var data = {};
                var datatype = 'JSON';
                ajaxCallUnsyncCallback(url, data, datatype, 'GET', function(responseData) {
                    if (responseData.status == 200) {
                        $('#total_organograms').text(enTobn(responseData.total_organograms));
                        $('#active_organograms').text(enTobn(responseData.active_organograms));
                        $('#inactive_organograms').text(enTobn(responseData.inactive_organograms));
                        $('#assign_organograms').text(enTobn(responseData.assign_organograms));

                        loadPieChart('organogram_pie_chart', ['Total Designation', 'Active Designation', 'Inactive Designation',
                            'Assign Designation'
                        ], [responseData.total_organograms, responseData.active_organograms, responseData
                            .inactive_organograms, responseData.assign_organograms
                        ]);
                    }
                    setTimeout(function() {
                        loadActiveOrganogramStatistics();
                    }, 1);
                })
            }

            function loadActiveOrganogramStatistics() {
                var url = 'load_all_users';
                var data = {};
                var datatype = 'JSON';
                ajaxCallUnsyncCallback(url, data, datatype, 'GET', function(responseData) {
                    if (responseData.status == 200) {
                        $('#total_users').text(enTobn(responseData.total_users));
                        $('#active_users').text(enTobn(responseData.active_users));
                        $('#inactive_users').text(enTobn(responseData.inactive_users));

                        loadPieChart('user_pie_chart', ['Total User', 'Active User',
                            'Inactive User'
                        ], [responseData.total_users, responseData.active_users,
                            responseData.inactive_users
                        ]);

                    }
                })
            }
        </script>
    @endif
@endsection
