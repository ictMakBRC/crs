<x-crs-layout>
    @section('title', 'Patients list')

    <!-- end row-->
    <div class="row mx-auto">
        <div class="col-12">
            {{-- <div class="card">
                <div class="card-body"> --}}
                    <div class="table-responsive">
                        <table id="scroll-vertical-datatable" class="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Lab No</th>
                                    <th>Pat No</th>
                                    <th>Patient id</th>
                                    <th>Passport</th>
                                    <th>Names</th>
                                    <!--<th>Gender</th>-->
                                    <th>Facility</th>
                                    <th>Collected</th>
                                     <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patients as $key=>$patient)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$patient->lab_no}}</td>
                                    <td>{{$patient->pat_no}}</td>
                                    <td>{{$patient->patient_id}}</td>
                                    <td>{{$patient->doc_no}}</td>
                                    <td>{{$patient->surname.' '.$patient->given_name.' '.$patient->other_name}}</td>
                                    <!--<td>{{$patient->gender}}</td>-->
                                    <td>{{$patient->facility_name}}</td>
                                    <td>{{$patient->collection_date}}</td>
                                    <td>{{$patient->status}}</td>
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
                     {{$patients->links('pagination.bootstrap-4') }}
                {{-- </div> <!-- end card body-->
            </div> <!-- end card --> --}}
        </div><!-- end col-->
    </div>
    <!-- end row-->
</x-crs-layout>
