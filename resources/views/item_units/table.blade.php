<div class="table-responsive">
    <table class="table" id="itemUnits-table">
        <thead>
            <tr>
                <th>Id</th>
        <th>Name Bn</th>
        <th>Name En</th>
        <th>Status</th>
        <th>Created At</th>
        <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($itemUnits as $key => $itemUnit)
            <tr>
                <td>{{ $itemUnit->id }}</td>
            <td>{{ $itemUnit->name_bn }}</td>
            <td>{{ $itemUnit->name_en }}</td>
            <td>{{ $itemUnit->status }}</td>
            <td>{{ $itemUnit->created_at }}</td>
            <td>{{ $itemUnit->updated_at }}</td>
                <td>
                    {!! Form::open(['route' => ['itemUnits.destroy', $itemUnit->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('itemUnits.show', [$itemUnit->id]) }}" class='btn btn-outline-primary btn-xs'><i class="im im-icon-Eye" data-placement="top" title="View"></i></a>
                        <a href="{{ route('itemUnits.edit', [$itemUnit->id]) }}" class='btn btn-outline-primary btn-xs'><i
                                class="im im-icon-Pen"  data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                        {!! Form::button('<i class="im im-icon-Remove" data-toggle="tooltip" data-placement="top" title="Delete"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
