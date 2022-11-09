<x-crs-layout>
    @section('title', $appName.'|Notification')

    <!-- end row-->
    <div class="container-fluid">
                        
        <!-- start page email-title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">{{$appName}}</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Notifications</a></li>
                            <li class="breadcrumb-item active">Notification Read</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Notification Read</h4>
                </div>
            </div>
        </div>   
         @if(count($notifications)>0)
        <!-- end page email-title --> 
        @foreach ($notifications as $key=>$value)
            <div class="row">

            <!-- Right Sidebar -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Left sidebar -->
                        <div class="page-aside-left">

                            <div class="d-grid">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#compose-modal">Notifications</button>
                            </div>

                            <div class="email-menu-list mt-3">
                                <a href="javascript: void(0);" class="text-danger fw-bold"><i class="dripicons-inbox me-2"></i>Unseen<span class="badge badge-danger-lighten float-end ms-2">{{$NotCount}}</span></a>
                                <a href="javascript: void(0);"><i class="dripicons-star me-2"></i>Solved</a>
                                <a href="javascript: void(0);"><i class="dripicons-clock me-2"></i>Snoozed</a>
                                <a href="javascript: void(0);"><i class="dripicons-trash me-2"></i>Trash</a>
                                <a href="javascript: void(0);"><i class="dripicons-tag me-2"></i>Important</a>
                            </div>


                        </div>
                        <!-- End Left sidebar -->

                        <div class="page-aside-right">

                            <div class="btn-group">
                               
                                <button type="button" class="btn btn-secondary"><i class="mdi mdi-delete-variant font-16"></i></button>
                            </div>
                          
                          

                            <div class="btn-group">
                                <button type="button" class="btn btn-secondary dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-horizontal font-16"></i> More
                                    <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <span class="dropdown-header">More Options :</span>
                                    <a class="dropdown-item" href="javascript: void(0);">Mark as Unread</a>
                                    <a class="dropdown-item" href="javascript: void(0);">Add to Tasks</a>
                                    <a class="dropdown-item" href="javascript: void(0);">Mark as Solved</a>
                                    <a class="dropdown-item" href="javascript: void(0);">Mute</a>
                                </div>
                            </div>

                            <div class="mt-3">
                                <h5 class="font-18">{{$value->subject}}</h5>

                                <hr>

                                <div class="d-flex mb-3 mt-1">
                                     <img class="d-flex me-2 rounded-circle" src="{{asset('storage/'.$value->avatar)}}" onerror="this.onerror=null;this.src='{{asset('images/avatar.png')}}';" alt="user-image" height="32">
                                    
                                    <div class="w-100 overflow-hidden">
                                        <small class="float-end">{{$value->date}}</small>
                                        <h6 class="m-0 font-14">{{$value->name}} {{$value->first_name}}</h6>
                                        <small class="text-muted">Facility: {{$value->facility_name}}</small>
                                    </div>
                                </div>
                                    <div style="overflow-y: auto; max-height: 350px;">
                                        <p>{{$value->body}}</p>
                                    </div>
                                <hr>

                                <!-- end row-->
                                
                                <div class="mt-5">
                                    <a href="" class="btn btn-secondary me-2"><i class="mdi mdi-reply me-1"></i>Previous</a>
                                    <a href="" class="btn btn-light">Next<i class="mdi mdi-forward ms-1"></i></a>
                                </div>

                            </div>
                            <!-- end .mt-4 -->

                        </div> 
                        <!-- end inbox-rightbar-->
                    </div>

                    <div class="clearfix"></div>
                </div> <!-- end card-box -->

            </div> <!-- end Col -->
        </div><!-- End row -->
         @endforeach
         @endif
    </div> <!-- container -->
    <!-- end row-->
</x-crs-layout>
