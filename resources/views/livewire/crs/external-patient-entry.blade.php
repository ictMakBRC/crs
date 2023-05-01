    
    <div row>
        <div class=" align-items-center float-end">                                                    
            <div class="btn btn-white">
                <input class="form-check-input" wire:click="$set('referred',{{ $referred ? 'false' : 'true' }})" @if ($referred)
                    checked
                @endif  type="checkbox">
                @if ($referred)Referred
                @else Total Samples
                @endif
                <b>({{$external_patients->count()}})</b>
            </div>       
        </div>
        <br>
        <div class="table-responsive col-12" >
            <table id="datableButtons" class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Sample ID</th>
                        <th>Patient UUID</th>
                        <th>Patient Name</th>
                        <th>Sample Type</th>
                        <th>Collection Date</th>
                        <th>Swab District</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>

                    @foreach ($external_patients as $key => $patient)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $patient['specimen_identifier'] }}</td>
                            <td>{{ $patient['specimen_uuid'] }}</td>
                            <td>{{ $patient['patient_surname'] ?? '-' }}</td>
                            <td>{{ $patient['sample_type'] ?? '-' }}</td>
                            <td>{{ $patient['request_date'] ?? '-' }}</td>
                            <td>{{ $patient['swabing_district'] ?? '-' }}</td>
                            <td class="table-action">
                                <button type="button" class="btn btn-success" wire:click="claimPatient('{{$patient['specimen_identifier']}}')"><i class="dripicons-arrow-down"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> <!-- end preview-->
    </div>
