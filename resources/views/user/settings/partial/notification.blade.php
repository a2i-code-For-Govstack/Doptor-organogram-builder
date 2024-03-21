<!--Begin:: App Content-->
<div class="kt-grid__item kt-grid__item--fluid kt-app__content">
    <div class="row">
        <div class="col-xl-6">

            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Notification
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body kt-portlet__body--fluid">
                    <div class="kt-widget12">
                        <div class="kt-widget12__content">
                            <form id="DataChange" action="{{ route('notification.change') }}" method="post"
                                  class="kt-form kt-form--label-right">
                                @csrf
                                <div class="kt-portlet__body">
                                    <div class="kt-section">
                                        <div class="kt-section__body">
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label"></label>
                                                <div class="col-2">
                                                    <b>Email</b>
                                                </div>
                                                <div class="col-3">
                                                    <b>SMS</b>
                                                </div>
                                            </div>

                                            @foreach ($events as $key => $event)
                                                @if($event->available_notification_setting(Auth::user()->employee->id))
                                                    <input type="hidden" name="data[{{$key}}][id]"
                                                           value="{{ $event->id }}">
                                                    <div class="form-group row">
                                                        <label
                                                            class="col-xl-3 col-lg-3 col-form-label">{{ $event->event_name_bng }}
                                                        </label>
                                                        <div class="col-2">
                                                            <span
                                                                class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                                                <label>
                                                                    <input type="checkbox" name="data[{{$key}}][email]" {{ $event->available_notification_setting(Auth::user()->employee->id)->email == 1 ? 'checked' : '' }}>
                                                                    <span></span>
                                                                </label>
                                                            </span>
                                                        </div>
                                                        <div class="col-2">
                                                            <span
                                                                class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                                                <label>
                                                                    <input type="checkbox" name="data[{{$key}}][sms]"  {{ $event->available_notification_setting(Auth::user()->employee->id)->sms == 1 ? 'checked' : '' }}>
                                                                    <span></span>
                                                                </label>
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="kt-portlet__foot">
                                    <div class="kt-form__actions">
                                        <div class="row">
                                            <div class="col-lg-3 col-xl-3">
                                            </div>
                                            <div class="col-lg-9 col-xl-9">
                                                <button type="submit" class="btn btn-success">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="kt-form__actions">
                                    <span
                                        class="h5 text-danger">** Some notification settings are reserved by super admin.</span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
