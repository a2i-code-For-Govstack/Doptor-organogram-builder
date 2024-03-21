<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th class="text-center">ক্রম</th>
            <th class="text-center">শিরোনাম</th>
            <th class="text-center">বার্তা</th>
            <th class="text-center">প্রাপক</th>
            <th class="text-center">প্রাপকের আইডি</th>
            <th class="text-center">প্রেরক</th>
            <th class="text-center">পাঠানোর তারিখ</th>
            <th class="text-center">কার্যক্রম</th>
        </tr>
        </thead>
        <tbody>
        @foreach($msgs as $key => $msg)
        <tr>
            <td class="text-center"> {{ En2Bn($key+1) }} </td>
            <td class="text-center"> {{ $msg->title }} </td>
            <td class="text-center"> <button type="button" onclick="loadView('{{ route('globalMessages.show', $msg->id) }}')" class="btn btn-info"><i class="fas fa-eye"></i></button> </td>
            <td class="text-center">
                @php
                if ($msg->message_for =='all') {
                    $for = 'সবাই';
                } elseif ($msg->message_for =='layer') {
                    $for = 'লেয়ার ভিত্তিক';
                } elseif ($msg->message_for =='office') {
                    $for = 'অফিস ভিত্তিক';
                } elseif ($msg->message_for =='unit') {
                    $for = 'শাখা ভিত্তিক';
                } elseif ($msg->message_for =='organogram') {
                    $for = 'পদবি ভিত্তিক';
                } elseif ($msg->message_for =='office_origin') {
                    $for = 'মৌলিক অফিস ভিত্তিক';
                } elseif ($msg->message_for =='office_layer') {
                    $for = 'অফিসের লেয়ার ভিত্তিক';
                } elseif ($msg->message_for =='office_ministry') {
                    $for = 'মন্ত্রনালয় ভিত্তিক';
                }
                @endphp
                {{ $for }}
            </td>
            <td class="text-center">
                {{ En2Bn($msg->related_id) }}
            </td>
            <td class="text-center"> {{ App\Models\Message::userName($msg->message_by) }} </td>
            <td class="text-center"> {{ En2Bn(Carbon\Carbon::parse($msg->created)->format('d/m/Y h:i A')) }} </td>
            <td class="text-center">
                <button type="button" data-dismiss="modal"
                onclick="deleted('{{ route('globalMessages.destroy', $msg->id) }}')"
                    class="btn btn-danger">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
{{--    {{ $thanas->links('pagination::bootstrap-4') }}--}}
    <div class="ajaxPagination">
    {!! $msgs->onEachSide(1)->links() !!}
    </div>
</div>
@php
function En2Bn($number) {
    $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
    $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

    return str_replace($en, $bn, $number);
}
@endphp
