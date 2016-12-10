<header class="main-header">
    <a href="{url link='manager'}" class="logo">
        <span class="logo-mini"><b>N</b>SKY</span>
        <span class="logo-lg"><b>NEW</b>SKY</span>
    </a>

    <nav class="navbar navbar-static-top">
        <a href="javascript:void(0);" onclick="$.ajaxCall('manager.toggleMenuSideBar');" class="sidebar-toggle" data-toggle="offcanvas" role="button"><span class="sr-only">Toggle navigation</span></a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{img user=$aGlobalUser suffix='_100_square' max_width='100' max_height='100' return_url=true}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{$aGlobalUser.full_name}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="{img user=$aGlobalUser suffix='_100_square' max_width='100' max_height='100' return_url=true}" class="img-circle" alt="User Image">
                            <p>{$aGlobalUser.full_name}</p>
                        </li>
                        <li class="user-footer">
                            <div class="row">
                                <div class="col-xs-6"><a href="{url link='user.setting'}" class="btn btn-default" style="display: block;">Tài khoản</a></div>
                                <div class="col-xs-6"><a href="{url link='user.logout'}" class="btn btn-default" style="display: block;">Đăng xuất</a></div>
                            </div>
                        </li>
                    </ul>
                </li>
                {if isset($aFilterSearchs) && !empty($aFilterSearchs)}
                    <li><a onclick="$.ajaxCall('manager.toggleFilterSearch');" role="button" data-toggle="collapse" href="#collapseSearch" aria-expanded="false" aria-controls="collapseSearch"><i class="fa fa-search"></i></a></li>
                {/if}
            </ul>
        </div>
    </nav>
</header>