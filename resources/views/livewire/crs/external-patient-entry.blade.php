<div>
    <div class="d-flex align-items-center">                                                    
        <div class="btn btn-white">
            <input class="form-check-input" wire:click="$set('referred',{{ $referred ? 'false' : 'true' }})" @if ($referred)
                checked
            @endif  type="checkbox">
            Referred{{$referred}}
        </div>       
    </div>
    <div class="table-responsive" >
        <table id="datableButtons" class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Case ID</th>
                    <th>Patient UUID</th>
                    <th>Surname</th>
                    <th>First Name</th>
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
                        <td>{{ $patient['patient_identifier'] }}</td>
                        <td>{{ $patient['specimen_uuid'] }}</td>
                        <td>{{ $patient['patient_surname'] ?? '-' }}</td>
                        <td>{{ $patient['patient_firstname'] ?? '-' }}</td>
                        <td>{{ $patient['sample_type'] ?? '-' }}</td>
                        <td>{{ $patient['request_date'] ?? '-' }}</td>
                        <td>{{ $patient['swabing_district'] ?? '-' }}</td>
                        <td class="table-action">
                            <button type="button" class="btn btn-success" wire:click="claimPatient('{{$patient['patient_identifier']}}')"><i class="dripicons-arrow-down"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> <!-- end preview-->
</div>
