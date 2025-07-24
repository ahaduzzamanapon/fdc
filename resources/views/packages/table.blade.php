<div class="table-responsive">
    <table class="table" id="packages-table table_data">
        <thead>
            <tr>
                <th>SL</th>
        <th>Name</th>
        <th>Amount</th>
        <th>Type</th>
        <th>Status</th>
        <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($packages as $key => $package)
            <tr>
                <td>{{ $package->id }}</td>
            <td>{{ $package->name }}</td>
            <td>{{ $package->amount }}</td>
            <td>{{ $package->type }}</td>
            <td>{{ $package->status }}</td>
            <td>{{ $package->description }}</td>
                <td>
                    {!! Form::open(['route' => ['packages.destroy', $package->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('packages.show', [$package->id]) }}" class='btn btn-outline-primary btn-xs'><i class="im im-icon-Eye" data-placement="top" title="View"></i></a>
                        <a href="{{ route('packages.edit', [$package->id]) }}" class='btn btn-outline-primary btn-xs'><i
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
