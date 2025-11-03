<!-- Section: পার্টি অ্যাপ্লিকেশন তথ্য -->
<fieldset class="border p-3 mb-4">
    <legend class="float-none w-auto px-2">{{  'পার্টি অ্যাপ্লিকেশন তথ্য' }}</legend>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-default">
                <tr>
                    <th scopre="row">{!! Form::label('film_title', 'Name:') !!}</th>
                    <td>{{ $film->organization_name }}</td>

                    <th scopre="row">{!! Form::label('applicant_nam', 'Address') !!}</th>
                    <td>{{ $film->address }}</td>
                </tr>
            </table>
        </div>
    </div>
</fieldset>


<!-- Section: নাটক সংক্রান্ত আবেদন মন্তব্য -->
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
