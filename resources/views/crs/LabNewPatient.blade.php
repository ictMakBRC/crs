@section('title', 'Register Patient')
<x-crs-layout>
    <!-- end row-->
    <div class="row mx-auto">
        <div class="col-12">
            <div >
                <div>
                    <form method="POST" action="{{route('patients.store')}}" onsubmit="myFunction1()" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="entry_type" value="Internal">
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label for="facility_id" class="form-label">Facility<span class="text-danger">*</span></label>
                                <select class="form-select myselect" id="facility_id" name="facility_id" required>
                                    <option value="">Select</option>
                                    @if(count($facilities)>0)
                                    @foreach($facilities as $facility)
                                    <option value="{{ $facility->id }}">{{$facility->facility_name}}{{$facility->parent!=null?' ('.$facility->parent->facility_name.')':''}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            @include('crs.inc.patient')
                        </div>
                        <div class="d-grid mb-0 text-center">
                            <button class="btn btn-primary" type="submit"  id="submitBtn"> Add Patient</button>
                            <img id="divMsg" style="display:none;" src="{{asset('images/loading.gif')}}" width="100%" height="8px" alt="Please wait.." />
                            <p id="txt" style="display:none;" class="text text-success">Processing request, Please wait..</p>
                        </div>
                    </form>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <script>
    function myFunction1() {
    var b = document.getElementById("submitBtn");
    var y = document.getElementById("txt");
    var x = document.getElementById("divMsg");
    if (x.style.display === "none") {
    x.style.display = "block";
    document.getElementById("submitBtn").style.visibility = "hidden";
    y.style.display = "block";
    } else {
    x.style.display = "none";
    document.getElementById("submitBtn").style.visibility = "visible";
    y.style.display = "none";
    }
    }
    </script>

    @push('scripts')
    @if(!Auth::user()->hasRole(['DataClerkSite']))
      <script>
      $( document ).ready(function() {
        $('#facility_id').change(function() 
          {
          var id  = $(this).val();
          var url="{{route('swabbers.get',':id')}}";
          url = url.replace(':id', id );

          let swabberElement;
          
          $.ajax(
          {
          url: url,
          method: "GET",
          dataType: "json",
          success: function(response)
          {
              console.log(response);

              $("option[class='dynamic']").remove();

              response[0].map(swabber => {
                swabberElement= `<option class="dynamic" value="${swabber.id}">${swabber.full_name}</option>`
                  $('#collected_by').append(swabberElement);
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
      @endif
  @endpush
</x-crs-layout>
