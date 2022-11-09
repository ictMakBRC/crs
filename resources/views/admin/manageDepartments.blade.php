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
            <h4 class="page-title">Departments</h4>
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
                       <h4 class="header-title mb-3  text-center">Departments</h4> 
                   </div>                                        
               </div>
               <div class="col-sm-8">
                <div class="text-sm-end mt-3">
                    <a type="button" href="#" class="btn btn-primary mb-2 me-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add Department</a>
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
                            <th>Department Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Date Added</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $key=>$department)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$department->department_name}}</td>
                            <td>{{$department->description}}</td>
                            @if ($department->status=='Inactive')
                            <td><span class="badge bg-danger">Inactive</span></td>
                            @else
                            <td><span class="badge bg-success">Active</span></td> 
                            @endif
                            <td>{{date('d-m-Y',strtotime($department->created_at))}}</td>
                            <td class="table-action">
                                <a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-pencil" data-bs-toggle="modal" data-bs-target="#editDept{{$department->id}}"></i></a>
                                {{-- <a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a> --}}
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
 <!-- ADD NEW DEPARTMENT Modal -->
 @include('admin.departmentModal')
    <!-- UPDATE  DEPARTMENT Modal -->
    @foreach ($departments as $key=>$department)
<div class="modal fade" id="editDept{{$department->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Update Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <form method="POST" action="{{ route("departments.update",[$department->id]) }}">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="row ">
                            <div class="mb-3 col-md-8">
                                <label for="departmentName" class="form-label">Department Name</label>
                                <input type="text" id="departmentName" class="form-control" value="{{$department->department_name}}" name="department_name">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="is_active" class="form-label">Status</label>
                                <select class="form-select" id="is_active" name="status">
                                    <option selected value="{{$department->status}}">{{$department->status}}</option>
                                    <option value='Active'>Active</option>
                                    <option value='Inactive'>Inactive</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" rows="3" name="description">{{$department->description}}</textarea>
                            </div>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row--> 
                    <div class="d-grid mb-0 text-center">
                        <button class="btn btn-primary" type="submit">Update Department</button>
                    </div>
                </form>
            </div>
        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->
@endforeach
</x-general-layout>