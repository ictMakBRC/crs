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
            <h4 class="page-title">Designations</h4>
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
                     <h4 class="header-title mb-3  text-center">Designations or Positions</h4> 
                 </div>                                        
             </div>
             <div class="col-sm-8">
                <div class="text-sm-end mt-3">
                    <a type="button" href="adddesignation.html" class="btn btn-primary mb-2 me-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add Designation</a>
                </div>
            </div><!-- end col-->
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="table-responsive">
                <table id="datableButtons" class="table table-striped mb-0 w-100 ">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Designation Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Date created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($designations as $key=>$designation)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$designation->name}}</td>
                            <td>{{$designation->description}}</td>
                            @if ($designation->status=='Inactive')
                            <td><span class="badge bg-danger">Inactive</span></td>
                            @else
                            <td><span class="badge bg-success">Active</span></td> 
                            @endif
                            <td>{{date('d-m-Y',strtotime($designation->created_at))}}</td>
                            <td class="table-action">
                                <a  href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-pencil" data-bs-toggle="modal" data-bs-target="#editdesignation{{$designation->id}}"></i></a>
                                {{-- <a  onclick="return confirm('Are you sure you want to delete?');" href="{{route('designations.destroy',[$designation->id])}}" class="action-icon"> <i class="mdi mdi-delete"></i></a> --}}
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
<!-- ADD NEW designation Modal -->
@include('admin.designationModal')
@foreach ($designations as $key=>$designation)
<!-- EDIT designation Modal -->
<div class="modal fade" id="editdesignation{{$designation->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Update Designation</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div> <!-- end modal header -->
        <div class="modal-body">
            <form method="POST" action="{{ route("designations.update",[$designation->id]) }}">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="designation_name" class="form-label">Designation Name</label>
                            <input type="text" id="designation_name" class="form-control" value="{{$designation->name}}" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select class="form-select" id="is_active" name="status">
                                <option selected value="{{$designation->status}}">{{$designation->status}}</option>
                                <option value='Active'>Active</option>
                                <option value='Inactive'>Inactive</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" rows="3" name="description">{{$designation->description}}</textarea>
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row--> 
                <div class="d-grid mb-0 text-center">
                    <button class="btn btn-primary" type="submit">Update designation</button>
                </div>
            </form>
        </div>
        
    </div> <!-- end modal content-->
</div> <!-- end modal dialog-->
</div> <!-- end modal-->
@endforeach
</x-general-layoutt>