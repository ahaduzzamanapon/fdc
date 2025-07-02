<div class="table-responsive">
    <table class="table table_data" id="producers-table">
        <thead>
            <tr>
                <th>SL</th>
        <th>Organization Name</th>
        <th>Phone Number</th>
        <th>Email</th>
        <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($producers as $key => $producer)
            <tr>
                <td>{{ $producer->id }}</td>
            <td>{{ $producer->organization_name }}</td>
            <td>{{ $producer->address }}</td>
            <td>{{ $producer->phone_number }}</td>
            <td>{{ $producer->email }}</td>
           
            <td>{{ $producer->status }}</td>
                <td>
                    {!! Form::open(['route' => ['producers.destroy', $producer->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('producers.show', [$producer->id]) }}" class='btn btn-outline-primary btn-xs'><i class="im im-icon-Eye" data-placement="top" title="View"></i></a>
                        <a href="{{ route('producers.edit', [$producer->id]) }}" class='btn btn-outline-primary btn-xs'><i
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
