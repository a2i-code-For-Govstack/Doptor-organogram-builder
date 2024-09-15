@if(count($alert_notifications)>0 && session('alert_notifications') == 'show')
    <div class="alert alert-warning alert-dismissible fade show alert_notification_area" role="alert">
        @foreach($alert_notifications as $key => $alert_notification)
            <p class="mb-1">{{$alert_notification}}</p>
            @if(!$loop->last)
            @endif
        @endforeach
        <button onclick="clearAlertNotification()" type="button" class="close mt-1" data-dismiss="alert"
                aria-label="Close">
            <span aria-hidden="true"><i class="fa fa-times"></i></span>
        </button>
    </div>
@endif
