<ul class="nav nav-tabs nav-tabs-solid nav-justified">
    <li class="nav-item"><a class="nav-link {{set_active(['page/candidates'])}}" href="{{ route('page/candidates') }}">Candidates</a></li>
    <li class="nav-item"><a class="nav-link {{set_active(['page/schedule/timing'])}}" href="{{ route('page/schedule/timing') }}">Interview</a></li>
    <li class="nav-item"><a class="nav-link {{set_active(['page/shortlist/candidates'])}}" href="{{ route('page/shortlist/candidates') }}">Shortlist</a></li>
    <li class="nav-item"><a class="nav-link {{set_active(['page/rejected/applicant'])}}" href="{{ route('page/rejected/applicant') }}">Rejected</a></li>
</ul>
