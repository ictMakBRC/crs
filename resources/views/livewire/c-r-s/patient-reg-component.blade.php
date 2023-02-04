<div>
    <div class="col-12">
        <div class="">
            <div class="card-header pt-0">
                <div class="row mb-2">
                    <div class="col-sm-12 mt-3">
                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                            <li class="nav-item">
                                <a href="#home" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0 active">
                                    <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Home</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#reports" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 ">
                                    <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Reports</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#tat" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                                    <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                    <span class="d-none d-md-block">TAT</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="tab-content">
                <div class="tab-pane show active" id="home">     
                        <x-table-utilities>
                            <div>
                                <div class="d-flex align-items-center ml-4 me-2">
                                    <label for="orderBy" class="text-nowrap mr-2 mb-0">OrderBy</label>
                                    <select wire:model="orderBy" class="form-select">
                                        <option type="name">Name</option>
                                        <option type="id">Latest</option>
                                    </select>
                                </div>
                            </div>
                        </x-table-utilities>
                        <div class="table-responsive">
                            <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Lab No.</th>
                                        <th>Date of collection</th>
                                        <th>Worksheet</th>
                                        <th>Result</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patients as $key => $value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->labno }}</td>
                                            <td>{{ $value->collectiondate }}</td>
                                            <td>{{ $value->worksheet}}</td>
                                            <td>{{ $value->result }}</td>
                                            <td>{{ $value->age }}</td>
                                            <td>{{ $value->gender }}</td>                                     
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="btn-group float-end">
                                    {{ $patients->links('vendor.livewire.bootstrap') }}
                                </div>
                            </div>
                        </div>
                    </div> <!-- end tab-content-->
                </div> <!-- end card body-->
                <div class="tab-pane" id="reports">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card my-1 shadow-none border">
                                <div class="p-2">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar-sm">
                                                <span class="avatar-title rounded">
                                                    .CVS
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col ps-0">
                                            <a href="javascript:void(0);" class="text-muted fw-bold">MOH report</a>
                                            <p class="mb-0">Daily</p>
                                        </div>
                                        <div class="col-auto">
                                            <!-- Button -->
                                            <a wire:click='moh' class="btn btn-link btn-lg text-muted">
                                                <i class="dripicons-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card my-1 shadow-none border">
                                <div class="p-2">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar-sm">
                                                <span class="avatar-title rounded">
                                                    .CVS
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col ps-0">
                                            <a href="javascript:void(0);" class="text-muted fw-bold">Average TAT</a>
                                            <p class="mb-0">Daily</p>
                                        </div>
                                        <div class="col-auto">
                                            <!-- Button -->
                                            <a wire:click='Avgtat' class="btn btn-link btn-lg text-muted">
                                                <i class="dripicons-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card my-1 shadow-none border">
                                <div class="p-2">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar-sm">
                                                <span class="avatar-title rounded">
                                                    .CVS
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col ps-0">
                                            <a href="javascript:void(0);" class="text-muted fw-bold">Average TAT</a>
                                            <p class="mb-0">Monthly</p>
                                        </div>
                                        <div class="col-auto">
                                            <!-- Button -->
                                            <a wire:click='AvgMonthlytat' class="btn btn-link btn-lg text-muted">
                                                <i class="dripicons-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card my-1 shadow-none border">
                                <div class="p-2">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar-sm">
                                                <span class="avatar-title rounded">
                                                    .CVS
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col ps-0">
                                            <a href="javascript:void(0);" class="text-muted fw-bold">Average TAT</a>
                                            <p class="mb-0">Quarterly</p>
                                        </div>
                                        <div class="col-auto">
                                            <!-- Button -->
                                            <a wire:click='AvgQuartertat' class="btn btn-link btn-lg text-muted">
                                                <i class="dripicons-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <a href="{{route('patientRegPropotion')}}">Propotion</a>
                    </div>
                </div>  
                <div class="tab-pane" id="tat"> 

                </div>    
            </div> <!-- end card -->
    </div><!-- end col-->
</div>
