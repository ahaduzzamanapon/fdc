




<div class="table-responsive">
    <table class="table table_data" id="users-table">
        <thead>
            <tr>
                <th>{{ __('messages.sl_label') }}</th>
                <th>{{ __('messages.name') }}</th>
                <th>{{ __('messages.username') }}</th>
                <th>{{ __('messages.group') }}</th>
                <th>{{ __('messages.email') }}</th>
                <th>{{ __('messages.status') }}</th>
                <th>{{ __('messages.action') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $key => $users)
            <tr>
                <td>{{ $key+1 }}</td>
            <td>{{ $users->name_bn }}</td>
            <td>{{ $users->mobile_no }}</td>
            <td>{{ $users->role }}</td>
            <td>{{ $users->email }}</td>
            <td>
                @if($users->current_status == 'Active')
                    <span class="badge badge-success">{{ __('messages.active') }}</span>
                @else
                    <span class="badge badge-danger">{{ __('messages.inactive') }}</span>
                @endif
            </td>
                <td>
                    <div class='btn-group'>
                        <a href="{{ route('users.show', [$users->id]) }}" class='btn btn-outline-primary btn-xs'><i class="im im-icon-Eye" data-placement="top" title="{{ __('messages.view') }}"></i></a>
                        <a href="{{ route('users.edit', [$users->id]) }}" class='btn btn-outline-primary btn-xs'><i
                            class="im im-icon-Pen"  data-toggle="tooltip" data-placement="top" title="{{ __('messages.edit') }}"></i></a>
                        @if(can('user_delete'))
                            {!! Form::open(['route' => ['users.destroy', $users->id], 'method' => 'delete']) !!}
                        {!! Form::button('<i class="im im-icon-Remove" data-toggle="tooltip" data-placement="top" title="' . __('messages.delete') . '"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-xs', 'onclick' => "return confirm('" . __('messages.are_you_sure') . "')"]) !!}
                            {!! Form::close() !!}
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
