<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add New Designation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <form method="POST" action="{{ route("designations.store") }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="designationName" class="form-label">Designation Name</label>
                                <input type="text" id="designationName" class="form-control" name="name" value="{{ old('name', '') }}">
                            </div>
                            <div class="mb-3">
                                <label for="isActive" class="form-label">Status</label>
                                <select class="form-select" id="isActive" name="status">
                                    <option selected value="">Select Status</option>
                                    <option value='Active'>Active</option>
                                    <option value='Inactive'>Inactive</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" rows="3" name="description">{{ old('description', '') }}</textarea>
                            </div>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row--> 
                    <div class="d-grid mb-0 text-center">
                        <button class="btn btn-primary" type="submit"> Create designation</button>
                    </div>
                </form>
            </div>
        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->