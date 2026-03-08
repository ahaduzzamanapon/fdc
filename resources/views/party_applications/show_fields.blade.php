
<tr>
    <th scopre="row">{!! Form::label('organization_name', 'Organization Name:') !!}</th>
    <td>{{ $filmApplication->organization_name }}</td>
</tr>

<tr>
    <th scopre="row">{!! Form::label('owners_name', 'Owner\'s Name:') !!}</th>
    <td>{{ $filmApplication->owners_name }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('owners_nid', 'Owner\'s NID:') !!}</th>
    <td>{{ $filmApplication->owners_nid }}</td>
</tr>

<tr>
    <th scopre="row">{!! Form::label('phone_number', 'Phone Number:') !!}</th>
    <td>{{ $filmApplication->phone_number }}</td>
</tr>

<tr>
    <th scopre="row">{!! Form::label('email', 'Email:') !!}</th>
    <td>{{ $filmApplication->email }}</td>
</tr>

<tr>
    <th scopre="row">{!! Form::label('Status', 'Status') !!}</th>
    <td>{{ $filmApplication->status }}</td>
</tr>

<tr>
    <th scopre="row">{!! Form::label('Desk', 'Desk') !!}</th>
    <td>{{ Str::ucfirst(get_role($filmApplication->desk_id)->name) }}</td>
</tr>

<tr>
    <th scopre="row">{!! Form::label('address', 'Address:') !!}</th>
    <td>{{ $filmApplication->address }}</td>
</tr>

<tr>
    <th scopre="row">{!! Form::label('bank_name', 'Bank Name:') !!}</th>
    <td>{{ $filmApplication->bank_name }}</td>
</tr>

<tr>
    <th scopre="row">{!! Form::label('bank_branch', 'Bank Branch:') !!}</th>
    <td>{{ $filmApplication->bank_branch }}</td>
</tr>

<tr>
    <th scopre="row">{!! Form::label('bank_account_number', 'Bank Account Number:') !!}</th>
    <td>{{ $filmApplication->bank_account_number }}</td>
</tr>

<tr>
    <th scopre="row">{!! Form::label('tin_number', 'TIN Number:') !!}</th>
    <td>{{ $filmApplication->tin_number }}</td>
</tr>

<tr>
    <th scopre="row">{!! Form::label('trade_license', 'Trade License:') !!}</th>
    <td>{{ $filmApplication->trade_license }}</td>
</tr>

<tr>
    <th scopre="row">{!! Form::label('vat_registration_number', 'VAT Registration Number:') !!}</th>
    <td>{{ $filmApplication->vat_registration_number }}</td>
</tr>

<tr>
    <th scopre="row">{!! Form::label('nominee_name', 'Nominee Name:') !!}</th>
    <td>{{ $filmApplication->nominee_name }}</td>
</tr>

<tr>
    <th scopre="row">{!! Form::label('nominee_nid', 'Nominee NID:') !!}</th>
    <td>{{ $filmApplication->nominee_nid }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('created_at', 'Created At:') !!}</th>
    <td>{{ $filmApplication->created_at }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('updated_at', 'Updated At:') !!}</th>
    <td>{{ $filmApplication->updated_at }}</td>
</tr>


