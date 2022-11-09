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
            <h4 class="page-title">Kits</h4>
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
                       <h4 class="header-title mb-3  text-center">Kits</h4> 
                   </div>                                        
               </div>
               <div class="col-sm-8">
                <div class="text-sm-end mt-3">
                    <a type="button" href="#" class="btn btn-primary mb-2 me-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add kit</a>
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
                            <th>Kit ID</th>
                            <th>Platform</th>
                            <th>Platiform ID</th>
                            <th>Date Added</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kits as $key=>$kit)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$kit->kit_name}}</td>
                            <td>{{$kit->id}}</td>
                            <td>{{$kit->platform}}</td>
                             <td>{{$kit->platform_id}}</td>
                            <td>{{date('d-m-Y',strtotime($kit->created_at))}}</td>
                            <td class="table-action">
                                <a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-pencil" data-bs-toggle="modal" data-bs-target="#editKit{{$kit->id}}"></i></a>
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
 <!-- ADD NEW kit Modal -->
 @include('admin.kitModal')
    <!-- UPDATE  kit Modal -->
    @foreach ($kits as $kit)
<div class="modal fade" id="editKit{{$kit->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Update Kit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <form method="POST" action="{{ route("kits.update",[$kit->id]) }}">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="row ">
                            <div class="mb-3 col-md-12">
                                <label for="kitName" class="form-label">Kit Name</label>
                                <input type="text" id="kitName" class="form-control" value="{{$kit->kit_name}}" name="kit_name">
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="platform_id" class="form-label">Platform</label>
                                <select class="form-select" id="platform_ide" name="platform_id">
                                    <option selected value="{{$kit->platform_id}}">{{$kit->platform}}</option>
                                    @foreach ($platforms as $platform)
                                    <option value='{{$platform->id}}'>{{$platform->platform_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row--> 
                    <div class="d-grid mb-0 text-center">
                        <button class="btn btn-primary" type="submit">Update Kit</button>
                    </div>
                </form>
            </div>
        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->
@endforeach
</x-general-layout>