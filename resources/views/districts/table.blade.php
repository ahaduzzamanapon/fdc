<div class="table-responsive">
    <table class="table table_data" id="districts-table">
        <thead>
            <tr>
                <th>{{ __('messages.id') }}</th>
        <th>{{ __('messages.name_bn') }}</th>
        <th>{{ __('messages.name_en') }}</th>
     
                <th>{{ __('messages.action') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($districts as $key => $district)
            <tr>
                <td>{{ $district->id }}</td>
            <td>{{ $district->name_bn }}</td>
            <td>{{ $district->name_en }}</td>
         
                <td>
                    {!! Form::open(['route' => ['districts.destroy', $district->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('districts.show', [$district->id]) }}" class='btn btn-outline-primary btn-xs'><i class="im im-icon-Eye" data-placement="top" title="{{ __('messages.view') }}"></i></a>
                        <a href="{{ route('districts.edit', [$district->id]) }}" class='btn btn-outline-primary btn-xs'><i
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
