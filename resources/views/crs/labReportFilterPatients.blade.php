<x-crs-layout>
    @section('title', 'Patients list')


    <!-- end row-->
    <div class="row mx-auto">
        <div class="col-12">
            <div class="card">

                <div class="card-body">

                    <form action="{{url('lab/report/filter')}}" method="POST">
                            @csrf
                            <div class="row">
                                <h4>Filter Facility Patients List</h4>
                            <div class="mb-3 col-md-3">
                                <label for="simpleinput" class="form-label">From</label>
                                <input type="date" id="from" name="from" value="{{date('Y-m-d')}}" class="form-control" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="example-email" class="form-label">To</label>
                                <input type="date" id="to" value="{{date('Y-m-d')}}" name="to" class="form-control" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="facility_id" class="form-label">Facility(Include)</label>
                                <select class="form-control myselect" id="facility_id" name="facility_id" required>
                                    <option value="all">All facilities</option>
                                    @if(count($facilities)>0)
                                    @foreach($facilities as $facility)
                                    <option value="{{ $facility->id }}">{{$facility->facility_name}} {{$facility->parent!=null? '('.$facility->parent->facility_name.')':''}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="facility_id" class="form-label">Facility(Exclude)</label>
                                <select class="form-control myselect" id="facility_ex" name="facility_ex" required>
                                    <option value="0">None</option>
                                    @if(count($facilities)>0)
                                    @foreach($facilities as $facility)
                                    <option value="{{ $facility->id }}">{{$facility->facility_name}} {{$facility->parent!=null? '('.$facility->parent->facility_name.')':''}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="facility_id" class="form-label">Entered by(include)</label>
                                <select class="form-control myselect"  name="entered_by" required>
                                    <option value="all">All users</option>
                                    @if(count($users)>0)
                                    @foreach($users as $user)                                 
                                    <option value="{{ $user->id }}">{{ $user->surname.' '.$user->first_name}}</option>                                 
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="facility_id" class="form-label">Entered by(Exclude)</label>
                                <select class="form-control myselect"  name="entered_ex" required>
                                    <option value="0">None</option>
                                    @if(count($users)>0)
                                    @foreach($users as $user)                                 
                                    <option value="{{ $user->id }}">{{ $user->surname.' '.$user->first_name}}</option>                                 
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="Swabberin" class="form-label">Swabbed by(Include)</label>
                                <select class="form-control myselect"  name="swabber_in" required>
                                    <option value="all">All swabbers</option>
                                    @if(count($swabbers)>0)
                                    @foreach($swabbers as $user)                                 
                                    <option value="{{ $user->id }}">{{ $user->full_name.' '.$user->swabber_email}}</option>                                 
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="Swabberex" class="form-label">Swabbed by(Exclude)</label>
                                <select class="form-control myselect"  name="swabber_ex" required>
                                    <option value="0">None</option>
                                    @if(count($swabbers)>0)
                                    @foreach($swabbers as $user)                                 
                                    <option value="{{ $user->id }}">{{ $user->full_name.' '.$user->swabber_email}}</option>                                 
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="example-email" class="form-label">Result</label>
                                <select name="result" id="result" class="form-control">
                                     <option value="all">All</option>
                                    <option value="Positive">Positive</option>
                                    <option value="Negative">Negative</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="example-email" class="form-label">Platform(Include)</label>
                                <select name="platform" id="platform" class="form-control" required>
                                    <option value="all">All platforms</option>
                                     @if(count($platforms)>0)
                                    @foreach($platforms as $item)                                 
                                    <option value="{{ $item->id }}">{{ $item->platform_name}}</option>                                  
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="example-email" class="form-label">Platform(Exclude)</label>
                                <select name="platform_ex" id="platforme" class="form-control" required>
                                    <option value="0">None</option>
                                     @if(count($platforms)>0)
                                    @foreach($platforms as $item)                                 
                                    <option value="{{ $item->id }}">{{ $item->platform_name}}</option>                                  
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mt-3 col-md-2">
                               <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>

                </div> <!-- end card body-->
            </div> <!-- end card -->
     

         
     
        
        </div><!-- end col-->
    </div>
    <!-- end row-->
</x-crs-layout>
