<style>
    #ajaxForm {
        width: 100%;
        position: relative;
    }
</style>
<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
    <tr class="text-center">
        <th>Higher Unit Name</th>
        <th>Unit Name ( Others )</th>
        <th>Unit Name ( English )</th>
        <th>Unit Code</th>
        <th>Unit Order</th>
        <th class="no-sort">Activity</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($office_units as $key => $unit)
        <tr class="text-center">
            <td id="parent_unit{{ $unit->id }}">
                @if ($unit->parent_unit_id)
                    {{ @$unit->parentUnit->unit_name_bng }}
                @endif
            </td>
            <td id="unit_name_bng{{ $unit->id }}">{{ $unit->unit_name_bng }}</td>
            <td id="unit_name_eng{{ $unit->id }}">{{ $unit->unit_name_eng }}</td>
            <td id="shaka_code{{ $unit->id }}">{{ enTobn($unit->unit_nothi_code) }}</td>
            <td id="shaka_level{{ $unit->id }}">{{ enTobn($unit->unit_level) }}</td>
            <td class="text-center">
                <button style="height: 30px;width: 30px" data-id="{{ $unit->id }}" type="button"
                        class="btn btn-icon btn-outline-brand view_modal"><i class="fas fa-pencil-alt"></i></button>
                <button style="height: 30px;width: 30px" data-id="{{ $unit->id }}" type="button"
                        class="btn btn-icon btn-outline-brand view-history"><i class="fas fa-eye"></i></button>
            </td>

        </tr>
    @endforeach
    </tbody>
</table>
<!-- Edit Modal -->
<div id="ajaxForm">
    <div class="modal fade bd-example-modal-lg" id="editModal" tabindex="-1" role="dialog"
         aria-labelledby="editModalTable" aria-hidden="true">
        <div class=""></div>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTable">Edit unit information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="edit_form">
                    <div id="modal_body" class="modal-body">

                    </div>
                    @method('POST')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary edit_button">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="historyModal" tabindex="-1" role="dialog"
     aria-labelledby="editModalTable" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalTable">Unit change history</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="history_modal_body" class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    no_order_tapp_table_init();
    $(".table tbody").on('click', '.view_modal', function () {
        var id = $(this).data("id");
        $.ajax({
            method: "GET",
            url: "get_office_unit/" + id,
            data: id,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data, textStatus, jqXHR) {
                $("#modal_body").html(data);
                $("#editModal").modal("show");
            }
        });
    });

    $(".edit_button").click(function () {
        KTApp.block('#editModal')
        id = $('[name=id]').val();
        data = new FormData($('#edit_form')[0]);

        data = $('#edit_form').serializeArray();
        data = removeFromSerializeArray(data, ['mobile[]', 'phone[]', 'phone_radio', 'mobile_radio']);

        phones = [];
        default_phone = '';
        $("[id^=unit_update_phone]").each(function (index, element) {
            if ($(element).val() != '') {
                phone = {};
                is_default = $(element).next().children().first().is(':checked') ? 1 : 0;
                phone[is_default] = $(element).val()
                phones.push(phone);
                if (is_default) {
                    default_phone = $(element).val();
                }
            }
        });

        mobiles = [];
        default_mobile = '';

        $("[id^=unit_update_mobile]").each(function (index, element) {
            if ($(element).val() != '') {
                mobile = {};
                is_default = $(element).next().children().first().is(':checked') ? 1 : 0;
                mobile[is_default] = $(element).val()
                mobiles.push(mobile);
                if (is_default) {
                    default_mobile = $(element).val();
                }
            }
        });

        data.push({name: 'phones', value: JSON.stringify(phones)});
        data.push({name: 'mobiles', value: JSON.stringify(mobiles)});
        data.push({name: 'phone', value: default_phone});
        data.push({name: 'mobile', value: default_mobile});

        url = "{{url('office_unit_update')}}";


        Server_Async(url, data, 'post').done(function (response) {
            if (response.status == 'success') {
                toastr.success('Successfully updated.');
                name_bng = $('#unit_name_bng').val();
                name_eng = $('#unit_name_eng').val();
                unit_nothi_code = $('#unit_nothi_code').val();
                unit_level = '';
                $.each(data, function (i, field) {
                    if (field.name == 'unit_level')
                        unit_level = field.value;
                });
                unit_level = enTobn(unit_level);
                parent_unit_id = $("#parent_unit_id option:selected").val();

                $('#unit_name_bng' + id).text(name_bng);
                $('#unit_name_eng' + id).text(name_eng);
                $('#shaka_code' + id).text(unit_nothi_code);
                $('#shaka_level' + id).text(unit_level);

                if (parent_unit_id != 0) {
                    parent_unit = $("#parent_unit_id option:selected").text();
                    $('#parent_unit' + id).text(parent_unit);
                }

                $("#editModal").modal("hide");
            } else {
                toastr.error('It is not possible to correct the name of the Unit.');
            }
            KTApp.unblock('#editModal')
        })
    });

    $(".table tbody").on('click', '.view-history', function () {
        unit_id = $(this).data("id");
        $.ajax({
            method: "GET",
            url: "get_office_unit_history/" + unit_id,
            data: unit_id,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data, textStatus, jqXHR) {
                $("#history_modal_body").html(data);
                $("#historyModal").modal("show");
            }
        });
    });

    var info = '{{ $emptyInfo }}';
    if (info == 'unit_info') {
        toastr.error('Please update the office Unit code.');
    }
</script>
