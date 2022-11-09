<x-general-layout>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <form class="d-flex">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-light" id="dash-daterange">
                        <span class="input-group-text bg-primary border-primary text-white">
                            <i class="mdi mdi-calendar-range font-13"></i>
                        </span>
                    </div>
                </form>
            </div>
            <h4 class="page-title">Manage Patients</h4>
        </div>
    </div>
</div>     
<!-- end page title --> 

<div class="row mx-auto">
    <div class="col-12">
        {{-- <div class="card">
            <div class="card-body"> --}}
                <div class="table-responsive">
                    <table id="scroll-vertical-datatable" class="table dt-responsive">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Lab No</th>
                                <th>Patient id</th>
                                <!--<th>Passport</th>-->
                                <th>Names</th>
                                <th>Sate</th>
                                <!--<th>Faclility</th>-->
                               <th>Created at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patients as $key=>$patient)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$patient->lab_no}}</td>
                                <td>{{$patient->patient_id}}</td>
                                <!--<td>{{$patient->doc_no}}</td>-->
                                <td>{{$patient->surname.' '.$patient->given_name.' '.$patient->other_name}}</td>
                                <td>{{$patient->status}}</td>
                                <!--<td>{{$patient->facility_name}}</td>-->
                               <td>{{$patient->date}}</td>
                                <td class="table-action">
                                    <a href="{{url('patients/view/'.$patient->wid)}}" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                                    <!--<a href="{{url('admin/lab/edit/'.$patient->wid)}}" class="action-icon"> <i class="mdi mdi-account-check"></i></a>-->
                                     @if($patient->status!='Cancel')
                                    <a onclick="return confirm('Are you sure you want to cancel {{$patient->surname.' '.$patient->given_name}} sample?');" 
                                    href="{{url('lab/patients/cancel/'.$patient->wid)}}" class="action-icon text-danger text-sm"> <i class="mdi mdi-cancel"></i></a>
                                    @endif
                                       @if($patient->status=='Cancel')
                                    <a onclick="return confirm('Are you sure you want to cancel {{$patient->surname.' '.$patient->given_name}} sample?');" 
                                    href="{{url('lab/patients/Ucancel/'.$patient->wid)}}" class="action-icon text-danger text-sm"> <i class="mdi mdi-check"></i></a>
                                    @endif
                                    @if($patient->status=='Completed')
                                     <a href="{{url('admin/manage/results/'.$patient->wid)}}" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                                    @endif
                                    <a href="{{url('admin/lab/validate/'.$patient->wid)}}" class="action-icon"> <i class="mdi mdi-account-check"></i></a>
                                    <a  href="{{url('patients/lab/delete/'.$patient->wid)}}" class="action-icon" onclick="return confirm('Are you sure you want to delete this patient?');"> <i class="mdi mdi-delete"></i></a>
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


</x-general-layout>