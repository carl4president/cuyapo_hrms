<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div class="sidebar-menu">
            <ul>
                <li><a href="{{ in_array(Auth::user()->role_name, ['Admin', 'Super Admin']) ? route('home') : route('em/dashboard') }}"><i class="la la-home"></i> <span>Back to Home</span></a></li>
                <li class="menu-title">Settings</li>
                @if(Auth::user()->role_name == 'Admin' || Auth::user()->role_name == 'Super Admin')
                
                <li class="{{set_active(['company/settings/page'])}}"><a href="{{ route('company/settings/page') }}"><i class="la la-building"></i><span>Company Settings</span></a></li>

                @endif

                <li class="{{set_active(['rchange/password'])}}"><a href="{{ route('change/password') }}"><i class="la la-lock"></i><span>Change Password</span></a></li>
            </ul>
        </div>
    </div>
</div>
<!-- Sidebar -->