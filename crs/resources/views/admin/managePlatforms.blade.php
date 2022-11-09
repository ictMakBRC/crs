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
            <h4 class="page-title">Platforms</h4>
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
                       <h4 class="header-title mb-3  text-center">Platforms</h4> 
                   </div>                                        
               </div>
               <div class="col-sm-8">
                <div class="text-sm-end mt-3">
                    <a type="button" href="#" class="btn btn-primary mb-2 me-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add platform</a>
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
                            <th>Range</th>
                            <th>Import ID</th>
                            <th>Date Added</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($platforms as $key=>$platform)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$platform->platform_name}}</td>
                            <td>{{$platform->platform_range}}</td>
                            <td>{{$platform->id}}</td>
                            <td>{{date('d-m-Y',strtotime($platform->created_at))}}</td>
                            <td class="table-action">
                                <a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-pencil" data-bs-toggle="modal" data-bs-target="#editPlatform{{$platform->id}}"></i></a>
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
 <!-- ADD NEW platform Modal -->
 @include('admin.platformModal')
    <!-- UPDATE  platform Modal -->
 @foreach ($platforms as $platform)
<div class="modal fade" id="editPlatform{{$platform->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Update Platform</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <form method="POST" action="{{ route("platforms.update",[$platform->id]) }}">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="platformsName" class="form-label">
                                Platform Name</label>
                            <input type="text" id="platformName" class="form-control" name="platform_name" value="{{$platform->platform_name }}">
                        </div> <!-- end col -->
                        <div class="mb-3 col-md-12">
                            <label for="platform_range" class="form-label">
                                Range</label>
                            <input type="text" id="platform_range" class="form-control" name="platform_range" value="{{$platform->platform_range}}">
                        </div> <!-- end col -->
                    </div>
                    <!-- end row--> 
                    <div class="d-grid mb-0 text-center">
                        <button class="btn btn-primary" type="submit">Update Platform</button>
                    </div>
                </form>
            </div>
        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->
@endforeach
</x-general-layout>