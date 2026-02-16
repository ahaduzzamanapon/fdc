<tr>
    <th scopre="row">{!! Form::label('id', __('messages.id').':') !!}</th>
    <td>{{ $users->emp_id }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('name', __('messages.first_name').':') !!}</th>
    <td>{{ $users->name }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('last_name', __('messages.last_name').':') !!}</th>
    <td>{{ $users->last_name }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('email', __('messages.email').':') !!}</th>
    <td>{{ $users->email }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('date_of_birth', __('messages.date_of_birth_label').':') !!}</th>
    <td>{{ $users->date_of_birth }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('date_of_join', __('messages.date_of_join_label').':') !!}</th>
    <td>{{ $users->date_of_join }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('gender', __('messages.gender').':') !!}</th>
    <td>{{ $users->gender }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('address', __('messages.address').':') !!}</th>
    <td>{{ $users->address }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('phone_number', __('messages.phone_number').':') !!}</th>
    <td>{{ $users->phone_number }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('image', __('messages.image').':') !!}</th>
    <td><img src="{{ asset($users->image) }}" style="width: 100px; height: 100px; border-radius: 50%;" alt=""></td>
</tr>



<tr>
    <th scopre="row">{!! Form::label('group_id', __('messages.group_id').':') !!}</th>
    <td>{{ $users->group_id }}</td>
</tr>




<tr>
    <th scopre="row">{!! Form::label('blood_group', __('messages.blood_group').':') !!}</th>
    <td>{{ $users->blood_group }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('religion', __('messages.religion').':') !!}</th>
    <td>{{ $users->religion }}</td>
</tr>


<tr>
    <th scopre="row">{!! Form::label('marital_status', __('messages.marital_status').':') !!}</th>
    <td>{{ $users->marital_status }}</td>
</tr>



