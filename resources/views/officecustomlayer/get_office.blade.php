<div class="table-responsive">
    <table class="table table-bordered text-center">
        <thead>
        <tr>
            <th>ক্রম</th>
            <th>অফিসের নাম</th>
            <th>কাস্টম স্তর </th>
{{--            <th>কার্যক্রম</th>--}}
        </tr>
        </thead>
        <tbody>
        @foreach($offices as $office)
            <tr>
                <td>{{enTobn($loop->iteration)}}</td>
                <td>{{$office->office_name_bng}}</td>
                <td>{{@$office->office_custom_layer->name}}</td>

{{--                <td>--}}
{{--                    <button type="button"--}}
{{--                            data-content="{{$office->id}},{{$office->office_name_bng}},{{@$office->office_custom_layer->name}}"--}}
{{--                            data-dismiss="modal"--}}
{{--                            class="btn btn-warning btn-icon btn-square btntableDataEdit"><i--}}
{{--                            class="fas fa-pencil-alt"></i></button>--}}
{{--                </td>--}}
            </tr>
        @endforeach
        </tbody>
    </table>
{{--    <div class="ajaxPagination">--}}
{{--        {!! $layers->onEachSide(5)->links() !!}--}}
{{--    </div>--}}
</div>
