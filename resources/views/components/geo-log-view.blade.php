<button class="mr-3 btn btn-sm btn-info btn-square btn-icon"
        title="লগ দেখুন"
        data-geo-table="{{$geotablename}}"
        data-id="{{$geoid}}"
        onclick="shoGeoLocationLog($(this))">
    <i class="fa fa-eye"></i>
</button>

<script>

    function shoGeoLocationLog(element) {
        url = '{{url('get-geo-location-logs')}}';
        geo_table_name = element.data('geo-table');
        geo_id = element.data('id');
        data = {geo_table_name, geo_id}

        ajaxCallUnsyncCallbackBothDataType(url, data, 'post', function (response) {
            if (response.status === 'error') {
                toastr.error('No data found');
            } else {
                $(".geo_location_log_show_quick_panel__title").text('ভৌগলিক তথ্য লগ');
                $("#geo_location_log_show_quick_panel").addClass('kt-quick-panel--on');
                $("#geo_location_log_show_quick_panel").css('opacity', 1);
                $(".geo_location_log_show_quick_panel__content").html(response);
                $("html").addClass("side-panel-overlay");
            }
        });
    }

    $("#kt_quick_panel_close_btn").click(function () {
        $("#kt_quick_panel").removeAttr('style');
        $("#kt_quick_panel").css('opacity', 0);
        $("#kt_quick_panel").removeClass('kt-quick-panel--on');
        $("html").removeClass("side-panel-overlay");
    });
</script>
