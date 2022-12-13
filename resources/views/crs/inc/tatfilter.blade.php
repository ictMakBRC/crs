<div class="card-body">
    <div class="float-end">
        <div class="col-md-12">
            <div class="mb-6 col-md-3">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{route('mean')}}" type="button" class="btn btn-secondary">Mean</a>
                    <a href="{{route('range')}}" type="button" class="btn btn-secondary">Range</a>
                    <a href="{{route('propotion')}}" class="btn btn-secondary">Propotion</a>
                  </div>
            </div>
        </div>
    </div>
    <form action="{{route(Route::current()->getName())}}" method="GET">
            @csrf
            <div class="row">
                
                <h4>Filter Lists</h4>
                <div class="mb-3 col-md-3">
                    <label for="simpleinput" class="form-label">From</label>
                    <input type="date" id="from" name="from" value="{{date('Y-m-d')}}" class="form-control" required>
                </div>
                <div class="mb-3 col-md-3">
                    <label for="example-email" class="form-label">To</label>
                    <input type="date" id="to" value="{{date('Y-m-d')}}" name="to" class="form-control" required>
                </div>
                <div class="mb-3 col-md-3">
                    <label for="example-email" class="form-label">Group By</label>
                    <select class="form-control myselect"  name="group">
                        <option value="{{$title}}">{{$title}}</option>
                        <option value="">Daily</option>
                        <option value="Weekly">Weekly</option>
                        <option value="Monthly">Monthly</option>
                        <option value="Yearly">Yearly</option>                                        
                    </select>
                </div>
                <div class="mb-3 col-md-3">
                    <button type="submit" class="btn btn-sm btn-primary mt-4">Filter</button>
                </div>
            </div>
    </form>

</div> <!-- end card body-->