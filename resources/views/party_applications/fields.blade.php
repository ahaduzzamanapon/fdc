    <!-- Bank Details -->
    <fieldset class="border p-2 mb-3 col-md-12">
        <legend class="w-auto">{{ __('messages.bank_related_information') }}</legend>
        <div class="row">
            <div class="col-md-3">
                {!! Form::label('bank_name', __('messages.bank_name')) !!}
                <span class="text-danger">*</span>
                {!! Form::text('bank_name', null, ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('bank_branch', __('messages.branch')) !!}
                <span class="text-danger">*</span>
                {!! Form::text('bank_branch', null, ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('bank_account_number', __('messages.account_number')) !!}
                <span class="text-danger">*</span>
                {!! Form::text('bank_account_number', null, ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('bank_attachment', __('messages.attachment')) !!}
                <span class="text-danger">*</span>
                {!! Form::file('bank_attachment', ['class' => 'form-control', 'required']) !!}
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
                <span class="text-danger">*</span>
                {!! Form::number('vat_registration_number', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('vat_attachment', __('messages.vat_attachment')) !!}
                <span class="text-danger">*</span>
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
                {!! Form::date('trade_license_validity_date', null, ['class' => 'form-control date']) !!}
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
                <span class="text-danger">*</span>
                {!! Form::text('nominee_name', null, ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('nominee_relation', __('messages.relation')) !!}
                <span class="text-danger">*</span>
                {!! Form::text('nominee_relation', null, ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('nominee_nid', __('messages.nid')) !!}
                <span class="text-danger">*</span>
                {!! Form::text('nominee_nid', null, ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('nominee_photo', __('messages.photo')) !!}
                <span class="text-danger">*</span>
                {!! Form::file('nominee_photo', ['class' => 'form-control', 'required']) !!}
            </div>
        </div>
    </fieldset>

    <!-- Business Agreements -->
    <fieldset class="border p-2 mb-3 col-md-12">
        <legend class="w-auto">{{ __('messages.business_agreements') }}</legend>
        <div class="row">
            @foreach (['partnership', 'ltd_company', 'somobay', 'other'] as $type)
                <div class="col-md-12" style="padding: 15px;">
                    {!! Form::label("{$type}_agreement", [
                        'partnership' => __('messages.partnership_deed_copy'),
                        'ltd_company' => __('messages.limited_company_info'),
                        'somobay' => __('messages.cooperative_society_info'),
                        'other' => __('messages.others')
                    ][$type]) !!}
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('messages.name') }}</th>
                                <th>{{ __('messages.attachment') }}</th>
                                <td>
                                    <span href="#" class="btn btn-success add-row" data-type="{{ $type }}">{{ __('messages.add_new') }}</span>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    {!! Form::text("{$type}_name[]", null, ['class' => 'form-control']) !!}
                                </td>
                                <td>
                                    {!! Form::file("{$type}_attachment[]", ['class' => 'form-control']) !!}
                                </td>
                                <td>
                                    <span class="btn btn-danger remove-row">{{ __('messages.delete') }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    </fieldset>

    <script>
        document.querySelectorAll('.add-row').forEach(button => {
            button.addEventListener('click', function() {
                const type = this.getAttribute('data-type');
                const tableBody = this.closest('table').querySelector('tbody');
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td><input type="text" name="${type}_name[]" class="form-control"></td>
                    <td><input type="file" name="${type}_attachment[]" class="form-control"></td>
                    <td><span class="btn btn-danger remove-row">{{ __('messages.delete') }}</span></td>
                `;
                tableBody.appendChild(newRow);
            });
        });

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-row')) {
                event.target.closest('tr').remove();
            }
        });
    </script>

    <!-- Submit Field -->
    <div class="form-group col-sm-12" style="text-align-last: right;">
        {!! Form::submit(__('messages.save'), ['class' => 'btn btn-primary']) !!}
        <a href="{{ route('producer.dashboard') }}" class="btn btn-danger">{{ __('messages.cancel') }}</a>
    </div>
