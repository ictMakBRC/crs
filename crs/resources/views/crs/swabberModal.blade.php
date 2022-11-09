<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add New  
                    Swabber
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <form method="POST" action="{{ route("swabbers.store") }}">
                    @csrf
                    <div class="row">
                        
                            <div class="mb-3 col-md-6">
                                <label for="SwabberName" class="form-label">
                                    Swabber Name<span class="text-danger">*</span>
                                </label>
                                <input type="text" id="full_name" class="form-control" name="full_name" value="{{ old('full_name', '') }}" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="swabber_contact" class="form-label">
                                    Swabber Contact
                                </label>
                                <input type="text" id="swabber_contact" class="form-control" name="swabber_contact" value="{{ old('swabber_contact', '') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="swabber_email" class="form-label">
                                    Swabber Email
                                </label>
                                <input type="text" id="swabber_email" class="form-control" name="swabber_email" value="{{ old('swabber_email', '') }}">
                            </div>
                            @if(Auth::user()->hasRole(['DataClerkSite']))
                            <input type="text" id="facilityid" hidden class="form-control" name="facility_id" value="{{ auth()->user()->facility_id }}">
                            @else
                            <div class="mb-3 col-md-6">
                                <label for="facility_id" class="form-label">Facility<span class="text-danger">*</span></label>
                                <select class="form-select" id="facility_id" name="facility_id" required>
                                    <option value="">Select</option>
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
                                    <option selected value="">Select Status</option>
                                    <option value='Active'>Active</option>
                                    <option value='Inactive'>Inactive</option>
                                </select>
                            </div>
                          
                    </div>
                            <!-- end row--> 
                    <div class="d-grid mb-2 text-center">
                        <button class="btn btn-primary" type="submit"> Create Swabber</button>
                    </div>
                </form>
            </div>
        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->