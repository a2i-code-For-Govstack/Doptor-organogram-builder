<table class="table table-bordered tapp_table">
    <thead>
    <tr>
        <th class="d-none">ক্রম</th>
        <th>এপ্লিকেশন</th>
        <th>এপ্লিকেশন (বংলা)</th>
        <th>ইউআরএল</th>
        <th>মোবাইল</th>
        <th>ইমেইল</th>
        <th>নিবন্ধন তারিখ</th>
        <th>অনুমোদন করুন</th>
    </tr>
    </thead>
    <tbody>
    @forelse($pending_applications as $pending_application)
        <tr>
            <td class="d-none">{{$loop->iteration}}</td>
            <td width="15%">{{$pending_application->application_name_en}}</td>
            <td width="15%">{{$pending_application->application_name_bn}}</td>
            <td width="15%">{{$pending_application->url}}</td>
            <td width="15%">{{$pending_application->mobile_number}}</td>
            <td width="15%">{{$pending_application->email_address}}</td>
            <td width="15%">{{enTobn($pending_application->created)}}</td>
            <td width="5%" class="text-center">
                <button data-systemid="{{$pending_application->id}}"
                        class="approve_application btn btn-outline-success btn-icon btn-square">
                    <i class="fas fa-check"></i>
                </button>
            </td>
        </tr>
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
        var application_id = $(this).data('systemid');
        var url = '{{url('approve_system_application')}}/' + application_id;
        var data = {};
        ajaxCallUnsyncCallback(url, data, 'json', 'post', function (resp) {
            if (resp.status === 'success') {
                toastr.success(resp.msg);
                loadData();
                console.log(resp.data)
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
