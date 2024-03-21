<div id="geo_location_log_show_quick_panel" class="kt-quick-panel py-5 px-3">
    <div class="geo_location_log_show_quick_panel__head">
        <h5 class="geo_location_log_show_quick_panel__title mb-0 col-md-12">
            ভৌগলিক তথ্য লগ </span></a></li>
            <!--<small>5</small>-->
        </h5>
        <a href="javascript:;" class="kt-quick-panel__close" id="geo_location_log_show_quick_panel_close_btn"><i
                class="flaticon2-delete"></i></a>
    </div>
    <div class="geo_location_log_show_quick_panel__content">
    </div>
</div>

<script>
    $("#geo_location_log_show_quick_panel_close_btn").click(function () {
        $("#geo_location_log_show_quick_panel").removeAttr('style');
        $("#geo_location_log_show_quick_panel").css('opacity', 0);
        $("#geo_location_log_show_quick_panel").removeClass('kt-quick-panel--on');
        $("html").removeClass("side-panel-overlay");
    });

</script>


