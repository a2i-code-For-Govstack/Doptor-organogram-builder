<?php

namespace a2i\organogram\Http\Controllers;

use a2i\organogram\Traits\UserInfoCollector;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, UserInfoCollector;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if ($this->checkLogin()) {
                $this->viewSharer();
            }
            return $next($request);
        });

    }

    public function viewSharer()
    {
        $userDetails = $this->getUserDetails();
        view()->share('userDetails', $userDetails);

        $userOffices = $this->getUserOfficesByDesignation();
        view()->share('userOffices', $userOffices);

        $userPermittedMenus = $this->getAssignedMenus();
        view()->share('userPermittedMenus', $userPermittedMenus);

        $userDesignation = $this->getUserOrganogramRoleName();
        view()->share('userDesignation', $userDesignation);

        $alert_notifications = $this->getAlertNotifications();
        view()->share('alert_notifications', $alert_notifications);
    }
}
