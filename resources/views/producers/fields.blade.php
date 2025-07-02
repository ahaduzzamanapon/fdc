<!-- Organization Name Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('organization_name', 'Organization Name',['class'=>'control-label']) !!}
        {!! Form::text('organization_name', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Address Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('address', 'Address',['class'=>'control-label']) !!}
        {!! Form::text('address', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Phone Number Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('phone_number', 'Phone Number',['class'=>'control-label']) !!}
        {!! Form::text('phone_number', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Email Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('email', 'Email',['class'=>'control-label']) !!}
        {!! Form::email('email', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Bank Name Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('bank_name', 'Bank Name',['class'=>'control-label']) !!}
        {!! Form::text('bank_name', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Bank Branch Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('bank_branch', 'Bank Branch',['class'=>'control-label']) !!}
        {!! Form::text('bank_branch', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Bank Account Number Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('bank_account_number', 'Bank Account Number',['class'=>'control-label']) !!}
        {!! Form::text('bank_account_number', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Bank Attachment Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('bank_attachment', 'Bank Attachment',['class'=>'control-label']) !!}
        {!! Form::file('bank_attachment') !!}
    </div>
</div>
 <div class="clearfix"></div>


<!-- Tin Number Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('tin_number', 'Tin Number',['class'=>'control-label']) !!}
        {!! Form::text('tin_number', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Trade License Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('trade_license', 'Trade License',['class'=>'control-label']) !!}
        {!! Form::text('trade_license', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Vat Registration Number Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('vat_registration_number', 'Vat Registration Number',['class'=>'control-label']) !!}
        {!! Form::number('vat_registration_number', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Nominee Name Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('nominee_name', 'Nominee Name',['class'=>'control-label']) !!}
        {!! Form::text('nominee_name', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Nominee Relation Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('nominee_relation', 'Nominee Relation',['class'=>'control-label']) !!}
        {!! Form::text('nominee_relation', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Nominee Nid Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('nominee_nid', 'Nominee Nid',['class'=>'control-label']) !!}
        {!! Form::text('nominee_nid', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Nominee Photo Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('nominee_photo', 'Nominee Photo',['class'=>'control-label']) !!}
        {!! Form::file('nominee_photo') !!}
    </div>
</div>
 <div class="clearfix"></div>


<!-- Partnership Agreement Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('partnership_agreement', 'Partnership Agreement',['class'=>'control-label']) !!}
        {!! Form::file('partnership_agreement') !!}
    </div>
</div>
 <div class="clearfix"></div>


<!-- Ltd Company Agreement Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('ltd_company_agreement', 'Ltd Company Agreement',['class'=>'control-label']) !!}
        {!! Form::file('ltd_company_agreement') !!}
    </div>
</div>
 <div class="clearfix"></div>


<!-- Somobay Agreement Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('somobay_agreement', 'Somobay Agreement',['class'=>'control-label']) !!}
        {!! Form::file('somobay_agreement') !!}
    </div>
</div>
 <div class="clearfix"></div>


<!-- Other Attachment Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('other_attachment', 'Other Attachment',['class'=>'control-label']) !!}
        {!! Form::file('other_attachment') !!}
    </div>
</div>
 <div class="clearfix"></div>


<!-- Trade License Validity Date Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('trade_license_validity_date', 'Trade License Validity Date',['class'=>'control-label']) !!}
        {!! Form::text('trade_license_validity_date', null, ['class' => 'form-control','id'=>'trade_license_validity_date']) !!}
    </div>
</div>
@section('footer_scripts')
<script type="text/javascript">
    $('#trade_license_validity_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
</script>
@endsection


<!-- Trade License Attachment Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('trade_license_attachment', 'Trade License Attachment',['class'=>'control-label']) !!}
        {!! Form::file('trade_license_attachment') !!}
    </div>
</div>
 <div class="clearfix"></div>


<!-- Vat Attachment Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('vat_attachment', 'Vat Attachment',['class'=>'control-label']) !!}
        {!! Form::file('vat_attachment') !!}
    </div>
</div>
 <div class="clearfix"></div>


<!-- Tin Attachment Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('tin_attachment', 'Tin Attachment',['class'=>'control-label']) !!}
        {!! Form::file('tin_attachment') !!}
    </div>
</div>
 <div class="clearfix"></div>


<!-- Status Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('status', 'Status',['class'=>'control-label']) !!}
        {!! Form::select('status', ['Active' => 'Active', 'Inactive' => 'Inactive'], null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12" style="text-align-last: right;">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('producers.index') }}" class="btn btn-danger">Cancel</a>
</div>
