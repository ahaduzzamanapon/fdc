<tr>
    <th scope="row">{!! Form::label('id', __('messages.id') . ':') !!}</th>
    <td>{{ $users->username }}</td>
</tr>

<tr>
    <th scope="row">{!! Form::label('name_bn', __('messages.name_bengali') . ':') !!}</th>
    <td>{{ $users->name_bn }}</td>
</tr>

<tr>
    <th scope="row">{!! Form::label('name_en', __('messages.name_english') . ':') !!}</th>
    <td>{{ $users->name_en }}</td>
</tr>

<tr>
    <th scope="row">{!! Form::label('email', __('messages.email_label') . ':') !!}</th>
    <td>{{ $users->email }}</td>
</tr>

<tr>
    <th scope="row">{!! Form::label('phone_number', __('messages.phone_number') . ':') !!}</th>
    <td>{{ $users->mobile_no }}</td>
</tr>

<tr>
    <th scope="row">{!! Form::label('date_of_birth', __('messages.date_of_birth_label') . ':') !!}</th>
    <td>{{ $users->dob }}</td>
</tr>

<tr>
    <th scope="row">{!! Form::label('gender', __('messages.gender') . ':') !!}</th>
    <td>{{ $users->gender }}</td>
</tr>

<tr>
    <th scope="row">{!! Form::label('religion', __('messages.religion') . ':') !!}</th>
    <td>{{ $users->religion }}</td>
</tr>

<tr>
    <th scope="row">{!! Form::label('blood_group', __('messages.blood_group') . ':') !!}</th>
    <td>{{ $users->blood_group }}</td>
</tr>

<tr>
    <th scope="row">{!! Form::label('marital_status', __('messages.marital_status') . ':') !!}</th>
    <td>{{ $users->marital_status }}</td>
</tr>

<tr>
    <th scope="row">{!! Form::label('father_name', __('messages.father_name') . ':') !!}</th>
    <td>{{ $users->father_name }}</td>
</tr>

<tr>
    <th scope="row">{!! Form::label('mother_name', __('messages.mother_name') . ':') !!}</th>
    <td>{{ $users->mother_name }}</td>
</tr>

<tr>
    <th scope="row">{!! Form::label('nid', __('messages.nid') . ':') !!}</th>
    <td>{{ $users->nid }}</td>
</tr>

<tr>
    <th scope="row">{!! Form::label('highest_qualification', __('messages.highest_educational_qualification') . ':') !!}</th>
    <td>{{ $users->highest_qualification }}</td>
</tr>

<tr>
    <th scope="row">{!! Form::label('freedom_fighter', __('messages.freedom_fighter') . ':') !!}</th>
    <td>{{ $users->freedom_fighter ?? '-' }}</td>
</tr>

<tr>
    <th scope="row">{!! Form::label('address', __('messages.permanent_address') . ':') !!}</th>
    <td>
        @php
            $permParts = array_filter([
                $users->village,
                optional($users->upazila)->name_bn ?? optional($users->upazila)->name,
                optional($users->district)->name_bn ?? optional($users->district)->name_en,
                optional($users->division)->name_bn ?? optional($users->division)->name_en,
            ]);
        @endphp
        {{ implode(', ', $permParts) ?: '-' }}
    </td>
</tr>

<tr>
    <th scope="row">{!! Form::label('present_address', __('messages.present_address') . ':') !!}</th>
    <td>
        @php
            $presParts = array_filter([
                $users->present_village,
                optional($users->presentUpazila)->name_bn ?? optional($users->presentUpazila)->name,
                optional($users->presentDistrict)->name_bn ?? optional($users->presentDistrict)->name_en,
                optional($users->presentDivision)->name_bn ?? optional($users->presentDivision)->name_en,
            ]);
        @endphp
        {{ implode(', ', $presParts) ?: '-' }}
    </td>
</tr>

<tr>
    <th scope="row">{!! Form::label('employee_type', __('messages.employee_type') . ':') !!}</th>
    <td>{{ $users->employee_type }}</td>
</tr>

<tr>
    <th scope="row">{!! Form::label('date_of_join', __('messages.date_of_join_label') . ':') !!}</th>
    <td>{{ $users->join_date }}</td>
</tr>

<tr>
    <th scope="row">{!! Form::label('department', __('messages.department') . ':') !!}</th>
    <td>{{ optional($users->departmentInfo)->name_bn ?? $users->department }}</td>
</tr>

<tr>
    <th scope="row">{!! Form::label('designation', __('messages.designation') . ':') !!}</th>
    <td>{{ optional($users->designationInfo)->desi_name ?? $users->designation }}</td>
</tr>

<tr>
    <th scope="row">{!! Form::label('staff_class', __('messages.officer_class') . ':') !!}</th>
    <td>
        @php
            $classes = [
                '1' => __('messages.class_a'),
                '2' => __('messages.class_b'),
                '3' => __('messages.class_c'),
                '4' => __('messages.class_d'),
            ];
        @endphp
        {{ $classes[$users->staff_class] ?? $users->staff_class ?? '-' }}
    </td>
</tr>

<tr>
    <th scope="row">{!! Form::label('grade', __('messages.grade') . ':') !!}</th>
    <td>{{ $users->grade }}</td>
</tr>

<tr>
    <th scope="row">{!! Form::label('basic_salary', __('messages.basic_salary') . ':') !!}</th>
    <td>{{ $users->basic_salary }}</td>
</tr>

<tr>
    <th scope="row">{!! Form::label('current_status', __('messages.current_status') . ':') !!}</th>
    <td>
        @if($users->current_status == 'Active')
            <span class="badge badge-success">{{ __('messages.active') }}</span>
        @else
            <span class="badge badge-danger">{{ __('messages.inactive') }}</span>
        @endif
    </td>
</tr>

<tr>
    <th scope="row">{!! Form::label('group_id', __('messages.user_role') . ':') !!}</th>
    <td>{{ optional($users->role)->name ?? $users->group_id }}</td>
</tr>

<tr>
    <th scope="row">{!! Form::label('image', __('messages.picture') . ':') !!}</th>
    <td>
        @php
            $showPic = '';
            if ($users->picture && $users->picture !== 'no-image.png') {
                $showPic = \Illuminate\Support\Str::startsWith($users->picture, 'picture/user/') ? asset($users->picture) : asset('picture/user/' . $users->picture);
            }
        @endphp
        @if($showPic)
            <img src="{{ $showPic }}" style="width: 90px; height: 90px; border-radius: 50%; object-fit: cover; border: 2px solid #ddd;" alt="{{ $users->name_bn }}">
        @else
            <span>-</span>
        @endif
    </td>
</tr>

<tr>
    <th scope="row">{!! Form::label('signature', __('messages.signature') . ':') !!}</th>
    <td>
        @php
            $showSig = '';
            if ($users->signature && $users->signature !== 'no-image.png') {
                $showSig = \Illuminate\Support\Str::startsWith($users->signature, 'images/signature/') ? asset($users->signature) : asset('images/signature/' . $users->signature);
            }
        @endphp
        @if($showSig)
            <img src="{{ $showSig }}" style="max-height: 50px; max-width: 150px; border: 1px solid #ddd; padding: 2px;" alt="Signature">
        @else
            <span>-</span>
        @endif
    </td>
</tr>