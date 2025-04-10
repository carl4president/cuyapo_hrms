<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main</span>
                </li>
                @if (Auth::user()->role_name == 'Admin')
                <li class="{{set_active(['home'])}}"><a class="{{set_active(['home'])}}" href="{{ route('home') }}"><i class="la la-dashboard"></i><span>Dashboard</span></a></li>
                @elseif (Auth::user()->role_name == 'Employee')
                <li class="{{set_active(['em/dashboard'])}}"><a class="{{set_active(['em/dashboard'])}}" href="{{ route('em/dashboard') }}"><i class="la la-dashboard"></i><span>Dashboard</span></a></li>
                @endif

                @if (Auth::user()->role_name == 'Admin')
                <li class="menu-title"> <span>Authentication</span> </li>
                <li class="{{set_active(['search/user/list','userManagement','activity/log','activity/login/logout'])}} submenu">
                    <a href="#" class="{{ set_active(['search/user/list','userManagement','activity/log','activity/login/logout']) ? 'noti-dot' : '' }}">
                        <i class="la la-user-secret"></i> <span> User Controller</span> <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['search/user/list','userManagement'])}}" href="{{ route('userManagement') }}">All User</a></li>
                    </ul>
                </li>
                @endif

                <!-- Employees Section -->
                @if (Auth::user()->role_name == 'Admin')
                <li class="menu-title"><span>Employees</span></li>
                <li class="{{set_active(['all/employee/list','all/employee/card','form/holidays/new','form/leaves/new', 
                    'form/leaves/employee/new','form/leavesettings/page','form/departments/page','form/designations/page','form/positions/page', 'form/leaves/calendar'])}} submenu">
                    <a href="#" class="{{ set_active(['all/employee/list','all/employee/card','form/holidays/new','form/leaves/new', 
                        'form/leaves/employee/new','form/leavesettings/page','form/departments/page','form/designations/page','form/positions/page', 'form/leaves/calendar']) ? 'noti-dot' : '' }}">
                        <i class="la la-user"></i> <span> Employees</span> <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['all/employee/list','all/employee/card'])}} {{ request()->is('all/employee/view/edit/*','employee/profile/*') ? 'active' : '' }}" href="{{ route('all/employee/card') }}">All Employees</a></li>
                        <li><a class="{{set_active(['form/leaves/new', 'form/holidays/new', 'form/leaves/new', 'form/leaves/employee/new', 'form/leavesettings/page', 'form/leaves/calendar'])}}" href="{{ route('form/leaves/calendar') }}">Leaves</a></li>
                        <li><a class="{{set_active(['form/departments/page'])}}" href="{{ route('form/departments/page') }}">Departments</a></li>
                        <li><a class="{{set_active(['form/designations/page'])}}" href="{{ route('form/designations/page') }}">Designations</a></li>
                        <li><a class="{{set_active(['form/positions/page'])}}" href="{{ route('form/positions/page') }}">Positions</a></li>
                    </ul>
                </li>
                @elseif (Auth::user()->role_name == 'Employee')
                <li class="menu-title"><span>Leaves</span></li>
                <li class="{{set_active(['form/leaves/employee/new', 'form/leaves/calendar'])}}">
                    <a class="{{set_active(['form/leaves/employee/new', 'form/leaves/calendar'])}}" href="{{ route('form/leaves/calendar') }}">
                        <i class="la la-calendar-check-o"></i> <span>Leaves</span></a>
                </li>
                @endif

                @if (Auth::user()->role_name == 'Admin')
                <li class="menu-title"> <span>HR</span> </li>
                <li class="{{set_active(['form/leave/reports/page','form/daily/reports/page','form/employee/reports/page'])}} submenu">
                    <a href="#" class="{{ set_active(['form/leave/reports/page','form/daily/reports/page','form/employee/reports/page']) ? 'noti-dot' : '' }}">
                        <i class="la la-pie-chart"></i> <span> Reports </span> <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['form/employee/reports/page'])}}" href="{{ route('form/employee/reports/page') }}"> Employee Report </a></li>
                        <li><a class="{{set_active(['form/daily/reports/page'])}}" href="{{ route('form/daily/reports/page') }}"> Daily Report </a></li>
                    </ul>
                </li>
                @endif

                @if (Auth::user()->role_name == 'Admin')
                <li class="menu-title"> <span>Administration</span> </li>
                @endif


                @if (Auth::user()->role_name == 'Admin')
                <li class="{{set_active(['user/dashboard/index','jobs/dashboard/index','user/dashboard/all','user/dashboard/applied/jobs','user/dashboard/interviewing','user/dashboard/offered/jobs','user/dashboard/visited/jobs','user/dashboard/archived/jobs','user/dashboard/save','jobs','job/applicants','job/details','page/shortlist/candidates','page/interview/questions','page/offer/approvals','page/rejected/applicant','page/candidates','page/schedule/timing','page/aptitude/result'])}} submenu">
                    <a href="#" class="{{ set_active(['user/dashboard/index','jobs/dashboard/index','user/dashboard/all','user/dashboard/save','jobs','job/applicants','job/details']) ? 'noti-dot' : '' }}">
                        <i class="la la-briefcase"></i>
                        <span> Jobs </span> <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }} {{ (request()->is('job/applicants/*')) ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['user/dashboard/index','user/dashboard/all','user/dashboard/applied/jobs','user/dashboard/interviewing','user/dashboard/offered/jobs','user/dashboard/visited/jobs','user/dashboard/archived/jobs','user/dashboard/save'])}}" href="{{ route('user/dashboard/index') }}"> User Dasboard </a></li>
                        <li><a class="{{set_active(['jobs/dashboard/index'])}}" href="{{ route('jobs/dashboard/index') }}"> Jobs Dasboard </a></li>
                        <li><a class="{{set_active(['jobs','job/applicants','job/details', 'jobsTypes'])}} {{ (request()->is('job/applicants/*','job/details/*')) ? 'active' : '' }}" href="{{ route('jobs') }} "> Manage Jobs </a></li>
                        <li><a class="{{set_active(['page/interview/questions'])}}" href="{{ route('page/interview/questions') }}"> Interview Questions </a></li>
                        <li><a class="{{set_active(['page/offer/approvals'])}}" href="{{ route('page/offer/approvals') }}"> Offer Approvals </a></li>
                        <li><a class="{{set_active(['page/candidates', 'page/shortlist/candidates', 'page/schedule/timing', 'page/rejected/applicant'])}} {{ request()->is('applicant/view/edit/*') ? 'active' : '' }}" href="{{ route('page/candidates') }}"> Candidates List </a></li>
                        <li><a class="{{set_active(['page/aptitude/result'])}}" href="{{ route('page/aptitude/result') }}"> Aptitude Results </a></li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
