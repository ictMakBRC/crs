
<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-dark navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('dashboard')}}" id="topnav-dashboards" role="button" aria-expanded="false">
                            <i class="uil-home-alt"></i>
                            <span> Home</span>
                        </a>
                    </li>

                    @if (Auth::user()->hasRole(['DataAdmin','DataClerkLab','LabTech','ResultsApprover','ResultsQC']))

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class=" uil-book-medical text-white"></i> All patients <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-apps">
                            @if (Auth::user()->hasRole(['DataAdmin','DataClerkLab','LabTech','ResultsApprover','ResultsQC']))
                            @if (Auth::user()->hasRole(['DataAdmin','DataClerkLab','ResultsApprover','ResultsQC']))
                            <a href="{{url('patients/lab/new_patient')}}" class="dropdown-item">New Patient</a>
                            @endif
                            @if (Auth::user()->hasRole(['DataAdmin','LabTech','ResultsApprover','ResultsQC']))
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-pending" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    All Incoming<div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-pending">
                                    <a href="{{url('patients/lab/pending/today')}}" class="dropdown-item">Today's Patients</a>
                                    <a href="{{url('patients/lab/pending/yesterday')}}" class="dropdown-item">Yesterday's List</a>
                                    <a href="{{url('patients/lab/pending/week')}}" class="dropdown-item">This Weeks List</a>
                                    <!--<a href="{{url('patients/lab/pending/months')}}" class="dropdown-item">This Months List</a>-->
                                    <a href="{{url('patients/lab/pending')}}" class="dropdown-item">All Patients List</a>
                                </div>
                            </div>
                            @endif
                            @endif
                            @if (Auth::user()->hasRole(['DataAdmin','DataClerkLab','ResultsApprover','ResultsQC']))
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-accessed" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    All Accessioned<div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-acccessed">
                                    <a href="{{url('patients/lab/accessioned/today')}}" class="dropdown-item">Today's List</a>
                                    <a href="{{url('patients/lab/accessioned/yesterday')}}" class="dropdown-item">Yesterday's List</a>
                                    {{-- <a href="{{url('patients/lab/accessioned/week')}}" class="dropdown-item">This Weeks List</a>
                                    <a href="{{url('patients/lab/accessioned/months')}}" class="dropdown-item">This Months List</a> --}}
                                    <a href="{{url('patients/lab/accessioned')}}" class="dropdown-item">All Patients List</a>
                                    <a href="{{url('patients/lab/Allvalidated')}}" class="dropdown-item">Verified List</a>
                                </div>
                            </div>
                            @endif
                            @if (Auth::user()->hasRole(['DataAdmin','ResultsApprover','ResultsQC']))
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-validated" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    All Verified<div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-validated">
                                    <a href="{{url('patients/lab/validated/today')}}" class="dropdown-item">Today's List</a>
                                    <a href="{{url('patients/lab/validated/yesterday')}}" class="dropdown-item">Yesterday's List</a>
                                    <a href="{{url('patients/lab/validated')}}" class="dropdown-item">All Patients List</a>
                                </div>
                            </div>
                            @endif
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-all" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    All Entered <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-all">
                                    <a href="{{url('patients/lab/today')}}" class="dropdown-item">Today</a>
                                    <a href="{{url('patients/lab/yesterday')}}" class="dropdown-item">Yesterday</a>
                                    <a href="{{url('patients/lab/week')}}" class="dropdown-item">This Week</a>
                                    <a href="{{url('patients/lab/months')}}" class="dropdown-item">This Month</a>
                                    <a href="{{url('patients/lab/lastmonth')}}" class="dropdown-item">Last month</a>
                                    <a href="{{url('patients/lab')}}" class="dropdown-item">All Entered </a>
                                </div>
                            </div>                            
                            {{-- <a href="{{url('patients/lab/new_patient')}}" class="dropdown-item">New Patient</a> --}}
                        </div>
                    </li>
                  
                    @endif
                    @if (Auth::user()->hasRole(['DataClerkSite','DataAdmin','DataClerkLab']))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps2" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="uil-medical-square text-white"></i> My Patients <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-apps2">
                            <a href="{{route('patients.create')}}" class="dropdown-item">New Patient</a>
                            <a href="{{url('patients/today')}}" class="dropdown-item">Patients Today's List</a>
                            <a href="{{url('patients/week')}}" class="dropdown-item">Patients This Weeks List</a>
                            <a href="{{url('patients/months')}}" class="dropdown-item">Patients This Months List</a>
                            <a href="{{route('patients.index')}}" class="dropdown-item">All Patients List</a>
                        </div>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole(['DataClerkSite']))
                     <li class="nav-item">
                        <a class="nav-link" href="{{route('swabbers.index')}}" id="topnav-swabbers" role="button" aria-expanded="false">
                            <i class="mdi-test-tube text-white"></i>
                            <span>Swabbers</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole(['DataAdmin','ResultsQC']))
                   <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="myexports" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="uil-sliders-v text-white"></i> Operations<div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="myexports">
                            <button  class="dropdown-item" data-bs-toggle="modal" data-bs-target="#resultimport">Import Results</button>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="expoRsults" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                   Export Pending results<div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="expoRsults">                                    
                                    <a href="{{url('patients/labr/export/today')}}" class="dropdown-item">Today</a>
                                    <a href="{{url('patients/labr/export/yesterday')}}" class="dropdown-item">Yesterday</a>
                                    <a href="{{url('patients/labr/export/pending')}}" class="dropdown-item">All Pending</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown d-none">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="myimports" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="uil-upload-alt text-white"></i> Import<div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="myimports">
                            <button  class="dropdown-item" data-bs-toggle="modal" data-bs-target="#resultimport">Import Results</button>
                        </div>
                    </li>
                 
                    @endif
                   @if (Auth::user()->hasRole(['DataAdmin','ResultsApprover','ResultsQC']))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-presults" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="uil-file-medical text-white"></i>View Results<div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-presults">
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-rpending" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    RDS Pending<div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-rpending">
                                    
                                    <a href="{{url('patients/lab/result/today')}}" class="dropdown-item">Today's List</a>
                                     <a href="{{url('patients/lab/result/yesterday')}}" class="dropdown-item">Yesterday's List</a>
                                    <a href="{{url('patients/lab/result/week')}}" class="dropdown-item">This Weeks List</a>
                                    <a href="{{url('patients/result/months')}}" class="dropdown-item">This Months List</a>
                                    <a href="{{url('patients/lab/result/pending')}}" class="dropdown-item">All Pending</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-submin" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    RDS Submitted<div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-submin">
                                    <a href="{{url('patients/lab/submitted/today')}}" class="dropdown-item">Today's List</a>
                                    <a href="{{url('patients/lab/submitted/week')}}" class="dropdown-item">This Weeks List</a>
                                    <a href="{{url('patients/submitted//months')}}" class="dropdown-item">This Months List</a>
                                    <a href="{{url('patients/lab/result/submitted')}}" class="dropdown-item">All Submitted</a>
                                </div>
                            </div>
                              <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-Notsubmin" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Not Submitted<div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="Notsubmin">
                                    <a href="{{url('patients/lab/completed/today')}}" class="dropdown-item">Today's List</a>
                                    <a href="{{url('patients/lab/completed/week')}}" class="dropdown-item">This Weeks List</a>
                                    <a href="{{url('patients/completed/months')}}" class="dropdown-item">This Months List</a>
                                    <a href="{{url('patients/lab/result/completed')}}" class="dropdown-item">All Completed</a>
                                </div>
                            </div>
                            <a href="{{url('patients/lab/result/imports')}}" class="dropdown-item">All Imports</a>
                            <a href="{{url('patients/lab/result')}}" class="dropdown-item">All results</a>
                        </div>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole(['DataAdmin','ResultsQC']))
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="myreports" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class=" uil-file-plus-alt text-white"></i> Reports<div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="myreports">
                            <a href="{{url('lab/report/patients')}}" class="dropdown-item">Patient Report</a>
                            <a href="{{url('lab/report/filter')}}" class="dropdown-item">Patient Filter</a>
                             <a href="{{url('lab/report/moh')}}" class="dropdown-item">MOH Report</a>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="myTat" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    TAT<div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="myTat">                                    
                                    <a href="{{url('lab/report/tat')}}" class="dropdown-item">Average TAT</a>
                                    <a href="{{url('lab/report/Patienttat')}}" class="dropdown-item">TAT Per Entry</a>
                                    <a href="{{url('lab/report/monthlyTat')}}" class="dropdown-item">TAT Per Month</a>
                                    <a href="{{url('lab/report/QuarterlyTat')}}" class="dropdown-item">TAT Per Quarter</a>
                                    <a href="{{url('lab/report/mean')}}" class="dropdown-item">TAT Analysis</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole(['DataAdmin','ResultsQC']))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('manage.index')}}" id="topnav-dashboards" role="button" aria-expanded="false">
                            <i class="uil-cog text-white"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</div>
