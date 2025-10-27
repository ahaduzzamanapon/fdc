<div class="table-responsive">
    <table class="table" id="permissions-table">
        <thead>
            <tr>
                <th>{{ __('messages.id') }}</th>
        <th>{{ __('messages.name') }}</th>
        <th>{{ __('messages.key') }}</th>
        <th>{{ __('messages.cat_id') }}</th>
        <th>{{ __('messages.created_at') }}</th>
        <th>{{ __('messages.updated_at') }}</th>
                <th>{{ __('messages.action') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($permissions as $key => $permission)
            <tr>
                <td>{{ $permission->id }}</td>
            <td>{{ $permission->name }}</td>
            <td>{{ $permission->key }}</td>
            <td>{{ $permission->cat_id }}</td>
            <td>{{ $permission->created_at }}</td>
            <td>{{ $permission->updated_at }}</td>
                <td>
                    {!! Form::open(['route' => ['permissions.destroy', $permission->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('permissions.show', [$permission->id]) }}" class='btn btn-outline-primary btn-xs'><i class="im im-icon-Eye" data-placement="top" title="{{ __('messages.view') }}"></i></a>
                        <a href="{{ route('permissions.edit', [$permission->id]) }}" class='btn btn-outline-primary btn-xs'><i
                                class="im im-icon-Pen"  data-toggle="tooltip" data-placement="top" title="{{ __('messages.edit') }}"></i></a>
                        {!! Form::button('<i class="im im-icon-Remove" data-toggle="tooltip" data-placement="top" title="' . __('messages.delete') . '"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-xs', 'onclick' => "return confirm('" . __('messages.are_you_sure') . "')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
