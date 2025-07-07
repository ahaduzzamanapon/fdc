<div class="table-responsive">
    <table class="table" id="items-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Category</th>
                <th>Unit</th>
                <th>Duration</th>
                <th>Max Times</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($items as $key => $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name_bn }}</td>
                <td>{{ $item->cat_id }}</td>
                <td>{{ $item->unit_id }}</td>
                <td>{{ $item->duration }}</td>
                <td>{{ $item->max_times }}</td>
                <td>{{ $item->amount }}</td>
                <td>{{ $item->description }}</td>
                <td>
                    {!! Form::open(['route' => ['items.destroy', $item->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('items.show', [$item->id]) }}" class='btn btn-outline-primary btn-xs'><i class="im im-icon-Eye" data-placement="top" title="View"></i></a>
                        <a href="{{ route('items.edit', [$item->id]) }}" class='btn btn-outline-primary btn-xs'><i
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
