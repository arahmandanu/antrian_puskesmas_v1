<aside class="sidebar navbar-default" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav in" id="side-menu">

            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin_dashboard') ? 'active' : '' }}"><i
                        class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>

            <li>
                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="flot.html">Flot Charts</a>
                    </li>
                    <li>
                        <a href="morris.html">Morris.js Charts</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>

            <li>
                <a href="{{ route('admin.users.index') }}"
                    class="{{ request()->is('admin_dashboard/users*') ? 'active' : '' }}"><i
                        class="fa fa-user fa-fw"></i> Users</a>
            </li>

            <li>
                <a href="{{ route('admin.poli.index') }}"
                    class="{{ request()->is('admin_dashboard/poli*') ? 'active' : '' }}"><i class="fa fa-bed fa-fw"></i>
                    Poli</a>
            </li>

            <li>
                <a href="{{ route('admin.loket.index') }}"
                    class="{{ request()->is('admin_dashboard/loket*') ? 'active' : '' }}"><i
                        class="fa fa-users fa-fw"></i> Loket</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-wrench fa-fw"></i> Setting<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="panels-wells.html">Company</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
        </ul>
    </div>
</aside>
<!-- /.sidebar -->
