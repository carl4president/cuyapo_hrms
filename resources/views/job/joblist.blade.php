@extends('layouts.job')
@section('content')
<style>
    .job-card {
        background-color: #fff;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        transition: 0.3s;
        margin-bottom: 30px;
    }

    .job-card:hover {
        transform: translateY(-5px);
    }

    .job-card .title {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 6px;
    }

    .job-card .department {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 20px;
    }

    .job-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 20px;
    }

    .job-meta .item {
        display: flex;
        align-items: center;
        font-size: 14px;
        color: #4b5563;
    }

    .job-meta .item i {
        color: #6366f1;
        margin-right: 8px;
    }

    .job-description {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 20px;
        line-height: 1.5;
    }

    .btn-apply {
        padding: 8px 20px;
        border-radius: 8px;
        font-size: 14px;
        background-color: #2563eb;
        border: none;
        color: white;
        text-decoration: none;
    }

    .badge-jobtype {
        font-size: 12px;
        background-color: #f43b48;
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
    }

    .badge-open {
        background-color: #10b981;
        /* green */
        color: white;
        font-size: 12px;
        padding: 6px 12px;
        border-radius: 20px;
    }

    .badge-closed {
        background-color: #f59e0b;
        /* amber */
        color: white;
        font-size: 12px;
        padding: 6px 12px;
        border-radius: 20px;
    }

    .badge-cancelled {
        background-color: #ef4444;
        /* red */
        color: white;
        font-size: 12px;
        padding: 6px 12px;
        border-radius: 20px;
    }

    .badge-default {
        background-color: #6b7280;
        color: white;
        font-size: 12px;
        padding: 6px 12px;
        border-radius: 20px;
    }

</style>
<div class="main-wrapper">
    <!-- Header -->
    <div class="header">
        <!-- Logo -->
        <div class="header-left">
            <a href="{{ route('login') }}" class="logo">
                @php
                    use App\Models\CompanySettings;
                    $company = CompanySettings::first();
                    @endphp

                    @if (!empty($company) && !empty($company->logo))
                    <img src="{{ asset('assets/images/' . $company->logo) }}" width="40" height="40" alt="">
                    @else
                    <img src="{{ asset('assets/img/logo2.png') }}" width="40" height="40" alt="">
                    @endif
            </a>
        </div>
        <!-- /Logo -->
        <!-- Header Title -->
        <div class="page-title-box float-left">
            <h3>Jobs List</h3>
        </div>
        <!-- /Header Title -->
        <!-- Header Menu -->
        <ul class="nav user-menu">
            <!-- Search -->
            <li class="nav-item mr-4">
                <div class="top-nav-search">
                    <a href="javascript:void(0);" class="responsive-search">
                        <i class="fa fa-search"></i>
                    </a>
                    <form action="{{ route('job/list/search') }}" method="GET">
                        <input class="form-control" id="search-input" type="text" name="position" placeholder="Search by position" value="{{ request('position') }}">
                        <button class="btn" type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link pr-12" href="{{ route('login') }}">Back to home page</a>
            </li>
            <!-- /Search -->
        </ul>
        <div class="dropdown mobile-user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('login') }}">Back to home page</a>
            </div>
        </div>
        <!-- /Header Menu -->
    </div>
    <!-- /Header -->

    <!-- Page Wrapper -->
    <div class="page-wrapper job-wrapper">
        <!-- Page Content -->
        <div class="content container">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Jobs</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('form/job/list') }}">Home</a></li>
                            <li class="breadcrumb-item active">Jobs</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="row">
                @foreach ($job_list as $list)
                @php
                $date = $list->created_at;
                $date = Carbon\Carbon::parse($date);
                $elapsed = $date->diffForHumans();

                $status = strtolower($list->status); // expects 'open', 'closed', or 'cancelled'
                $statusLabel = ucfirst($status);
                $statusClass = match ($status) {
                'Open' => 'badge-open',
                'Closed' => 'badge-closed',
                'Cancelled' => 'badge-cancelled',
                default => 'badge-default'
                };
                @endphp
                <div class="col-md-6">
                    <div class="job-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="title">{{ $list->position->position_name }}</div>
                                <div class="department">{{ $list->department->department }}</div>
                            </div>
                            <span class="{{ $statusClass }}">{{ $statusLabel }}</span>
                        </div>

                        <div class="job-meta mt-3">
                            <div class="item"><i class="fa fa-users"></i> {{ $list->no_of_vacancies }} vacancies</div>
                            <div class="item"><i class="fa fa-briefcase"></i> {{ \Illuminate\Support\Str::limit($list->experience, 20) }}</div>
                            <div class="item"><i class="fa fa-money"></i> ₱{{ $list->salary_from }} – ₱{{ $list->salary_to }}</div>
                            <div class="item"><i class="fa fa-calendar"></i> Start: {{ $list->start_date }}</div>
                            <div class="item"><i class="fa fa-calendar"></i> Expiry: {{ $list->expired_date }}</div>
                            <div class="item"><i class="fa fa-clock-o"></i> {{ $elapsed }}</div>
                        </div>

                        <div class="job-description">
                            {{ \Illuminate\Support\Str::limit($list->description, 100) }}
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <a href="{{ url('form/job/view/'.$list->id) }}" class="btn btn-apply">View Details</a>
                            <span class="badge-jobtype">{{ ucfirst($list->job_type) ?? 'Full-Time' }}</span>

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->
</div>
@endsection
