<x-crs-layout>
<div class="row mx-auto">
    <div class="col-12">
        <div class="">
          <div class="card-header pt-0">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="text-sm-end mt-3">
                       <h4 class="header-title mb-3  text-center">Swabbers</h4> 
                   </div>                                        
               </div>
               <div class="col-sm-8">
                <div class="text-sm-end mt-3">
                    <a type="button" href="#" class="btn btn-primary mb-2 me-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add swabber</a>
                </div>
            </div><!-- end col-->
        </div>
    </div>
    <div class="card-body mt-0">
        <table id="datableButtons" class="table table-striped mb-0 w-100 ">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Swabber Name</th>
                    @if(!Auth::user()->hasRole(['DataClerkSite']))
                    <th>Facility</th>
                    @endif
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Date Added</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($swabbers as $key=>$swabber)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$swabber->full_name}}</td>
                    @if(!Auth::user()->hasRole(['DataClerkSite']))
                    <td>{{$swabber->facility->facility_name}}{{$swabber->facility->parent!=null?' ('.$swabber->facility->parent->facility_name.')':''}}</td>
                    @endif
                    <td>{{$swabber->swabber_contact}}</td>
                    <td>{{$swabber->swabber_email}}</td>
                    @if ($swabber->status=='Inactive')
                    <td><span class="badge bg-danger">Inactive</span></td>
                    @else
                    <td><span class="badge bg-success">Active</span></td> 
                    @endif
                    <td>{{date('d-m-Y',strtotime($swabber->created_at))}}</td>
                    <td class="table-action">
                        <a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-pencil" data-bs-toggle="modal" data-bs-target="#editSwabber{{$swabber->id}}"></i></a>
                        {{-- <a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a> --}}
                    </td>
                </tr>
                @endforeach                                                      
            </tbody>
        </table>                                          
    </div> <!-- end card body-->
</div> <!-- end card -->
</div><!-- end col-->
</div>
<!-- end row-->
 <!-- ADD NEW swabber Modal -->
@include('crs.swabberModal')
    <!-- UPDATE  swabber Modal -->
@foreach ($swabbers as $key=>$swabber)
<div class="modal fade" id="editSwabber{{$swabber->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Update Swabber</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <form method="POST" action="{{ route("swabbers.update",[$swabber->id]) }}">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        
                            <div class="mb-3 col-md-6">
                                <label for="swabberName" class="form-label">Swabber Name<span class="text-danger">*</span></label>
                                <input type="text" id="swabberName" class="form-control" value="{{$swabber->full_name}}" name="full_name" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="swabber_contact2" class="form-label">
                                    Swabber Contact
                                </label>
                                <input type="text" id="swabber_contact2" class="form-control" name="swabber_contact" value="{{$swabber->swabber_contact}}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="swabber_email2" class="form-label">
                                    Swabber Email
                                </label>
                                <input type="text" id="swabber_email2" class="form-control" name="swabber_email" value="{{$swabber->swabber_email}}">
                            </div>
                            @if(Auth::user()->hasRole(['DataClerkSite']))
                            <input type="text" id="facilityid" hidden class="form-control" name="facility_id" value="{{ auth()->user()->facility_id }}">
                            @else
                            <div class="mb-3 col-md-6">
                                <label for="facility_id" class="form-label">Facility<span class="text-danger">*</span></label>
                                <select class="form-select" id="facility_id" name="facility_id" required>
                                    <option value="{{$swabber->facility_id}}">{{$swabber->facility->facility_name}}{{$swabber->facility->parent!=null?' ('.$swabber->facility->parent->facility_name.')':''}}</option>
                                    @if(count($facilities)>0)
                                    @foreach($facilities as $facility)
                                    <option value="{{ $facility->id }}">{{$facility->facility_name}}{{$facility->parent!=null?' ('.$facility->parent->facility_name.')':''}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            @endif
                            <div class="mb-3 col-md-6">
                                <label for="is_active" class="form-label">Status<span class="text-danger">*</span></label>
                                <select class="form-select" id="is_active" name="status" required>
                                    <option selected value="{{$swabber->status}}">{{$swabber->status}}</option>
                                    <option value='Active'>Active</option>
                                    <option value='Inactive'>Inactive</option>
                                </select>
                            </div>
                        
                    </div>
                    <!-- end row--> 
                    <div class="d-grid mb-0 text-center">
                        <button class="btn btn-primary" type="submit">Update Swabber</button>
                    </div>
                </form>
            </div>
        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->
@endforeach
</x-crs-layout>