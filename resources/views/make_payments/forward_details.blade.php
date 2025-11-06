<!-- Section: পেমেন্ট সংক্রান্ত তথ্য -->
<fieldset class="border p-3 mb-4">
    <legend class="float-none w-auto px-2">{{ 'পেমেন্ট সংক্রান্ত তথ্য' }}</legend>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-default">
                <tr>
                    <th scopre="row">{!! Form::label('Package_name', 'Package Name:') !!}</th>
                    <td>{{ $film->name }}</td>

                    <th scopre="row">{!! Form::label('amount', 'Amount:') !!}</th>
                    <td>{{ $film->amount }}</td>

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
