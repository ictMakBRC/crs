<x-crs-layout>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active" style="color:red;">SANITIZE</li>
                        <li class="breadcrumb-item active" style="color:red;">WEAR MASK</li>
                        <li class="breadcrumb-item active" style="color:red;">KEEP DISTANCE</li>
                    </ol>
                </div>
                <h4 class="page-title">Dashboard:</strong> <?php echo date("d-F-Y");?></small></h4>
            </div>
        </div>
    </div>
    <!-- end page title -->


    <div class="row mx-auto">
        <div class="col-lg-6 col-xl-3">
            <div class="card border-secondary border">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="text-muted fw-normal mt-0 text-truncate" title="Campaign Sent">Total Tests</h5>
                            <h3 class="my-2 py-1">{{$totalTests}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 3.27%</span>
                            </p>
                        </div>
                        <div class="col-4">
                            <div class="text-end">
                                <div id="campaign-sent-chart" data-colors="#727cf5"></div>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col-lg-6 col-xl-3">
            <div class="card border-danger border">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="text-muted fw-normal mt-0 text-truncate" title="New Leads">Total Positives</h5>
                            <h3 class="my-2 py-1">{{$totalPostive}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-danger me-2"><i class="mdi mdi-arrow-down-bold"></i> 5.38%</span>
                            </p>
                        </div>
                        <div class="col-4">
                            <div class="text-end">
                                <div id="new-leads-chart" data-colors="#0acf97"></div>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col-lg-6 col-xl-3">
            <div class="card border-success border">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="text-muted fw-normal mt-0 text-truncate" title="Booked Revenue">Tested Today</h5>
                            <h3 class="my-2 py-1">{{$totalToday}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 11.7%</span>
                            </p>
                        </div>
                        <div class="col-4">
                            <div class="text-end">
                                <div id="booked-revenue-chart" data-colors="#0acf97"></div>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col-lg-6 col-xl-3">
            <div class="card border-warning border">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="text-muted fw-normal mt-0 text-truncate" title="Deals">Pending Results</h5>
                            <h3 class="my-2 py-1">{{$totalPending}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 4.87%</span>
                            </p>
                        </div>
                        <div class="col-4">
                            <div class="text-end">
                                <div id="deals-chart" data-colors="#727cf5"></div>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
    <!-- end row -->


    <div class="row mx-auto">
        <div class="col-xl-6 col-lg-12 order-lg-2 order-xl-1">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-2 mb-3">Current Month Tests</h4>

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <tbody>

                                <tr>

                                    @foreach($totalWeek as $weekly)
                                    <td>
                                        <h5 class="font-14 my-1 fw-normal">Tested this Week</h5>
                                        <span class="text-success font-13">Week {{ date('W', strtotime($weekly->created_at))}}</span>

                                    </td>
                                    <td>
                                        <h5 class="font-14 my-1 fw-normal">{{$weekly->qty}}</h5>
                                        <span class="text-success font-13">Samples tested</span>
                                    </td>
                                    @endforeach


                                    <td>
                                        <h5 class="font-14 my-1 fw-normal">{{$totalWeekPos}}</h5>
                                        <span class="text-danger font-13">Positives</span>
                                    </td>
                                </tr>
                                <tr>
                                    @foreach($totalMonth as $month)
                                    <td>
                                        <h5 class="font-14 my-1 fw-normal">Tested this Month</h5>
                                        <span class="text-success font-13">{{ date('M Y', strtotime($month->created_at))}}</span>
                                    </td>
                                    <td>
                                        <h5 class="font-14 my-1 fw-normal">{{$month->qty}}</h5>
                                        <span class="text-success font-13">Samples</span>
                                    </td>
                                    @endforeach
                                    <td>
                                        <h5 class="font-14 my-1 fw-normal">{{$totalMonthP}}</h5>
                                        <span class="text-danger font-13">Positives</span>
                                    </td>
                                </tr>
                                <tr>
                                    @foreach($totalYear as $year)
                                    <td>
                                        <h5 class="font-14 my-1 fw-normal">Tested this Year</h5>
                                        <span class="text-success font-13">{{ date('Y', strtotime($year->created_at))}}</span>
                                    </td>
                                    <td>
                                        <h5 class="font-14 my-1 fw-normal">{{$year->qty}}</h5>
                                        <span class="text-success font-13">Samples</span>
                                    </td>
                                    @endforeach
                                    <td>
                                        <h5 class="font-14 my-1 fw-normal">{{$totalYearP}}</h5>
                                        <span class="text-danger font-13">Positives</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> <!-- end table-responsive-->
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-xl-3 col-lg-6 order-lg-1">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-2 mb-3">Basic Statistics</h4>
                    <div class="chart-widget-list">
                        <p>
                            <i class="mdi mdi-square text-danger"></i> Today's Positivity
                            <span class="text-danger float-end">{{$avgpositives}}%</span>
                        </p>
                        <p>
                            <i class="mdi mdi-square text-danger"></i> Month's Positivity
                            <span class="text-danger float-end">{{$avgMonthpositive}}%</span>
                        </p>
                        <p class="mb-0">
                            <i class="mdi mdi-square text-info"></i> Today's average TAT
                            <span class="text-info float-end">5 Hrs</span>
                        </p>
                        <p class="mb-0">
                            <i class="mdi mdi-square text-warning"></i> System Users
                            <span class="float-end">{{$users}}</span>
                        </p>
                        <p>
                            <i class="mdi mdi-square text-warning"></i> Tested last Month
                            <span class="text-warning float-end">{{$totalLastMonth}}</span>
                        </p>

                        <p>
                            <i class="mdi mdi-square text-danger"></i> Results Withheld
                            <span class="text-danger float-end">{{$totalWithheld}}</span>
                        </p>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-xl-3 col-lg-6 order-lg-1">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-2">Activity Tracking</h4>

                    <div data-simplebar="" style="max-height: 424px;">
                        <div class="timeline-alt pb-0">

                            <div class="timeline-item">
                                <i class="mdi mdi-airplane bg-danger text-white timeline-icon"></i>
                                <div class="timeline-item-info">
                                    <a href="#" class="text-danger fw-bold mb-1 d-block">{{$totalincoming}} Pending Dispatch</a>
                                    <small>to the testing facility at</small>
                                    <p class="mb-0 pb-2">
                                        <small class="text-muted">MakBRC Labs</small>
                                    </p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <i class="mdi mdi-timer-outline bg-success text-white timeline-icon"></i>
                                <div class="timeline-item-info">
                                    <a href="#" class="text-success fw-bold mb-1 d-block">{{$totalRecieved}} Samples sent</a>
                                    <small>and recieved at the laboratory</small>
                                    <p class="mb-0 pb-2">
                                        <small class="text-muted">pending extraction & data review</small>
                                    </p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <i class="mdi mdi-microscope bg-warning text-white timeline-icon"></i>
                                <div class="timeline-item-info">
                                    <a href="#" class="text-warning fw-bold mb-1 d-block">{{$totalValidated}} being processed</a>
                                    <small>currently under extration
                                    </small>
                                    <p class="mb-0 pb-2">
                                        <small class="text-muted">or in a machine running</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- end timeline -->
                    </div> <!-- end slimscroll -->
                </div>
                <!-- end card-body -->
            </div>
            <!-- end card-->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
</x-crs-layout>
