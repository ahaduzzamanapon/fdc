<!-- Section: বুকিং তথ্য -->
<fieldset class="border p-3 mb-4">
    <legend class="float-none w-auto px-2">{{  'বুকিং তথ্য' }}</legend>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-default">
                <tr>
                    <th scopre="row">{!! Form::label('booking_type', 'Booking Type:') !!}</th>
                    <td>{{ $booking->film_type }}</td>

                    <th scopre="row">{!! Form::label('applicant_name', 'Applicant Name:') !!}</th>
                    <td>{{ \App\Models\Producer::find($booking->producer_id)->organization_name }}</td>
                </tr>
            </table>
        </div>
    </div>
</fieldset>


<!-- Section: বুকিং সংক্রান্ত আবেদন মন্তব্য -->
<fieldset class="border p-3 mb-4">
    <legend class="float-none w-auto px-2">আবেদন মন্তব্য</legend>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-default">
                <tr>
                    <th>Sl</th>
                    <th>Role Name</th>
                    <th>Status</th>
                    <th>Remarks</th>
                </tr>

                @foreach($logs as $key => $log)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td> {{ get_user($log->action_by)->name_en }} ({{ Str::ucfirst(get_role($log->action_role_id)->name) }})</td>
                        <td>{{ $log->status }}</td>
                        <td>{{ $log->remarks }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</fieldset>
