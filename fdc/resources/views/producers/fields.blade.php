
<style>
   
</style>





  <!-- Organization Info -->
                    <fieldset class="border p-2 mb-3 col-md-12">
                        <legend class="w-auto">{{ __('messages.organization_information') }}</legend>
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('organization_name', __('messages.organization_name')) !!}
                                {!! Form::text('organization_name', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('address', __('messages.address')) !!}
                                {!! Form::text('address', null, ['class' => 'form-control']) !!} 
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('phone_number', __('messages.phone_number')) !!}
                                {!! Form::text('phone_number', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('email', __('messages.email')) !!}
                                {!! Form::email('email', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('password', __('messages.password_label')) !!}
                                {!! Form::password('password', null, ['required','style="border: 1px solid #8dc641;border-radius: 4px;padding: 4px;"']) !!}
                            </div>
                        </div>
                    </fieldset>

                    <!-- Bank Details -->
                    <fieldset class="border p-2 mb-3 col-md-12">
                        <legend class="w-auto">{{ __('messages.bank_related_information') }}</legend>
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('bank_name', __('messages.bank_name')) !!}
                                {!! Form::text('bank_name', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('bank_branch', __('messages.branch')) !!}
                                {!! Form::text('bank_branch', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('bank_account_number', __('messages.account_number')) !!}
                                {!! Form::text('bank_account_number', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('bank_attachment', __('messages.attachment')) !!}
                                {!! Form::file('bank_attachment', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </fieldset>

                    <!-- Tax Info -->
                    <fieldset class="border p-2 mb-3 col-md-12">
                        <legend class="w-auto">{{ __('messages.tax_related_information') }}</legend>
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('tin_number', __('messages.tin_number')) !!}
                                {!! Form::text('tin_number', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('tin_attachment', __('messages.tin_attachment')) !!}
                                {!! Form::file('tin_attachment', ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('vat_registration_number', __('messages.vat_registration_number')) !!}
                                {!! Form::number('vat_registration_number', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('vat_attachment', __('messages.vat_attachment')) !!}
                                {!! Form::file('vat_attachment', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </fieldset>

                    <!-- Trade License -->
                    <fieldset class="border p-2 mb-3 col-md-12">
                        <legend class="w-auto">{{ __('messages.trade_license') }}</legend>
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('trade_license', __('messages.trade_license_number')) !!}
                                {!! Form::text('trade_license', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('trade_license_validity_date', __('messages.validity_date')) !!}
                                {!! Form::date('trade_license_validity_date', isset($producer->trade_license_validity_date) ? date('Y-m-d', strtotime($producer->trade_license_validity_date)) : null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('trade_license_attachment', __('messages.attachment')) !!}
                                {!! Form::file('trade_license_attachment', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </fieldset>

                    <!-- Nominee Info -->
                    <fieldset class="border p-2 mb-3 col-md-12">
                        <legend class="w-auto">{{ __('messages.nominee_information') }}</legend>
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('nominee_name', __('messages.name')) !!}
                                {!! Form::text('nominee_name', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('nominee_relation', __('messages.relation')) !!}
                                {!! Form::text('nominee_relation', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('nominee_nid', __('messages.nid')) !!}
                                {!! Form::text('nominee_nid', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('nominee_photo', __('messages.photo')) !!}
                                {!! Form::file('nominee_photo', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </fieldset>

                    <!-- Business Agreements -->
                    <fieldset class="border p-2 mb-3 col-md-12">
                        <legend class="w-auto">{{ __('messages.business_agreements') }}</legend>
                        <div class="row">
                            <div class="col-md-12" style="padding: 15px;">
                                {!! Form::label('partnership_agreement', __('messages.partnership_deed_copy')) !!}
                                <br>
                                {!! Form::file('partnership_agreement') !!}
                            </div>
                            
                            <div class="col-md-12" style="padding: 15px;">
                                {!! Form::label('ltd_company_agreement', __('messages.limited_company_info')) !!}
                                {!! Form::file('ltd_company_agreement') !!}
                            </div>
                            <div class="col-md-12" style="padding: 15px;">
                                {!! Form::label('somobay_agreement', __('messages.cooperative_society_info')) !!}

                                {!! Form::file('somobay_agreement') !!}
                            </div>
                            <div class="col-md-12" style="padding: 15px;">
                                {!! Form::label('other_attachment', __('messages.others')) !!}
                                                                <br>

                                {!! Form::file('other_attachment') !!}
                            </div>
                        </div>
                    </fieldset>

<!-- Status Field -->
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('status', __('messages.status'),['class'=>'control-label']) !!}
        {!! Form::select('status', [__('messages.active') => __('messages.active'), __('messages.inactive') => __('messages.inactive')], null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12" style="text-align-last: right;">
    {!! Form::submit(__('messages.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('producers.index') }}" class="btn btn-danger">{{ __('messages.cancel') }}</a>
</div>
