
                            <div class="mb-3 col-md-3">
                                <label for="priority" class="form-label">Priority<span class="text-danger">*</span></label>
                                <select class="form-select" id="priority" name="priority" required>
                                    <option value="" selected>Select</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Emergency">Emergency</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="who_tested" class="form-label">Test reason<span class="text-danger">*</span></label>
                                <select class="form-select" id="who_tested" name="who_tested" required>
                                    <option value="" selected>Select</option>
                                    <option value="Traveller">Traveller</option>
                                    <option value="Routine">Routine</option>
                                    <option value="Research">Research</option>
                                    <option value="Health worker">Health worker</option>
                                    <option value="Contact">Contact</option>
                                    <option value="Case">Case</option>
                                    <option value="PoE">PoE</option>
                                    <option value="Postmortem">Postmortem</option>
                                    <option value="Alert">Alert</option>
                                    <option value="Alert">EQA</option>
                                </select>
                            </div>
                           <div class="mb-3 col-md-3">
                                <label for="test_reason" class="form-label">Who is testing<span class="text-danger">*</span></label>
                                <select class="form-select" id="test_reason" name="test_reason" required>
                                    <option value="" selected>Select</option>
                                    <option value="Travel">Travel</option>
                                    <option value="Routine Exposure">Routine Exposure</option>
                                    <option value="Quarantine">Quarantine</option>
                                    <option value="Confirmatory">Confirmatory</option>
                                    <option value="Voluntary">Voluntary</option>
                                    <option value="Event Based">Event Based</option>
                                    <option value="School">School</option>      
                                    <option value="VIP">VIP</option>
                                     <option value="Alert">EQA</option>
                                    <option value="Research participant">Research participant</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                              <div class="mb-3 col-md-3 d-none">
                                <label for="patient_photo" class="form-label">Patient image<span class="text-danger">*</span></label>
                                <input type='file' accept="image/*" disabled capture="environment"class="dropify form-control" required id="patient_photo" name="patient_photo" />
                            </div>
                            <div class="mb-3 col-md-3 d-none">
                                <label for="tube_photo" class="form-label">Test Tube Image<span class="text-danger">*</span></label>
                                <input type='file' disabled accept="image/*" capture="environment"class="dropify form-control" required name="tube_photo" id="tube_photo" />
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="patient_id" class="form-label">Patient ID</label>
                                <input type="text" id="patient_id" class="form-control text-uppercase" onkeyup="this.value = this.value.toUpperCase();" name="patient_id"  value="{{ old('patient_id', '') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="surname" class="form-label">Surname<span class="text-danger">*</span></label>
                                <input type="text" id="surname" class="form-control text-uppercase" onkeyup="this.value = this.value.toUpperCase();" name="surname" required value="{{ old('surname', '') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="given_name" class="form-label">Given Name<span class="text-danger">*</span></label>
                                <input type="text" id="given_name" class="form-control text-uppercase" onkeyup="this.value = this.value.toUpperCase();" name="given_name" required value="{{ old('given_name', '') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="other_name" class="form-label">Other Name</label>
                                <input type="text" id="other_name" class="form-control text-uppercase" onkeyup="this.value = this.value.toUpperCase();" name="other_name" value="{{ old('other_name', '') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="gender" class="form-label">Gender<span class="text-danger">*</span></label>
                                <select class="form-select myselect" id="gender" name="gender" required>
                                    <option value="" selected>Select</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>

                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="dob" class="form-label">DOB</label>
                                <input type="date" id="dob" class="form-control" name="dob" value="{{ old('dob', '') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="age" class="form-label">Age</label>
                                <input type="number" id="age" class="form-control" name="age" value="{{ old('age', '') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="doc_type" class="form-label">Document Type</label>
                                <select class="form-select" id="doc_type" name="doc_type">
                                    <option value="">Select</option>
                                    <option value="Passport">Passport</option>
                                    <option value="National ID">National ID</option>
                                    <option value="Other">Other</option>

                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="doc_no" class="form-label">Document No</label>
                                <input type="text" id="doc_no" class="form-control text-uppercase" onkeyup="this.value = this.value.toUpperCase();" name="doc_no" value="{{ old('doc_no', '') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="patient_email" class="form-label">Email</label>
                                <input type="email" id="patient_email" class="form-control" name="patient_email" value="{{ old('patient_email', '') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="phone_number" class="form-label">Contact<span class="text-danger">*</span></label>
                                <input type="tel" id="phone_number" class="form-control" name="phone_number" value="{{ old('phone_number', '') }}" pattern="[1-9]{1,3}[0-9]{1,4}[0-9]{6}" minlength="12" required placeholder="like 256715660055">
                            </div>
                           
                            <div class="mb-3 col-md-3">
                                <label for="nok_name" class="form-label">Next of Kin</label>
                                <input type="text" id="nok_name" class="form-control text-uppercase" onkeyup="this.value = this.value.toUpperCase();" name="nok_name" value="{{ old('nok_name', '') }}">
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="nationality" class="form-label">Nationality<span class="text-danger">*</span></label>
                                <select class="form-control myselect"id="nationality"  name="nationality" required>
                                    <option value="">Select</option>
                                    @include('layouts.nationality')
                                </select>
                            </div>
                            
                            <div class="mb-3 col-md-3">
                                <label for="patient_district" class="form-label">Patient district<span class="text-danger">*</span></label>
                                <select name="patient_district" id="patient_district" class="form-select myselect" required>
                                  @include('layouts.districts')
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="swab_district" class="form-label">Swab district<span class="text-danger">*</span></label>
                                <select name="swab_district" id="swab_district" class="form-select myselect" required>
                                  @include('layouts.districts')
                                </select>
                               
                            </div>
                            <div class="mb-3 col-md-3">
                                    @php
                                    $startTime = date("Y-m-d H:i:s");
                                    $maxCollect = date('Y-m-d H:i:s', strtotime('+20 minutes', strtotime($startTime)));
                                    @endphp
                                <label for="collection_date" class="form-label">Collection Date(Time in 24hrs)<span class="text-danger">*</span></label>
                                <input type="datetime-local" id="collection_date" class="form-control" name="collection_date" max="{{ date('Y-m-d\TH:i:s', strtotime($maxCollect))}}" required value="{{ old('collection_date', '') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="collected_by" class="form-label">Collected by<span class="text-danger">*</span></label>
                                <select class="form-select myselect" id="collected_by" name="collected_by" required>
                                    <option value="">Select Swabber</option>
                                    @if(Route::is('patients.create'))
                                    @if(count($swabber)>0)
                                    @foreach($swabber as $swabbe)
                                    <option value="{{ $swabbe->id }}">{{ $swabbe->full_name}}</option>
                                    @endforeach
                                    @endif
                                    @endif
                                </select>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="sample_type" class="form-label">Sample type<span class="text-danger">*</span></label>
                                <select name="sample_type" id="sample_type" class="form-select" style="width: 100%;" required>
                                    <option value="" selected disabled>Select</option>
                                    <option value="Nasopharyngeal">Nasopharyngeal</option>
                                    <option value="Oropharyngeal">Oropharyngeal</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-3">
                                <div class="form-group">
                                  <label class="form-label">Ever Tested Positive?<font color="red"><b>*</b></font></label>
                                  <select name="ever_been_positive" id="ever_been_positive" class="form-select" style="width: 100%;" required>
                                  <option value="" selected disabled>Select</option>
                                  <option value="Yes">Yes</option>
                                  <option value="No">No</option>
                                  </select>
                                </div>
                                <!-- /.form-group -->
                              </div>
                              <div class="mb-3 col-md-3">
                                <div class="form-group">
                                  <label class="form-label">Ever been vaccinated?<font color="red"><b>*</b></font></label>
                                  <select name="ever_been_vaccinated" id="ever_been_vaccinated" onchange="vaccinated()" class="form-select" style="width: 100%;" required>
                                    <option value="" selected disabled>Select</option>
                                  <option value="Yes">Yes</option>
                                  <option value="No">No</option>
                                  </select>
                                </div>
                                <!-- /.form-group -->
                              </div>

                              <div class="mb-3 col-md-3 " style="display: none" id="v1">
                                <div class="form-group">
                                  <label class="form-label">If vaccinated, vaccine doze 1<font color="red"><b>*</b></font></label>
                                  <select name="vaccine_dose1" id="vaccine_dose1" class="form-control myselect" style="width: 100%;" required >
                                  <option value="" selected disabled>Select</option>
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
                                  <label class="form-label">vaccine doze 2</label>
                                  <select name="vaccine_dose2" id="vaccine_dose2" class="form-control myselect" style="width: 100%;"  >
                                    <option value="" selected >Select</option>
                                    <option value="" >None</option>
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
                                  <label class="form-label">vaccine doze 3</label>
                                  <select name="vaccine_dose3" id="vaccine_dose3" class="form-control myselect" style="width: 100%;" >
                                    <option value="" selected disabled>Select</option>
                                    <option value="" >None</option>
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
    <script type="text/javascript">
        function vaccinated()
        {
         var x = document.getElementById('ever_been_vaccinated').value;

        if(x  == 'No')
        {
        document.getElementById("vaccine_dose1").removeAttribute("required");
        document.getElementById("vaccine_dose2").removeAttribute("required");
        document.getElementById("vaccine_dose3").removeAttribute("required");

         $("#vaccine_dose1").append('<option selected value=""></option>');
         $("#vaccine_dose2").append('<option selected value=""></option>');
         $("#vaccine_dose3").append('<option selected value=""></option>');

        document.getElementById("v1").style.display = "none";
        document.getElementById("v2").style.display = "none";
        document.getElementById("v3").style.display = "none";
        }
       else if(x  == 'Yes')
        {
        document.getElementById("vaccine_dose1").setAttribute("required", "required");
        // document.getElementById("vaccine_dose2").setAttribute("required", "required");
        // document.getElementById("vaccine_dose3").setAttribute("required", "required");
        document.getElementById("vaccine_dose2").removeAttribute("required");
        document.getElementById("vaccine_dose3").removeAttribute("required");



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
