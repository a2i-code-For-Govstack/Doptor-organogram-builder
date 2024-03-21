<div class="kt-content" id="kt_content">
    <!--begin::Form-->
    <hr>
    <form id="office_edit" class="kt-form kt-form--label-right">
        <div class="form-group row">
            <div class="col-lg-3">
                @method('PUT')
                <input type="hidden" name="id" value="{{ $office_info->id }}">
                <label for="geo_division_id">বিভাগ </label>
                <select autocomplete="off" id="geo_division_id" class="form-control rounded-0 select-select2"
                    name="geo_division_id">
                    <option value="0" selected="selected">----বাছাই করুন----</option>
                    @foreach ($bivags as $bivag)
                        <option data-bivag_bbs_code="{{ $bivag->bbs_code }}" value="{{ $bivag->id }}"
                            @if ($office_info->geo_division_id == $bivag->id) selected @endif>
                            {{ $bivag->division_name_bng }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                <label for="geo_district_id">জেলা </label>
                <select autocomplete="off" id="geo_district_id" class="form-control rounded-0 select-select2"
                    name="geo_district_id">
                    <option value="0" selected="selected">----বাছাই করুন----</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}" @if ($office_info->geo_district_id == $district->id) selected @endif>
                            {{ $district->district_name_bng }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                <label for="geo_upazila_id">উপজেলা </label>
                <select autocomplete="off" id="geo_upazila_id" class="form-control rounded-0 select-select2"
                    name="geo_upazila_id">
                    <option value="0" selected="selected">----বাছাই করুন----</option>
                    @foreach ($upozilas as $upozila)
                        <option value="{{ $upozila->id }}" @if ($office_info->geo_upazila_id == $upozila->id) selected @endif>
                            {{ $upozila->upazila_name_bng }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                <label for="geo_union_id">ইউনিয়ন </label>
                <select autocomplete="off" id="geo_union_id" class="form-control rounded-0 select-select2"
                    name="geo_union_id">
                    <option value="0" selected="selected">----বাছাই করুন----</option>
                    @foreach ($unions as $union)
                        <option value="{{ $union->id }}" @if ($office_info->geo_union_id == $union->id) selected @endif>
                            {{ $union->union_name_bng }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label for="office_name_bng">নাম </label>
                <input id="office_name_bng" class="form-control no-drop" type="text" name="office_name_bng"
                    readonly="" value="{{ $office_info->office_name_bng }}">
            </div>
            <div class="col-lg-6">
                <label for="office_name_eng">নাম ইংরেজী </label>
                <input id="office_name_eng" class="form-control no-drop" type="text" name="office_name_eng"
                    readonly="" value="{{ $office_info->office_name_eng }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12">
                <label for="office_address">ঠিকানা</label>
                <textarea id="office_address" name="office_address" class="form-control" rows="8">{{ $office_info->office_address }}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label for="office_phone">ফোন </label>
                <input class="form-control bijoy-bangla integer_type_positive" type="text" id="office_phone"
                    name="office_phone" value="{{ bnToen($office_info->office_phone) }}">
            </div>
            <div class="col-lg-6">
                <label for="office_mobile">মোবাইল </label>
                <input class="form-control bijoy-bangla integer_type_positive" type="text" id="office_mobile"
                    name="office_mobile" maxlength="11" value="{{ bnToen($office_info->office_mobile) }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label for="office_fax">ফ্যাক্স </label>
                <input class="form-control bijoy-bangla integer_type_positive" id="office_fax" type="text"
                    name="office_fax" value="{{ bnToen($office_info->office_fax) }}">
            </div>
            <div class="col-lg-6">
                <label for="office_email"> ই-মেইল </label>
                <input class="form-control" id="office_email" type="email" name="office_email"
                    value="{{ $office_info->office_email }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label for="office_web"> অফিস ওয়েবসাইট </label>
                <input class="form-control" type="text" id="office_web" name="office_web"
                    value="{{ $office_info->office_web }}">
            </div>
            <div class="col-lg-6">
                <label for="digital_nothi_code">ডিজিটাল নথি কোড (প্রথম ৮টি) * </label>
                <!--for inputmask-->
                {{-- data-inputmask="'mask': '**.**.****'" --}}
                <input class="form-control bijoy-bangla" id="digital_nothi_code" type="text"
                    name="digital_nothi_code" placeholder="00.00.0000"
                    value="{{ bnToen($office_info->digital_nothi_code) }}">
            </div>
        </div>
        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-lg-6">
                        <button type="button" id="edit_button" class="btn btn-primary">সংরক্ষণ
                        </button>
                        <button type="reset" class="btn btn-danger">রিসেট</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
{{-- <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"
            type="text/javascript"></script> --}}

<script type="text/javascript">
    $("select#geo_division_id").change(function() {
        var division_code = $(this).children("option:selected").attr('data-bivag_bbs_code');
        var division_id = $(this).children("option:selected").val();
        $('#division_bbs_code').val(division_code);
        // $('#division_bbs_code').val(division_code);
        loadZila(division_id);
    });

    // $("#digital_nothi_code").inputmask();
    $("#digital_nothi_code").mask('AA.AA.AAAA', {
        translation: {
            A: {
                pattern: /[\u09E6-\u09EF0-9]/
            },
        },
        placeholder: "**.**.****",
    });

    function loadZila(division_id) {
        var url = 'load_zila_division_wise';
        var data = {
            division_id
        };
        var datatype = 'html';
        ajaxCallUnsyncCallback(url, data, datatype, 'GET', function(responseDate) {
            $("#geo_district_id").html(responseDate);
        });
    }

    $("select#geo_district_id").change(function() {
        var district_code = $(this).children("option:selected").attr('data-zila_bbs_code');
        var district_id = $(this).children("option:selected").val();

        $('#district_bbs_code').val(district_code);
        // $('#division_bbs_code').val(division_code);
        loadUpoZila(district_id);
    });

    function loadUpoZila(district_id) {
        var url = 'load_upozila_district_wise';
        var data = {
            district_id
        };
        var datatype = 'html';
        ajaxCallUnsyncCallback(url, data, datatype, 'GET', function(responseDate) {
            $("#geo_upazila_id").html(responseDate);
        });
    }


    $("select#geo_upazila_id").change(function() {
        var upozila_id = $(this).children("option:selected").val();
        loadUnion(upozila_id);
    });

    function loadUnion(upozila_id) {
        var url = 'load_union_upozila_wise';
        var data = {
            upozila_id
        };
        var datatype = 'html';
        ajaxCallUnsyncCallback(url, data, datatype, 'GET', function(responseDate) {
            $("#geo_union_id").html(responseDate);
        });
    }

    $("#edit_button").click(function() {
        $(".error_msg").html('');
        var data = new FormData($('#office_edit')[0]);
        var id = $('[name=id]').val();
        KTApp.block('#kt_content');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: "office_update",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data, textStatus, jqXHR) {
                if (data.status == 'success') {
                    toastr.success('সফলভাবে হালনাগাদ হয়েছে।');
                } else {
                    toastr.error('আপনার ই-মেইলটি সঠিক নয়!');
                }
                KTApp.unblock('#kt_content');
            }
        }).fail(function(data, textStatus, jqXHR) {
            var json_data = JSON.parse(data.responseText);
            $.each(json_data.errors, function(edit_key, value) {
                $(edit_key).after(
                    "<span class='error_msg' style='color: red;font-weigh: 600'>" + value +
                    "</span>");
            });
        });
    });
</script>
