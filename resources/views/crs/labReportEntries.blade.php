<x-crs-layout>
    @section('title', 'Patients list')

    <!-- end row-->
    <div class="row mx-auto">
        <div class="col-12">
            <div class="row">

                <p style="text-align:center;"><img src="{{asset('storage/results/mak.png')}}" alt="Makerere University Logo" width="150px" style="vertical-align:middle;"></p>
                <h4 style="text-align:center; font-family:times;">MAKERERE UNIVERSITY COLLEGE OF HEALTH SCIENCES</h4><br>
                <h5 style="text-align:center; font-family:times; color:rgb(34, 33, 33)"><b>All user patient entries Between <span class="text-success">{{$from}}</span> And <span class="text-success">{{$to}}</span> Facility (<span class="text-success">{{$user}}</span>)</b></h5>
                <hr style="height:2px; width:100%; color:rgb(55, 52, 52);">
            </div>
            {{-- <div class="card">
                <div class="card-body"> --}}
                    <div class="table-responsive">
                        <table id="datableButtons"  class="table dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>LabNo</th>
                                    <th>Names</th>
                                    <!--<th>Email</th>-->
                                    <th>Collected</th>
                                    <th>Gender</th>
                                    <th>Faclility</th>
                                    <th>Fser</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patients as $key=>$patient)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$patient->lab_no}}</td>
                                    <td>{{$patient->Sname.' '.$patient->Gname.' '.$patient->Oname}}</td>
                                    <!--<td>{{$patient->patient_email}}</td>-->
                                    <td>{{$patient->created_at}}</td>
                                    <td>{{$patient->gender}}</td>
                                    <td>{{$patient->facility_name}}</td>
                                    <td>{{$patient->first_name}}</td>
                                    <td class="table-action">
                                        <a href="{{url('patients/view/'.$patient->wid)}}" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                                        {{-- <a href="{{url('patients/lab/edit/'.$patient->wid)}}" class="action-icon"> <i class="mdi mdi-pencil"></i></a> --}}
                                        {{-- <a href="#" class="action-icon d-none"> <i class="mdi mdi-delete"></i></a> --}}
                                    </td>
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
