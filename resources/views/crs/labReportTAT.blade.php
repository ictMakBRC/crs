<x-crs-layout>
    @section('title', 'Patients list')


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
                                    <th>Total TAT(Mins)</th>
                                    <th>Count</th>
                                    <th>Mean TAT(Mins)</th>
                            </tr>
                        <thead>
                            <tbody>
                                @foreach ($meanDailyTat as $key=>$mean)
                                <tr>
                                    <td> <input name='id[]' type="checkbox" id="checkItem"> {{$key+1}}</td>
                                    <td class="text-center">{{$mean->new_date}}</td>
                                    <td>{{$mean->TotalPerDay}}</td>
                                    <td>{{$mean->CountPerDay}}</td>
                                    <td>
                                    @php
                                        $meanValue = ($mean->TotalPerDay+0.001)/($mean->CountPerDay+0.001)
                                    @endphp
                                    @convert($meanValue+0.001)
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                    </table>
                    {{-- {{$propIn}} --}}
                </div>
            </div>
     
        </div><!-- end col-->
        <div class="col-md-12">
            <canvas id="canvas" height="150" width="600"></canvas>
        </div>
    </div>
    <script>
        var gmonth;
      var gsales ;
      var barChartData = {
          labels: [ @foreach ($meanData as $mean)
        '{{$mean->new_date}}',
        @endforeach],
          datasets: [{
              label: 'TAT MEAN',
              borderColor: "rgb(62,149,205)",
                backgroundColor: "rgb(62,149,205,0.1)",
              data: [ @foreach ($meanData as $mean)
              @php
            $meanValue = ($mean->TotalPerDay+0.001)/($mean->CountPerDay+0.001)
                @endphp
                @convert($meanValue+0.001),
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
