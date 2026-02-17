<div class="table-responsive">
    <table class="table table_data" id="designations-table">
        <thead>
            <tr>
                <th>{{ __('messages.id') }}</th>
        <th>{{ __('messages.name') }}</th>
        <th>{{ __('messages.status') }}</th>

                <th>{{ __('messages.action') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($designations as $key => $designation)
            <tr>
                <td>{{ $designation->id }}</td>
            <td>{{ $designation->desi_name }}</td>
            <td>{{ $designation->desi_status }}</td>

                <td>
                    <div class='btn-group'>
                        <a href="{{ route('designations.show', [$designation->id]) }}" class='btn btn-outline-primary btn-xs'><i class="im im-icon-Eye" data-placement="top" title="{{ __('messages.view') }}"></i></a>
                        <a href="{{ route('designations.edit', [$designation->id]) }}" class='btn btn-outline-primary btn-xs'><i
                            class="im im-icon-Pen"  data-toggle="tooltip" data-placement="top" title="{{ __('messages.edit') }}"></i></a>
                        @if(can('delete_option'))
                            {!! Form::open(['route' => ['designations.destroy', $designation->id], 'method' => 'delete']) !!}
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
