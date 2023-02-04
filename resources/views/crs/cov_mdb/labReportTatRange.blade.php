<x-crs-layout>
    @section('title', 'Patients list')


    <!-- end row-->
    <div class="row mx-auto">
        <div class="col-12">
            <div class="card">
                @include('crs.cov_mdb.tatfilter')
            </div> <!-- end card -->

            <div class="card">
                <div class="card-body">
                    <table id="datableButtons"  class="table dt-responsive nowrap text-end">
                        <thead class="text-center">
                            <tr>
                                    <th>#</th>
                                    <th>Date ({{$title}})</th>
                                    <th>Lowest TAT(Mins)</th>
                                    <th>Highest TAT(Mins)</th>
                                    <th>Range(Mins)</th>
                            </tr>
                        <thead>
                            <tbody>
                                @foreach ($rangeTat as $key=>$data)
                                <tr>
                                    <td> <input name='id[]' type="checkbox" id="checkItem"> {{$key+1}}</td>
                                    <td class="text-center">{{$data->new_date}}</td>
                                    <td>{{$data->MinMins}}</td>
                                    <td>{{$data->MaxMins}}</td>
                                    <td>
                                    @php
                                        $rangeValue = $data->MaxMins-$data->MinMins
                                    @endphp
                                    @convert($rangeValue)
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                    </table>
                    {{-- {{$propIn}} --}}
                </div>
            </div>
     
        </div><!-- end col-->
        <div class="col-md-12 d-none">
            <canvas id="canvas" height="150" width="600"></canvas>
        </div>

        <div>
            <canvas id="myChart" height="250" width="600"></canvas>
            </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
       var myChart = new Chart(ctx, {
           type: 'line',
           data: {
             labels: [ @foreach ($rangeChartData as $data) '{{$data->new_date}}', @endforeach],
             datasets: [{ 
                 data: [ @foreach ($rangeChartData as $data)
            @php
                $rangeValue = $data->MaxMins-$data->MinMins
            @endphp
                @convert($rangeValue),
             @endforeach],
                 label: "TAT Range",
                 borderColor: "rgb(962,59,25)",
                 backgroundColor: "rgb(962,149,205,0.1)",
               }, { 
                 data: [ @foreach ($rangeChartData as $data) {{$data->MaxMins}}, @endforeach],
                 label: "Highest TAT",
                 borderColor: "rgb(60,186,159)",
                 backgroundColor: "rgb(60,186,159,0.1)",
               }, { 
                 data: [ @foreach ($rangeChartData as $data) {{$data->MinMins}}, @endforeach],
                 label: "Lowest TAT",
                 borderColor: "rgb(255,165,0)",
                 backgroundColor:"rgb(255,165,0,0.1)",
               }
             ]
           },
         });
     </script>
    <script>
        var gmonth;
      var gsales ;
      var barChartData = {
          labels: [ @foreach ($rangeChartData as $data)
        '{{$data->new_date}}',
        @endforeach],
          datasets: [{
              label: 'TAT Range',
              borderColor: "rgb(862,19,05)",
                backgroundColor: "rgb(62,149,205,0.1)",
              data: [ @foreach ($rangeChartData as $data)
            @php
                $rangeValue = $data->MaxMins-$data->MinMins
            @endphp
                @convert($rangeValue),
             @endforeach]
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
                      text: '{{$title}}'
                  }
              }
          });
      };
  </script>
    <!-- end row-->
</x-crs-layout>
