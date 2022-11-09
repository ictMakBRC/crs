<x-crs-layout>
    @section('title', 'Patients list')

    <!-- end row-->
    <div class="row">
        <div class="col-12">
            <div class="row">

                <p style="text-align:center;"><img src="{{asset('storage/results/mak.png')}}" alt="Makerere University Logo" width="150px" style="vertical-align:middle;"></p>
                <h4 style="text-align:center; font-family:times;">MAKERERE UNIVERSITY COLLEGE OF HEALTH SCIENCES</h4><br>
                <h5 style="text-align:center; font-family:times; color:rgb(34, 33, 33)"><b>All patient records Between <span class="text-success">{{$from}}</span> And <span class="text-success">{{$to}}</span></b></h5>
                <hr style="height:2px; width:100%; color:rgb(55, 52, 52);">
            </div>
            {{-- <div class="card">
                <div class="card-body"> --}}
                    <div class="table-responsive">
                        <table id="datableButtons"  class="table dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Entry to Accession</th>
                                    <th>Accession to Validation</th>
                                    <th>Validation to Result</th>
                                    <th>Accession to Result</th>
                                    <th>Entry To Result</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($time_difference as $key=>$tat)
                                <tr>
                                    <td>{{$tat->new_date}}</td> 
                                    <td> {{round($tat->EnteredAccessionedDiff / 60,2)}} Mins</td>
                                    <td>{{round($tat->AccessionedValidatedDiff / 60,2)}} Mins</td>
                                    <td>{{round($tat->ValidatedResultDiff / 60,2)}} Mins</td>
                                    <td>{{round($tat->AccessionedResultDiff / 60,2)}} Mins</td>  
                                    <td>{{round($tat->EnteredResultDiff / 60,2)}} Mins</td>                                  
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
