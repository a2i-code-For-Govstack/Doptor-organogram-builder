<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
       <tr class="text-center">
            <th>ক্রম</th>
            <th class="">অফিসের নাম</th>
            <th class="">শাখা সংশোধন</th>
            <th class="">পদবি সংশোধন</th>
            <th class="">কার্যক্রম</th>
        </tr>
        </thead>
        <tbody>


        @foreach($office_list as $office)

            @php
                $section = 0;
                $designation = 0;
            @endphp
                @if($office->unit_organogram_edit_option == 0)
                    @php
                        $section = 'NO';
                        $designation = 'NO';
                    @endphp
                @elseif($office->unit_organogram_edit_option == 1)
                    @php
                        $section = 'YES';
                        $designation = 'YES';
                    @endphp

                @elseif($office->unit_organogram_edit_option == 2)
                    @php
                        $section = 'YES';
                        $designation = 'NO';
                    @endphp

                @elseif($office->unit_organogram_edit_option == 3)
                    @php
                        $section = 'NO';
                        $designation = 'YES';
                    @endphp
                @endif
            <tr class="text-center">
            <td>{{ $loop->iteration }}</td>
            <td>{{ $office->office_name_bng }}</td>
            <td>
                <span class="kt-switch kt-switch--icon">
                    <label>
                        <input class="section" id="section{{$office->id}}" type="checkbox" data-id="{{$office->id}}" value="{{$section}}" <?php if($section == 'YES'){echo 'checked';} ?> name="section[]">
                        <span></span>
                    </label>
                </span>
            </td>
            <td>
                <span class="kt-switch kt-switch--icon">
                    <label>
                        <input class="designation" id="designation{{$office->id}}" type="checkbox" data-id="{{$office->id}}" value="{{$designation}}" <?php if($designation == 'YES'){echo 'checked';} ?> name="designation[]">
                        <span></span>
                    </label>
                </span>
            </td>
            <td>
                <button  data-id="{{$office->id}}" type="button" class="btn btn-md btn-primary officeSetting"  id="officeSetting" >সংরক্ষণ</button>
            </td>
        </tr>

        @endforeach
        </tbody>

    </table>


<script type="text/javascript">
tapp_table_init();
    $(".officeSetting").click(function(){

        var office_id = $(this).attr('data-id');
        var section = $('#section'+ office_id).val();
        var designation = $('#designation'+ office_id).val();
        var unit_organogram_edit_option = 0;

        if (section == 'NO' && designation == 'NO') {
            unit_organogram_edit_option = 0;
        }else if(section == 'YES' && designation == 'YES'){
            unit_organogram_edit_option = 1;
        }else if(section == 'YES' && designation == 'NO'){
            unit_organogram_edit_option = 2;
        }else if(section == 'NO' && designation == 'YES'){
            unit_organogram_edit_option = 3;
        }

        $.ajax({
            method: 'POST',
            url: "{{ url('section_designation_update') }}",
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {office_id:office_id,unit_organogram_edit_option:unit_organogram_edit_option}, // pass in json format
            success: function(data) {
                if (data.status === 'success') {
                    toastr.success(data.msg);
                }
                location.reload();
            },
            error : function(data){
                var errors = data.responseJSON;
                $.each(errors.errors,function (k,v) {
                    toastr.error(v);
                });
            }
        });
    });

    $(".section").change(function() {
        var section = $(this).val();
        if (section == 'YES') {
            $(this).val('NO');
        }else if(section == 'NO'){
           $(this).val('YES');
        }
    });

    $(".designation").change(function() {
        var designation = $(this).val();
        if (designation == 'YES') {
            $(this).val('NO');
        }else if(designation == 'NO'){
           $(this).val('YES');
        }
    });
</script>


