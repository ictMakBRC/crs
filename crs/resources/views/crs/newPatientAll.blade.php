@section('title', 'Register Patient')
<x-crs-layout>
    <!-- end row-->
    <div class="row mx-auto">
        <div class="col-12">
            <div class="card">
                {{-- <div class="card-header pt-0">

                </div> --}}
                <div class="card-body">

                    <form method="POST" action="{{route('patients.store')}}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label for="test_reason" class="form-label">Test reason <span class="text-danger">*</span></label>
                                <select class="form-select" id="test_reason" name="test_reason" required>
                                    <option value="Travel">Travel</option>
                                    <option value="Routine">Routine</option>

                                </select>
                            </div>

                              <div class="mb-3 col-md-3">
                                <label for="patient_photo" class="form-label">Patient image<span class="text-danger">*</span></label>
                                <input type='file' accept="image/*" capture="environment"class="dropify form-control" required id="patient_photo" name="patient_photo" />
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="tube_photo" class="form-label">Test tube Image<span class="text-danger">*</span></label>
                                <input type='file' accept="image/*" capture="environment"class="dropify form-control" required name="tube_photo" id="tube_photo" />
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="patient_id" class="form-label">Patient id<span class="text-danger">*</span></label>
                                <input type="text" id="patient_id" class="form-control" name="patient_id" required value="{{ old('patient_id', '') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="surname" class="form-label">Surname<span class="text-danger">*</span></label>
                                <input type="text" id="surname" class="form-control" name="surname" required value="{{ old('surname', '') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="given_name" class="form-label">Given Name</label>
                                <input type="text" id="given_name" class="form-control" name="given_name" value="{{ old('given_name', '') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="other_name" class="form-label">Other Name</label>
                                <input type="text" id="other_name" class="form-control" name="other_name" value="{{ old('other_name', '') }}">
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="dob" class="form-label">DOD</label>
                                <input type="date" id="dob" class="form-control" name="dob" value="{{ old('dob', '') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="age" class="form-label">Age</label>
                                <input type="text" id="age" class="form-control" name="age" value="{{ old('age', '') }}">
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="patient_email" class="form-label">Email<span class="text-danger">*</span></label>
                                <input type="email" id="patient_email" class="form-control" name="patient_email" required value="{{ old('patient_email', '') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="phone_number" class="form-label">Contact<span class="text-danger">*</span></label>
                                <input type="text" id="phone_number" class="form-control" name="phone_number" required value="{{ old('phone_number', '') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="gender" class="form-label">Gender<span class="text-danger">*</span></label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>

                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="nok_name" class="form-label">Next of Kin<span class="text-danger">*</span></label>
                                <input type="text" id="nok_name" class="form-control" name="nok_name" required value="{{ old('nok_name', '') }}">
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="nationality" class="form-label">Nationality<span class="text-danger">*</span></label>
                                <input type="text" id="nationality" class="form-control" name="nationality" required value="{{ old('nationality', '') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="patient_district" class="form-label">Patient district<span class="text-danger">*</span></label>
                                <input type="text" id="patient_district" class="form-control" name="patient_district" required value="{{ old('patient_district', '') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="swab_district" class="form-label">Swab district<span class="text-danger">*</span></label>
                                <input type="text" id="swab_district" class="form-control" name="swab_district" required value="{{ old('swab_district', '') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="collection_date" class="form-label">Collection Date<span class="text-danger">*</span></label>
                                <input type="date" id="collection_date" class="form-control" name="collection_date" required value="{{ old('collection_date', '') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="collected_by" class="form-label">Collected by<span class="text-danger">*</span></label>
                                <input type="text" id="collected_by" class="form-control" name="collected_by" required value="{{ old('collected_by', '') }}">
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="sample_type" class="form-label">Sample type<span class="text-danger">*</span></label>
                                <input type="text" id="sample_type" class="form-control" name="sample_type" required value="{{ old('sample_type', '') }}">
                            </div>

                            <div class="mb-3 col-md-3">
                                <div class="form-group">
                                  <label>Ever confirmed with COVID-19?<font color="red"><b>*</b></font></label>
                                  <select name="cov19Positivity" id="cov19Positivity" class="form-control myselect" style="width: 100%;" required>
                                  <option value="" selected disabled>Select option</option>
                                  <option value="Yes">Yes</option>
                                  <option value="No">No</option>
                                  </select>
                                </div>
                                <!-- /.form-group -->
                              </div>
                              <div class="mb-3 col-md-3">
                                <div class="form-group">
                                  <label>Ever been vaccinated?<font color="red"><b>*</b></font></label>
                                  <select name="vaccinationState" id="vaccinationState" onchange="vaccinated()" class="form-control myselect" style="width: 100%;" required>
                                    <option value="" selected disabled>Select option</option>
                                  <option value="Yes">Yes</option>
                                  <option value="No">No</option>
                                  </select>
                                </div>
                                <!-- /.form-group -->
                              </div>

                              <div class="mb-3 col-md-3 " style="display: none" id="v1">
                                <div class="form-group">
                                  <label>If vaccinated, vaccine doze 1<font color="red"><b>*</b></font></label>
                                  <select name="vaccine_dose1" id="vaccine_dose1" class="form-control myselect" style="width: 100%;" required readonly>
                                    <option value="" selected >N/A</option>
                                  <option value="AstraZeneca">AstraZeneca</option>
                                  <option value="Pfizer">Pfizer</option>
                                  <option value="Moderna">Moderna</option>
                                  <option value="Sinopham">Sinopham</option>
                                  <option value="Sinovac">Sinovac</option>
                                  <option  value="Johnson & Johnson">Johnson & Johnson</option>
                                  </select>
                                </div>
                                <!-- /.form-group -->
                              </div>

                              <div class="mb-3 col-md-3 " style="display: none" id="v2">
                                <div class="form-group">
                                  <label>vaccine doze 2<font color="red"><b>*</b></font></label>
                                  <select name="vaccine_dose2" id="vaccine_dose2" class="form-control myselect" style="width: 100%;" required readonly>
                                    <option value="" selected >N/A</option>
                                    <option value="AstraZeneca">AstraZeneca</option>
                                    <option value="Pfizer">Pfizer</option>
                                    <option value="Moderna">Moderna</option>
                                    <option value="Sinopham">Sinopham</option>
                                    <option value="Sinovac">Sinovac</option>
                                    <option  value="Johnson & Johnson">Johnson & Johnson</option>
                                  </select>
                                </div>
                                <!-- /.form-group -->
                              </div>

                              <div class="mb-3 col-md-3 " style="display: none" id="v3">
                                <div class="form-group">
                                  <label>vaccine doze 3<font color="red"><b>*</b></font></label>
                                  <select name="vaccine_dose3" id="vaccine_dose3" class="form-control myselect" style="width: 100%;" required readonly>
                                    <option value="" selected >N/A</option>
                                    <option value="AstraZeneca">AstraZeneca</option>
                                    <option value="Pfizer">Pfizer</option>
                                    <option value="Moderna">Moderna</option>
                                    <option value="Sinopham">Sinopham</option>
                                    <option value="Sinovac">Sinovac</option>
                                    <option  value="Johnson & Johnson">Johnson & Johnson</option>
                                  </select>
                                </div>
                                <!-- /.form-group -->
                              </div>

                            </div>
                              <!-- end row-->


                            <!-- end row-->
                            <div class="d-grid mb-0 text-center">
                                <button class="btn btn-primary" type="submit"  id="submitBtn"> Add Patient</button>
                            </div>
                    </form>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <script type="text/javascript">
        function vaccinated()
        {
         var x = document.getElementById('vaccinationState').value;

        if(x  == 'No')
        {
        document.getElementById("vaccine_dose1").removeAttribute("required");
        document.getElementById("vaccine_dose2").removeAttribute("required");
        document.getElementById("vaccine_dose3").removeAttribute("required");

         $("#vaccine_dose1").append('<option selected value="N/A">N/A</option>');
         $("#vaccine_dose2").append('<option selected value="N/A">N/A</option>');
         $("#vaccine_dose3").append('<option selected value="N/A">N/A</option>');

        document.getElementById("v1").style.display = "none";
        document.getElementById("v2").style.display = "none";
        document.getElementById("v3").style.display = "none";
        }
       else if(x  == 'Yes')
        {
        document.getElementById("vaccine_dose1").setAttribute("required", "required");
        document.getElementById("vaccine_dose2").setAttribute("required", "required");
        document.getElementById("vaccine_dose3").setAttribute("required", "required");
        document.getElementById("vaccine_dose1").removeAttribute("readonly");
        document.getElementById("vaccine_dose2").removeAttribute("readonly");
        document.getElementById("vaccine_dose3").removeAttribute("readonly");


        document.getElementById("v1").style.display = "block";
        document.getElementById("v2").style.display = "block";
        document.getElementById("v3").style.display = "block";
        }
        else
        {
          document.getElementById("vaccine_dose1").setAttribute("required", "required");
          $("#vaccine_dose1").empty();
         $("#vaccine_dose1").append('<option value="NA">NA</option>');
        }
        }
</script>

</x-crs-layout>
