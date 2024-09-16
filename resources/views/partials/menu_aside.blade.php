<style>
    #kt_aside_menu {
        background-color: #38c172;
    }

    #kt_aside_menu .kt-menu__nav {
        margin-top: 20px;
        background-color: #38c172; /* Ensuring nested items also have green background */
    }

    #kt_aside_menu .kt-menu__nav .kt-menu__item a {
        color: white; /* Make font color white for all menu items */
    }

    #kt_aside_menu .kt-menu__nav .kt-menu__item--submenu > a {
        color: white; /* Ensure that submenu items also have white color */
    }

    #kt_aside_menu .kt-menu__nav .kt-menu__item a:hover {
        color: #ffffff; /* Ensure hover state is also white */
    }

    #kt_aside_menu .kt-menu__nav .kt-menu__item--active > a {
        color: white !important; /* Ensure active items also have white color */
    }
</style>

<div id="kt_aside_menu" class="kt-aside-menu" data-ktmenu-vertical="1" data-ktmenu-scroll="1"
     data-ktmenu-dropdown-timeout="500">
    <ul class="kt-menu__nav py-0">
        {!! loadNavigationMenu($userPermittedMenus) !!}
    </ul>
</div>

<script>
    $(document).ready(function () {
        $('.kt-menu__nav .kt-menu__item--active').parents('.kt-menu__item--submenu').addClass('kt-menu__item--open');
    });
</script>
