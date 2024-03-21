
<table id="menu_table"
       class="table tapp_table table-striped- table-bordered table-hover table-checkable  custom-table-border">
    <thead class="table-head-color">
    <tr class="text-center">
        <th width="5%" class="no-sort">Sl.</th>
        <th>Menu icon</th>
        <th>Menu Name</th>
        <th>Menu Link</th>
        <th>Parent Menu</th>
        {{--        <th>ক্রমিক</th>--}}
        <th class="no-sort">Edit</th>
    </tr>
    </thead>
    <tbody>
    @foreach($menus as $menu)
        <tr class="text-center">
            <td>{{enTobn($loop->iteration)}}</td>
            <td><i class="{{$menu->menu_icon}}"></i></td>
            <td>{{$menu->menu_name}}</td>
            <td>{{$menu->menu_link}}</td>
            <td>
                @php
                $parent = $menu->parent;
                $parent_string = "";
                @endphp

                @while($parent)
                    @php
                        $parent_string = $parent->menu_name . $parent_string;
                        $parent = $parent->parent;
                    @endphp

                    @if($parent)
                        @php
                            $parent_string = ' <i class="fa fa-chevron-right"></i> ' . $parent_string;
                        @endphp
                    @endif
                @endwhile

                {!! $parent_string !!}
            </td>
            <td>
                <button style="height: 30px;width: 30px;" type="button" id="btntableDataEdit_{{$menu->id}}"
                        data-content="{{$menu->id}},{{$menu->menu_name}},{{$menu->menu_link}},{{$menu->menu_icon}},{{$menu->parent_menu_id}},{{$menu->display_order}},{{$menu->status}}"
                        data-dismiss="modal"
                        class="btn  btn-icon  btn-outline-brand btntableDataEdit"><i
                        class="fas fa-pencil-alt"></i></button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
<link href="{{asset('assets/plugins/custom/sweetalert2/dist/sweetalert2.css')}}" rel="stylesheet" type="text/css"/>
<script src="{{asset('assets/plugins/custom/sweetalert2/dist/sweetalert2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/sweetalert2.init.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/pages/components/extended/sweetalert2.js')}}" type="text/javascript"></script>

<script type="text/javascript">

    tapp_table_init();
    $("#all").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });
</script>
