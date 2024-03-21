<input type="hidden" class="form-control mb-4" value="{{$unit_info->id}}" name="id" id="type_id">

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="type_name">শাখা নাম ( বাংলা )</label><span class="text-danger">*</span>
                <input required type="text" class="form-control mb-4 bangla" value="{{$unit_info->unit_name_bng}}"
                       name="unit_name_bng" id="unit_name_bng" placeholder="শাখা বাংলা">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="type_name">শাখা নাম ( ইংরেজী )</label><span class="text-danger">*</span>
                <input required type="text" class="form-control mb-4" value="{{$unit_info->unit_name_eng}}"
                       name="unit_name_eng" id="unit_name_eng" placeholder="শাখা ইংরেজিতে">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="type_name">শাখা কোড</label><span class="text-danger">*</span>
                <input minlength="3" maxlength="3" type="text" class="form-control mb-4"
                       value="{{enTobn($unit_info->unit_nothi_code)}}" id="unit_nothi_code" placeholder=" শাখা কোড">
                <input type="hidden" id="unit_nothi_code_hidden" name="unit_nothi_code"
                       value="{{$unit_info->unit_nothi_code}}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="type_name">উর্ধ্বতন শাখা</label>
                <select class="form-control" name="parent_unit_id" id="parent_unit_id">
                    <option value="0">--বাছাই করুন--</option>
                    @foreach($unit_list as $unit)

                        <option @if($unit->id == $unit_info->parent_unit_id) selected
                                @endif value="{{$unit->id}}">{{$unit->unit_name_bng}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="type_name">ফোনে নম্বর </label>
                <input type="text" class="form-control mb-4" value="{{enTobn($unit_info->phone)}}" name="phone"
                       id="phone"
                       maxlength="11" placeholder="মোবাইল নম্বর">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="type_name">মোবাইল</label>
                <input type="text" class="form-control mb-4" value="{{enTobn($unit_info->phone)}}" name="phone"
                       id="phone"
                       maxlength="11" placeholder="মোবাইল নম্বর">
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="type_name">ফোন নম্বর</label>
                <div class="phone-numbers">
                    @if(count($phones) > 0)
                        @foreach($phones as $unit_information)
                            @if($unit_information->type == 'phone')
                                <div class="input-group mb-4">
                                    <input type="text" class="form-control"
                                           value="{{enTobn($unit_information->content)}}"
                                           onkeyup="checkInformationValidation($(this), `phone`)"
                                           id="unit_update_phone{{$loop->iteration}}" name="mobile[]" maxlength="11"
                                           placeholder="ফোন">
                                    <div class="input-group-append">
                                        <input style="margin: 0 10px; accent-color: green" type="radio"
                                               title="ডিফল্ট করুন"
                                               name="phone_radio" {{$unit_information->is_default == 1? 'checked':''}}>
                                        @if($loop->iteration < 2)
                                            <button class="btn btn-success add-phone" type="button"><i
                                                    title="যোগ করুন" class="fas fa-plus"></i>
                                            </button>
                                        @else
                                            <button title="বাতিল করুন" class="btn btn-danger remove-phone"
                                                    type="button"><i
                                                    class="fas fa-minus"></i></button>
                                        @endif

                                    </div>
                                </div>

                            @endif
                        @endforeach
                    @else
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" value="{{enTobn($unit_info->phone)}}"
                                   onkeyup="checkInformationValidation($(this), `phone`)"
                                   id="unit_update_phone1" name="phone[]" maxlength="11" placeholder="ফোন নম্বর">
                            <div class="input-group-append">
                                <input style="margin: 0 10px; accent-color: green" title="ডিফল্ট করুন" checked type="radio"
                                       name="phone_radio">
                                <button class="btn btn-success add-phone" type="button" title="যোগ করুন"><i
                                        class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="type_name">মোবাইল নম্বর</label>
                <div class="mobile-numbers">
                    @if(count($mobiles) > 0)
                        @foreach($mobiles as $unit_information)
                            @if($unit_information->type == 'mobile')
                                <div class="input-group mb-4">
                                    <input type="text" class="form-control"
                                           value="{{enTobn($unit_information->content)}}"
                                           onkeyup="checkInformationValidation($(this), `mobile`)"
                                           id="unit_update_mobile{{$loop->iteration}}" name="mobile[]" maxlength="14"
                                           placeholder="মোবাইল নম্বর">
                                    <div class="input-group-append">
                                        <input style="margin: 0 10px; accent-color: green" type="radio"
                                               title="ডিফল্ট করুন"
                                               name="mobile_radio" {{$unit_information->is_default == 1? 'checked':''}}>
                                        @if($loop->iteration < 2)
                                            <button class="btn btn-success add-mobile" type="button"><i
                                                    title="যোগ করুন" class="fas fa-plus"></i>
                                            </button>
                                        @else
                                            <button title="বাতিল করুন" class="btn btn-danger remove-mobile"
                                                    type="button"><i
                                                    class="fas fa-minus"></i></button>
                                        @endif
                                    </div>
                                </div>

                            @endif
                        @endforeach
                    @else
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" value="{{enTobn($unit_info->mobile)}}"
                                   onkeyup="checkInformationValidation($(this), `mobile`)" id="unit_update_mobile1"
                                   name="mobile[]" maxlength="14" placeholder="মোবাইল নম্বর">
                            <div class="input-group-append">
                                <input style="margin: 0 10px; accent-color: green" checked type="radio" title="ডিফল্ট করুন"
                                       name="mobile_radio">
                                <button title="যোগ করুন" class="btn btn-success add-mobile" type="button"><i
                                        class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="type_name">ইমেইল</label>
                <input type="text" class="form-control mb-4" value="{{$unit_info->email}}" name="email" id="email"
                       placeholder="ইমেইল">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="type_name">ফ্যাক্স</label>
                <input type="text" class="form-control mb-4" value="{{$unit_info->fax}}" name="fax" id="fax"
                       placeholder="ফ্যাক্স">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="type_name">ক্রম</label>
                <input type="text" class="form-control mb-4" value="{{enTobn($unit_info->unit_level)}}"
                       name="unit_level" id="unit_level" placeholder="ক্রম">
            </div>
        </div>
    </div>
</div>

<style>
    .alternative-data {
        display: none;
    }

    /* .add-more {
        cursor: pointer;
    } */
</style>

<script>

    $(document).ready(function () {
        var phoneIndex = 2;
        var mobileIndex = 2;

        // Add phone number
        $(".add-phone").click(function () {
            var phoneField = '<div class="input-group mb-4"><input type="text" class="form-control" id="unit_update_phone' +
                phoneIndex + '" name="phone[]" maxlength="11" onkeyup="checkInformationValidation($(this), `phone`)" placeholder="বিকল্প ফোন নম্বর"><div class="input-group-append"><input style="margin: 0 10px; accent-color: green" type="radio"  title="ডিফল্ট করুন" name="phone_radio"><button   title="বাতিল করুন" class="btn btn-danger remove-phone" type="button"><i class="fas fa-minus"></i></button></div></div>';
            $(".phone-numbers").append(phoneField);
            phoneIndex++;
        });

        // Remove phone number
        $(document).on("click", ".remove-phone", function () {
            $(this).closest(".input-group").remove();
        });

        // Add mobile number
        $(".add-mobile").click(function () {
            var mobileField = '<div class="input-group mb-4"><input type="text" class="form-control" id="unit_update_mobile' +
                mobileIndex + '" name="mobile[]" maxlength="14" placeholder="বিকল্প মোবাইল নম্বর"  onkeyup="checkInformationValidation($(this), `mobile`)"><div class="input-group-append"><input style="margin: 0 10px; accent-color: green" type="radio"  title="ডিফল্ট করুন" name="mobile_radio"><button   title="বাতিল করুন" class="btn btn-danger remove-mobile" type="button"><i class="fas fa-minus"></i></button></div></div>';
            $(".mobile-numbers").append(mobileField);
            mobileIndex++;
        });

        // Remove mobile number
        $(document).on("click", ".remove-mobile", function () {
            $(this).closest(".input-group").remove();
        });
    });

    $('.bangla').bangla({enable: true});
    $('#unit_level').on('blur', function () {
        this.value = this.value.replace(/[^০-৯0-9+]/gi, '');
    });

    $('#unit_nothi_code').on('blur', function () {
        number = $(this).val();
        number = number.replace(/[^০-৯0-9+]/gi, '');
        is_uni = isUnicode(number);
        if (is_uni) {
            converted = convertBanglaToEnglishNumber(number);
            $('#unit_nothi_code_hidden').val(converted);
        } else {
            $('#unit_nothi_code_hidden').val(number);
        }
    });

    function checkInformationValidation(elem, type = 'phone') {
        value = $(elem).val().replace(/[^০-৯0-9+]/gi, '');
        $(elem).val(value);
    }
</script>
