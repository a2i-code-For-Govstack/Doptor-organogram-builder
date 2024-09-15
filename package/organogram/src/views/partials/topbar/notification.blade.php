<style>
    body {
        font-family: Nikosh, SolaimanLipi, sans-serif;
    }

    .notification .badge {
        position: absolute;
        margin-top: 5px;
        margin-right: -30px;
        border-radius: 50%;
        background-color: #fd397a;
        color: white;
    }
</style>

<div class="kt-header__topbar-item" data-toggle="kt-tooltip" title="নোটিফিকেশন" data-placement="bottom">
    <a type="button" data-dismiss="modal" id="showNotifications" class="btn btn-icon btn-outline-info btn-sm notification"
        style="width:35px;height:35px;border:solid 1px;padding:3px;border-radius:3px;color:#4444f3!important;">
        <i style="font-size: 22px" class="fa fa-bell"></i>
        <span class="badge" id="notification_count"></span>
    </a>
</div>
<!-- begin::Form Quick Panel -->
<div id="kt_quick_panel_notification" class="kt-quick-panel py-5 px-3">
    <div class="kt_quick_panel__head">
        <h4 class="kt_quick_panel__title mb-0 font-weight-bold">নোটিফিকেশন</h4>
        <hr>
        <a href="#" class="kt-quick-panel__close" id="kt_quick_notification_close_btn"><i
                class="flaticon2-delete"></i></a>
    </div>
    <div class="load-message-data" id="view_message">
    </div>
</div>
<!-- end::Form Quick Panel -->


<!-- Start Modal -->
<div class="modal fade" id="showMessageModal" tabindex="-1" role="dialog" aria-labelledby="showMessageModalLabel"
    aria-hidden="true" data-toggle="modal" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg p-3 mb-5 bg-white rounded">
            <div class="modal-header">
                <label class="modal-title font-weight-bold" for="msg_header">শিরোনামঃ&nbsp;</label>
                <h4 class="modal-title font-weight-bold" id="msg_header"></h4>
                <button type="button" class="close close-message" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-justify">
                <p id="msg_body"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger close-button" data-dismiss="modal">বন্ধ করুন</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', "#showNotifications", function() {
        $("#kt_quick_panel_notification").addClass('kt-quick-panel--on');
        $("#kt_quick_panel_notification").css('opacity', 1);
    });

    $("#kt_quick_notification_close_btn").click(function() {
        $("#kt_quick_panel_notification").removeAttr('style');
        $("#kt_quick_panel_notification").css('opacity', 0);
        $("#kt_quick_panel_notification").removeClass('kt-quick-panel--on');
    });

    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
        if ($(".load-message-data").length > 0) {
            loadNotification();
        }
    });

    function loadNotification() {
        var url = 'notification_message';
        var data = {};
        var datatype = 'JSON';
        ajaxCallAsyncCallback(url, data, datatype, 'GET', function(responseData) {
            var data = responseData.notification;
            $('#view_message').empty();
            $('#notification_count').text(enTobn(responseData.count));
            if (data['read'] || data['unread']) {
                if (data['read']) {
                    $.each(data['read'], function(key, value) {
                        $('#view_message').prepend(
                            "<div class='card mt-3'> <a data-toggle='modal'data-target='#showMessageModal' onClick='showMessage(" +
                            value.id +
                            ")' type='button'class='card-header bg-secondary text-truncate'> <i class='fas fa-envelope-open-text'></i> শিরোনাম: " +
                            value.title +
                            " </a> <div class='card-body alert-danger'> <p class='card-text'style='display: -webkit-box;-webkit-line-clamp: 3;-webkit-box-orient: vertical;overflow: hidden;text-overflow: ellipsis; text-align: justify; text-justify: inter-word;'> বিবরণ: " +
                            value.message + "</p> <p> সময়: " + dateEnToBn(value.created) +
                            "<span style='float: right'>(দেখেছেন)</span></p> </div> </div>")
                    });
                }
                if (data['unread']) {
                    $.each(data['unread'], function(key, value) {
                        $('#view_message').prepend(
                            "<div class='card mt-3'> <a data-toggle='modal'data-target='#showMessageModal' onClick='showMessage(" +
                            value.id +
                            ")' type='button'class='card-header text-white bg-primary text-truncate'> <i class='fa fa-envelope'></i> শিরোনাম: " +
                            value.title +
                            " </a> <div class='card-body alert-info'> <p class='card-text'style='display: -webkit-box;-webkit-line-clamp: 3;-webkit-box-orient: vertical;overflow: hidden;text-overflow: ellipsis; text-align: justify; text-justify: inter-word;'> বিবরণ: " +
                            value.message + "</p> <p> সময়: " + dateEnToBn(value.created) +
                            "</p> </div> </div>")
                    });
                }
            } else {
                $('#view_message').append("<h4>কোনো নোটিফিকেশন নেই</h4>")
            }
        });
    }

    function showMessage(id) {

        $(".close-message").click(function() {
            loadNotification();
        });
        $(".close-button").click(function() {
            loadNotification();
        });

        var url = 'show_popup_notification';
        var data = {
            id
        };
        var datatype = 'JSON';
        ajaxCallAsyncCallback(url, data, datatype, 'GET', function(responseData) {
            $("#msg_header").text(responseData[0].title).css({
                'font-size': '13px !important'
            });
            $("#msg_body").html(responseData[0].message).css({
                'font-size': '13px !important'
            });
        })
    }
</script>
