<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add New  
                    Platform
                   </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <form method="POST" action="{{ route("platforms.store") }}">
                    @csrf
                    <div class="row">
                     
                        <div class="mb-3 col-md-12">
                            <label for="platformsName" class="form-label">
                                Platform Name</label>
                            <input type="text" id="platformName" class="form-control" name="platform_name" value="{{ old('platform_name', '') }}">
                        </div> <!-- end col -->
                        <div class="mb-3 col-md-12">
                            <label for="platform_range" class="form-label">
                                Range</label>
                            <input type="text" id="platform_range" class="form-control" name="platform_range" value="{{ old('platform_range', '') }}">
                        </div> <!-- end col -->

                    </div>
                    <!-- end row--> 
                    <div class="d-grid mb-0 text-center">
                        <button class="btn btn-primary" type="submit"> Create Platform</button>
                    </div>
                </form>
            </div>
        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->