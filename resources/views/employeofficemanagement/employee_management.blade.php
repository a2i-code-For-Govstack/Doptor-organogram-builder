<div class="row">
    <div class="col-md-12">
        @foreach ($office_units as $office_unit)
            <table class="table table-bordered">
                <thead class="table-head-color">
                    <tr class="group">
                        <td colspan="2" style="font-size: 1.5rem">{{ $office_unit->unit_name_bng }}</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($office_unit->active_organograms as $organogram)
                        <tr id="checked_unit_{{$office_unit->id}}_org_{{$organogram->id}}" role="row" class="check_row">
                            <td style="width: 40%;">
                                <input type="checkbox"
                                    @if ($organogram->assigned_user) disabled="true" checked="true" @endif>
                                &nbsp;{{ $organogram->designation_bng }}

                                @if ($organogram->last_assigned_user)
                                    (পূর্ববর্তী কর্মকর্তা:
                                    {{ @$organogram->last_assigned_user->employee_record->full_name_bng }} -
                                    {{ @$organogram->last_assigned_user->employee_record->user->username }})
                                @endif
                            </td>
                            @if (!empty($organogram->assigned_user->employee_record->full_name_bng))
                                <td style="width: 60%;" class="form-group">
                                    {{ @$organogram->assigned_user->employee_record->full_name_bng }}
                                    @if (!empty($organogram->assigned_user->employee_record->user))
                                        ({{ @$organogram->assigned_user->employee_record->user->username }})
                                    @endif
                                </td>
                            @else
                                <td style="width: 60%;" class="form-groupman">
                                    <div class="row_inside_input" id="checked_input_field_{{ $organogram->id }}">
                                        <div class="input-group">
                                            <input id="office_id{{ $organogram->id }}" type="hidden" name=""
                                                value="{{ $organogram->office_id }}">

                                            <input id="office_unit_id{{ $organogram->id }}" type="hidden"
                                                name="office_unit_id" value="{{ $organogram->office_unit_id }}">

                                            <input id="office_unit_organogram_id{{ $organogram->id }}" type="hidden"
                                                name="office_unit_organogram_id" value="{{ $organogram->id }}">

                                            <input id="designation_bng{{ $organogram->id }}" type="hidden"
                                                name="designation" value="{{ $organogram->designation_bng }}">

                                            <input id="designation_eng{{ $organogram->id }}" type="hidden"
                                                name="designation_en" value="{{ $organogram->designation_eng }}">

                                            <input id="designation_level{{ $organogram->id }}" type="hidden"
                                                name="designation_level"
                                                value="{{ $organogram->designation_level }}">

                                            <input id="designation_sequence{{ $organogram->id }}" type="hidden"
                                                name="designation_sequence"
                                                value="{{ $organogram->designation_sequence }}">

                                            <input id="unit_name_bn{{ $organogram->id }}" type="hidden"
                                                name="unit_name_bn" value="{{ $office_unit->unit_name_bng }}">

                                            <input id="unit_name_en{{ $organogram->id }}" type="hidden"
                                                name="unit_name_en" value="{{ $office_unit->unit_name_eng }}">

                                            <input id="office_name_bng{{ $organogram->id }}" type="hidden"
                                                name="office_name_bng"
                                                value="{{ $office_unit->office_info->office_name_bng }}">

                                            <input id="office_name_eng{{ $organogram->id }}" type="hidden"
                                                name="office_name_eng"
                                                value="{{ $office_unit->office_info->office_name_eng }}">

                                            <!-- <input id="employee_record_id{{ $organogram->id }}" type="hidden" name="employee_record_id" value=""> -->


                                            <input id="joining_date{{ $organogram->id }}" name="joining_date"
                                                type="text" class="form-control rounded-0 date"
                                                placeholder="দিন-মাস-বছর"
                                                aria-label="Recipient's username with two button addons"
                                                aria-describedby="button-addon4">
                                            <select class="custom-select rounded-0 incharge_label"
                                                id="incharge_label{{ $organogram->id }}" name="incharge_label"
                                                aria-label="Example select with button addon" style="height: 40px;">
                                                <option value="" selected>--বাছাই করুন--</option>
                                                @foreach ($office_incharges as $incharge)
                                                    <option value="{{ $incharge->name_bng }}">
                                                        {{ $incharge->name_bng }}</option>
                                                @endforeach
                                                <option id="other">অন্যান্য</option>
                                            </select>
                                            <div class="input-group-append rounded-0" id="button-addon4">
                                                {{-- <button class="btn btn-outline-secondary addOfficeEmployee" type="button"><i
                                                    class="fa fa-paper-plane" aria-hidden="true"></i> Button
                                            </button> --}}
                                                <button class="addOfficeEmployee" type="button"
                                                    style="background-color: #8051A3;color: #FFF;"
                                                    data-id="{{ $organogram->id }}"><i style="color:#fff"
                                                        class="far fa-hand-point-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    </div>

    <script !src="">
        $('.row_inside_input').hide();
        $(".check_row input:checkbox").change(function() {
            var ischecked = $(this).is(':checked');
            var row_id = $(this).closest('td').next('td').find('div').attr('id');
            if (ischecked) {
                $('#' + row_id).show();
            } else {
                $('#' + row_id).hide();
            }
        });

        $('.date').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
    </script>

</div>

<!-- end::Form Quick Panel -->
<img id="loader" src="{{ asset('assets/plugins/global/images/owl.carousel/ajax-loader.gif') }}" alt="">
<!-- begin::Scrolltop -->
<div id="kt_scrolltop" class="kt-scrolltop">
    <i class="fa fa-arrow-up"></i>
</div>

<script !src="">
    $('#loader').hide();
    $('.row_inside_input').hide();
    $(".check_row input:checkbox").change(function() {
        var ischecked = $(this).is(':checked');
        var row_id = $(this).closest('td').next('td').find('div').attr('id');
        if (ischecked) {
            $('#' + row_id).show();
        } else {
            $('#' + row_id).hide();
        }
    });

    $(function() {

        var sel_user_options = $("select.incharge_label"),
            opts = sel_user_options.find('option');


        sel_user_options.bind('change', function(e) {

            e.preventDefault();

            var optselected = $(this).find("option:selected");

            if (optselected.attr('id') == 'other') {

                sel_user_options.after(
                    "<div class='additional'><input class='form-control' id=other name='other' placeholder='টাইপ করুন'/></div>"
                );

                var oth = $("input#other");

                oth.keydown(function(e) {
                    optselected.html($(this).val());
                });

            } else {
                $('.additional').hide();
            }

        });
    });
</script>
