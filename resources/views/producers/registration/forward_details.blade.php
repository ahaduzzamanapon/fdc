<!-- Section: বুকিং তথ্য -->
<fieldset class="border p-3 mb-4">
    <legend class="float-none w-auto px-2">{{  'রেজিস্ট্রেশন তথ্য' }}</legend>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-default">
                <tr>
                    <th scopre="row">{!! Form::label('booking_type', ' Organization:') !!}</th>
                    <td>{{ $producer->organization_name }}</td>

                    <th scopre="row">{!! Form::label('applicant_name', 'Applicant Name:') !!}</th>
                    <td>{{ $producer->owners_name }}</td>
                </tr>
            </table>
        </div>
    </div>
</fieldset>


<!-- Section: বুকিং সংক্রান্ত আবেদন মন্তব্য -->
{{-- <fieldset class="border p-3 mb-4">
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

            </table>
        </div>
    </div>
</fieldset> --}}
