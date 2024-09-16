@if($userDesignation)
    <div class="welcome_user ml-3">
        <p style=" border: 1px solid #5477ea; color: #5477ea;"
           class="h3 text-dark-75 text-shadow mb-0 py-1 px-3 bold">{{$userDesignation ? ' '.$userDesignation : ''}}</p>
    </div>
@else
    <div class="welcome_user ml-3">

    </div>
@endif
