<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add New  
                    Kit
                   </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <form method="POST" action="{{ route("kits.store") }}">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="kit_name" class="form-label">
                                Kit Name</label>
                            <input type="text" id="kit_name" class="form-control" name="kit_name" value="{{ old('kit_name', '') }}">
                        </div> <!-- end col -->
                        
                        <div class="mb-3 col-md-12">
                            <label for="platform_id" class="form-label">Platform</label>
                            <select class="form-select" id="platform_id" name="platform_id">
                                <option selected value="">Select Platform</option>
                                @foreach ($platforms as $platform)
                                    <option value='{{$platform->id}}'>{{$platform->platform_name}}</option>
                                @endforeach
                                
                            </select>
                        </div>
                    </div>
                    <!-- end row--> 
                    <div class="d-grid mb-0 text-center">
                        <button class="btn btn-primary" type="submit"> Create Kit</button>
                    </div>
                </form>
            </div>
        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->