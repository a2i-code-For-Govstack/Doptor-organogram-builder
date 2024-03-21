<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>নাম(বাংলা)</th>
            <th>নাম(ইংরেজি)</th>
            <th>লেয়ার লেভেল </th>
            <th>কার্যক্রম</th>
        </tr>
        </thead>
        <tbody>
        @foreach($layers as $layer)
            <tr>
                <td>{{$layer->name}}</td>
                <td>{{$layer->name_eng}}</td>
                <td>{{$layer->layer_level}}</td>
                <td>
                    <button type="button"
                            data-content="{{$layer->id}},{{$layer->name}},{{$layer->name_eng}},{{$layer->layer_level}}"
                            data-dismiss="modal"
                            id="layer_id{{$layer->id}}"
                            class="btn btn-warning btn-icon btn-square btntableDataEdit"><i
                            class="fas fa-pencil-alt"></i>
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="ajaxPagination">
        {!! $layers->onEachSide(5)->links() !!}
    </div>
</div>
