<div>
    <div class="table-responsive" wire:ignore>
        <table id="datableButtons" class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Case ID</th>
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
                        <td>{{ $patient['caseID'] }}</td>
                        <td>{{ $patient['patient_surname'] ?? '-' }}</td>
                        <td>{{ $patient['patient_firstname'] ?? '-' }}</td>
                        <td>{{ $patient['sample_type'] ?? '-' }}</td>
                        <td>{{ $patient['request_date'] ?? '-' }}</td>
                        <td>{{ $patient['swabing_district'] ?? '-' }}</td>
                        <td class="table-action">
                            <button type="button" class="btn btn-success" wire:click="claimPatient('{{$patient['caseID']}}')"><i class="dripicons-arrow-down"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> <!-- end preview-->
</div>
