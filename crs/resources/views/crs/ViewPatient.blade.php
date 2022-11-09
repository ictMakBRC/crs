@section('title', 'Register Patient')
<x-crs-layout>
    <!-- end row-->
    <div class="row mx-auto">
        <div class="col-12">
            @if(count($results)>0)
            @foreach($results as $result)
            <div class="row">
                <div class="col-md-12">
                            <div class="row">

                                <p style="text-align:center;"><img src="{{asset('images/results/mak.png')}}" alt="Makerere University Logo" width="150px" style="vertical-align:middle;"></p>
                                <h4 style="text-align:center; font-family:times;">MAKERERE UNIVERSITY COLLEGE OF HEALTH SCIENCES</h4><br>
                                <h4 style="text-align:center; font-family:times; color:red"><b>COVID-19 TEST PATIENT DETAILS</b></h5>
                                <hr style="height:2px; width:100%; color:rgb(55, 52, 52);">
            
                            </div>
                            <div class="container-fluid d-flex justify-content-between" >
                                <div class="col-lg-3 ">
                                    <h5 class="mt-1 mb-1"><b>Test Reason</b>: {{ $result->test_reason}}</h5>
                                    <h5 class="mt-1 mb-1"><b>Laboratory</b>: MBL</h5>
                                </div>
                                <div class="col-lg-3 float-right">
                                    <h5 class="font-weight-medium text-uppercase text-right ">Lab No: {{ $result->lab_no}}</h5>
                                    @if ($result->result == 'Positive')
                                    <h5>Result  <strong style='color:rgb(232, 4, 4)'>{{$result->result}}</strong></h5>
                                    @elseif ($result->result == 'Negative')
                                    <h5>Result   <strong style='color:rgb(4, 130, 25)'>{{$result->result}}</strong></h5>
                                    @endif
                                    
                                </div>
                            </div>
                            <hr>
                            <h6 class="text-primary mt-1 text-center">Patient<span> Details</span></h6>
                            <div class="container-fluid  d-flex justify-content-center w-100">
                                <div class=" w-100">
                                    <table class="table table-bordered" width="100%">
                                        <tbody>
                                            <tr class="text-left">
                                                <td ><b>Name:</b>  {{ $result->surname.' '. $result->given_name.' '. $result->other_name }}</td>
                                                <td><b>Age:</b>  {{ $result->age}}</td>
                                                <td><b>Sex:</b>   {{ $result->gender}}</td>
                                                <td ><b>D.O.B:</b> <br>  {{ $result->dob}}  </td>
                                            </tr>
                                            <tr class="text-left">
                                                <td ><b>Email:</b> <br>  {{ $result->patient_email}}  </td>
                                                <td ><b>Nationality:</b><br>   {{ $result->nationality}}  </td>
                                                <td><b>Contact:</b> <br>  {{ $result->phone_number}}</td>
                                                <td ><b>Next of Kin:</b> <br>  {{ $result->nok_name}}</td>
                                            </tr>
                                            <tr class="text-left">
                                                <td ><b>Patient District:</b> <br>   {{ $result->patient_district}}  </td>
                                                <td ><b>Swab District:</b> <br>  {{ $result->swab_district}}  </td>
                                                <td ><b>Patient ID:</b> <br>  {{ $result->patient_id}}  </td>
                                                <td ><b>Lab No. :</b> <br>  {{ $result->lab_no}}</td>
                                            </tr>
                                               <tr class="text-left">
                                                <td ><b>Who Tested:</b> <br>  {{ $result->who_tested}}  </td>
                                                <td ><b>Test Reason:</b> <br>   {{ $result->test_reason}}  </td>
                                                <td ><b>Test Type:</b> <br>  {{ $result->test_type}}  </td>
                                                <td ><b>Worksheet No:</b> <br>  {{ $result->worksheet_no}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <h6 class="text-primary d-print-none text-center">Collection <span>Details</span></h6>
                            <div class="container-fluid d-flex justify-content-center w-100">
                                <div class=" w-100">
                                    <table class="table table-bordered" width="100%">
                                        <tbody>
                                            <tr class="text-left">
                                                <td><b>Collected By</b>: <br> {{ $result->swabber}}</th>
                                                    <td><b>Collection date</b>: <br>  {{ $result->collection_date}}</th>
                                                        <td><b>Sample type</b>: <br>  {{ $result->sample_type}}</th>
                                                            <td><b>Facility</b>: <br>  {{ $result->facility}}</th>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <h6 class="text-primary d-print-none text-center">Covid 19 Vaccination <span>Information</span></h6>
                                            <div class="container-fluid d-flex justify-content-center w-100">
                                                <div class="table-responsive w-100">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr class="text-left">
                                                                <td><strong>Ever confirmed with COVID-19?</strong>: <br>  {{ $result->ever_been_positive}}</td>
                                                                <td><strong>Ever been vaccinated?</strong>:<br>  {{ $result->ever_been_vaccinated}}</td>
                                                                <td><strong>(Doses taken) If vaccinated</strong> :<br>{{$result->vaccine_dose1}}, {{ $result->vaccine_dose2}}, {{ $result->vaccine_dose3}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-bordered" width="100%">
                                                        <tr class="text-left">
                                                            <td ><b>Created by:</b>  {{ $result->createdby.' '.$result->createdbyfn.' ('.$result->created_at.')'}}  </td>
                                                            <td ><b>Accessioned by:</b>  {{ $result->accessionedby.' '.$result->accessionedbyfn.' ('.$result->accessioned_at.')'}}  </td>
                                                            <td ><b>Validated by:</b>  {{ $result->enteredby.' '.$result->enteredbyfn.' ('.$result->entered_at.')'}}  </td>
                                                            <td ><b>Result Added by:</b>  {{ $result->result_addedby.' '.$result->result_addedbyfn.' ('.$result->result_added_at.')'}}  </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="container-fluid w-100 d-print-none">
                                                <a  onclick = "window.print()" class="btn btn-outline-primary float-end mt-4 do-not-print"><i data-feather="printer" class="mr-2 icon-md"></i>Print</a>
                                            </div>                                       
                                </div>
                            </div>
                            @endforeach
                            @endif
                            
                            <div class="table-responsive">
                                 <table id="datableButtons" class="table dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Event</th>
                                            <th>Date</th>        
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($trails as $key=>$trail)
                                        <tr>
                                            <!--<td  class="d-none"></td>-->
                                            <!--<td  class="d-none">{{$trail->sname.' '.$trail->gname.' '.$trail->oname}}</td>                                            -->
                                            <!--<td>{{$trail->lab_no}}</td>-->
                                            <td>{{$trail->name}}</td>                                           
                                            <td style="word-wrap: break-word;
word-break: break-all;  
white-space: normal !important;
text-align: justify;">{{$trail->event}}</td>                                           
                                            <td>{{$trail->date}}</td>
                                           
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> 
                        </div><!-- end col-->
                    </div>

                </x-crs-layout>
