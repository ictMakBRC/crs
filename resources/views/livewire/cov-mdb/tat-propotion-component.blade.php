<div>
    <div class="col-12">
        <div class="card">
            @include('crs.inc.tatfilter')
            
        </div> <!-- end card -->

        <div class="card">
            <div class="card-body">
                <table id="datableButtons"  class="table dt-responsive nowrap text-end">
                    <thead class="text-center">
                        <tr>
                                <th>#</th>
                                <th>Date ({{$title}})</th>
                                <th>Inside Rage</th>
                                <th>Outside Rage</th>
                                <th>Total</th>
                                <th>Propotion(%)</th>
                        </tr>
                    <thead>
                        <tbody>
                            @foreach ($propotions as $key=>$data)
                            <tr>
                                <td> <input name='id[]' type="checkbox" id="checkItem"> {{$key+1}}</td>
                                <td class="text-center">{{$data->new_date}}</td>
                                <td>{{$data->totalwitin}}</td>
                                <td>{{$data->totalOut}}</td>
                                <td>{{$data->total}}</td>
                                <td>
                                @php
                                    $propValue = ($data->totalwitin/$data->total)*100
                                @endphp
                                @convert($propValue)
                                </td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                </table>
                {{-- {{$propIn}} --}}
            </div>
        </div>
 
    </div><!-- end col-->
</div>
