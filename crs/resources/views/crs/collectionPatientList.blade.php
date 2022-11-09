<x-crs-layout>
    <div class="row mx-auto">
        <div class="col-12">
            {{-- <div class="card">
                <div class="card-body"> --}}

                    <div class="table-responsive">
                        <table id="datableButtons" class="table w-100 nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Patient id</th>
                                    <th>Lab No</th>
                                    <th>Names</th>
                                    <th>Age</th>
                                    <th>Contact</th>
                                    <th>Gender</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patients as $key=>$patient)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$patient->patient_id}}</td>
                                    <td>{{$patient->lab_no}}</td>
                                    <td>{{$patient->surname.' '.$patient->given_name.' '.$patient->other_name}}</td>
                                    <td>{{$patient->age}}</td>
                                    <td>{{$patient->phone_number}}</td>
                                    <td>{{$patient->gender}}</td>
                                    <td>{{$patient->status}}</td>
                                    <td class="table-action">
                                        <a href="{{route('patients.show',$patient->wid)}}" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                                        @if($patient->status!='Completed')
                                        <a href="{{route('patients.edit',$patient->wid)}}" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                                        @endif
                                         @if($patient->status=='collected')
                                        <a onclick="return confirm('Are you sure you want to cancel {{$patient->surname.' '.$patient->given_name}} sample?');" 
                                        href="{{url('patients/cancel/'.$patient->wid)}}" class="action-icon text-danger text-sm"> <i class="mdi mdi-cancel"></i></a>
                                        @endif
                                        @if($patient->status=='Completed')
                                        <a target="_blanck" href="{{url('patients/result/print/'.$patient->wid)}}" class="action-icon"> <i class="mdi mdi-printer"></i></a>
                                        @endif
                                        {{-- <a href="#" class="action-icon"> <i class="mdi mdi-delete"></i></a> --}}
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
