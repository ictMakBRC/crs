<!-- Footer Start -->
<div class="modal fade" id="resultimport" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Upload File
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div> <!-- end modal header -->
            <form action="{{ url('patient/results/import') }}" method="POST" name="importform"
            enctype="multipart/form-data"  onsubmit="return checkfile()">
            <div class="modal-body">
                @csrf
                <div class="row">
                    <div class="col-md-12">

                        <input type="hidden" name="batch" value="{{rand(400,9999).time()}}">
                        <div class="mb-3">
                            <label  class="form-label">Upload CVS File</label>
                            <input type="file" name="file" id="image-uploadify" required class="form-control" onchange="checkfile(this);">
                        </div>
                    </div> <!-- end col -->
                </div>
                <script type="text/javascript" language="javascript">
                    function checkfile(sender) {
                        var validExts = new Array(".xlsx", ".xls", ".csv");
                        var fileExt = sender.value;
                        fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
                        if (validExts.indexOf(fileExt) < 0) {

                            swal('Error', "Invalid file selected, valid files are of " +
                                validExts.toString() + " types.", 'warning');
                            document.getElementById('image-uploadify').value= null;
                            return false;
                        }
                        else return true;
                    }
                </script>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div> <!-- end modal content-->
</div> <!-- end modal dialog-->
</div> <!-- end modal-->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center">
                <script>document.write(new Date().getFullYear())</script> © Covid-19 Results Management System (CRS)
            </div>

        </div>
    </div>
</footer>
<!-- end Footer -->