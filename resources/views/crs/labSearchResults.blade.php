<x-crs-layout>
    @section('title', 'Patients list')


    <!-- end row-->
    <div class="row mx-auto">
        <div class="col-12">

                    <div class="container">



                        <section class="col-xs-12 col-sm-6 col-md-12">

                            @if(count($patients)>0)
                            @foreach($patients as $result)
                            <hgroup class="mb20">
                                <h1>Search Results</h1>
                                <h2 class="lead">Results found for the search for <strong class="text-danger">{{$search}}</strong></h2>
                            </hgroup>
                            <article class="search-result row">
                                {{-- <div class="col-xs-12 col-sm-12 col-md-3">
                                    <a href="#" title="Lorem ipsum" class="thumbnail"><img  alt="Lorem ipsum" /></a>
                                </div> --}}
                                <div class="col-xs-12 col-sm-12 col-md-7 excerpet">
                                    <h3><a href="{{url('patients/view/'.$result->wid)}}" title="">{{ $result->surname.' '. $result->given_name.' '. $result->other_name }}</a></h3>
                                    <p><b>Age:</b>  {{ $result->age}}, <b>Sex:</b>{{ $result->gender}}, <b>Nationality:</b> {{ $result->nationality}} </p>
                                    <p ><b>Patient ID:</b>  {{ $result->patient_id}}  <br>
                                    <b>Lab No. :</b> {{ $result->lab_no}}</p>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-5">
                                    <ul class="meta-search">
                                        <li><i class="bx bx-calendar"></i> <b>Collection Date: </b>{{ $result->collection_date}}</li>
                                        <li><i class="glyphicon glyphicon-time"></i> <b>Facility:</b> {{ $result->facility_name}}</li>
                                        <li><i class="glyphicon glyphicon-tags"></i> <b>Swbab District</b> {{ $result->swab_district}}</li>
                                        @if ($result->result != '')
                                        <li> <a  href="{{url('patients/result/download/'.$result->wid)}}" class="action-icon"> <i class="mdi mdi-download"></i></a></li>
                                        <li><a target="_blanck" href="{{url('patients/result/print/'.$result->wid)}}" class="action-icon"> <i class="mdi mdi-printer"></i>Print Results</a> </li>
                                        @endif
                                        <li><a  href="{{url('patients/lab/export/'.$result->wid)}}" class="action-icon"> <i class="mdi mdi-application-export"></i>Export</a> </li>
                                    </ul>
                                </div>

                                <span class="clearfix borda"></span>
                            </article>
                            @endforeach

                            @else
                            <hgroup class="mb20">
                                <h1>Search Results</h1>
                                <h2 class="lead">No search Results found for  <strong class="text-danger">{{$search}}</strong></h2>
                            </hgroup>
                            @endif
                        </section>
                    </div>


                {{$patients->links('pagination.bootstrap-4') }}

        </div><!-- end col-->
    </div>
    <!-- end row-->
</x-crs-layout>
