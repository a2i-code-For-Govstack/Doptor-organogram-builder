@if($login_history && count($login_history) > 0)
    <div class="col-md-12">
        <div class="card custom-card round-0 shadow-sm">
            <div class="card-body">

                @php
                    $date_range = explode(' - ', $date_range);
                    if($date_range[0] == $date_range[1]){
                        $date_range = enTobn($date_range[0]);
                    }else{
                        $date_range = enTobn($date_range[0]) . ' হতে ' . enTobn($date_range[1]);
                    }
                @endphp
                <table id="summary_table">
                    <tr>
                        <td>তারিখ: {{$date_range}}</td>
                    </tr>
                    <tr>
                        <td>সর্বমোট ইউজার লগইন: {{$total_unique_user_login_count}}</td>
                    </tr>
                    <tr>
                        <td>সর্বমোট অফিস লগইন: {{$total_office_login}}</td>
                    </tr>
                </table>

                <div class="table-responsive">
                    <table id="history_table"
                           class="table table-striped- table-bordered table-hover table-checkable  custom-table-border">
                        <thead class="table-head-color">
                        <tr>
                            <th>অফিস আইডি</th>
                            <th>অফিসের নাম</th>
                            <th>সর্বোমোট ইউজার লগইন</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($login_history as $history)
                            <tr>
                                <td>{{$history->office_id}}</td>
                                <td>{{$history->office->office_name_bng}}</td>
                                <td>{{$history->total_unique_user_login_count }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="col-md-12">
        <div class="card custom-card round-0 shadow-sm">
            <div class="card-body">
                <h4>কোন তথ্য পাওয়া যায়নি</h4>
            </div>
        </div>
    </div>
@endif
