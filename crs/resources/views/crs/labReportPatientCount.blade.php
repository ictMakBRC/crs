<x-crs-layout>
    @section('title', 'Patients list')

    <!-- end row-->
    <div class="row">
        <div class="col-12">
            <div class="row">

                <p style="text-align:center;"><img src="{{asset('storage/results/mak.png')}}" alt="Makerere University Logo" width="150px" style="vertical-align:middle;"></p>
                <h4 style="text-align:center; font-family:times;">MAKERERE UNIVERSITY COLLEGE OF HEALTH SCIENCES</h4><br>
                <h5 style="text-align:center; font-family:times; color:rgb(34, 33, 33)"><b>All patient Count Between <span class="text-success">{{ date('d-M-Y', strtotime($from))}}</span> And <span class="text-success">{{ date('d-M-Y', strtotime($to))}}</span> Facility (<span class="text-success">{{$facility}}</span>)</b></h5>
                <hr style="height:2px; width:100%; color:rgb(55, 52, 52);">

            </div>
            {{-- <div class="card">
                <div class="card-body"> --}}
                    <div class="table-responsive">
                        <table id="datableButtons"  class="table dt-responsive">
                            <thead>
                                <tr>
                                    <th>No.</th>

                                    <th>Faclility Name</th>
                                    <th>Total samples</th>
                                    <th>Positives</th>
                                    <th>Positivity Rate</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patients as $key=>$patient)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td> @if ($patient->parent_id!=null)
                                    {{ $patient->facility_name.' (SUB)'}}
                                    @else
                                    {{$patient->facility_name}}
                                    @endif</td>
                                    <td>{{$patient->data}}</td>
                                    <td>{{$patient->positives}}</td>
                                    <td>{{$patient->rate}}</td>
                                    <td>{{$patient->newdate}}</td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end preview-->

                {{-- </div> <!-- end card body-->
            </div> <!-- end card --> --}}
        </div><!-- end col-->
    </div>
    <!-- end row-->
</x-crs-layout>
