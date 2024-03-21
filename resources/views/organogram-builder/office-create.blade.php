<div class="row border pt-3 pb-3 mb-3" style="border-color: #7dbcff !important;">
    <div class="col-md-4 mb-1">
        <label for="office_ministry_id">মন্ত্রণালয়</label><span class="text-danger">*</span>
        <select id="office_ministry_id" name="office_ministry_id" class="form-control rounded-0 select-select2 mb-0"
                onchange="loadOfficeLayer($(this))">
            <option value="0">--বাছাই করুন--</option>
            @foreach($ministries as $ministy)
                <option value="{{$ministy->id}}">{{$ministy->name_bng}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4 mb-1">
        <label for="office_layer_id">অফিস পর্যায়</label><span class="text-danger">*</span>
        <select id="office_layer_id" name="office_layer_id" class="form-control rounded-0 select-select2 mb-0"
                onchange="loadOfficeOriginByLayer($(this))">
            <option value="0">--বাছাই করুন--</option>
        </select>
    </div>

    <div class="col-md-4 mb-1">
        <label for="office_origin_id">উর্ধ্বতন অফিস</label><span class="text-danger">*</span>
        <select id="office_origin_id" name="office_origin_id" class="form-control rounded-0 select-select2 mb-0">
            <option value="0">--বাছাই করুন--</option>
        </select>
    </div>
</div>

<div class="row border border-bottom-0 pt-3" style="border-color: #7dbcff !important;">
    <div class="col-md-6 mb-1">
        <label for="office_name_eng">নাম (ইংরেজি)</label><span class="text-danger">*</span>
        <input id="office_name_eng" onkeyup="$(this).val($(this).val().replace(/[^a-zA-Z0-9@ ._-]/gi, ''))" class="form-control rounded-0 english" type="text" name="office_name_eng">
    </div>
    <div class="col-md-6 mb-1">
        <label for="office_name_bng">নাম (বাংলা)</label><span class="text-danger">*</span>
        <input id="office_name_bng" class="form-control rounded-0 bangla" type="text" name="office_name_bng">
    </div>
</div>
<div class="row border border-bottom-0 border-top-0" style="border-color: #7dbcff !important;">
    <div class="col-md-4 mb-1">
        <label for="geo_division_id">বিভাগ</label><span class="text-danger">*</span>
        <select id="geo_division_id" name="geo_division_id" class="form-control rounded-0 select-select2 mb-0"
                onchange="loadZila($(this))">
            <option value="0">--বাছাই করুন--</option>
            @foreach($divisions as $geo_division)
                <option value="{{$geo_division->id}}">{{$geo_division->division_name_bng}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 mb-1">
        <label for="geo_district_id">জেলা</label><span class="text-danger">*</span>
        <select id="geo_district_id" name="geo_district_id" class="form-control rounded-0 select-select2 mb-0">
            <option value="0">--বাছাই করুন--</option>
        </select>
    </div>
    <div class="col-md-4 mb-1">
        <label for="geo_upazila_id">উপজেলা</label><span class="text-danger">*</span>
        <select id="geo_upazila_id" name="geo_upazila_id" class="form-control rounded-0 select-select2 mb-0">
            <option value="0">--বাছাই করুন--</option>
        </select>
    </div>
</div>
<div class="row  border border-top-0 pb-3" style="border-color: #7dbcff !important;">
    <div class="col-md-4 mb-1">
        <label for="office_address">ঠিকানা</label><span class="text-danger">*</span>
        <textarea id="office_address" class="form-control" name="office_address"
                  rows="1"></textarea>
    </div>
    <div class="col-md-4 mb-1">
        <label for="office_phone">ফোন</label>
        <input id="office_phone" class="form-control rounded-0 bijoy-bangla integer_type_positive"
               type="text" name="office_phone">
    </div>
    <div class="col-md-4 mb-1">
        <label for="office_mobile">মোবাইল</label><span class="text-danger">*</span>
        <input id="office_mobile" class="form-control rounded-0 bijoy-bangla integer_type_positive"
               onkeyup="$(this).val($(this).val().replace(/[^০-৯0-9+]/gi, ''))" type="text" name="office_mobile" maxlength="11">
    </div>
    <div class="col-md-4 mb-1">
        <label for="office_fax">ফ্যাক্স</label>
        <input id="office_fax" class="form-control rounded-0 bijoy-bangla integer_type_positive"
               type="text" name="office_fax">
    </div>
    <div class="col-md-4 mb-1">
        <label for="office_email">ই-মেইল</label><span class="text-danger">*</span>
        <input id="office_email" onkeyup="$(this).val($(this).val().replace(/[^a-zA-Z0-9@._-]/gi, ''))" class="form-control rounded-0" type="email" name="office_email">
    </div>
    <div class="col-md-4 mb-1">
        <label for="office_web">অফিস ওয়েবসাইট</label><span class="text-danger">*</span>
        <input id="office_web" class="form-control rounded-0" type="text" name="office_web">
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.select-select2').select2();
    });

    function loadOfficeLayer(elem) {
        ministry_id = $(elem).children("option:selected").val();
        var url = 'load_office_layer_ministry_wise';
        var data = {ministry_id};
        var datatype = 'html';
        ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (response) {
            $("#office_layer_id").html(response);
        });
    }

    function loadOfficeOriginByLayer(elem) {
        office_layer_id = $(elem).children("option:selected").val();
        var url = 'load_office_origin_office_layer_wise';

        var data = {office_layer_id};
        var datatype = 'html';
        ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (response) {
            $("#office_origin_id").html(response);
        });

        $('#office_origin_id').on('change', function () {
            loadOriginUnitOrganogramTree($(this));
        });

    }

    function loadZila(elem) {
        division_id = $(elem).children("option:selected").val();
        url = 'load_zila_division_wise';
        data = {division_id};
        datatype = 'html';
        ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
            $("#geo_district_id").html(responseDate);
            $("#geo_upazila_id").html('<option value="0">--বাছাই করুন--</option>');

            $('#geo_district_id').on('change', function () {
                loadUpoZila($(this));
            });
        });
    }

    function loadUpoZila(elem) {
        district_id = $(elem).children("option:selected").val();
        url = 'load_upozila_district_wise';
        data = {district_id};
        datatype = 'html';
        ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
            $("#geo_upazila_id").html(responseDate);
        });
    }

    function loadOriginUnitOrganogramTree(office_origin_id) {
        office_origin_id = $('#office_origin_id').val();
        url = 'org_builder_load_office_origin_unit_organogram_tree';
        data = {office_origin_id};
        datatype = 'html';

        ajaxCallUnsyncCallback(url, data, datatype, 'GET', function (responseDate) {
            $("#origin_organogram_tree").html(responseDate);
            KTTreeview.init();
            $(".kt_tree_22").jstree("open_all");
            $('.jstree-node').each(function (i, v) {
                selected_organograms_count++;
                id = $(this).attr('id');
                $(".kt_tree_22").jstree('select_node', id);
            })
        });
    }
</script>
