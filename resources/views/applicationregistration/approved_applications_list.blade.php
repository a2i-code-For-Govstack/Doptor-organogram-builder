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
        {{-- <th>প্রকাশিত</th>--}}
        <th>সম্পাদনা করুন</th>
        <th>স্থগিত করুন</th>
    </tr>
    </thead>
    <tbody>
    @forelse($approved_applications as $approved_application)
        @if($approved_application->application)
            <tr>
                <td class="d-none">{{$loop->iteration}}</td>
                <td width="15%">{{$approved_application->application->application_name_en}}</td>
                <td width="15%">{{$approved_application->application->application_name_bn}}</td>
                <td width="15%">{{$approved_application->application->url}}</td>
                <td width="15%">{{$approved_application->application->mobile_number}}</td>
                <td width="15%">{{$approved_application->application->email_address}}</td>
                <td width="15%">{{enTobn($approved_application->created)}}</td>
                {{-- <td></td>--}}
                <td width="5%" class="text-center">
                    <a href="{{url('edit_application/'.$approved_application->id)}}"
                       class=" edit_application btn btn-outline-warning btn-icon btn-square">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                </td>
                <td width="5%" class="text-center">
                    <button data-systemid="{{$approved_application->id}}"
                            class="unapprove_application btn btn-outline-danger btn-icon btn-square">
                        <i class="fas fa-times"></i>
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

    $('.unapprove_application').click(function () {
        var application_id = $(this).data('systemid');
        console.log(application_id)
        var url = '{{url('suspend_system_application')}}/' + application_id;
        var data = {};
        ajaxCallUnsyncCallback(url, data, 'json', 'post', function (resp) {
            if (resp.status === 'success') {
                toastr.success(resp.msg);
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
