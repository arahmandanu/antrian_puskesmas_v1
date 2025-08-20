<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Puskesman Sehat Sentosa</a>
    </div>

    <ul class="nav navbar-right navbar-top-links">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> {{ auth()->user()->email }} <b class="caret"></b>
            </a>
            <ul class="dropdown-menu dropdown-user">
                {{-- <li>
                    <a href=""><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li> --}}

                <li>
                    <a href="{{ route('admin.company.index') }}"><i class="fa fa-gear fa-fw"></i> Settings</a>
                </li>

                <li class="divider"></li>
                <li>
                    <a href="{{ route('admin.logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- /.navbar-top-links -->
</nav>
