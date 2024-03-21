<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th class="text-center">Sl.</th>
                <th class="text-center">Description</th>
                <th class="text-center">Release Date</th>
                <th class="text-center">Version</th>
                <th class="text-center">Activity</th>
                <th class="text-center">"Release notes can be show on the page"</th>
        </tr>
        </thead>
        <tbody>
        @foreach($lists as $key => $list)
        <tr>
            <td class="text-center"> {{ En2Bn($key+1) }} </td>
            <td class="text-center"> <button type="button" onclick="loadView('{{ route('nothiUpdateList.show', $list->id) }}')" class="btn btn-info"><i class="fas fa-eye"></i></button> </td>
            <td class="text-center"> {{  En2Bn(date('d-m-Y', strtotime($list->release_date)))}} </td>
            <td class="text-center"> {{ En2Bn($list->version) }} </td>
            <td class="text-center">
                <button type="button" data-dismiss="modal"
                    onclick="loadEdit('{{ route('nothiUpdateList.edit', $list->id) }}')"
                    class="btn btn-warning">
                    Edit
                </button>
                <button type="button" data-dismiss="modal"
                onclick="deleted('{{ route('deleteNothiList', $list->id) }}')"
                    class="btn btn-danger">
                    Cancel
                </button>
            </td>
            <td class="text-center">
                <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                    <label>
                        <input onclick="changeStatus('{{ route('statusNothiList', [$list->id, 'status' => $list->is_display == 1 ? 0:1 ]) }}')" type="checkbox" {{ $list->is_display == 1 ? 'checked' : '' }}>
                        <span></span>
                    </label>
                </span>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
{{--    {{ $thanas->links('pagination::bootstrap-4') }}--}}
    <div class="ajaxPagination">
    {!! $lists->onEachSide(1)->links() !!}
    </div>
</div>
@php
    function En2Bn($number) {
        $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

        return str_replace($en, $bn, $number);
    }
@endphp
