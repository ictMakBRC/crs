<x-crs-layout>
@section('title', 'Dashboard')
    <!-- start page title -->
    <div class="row " style="margin-top:-30px">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active" style="color:red;">SANITIZE</li>
                        <li class="breadcrumb-item active" style="color:red;">WEAR MASK</li>
                        <li class="breadcrumb-item active" style="color:red;">KEEP DISTANCE</li>
                    </ol>
                </div>
                <h4 class="page-title">Today: <?php echo date("d-F-Y");?></h4>
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
                                <span class="text-success me-2 {{$weekUp}}"><i class="mdi mdi-arrow-up-bold"></i> @convert($percentDiff)%</span>
                                <span class="text-danger me-2 {{$weekDown}}"><i class="mdi mdi-arrow-down-bold"></i> @convert($percentDiff)%</span>
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
                                <span class="text-success me-2 {{$TodayctiveUp}}"><i class="mdi mdi-arrow-up-bold"></i> @convert($ntageTodayDiff)%</span>
                                <span class="text-danger me-2 {{$TodayctiveDown}}"><i class="mdi mdi-arrow-down-bold"></i> @convert($ntageTodayDiff)%</span>
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
                                <span class="text-success me-2 {{$TodayUp}}"><i class="mdi mdi-arrow-up-bold"></i> @convert($percentDiffToday)%</span>
                                <span class="text-danger me-2 {{$TodayDown}}"><i class="mdi mdi-arrow-down-bold"></i> @convert($percentDiffToday)%</span>
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
                                <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold d-none"></i>  @convert($avgpending)%</span>
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
<style>
    .flex-1 {
flex: 1;
}
</style>

    <div class="row mx-auto">
        <div class="col-xl-6 equal-cols col-lg-12 order-lg-2 order-xl-1 flex-1">
            <div class="card">
                <div class="card-header bg-success text-light text-center">
                    <h4 class="header-title mt-2 mb-3">Current Year Tests ({{date('Y')}})</h4>
                </div>
                <div class="card-body pt-1">
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
                                        <span class="text-success font-13">{{ date('F Y', strtotime($month->created_at))}}</span>
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

        <div class="col-xl-3 col-lg-6 equal-cols order-lg-1 flex-1">
            <div class="card">
                <div class="card-header bg-success text-light text-center">
                    <h4 class="header-title mt-2 mb-3">Basic Statistics</h4>
                </div>
                <div class="card-body pt-1">
                    <div class="chart-widget-list">
                        <p>
                            <i class="mdi mdi-square text-warning"></i> Results Withheld
                            <span class="text-warning float-end">{{$totalWithheld}}</span>
                        </p>
                        <p>
                            <i class="mdi mdi-square text-success"></i> Active Facilities
                            <span class="text-success float-end">{{$facilitiesOn}}</span>
                        </p>
                        <!--  <p>-->
                        <!--    <i class="mdi mdi-square text-danger"></i> Stopped Facilities-->
                        <!--    <span class="text-danger float-end">{{$facilitiesOff}}</span>-->
                        <!--</p>-->
                        <!--<p><a href="{{url('patients/lab/emergencies')}}">-->
                        <!--    <i class="mdi mdi-square text-danger"></i>Pending Emergencies-->
                        <!--    <span class="text-danger float-end">{{$totalEmergency}}</span>-->
                        <!--    </a>-->
                        <!--</p>-->
                        <p class="mb-0">
                            <i class="mdi mdi-square text-warning"></i> System Users
                            <span class="float-end">{{$users}}</span>
                        </p>
                        <p>
                            <i class="mdi mdi-square text-danger"></i> Today's Positivity
                            <span class="text-danger float-end">@convert($avgpositives)%</span>
                        </p>
                        <p>
                            <i class="mdi mdi-square text-danger"></i> Month's Positivity
                            <span class="text-danger float-end">@convert($avgMonthpositive)%</span>

                        </p>

                        <p class="mb-0">
                            <i class="mdi mdi-square text-info"></i> Today's TAT
                            <span class="text-info float-end">@convert($avgTat) Hrs</span>
                        </p>
                        <br>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-xl-3 col-lg-6 equal-cols order-lg-1 flex-1">
            <div class="card">
                <div class="card-header bg-success text-light text-center">
                    <h4 class="header-title mb-2">Activity Tracking</h4>
                </div>
                <div class="card-body pt-1">
                    <div data-simplebar="" style="max-height: 424px;">
                        <div class="timeline-alt pb-0">

                            <div class="timeline-item">
                                <i class="mdi mdi-airplane bg-danger text-white timeline-icon"></i>
                                <div class="timeline-item-info">
                                    <a href="#" class="text-danger fw-bold mb-1 d-block">{{$totalincoming}} Incoming Samples</a>
                                    <p class="mb-0 pb-2">
                                        <small class="text-muted">Pending dispatch</small>
                                    </p>
                                </div>
                            </div>
                            
                              <div class="timeline-item">
                                <i class="mdi mdi-car-emergency bg-danger text-white timeline-icon"></i>
                                <div class="timeline-item-info">
                                    <a href="{{url('patients/lab/emergencies')}}" class="text-danger fw-bold mb-1 d-block">{{$totalEmergency}} Pending Emergencies</a>
                                    <p class="mb-0 pb-2">
                                        <small class="text-muted">Results not yet released</small>
                                    </p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <i class="mdi mdi-timer-outline bg-success text-white timeline-icon"></i>
                                <div class="timeline-item-info">
                                    <a href="#" class="text-success fw-bold mb-1 d-block">{{$totalRecieved}} Samples recieved</a>
                                    <p class="mb-0 pb-2">
                                        <small class="text-muted">Pending processing</small>
                                    </p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <i class="mdi mdi-microscope bg-warning text-white timeline-icon"></i>
                                <div class="timeline-item-info">
                                    <a href="#" class="text-warning fw-bold mb-1 d-block">{{$totalValidated}} Under processing</a>
                                    <p class="mb-0 pb-2">
                                        <!-- <small class="text-muted">Or results review</small> -->
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
    {{-- <div class="row">
        <div class="col-md-12">
            <canvas id="canvas" height="150" width="600"></canvas>
        </div>
    </div> --}}
<script>
      var gmonth = JSON.parse(`<?php echo $smonth; ?>`);
    var gsales = JSON.parse(`<?php echo $samount; ?>`);
    var barChartData = {
        labels: gmonth,
        datasets: [{
            label: 'Total Monthly tests',
            backgroundColor: "#0ACF97",
            data: gsales
        }]
    };
    window.onload = function() {
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myBar = new Chart(ctx, {
            type: 'line',
            data: barChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: '#c1c1c1',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'Month'
                }
            }
        });
    };
</script>
    <!-- end row -->
</x-crs-layout>
