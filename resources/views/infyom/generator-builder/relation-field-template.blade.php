<td style="vertical-align: middle">
    <select class="form-control drdRelationType" style="width: 100%">
        <option value="1t1">{{ __('messages.one_to_one') }}</option>
        <option value="1tm">{{ __('messages.one_to_many') }}</option>
        <option value="mt1">{{ __('messages.many_to_one') }}</option>
        <option value="mtm">{{ __('messages.many_to_many') }}</option>
    </select>

    <input type="text" class="form-control foreignTable txtForeignTable" style="display: none"
        placeholder="{{ __('messages.custom_table_name') }}" />
</td>
<td style="vertical-align: middle">
    <input type="text" required class="form-control txtForeignModel" />
</td>
<td style="vertical-align: middle">
    <input type="text" style="width: 100%" class="form-control txtForeignKey" />
</td>
<td style="vertical-align: middle">
    <input type="text" class="form-control txtLocalKey" />
</td>
<td style="text-align: center;vertical-align: middle">
    <i onclick="removeItem(this)" class="{{ __('messages.remove') }} far fa-trash-alt text-danger btn"></i>
</td>
