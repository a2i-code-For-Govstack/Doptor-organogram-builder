<div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1"
     data-ktmenu-dropdown-timeout="500">
    <ul class="kt-menu__nav py-0">
        {!! loadNavigationMenu($userPermittedMenus) !!}
    </ul>
</div>

<script>
    $(document).ready(function () {
        $('.kt-menu__nav .kt-menu__item--active').parents('.kt-menu__item--submenu').addClass('kt-menu__item--open')
    })
</script>
