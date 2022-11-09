<x-crs-layout>
    @section('title', 'Import list')
    <!-- end row-->
    <div class="row mx-auto">
        <div class="col-12">
            {{-- <div class="card"> --}}
                {{-- <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <div class="text-sm-end mt-3">
                                <h4 class="header-title mb-3  text-center">My Patients</h4>
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="card-body"> --}}
                    {{-- <label for=""><input type="checkbox" id="checkAll"> Select All</label> --}}
                    <div class="table-responsive">
                        <table id="scroll-vertical-datatable" class="table"> 
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Batch Number</th>
                                    <th>Imported by</th>
                                    <th>No. of items</th>
                                    <th>Date imported</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($imports)>0)
                                @php($i=1)
                                @foreach($imports as $value)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$value->import_batch}}</td>
                                    <td>{{ $value->name}}</td>
                                    <td>{{ $value->list}}</td>
                                    <td>{{ $value->resultdate}}</td>
                                    <td class="table-action">
                                        <a  href="{{url('patients/labr/export/'.$value->import_batch)}}" class="action-icon"> <i class="mdi mdi-application-export"></i></a>
                                        <a href="{{ url('patients/lab/result/import/'.$value->import_batch)}}" class="action-icon btn btn-sm"> <i class="mdi mdi-eye" ></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @endif


                            </tbody>
                        </table>
                    </div> <!-- end preview-->
                {{-- </div> <!-- end card body-->
            </div> <!-- end card --> --}}
        </div><!-- end col-->
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script language="javascript">
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
    <!-- end row-->
</x-crs-layout>
