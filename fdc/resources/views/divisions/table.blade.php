<div class="table-responsive">
    <table class="table" id="divisions-table">
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
        @foreach($divisions as $key => $division)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $division->name_bn }}</td>
                <td>{{ $division->name_en }}</td>
                <td>{{ $division->status }}</td>
                <td>
                    {!! Form::open(['route' => ['divisions.destroy', $division->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('divisions.show', [$division->id]) }}" class='btn btn-outline-primary btn-xs'><i class="im im-icon-Eye" data-placement="top" title="{{ __('messages.view') }}"></i></a>
                        <a href="{{ route('divisions.edit', [$division->id]) }}" class='btn btn-outline-primary btn-xs'><i
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
