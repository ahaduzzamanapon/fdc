<style>
    th{
        white-space: normal;
    }
</style>
<tr>
    <th  width="5%">{!! Form::label('id', __('messages.id') . ':') !!}</th>
    <td>{{ $producer->id }}</td>
</tr>


<tr>
    <th  width="5%">{!! Form::label('organization_name', __('messages.organization_name') . ':') !!}</th>
    <td>{{ $producer->organization_name }}</td>
</tr>


<tr>
    <th  width="5%">{!! Form::label('owners_name', __('messages.owners_name') . ':') !!}</th>
    <td>{{ $producer->owners_name }}</td>
</tr>


<tr>
    <th  width="5%">{!! Form::label('owners_nid', __('messages.owners_nid') . ':') !!}</th>
    <td>{{ $producer->owners_nid }}</td>
</tr>


<tr>
    <th  width="5%">{!! Form::label('address', __('messages.address') . ':') !!}</th>
    <td>{{ $producer->address }}</td>
</tr>


<tr>
    <th  width="5%">{!! Form::label('phone_number', __('messages.phone_number') . ':') !!}</th>
    <td>{{ isset($producer->phone_number) ? $producer->phone_number : '' }}</td>
</tr>


<tr>
    <th  width="5%">{!! Form::label('email', __('messages.email') . ':') !!}</th>
    <td>{{ isset($producer->email) ? $producer->email : '' }}</td>
</tr>


<tr>
    <th  width="5%">{!! Form::label('bank_name', __('messages.bank_name') . ':') !!}</th>
    <td>{{ isset($producer->bank_name) ? $producer->bank_name : '' }}</td>
</tr>


<tr>
    <th  width="5%">{!! Form::label('bank_branch', __('messages.bank_branch') . ':') !!}</th>
    <td>{{ isset($producer->bank_branch) ? $producer->bank_branch : '' }}</td>
</tr>


<tr>
    <th  width="5%">
        {!! Form::label('bank_account_number', __('messages.bank_account_number_label') . ':') !!}
    </th>
    <td>{{ isset($producer->bank_account_number) ? $producer->bank_account_number : '' }}</td>
</tr>


<tr>
    <th  width="5%">{!! Form::label('bank_attachment', __('messages.bank_attachment') . ':') !!}</th>
    <td>
        @if(isset($producer->bank_attachment) && $producer->bank_attachment != '[]' && $producer->bank_attachment != '')
            <a href="{{ asset($producer->bank_attachment) }}" target="_blank" class="btn btn-outline-primary btn-xs">
                <i class="im im-icon-File-Search" data-placement="top" title="{{ __('messages.view') }}"></i>
                {{ __('messages.view') }}
            </a>
        @endif
    </td>
</tr>


<tr>
    <th  width="5%">{!! Form::label('tin_number', __('messages.tin_number') . ':') !!}</th>
    <td>{{ isset($producer->tin_number) ? $producer->tin_number : '' }}</td>
</tr>


<tr>
    <th  width="5%">{!! Form::label('trade_license', __('messages.trade_license') . ':') !!}</th>
    <td>{{ isset($producer->trade_license) ? $producer->trade_license : '' }}</td>
</tr>


<tr>
    <th  width="5%">
        {!! Form::label('vat_registration_number', __('messages.vat_registration_number') . ':') !!}
    </th>
    <td>{{ isset($producer->vat_registration_number) ? $producer->vat_registration_number : '' }}</td>
</tr>


<tr>
    <th  width="5%">{!! Form::label('nominee_name', __('messages.nominee_name_label') . ':') !!}</th>
    <td>{{ isset($producer->nominee_name) ? $producer->nominee_name : '' }}</td>
</tr>


<tr>
    <th  width="5%">{!! Form::label('nominee_relation', __('messages.nominee_relation') . ':') !!}</th>
    <td>{{ isset($producer->nominee_relation) ? $producer->nominee_relation : '' }}</td>
</tr>


<tr>
    <th  width="5%">{!! Form::label('nominee_nid', __('messages.nominee_nid_label') . ':') !!}</th>
    <td>{{ isset($producer->nominee_nid) ? $producer->nominee_nid : '' }}</td>
</tr>


<tr>
    <th  width="5%">{!! Form::label('nominee_photo', __('messages.nominee_photo_label') . ':') !!}</th>
    <td>
        @if(isset($producer->nominee_photo))
            <a href="{{ asset($producer->nominee_photo) }}" target="_blank" class="btn btn-outline-primary btn-xs">
                <i class="im im-icon-File-Search" data-placement="top" title="{{ __('messages.view') }}"></i>
                {{ __('messages.view') }}
            </a>
        @endif
    </td>
</tr>


<tr>
    <th  width="5%">
        {!! Form::label('partnership_agreement', __('messages.partnership_agreement_label') . ':') !!}
    </th>
    <td>
        @if(isset($producer->partnership_agreement) && $producer->partnership_agreement != '[]' && $producer->partnership_agreement != '')
            <a href="{{ asset($producer->partnership_agreement) }}" target="_blank" class="btn btn-outline-primary btn-xs">
                <i class="im im-icon-File-Search" data-placement="top" title="{{ __('messages.view') }}"></i>
                {{ __('messages.view') }}
            </a>
        @endif
    </td>
