<div class="kt-header__topbar-item kt-header__topbar-item--user">
    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
        <div class="kt-header__topbar-user d-flex justify-content-end align-items-center">
            <div class="text-right mr-1">
                <span class="kt-header__topbar-welcome kt-hidden-mobile">Hi,</span>
                <span class="kt-header__topbar-username kt-hidden-mobile">{{ Auth::user()->employee->full_name_bng ?? Auth::user()->username }}</span>
            </div>
            <div>
                <img class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold"
                     src="{{ Auth::user()->employee ? Auth::user()->employee->profile_picture() : asset('https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png') }}"
                     alt="Profile Picture">
            </div>
        </div>
    </div>
    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">
        <!--begin: Head -->
        <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x pt-2 pb-2"
                style="background-image: url({{ asset('assets/media/misc/bg-1.jpg') }})">
            <div class="kt-user-card__avatar">
                <img class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success"
                     src="{{ Auth::user()->employee ? Auth::user()->employee->profile_picture() : asset('https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png') }}"
                     alt="Profile Picture">
            </div>
            <div class="kt-user-card__name">
                {{ Auth::user()->employee->full_name_bng ?? Auth::user()->username }}
                <p class="h6">{{ Auth::user()->current_designation->designation ?? '' }}</p>
                <p class="h6">{{ Auth::user()->current_designation->office_info->office_name_bng ?? '' }}</p>
            </div>
        </div>
        <!--end: Head -->

        <!--begin: Navigation -->
        <div class="kt-notification" style="overflow-y: auto; max-height: 30vh;">
            <div>
                @foreach($userOffices as $userOffice)
                    <a href="{{ route('change.office', ['office_id' => $userOffice->office_id, 'office_unit_id' =>  $userOffice->office_unit_id, 'designation_id' => $userOffice->office_unit_organogram_id]) }}"
                       class="kt-notification__item {{ Auth::user()->current_designation_id() == $userOffice->office_unit_organogram_id ? 'bg-secondary' : '' }}">
                        <div class="kt-notification__item-icon">
                            <i class="flaticon2-user-outline-symbol kt-font-danger"></i>
                        </div>
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title kt-font-bold">
                                {{ $userOffice->designation }}
                                {{ $userOffice->incharge_label ? ', (' . $userOffice->incharge_label . ')' : '' }}
                            </div>
                            <div class="kt-notification__item-time">
                                {{ $userOffice->office_info->office_name_bng }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <a href="{{ route('profile') }}" class="kt-notification__item">
                <div class="kt-notification__item-icon">
                    <i class="flaticon2-calendar-2 kt-font-success"></i>
                </div>
                <div class="kt-notification__item-details">
                    <div class="kt-notification__item-title kt-font-bold">
                        Profile Management 
                    </div>
                </div>
            </a>

            <div class="kt-notification__custom kt-space-between">
                <a href="" target="_blank" class="btn btn-label btn-label-brand btn-sm btn-bold w-100"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
        <!--end: Navigation -->
    </div>
</div>
