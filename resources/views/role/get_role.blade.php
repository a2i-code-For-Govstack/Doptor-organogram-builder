<div class="table-responsive">
    <table class="table table-bordered tapp_table text-center">
        <thead>
        <tr>
            <th>User Label</th>
            <th>Role</th>
            <th>Description</th>
            {{--            <th>সম্পাদনা</th>--}}
            {{--            <th width="10%">--}}
            {{--                <label class="kt-checkbox kt-checkbox--success float-left">--}}
            {{--                    <input type="checkbox">--}}
            {{--                    <span></span>--}}
            {{--                </label>--}}
            {{--                <button type="button"--}}
            {{--                class="btn btn-danger btn-icon btn-square float-left"><i--}}
            {{--                class="fas fa-trash-alt"></i></button>--}}
            {{--            </th>--}}
        </tr>
        </thead>
        <tbody>
        @foreach($roles as $role)
            <tr>
                <td>{{enTobn($role->user_level)}}</td>
                <td>{{$role->name}}</td>
                <td>{{$role->description}}</td>
                {{--                <td>--}}
                {{--                    <button type="button"--}}
                {{--                            data-content="{{$role->id}},{{$role->name}},{{$role->description}},{{$role->user_level}}"--}}
                {{--                            data-dismiss="modal"--}}
                {{--                            class="btn btn-warning btn-icon btn-square btntableDataEdit"><i--}}
                {{--                            class="fas fa-pencil-alt"></i></button>--}}
                {{--                </td>--}}
                {{--                <td>--}}
                {{--                    <label class="kt-checkbox kt-checkbox--success">--}}
                {{--                        <input type="checkbox">--}}
                {{--                        <span></span>--}}
                {{--                    </label>--}}
                {{--                </td>--}}
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script>
    tapp_table_init();

</script>
