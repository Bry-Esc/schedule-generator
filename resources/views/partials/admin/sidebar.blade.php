<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 sidebar">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 site-logo-container">
            <h3 class="text-center site-logo">TechSCHD</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            

            <ul class="menu">
                <?php $page = Request::segment(1); ?>
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="{{ asset(Auth::user()->path_to_avatar) }}" class="img-circle" alt="User Imge"  />
                    </div>
                    <div class="pull-right info">
                        <p>{{ Auth::user()->name }}</p>
                    </div>
                </div>

                <li class="menu-link {{ ($page == 'dashboard') ? 'active' : '' }}">
                    <a href="/dashboard"><span class="fa fa-dashboard"></span><span class="text">Dashboard</span></a>
                </li>

                <li class="menu-link dropdown {{ ($page == 'courses' || $page == 'classes' || $page == 'timeslots') ? 'active' : '' }}">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-book"></span><span class="text">Maintenance</span><span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="/courses"><span class="fa fa-book"></span><span class="text">Acad Period</a></li>
                        <li><a href="/classes"><span class="fa fa-users"></span><span class="text">Curriculum</a></li>
                        <li><a href="/timeslots"><span class="fa fa-clock-o"></span><span class="text">Periods</a></li>
                        <li class="menu-link {{ ($page == 'rooms') ? 'active' : '' }}">
                            <a href="/rooms"><span class="fa fa-home"></span><span class="text">Room</span></a>
                        </li>
                    </ul>
                </li>

                <li class="menu-link {{ ($page == 'professors') ? 'active' : '' }}">
                    <a href="/professors"><span class="fa fa-graduation-cap"></span><span class="text">Professors Schedule</span></a>
                </li>

                <li class="menu-link {{ ($page == 'my_account') ? 'active' : '' }}">
                    <a href="/my_account"><span class="fa fa-user"></span><span class="text">My Account</span></a>
                </li>
                <li class="menu-link">
                    <a href="/logout"><span class="fa fa-sign-out"></span><span class="text">Log Out</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>
