<style>
    .custom-timeline .timeline-content:before {
        border-right: solid 10px #d2eaff !important;
        left: -27px !important;
    }

    .custom-timeline .timeline-content {
        background: #F3F6F9;

    }

    .permitted_designation span {
        color: #989db3;
        font-size: 16px !important;
    }
</style>
<div class="card card-custom">
    <!--begin::Header-->
    <div class="row m-0 page-title-wrapper d-md-flex align-items-md-center">
        <div class="col-md-6">
            <div class="title py-2">
                <h4 class="mb-0 font-weight-bold solaimanLipi"><i
                        class="fas fa-list mr-3"></i> {{ Auth::user()->employee->name_bng ?? Auth::user()->username  }}
                    ({{enTobn(Auth::user()->username)}}): Digital Certificate</h4>
            </div>
        </div>
    </div>
    <!--end::Header-->
    <!--begin::Form-->
    <form class="form">
        <!--begin::Body-->
        <div class="card-body p-3 mt-2" id="kt_profile_scroll">
            <div class="col-md-12 px-0">
                <table
                    class="tapp_table table table-striped table-bordered table-hover table-checkable custom-table-border"
                    style="text-align: center; margin-left: auto;  margin-right: auto;">
                    <thead class="table-head-color">
                    <tr class="text-center">
                        <th width="20%">Name</th>
                        <th width="15%">Certificate</th>
                        <th width="15%">Date of receipt of certificate</th>
                        <th width="25%">Condition</th>
                        <th width="25%">Activities</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ca_lists as $certificate_authority)
                        <tr>
                            <td><img src="{{$certificate_authority->logo_url}}" alt=""
                                     style="width: 60px!important; height: 60px"/> {{$certificate_authority->name}}</td>
                            <td>{{$certificate_authority->user_digital_certificate?$certificate_authority->user_digital_certificate->certificate:''}}</td>
                            <td>{{$certificate_authority->user_digital_certificate?enTobn(date('d-m-Y h:i A', strtotime($certificate_authority->user_digital_certificate->created_at))):''}}</td>
                            <td>
                                @if($certificate_authority->user_digital_certificate)
                                    <span class="badge badge-success">সার্টিফিকেট বিদ্যমান আছে।</span>
                                @else
                                    <span class="badge badge-warning">সার্টিফিকেট বিদ্যমান নাই।</span>
                                @endif
                            </td>
                            <td>
                                @if($certificate_authority->user_digital_certificate)
                                    <a href="javascript:;"
                                       data-ca-id="{{$certificate_authority->id}}"
                                       data-ca-short-name="{{$certificate_authority->short_name}}"
                                       onclick="getUserDigitalCertificate($(this))"
                                       class="btn btn-sm btn-primary">সার্টিফিকেট নবায়ন করুন</a>
                                @else
                                    <a href="javascript:;"
                                       data-ca-id="{{$certificate_authority->id}}"
                                       data-ca-short-name="{{$certificate_authority->short_name}}"
                                       onclick="getUserDigitalCertificate($(this))"
                                       class="btn btn-sm btn-primary">সার্টিফিকেট গ্রহণ করুন</a>
                                @endif
                            </td>
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

    function getUserDigitalCertificate(elem) {
        ca_provider = $(elem).data('ca-short-name');
        console.log(ca_provider)
        if (ca_provider == 'mangoca') {
            ca_id = $(elem).data('ca-id');
            url = "digital-certificate/get-certificate";

            data = {
                ca_id: ca_id
            }

            Server_Async(url, data, 'post').done(function (response) {
                if (response.status == 'success') {
                    if (response.type == 'redirect') {
                        window.location.href = response.url;
                    } else {
                        toastr.error('Something went wrong')
                    }
                } else {
                    toastr.error(response.message)
                }
            })

        } else if (ca_provider == 'bcc') {
            ca_id = $(elem).data('ca-id');
            url = "digital-certificate/get-certificate";

            data = {
                ca_id: ca_id
            }

            Server_Async(url, data, 'post').done(function (response) {
                if (response.status == 'success') {
                    toastr.success(response.message)
                    $('#digitalCaBtn').click();
                } else {
                    toastr.error(response.message)
                }
            })
        }


    }

</script>
