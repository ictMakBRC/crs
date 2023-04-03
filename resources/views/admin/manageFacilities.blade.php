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
            <h4 class="page-title">Facilities</h4>
        </div>
    </div>
</div>     
<!-- end page title --> 

<div class="row">
    <div class="col-12">
        <div class="card">
          <div class="card-header pt-0">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="text-sm-end mt-3">
                       <h4 class="header-title mb-3  text-center">Facilities</h4> 
                   </div>                                        
               </div>
               <div class="col-sm-8">
                <div class="text-sm-end mt-3">
                    <a type="button" href="#" class="btn btn-primary mb-2 me-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add Facility</a>
                </div>
            </div><!-- end col-->
        </div>
    </div>
    <div class="card-body">

        <div class="tab-content">
            <div class="table-responsive" id="scroll-horizontal-preview">
                <table id="datableButtons" class="table table-striped mb-0 w-100 ">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Parent Facility</th>
                            <th>Requester Name</th>
                            <th>Requester Contact</th>
							<th>Requester Email</th>
                            <th>Date Added</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($facilities as $key=>$facility)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$facility->facility_name}}{{$facility->parent!=null?' ('.$facility->parent->facility_name.')':''}}</td>
                            <td>{{$facility->facility_type}}</td>
                            @if ($facility->parent!=null)
                            <td>{{$facility->parent->facility_name}}</td>  
                            @else
                            <td>N/A</td> 
                            @endif
                            <td>{{$facility->requester_name}}</td>
                            <td>{{$facility->requester_contact}}</td>
							<td>{{$facility->requester_email}}</td>
                            <td>{{date('d-m-Y',strtotime($facility->created_at))}}</td>
                            <td class="table-action">
                                @if($facility->is_active==1)
                                <span class="badge bg-success float-center">Active</span>
                                @php($satate='Active' AND $Stvalue=1)
                                @elseif($facility->is_active==0)
                                <span class="badge bg-danger float-center">InActive</span>
                                @php($satate='InActive' AND $Stvalue=0)
                                @endif
                                <span class="text-success">{{$facility->id}}</span>
                            <a  class="action-icon"> <i class="mdi mdi-pencil" data-bs-toggle="modal" data-bs-target="#editFacility{{$facility->id}}"></i></a>
                     
                        </td>
                        </tr>
                        @endforeach                                                      
                    </tbody>
                </table>                                          
            </div> <!-- end preview-->


        </div> <!-- end tab-content-->

    </div> <!-- end card body-->
</div> <!-- end card -->
</div><!-- end col-->
</div>
<!-- end row-->
 <!-- ADD NEW facilit Modal -->
 @include('admin.facilityModal')
    <!-- UPDATE  facilit Modal -->
	@foreach ($facilities as $key=>$facility)
	<div class="modal fade" id="editFacility{{$facility->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Update facility</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                        </div> <!-- end modal header -->
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route("facilities.update",[$facility->id]) }}">
                                                @method('PUT')
                                                @csrf
                                                <div class="row">
                                                    <div class="mb-3 col-md-6">
                                                        <label for="parent_facility{{$facility->id}}" class="form-label">Parent facility</label>
                                                        <select class="form-select" id="parent_facility{{$facility->id}}" name="parent_id">
                                                            @if ($facility->parent!=null)
                                                            <option selected value="{{$facility->parent_id}}">{{$facility->parent->facility_name}}</option>  
                                                            @endif
                                                            <option value="">None</option>
                                                            @foreach ($allfacilities as $key=>$facility2)
                                                            <option value='{{$facility2->id}}'>{{$facility2->facility_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="facilityName{{$facility->id}}" class="form-label">
                                                            Facility Name</label>
                                                        <input type="text" id="facilityName{{$facility->id}}" class="form-control" name="facility_name" value="{{$facility->facility_name }}">
                                                    </div> <!-- end col -->
                                                    
                                                    <div class="mb-3 col-md-6">
                                                        <label for="facility_type{{$facility->id}}" class="form-label">Type</label>
                                                        <select class="form-select" id="facility_type{{$facility->id}}" name="facility_type">
                                                            <option selected value="{{$facility->facility_type}}">{{$facility->facility_type}}</option>
                                                            <option value='Institution'>Institution</option>
                                                            <option value='Health Facility'>Health Facility</option>
                                                            <option value='API'>API</option>
                                                            
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="requester_name" class="form-label">
                                                            Requester Name</label>
                                                        <input type="text" id="requestername" class="form-control" name="requester_name" value="{{$facility->requester_name}}">
                                                    </div>
                                                    <div class="mb-3 col-md-4">
                                                        <label for="requester_contact" class="form-label">
                                                            Requester Contact</label>
                                                        <input type="text" id="requestercontact" class="form-control" name="requester_contact" value="{{$facility->requester_contact}}">
                                                    </div>
													  <div class="mb-3 col-md-5">
                                                        <label for="requester_contact" class="form-label">
                                                            Requester Email</label>
                                                        <input type="email" id="requester_email" class="form-control" name="requester_email" value="{{$facility->requester_email}}">
                                                    </div>
                                                     <div class="mb-3 col-md-3">
                                                        <label for="is_active" class="form-label">State</label>
                                                        <select class="form-control" id="is_active" name="is_active">
                                                             @if($facility->is_active==1)
                                                             <option selected value="1">Active</option>
                                                            <option value="0">InActive</option>
                                                            @elseif($facility->is_active==0)
                                                            <option selected value="0">InActive</option>
                                                            <option value="1">Active</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                    
                                                </div>
                                                <!-- end row--> 
                                                <div class="d-grid mb-0 text-center">
                                                    <button class="btn btn-primary" type="submit">Update Facility</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div> <!-- end modal content-->
                                </div> <!-- end modal dialog-->
                            </div> 
							@endforeach

</x-general-layout>