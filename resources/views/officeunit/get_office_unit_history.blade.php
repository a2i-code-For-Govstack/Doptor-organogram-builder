<style>
      .custom-timeline .timeline-content:before{
        border-right: solid 10px #d2eaff !important;
        left: -27px !important;
  }
  .custom-timeline .timeline-content{
    background: #F3F6F9;

  }
  .permitted_designation span{
    color: #989db3;
    font-size: 16px !important;
  }
</style>

@if(count($unit_history) > 0)
     <table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
            <thead class="table-head-color">
               <tr class="text-center">
                        <th  class="" width="10%">পুরাতন শাখা বাংলা</th>
                        <th  class="" width="10%">নতুন শাখা বাংলা</th>
                        <th class="" width="10%">পুরাতন শাখা ইংরেজি </th>
                        <th class="" width="10%">নতুন শাখা ইংরেজি</th>
                        <th class="no-sort" width="10%">পরিবর্তনের তারিখ</th>
{{--                        <th class="no-sort" width="10%">পরিবতন করেছেন</th>--}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($unit_history as $key => $history)
                    <tr class="text-center">
                        <td >{{$history->old_unit_bng}}</td>
                        <td>{{$history->unit_bng}}</td>
                        <td>{{$history->old_unit_eng}}</td>
                        <td>{{$history->unit_eng}}</td>
                        <td>{{enTobn($history->created)}}</td>
{{--                        <td>{{$history->user->employee->name_bng}} </td>--}}

                    </tr>
                    @endforeach
                </tbody>
    </table>
@else
    <h2 class="text-center">কোন তথ্য পাওয়া যায়নি</h2>
@endif


