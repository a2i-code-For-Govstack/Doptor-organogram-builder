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
<div class="card card-custom">
    <!--begin::Header-->
    <div class="row m-0 page-title-wrapper d-md-flex align-items-md-center">
        <div class="col-md-6">
            <div class="title py-2">
                <h4 class="mb-0 font-weight-bold solaimanLipi"><i class="fas fa-list mr-3"></i> {{ Auth::user()->employee->name_bng ?? Auth::user()->username  }}
                    ({{enTobn(Auth::user()->username)}}):Work History</h4>
            </div>
        </div>
    </div>
    <!--end::Header-->
    <!--begin::Form-->
    <form class="form">
        <!--begin::Body-->
        <div class="card-body p-3 mt-2" id="kt_profile_scroll">
            <div class="col-md-12 px-0">
                <table  class="tapp_table table table-striped table-bordered table-hover table-checkable  custom-table-border">
            <thead class="table-head-color">
                <tr class="text-center">
                        <th width="10%">Office Name</th>
                        <th width="10%">Branch</th>
                        <th width="10%">Last name</th>
                        <th width="10%">Start working day</th>
                        <th width="10%">Last working day</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($designation_history as $history)
                        <tr>
                            <td>{{$history->office_name_bn}}</td>
                            <td>{{$history->unit_name_bn}}</td>
                            <td>{{$history->designation}}</td>
                            <td>{{ $history->joining_date != NULL ? enTobn(Carbon\Carbon::parse($history->joining_date)->format('d-m-Y')) : "জয়েন করার তারিখ পাওয়া যায় নি" }}</td>
                            <td>{{ $history->last_office_date != NULL ? enTobn(Carbon\Carbon::parse($history->last_office_date)->format('d/m/Y')) : "বর্তমান" }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        <!--end::Body-->
    </form>
    <!--end::Form-->
</div>

<script>
    tapp_table_init()
</script>
