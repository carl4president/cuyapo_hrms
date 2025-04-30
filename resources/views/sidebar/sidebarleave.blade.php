<ul class="nav nav-tabs nav-tabs-solid nav-justified">
    @if (Auth::user()->role_name == 'Admin' || Auth::user()->role_name == 'Super Admin' || Auth::user()->role_name == 'Employee')
    <li class="nav-item"><a class="nav-link {{set_active(['form/leaves/calendar'])}} {{ (request()->is('form/leaves/calendar')) ? 'active' : '' }}" href="{{ route('form/leaves/calendar') }} ">
            Calendar
        </a></li>
    @endif
    @if (Auth::user()->role_name == 'Employee')
    <li class="nav-item"><a class="nav-link {{set_active(['form/leaves/employee/new'])}}" href="{{ route('form/leaves/employee/new') }}">
            Leaves
        </a></li>
    @endif
    @if (Auth::user()->role_name == 'Admin' || Auth::user()->role_name == 'Super Admin')
    <li class="nav-item"><a class="nav-link {{set_active(['form/holidays/new'])}}" href="{{ route('form/holidays/new') }}">
            Holidays
        </a></li>
    @endif
    @if (Auth::user()->role_name == 'Admin' || Auth::user()->role_name == 'Super Admin' || (Auth::user()->role_name == 'Employee' && optional(Auth::user()->employee->jobdetails->first())->is_head == 1) )
    <li class="nav-item"><a class="nav-link {{set_active(['form/leaves/new'])}}" href="{{ route('form/leaves/new') }}">
            Leaves @if ((Auth::user()->role_name == 'Employee' && optional(Auth::user()->employee->jobdetails->first())->is_head == 1))
        in department
        @endif
        </a></li>
    @endif
    @if (Auth::user()->role_name == 'Admin' || Auth::user()->role_name == 'Super Admin')
    <li class="nav-item"><a class="nav-link {{set_active(['form/leavesettings/page'])}}" href="{{ route('form/leavesettings/page') }}">
            Leave Settings
        </a></li>
    @endif
</ul>
