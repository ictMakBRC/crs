<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add New  
                    Facility
                   </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <form method="POST" action="{{ route("facilities.store") }}">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="parent_facility" class="form-label">Parent facility</label>
                            <select class="form-select" id="parent_facility" name="parent_id">
                                <option selected value="">Select Parent</option>
                                <option value="">None</option>
                                @foreach ($facilities as $key=>$facility)
                                <option value='{{$facility->id}}'>{{$facility->facility_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="facilitiesName" class="form-label">
                                Facility Name</label>
                            <input type="text" id="facilityName" class="form-control" name="facility_name" value="{{ old('facility_name', '') }}" required>
                        </div> <!-- end col -->
                        
                        <div class="mb-3 col-md-6">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" id="facility_type" name="facility_type" required>
                                <option selected value="">Select Type</option>
                                <option value='Institution'>Institution</option>
                                <option value='Health Facility'>Health Facility</option>
                                <option value='API'>API</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="requester_name" class="form-label">
                                Requester Name</label>
                            <input type="text" id="requester_name" class="form-control" name="requester_name" value="{{ old('requester_name', '') }}" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="requester_contact" class="form-label">
                                Requester Contact</label>
                            <input type="text" id="requester_contact" class="form-control" name="requester_contact" value="{{ old('requester_contact', '') }}" required>
                        </div>
						  <div class="mb-3 col-md-6">
							<label for="requester_contact" class="form-label">
								Requester Email</label>
							<input type="email" id="requester_email" class="form-control" name="requester_email" value="{{ old('requester_email', '') }}">
						</div>
                    </div>
                    <!-- end row--> 
                    <div class="d-grid mb-0 text-center">
                        <button class="btn btn-primary" type="submit"> Create Facility</button>
                    </div>
                </form>
            </div>
        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->