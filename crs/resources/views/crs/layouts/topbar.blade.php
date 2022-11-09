   <!-- Topbar Start -->
   <div class="navbar-custom topnav-navbar">
    <div class="container-fluid">

        <!-- LOGO -->
       <a href="{{route('dashboard')}}" class="topnav-logo">
            <span class="topnav-logo-lg">
                <img src="{{asset('assets/images/logo-light.png')}}" alt="" width="138px">
            </span>
            <span class="topnav-logo-sm">
                <img src="{{asset('assets/images/logo-dark.png')}}" alt="" width="138px">
            </span>
        </a>

        <ul class="list-unstyled topbar-menu float-end mb-0">
            @if (Auth::user()->hasRole(['DataAdmin','DataClerkLab','LabTech','ResultsApprover','ResultsQC']))
            <li class="dropdown notification-list d-xl-none">
                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="dripicons-search noti-icon"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">

                    <form class="p-3" method="GET" action="{{url('patient/find')}}">
                        <input type="text" required class="form-control" name="q" placeholder="Search by name/lab No..." aria-label="Recipient's username">
                    </form>
                </div>
            </li>
            @endif
            <!--@if (Auth::user()->hasRole(['DataAdmin','ResultsApprover','ResultsQC']))-->
            <!-- <li class="dropdown notification-list">-->
            <!--                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" id="topbar-notifydrop" role="button" aria-haspopup="true" aria-expanded="false">-->
            <!--                            <i class="dripicons-bell noti-icon"></i>-->
            <!--                            <h6 class="text-success"><span class="noti-icon-badge">{{$NotCount}}</span></h6>-->
                                        
                                        
            <!--                        </a>-->
            <!--                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg" aria-labelledby="topbar-notifydrop">-->
    
                                        <!-- item-->
            <!--                            <div class="dropdown-item noti-title">-->
            <!--                                <h5 class="m-0">-->
            <!--                                    <span class="float-end">-->
            <!--                                        <a href="javascript: void(0);" class="text-dark">-->
            <!--                                            <small>Clear All</small>-->
            <!--                                        </a>-->
            <!--                                    </span>Notification-->
            <!--                                </h5>-->
            <!--                            </div>-->
            <!--                    @if(count($NotItems)>0)-->
            <!--                            <div style="max-height: 230px;" data-simplebar="">-->
                                           
            <!--                             @foreach($NotItems as $value)-->
                                            <!-- item-->
            <!--                                <a href="{{url('lab/notification/view/'.$value->nid)}}" class="dropdown-item notify-item">-->
            <!--                                    <div class="notify-icon bg-primary">-->
            <!--                                        <i class="mdi mdi-comment-account-outline"></i>-->
            <!--                                    </div>-->
            <!--                                    <p class="notify-details">{{$value->subject}}-->
            <!--                                        <small class="text-muted">{{ $value->date}}</small>-->
            <!--                                        <small class="text-muted">{{ $value->name}} ({{ $value->facility_name}})</small>-->
            <!--                                    </p>-->
            <!--                                </a>-->
            <!--                            @endforeach-->
                                              
                                         
            <!--                            </div>-->
    
                                        <!-- All-->
            <!--                            <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">-->
            <!--                                View All-->
            <!--                            </a>-->
            <!--                            @else-->
            <!--                             <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">-->
            <!--                                No new Notifications-->
            <!--                            </a>-->
            <!--                    @endif-->
            <!--                        </div>-->
            <!--   </li>-->

            <!--@endif-->
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" id="topbar-userdrop" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="account-user-avatar">
                        <img src="{{asset('storage/'.Auth::user()->avatar)}}" onerror="this.onerror=null;this.src='{{asset('images/avatar.png')}}';" alt="user-image" class="rounded-circle">
                    </span>
                    <span>
                        <span class="account-user-name">{{ Auth::user()->name }}</span>
                        {{-- <span class="account-user-name">{{ Auth::user()->roles }}</span> --}}
                    </span>

                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown" aria-labelledby="topbar-userdrop">
                    <!-- item-->
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>

                     <!-- item-->
                <a href="{{route('user.account')}}" class="dropdown-item notify-item">
                    <i class="mdi mdi-account-circle me-1"></i>
                    <span>My Account</span>
                </a>
                 <!-- item-->
                <a href="{{route('dashboard')}}" class="dropdown-item notify-item">
                    <i class="uil-home-alt"></i>
                    <span>Checkout</span>
                </a>
                <!-- item-->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                <a href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item notify-item">
                    <i class="mdi mdi-logout me-1"></i>
                    <span>Logout</span>
                </a>
                </form>

                </div>
            </li>

        </ul>
        <a class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
            <div class="lines">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </a>
        @if (Auth::user()->hasRole(['DataAdmin','DataClerkLab','LabTech','ResultsApprover','ResultsQC']))
        <div class="app-search dropdown">
            <form method="GET" action="{{url('patient/find')}}">

                <div class="input-group">
                    <input type="text" required class="form-control" name="q" placeholder="Search..." id="top-search">
                    <span class="mdi mdi-magnify search-icon"></span>
                    <button class="input-group-text  btn-primary" type="submit">Search</button>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>
