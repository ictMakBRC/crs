
<x-crs-layout>
    @section('title', 'Edit Patient')
    <!-- end row-->
    <div class="row mx-auto">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">

                </div>
                <div class="card-body">
                    @foreach ($values as $key=>$value)
                    <form method="POST" action="{{route('patients.update',$value->wid)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="entry_type" value="External">
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label for="who_tested" class="form-label">Who Tested<span class="text-danger">*</span></label>
                                <select class="form-select" id="who_tested" name="who_tested" required>
                                    @if ($value->who_tested =="")
                                    <option value=" ">Select Option</option>
                                    @else
                                    <option value="{{ $value->who_tested }}">{{ $value->who_tested }}</option>
                                    @endif
                                     <option value="Traveller">Traveller</option>
                                    <option value="Routine">Routine</option>
                                    <option value="Research">Research</option>
                                    <option value="Health worker">Health worker</option>
                                    <option value="Contact">Contact</option>
                                    <option value="Case">Case</option>
                                    <option value="PoE">PoE</option>
                                    <option value="Postmortem">Postmortem</option>
                                    <option value="Alert">Alert</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="test_reason" class="form-label">Test reason <span class="text-danger">*</span></label>
                                <select class="form-select" id="test_reason" name="test_reason" required>
                                    <option value="{{ $value->test_reason }}">{{ $value->test_reason }}</option>
                                     <option value="Travel">Travel</option>
                                    <option value="Routine Exposure">Routine Exposure</option>
                                    <option value="Quarantine">Quarantine</option>
                                    <option value="Confirmatory">Confirmatory</option>
                                    <option value="Voluntary">Voluntary</option>
                                    <option value="Event Based">Event Based</option>
                                    <option value="School">School</option>
                                    <option value="VIP">VIP</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                             <div class="mb-3 col-md-3">
                            <label for="priority" class="form-label">Priority<span class="text-danger">*</span></label>
                                <select class="form-select" id="priority" name="priority" required>
                                     @if ($value->priority =="")
                                    <option value=" ">Select Option</option>
                                    @else
                                    <option value="{{ $value->priority }}">{{ $value->priority }}</option>
                                    @endif
                                    <option value="Normal">Normal</option>
                                    <option value="Emergency">Emergency</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="patient_id" class="form-label">Patient id</label>
                                <input type="text" id="patient_id" class="form-control text-uppercase" name="patient_id" value="{{ $value->patient_id }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="surname" class="form-label">Surname<span class="text-danger">*</span></label>
                                <input type="text" id="surname" class="form-control text-uppercase" name="surname" required value="{{ $value->surname }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="given_name" class="form-label">Given Name<span class="text-danger">*</span></label>
                                <input type="text" id="given_name" class="form-control text-uppercase" name="given_name" value="{{ $value->given_name }}" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="other_name" class="form-label">Other Name</label>
                                <input type="text" id="other_name" class="form-control text-uppercase" name="other_name" value="{{ $value->other_name }}">
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="dob" class="form-label">DOB</label>
                                <input type="date" id="dob" class="form-control" name="dob" value="{{ $value->dob }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="age" class="form-label">Age<span class="text-danger">*</span></label>
                                <input type="text" id="age" class="form-control" name="age" value="{{ $value->age }}" required>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="patient_email" class="form-label">Email</label>
                                <input type="email" id="patient_email" class="form-control" name="patient_email" value="{{ $value->patient_email }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="phone_number" class="form-label">Contact<span class="text-danger">*</span></label>
                                <input type="tel" id="phone_number" class="form-control" name="phone_number" pattern="[1-9]{1,3}[0-9]{1,4}[0-9]{6}" minlength="12" value="{{ $value->phone_number }}" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="gender" class="form-label">Gender<span class="text-danger">*</span></label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="{{ $value->gender }}">{{ $value->gender }}</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>

                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="nok_name" class="form-label">Next of Kin</label>
                                <input type="text" id="nok_name" class="form-control text-uppercase" name="nok_name"  value="{{ $value->nok_name }}">
                            </div>

                            {{-- <div class="mb-3 col-md-3">
                                <label for="nationality" class="form-label">Nationality<span class="text-danger">*</span></label>
                                <select class="form-select myselect"id="nationality"  name="nationality" required>
                                    <option value="{{ $value->nationality }}">{{$value->nationality}}</option>
                                    @include('layouts.nationality')
                                </select>
                            </div> --}}
                            <div class="mb-3 col-md-3">
                                <label for="nationality" class="form-label">Nationality<span class="text-danger">*</span></label>
                                <select class="form-select myselect"id="nationality"  name="nationality" required>
                                    <option value="{{ $value->nationality }}">{{$value->nationality}}</option>
                                    @include('layouts.nationality')
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="doc_type" class="form-label">Documment Type</label>
                                <select class="form-control myselect" id="doc_type" name="doc_type" required>
                                    @if ($value->doc_type == "")
                                    <option value="">Select</option>
                                    @else
                                    <option value="{{$value->doc_type}}">{{$value->doc_type}}</option>
                                    @endif
                                    <option value="Passport">Passport</option>
                                    <option value="National ID">National ID</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="doc_no" class="form-label">Document No</label>
                                <input type="text" id="doc_no" class="form-control text-uppercase" required name="doc_no" value="{{ $value->doc_no}}">
                            </div>

                           <div class="mb-3 col-md-3">
                                    <label for="patient_district" class="form-label">Patient district<span class="text-danger">*</span></label>
                                     <select class="form-select myselect" id="patient_district" name="patient_district" required>
                                        @if ($value->patient_district =="")
                                        <option value="">Select</option>
                                        @else
                                        <option selected value="{{ $value->patient_district }}">{{ $value->patient_district}}</option>
                                        @endif
                                       @include('layouts.districts')
                                    </select>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label for="swab_district" class="form-label">Swab district<span class="text-danger">*</span></label>
                                        <select class="form-select myselect" id="swab_district" name="swab_district" required>
                                        @if ($value->swab_district =="")
                                        <option value="">Select</option>
                                        @else
                                        <option selected value="{{ $value->swab_district }}">{{ $value->swab_district}}</option>
                                        @endif
                                       @include('layouts.districts')
                                    </select>
                                </div>
                             <div class="mb-3 col-md-3">
                                <label for="collection_date" class="form-label">Collection Date<span class="text-danger">*</span></label>
                                 @php($maxCollect = date('Y-m-d H:i:s'))
                                <input type="datetime-local" id="collection_date" class="form-control" max="{{ date('Y-m-d\TH:i:s', strtotime($maxCollect))}}" name="collection_date" required value="{{ date('Y-m-d\TH:i:s', strtotime($value->collection_date))}}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="collected_by" class="form-label">Collected by<span class="text-danger">*</span></label>
                                <select class="form-select myselect" id="collected_by" name="collected_by" required>
                                    @if ($value->collected_by =="")
                                    <option value="">Select</option>
                                    @else
                                    <option value="{{ $value->collected_by }}">{{ $value->full_name }}</option>
                                    @endif
                                    @if(count($swabber)>0)
                                    @foreach($swabber as $swabbe)
                                    <option value="{{ $swabbe->id }}">{{ $swabbe->full_name}}</option>
                                    @endforeach
                                    @endif

                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="sample_type" class="form-label">Sample type<span class="text-danger">*</span></label>
                                <select name="sample_type" id="sample_type" class="form-control myselect" style="width: 100%;" required>
                                    <option value="{{$value->sample_type}}" selected>{{$value->sample_type}}</option>
                                    <option value="Nasopharyngeal">Nasopharyngeal</option>
                                    <option value="Oropharyngeal">Oropharyngeal</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <div class="form-group">
                                    <label  class="form-label">Ever confirmed with COVID-19?<font color="red"><b>*</b></font></label>
                                    <select name="ever_been_positive" id="ever_been_positive" class="form-control myselect" style="width: 100%;" required>
                                        <option value="{{$value->ever_been_positive}}" selected>{{$value->ever_been_positive}}</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <div class="mb-3 col-md-3">
                                <div class="form-group">
                                    <label  class="form-label">Ever been vaccinated?<font color="red"><b>*</b></font></label>
                                    <select name="ever_been_vaccinated" id="ever_been_vaccinated" onchange="vaccinated()" class="form-control myselect" style="width: 100%;" required>
                                        <option value="{{$value->ever_been_vaccinated}}" selected>{{$value->ever_been_vaccinated}}</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            @if ($value->ever_been_vaccinated =='No')
                            @php($disp='none')
                            @else
                            @php($disp='block')
                            @endif
                            <div class="mb-3 col-md-4 " style="display: {{$disp}}" id="v1">
                                <div class="form-group">
                                    <label  class="form-label">If vaccinated, vaccine doze 1<font color="red"><b>*</b></font></label>
                                    <select name="vaccine_dose1" id="vaccine_dose1" class="form-control myselect" style="width: 100%;" required readonly>
                                        <option value="{{$value->vaccine_dose1}}">{{$value->vaccine_dose1}}</option>
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

                            <div class="mb-3 col-md-4 " style="display: {{$disp}}" id="v2">
                                <div class="form-group">
                                    <label>vaccine doze 2<font color="red"><b>*</b></font></label>
                                    <select name="vaccine_dose2" id="vaccine_dose2" class="form-control myselect" style="width: 100%;" required readonly>
                                        <option value="{{$value->vaccine_dose2}}" selected >{{$value->vaccine_dose2}}</option>
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

                            <div class="mb-3 col-md-4 " style="display: {{$disp}}" id="v3">
                                <div class="form-group">
                                    <label>vaccine doze 3<font color="red"><b>*</b></font></label>
                                    <select name="vaccine_dose3" id="vaccine_dose3" class="form-control myselect" style="width: 100%;" required readonly>
                                        <option value="{{$value->vaccine_dose3}}">{{$value->vaccine_dose3}}</option>
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
                            <button class="btn btn-primary" type="submit"  id="submitBtn"> Update Patient</button>
                        </div>
                    </form>
                    @endforeach
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <script type="text/javascript">
        function vaccinated()
        {
            var x = document.getElementById('ever_been_vaccinated').value;

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
