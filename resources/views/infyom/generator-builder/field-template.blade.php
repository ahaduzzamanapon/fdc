<td style="vertical-align: middle">
    <input type="text" style="width: 100%" required class="form-control txtFieldName" />
    <input type="text" class="form-control foreignTable txtForeignTable" style="display: none"
        placeholder="Foreign table,Primary key" />
    <div class="invalid-feedback"></div>
</td>
<td style="vertical-align: middle">
    <select class="form-control txtdbType" style="width: 100%">
        <option value="integer">{{ __('messages.integer') }}</option>
        <option value="smallInteger">{{ __('messages.small_integer') }}</option>
        <option value="longText">{{ __('messages.long_text') }}</option>
        <option value="bigInteger">{{ __('messages.big_integer') }}</option>
        <option value="double">{{ __('messages.double') }}</option>
        <option value="float">{{ __('messages.float') }}</option>
        <option value="decimal">{{ __('messages.decimal') }}</option>
        <option value="boolean">{{ __('messages.boolean') }}</option>
        <option value="string" selected>{{ __('messages.string') }}</option>
        <option value="char">{{ __('messages.char') }}</option>
        <option value="text">{{ __('messages.text') }}</option>
        <option value="mediumText">{{ __('messages.medium_text') }}</option>
        <option value="longText">{{ __('messages.long_text') }}</option>
        <option value="enum">{{ __('messages.enum') }}</option>
        <option value="binary">{{ __('messages.binary') }}</option>
        <option value="dateTime">{{ __('messages.date_time') }}</option>
        <option value="date">{{ __('messages.date') }}</option>
        <option value="timestamp">{{ __('messages.timestamp') }}</option>
    </select>

    <input type="text" class="form-control dbValue txtDbValue" style="display: none" placeholder="" />
</td>
<td style="vertical-align: middle">
    <input type="text" class="form-control txtValidation" />
</td>
<td style="vertical-align: middle">
    <select class="form-control drdHtmlType" style="width: 100%">
        <option value="text">{{ __('messages.text') }}</option>
        <option value="email">{{ __('messages.email_type') }}</option>
        <option value="number">{{ __('messages.number_type') }}</option>
        <option value="date">{{ __('messages.date') }}</option>
        <option value="file">{{ __('messages.file_type') }}</option>
        <option value="password">{{ __('messages.password_type') }}</option>
        <option value="select">{{ __('messages.select_type') }}</option>
        <option value="radio">{{ __('messages.radio_type') }}</option>
        <option value="checkbox">{{ __('messages.checkbox_type') }}</option>
        <option value="textarea">{{ __('messages.textarea_type') }}</option>
        <option value="toggle-switch">{{ __('messages.toggle_type') }}</option>
    </select>
    <input type="text" class="form-control htmlValue txtHtmlValue" style="display: none" placeholder="" />
</td>
<td style="vertical-align: middle">
    <div class="checkbox">
        <label>
            <input type="checkbox" class="flat-red chkPrimary" />
            Primary {{ __('messages.primary') }}
        </label>
    </div>

    <div class="checkbox">
        <label>
            <input type="checkbox" class="flat-red chkForeign" />
            Is Foreign {{ __('messages.is_foreign') }}
        </label>
    </div>

    <div class="checkbox">
        <label>
            <input type="checkbox" class="flat-red chkSearchable" checked />
            Searchable {{ __('messages.searchable') }}
        </label>
    </div>

    <div class="checkbox">
        <label>
            <input type="checkbox" class="flat-red chkFillable" checked />
            Fillable {{ __('messages.fillable') }}
        </label>
    </div>

    <div class="checkbox">
        <label>
            <input type="checkbox" class="flat-red chkInForm" checked />
            In Form {{ __('messages.in_form') }}
        </label>
    </div>

    <div class="checkbox">
        <label>
            <input type="checkbox" class="flat-red chkInIndex" checked />
            In Index {{ __('messages.in_index') }}
        </label>
    </div>
</td>
<td style="text-align: center;vertical-align: middle">
    <i onclick="removeItem(this)" class="{{ __('messages.remove') }} far fa-trash-alt text-danger btn"></i>
</td>
