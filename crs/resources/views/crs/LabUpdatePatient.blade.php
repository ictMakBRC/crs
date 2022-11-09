
<x-crs-layout>
    @section('title', 'Patient')
    <!-- end row-->
    <div class="row mx-auto">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @foreach ($values as $key=>$value)
                    <div id="progressbarwizard">
                        <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                            <li class="nav-item">
                                <a href="#account-2" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2 active">
                                    <i class="uil-medical-square"></i>
                                    <span class="d-none d-sm-inline">Patient Profile</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#details" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                    <i class="uil-book-medical me-1"></i>
                                    <span class="d-none d-sm-inline">Accessioning</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a disableds href="#finish-2" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                    <i class="uil-monitor-heart-rate me-1"></i>
                                    <span class="d-none d-sm-inline">Results</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content b-0 mb-0">
                            <div id="bar" class="progress mb-3" style="height: 7px;">
                                <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success"></div>
                            </div>
                            @if(Auth::user()->hasRole(['DataAdmin','DataClerkLab']))
                            <div class="tab-pane active" id="account-2">
                                <form method="POST" action="{{url('patient/lab/update/'.$value->wid)}}" >
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-md-3">
                                            <label for="patient_id" class="form-label">Patient id<span class="text-danger">*</span></label>
                                            <input type="text" id="patient_id" class="form-control" name="patient_id" required value="{{ $value->patient_id }}">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="test_reason" class="form-label">Test reason <span class="text-danger">*</span></label>
                                            <select class="form-control myselect" id="test_reason" name="test_reason" required>
                                                <option value="{{ $value->test_reason }}">{{ $value->test_reason }}</option>
                                                <option value="Travel">Travel</option>
                                                <option value="Routine">Routine</option>

                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="surname" class="form-label">Surname<span class="text-danger">*</span></label>
                                            <input type="text" id="surname" class="form-control" name="surname" required value="{{ $value->surname }}">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="given_name" class="form-label">Given Name</label>
                                            <input type="text" id="given_name" class="form-control" name="given_name" value="{{ $value->given_name }}">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="other_name" class="form-label">Other Name</label>
                                            <input type="text" id="other_name" class="form-control" name="other_name" value="{{ $value->other_name }}">
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label for="dob" class="form-label">DOB</label>
                                            <input type="date" id="dob" class="form-control" name="dob" value="{{ $value->dob }}">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="age" class="form-label">Age</label>
                                            <input type="text" id="age" class="form-control" name="age" value="{{ $value->age }}">
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label for="patient_email" class="form-label">Email<span class="text-danger">*</span></label>
                                            <input type="email" id="patient_email" class="form-control" name="patient_email" required value="{{ $value->patient_email }}">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="phone_number" class="form-label">Contact<span class="text-danger">*</span></label>
                                            <input type="text" id="phone_number" class="form-control" name="phone_number" required value="{{ $value->phone_number }}">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="gender" class="form-label">Gender<span class="text-danger">*</span></label>
                                            <select class="form-control myselect" id="gender" name="gender" required>
                                                <option value="{{ $value->gender }}">{{ $value->gender }}</option>
                                                <option value="Male">Male</option>
                                                <option value="Femal">Female</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="nok_name" class="form-label">Next of Kin<span class="text-danger">*</span></label>
                                            <input type="text" id="nok_name" class="form-control" name="nok_name" required value="{{ $value->nok_name }}">
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label for="nationality" class="form-label">Nationality<span class="text-danger">*</span></label>
                                            <select class="form-control myselect"id="nationality"  name="nationality" required>
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
                                            <input type="text" id="doc_no" class="form-control" required name="doc_no" value="{{ $value->doc_no}}">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="patient_district" class="form-label">Patient district<span class="text-danger">*</span></label>
                                            <input type="text" id="patient_district" class="form-control" name="patient_district" required value="{{ $value->patient_district }}">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="swab_district" class="form-label">Swab district<span class="text-danger">*</span></label>
                                            <input type="text" id="swab_district" class="form-control" name="swab_district" required value="{{ $value->swab_district }}">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="collection_date" class="form-label">Collection Date<span class="text-danger">*</span></label>
                                            <input type="datetime-local" id="collection_date" class="form-control" name="collection_date" required value="{{ date('Y-m-d\TH:i:s', strtotime($value->collection_date))}}">
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
                                                <option value="{{ $value->sample_type }}" selected>{{$value->sample_type}}</option>
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
                                        <div class="mb-3 col-md-3 " style="display: {{$disp}}" id="v1">
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
                                        <div class="mb-3 col-md-3 " style="display: {{$disp}}" id="v2">
                                            <div class="form-group">
                                                <label  class="form-label">vaccine doze 2<font color="red"><b>*</b></font></label>
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
                                        <div class="mb-3 col-md-3 " style="display: {{$disp}}" id="v3">
                                            <div class="form-group">
                                                <label  class="form-label">vaccine doze 3<font color="red"><b>*</b></font></label>
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
                                        <div class="mb-3 col-md-3">
                                            <label for="sample_type" class="form-label">Receipt no<span class="text-danger">*</span></label>
                                            <input type="text" id="receipt_no" class="form-control" name="receipt_no" required value="{{ $value->receipt_no }}">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label  class="form-label">Test arm<font color="red"><b>*</b></font></label>
                                            <select name="test_arm" id="test_arm"  class="form-control myselect" style="width: 100%;" required>
                                                @if ($value->test_arm=="")
                                                <option value="">Select Arm</option>
                                                @else
                                                <option selected value="{{ $value->test_arm }}" >{{ $value->test_arm }}</option>
                                                @endif
                                                <option value="Clinical">Clinical</option>
                                                <option value="Survey">Survey</option>
                                                <option value="Studay">Studay</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="facility_id" class="form-label">Facility</label>
                                            <select class="form-control myselect" id="facility_id" name="facility_id" required>
                                                @if ($value->parent_id!=null)
                                                <option value="{{ $value->facility_id }}" selected>{{ $value->facility_name.' (CPHL)'}}</option>
                                                @else
                                                <option value="{{ $value->facility_id }}" selected>{{ $value->facility_name}}</option>
                                                @endif
                                                @if(count($facilities)>0)
                                                @foreach($facilities as $facility)
                                                @if ($facility->parent_id!=null)
                                                <option value="{{ $facility->id }}">{{ $facility->facility_name.' (CPHL)'}}</option>
                                                @else
                                                <option value="{{ $facility->id }}">{{ $facility->facility_name}}</option>
                                                @endif
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-success float-end">Validate Patient</button>
                                    </div> <!-- end row -->
                                </form>
                            </div>
                            @endif
                            @if(Auth::user()->hasRole(['DataAdmin','LabTech']))
                            <div class="tab-pane" id="details">
                                <div class="card ">
                                    <div class="card-body">
                                        <form method="POST" action="{{url('patient/lab/number/'.$value->wid)}}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label for="lab_no" class="form-label">lab no<span class="text-danger">*</span></label>
                                                    <input type="text" id="lab_no" class="form-control" name="lab_no" required value="{{ $value->lab_no }}">
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label for="date_recieved" class="form-label">Date recieved<span class="text-danger">*</span></label>
                                                    <input type="datetime-local" id="date_recieved" class="form-control" name="date_recieved" required value="{{ date('Y-m-d\TH:i:s', strtotime($value->date_recieved))}}">
                                                </div>
                                                <button type="submit" class="btn btn-success float-end">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(Auth::user()->hasRole(['DataAdmin','ResultsQC']))
                            <div class="tab-pane" id="finish-2">
                                <div class="row">
                                    <form method="POST" action="{{url('patient/lab/result/update/'.$value->wid)}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-12">
                                            <div class="card ">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="mb-3 col-md-3">
                                                            <label for="worksheet_no" class="form-label">Worksheet no<span class="text-danger">*</span></label>
                                                            <input type="text" id="worksheet_no" class="form-control" name="worksheet_no" required value="{{ $value->worksheet_no}}">
                                                        </div>

                                                        <div class="mb-3 col-md-3">
                                                            <label for="test_type" class="form-label">Test type<span class="text-danger">*</span></label>

                                                            <select  name="test_type" class="form-control myselect" id="test_type" required onchange="myresult()">
                                                                @if ($value->test_type=="")
                                                                <option value="">Select test</option>
                                                                @else
                                                                <option selected value="{{ $value->test_type }}" >{{ $value->test_type }}</option>
                                                                @endif
                                                                <option value="RT qPCR">RT qPCR</option>
                                                                <option value="Antigen">Antigen</option>
                                                                <option value="Antibody">Antibody</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <label for="target1" class="form-label">Target 1<span class="text-danger">*</span></label>
                                                            <select name="target1" class="form-control myselect" id="target1">
                                                                @if ($value->target1=="")
                                                                <option value="">Select</option>
                                                                @else
                                                                <option selected value="{{ $value->target1 }}" >{{ $value->target1 }}</option>
                                                                @endif
                                                                <option value="E">E</option>
                                                                <option value="N1">N1</option>
                                                                <option value="N2">N2</option>
                                                                <option value="N">N</option>
                                                                <option value="ORF">ORF</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <label for="ct_value" class="form-label">CT value 1<span class="text-danger">*</span></label>
                                                            <input type="text" id="ct_value" class="form-control" name="ct_value" required value="{{ $value->ct_value }}">
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <label for="target2" class="form-label">Target 2</label>
                                                            <select name="target2" class="form-control myselect" id="target2">
                                                                @if ($value->target2=="")
                                                                <option value="">Select</option>
                                                                @else
                                                                <option selected value="{{ $value->target2 }}" >{{ $value->target2 }}</option>
                                                                @endif
                                                                <option value="E">E</option>
                                                                <option value="N1">N1</option>
                                                                <option value="N2">N2</option>
                                                                <option value="N">N</option>
                                                                <option value="ORF">ORF</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <label for="ct_value" class="form-label">CT value 2<span class="text-danger">*</span></label>
                                                            <input type="text" id="ct_value2" class="form-control" name="ct_value2" required value="{{ $value->ct_value2 }}">
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <label for="target3" class="form-label">Target 3</label>
                                                            <select name="target3" class="form-control myselect" id="target3">
                                                                @if ($value->target3=="")
                                                                <option value="">Select</option>
                                                                @else
                                                                <option selected value="{{ $value->target3 }}" >{{ $value->target3 }}</option>
                                                                @endif
                                                                <option value="E">E</option>
                                                                <option value="N1">N1</option>
                                                                <option value="N2">N2</option>
                                                                <option value="N">N</option>
                                                                <option value="ORF">ORF</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <label for="ct_value" class="form-label">CT value3<span class="text-danger">*</span></label>
                                                            <input type="text" id="ct_value2" class="form-control" name="ct_value3" required value="{{ $value->ct_value3 }}">
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <label for="target2" class="form-label">Target 4<span class="text-danger">*</span></label>
                                                            <select name="target2" class="form-control myselect" id="target2">
                                                                @if ($value->target4=="")
                                                                <option value="">Select</option>
                                                                @else
                                                                <option selected value="{{ $value->target4 }}" >{{ $value->target4 }}</option>
                                                                @endif
                                                                <option value="E">E</option>
                                                                <option value="N1">N1</option>
                                                                <option value="N2">N2</option>
                                                                <option value="N">N</option>
                                                                <option value="ORF">ORF</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <label for="ct_value" class="form-label">CT value 4<span class="text-danger">*</span></label>
                                                            <input type="text" id="ct_value4" class="form-control" name="ct_value4" required value="{{ $value->ct_value4 }}">
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <label class="form-label">Platform<font color="red"><b>*</b></font></label>
                                                            <select name="platform" id="platform" class="form-control myselect" style="width: 100%;" required>
                                                                @if ($value->platform=="")
                                                                <option value="">Select platform</option>
                                                                @else
                                                                <option selected value="{{ $value->platform }}" >{{ $value->platform }}</option>
                                                                @endif
                                                                @if(count($platforms)>0)
                                                                @foreach($platforms as $platform)
                                                                <option value="{{ $platform->id }}">{{ $platform->platform_name}}</option>
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <label for="test_kit" class="form-label">Test kit<span class="text-danger">*</span></label>
                                                            <select id="test_kit"  name="test_kit" required class="form-control myselect" style="width: 100%;" required>
                                                                @if ($value->test_kit=="")
                                                                <option value="">Select a kit</option>
                                                                @else
                                                                <option selected value="{{ $value->test_kit }}" >{{ $value->kit_name }}</option>
                                                                @endif
                                                                @if(count($kits)>0)
                                                                @foreach($kits as $kit)
                                                                <option value="{{ $kit->id }}">{{ $kit->kit_name}}</option>
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div class="mb-3 col-md-2">
                                                            <label for="igg_result" class="form-label">IGG result</label>
                                                            <input type="text" id="igg_result" class="form-control" name="igg_result"  value="{{  $value->igg_result }}">
                                                        </div>
                                                        <div class="mb-3 col-md-2">
                                                            <label for="igm_result" class="form-label">IGM resul</label>
                                                            <input type="text" id="igm_result" class="form-control" name="igm_result"  value="{{  $value->igm_result }}">
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <label for="tat" class="form-label">Result<span class="text-danger">*</span></label>
                                                            <select name="result" id="result" class="form-control myselect" style="width: 100%;" required>
                                                                @if ($value->result=="")
                                                                <option value="">Select Result</option>
                                                                @else
                                                                <option selected value="{{ $value->result }}" >{{ $value->result }}</option>
                                                                @endif
                                                                <option value="Negative">Negative</option>
                                                                <option value="Positive">Positive</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3 col-md-5">
                                                            <label for="comment" class="form-label">Comment<span class="text-danger">*</span></label>

                                                            <textarea id="comment" class="form-control" name="comment">{{  $value->comment }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                               
                                                <button type="submit" class="btn btn-success float-end">Update results</button>
                                              

                                            </div>
                                        </div> <!-- end col -->
                                    </form>
                                </div> <!-- end row -->
                            </div>
                            @endif
                            <ul class="list-inline mb-0 wizard mt-3">
                                <li class="previous list-inline-item">
                                    <a href="#" class="btn btn-info">Previous</a>
                                </li>
                                <li class="next list-inline-item float-end">
                                    <a href="#" class="btn btn-info">Next</a>
                                </li>
                            </ul>
                        </div> <!-- tab-content -->
                    </div> <!-- end #progressbarwizard-->
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

    <script type="text/javascript">
        function myresult()
        {
            var x = document.getElementById('test_type').value;

            if(x  == 'Antigen' || x  == 'Antibody')
            {


                document.getElementById("igg_result").setAttribute("required", "required");
                document.getElementById("igm_result").setAttribute("required", "required");
                document.getElementById("igg_result").removeAttribute("readonly");
                document.getElementById("igm_result").removeAttribute("readonly");
                document.getElementById("igg_result").value='';
                document.getElementById("igm_result").value='';
                $("#result").append('<option selected value="NA">NA</option>');
                document.getElementById("result").setAttribute("readonly", "readonly");
                document.getElementById("ct_value").value='N/A';
                document.getElementById("ct_value").setAttribute("readonly", "readonly");

            }
            else
            {


                document.getElementById("igg_result").removeAttribute("required");
                document.getElementById("igm_result").removeAttribute("required");
                document.getElementById("igg_result").value='N/A';
                document.getElementById("igm_result").value='N/A';
                document.getElementById("igg_result").setAttribute("readonly", "readonly");
                document.getElementById("igm_result").setAttribute("readonly", "readonly");
                document.getElementById("result").removeAttribute("readonly");
                document.getElementById("result").value='';
                document.getElementById("ct_value").removeAttribute("readonly");
                document.getElementById("ct_value").value='';

            }

        }
    </script>

</x-crs-layout>
