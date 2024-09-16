<div class="kt-header__topbar-item kt-header__topbar-item--user">
    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
        <div class="kt-header__topbar-user justify-content-between align-items-center d-flex">
            <div class="mr-2">
                @if(Auth::user()->user_role_id == config('menu_role_map.super_admin'))
                    <h4 class="font-weight-bold text-right mb-0">{{ Auth::user()->employee->full_name_bng ?? 'Super Admin' }}</h4>
                    <p class="text-right mb-1">{{ Auth::user()->username}}</p>
                @elseif(Auth::user()->user_role_id == config('menu_role_map.admin'))
                    <h4 class="font-weight-bold text-right mb-0">Admin</h4>
                    <p class="text-right mb-1">{{ Auth::user()->username}}</p>
                @else
                    <h4 class="font-weight-bold text-right mb-0">{{ Auth::user()->employee->full_name_bng ?? Auth::user()->username }}</h4>
                    <p class="text-right mb-1">{{ Auth::user()->current_designation->designation ?? '' }}</p>
                @endif
            </div>

            <div>
                <img
                    class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold"
                    src="{{Auth::user()->employee ? Auth::user()->employee->profile_picture():asset('images/no.png')}}"
                    alt="image">
            </div>

        </div>
    </div>
    <div
        class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">

        <!--begin: Head -->
        <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x pt-2 pb-2"
             style="background-image: url({{asset('assets/media/misc/bg-1.jpg')}})">
            <div class="kt-user-card__avatar">
                <img class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success"
                     src="{{Auth::user()->employee ? Auth::user()->employee->profile_picture():asset('images/no.png')}}"
                     alt="image">
            </div>
            <div class="kt-user-card__name">
                {{ Auth::user()->employee->full_name_bng ?? Auth::user()->username  }}
                <p class="h6"> {{ Auth::user()->current_designation->designation ?? '' }} </p>
                <p class="h6"> {{ Auth::user()->current_designation->office_info->office_name_bng ?? '' }} </p>
            </div>
        </div>

        <!--end: Head -->

        <!--begin: Navigation -->
        <div class="kt-notification" style="overflow-y: auto; max-height: 60vh;">
            <div>
                @foreach($userOffices as $userOffice)
                    <a href="{{route('change.office', ['office_id' => $userOffice->office_id, 'office_unit_id' =>  $userOffice->office_unit_id, 'designation_id'=> $userOffice->office_unit_organogram_id])}}"
                       class="kt-notification__item {{Auth::user()->current_designation_id() == $userOffice->office_unit_organogram_id ?'bg-secondary': ''}}">
                        <div class="kt-notification__item-icon">
                            <i class="flaticon2-user-outline-symbol kt-font-danger"></i>
                        </div>
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title kt-font-bold">
                                {{$userOffice->designation}}
                                {{$userOffice->incharge_label ? ', ('.$userOffice->incharge_label.')' : ''}}
                            </div>
                            <div class="kt-notification__item-time">
                                {{$userOffice->office_info->office_name_bng}}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <a href="{{ route('profile') }}"
               class="kt-notification__item">
                <div class="kt-notification__item-icon">
                    <i class="flaticon2-calendar-3 kt-font-success"></i>
                </div>
                <div class="kt-notification__item-details">
                    <div class="kt-notification__item-title kt-font-bold">
                        Profile Management
                    </div>
                </div>
            </a>

            <div class="kt-notification__custom kt-space-between">
                <a href="" target="_blank"
                   class="btn btn-label btn-label-brand btn-sm btn-bold w-100"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                {{--                <a href="custom/user/login-v2.html" target="_blank"--}}
                {{--                   class="btn btn-clean btn-sm btn-bold">Upgrade Plan</a>--}}
            </div>
        </div>

        <!--end: Navigation -->
    </div>
</div>
