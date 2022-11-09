<x-crs-layout>
    @section('title', 'Patients list')

    <!-- end row-->
    <div class="row">
        <div class="col-12">
            <div class="row">

                <p style="text-align:center;"><img src="{{asset('storage/results/mak.png')}}" alt="Makerere University Logo" width="150px" style="vertical-align:middle;"></p>
                <h4 style="text-align:center; font-family:times;">MAKERERE UNIVERSITY COLLEGE OF HEALTH SCIENCES</h4><br>
                <h5 style="text-align:center; font-family:times; color:rgb(34, 33, 33)"><b>All patient records Between <span class="text-success">{{$from}}</span> And <span class="text-success">{{$to}}</span> Facility (<span class="text-success">{{$facility}}</span>)</b></h5>
                <hr style="height:2px; width:100%; color:rgb(55, 52, 52);">
            </div>
            {{-- <div class="card">
                <div class="card-body"> --}}
                    <div class="table-responsive">
                        <table id="datableButtons"  class="table ">
                            <thead>
                                <tr>
                                    <th>PTID</th>
                                    <th>LabNo</th>
                                    <th>FacilityId</th>
                                    <th>Collected</th>
                                    <th>DateReceived</th>
                                    <th>Faclility</th>
                                    <th>Names</th>
                                    <th>Contact</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>PatientDistrict</th>
                                    <th>SwabDistrict</th>
                                    <th>WorkSheet No.</th>
                                    <th>Result</th>
                                    <th>ResultDate</th>
                                    <th>Passport</th>
                                    <th>Who</th>
                                    <th>Priority</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patients as $key=>$patient)
                                <tr>
                                    <td>{{$patient->pat_no}}</td>
                                    <td>{{$patient->lab_no}}</td>
                                    <td>{{$patient->patient_id}}</td>
                                    <td>{{$patient->collection_date}}</td>
                                    <td>{{$patient->accessioned_at}}</td>
                                    <td>{{$patient->facility_name}}</td>
                                    <td>{{$patient->surname.' '.$patient->given_name.' '.$patient->other_name}}</td>
                                    <td>{{$patient->phone_number}}</td>
                                    <td>{{$patient->age}}</td>
                                    <td>{{$patient->gender}}</td>
                                    <td>{{$patient->patient_district}}</td>
                                    <td>{{$patient->swab_district}}</td>
                                    <td>{{$patient->worksheet_no}}</td>
                                    <td>{{$patient->result}}</td>
                                    <td>{{$patient->result_added_at}}</td>
                                    <td>{{$patient->doc_no}}</td>
                                    <td>{{$patient->who_tested}}</td>
                                    <td>{{$patient->priority}}</td>
                                    <!--<td class="table-action">-->
                                    <!--    <a href="{{url('patients/view/'.$patient->wid)}}" class="action-icon"> <i class="mdi mdi-eye"></i></a>-->
                                    <!--    {{-- <a href="{{url('patients/lab/edit/'.$patient->wid)}}" class="action-icon"> <i class="mdi mdi-pencil"></i></a> --}}-->
                                    <!--    {{-- <a href="#" class="action-icon d-none"> <i class="mdi mdi-delete"></i></a> --}}-->
                                    <!--</td>-->
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