</tr>


<tr>
    <th  width="5%">{!! Form::label('ltd_company_agreement', __('messages.limited_company_info') . ':') !!}
    </th>
    <td>
        @if(isset($producer->ltd_company_agreement) && $producer->ltd_company_agreement != '[]' && $producer->ltd_company_agreement != '')
            <a href="{{ asset($producer->ltd_company_agreement) }}" target="_blank" class="btn btn-outline-primary btn-xs">
                <i class="im im-icon-File-Search" data-placement="top" title="{{ __('messages.view') }}"></i>
                {{ __('messages.view') }}
            </a>
        @endif
    </td>
</tr>


<tr>
    <th  width="5%">{!! Form::label('somobay_agreement', __('messages.cooperative_society_info') . ':') !!}
    </th>
    <td>
        @if(isset($producer->somobay_agreement) && $producer->somobay_agreement != '[]' && $producer->somobay_agreement != '')
            <a href="{{ asset($producer->somobay_agreement) }}" target="_blank" class="btn btn-outline-primary btn-xs">
                <i class="im im-icon-File-Search" data-placement="top" title="{{ __('messages.view') }}"></i>
                {{ __('messages.view') }}
            </a>
        @endif
    </td>
</tr>


<tr>
    <th  width="5%">{!! Form::label('other_attachment', __('messages.other_attachment_label') . ':') !!}
    </th>
    <td>
        @if(isset($producer->other_attachment) && $producer->other_attachment != '[]' && $producer->other_attachment != '')
            <a href="{{ asset($producer->other_attachment) }}" target="_blank" class="btn btn-outline-primary btn-xs">
                <i class="im im-icon-File-Search" data-placement="top" title="{{ __('messages.view') }}"></i>
                {{ __('messages.view') }}
            </a>
        @endif
    </td>
</tr>


<tr>
    <th  width="5%">
        {!! Form::label('trade_license_validity_date', __('messages.trade_license_validity_date_label') . ':') !!}
    </th>
    <td>{{ isset($producer->trade_license_validity_date) ? $producer->trade_license_validity_date : '' }}</td>
</tr>


<tr>
    <th  width="5%">
        {!! Form::label('trade_license_attachment', __('messages.trade_license_attachment_label') . ':') !!}
    </th>
    <td>
        @if(isset($producer->trade_license_attachment) && $producer->trade_license_attachment != '[]' && $producer->trade_license_attachment != '')
            <a href="{{ asset($producer->trade_license_attachment) }}" target="_blank"
                class="btn btn-outline-primary btn-xs">
                <i class="im im-icon-File-Search" data-placement="top" title="{{ __('messages.view') }}"></i>
                {{ __('messages.view') }}
            </a>
        @endif
    </td>
</tr>


<tr>
    <th  width="5%">{!! Form::label('vat_attachment', __('messages.vat_attachment') . ':') !!}</th>
    <td>
        @if(isset($producer->vat_attachment) && $producer->vat_attachment != '[]' && $producer->vat_attachment != '')
            <a href="{{ asset($producer->vat_attachment) }}" target="_blank" class="btn btn-outline-primary btn-xs">
                <i class="im im-icon-File-Search" data-placement="top" title="{{ __('messages.view') }}"></i>
                {{ __('messages.view') }}
            </a>
        @endif
    </td>
</tr>


<tr>
    <th  width="5%">{!! Form::label('tin_attachment', __('messages.tin_attachment') . ':') !!}</th>
    <td>
        @if(isset($producer->tin_attachment) && $producer->tin_attachment != '[]' && $producer->tin_attachment != '')
            <a href="{{ asset($producer->tin_attachment) }}" target="_blank" class="btn btn-outline-primary btn-xs">
                <i class="im im-icon-File-Search" data-placement="top" title="{{ __('messages.view') }}"></i>
                {{ __('messages.view') }}
            </a>
        @endif
    </td>
</tr>


<tr>
    <th  width="5%">{!! Form::label('status', __('messages.status') . ':') !!}</th>
    <td>
        @if($producer->status == 'active')
            {{ __('messages.active') }}
        @elseif($producer->status == 'inactive')
            {{ __('messages.inactive') }}
        @elseif($producer->status == 'verified')
            {{ __('messages.verified') }}
        @elseif($producer->status == 'approved')
            {{ __('messages.approved') }}
        @elseif($producer->status == 'rejected')
            {{ __('messages.rejected') }}
        @else
            {{ $producer->status }}
        @endif
    </td>
</tr>


<tr>
    <th  width="5%">{!! Form::label('created_at', __('messages.created_at') . ':') !!}</th>
    <td>{{ $producer->created_at }}</td>
</tr>


<tr>
    <th  width="5%">{!! Form::label('updated_at', __('messages.updated_at') . ':') !!}</th>
    <td>{{ $producer->updated_at }}</td>
</tr>