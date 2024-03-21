<div style="width:50%">
    <input placeholder="অনুসন্ধান" class="tree_search21 form-control" type="text" value="">
</div>
<div class="tree-demo kt_tree_21" id="treeTask">
    {!! loadOfficeOriginUnitOrganoTree($results,'child:originOrganograms','0:1') !!}
</div>

<script>
    function editOfficeOriginUnitOrganogram(e) {
        var link = $(event.target);//.find('a');
        var type = link.data('type');
        if (type === 'title') {
            $('#total_insert_group').addClass('d-none')
            document.getElementById("designation_form").reset();
            $("#id").val('');
            $("#superior_unit_id").val('');
            $("#office_origin_unit_id").val('');
            $("#office_ministry").val('');
            $("#office_origin").val('');
            $("#office_layer").val('');
            $("#short_name_eng").val('');
            $("#short_name_bng").val('');
            $("#kt_quick_panel").addClass('kt-quick-panel--on').css('opacity', 1);
            $("html").addClass("side-panel-overlay");

            var id = link.data('id'); //clicked node data-id
            var unit_id = link.data('unitid')
            var unit_name = $("a[data-id='" + unit_id + "']").text()

            var html_id = link.attr('id');

            var superior_html_li_id = $('#' + html_id).parent().parent().parent().parent().parent().attr('id');
            var superior_unit_id = $('#' + superior_html_li_id + ' a').attr('data-id');
            var superior_unit_text = $('#' + superior_html_li_id + '>a').text();
            loadUnitWiseOrganogram(unit_id, id);
            loadUnit(unit_id, id);
            $('#id').val(id);
            editUnitOrganogram(id);
            $('#superior_unit_text').val(unit_name);
            $('#superior_unit_id').val(unit_id);

        }
    }

    function deleteOfficeOriginUnitOrganogram(e) {
        var elem = $(event.target);
        swal.fire({
            title: 'আপনি কি তথ্যটি মুছে ফেলতে চান?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'হ্যাঁ',
            cancelButtonText: 'না'
        }).then(function (result) {
            if (result.value) {

                var office_origin_organogram_id = elem.data('id');
                var unit_id = elem.data('unitid');
                var url = 'delete_office_origin_unit_organogram';
                var data = {office_origin_organogram_id, unit_id};
                var datatype = 'json';
                ajaxCallUnsyncCallback(url, data, datatype, 'post', function (response) {
                    if (response.status === 'success') {
                        toastr.success(response.msg)
                        var office_ministry_id = $('#office_ministry_id').val();
                        var office_layer_id = $('#office_layer_id').val();
                        var office_origin_id = $('#office_origin_id').val();
                        loadTree(office_ministry_id, office_layer_id, office_origin_id, true);
                    } else {
                        toastr.error(response.msg)
                        console.log(response.data ? response.data : '');
                    }
                });

            }
        });

    }

</script>
