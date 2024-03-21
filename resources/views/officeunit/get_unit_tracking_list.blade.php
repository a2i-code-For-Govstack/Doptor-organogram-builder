     <style>
        #ajaxForm {
            width: 100%;
            position: relative;
        }

        .loader-overly {
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: #eceaea;
            background-image: url({{asset('assets/plugins/global/images/owl.carousel/ajax-loader.gif')}});
            background-size: 50px;
            background-repeat: no-repeat;
            background-position: center;
            z-index: 10000000;
            opacity: 0.4;
            filter: alpha(opacity=40);
            /*display: none;*/
        }
    </style>
<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
       <tr class="text-center">
                <th>উর্ধ্বতন শাখা</th>
                <th>শাখা নাম ( বাংলা )</th>
                <th>শাখা নাম ( ইংরেজি )</th>
                <th>শাখা কোড</th>
                <th class="no-sort">কার্যক্রম</th>
            </tr>
        </thead>
        <tbody>
            @foreach($office_units as $key => $unit)
            <tr class="text-center">
                <td id="parent_unit{{$unit->id}}">
                    @if($unit->parent_unit_id)
                    {{$unit->unit_name_bng}}
                    @endif
                </td>
                <td id="unit_name_bng{{$unit->id}}">{{$unit->unit_name_bng}}</td>
                <td id="unit_name_eng{{$unit->id}}">{{$unit->unit_name_eng}}</td>
                <td id="shaka_code{{$unit->id}}">{{enTobn($unit->unit_nothi_code)}}</td>
                <td class="text-center">
                    {{-- <button style="height: 30px;width: 30px" data-id="{{$unit->id}}"
                    type="button" class="btn btn-icon btn-outline-brand view_modal"><i class="fas fa-pencil-alt"></i></button> --}}
                    <button style="height: 30px;width: 30px" data-id="{{$unit->id}}"
                    type="button" class="btn btn-icon btn-outline-brand view-history"><i class="fas fa-eye"></i></button>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>


    <!-- Edit Modal -->
    <div id="ajaxForm">

        <div class="modal fade bd-example-modal-lg" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTable" aria-hidden="true">
            <div id="loader-overly" class=""></div>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTable">শাখা পরিবর্তন করুন</h5>
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
    </div>
    <div class="modal fade bd-example-modal-lg" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="editModalTable" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTable">শাখা পরিবর্তন ইতিহাস</h5>
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
         $('#loader-overly').addClass('loader-overly');
            var data = new FormData($('#edit_form')[0]);
            var id = $('[name=id]').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "office_unit_update",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data, textStatus, jqXHR) {
                }
            }).done(function () {
                toastr.success('সফলভাবে হালনাগাদ হয়েছে।');
                var name_bng = $('#unit_name_bng').val();
                var name_eng = $('#unit_name_eng').val();
                var unit_nothi_code = $('#unit_nothi_code').val();
                var parent_unit_id = $( "#parent_unit_id option:selected" ).val();

                $('#unit_name_bng'+id).text(name_bng);
                $('#unit_name_eng'+id).text(name_eng);
                $('#shaka_code'+id).text(unit_nothi_code);

                if(parent_unit_id != 0){
                    var parent_unit = $( "#parent_unit_id option:selected" ).text();
                    $('#parent_unit'+id).text(parent_unit);
                }

                $("#editModal").modal("hide");
                $('#loader-overly').removeClass('loader-overly');
                // location.reload();
            }).fail(function (data, textStatus, jqXHR) {
                toastr.error('Enternal Server Error');
            });
        });

     $(".table tbody").on('click','.view-history',function () {
            // $("#historyModal").modal("show");
            var unit_id = $(this).data("id");
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


</script>
