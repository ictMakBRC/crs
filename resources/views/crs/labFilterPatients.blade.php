<x-crs-layout>
    @section('title', 'Patients list')


    <!-- end row-->
    <div class="row mx-auto">
        <div class="col-12">
            <div class="card">

                <div class="card-body">

                        <form action="{{url('lab/report/patients')}}" method="POST">
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
                            <div class="mb-3 col-md-4">
                                <label for="facility_id" class="form-label">Facility</label>
                                <select class="form-control myselect" id="facility_id" name="facility_id" required>
                                    <option value="all">All facilities</option>
                                    @if(count($facilities)>0)
                                    @foreach($facilities as $facility)
                                    <option value="{{ $facility->id }}">{{$facility->facility_name}} {{$facility->parent!=null? '('.$facility->parent->facility_name.')':''}}</option>
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
             <div class="card">
             <div class="card-body">

                        <form action="{{url('lab/report/parentList')}}" method="POST">
                            @csrf
                            <div class="row">
                                <h4>Filter Facility Parent's List</h4>
                            <div class="mb-3 col-md-3">
                                <label for="simpleinput" class="form-label">From</label>
                                <input type="date" id="from" name="from" value="{{date('Y-m-d')}}" class="form-control" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="example-email" class="form-label">To</label>
                                <input type="date" id="to" value="{{date('Y-m-d')}}" name="to" class="form-control" required>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="facility_id" class="form-label">Facility</label>
                                <select class="form-control myselect" id="parent_id" name="facility_id" required>
                                    <option value="">Select a parent facility</option>
                                    @if(count($parents)>0)
                                    @foreach($parents as $facility)
                                    <option value="{{ $facility->id }}">{{$facility->facility_name}} {{$facility->parent!=null? '('.$facility->parent->facility_name.')':''}}</option>
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
            <div class="card">

                <div class="card-body">

                        <form action="{{url('lab/report/patients/count')}}" method="POST">
                            @csrf
                            <div class="row">
                                <h4>Filter Patients Count</h4>
                            <div class="mb-3 col-md-3">
                                <label for="simpleinput" class="form-label">From</label>
                                <input type="date" id="from" name="from" value="{{date('Y-m-d')}}" class="form-control" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="example-email" class="form-label">To</label>
                                <input type="date" id="to" value="{{date('Y-m-d')}}" name="to" class="form-control" required>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="facility_id" class="form-label">Group By Facility</label>
                                <select class="form-control myselect" id="facility_id2" name="facility_id" required>
                                    <option value="all">All facilities</option>
                                    @if(count($facilities)>0)
                                    @foreach($facilities as $facility)
                                    <option value="{{ $facility->id }}">{{$facility->facility_name}} {{$facility->parent!=null? '('.$facility->parent->facility_name.')':''}}</option>
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

            <div class="card">

                <div class="card-body">

                        <form action="{{url('lab/report/entries')}}" method="POST">
                            @csrf
                            <div class="row">
                                <h4>Filter Entries per user</h4>
                            <div class="mb-3 col-md-3">
                                <label for="simpleinput" class="form-label">From</label>
                                <input type="date" id="from" name="from" value="{{date('Y-m-d')}}" class="form-control" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="example-email" class="form-label">To</label>
                                <input type="date" id="to" value="{{date('Y-m-d')}}" name="to" class="form-control" required>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="facility_id" class="form-label">User</label>
                                <select class="form-control myselect"  name="user_id" required>
                                    <option value="all">All users</option>
                                    @if(count($users)>0)
                                    @foreach($users as $user)                                 
                                    <option value="{{ $user->id }}">{{ $user->surname.' '.$user->first_name}}</option>                                 
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
            <div class="card">

                <div class="card-body">

                        <form action="{{url('lab/report/entries/count')}}" method="POST">
                            @csrf
                            <div class="row">
                                <h4>Filter total entries per User</h4>
                            <div class="mb-3 col-md-3">
                                <label for="simpleinput" class="form-label">From</label>
                                <input type="date" id="from" name="from" value="{{date('Y-m-d')}}" class="form-control" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="example-email" class="form-label">To</label>
                                <input type="date" id="to" value="{{date('Y-m-d')}}" name="to" class="form-control" required>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="facility_id" class="form-label">User</label>
                                <select class="form-control myselect"  name="user_id" required>
                                    <option value="all">All users</option>
                                    @if(count($users)>0)
                                    @foreach($users as $user)                                 
                                    <option value="{{ $user->id }}">{{ $user->surname.' '.$user->first_name}}</option>                                  
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
            <div class="card">

                <div class="card-body">

                        <form action="{{url('lab/report/tat')}}" method="POST">
                            @csrf
                            <div class="row">
                                <h4>Filter Average Turn Around Time</h4>
                            <div class="mb-3 col-md-4">
                                <label for="simpleinput" class="form-label">From</label>
                                <input type="date" id="from" name="from" value="{{date('Y-m-d')}}" class="form-control" required>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="example-email" class="form-label">To</label>
                                <input type="date" id="to" value="{{date('Y-m-d')}}" name="to" class="form-control" required>
                            </div>
                        
                            <div class="mt-3 col-md-4">
                               <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                        </form>

                </div> <!-- end card body-->
            </div> <!-- end card -->
             <div class="card">

                <div class="card-body">

                        <form action="{{url('lab/report/result')}}" method="POST">
                            @csrf
                            <div class="row">
                                <h4>Export Patient Results</h4>
                            <div class="mb-3 col-md-3">
                                <label for="simpleinput" class="form-label">From</label>
                                <input type="date" id="from" name="from" value="{{date('Y-m-d')}}" class="form-control" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="example-email" class="form-label">To</label>
                                <input type="date" id="to" value="{{date('Y-m-d')}}" name="to" class="form-control" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="example-email" class="form-label">Result</label>
                                <select name="result" id="result" class="form-control">
                                     <option value="all">All</option>
                                    <option value="Positive">Positive</option>
                                    <option value="Negative">Negative</option>
                                </select>
                            </div>
                        
                            <div class="mt-3 col-md-3">
                               <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                        </form>

                </div> <!-- end card body-->
            </div> <!-- end card -->
             <div class="card">

                <div class="card-body">

                        <form action="{{url('lab/report/platifoms')}}" method="POST">
                            @csrf
                            <div class="row">
                                <h4>Filter Platifom Patient list</h4>
                            <div class="mb-3 col-md-3">
                                <label for="simpleinput" class="form-label">From</label>
                                <input type="date" id="from" name="from" value="{{date('Y-m-d')}}" class="form-control" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="example-email" class="form-label">To</label>
                                <input type="date" id="to" value="{{date('Y-m-d')}}" name="to" class="form-control" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="example-email" class="form-label">Platform</label>
                                <select name="platform" id="platform" class="form-control" required>
                                    <option value="">Select</option>
                                     @if(count($platforms)>0)
                                    @foreach($platforms as $item)                                 
                                    <option value="{{ $item->id }}">{{ $item->platform_name}}</option>                                  
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        
                            <div class="mt-3 col-md-3">
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
