<!-- Section: বুকিং তথ্য -->
<fieldset class="border rounded p-3 mb-4">
    <legend class="float-none w-auto px-2 fw-bold">
        বুকিং তথ্য
    </legend>

    <div class="row gy-2">
        <div class="col-md-6">
            <div class="d-flex">
                <span class="fw-semibold me-2" style="min-width: 140px;">
                    সেবার নাম:
                </span>
                <span>{{ $booking->film_title }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="d-flex">
                <span class="fw-semibold me-2" style="min-width: 140px;">
                    প্রযোজকের নাম:
                </span>
                <span>{{ $booking->producer_name }}</span>
            </div>
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
                    @php
                        $user = get_user($log->action_by);
                        $role = get_role($log->action_role_id);
                    @endphp
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                            {{ $user?->name_en ?? 'N/A' }}
                            ({{ Str::ucfirst($role?->name ?? 'N/A') }})
                        </td>
                        <td>{{ $log->status }}</td>
                        <td>{{ $log->remarks }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</fieldset>
