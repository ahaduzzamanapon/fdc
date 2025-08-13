<div class="table-responsive">
    <table class="table table_data" id="producers-table">
        <thead>
            <tr>
                <th>{{ __('messages.sl_label') }}</th>
        <th>{{ __('messages.organization_name') }}</th>
        <th>{{ __('messages.phone_number') }}</th>
        <th>{{ __('messages.email') }}</th>
        <th>{{ __('messages.status') }}</th>
                <th>{{ __('messages.action') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($producers as $key => $producer)
            <tr>
                <td>{{ $producer->id }}</td>
            <td>{{ $producer->organization_name }}</td>
           
            <td>{{ $producer->phone_number }}</td>
            <td>{{ $producer->email }}</td>
           
            <td>{{ $producer->status }}</td>
                <td>
                    {!! Form::open(['route' => ['producers.destroy', $producer->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('producers.show', [$producer->id]) }}" class='btn btn-outline-primary btn-xs'><i class="im im-icon-Eye" data-placement="top" title="{{ __('messages.view') }}"></i></a>
                        <a href="{{ route('producers.edit', [$producer->id]) }}" class='btn btn-outline-primary btn-xs'><i
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
