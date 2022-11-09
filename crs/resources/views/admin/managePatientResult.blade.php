<x-general-layout>
    @section('title', 'Patient')
    <!-- end row-->
    <div class="row mx-auto">
        <div class="col-12">
            @foreach ($values as $key=>$value)
                                        
                            @if(Auth::user()->hasRole(['DataAdmin','ResultsQC']))
                            <div class="tab-pane" id="finish-2">
                                <div class="row">
                                    <form method="POST" action="{{url('admin/results/update/'.$value->wid)}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-12">
                                            <h5 class="modal-title" id="staticBackdropLabel">Update <b class="text-success">{{$value->surname.' '.$value->given_name.' '.$value->other_name}}</b></h5>
                                                    <div class="row">
                                                        <div class="mb-3 col-md-3">
                                                            <label for="worksheet_no" class="form-label">Worksheet no<span class="text-danger">*</span></label>
                                                            <input type="text" id="worksheet_no" class="form-control" name="worksheet_no" required value="{{ $value->worksheet_no}}">
                                                        </div>
                                                        <input type="text" id="collection_date" class="form-control d-none" name="collection_date" required value="{{$value->collection_date}}">
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
                                                            <label for="ct_value" class="form-label">CT value 1(Confirmatory)<span class="text-danger">*</span></label>
                                                            <input type='number' step='0.001' min="0" max="38.00" id="ct_value" class="form-control" name="ct_value" required value="{{ $value->ct_value }}">
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
                                                            <label for="ct_value2" class="form-label">CT value 2<span class="text-danger">*</span></label>
                                                            <input type='number' step='0.001' id="ct_value2" min="0" max="38.00" class="form-control" name="ct_value2" value="{{ $value->ct_value2 }}">
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
                                                            <label for="ct_value3" class="form-label">CT value3<span class="text-danger">*</span></label>
                                                            <input type='number' step='0.001' id="ct_value3" min="0" max="38.00" class="form-control" name="ct_value3" value="{{ $value->ct_value3 }}">
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <label for="target4" class="form-label">Target 4<span class="text-danger">*</span></label>
                                                            <select name="target4" class="form-control myselect" id="target4">
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
                                                            <label for="ct_value4" class="form-label">CT value 4<span class="text-danger">*</span></label>
                                                            <input type='number' step='0.001' id="ct_value4" min="0" max="38.00" class="form-control" name="ct_value4" value="{{ $value->ct_value4 }}">
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <label class="form-label">Platform<font color="red"><b>*</b></font></label>
                                                            <select name="platform" id="platform" class="form-control myselect" style="width: 100%;" required>
                                                                @if ($value->platform=="")
                                                                <option value="">Select platform</option>
                                                                @else
                                                                <option selected value="{{ $value->platform }}" >{{ $value->platform_name }}</option>
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
                                                                <option value="">Select a kit</option>
                                                                {{-- @if ($value->test_kit=="")
                                                                <option value="">Select a kit</option>
                                                                @else
                                                                <option selected value="{{ $value->test_kit }}" >{{ $value->kit_name }}</option>
                                                                @endif
                                                                @if(count($kits)>0)
                                                                @foreach($kits as $kit)
                                                                <option value="{{ $kit->id }}">{{ $kit->kit_name}}</option>
                                                                @endforeach
                                                                @endif --}}
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
                                                            <label for="result" class="form-label">Result<span class="text-danger">*</span></label>
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

                                                        <button type="submit" class="btn btn-success float-end">Update results</button>
                                                    </div>
                                    
                                        </div> <!-- end col -->
                                    </form>
                                </div> <!-- end row -->
                            </div>
                            @endif
                     
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
    @push('scripts')

        <script>
        $( document ).ready(function() {
            // $('#ct_value').val(0.00);
            $('#result').empty().prepend('<option value="Negative" selected>Negative</option>');
            var element='<option value="Positive" selected>Positive</option>';
            $('#ct_value').change(function() 
            {
                if($('#ct_value').val()>0)
                {
                    $('#result').empty().prepend(element);
                
                }else{
                    $('#result').empty().prepend('<option value="Negative" selected>Negative</option>');
                }
            
            })

             
            $('#platform').change(function() 
            {
            var id  = $(this).val();
            var url="{{route('kits.get',':id')}}";
            url = url.replace(':id', id );

            let kitElement;
            
            $.ajax(
            {
            url: url,
            method: "GET",
            dataType: "json",
            success: function(response)
            {
                console.log(response);

                $("option[class='dynamic']").remove();

                response[0].map(kit => {
                    kitElement= `<option class="dynamic" value="${kit.id}">${kit.kit_name}</option>`
                    $('#test_kit').append(kitElement);
                    return true;

                    });
            },
            error: function (xhr, ajaxOptions, thrownError) 
            {
                console.log(xhr.status);
                console.log(thrownError);
            }
            })
            })
            });
           
        </script>
    @endpush
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

</x-general-layout>
