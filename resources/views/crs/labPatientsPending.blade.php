<x-crs-layout>
    @section('title', 'Patients list')
       <!-- start page title -->
       {{-- <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Patient List</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- end page title -->

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
                                        <th>Patient ID</th>
                                        <th>Passport</th>
                                        <!--<th>Priority</th>-->
                                        <th>Names</th>
                                        <!--<th>Gender</th>-->
                                        <!--<th>Age</th>-->
                                        <th>Faclility</th>
                                        <th>Date Collected</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patients as $key=>$patient) 
                                      @if($patient->priority =='Emergency')
                                     @php($text="text-danger")
                                     @else
                                     @php($text="")
                                     @endif
                                    <tr class="{{$text}}">
       
                                        <td>{{$key+1}}</td>
                                         <td>{{$patient->lab_no?$patient->lab_no:'N/A'}}</td>
                                        <td>{{$patient->patient_id}}</td>
                                        <td>{{$patient->doc_no}}</td>
                                        <!--@if ($patient->priority!='Emergency')-->
                                        <!--<td><span class="badge bg-success">{{$patient->priority?$patient->priority:'N/A'}}</span></td> -->
                                        <!--@else-->
                                        <!--<td><span class="badge bg-danger">{{$patient->priority?$patient->priority:'N/A'}}</span></td>-->
                                        <!--@endif-->
                                        <td>{{$patient->surname.' '.$patient->given_name.' '.$patient->other_name}}</td>
                                        <!--<td>{{$patient->gender}}</td>-->
                                        <!--<td>{{$patient->age}}</td>-->
                                        <td>{{$patient->facility_name}}</td>
                                        <td>{{$patient->collection_date}}</td>
                                        <td class="table-action">                                       
                                            <a href="{{url('patients/view/'.$patient->wid)}}" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                                            <a href="{{url('patients/lab/edit/'.$patient->wid)}}" class="action-icon {{$val}}"> <i class="mdi mdi-pencil"></i></a>
                                            <a href="{{url('patients/lab/validate/'.$patient->wid)}}" class="action-icon {{$ac}}"> <i class="mdi mdi-account-check"></i></a>
                                            <a  href="{{url('patients/lab/export/'.$patient->wid)}}" class="action-icon {{$val}}"> <i class="mdi mdi-application-export"></i></a>
                                            <a href="javascript: void(0);" class="action-icon {{$sub}}" data-bs-toggle="modal" data-bs-target="#editpending{{$patient->wid}}"><i class="mdi mdi-arrow-up-circle"></i> </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                            <form action="{{url('patients/export')}}"  class="{{$val}}" method="POST">
                                @csrf
                            <input type="hidden" name="state" value="{{$state}}">
                            <input type="hidden" name="time" value="{{$time}}">
                            <button type="submit" class="btn btn-success float-end">  <i class="mdi mdi-export"></i> Export to CSV</button>

                            </form>
                {{-- </div> <!-- end card body-->

            </div> <!-- end card --> --}}
            {{$patients->links('pagination.bootstrap-4') }}
        </div><!-- end col-->
    </div>
    <!-- end row-->
    @foreach ($patients as $key=>$patient)  
    @include('crs.inc.accessModal')
    @endforeach
</x-crs-layout>
