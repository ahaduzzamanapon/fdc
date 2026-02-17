<div class="table-responsive">
    <table class="table table_data" id="shifts-table">
        <thead>
            <tr>
                <th>SL</th>
        <th>Name</th>
        <th>Category</th>
        <th>Item</th>
        <th>Start Time</th>
        <th>End Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($shifts as $key => $shift)
            <tr>
                <td>{{ $key+1 }}</td>
            <td>{{ $shift->name }}</td>
            <td>{{ $shift->category_name_bn }}</td>
            <td>{{ $shift->item_name_bn }}</td>
            <td>{{ $shift->start_time }}</td>
            <td>{{ $shift->end_time }}</td>
                <td>
                    {!! Form::open(['route' => ['shifts.destroy', $shift->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('shifts.show', [$shift->id]) }}" class='btn btn-outline-primary btn-xs'><i class="im im-icon-Eye" data-placement="top" title="View"></i></a>
                        <a href="{{ route('shifts.edit', [$shift->id]) }}" class='btn btn-outline-primary btn-xs'><i
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
