<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
    <tr class="text-center">
        <th width="10%">নাম</th>
        <th width="10%">জাতীয় পরিচয় পত্র নম্বর</th>
        <th width="10%">মোবাইল নম্বর</th>
        <th width="10%">ইমেইল</th>
        <th width="15%">অফিস</th>
        <th width="10%">অফিস শাখা</th>
        <th width="10%">পদবি</th>
        <th class="no-sort" width="5%">দেখুন</th>
        {{-- <th class="no-sort" width="10%">কার্যক্রম</th> --}}
        <th class="no-sort" width="5%">অনুমোদন</th>
    </tr>
    </thead>
    <tbody>
    @foreach($reg_list as $reg)
        <tr class="text-center">
            <td>{{$reg['name_bng']}}</td>
            <td>{{$reg['nid']}}</td>
            <td>{{$reg['personal_mobile']}}</td>
            <td>{{$reg['personal_email']}}</td>
            <td>{{$reg['office']['office_name_bng']}}</td>
            <td>{{$reg['office_unit']['unit_name_bng']}}</td>
            <td>
                @isset($reg['office_designation']['designation_bng'])
                    {{$reg['office_designation']['designation_bng']}}
                @endisset
            </td>
            <td>
                <button style="height: 30px;width: 30px;"
                        title="দেখুন"
                        data-content=""
                        id="reg_id{{$reg->id}}" data-dismiss="modal"
                        class="mr-3 btn btn-sm btn-info btn-square btn-icon btntableDataEdit">
                    <i class="fa fa-eye"></i>
                </button>
            </td>
            {{-- <td>
                <button style="height: 30px;width: 30px;"
                    data-content="{{$reg->id}}"
                    id="reg_id{{$reg->id}}" data-dismiss="modal"
                    class="btn  btn-icon btn-outline-brand btntableDataEdit">
                    <i class="fas fa-pencil-alt"></i>
                </button>
            </td> --}}
            <td>
                @if($reg->modifier)
                    <span class="badge badge-success">অনুমোদিত</span>
                    <p class="mt-0 mb-0"><span>{{$reg->modifier->username}}</span></p>
                    <p class="mt-0 mb-0"><span>{{enTobn(date('d-m-Y', strtotime($reg->approved_at)))}}</span></p>
                @else
                    <button style="height: 30px;width: 30px;"
                            data-content="{{$reg->id}}"
                            id="reg_id_appoving_{{$reg->id}}"
                            title="অনুমোদন করুন"
                            class="btn  btn-icon btn-outline-brand btnApprove">
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </button>

                    <button style="height: 30px;width: 30px;"
                            data-content="{{$reg->id}}"
                            id="reg_id_rejecting_{{$reg->id}}"
                            title="বাতিল করুন"
                            class="btn btn-icon btn-outline-danger btnReject">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>

<script type="text/javascript">
    no_order_tapp_table_init();

    $(document).on('click', ".btnApprove", function () {

        url = 'approve_registration_request';
        id = $(this).attr('data-content');
        data = {
            'registration_id': id,
        };


        swal.fire({
            title: 'আপনি কি আবেদন অনুমোদন করতে চান?',
            text: "",
            type: 'success',
            showCancelButton: true,
            confirmButtonText: 'হ্যাঁ',
            cancelButtonText: 'না'
        }).then(function (result) {
            if (result.value) {
                datatype = 'json';
                ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseData) {
                    if (responseData.status === 'success') {
                        toastr.success('অনুমোদন সম্পন্ন হয়েছে');
                        window.location.reload();
                    } else {
                        if (responseData.statusCode === '422') {
                            errors = responseData.msg;
                            $.each(errors, function (k, v) {
                                if (v !== '') {
                                    toastr.error(v);
                                }
                            });
                        } else {
                            toastr.error(responseData.msg);
                            console.log(responseData)
                        }
                    }
                });
            }
        });


    });

    $(document).on('click', ".btnReject", function () {

        url = 'reject_registration_request';
        id = $(this).attr('data-content');
        data = {
            'registration_id': id,
        };

        swal.fire({
            title: 'আপনি কি আবেদন বাতিল করতে চান?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'হ্যাঁ',
            cancelButtonText: 'না'
        }).then(function (result) {
            if (result.value) {
                datatype = 'json';
                ajaxCallAsyncCallback(url, data, datatype, 'POST', function (responseData) {
                    if (responseData.status === 'success') {
                        toastr.success('আবেদন বাতিল হয়েছে');
                        window.location.reload();
                    } else {
                        if (responseData.statusCode === '422') {
                            errors = responseData.msg;
                            $.each(errors, function (k, v) {
                                if (v !== '') {
                                    toastr.error(v);
                                }
                            });
                        } else {
                            toastr.error(responseData.msg);
                            console.log(responseData)
                        }
                    }
                });
            }
        });

    });

</script>
