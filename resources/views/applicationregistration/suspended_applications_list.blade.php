<table class="table table-bordered tapp_table">
    <thead>
    <tr>
        <th class="d-none">ক্রম</th>
        <th>এপ্লিকেশন নাম</th>
        <th>এপ্লিকেশন নাম (বংলা)</th>
        <th>ইউআরএল</th>
        <th>মোবাইল</th>
        <th>ইমেইল</th>
        <th>অনুমোদন তারিখ</th>
        <th>পুনঃঅনুমোদন করুন</th>
    </tr>
    </thead>
    <tbody>
    @forelse($suspended_applications as $suspended_application)
        @if($suspended_application->application)
            <tr>
                <td class="d-none">{{$loop->iteration}}</td>
                <td width="15%">{{$suspended_application->application->application_name_en}}</td>
                <td width="15%">{{$suspended_application->application->application_name_bn}}</td>
                <td width="15%">{{$suspended_application->application->url}}</td>
                <td width="15%">{{$suspended_application->application->mobile_number}}</td>
                <td width="15%">{{$suspended_application->application->email_address}}</td>
                <td width="15%">{{enTobn($suspended_application->created)}}</td>
                <td width="5%" class="text-center">
                    <button data-systemid="{{$suspended_application->id}}"
                            class="approve_application btn btn-outline-success btn-icon btn-square">
                        <i class="fas fa-check"></i>
                    </button>
                </td>
            </tr>
        @else
            <tr>
                <td class="d-none">{{$loop->iteration}}</td>
                <td width="15%">{{$suspended_application->name}}</td>
                <td width="15%">-</td>
                <td width="15%">-</td>
                <td width="15%">-</td>
                <td width="15%">-</td>
                <td width="15%">{{enTobn($suspended_application->created)}}</td>
                {{-- <td></td>--}}
                {{-- <td></td>--}}
                {{-- <td></td>--}}
                <td width="5%" class="text-center">
                    <button data-systemid="{{$suspended_application->id}}" data-oldsystemid="old"
                            class="approve_application btn btn-outline-success btn-icon btn-square">
                        <i class="fas fa-check"></i>
                    </button>
                </td>
            </tr>
        @endif
    @empty
        <tr class="text-center">
            <td colspan="8">দুঃখিত! কোনো তথ্য পাওয়া যায়নি।</td>
        </tr>
    @endforelse
    </tbody>
</table>

<script>
    tapp_table_init();

    $('.approve_application').click(function () {
        var url;
        var application_id = $(this).data('systemid');
        var old_system = $(this).data('oldsystemid');
        if (old_system) {
            url = '{{url('re_allow_application')}}/' + application_id + '/' + old_system;
        } else {
            url = '{{url('re_allow_application')}}/' + application_id;
        }
        var data = {};
        ajaxCallUnsyncCallback(url, data, 'json', 'post', function (resp) {
            if (resp.status === 'success') {
                toastr.success(resp.msg);
                console.log(resp.data)
                loadData();
            } else {
                if (resp.statusCode === '422') {
                    var errors = resp.msg;
                    $.each(errors, function (k, v) {
                        if (v !== '') {
                            toastr.error(v);
                        }

                    });
                } else {
                    toastr.error(resp.msg);
                    console.log(resp)
                }
            }
        });
    });

</script>
