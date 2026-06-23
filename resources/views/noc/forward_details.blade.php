<!-- Section: সিনেমা সংক্রান্ত তথ্য -->
<fieldset class="border p-3 mb-4">
    <legend class="float-none w-auto px-2">NOC</legend>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-default">
                <tr>
                    <th scopre="row">{!! Form::label('registration_no', 'Registration No:') !!}</th>
                    <td>{{ $noc->token }}</td>

                    <th scopre="row">{!! Form::label(' producer', 'Producer :') !!}</th>
                    <td>{{ $noc->producer }}</td>

                    <th scopre="row">{!! Form::label('designation', 'Designation:') !!}</th>
                    <td>{{ $noc->designation }}</td>
                </tr>
                <tr>
                    <th scopre="row">{!! Form::label('organization', 'Organization:') !!}</th>
                    <td>{{ $noc->organization }}</td>

                    <th scopre="row">{!! Form::label('type', ' Type:') !!}</th>
                    <td>{{ $noc->type }}</td>

                    <th scopre="row">{!! Form::label(' cen_certificate_no', ' cen certificate no:') !!}</th>
                    <td>{{ $noc->cen_certificate_no }}</td>
                </tr>
            </table>
        </div>
    </div>
</fieldset>
