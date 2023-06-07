<x-crs-layout>
    @section('title', 'Results TAT propotions')


    <!-- end row-->
    <div class="row mx-auto">
        <div class="col-12">
            <div class="card">
                @include('crs.inc.tatfilter')
                
            </div> <!-- end card -->

            <div class="card">
                <div class="card-body">
                    <table id="datableButtons"  class="table dt-responsive nowrap text-end">
                        <thead class="text-center">
                            <tr>
                                    <th>#</th>
                                    <th>Date ({{$title}})</th>
                                    <th>Inside Rage</th>
                                    <th>Outside Rage</th>
                                    <th>Total Samples</th>
                                    <th>within TAT(%)</th>
                                    <th>Outside TAT(%)</th>
                            </tr>
                        <thead>
                            <tbody>
                                @foreach ($propotions as $key=>$data)
                                <tr>
                                    <td> <input name='id[]' type="checkbox" id="checkItem"> {{$key+1}}</td>
                                    <td class="text-center">{{$data->new_date}}</td>
                                    <td>{{$data->totalwitin}}</td>
                                    <td>{{$data->totalOut}}</td>
                                    <td>{{$data->total}}</td>
                                    <td>
                                    @php
                                        $propValue = ($data->totalwitin/$data->total)*100
                                    @endphp
                                    @convert($propValue)
                                    </td>
                                    <td>
                                        @php
                                            $propValue2 = ($data->totalOut/$data->total)*100
                                        @endphp
                                        @convert($propValue2)
                                        </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                    </table>
                    {{-- {{$propIn}} --}}
                </div>
            </div>
     
        </div><!-- end col-->
        <div class="col-md-12 ">
            <canvas id="canvas" height="150" width="600"></canvas>
        </div>

        <div class="col-md-12 ">
            <div id="apexbar"></div>
        </div>

        <div>
           
            </div>
    </div>
    {{-- <script src="{{url('assets/js/vendor/Chart.bundle.min.js')}}"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> 
    <script>
    var optionsb = {
      
        series: [{
                name: '% Propotion within range',
                data: [
                    @foreach ($ChartData as $data) 
                    @php
                    $propValue = ($data->totalwitin/$data->total)*100
                @endphp
                @convert($propValue),
                    @endforeach
                ],
                title: {
                    text: '% Propotion within range'
                }
            },
            {
                name: '% Propotion outside range',
                data: [
                    @foreach ($ChartData as $data) 
                        @php
                        $propValue = ($data->totalOut/$data->total)*100
                        @endphp
                        @convert($propValue),
                    @endforeach
                ],
                title: {
                    text: '% Propotion outside range'
                }
            }

        ],
        colors: ['#119A48', '#951F39', '#BBA66D'],
        markers: {
   colors: ['#F44336', '#E91E63', '#9C27B0']
},
dataLabels: {
  style: {
    colors: ['#F44336', '#E91E63', '#9C27B0']
  }
},
        chart: {
            height: 350,
            widith: 350,
            type: 'bar',
            stacked: false,
        },
        stroke: {
            width: [0, 2, 5],
            curve: 'smooth'
        },
        plotOptions: {
            bar: {
                columnWidth: '50%'
            }
        },

        fill: {
            opacity: [0.85, 0.25, 1],
            gradient: {
                inverseColors: false,
                shade: 'light',
                type: "vertical",
                opacityFrom: 0.85,
                opacityTo: 0.55,
                stops: [0, 100, 100, 100]
            }
        },
        labels: [
            @foreach ($ChartData as $data) '{{$data->new_date}}', @endforeach
        ],
        markers: {
            size: 0
        },
        yaxis: {
            title: {
                text: 'Patients',
            },
            min: 0
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function(y) {
                    if (typeof y !== "undefined") {
                        return y.toFixed(0) + " samples";
                    }
                    return y;

                }
            }
        }
    };

    var chartb = new ApexCharts(document.querySelector("#apexbar"), optionsb);
    chartb.render();
</script>

    <script>
    //     var ctx = document.getElementById('canvas').getContext('2d');
    //    var myChart = new Chart(ctx, {
    //        type: 'bar',
    //        data: {
    //          labels: [ @foreach ($ChartData as $data) '{{$data->new_date}}', @endforeach],
    //          datasets: [ { 
    //              data: [ 
    //                 @foreach ($ChartData as $data)   
    //              @php
    //                 $propValue = ($data->totalwitin/$data->total)*100
    //             @endphp
    //             @convert($propValue),
    //          @endforeach],
    //              label: "% Propotion inside range",
    //              borderColor: "rgb(60,186,159)",
    //              backgroundColor: "rgb(60,186,159,0.2)",
    //            },
    //            { 
    //              data: [ 
    //                 @foreach ($ChartData as $data)   
    //              @php
    //                 $propValue = ($data->totalOut/$data->total)*100
    //             @endphp
    //             @convert($propValue),
    //          @endforeach],
    //              label: "% Propotion Outiside range",
    //              borderColor: "rgb(60,186,159)",
    //              backgroundColor: "rgb(255, 99, 132, 0.2)",
    //            }
    //          ]
    //        },
    //      });
     </script>
  
    <!-- end row-->
</x-crs-layout>
