<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
    <tr class="text-center">
        <th width="20%">পদবি</th>
        <th width="20%">প্রতিকল্পকৃত পদবি</th>
        <th width="10%">প্রতিকল্পকারি ব্যক্তি</th>
        <th width="10%">ছুটি শুরু</th>
        <th width="10%">ছুটি শেষ</th>
        <th width="10%">কার্যক্রম</th>
    </tr>
    </thead>
    <tbody>
    @foreach($protikolpo_obosta as $protikolpo)
        <tr>
            <input type="hidden" id="office_unit_organogram_id_{{$protikolpo['protikolpo_id']}}" name=""
                   value="{{$protikolpo['office_unit_organogram_id']}}">

            <input type="hidden" id="active_status_{{$protikolpo['protikolpo_id']}}" name=""
                   value="{{$protikolpo['active_status']}}">

            <td>{{$protikolpo['designation']}}, {{$protikolpo['unit_name_bn']}},{{$protikolpo['office_name_bn']}}</td>

            <td>@if($protikolpo['protikolpo_name']) {{$protikolpo['protikolpo_name']}}
                ,{{$protikolpo['protikolpo_office_unit']}} @endif</td>
            <td>{{$protikolpo['employee_office_id_to_name']}}</td>
            <td>
                @if($protikolpo['protikolpo_name'])
                    @if($protikolpo['active_status'] == 1)
                        {{$protikolpo['protikolpo_start_date']}}

                    @else
                        <input id="start_date_{{$protikolpo['protikolpo_id']}}" class="form-control date" type="text"
                               name="" value="{{$protikolpo['protikolpo_start_date']}}">

                    @endif
                @endif

            </td>
            <td>
                @if($protikolpo['protikolpo_name'])
                    <input id="end_date_{{$protikolpo['protikolpo_id']}}" class="form-control date" type="text" name=""
                           value="{{$protikolpo['protikolpo_end_date']}}"></td>
            @endif
            <td>
                @if($protikolpo['protikolpo_name'])
                    <div class="btn-group">
                        <button style="height: 30px;width: 30px;" type="button"
                                data-id="{{$protikolpo['protikolpo_id']}}"
                                class="btn  btn-icon  btn-outline-brand edit_protikolpo"><i
                                class="fas fa-pencil-alt"></i></button>
                        @if($protikolpo['active_status'] != 1)
                        <button style="height: 30px;width: 30px;" type="button"
                                data-id="{{$protikolpo['protikolpo_id']}}"
                                class="btn  btn-icon  btn-outline-warning active_protikolpo">
                            <i
                                class="fas fa-random"></i></button>
                        @endif()
                        <button style="height: 30px;width: 30px;" type="button"
                                data-id=""
                                class="btn  btn-icon  btn-outline-danger"><i
                                class="fas fa-trash-alt"></i></button>
                    </div>
                @else
                    <a href="{{ url('protikolpo_management') }}" style="height: 30px;width: 30px;" type="button"
                       data-id="{{$protikolpo['protikolpo_id']}}"
                       class="btn  btn-icon  btn-outline-brand"><i
                            class="fas fa-pencil-alt"></i></a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<script type="text/javascript">
    tapp_table_init();
</script>
