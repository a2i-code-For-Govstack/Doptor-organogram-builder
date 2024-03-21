<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
       <tr class="text-center">
                <th  class="" width="10%">পদবি নাম ( বাংলা )</th>
                <th  class="" width="10%">পদবি নাম ( ইংরেজি )</th>
                <th class="" width="10%">শাখা</th>
                <th class="" width="10%">অফিস</th>
                <th class="no-sort" width="10%">কার্যক্রম</th>
            </tr>
        </thead>
        <tbody>
            @foreach($office_designations as $key => $desigantion)
            <tr class="text-center">
                <td id="designation_bng{{$desigantion->id}}">{{$desigantion->designation_bng}}</td>
                <td id="designation_eng{{$desigantion->id}}">{{$desigantion->designation_eng}}</td>
                <td> @if($desigantion->office_unit) {{$desigantion->office_unit->unit_name_bng}} @endif</td>
                <td>{{$desigantion->office_info->office_name_bng}}</td>
                <td class="text-center">
                    {{-- <button style="height: 30px;width: 30px" data-id="{{$desigantion->id}}" class="btn btn-icon btn-outline-brand view_modal"><i class="fas fa-pencil-alt"></i></button> --}}
                    <button style="height: 30px;width: 30px" data-id="{{$desigantion->id}}" class="btn btn-icon btn-outline-brand view-history"><i class="fas fa-eye"></i></button>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

            <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTable" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTable">পদবি পরিবর্তন করুন</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="edit_form">
                    <div id="modal_body" class="modal-body">

                    </div>
                    @method('POST')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary edit_button">সংরক্ষণ</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">বন্ধ করুন</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="editModalTable" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTable">পদবি পরিবর্তন ইতিহাস</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="history_modal_body" class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">বন্ধ করুন</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
     tapp_table_init();
    $(".table tbody").on('click','.view_modal',function () {
        var id = $(this).data("id");
        $.ajax({
            method: "GET",
            url: "get_office_designation/" + id,
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
            var data = new FormData($('#edit_form')[0]);
            var id = $('[name=id]').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "office_designation_update",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data, textStatus, jqXHR) {
                }
            }).done(function () {
                toastr.success('সফলভাবে হালনাগাদ হয়েছে।');
                var name_bng = $('#designation_bng').val();
                var name_eng = $('#designation_eng').val();
                $('#designation_bng'+id).text(name_bng);
                $('#designation_eng'+id).text(name_eng);
                $("#editModal").modal("hide");
                // location.reload();
            }).fail(function (data, textStatus, jqXHR) {
                toastr.error('Enternal Server Error');
            });
        });

        $(".table tbody").on('click','.view-history',function () {
            // $("#historyModal").modal("show");
            var designation_id = $(this).data("id");

            $.ajax({
                method: "GET",
                url: "get_office_designation_history/" + designation_id,
                data: designation_id,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data, textStatus, jqXHR) {
                    $("#history_modal_body").html(data);
                    $("#historyModal").modal("show");
                }
            });
        });
</script>
