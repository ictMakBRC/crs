<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu">

    <!-- LOGO -->
    <a href="{{route('dashboard')}}" class="logo text-center logo-light">
        <span class="logo-lg">
            <img src="{{asset('assets/images/logo-light.png')}}" alt="" height="16">
        </span>
        <span class="logo-sm">
            <img src="{{asset('assets/images/logo-light.png')}}" alt="" height="16">
        </span>
    </a>

    <!-- LOGO -->
    <a href="{{route('dashboard')}}" class="logo text-center logo-dark">
        <span class="logo-lg">
            <img src="{{asset('assets/images/logo-dark.png')}}" alt="" height="16">
        </span>
        <span class="logo-sm">
            <img src="{{asset('assets/images/logo-dark.png')}}" alt="" height="16">
        </span>
    </a>

    <div class="h-100" id="leftside-menu-container" data-simplebar="">
        <!--- Sidemenu -->
        <ul class="side-nav">
            <li class="side-nav-title side-nav-item">Navigation</li>
            <li class="side-nav-item">
                <a href="{{route('dashboard')}}" aria-expanded="false" aria-controls="sidebarDashboards" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span>Home</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{route('manage.index')}}" aria-expanded="false" aria-controls="sidebarDashboards" class="side-nav-link">
                    <i class=" mdi mdi-monitor"></i>
                    <span> Dashboard</span>
                </a>
            </li>
             <li class="side-nav-item">
                <a href="{{asset('management/patients/manage')}}" aria-expanded="false" aria-controls="sidebarDashboards" class="side-nav-link">
                    <i class="uil-users-alt"></i>
                    <span>Manage Patients</span>
                </a>
            </li>
 
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#manage" aria-expanded="false" aria-controls="sidebarmanage" class="side-nav-link">
                    <i class="uil-folder-medical"></i>
                    <span>Manage</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="manage">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{route('facilities.index')}}">Facilities</a>
                        </li>
                        <li>
                            <a href="{{route('platforms.index')}}">Platforms</a>
                        </li>
                        <li>
                            <a href="{{route('kits.index')}}">Kits</a>
                        </li>
                        <li>
                            <a href="{{route('designations.index')}}">Designations</a>
                        </li>
                        <li>
                            <a href="{{route('departments.index')}}">Departments</a>
                        </li>
                        <li>
                            <a href="{{route('swabbers.index')}}">Swabbers</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarStaff" aria-expanded="false" aria-controls="sidebarEcommerce" class="side-nav-link">
                    <i class="uil-cog"></i>
                    <span>Roles and Permission</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarStaff">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{route('roles.index')}}">Roles</a>
                        </li>
                        <li>
                            <a href="{{route('permission.index')}}">Permissions</a>
                        </li>
                        <li>
                            <a href="{{route('assignment.index')}}">Assignment</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarVendors" aria-expanded="false" aria-controls="sidebarEcommerce" class="side-nav-link">
                    <i class="uil-list-ul"></i>
                    <span>User Logs</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarVendors">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{route('logs')}}">Activity Logs</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
<!-- Left Sidebar End -->

