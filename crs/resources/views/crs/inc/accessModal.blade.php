<div class="modal fade" id="editpending{{$patient->wid}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add <span class="text-success">{{ $patient->surname }}  {{ $patient->given_name }}</span>'s
                    Lab No.
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <div class="card-body">

                    <form method="POST" action="{{url('patient/lab/number/'.$patient->wid)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="lab_no" class="form-label">lab no<span class="text-danger">*</span></label>
                                <input type="text" id="lab_no" class="form-control" autocomplete="off" onkeyup="this.value = this.value.toUpperCase();" name="lab_no" required >
                            </div>

                            <div class="mb-3 col-md-12 d-none">
                                <label for="date_recieved" class="form-label">Date recieved<span class="text-danger">*</span></label>
                                <input type="datetime-local" id="date_recieved" class="form-control" name="date_recieved">
                            </div>
                                <button type="submit" class="btn btn-success float-end">Update</button>
                        </div>
                    </form>
            </div>
            </div>
        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->
