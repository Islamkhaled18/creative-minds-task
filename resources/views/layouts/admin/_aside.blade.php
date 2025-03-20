<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>

<aside class="app-sidebar">
    <div class="app-sidebar__user">
        <div>
            <p class="app-sidebar__user-name">{{ auth()->user()->username }}</p>
            <p class="app-sidebar__user-designation">{{ auth()->user()->mobile_number }}</p>
        </div>
    </div>

    <ul class="app-menu">

        <li><a class="app-menu__item" href="{{ route('dashboard') }}"><i class="app-menu__icon fa fa-home"></i>
                <span class="app-menu__label">Home</span></a></li>


        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i
                    class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Users & Deliveries</span><i
                    class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">

                <li><a class="treeview-item" href="{{ route('admin.users.index') }}"><i
                            class="app-menu__icon fa fa-user"></i> <span class="app-menu__label">All</span></a>
                </li>
            </ul>
        </li>


    </ul>
</aside>
