<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead>
    <tr class="text-center">
        <th>Name</th>
        <th>Login Id</th>
        <th>Designation & Unit</th>
        <th>Designation Label</th>
        <th>Designation Order</th>
        <th class="no-sort">Activity</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($ownOfficeOrgLebel as $key => $ownOfficeOrg)
        <tr class="text-center">
            <td>{{$ownOfficeOrg->assigned_user->employee_record->full_name_bng ?? ''}}</td>
            <td>{{$ownOfficeOrg->assigned_user_level->designation_user->username ?? ''}}</td>
            <td>{{ $ownOfficeOrg->designation_bng ?? '' }},
                <b>{{ $ownOfficeOrg->office_unit_org->unit_name_bng ?? '' }}</b></td>
            <td>{{ enTobn(!empty($ownOfficeOrg->designation_level) ? $ownOfficeOrg->designation_level : 999) }}</td>
            <td>{{ enTobn($ownOfficeOrg->designation_sequence) }}</td>
            <td>
                <button style="height: 30px;width: 30px;" type="button" id="btntableDataEdit_{{ $ownOfficeOrg->id }}"
                        data-content="{{ $ownOfficeOrg->id }},{{ $ownOfficeOrg->designation_level }},{{ $ownOfficeOrg->designation_sequence }}"
                        data-dismiss="modal" class="btn  btn-icon  btn-outline-brand btntableDataEdit"><i
                        class="fas fa-pencil-alt"></i></button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<link href="{{ asset('assets/plugins/custom/sweetalert2/dist/sweetalert2.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('assets/plugins/custom/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/sweetalert2.init.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/pages/components/extended/sweetalert2.js') }}" type="text/javascript"></script>

<script type="text/javascript">
    no_order_tapp_table_init('tapp_table');
</script>
