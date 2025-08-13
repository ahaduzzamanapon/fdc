<div class="table-responsive">
    <table class="table table_data" id="departments-table">
        <thead>
            <tr>
                <th>{{ __('messages.sl') }}</th>
                <th>{{ __('messages.name_bn') }}</th>
                <th>{{ __('messages.name_en') }}</th>
                <th>{{ __('messages.status') }}</th>
                <th>{{ __('messages.action') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($departments as $key => $department)
            <tr>
                <td>{{ ++$key }}</td>
            <td>{{ $department->name_bn }}</td>
            <td>{{ $department->name_en }}</td>
            <td>{{ $department->status }}</td>
                <td>
                    {!! Form::open(['route' => ['departments.destroy', $department->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('departments.show', [$department->id]) }}" class='btn btn-outline-primary btn-xs'><i class="im im-icon-Eye" data-placement="top" title="{{ __('messages.view') }}"></i></a>
                        <a href="{{ route('departments.edit', [$department->id]) }}" class='btn btn-outline-primary btn-xs'><i
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
