<ul class="nav nav-tabs nav-tabs-solid nav-justified">
    <li class="nav-item"><a class="nav-link {{set_active(['jobs/dashboard/index'])}}" href="{{ route('jobs/dashboard/index') }}">Job Dashboard</a></li>
    <li class="nav-item"><a class="nav-link {{set_active(['jobs','job/applicants','job/details'])}} {{ (request()->is('job/applicants/*','job/details/*')) ? 'active' : '' }}" href="{{ route('jobs') }} ">Jobs</a></li>
    <li class="nav-item"><a class="nav-link {{set_active(['jobsTypes'])}}" href="{{ route('jobsTypes') }}">Job Type</a></li>
</ul>
