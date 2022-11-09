
<x-crs-layout>
    @section('title', 'Register Patient')
    <!-- end row-->
    <div class="row mx-auto">
        <div class="col-12">
            <div>

                <div>

                    <form method="POST" action="{{route('patients.store')}}" enctype="multipart/form-data">
                        @csrf
                        {{-- @method('PUT') --}}
                        <input type="hidden" name="entry_type" value="External">
                         <ul class="nav nav-pills nav-justified form-wizard-header ml-3">
                            <li class="nav-item">
                                <a href="#account-2" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2 active">
                                    <i class="uil-medical-square"></i>
                                    <span class=" d-sm-inline"><b>{{$facility->facility_name}} {{$facility->parent!=null? '['.$facility->parent->facility_name.']':''}}</b></span>
                                </a>
                            </li>
                        </ul>
                        <div class="row mx-auto mt-3">
                             @include('crs.inc.patient')
                        </div>
                              <!-- end row-->
                        <!-- end row-->
                        <div class="d-grid mb-0 text-center">
                            <button class="btn btn-primary" type="submit"  id="btnSubmit"> Add Patient</button>
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
          var x = document.getElementById("divMsg");
          var y = document.getElementById("txt");
          if (x.style.display === "none") {
            x.style.display = "block";
             document.getElementById("btnSubmit").style.display = "none";
             y.style.display = "block";
          } else {
            x.style.display = "none";
             document.getElementById("btnSubmit").style.display = "block";
             y.style.display = "none";
          }
        }
        </script>
</x-crs-layout>
