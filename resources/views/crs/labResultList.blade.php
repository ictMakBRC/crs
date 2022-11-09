<x-crs-layout>
    @section('title', 'Patients list')
    <!-- end row-->
    <div class="row mx-auto">
        <div class="col-12">
            {{-- <div class="card"> --}}
                {{-- <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <div class="text-sm-end mt-3">
                                <h4 class="header-title mb-3  text-center">My Patients</h4>
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="card-body"> --}}
                    <label for=""><input type="checkbox" id="checkAll"> Select All</label>
                    <div class="table-responsive">
                        <table id="scroll-vertical-datatable" class="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Lab No.</th>
                                    <th>Patient id</th>
                                    <th>Names</th>
                                    <th>Gender</th>
                                    <th>Faclility</th>
                                    <th>Results</th>
                                    <th>Results Date</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patients as $key=>$patient)
                                <tr>
                                    <td> <input name='id[]' type="checkbox" id="checkItem" value="{{$patient->wid}}"> {{$key+1}}</td>
                                    <td>{{$patient->lab_no}}</td>
                                    <td>{{$patient->patient_id}}</td>
                                    <td>{{$patient->surname.' '.$patient->given_name.' '.$patient->other_name}}</td>
                                    <td>{{$patient->gender}}</td>
                                    <td>{{$patient->facility_name}}</td>
                                    <td>{{$patient->result}} 
                                    @if($patient->rds_success!='202')
                                    <a href="{{url('patients/complete/'.$patient->wid)}}" class="btn btn-sm btn-outline-light  {{$sub}}">Complete</a></td>
                                    @endif
                                    <td>{{$patient->result_added_at}}</td>
                                    <td class="table-action">
                                        <a href="{{url('patients/view/'.$patient->wid)}}" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                                        <a href="{{route('send.rds',$patient->wid)}}" disabled class="action-icon {{$sub}}"> <i class="uil-plane-departure text-success"></i></a>
                                        <a target="_blanck" href="{{url('patients/result/print/'.$patient->wid)}}" class="action-icon"> <i class="mdi mdi-printer"></i></a>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script language="javascript">
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
    <!-- end row-->
</x-crs-layout>
